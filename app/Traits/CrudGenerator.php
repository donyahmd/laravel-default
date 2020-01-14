<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Str;
trait CrudGenerator
{
    protected function createCrud($className, $field = null)
    {
        $this->makeController($className);
        $this->makeModel($className);
        $this->makeRequest($className);
        $this->makeRoute($className);
        $this->makeMigration($className, $field);
        $this->makeView($className, $field);
    }

    private function getStub($type)
    {
        return file_get_contents(resource_path("stubs/$type.stub"));
    }

    private function makeController($className)
    {
        $controllerTemplate = str_replace(
            [
                '{modelName}',
                '{modelNamePluralLowerCase}',
                '{modelNameSingularLowerCase}'
            ],
            [
                $className,
                Str::lower(Str::plural($className)),
                Str::lower($className)
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
                Str::lower(Str::plural($className)),
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

        $nextLine = 'Route::resource(\'' . Str::plural(Str::lower($className)) . "', '{$className}Controller');";

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
            case 'txt':
                return 'txt';
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
        $this->makeIndexView($className, $explodeField);
    }

    private function makeIndexView($className, $explodeField = null)
    {
        //TODO: Bikin auto
    }
}
