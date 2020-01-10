<?php

namespace App\Http\Controllers;

use App\Traits\Setup;
use App\Http\Requests\Setup\SetupRequest;

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
    public function setup(SetupRequest $setup)
    {
        if ($this->isMysqlConnected($setup)) {
            if ($this->createEnv($setup)) {
                return redirect('/');
            }
        } else {
            return redirect()->back()->withErrors(mysqli_connect_error());
        }
    }
}
