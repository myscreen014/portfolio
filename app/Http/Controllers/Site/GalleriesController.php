<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/* My uses */
use App\Models\GalleriesCategoryModel;
use App\Models\GalleryModel;
use Illuminate\Support\Facades\Route;
use App\Models\PageModel;

class GalleriesController extends Controller
{

 	
    public function index($categorySlug=NULL, $gallerySlug=NULL) {


		$category = new GalleriesCategoryModel();

        // Display Categories
    	if (is_null($categorySlug) && is_null($gallerySlug)) {
    		$categories = $category->published()->with(
                array(
                    'galleries' => function($query) {
                        $query->with(
                            array(
                                'pictures' => function($query) {
                                    $query->OfOrder();
                                }
                            ))->orderBy('ordering', 'ASC');
                    },
                    'pictures' => function($query) {
                        $query->orderBy('ordering', 'ASC');
                    }
                ))->has('galleries', '>', 0)->whereHas('galleries', function($query){
                    $query->published();
                }
            )->get();
    		return view('site.galleries', array(
    			'categories' => $categories
    		));

        // Display Galleries of category 
    	} elseif (is_null($gallerySlug)) {
            $gallery = new GalleryModel();
    		$category = $category
                ->with(array('galleries' => function($query) {
                    $query->published()->with(
                        array(
                            'pictures' => function($query) {
                                $query->OfOrder();
                            }
                        ));
                }))
                ->where('slug', $categorySlug)
                ->first();
			return view('site.galleries', array(
    			'category' => $category,
                '_metaTitle' => $category->name,
                '_metaDescription' => $category->description,
    		));

        // Display Gallery
    	} else {
            $gallery = new GalleryModel();
            $gallery = $gallery->published()->with(
                array(
                    'pictures' => function($query) {
                        $query->OfOrder();
                    }
                ))->where('slug', $gallerySlug)
                ->first();
            return view('site.galleries', array(
                'gallery'   => $gallery,
                '_metaTitle' => $gallery->category->name.' - '.$gallery->name,
                '_metaDescription' => $gallery->description,
            ));
        }

    }

    public function _sitemap(PageModel $page) {

        $urls = array();
        $galleries = GalleryModel::with('category')->get();
        
        foreach ($galleries as $key => $gallery) {
            array_push($urls, array(
                'loc' => route_page($page, [$gallery->category->slug, $gallery->slug]),
                'priority' => 0.9
            ));
        }
        
        return $urls;
    }


}
