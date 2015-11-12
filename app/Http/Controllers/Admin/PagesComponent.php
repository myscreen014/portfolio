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
use DB;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Session;


class PagesComponent extends Controller
{

	private $defaultView = 'admin.pages';

	
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
		)->add(trans('admin.pages.action.create'), 'submit', ['attr' => ['class' => 'btn btn-success'] ]);

		return view($this->defaultView, array(
			'page'=>$page,
			'form'=>$form
		));
	}

	public function store(PageRequest $request)
	{
	
		// Create pages
		$page = PageModel::create($request->only('name', 'content'));

		// Get files added for this pages
		$file = new FileModel();
		$files = $file->whereIn('id', explode(',', $request->input('files_new')))->get();

		// Save relation
		$page->files()->saveMany($files);

		return redirect(route('admin.pages.index'));
	}
	
	public function edit($id, Request $request, FormBuilder $formBuilder)
	{

		$page = new PageModel;
		$page = $page->with(array(
			'files' => function($query) {
				$query->OfOrder()->where('model_field', 'files');
			}
		))->with(array(
			'pictures' => function($query) {
				$query->OfOrder()->where('model_field', 'pictures');
			}
		))->findOrFail($id);

		$page->pictures = $page->pictures->merge(FileModel::whereIn('id', explode(',', $request->old('pictures_new')))->get());
		$page->files = $page->files->merge(FileModel::whereIn('id', explode(',', $request->old('files_new')))->get());

		$form = $formBuilder->create(
			'App\Forms\PageForm',
			array(
				'method' => 'PUT',
				'url' => route('admin.pages.update', $id),
				'model' => $page
			), 
			array(
				'model_table'=> $page->getTable(),
				'model_id'=> $page->id
			)
		)->add(trans('admin.pages.action.save'), 'submit', ['attr' => ['class' => 'btn btn-primary'] ]);
		return view($this->defaultView,  array(
			'page' => $page,
			'form' => $form
		));
	}


	public function update($id, PageRequest $request)
	{
		$page = PageModel::findOrFail($id);
		$page->update($request->only('name', 'content'));

		// Get files added for this pages
		$file = new FileModel();
		$files = $file->whereIn('id', explode(',', $request->input('files_new')))->get();

		// Save relation
		$page->files()->saveMany($files);
		Session::flash('feedback', array(
			'message'=> trans('admin.global.feedback.update.ok'),
			'type' => 'success'
		));

		return redirect(route('admin.pages.index'));
	}

	public function delete($id) {
		$page = PageModel::findOrFail($id);
		return view($this->defaultView,  array(
			'page' => $page
		));
	}

	public function destroy($id)
	{
		$page = PageModel::findOrFail($id);
		$page->delete();
		Session::flash('feedback', array(
			'message'=> trans('admin.global.feedback.delete.ok'),
			'type' => 'success'
		));
		return redirect(route('admin.pages.index'));
	}
}
