<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use App\Traits\CrudGenerator as AppCrudGenerator;

class CrudGenerator extends Command
{
    use AppCrudGenerator;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud {className : Name of the Model} {--field=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Magic {C}reate,{R}ead,{U}pdate,{D}elete Generator by Doni Ahmad';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $parameterConsole = $this->option('field');
        $explodeParameter = explode(",", $parameterConsole);

        foreach ($explodeParameter as $field) {
            $explodeField[] = explode(":", $field);
        }

        $className = Str::ucfirst($this->argument('className'));

        $this->info('Please wait, magic is on process. Abrakadabra!');

        if ($this->option('field') == null) {
            $this->createCrud($className);
        } else {
            $this->createCrud($className, $explodeField);
        }

        $this->info('TADAA! Your CRUD is created magically!');
    }
}
