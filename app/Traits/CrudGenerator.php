<?php

namespace App\Traits;

use Carbon\Carbon;
use File;
use Illuminate\Support\Str;

trait CrudGenerator
{
    protected function createCrud($className)
    {
        $this->makeController($className);
        $this->makeModel($className);
        $this->makeRequest($className);
        $this->makeRoute($className);
        $this->makeMigration($className);
    }

    protected function getStub($type)
    {
        return file_get_contents(resource_path("stubs/$type.stub"));
    }

    protected function makeController($className)
    {
        $controllerTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}'
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

    protected function makeModel($className)
    {
        $modelTemplate = str_replace(
            ['{{modelName}}'],
            [$className],
            $this->getStub('Model')
        );

        file_put_contents(app_path("/Models/{$className}.php"), $modelTemplate);
    }

    protected function makeRequest($className)
    {
        $requestTemplate = str_replace(
            ['{{modelName}}'],
            [$className],
            $this->getStub('Request')
        );

        if(!file_exists($path = app_path('/Http/Requests')))
            mkdir($path, 0777, true);

        file_put_contents(app_path("/Http/Requests/{$className}Request.php"), $requestTemplate);
    }

    protected function makeRoute($className)
    {
        //TODO: Append diantara middleware installed
        // $filename = 'test.php'; // the file to change
        // $search = 'Hi 2'; // the content after which you want to insert new stuff
        // $insert = 'Hi 3'; // your new stuff

        // $replace = $search. "\n". $insert;

        // file_put_contents($filename, str_replace($search, $replace, file_get_contents($filename)));
        File::append(base_path('routes/web.php'), 'Route::resource(\'' . Str::plural(Str::lower($className)) . "', '{$className}Controller');" . PHP_EOL);
    }

    protected function makeMigration($className)
    {
        $migrationTableName = Str::plural(Str::lower(Str::snake($className)));
        $migrationTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNamePlural}}'
            ],
            [
                $className,
                $migrationTableName,
                Str::plural($className),
            ],
            $this->getStub('Migration')
        );

        if(!file_exists($path = base_path('/database/migrations')))
            mkdir($path, 0777, true);

        $timestamp = Str::snake(Carbon::now()->format('Y_m_d_His'));
        file_put_contents(base_path("/database/migrations/{$timestamp}_create_{$migrationTableName}_table.php"), $migrationTemplate);
    }

    protected function makeView($className)
    {
        //
    }
}
