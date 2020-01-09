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
    public function setup(SetupRequest $request)
    {
        if ($this->isMysqlConnected($request)) {
            return true;
        } else {
            return redirect()->back()->withErrors(mysqli_connect_error());
        }
    }
}
