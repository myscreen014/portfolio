<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/* My uses */
use App\Models\Page;

class PagesController extends Controller
{
 	
 
    public function index($slug=NULL) {
    	if (is_null($slug)) {
    		$page = Page::firstOrFail();
    	} else {
    		$page = Page::with(array('files' => function($query) {
                // $query->select('page_id', 'path'); just select path
            }))->where('slug', $slug)->firstOrFail();
    	}
    	return view('site.pages', array('page' => $page));
    }
}
