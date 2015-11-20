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

<<<<<<< HEAD
	public function configure() {
=======
	
	public function index()
	{
	
		$page = new PageModel;
		$pages = $page->get();
		return view($this->defaultView, array('pages' => $pages));
	}

	public function create(FormBuilder $formBuilder, Request $request)
	{

		$page = new PageModel;
		$page->pictures = FileModel::where('model_field', 'pictures')->whereIn('id', explode(',', $request->old('pictures_new')))->get();
		$page->files = FileModel::where('model_field', 'files')->whereIn('id', explode(',', $request->old('files_new')))->get();
	   
		$form = $formBuilder->create(
			'App\Forms\PageForm', 
			array(
				'method' => 'POST',
				'url' => route('admin.pages.store'),
				'model' => $page
			), 
			array(
				'model_table'=> $page->getTable(),
				'model_id'=> NULL
			)
		)->add(trans('admin.page.action.create'), 'submit', array(
            'attr' => array('class' => 'btn btn-success'),
            'wrapper' => array('class' => 'form-group actions'),
            'others_actions' => array(
                'back' => array(
                    'value' => trans('admin.global.action.back'), 
                    'class' => 'btn-default',
                    'url' => route('admin.pages.index')
                )
            )
        ));

		return view($this->defaultView, array(
			'page'=>$page,
			'form'=>$form
		));
	}

	public function store(PageRequest $request)
	{
	
		// Create pages
		$page = PageModel::create($request->all());

		// Get files added for this pages
		$file = new FileModel();
		$files = $file->whereIn('id', explode(',', $request->input('files_new')))->get();
>>>>>>> parent of 736aa62... Add reorder items models

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
