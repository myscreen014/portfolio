<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/* My uses */
use App\Models\PageModel;

class PagesController extends Controller
{
 	
 
    public function index($slug=NULL) {
    	if (is_null($slug)) {
            $page = PageModel::with(array('files' => function($query) {
                $query->where('model_field', 'pictures'); 
            }))->firstOrFail();
    	} else {
    		$page = PageModel::with(array('files' => function($query) {
                $query->where('model_field', 'pictures'); 
            }))->where('slug', $slug)->firstOrFail();
    	}
    	return view('site.pages', array('page' => $page));
    }
}
