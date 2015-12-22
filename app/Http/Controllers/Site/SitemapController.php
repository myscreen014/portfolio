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
		$urls = array();
		$pages = PageModel::get();

		foreach ($pages as $key => $page) {
			if ($page->controller == 'pages') {
				array_push($urls, array(
					'loc' => route('page', $page->slug),
					'priority' => '1'
				));
			} else {
				$controllerName = '\App\Http\Controllers\Site\\'.ucfirst($page->controller).'Controller';
	            $controller = new $controllerName;
	            $controllerUrls = call_user_func_array(array($controller, '_sitemap'), array($page));
	            $urls = array_merge($urls, $controllerUrls);
			}
		}

		return view('site.sitemap', array(
			'urls' => $urls
		));
	}

}
