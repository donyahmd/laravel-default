<?php

namespace App\Traits;

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
        $env = base_path('.env');
        $env_example = base_path('.env.example');

        $input = $setup->only(['APP_NAME', 'APP_URL', 'DB_CONNECTION', 'DB_HOST', 'DB_PORT', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD', 'APP_ENV']);

        foreach ($input as $key => $value) {
            print_r($key);
        }

        exit();

        if (!$this->isEnvExist()) {
            copy($env_example, $env);
            Artisan::call('key:generate');
            return true;
        }

        return false;
    }

    /**
     * Delete .env file
     */
    public function deleteEnv()
    {
        $env = base_path('.env');

        if ($this->isEnvExist()) {
            return $env;
        }

        return false;
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
}
