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

            $homePage = PageModel::published()->where('menu', 'primary')->orderBy('ordering', 'ASC')->first();
            if (is_null($homePage)) abort(404);
            return redirect(route('page', [$homePage->slug]), 301);
    	} else {
    		$page = PageModel::published()->where('slug', $slug)->with(array('pictures' => function($query) {
                $query
                ->OfOrder()
                ->where('model_field', 'pictures'); 

            }))->firstOrFail();
    	}

        if ($page->controller != 'pages') {
            
            if (!is_null($params)) { $arrayParams = explode('/',$params);
            } else { $arrayParams = array(); }
            $controllerName = '\App\Http\Controllers\Site\\'.ucfirst($page->controller).'Controller';
            $controller = new $controllerName($page);
            $view = call_user_func_array(array($controller, 'index'), $arrayParams);
            return $view->with('page', $page);
        }
            
    	return view('site.pages', array('page' => $page));
    }
}
