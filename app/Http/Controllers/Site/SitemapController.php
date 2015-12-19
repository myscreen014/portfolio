<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/* Mu uses */
use App\Models\PageModel;


class SitemapController extends Controller
{

	public function index()
	{
		$pages = PageModel::get();
		return view('site.sitemap', array(
			'pages' => $pages
		));
	}

}
