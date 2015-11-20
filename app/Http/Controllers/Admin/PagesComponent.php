<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers;


/* My uses */
use App\Models\PageModel;
use App\Models\FileModel;
use App\Http\Requests\PageRequest;
use App\Forms\PageForm;
use DB;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Session;


class PagesComponent extends LazyComponent
{

	private $defaultView = 'admin.pages';

	public function configure() {

		$this->lazyConfig = array(

			/* global */
			'componentName'	=> 'pages',
			'modelName' 	=> 'page',

			/* request */
			'request'		=> new PageRequest(),

			/* form */
			'form'			=> new PageForm(),

			/* joins */
			'width'			=> array(
				'pictures' => function($query) {
					$query->OfOrder()->where('model_field', 'pictures');
				}, 
				'files' => function($query) {
					$query->OfOrder()->where('model_field', 'files');
				},
			),

			/* fields File */
			'fieldsFile' => array(
				'pictures', 'files'
			),

			/* list */
			'list'			=> array(
				'fields'	=> array(
					'id', 'name'
				)
			)

		);
	}

}
