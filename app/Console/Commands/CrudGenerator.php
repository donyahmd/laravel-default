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
    protected $signature = 'make:crud {className}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membuat CRUD Otomatis';

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
        $className = Str::ucfirst($this->argument('className'));

        $this->createCrud($className);
    }
}
