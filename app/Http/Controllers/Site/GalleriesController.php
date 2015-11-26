<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/* My uses */
use App\Models\GalleriesCategoryModel;
use App\Models\GalleryModel;
use Illuminate\Support\Facades\Route;

class GalleriesController extends Controller
{

 	
    public function index($categorySlug=NULL, $gallerySlug=NULL) {


		$category = new GalleriesCategoryModel();

    	if (is_null($categorySlug) && is_null($gallerySlug)) {
    		$categories = $category->with(array('pictures' => function($query) {
                $query->orderBy('ordering', 'ASC');
            }))->get();
    		return view('site.galleries', array(
    			'categories' => $categories 
    		));

    	} elseif (is_null($gallerySlug)) {
            $gallery = new GalleryModel();
    		$category = $category
                ->where('slug', $categorySlug)
                ->first();
			return view('site.galleries', array(
    			'category' => $category
    		));
    	} else {
            $gallery = new GalleryModel();
            $gallery = $gallery
                ->where('slug', $gallerySlug)
                ->first();
            return view('site.galleries', array(
                'gallery'   => $gallery
            ));
        }

    }


}
