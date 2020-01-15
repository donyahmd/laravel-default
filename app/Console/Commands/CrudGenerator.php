<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

use App\Traits\CrudGenerator as AppCrudGenerator;

class CrudGenerator extends Command
{
    use AppCrudGenerator;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud {className : Name of the model}
                            {--f|field= : Table column for this model}
                            {--m|migrate : Migrate immediately after creating CRUD}
                            {--noview : No create view of model (Under Development)}';

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
        $fieldParameter     = $this->option('field');
        $migrateParameter   = $this->option('migrate');
        $noViewParameter    = $this->option('noview');

        $explodeParameter = explode(",", $fieldParameter);

        foreach ($explodeParameter as $field) {
            $explodeField[] = explode(":", $field);
        }

        $className = Str::ucfirst($this->argument('className'));

        $this->info('Please wait, magic is on process. Abrakadabra!');

        if ($fieldParameter != null)
            $this->createCrud($className, $explodeField, $noViewParameter != null ? true : false);
        else
            $this->createCrud($className);

        if ($migrateParameter != null) {
            $this->info('Migrating table...');
            Artisan::call('migrate', ['--force' => true]);
        }

        $this->info('TADAA! Your CRUD is created magically!');
    }
}
