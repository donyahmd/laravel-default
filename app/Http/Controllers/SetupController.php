<?php

namespace App\Http\Controllers;

use App\Traits\Setup;
use Illuminate\Http\Request;

class SetupController extends Controller
{
    use Setup;

    /**
     * View setup
     *
     * @return view
     */
    public function viewSetup()
    {
        return view('setup.setup');
    }

    /**
     * Save setup configuration
     *
     * @return void
     */
    public function setConfig()
    {
        return $this->deleteEnv();
    }
}
