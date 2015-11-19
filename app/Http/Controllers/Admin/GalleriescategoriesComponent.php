<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers;


/* My uses */
use App\Models\GalleriesCategoryModel;
use App\Http\Requests\GalleriesCategoryRequest;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Session;


class GalleriesCategoriesComponent extends Controller
{

	private $defaultView = 'admin.galleries';

	public function index() 
	{
		$category = new GalleriesCategoryModel;
		$categories = $category->get();
		return view($this->defaultView, array('categories' => $categories));
	}


}