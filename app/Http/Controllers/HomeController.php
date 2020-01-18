<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function index()
    {
        $breadcrumb_routes = base_path('routes/breadcrumbs.php');
        $className = Str::ucfirst('beritaBaru');
        $classNameSnakeLowerCase = Str::lower(Str::snake($className));

        // return $classNameSnakeLowerCase;

        $breadcrumbs = "//Home > $className
Breadcrumbs::for('$classNameSnakeLowerCase.index', function (".'$trail'.") {
\t".'$trail->parent'."('home');
\t".'$trail->push'."('$className', action('".$className."Controller@index'));
});";

        File::append($breadcrumb_routes, PHP_EOL . $breadcrumbs . PHP_EOL);

        exit();
        return HomeController::class;
    }
}
