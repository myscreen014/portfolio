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
            $page = PageModel::with(array('pictures' => function($query) {
                $query
                ->where('model_field', 'pictures')
                ->orderBy('ordering', 'ASC'); 

            }))->orderBy('ordering','ASC')->firstOrFail();
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
            $Controller = new \App\Http\Controllers\Site\GalleriesController;    
            $view = call_user_func_array(array($Controller, 'index'), $arrayParams);
            return $view->with('page', $page);
        }
            
    	return view('site.pages', array('page' => $page));
    }
}
