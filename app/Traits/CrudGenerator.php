<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

trait CrudGenerator
{
    protected function createCrud($className, $field = null, $createNoView = false)
    {
        $this->makeController($className);
        $this->makeModel($className);
        $this->makeRequest($className);
        $this->makeRoute($className);
        $this->makeMigration($className, $field);
        if ($createNoView == false) {
            $this->makeView($className, $field);
        }
    }

    private function getStub($type)
    {
        return file_get_contents(resource_path("stubs/$type.stub"));
    }

    private function getViewStub($type)
    {
        return file_get_contents(resource_path("stubs/views/$type.blade.stub"));
    }

    private function makeController($className)
    {
        $controllerTemplate = str_replace(
            [
                '{modelName}',
                '{modelNamePluralLowerCase}',
                '{modelNameSingularLowerCase}',
                '{viewName}',
                '{routeName}'
            ],
            [
                $className,
                Str::lower(Str::plural($className)),
                Str::lower($className),
                Str::plural(Str::lower(Str::snake($className))),
                Str::lower(Str::snake($className))
            ],
            $this->getStub('Controller')
        );

        file_put_contents(app_path("/Http/Controllers/{$className}Controller.php"), $controllerTemplate);
    }

    private function makeModel($className)
    {
        $modelTemplate = str_replace(
            [
                '{modelName}',
                '{modelNamePluralLowerCase}'
            ],
            [
                $className,
                Str::plural(Str::lower(Str::snake($className))),
            ],
            $this->getStub('Model')
        );

        file_put_contents(app_path("/Models/{$className}.php"), $modelTemplate);
    }

    private function makeRequest($className)
    {
        $requestTemplate = str_replace(
            ['{modelName}'],
            [$className],
            $this->getStub('Request')
        );

        if(!file_exists($path = app_path('/Http/Requests')))
            mkdir($path, 0777, true);

        file_put_contents(app_path("/Http/Requests/{$className}Request.php"), $requestTemplate);
    }

    private function makeRoute($className)
    {
        $routes = base_path('routes/web.php');
        $data = array_slice(file($routes), 0);

        foreach ($data as $line) {
            if (Str::contains($line, "Route::middleware(['installed'])->group( function () {")) {
                $previousLine = $line;
            }
        }

        $nextLine = "Route::name('" . Str::lower(Str::snake($className)) . ".')->prefix('". Str::lower(Str::snake($className)) ."')->group( function () {". PHP_EOL .
            "\t\t" .'Route::get(\'' . "', '{$className}Controller@index')->name('index');" . PHP_EOL .
            "\t\t" .'Route::get(\'datatables' . "', '{$className}Controller@dataTables')->name('datatables');" . PHP_EOL .
            "\t\t" .'Route::get(\'create' . "', '{$className}Controller@create')->name('create');" . PHP_EOL .
            "\t\t" .'Route::get(\'store' . "', '{$className}Controller@store')->name('store');" . PHP_EOL .
            "\t\t" .'Route::get(\'edit/{id}' . "', '{$className}Controller@edit')->name('edit');" . PHP_EOL .
            "\t\t" .'Route::get(\'update/{id}' . "', '{$className}Controller@update')->name('update');" . PHP_EOL .
            "\t\t" .'Route::get(\'delete/{id}' . "', '{$className}Controller@delete')->name('delete');" . PHP_EOL .
            "\t ". "});";

        $newLine = $previousLine . "\t" . $nextLine . PHP_EOL;
        $newRoutes = str_replace(strip_tags($previousLine), strip_tags($newLine), file_get_contents($routes));

        file_put_contents($routes, $newRoutes);
    }

    private function makeMigration($className, $explodeField = null)
    {
        $migrationTableName = Str::plural(Str::lower(Str::snake($className)));

        if ($explodeField != null) {
            $field = $this->migrationColumnList($explodeField);
        } else {
            $field = null;
        }

        $migrationTemplate = str_replace(
            [
                '{modelName}',
                '{modelNamePluralLowerCase}',
                '{modelNamePlural}',
                '{field}'
            ],
            [
                $className,
                $migrationTableName,
                Str::plural($className),
                $field,
            ],
            $this->getStub('Migration')
        );

        if(!file_exists($path = base_path('/database/migrations')))
            mkdir($path, 0777, true);

        $timestamp = Str::snake(Carbon::now()->format('Y_m_d_His'));
        file_put_contents(base_path("/database/migrations/{$timestamp}_create_{$migrationTableName}_table.php"), $migrationTemplate);
    }

