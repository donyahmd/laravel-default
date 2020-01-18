<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

trait Setup
{
    /**
     * Check .env file is exist or not
     */
    public function isEnvExist()
    {
        $env = base_path('.env');

        if (!file_exists($env)) {
            return false;
        }

        return true;
    }

    /**
     * Create .env file
     */
    public function createEnv($setup)
    {
        $this->setupConfig();
        $env = base_path('.env');
        $envExample = base_path('.env.example');

        $input = $setup->only([
            'APP_NAME', 'APP_URL', 'DB_CONNECTION',
            'DB_HOST', 'DB_PORT', 'DB_DATABASE',
            'DB_USERNAME', 'DB_PASSWORD', 'APP_ENV']);

        if (!$this->isEnvExist()) {
            copy($envExample, $env);

            $envLines = file($env);
            foreach ($input as $index => $value) {
                foreach ($envLines as $key => $line) {
                    if (strpos($line, $index) !== false) {
                        $envLines[$key] = $index . '="' . $value . '"' . PHP_EOL;
                    }
                }
            }

            Artisan::call('key:generate', [
                '--show'    =>  true,
            ]);

            $appKey = Artisan::output();
            $envLines[2] = 'APP_KEY=' . $appKey . '';

            $fp = fopen($env, 'w');
            fwrite($fp, implode('', $envLines));
            fclose($fp);

            // $this->runArtisan();
        } else {
            $this->deleteEnv();
            $this->createEnv($setup);
        }

        return true;
    }

    /**
     * Delete .env file
     */
    public function deleteEnv()
    {
        $env = base_path('.env');

        if ($this->isEnvExist()) {
            unlink($env);
        }

        return true;
    }

    /**
     * Check MySQL connection
     */
    public function isMysqlConnected($setup)
    {
        @mysqli_connect($setup['DB_HOST'], $setup['DB_USERNAME'], $setup['DB_PASSWORD'], $setup['DB_DATABASE'], $setup['DB_PORT']);

        if (mysqli_connect_errno()) {
            return false;
        }

        return true;
    }

    /**
     * Initialize all install functions
     *
     */
    private function setupConfig()
    {
        config(['app.debug' => true]);
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
    }

    /**
     * Run Artisan Command
     */
    private function runArtisan()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '512M');

        $this->setupConfig();

        DB::statement('SET default_storage_engine=INNODB;');

        Artisan::call('migrate:fresh', [
            '--force'   =>  true,
            '--seed'    =>  true,
        ]);

        return true;
    }
}
