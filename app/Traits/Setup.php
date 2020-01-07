<?php

namespace App\Traits;

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
}
