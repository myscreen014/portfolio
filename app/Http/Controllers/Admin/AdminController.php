<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

/* My uses */
use Illuminate\Support\Facades\Config;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $components = Config::get('administration.components');
        $firstComponent = array_shift($components);
        return redirect(route($firstComponent['routes']['index']));
    }

   
}
