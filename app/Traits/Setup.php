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
    public function createEnv()
    {
        $env = base_path('.env');
        $env_example = base_path('.env.example');

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
}
