<?php

namespace App\Http\Controllers;

/* My uses */
use App\Models\PageModel;

abstract class SubpageController extends Controller
{
    
	private $page;

	public function __construct(PageModel $page) {
		$this->page = $page;
	}

	public function getPage() {
		return $this->page;
	}

}
