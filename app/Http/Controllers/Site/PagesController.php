<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/* My uses */
use App\Models\PageModel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;

class PagesController extends Controller
{
 	
 
    public function index($slug=NULL, $params=NULL) {
        
    	if (is_null($slug)) {
            $homePage = PageModel::orderBy('ordering', 'ASC')->first();
            return redirect(route('page', [$homePage->slug]), 301);
    	} else {
    		$page = PageModel::where('slug', $slug)->with(array('pictures' => function($query) {
                $query
                ->where('model_field', 'pictures')
                ->orderBy('ordering', 'ASC'); 

            }))->firstOrFail();
    	}

        if ($page->controller != 'pages') {
            
            if (!is_null($params)) { $arrayParams = explode('/',$params);
            } else { $arrayParams = array(); }
            $controllerName = '\App\Http\Controllers\Site\\'.$page->controller.'Controller';
            $controller = new $controllerName;
            $view = call_user_func_array(array($controller, 'index'), $arrayParams);
            return $view->with('page', $page);
        }
            
    	return view('site.pages', array('page' => $page));
    }
}