    /**
     * Create migration table column list.
     * TODO: Buat limit jika kolom integer, dan tambahkan opsional().
     *
     * @param array $explodeField
     * @return string
     */
    private function migrationColumnList($explodeField)
    {
        $migrationColumn = null;
        foreach ($explodeField as $value) {

            $field  = $value[0];
            $type   = $this->typeDataColumn($value[1]);

            if (isset($value[2])) {
                $length = ', '.$value[2];
            } else {
                $length = '';
            }

            $migrationColumn .= "\t\t\t".'$table->'.$type."('". $field ."'".$length. ");" . PHP_EOL;
        }

        return $migrationColumn;
    }

    private function typeDataColumn($string) {
        switch ($string) {
            case 'int':
                return 'integer';
                break;
            case 'uint':
                return 'unsignedInteger';
                break;
            case 'str':
                return 'string';
                break;
            case 'text':
                return 'text';
                break;
            case 'char':
                return 'char';
                break;
            case 'date':
                return 'date';
                break;
            default:
                return 'string';
                break;
        }
    }

    private function makeView($className, $explodeField = null)
    {
        $modelNamePluralLowerCase = Str::plural(Str::lower(Str::snake($className)));
        $path = base_path('/resources/views/' . $modelNamePluralLowerCase);

        if(!file_exists($path))
            mkdir($path, 0777, true);

        $this->makeIndexView($className, $explodeField);
        $this->appendBreadcrumb($className);
    }

    private function makeIndexView($className, $explodeField = null)
    {
        $ajaxColumns = null;
        $dataTableColumns = null;

        if ($explodeField != null) {
            foreach ($explodeField as $value) {
                $column  = $value[0];
                $ajaxColumns .= "\t\t\t{ data: '$column', name: '$column' }," . PHP_EOL ;

                $dataTableColumnName = Str::ucfirst(str_replace("_", " ", $column));
                $dataTableColumns .= "\t\t\t\t\t\t\t\t<th>$dataTableColumnName</th>" . PHP_EOL ;
            }
        } else {
            $ajaxColumns = "\t\t\t";
            $dataTableColumns = "\t\t\t\t\t\t\t\t";
        }

        $ajaxId = "{ data: 'id', name: 'id' }," . PHP_EOL;
        $ajaxAction = "\t\t\t{ data: 'action', name: 'action' },";

        $dataTableId = "<th>ID</th>" . PHP_EOL;
        $dataTableAction = "\t\t\t\t\t\t\t\t<th>Action</th>";

        $modelNamePluralLowerCase = Str::plural(Str::lower(Str::snake($className)));
        $modelNameSpacing = preg_replace('/([a-z])([A-Z])/s','$1 $2', $className);
        $modelNameLowerCase = Str::lower(Str::snake($className));

        $ajaxTableColumns = $ajaxId . $ajaxColumns . $ajaxAction;
        $dataTableHeader = $dataTableId . $dataTableColumns . $dataTableAction;

        $indexViewTemplate = str_replace(
            [
                '{modelName}',
                '{modelNameSpacing}',
                '{modelNameLowerCase}',
                '{ajaxTableColumns}',
                '{dataTableHeader}'
            ],
            [
                $className,
                $modelNameSpacing,
                $modelNameLowerCase,
                $ajaxTableColumns,
                $dataTableHeader
            ],
            $this->getViewStub('index')
        );

        file_put_contents(base_path("/resources/views/{$modelNamePluralLowerCase}/index.blade.php"), $indexViewTemplate);
    }

    private function appendBreadcrumb($className)
    {
        $breadcrumb_routes = base_path('routes/breadcrumbs.php');
        $className = Str::ucfirst($className);
        $classNameSnakeLowerCase = Str::lower(Str::snake($className));

        $breadcrumbs = "//Home > $className
Breadcrumbs::for('$classNameSnakeLowerCase.index', function (".'$trail'.") {
\t".'$trail->parent'."('home');
\t".'$trail->push'."('$className', action('".$className."Controller@index'));
});";

        File::append($breadcrumb_routes, PHP_EOL . $breadcrumbs . PHP_EOL);
    }
}
