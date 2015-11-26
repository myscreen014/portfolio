<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers;


/* My uses */
use App\Models\FileModel;
use App\Models\GalleriesCategoryModel;
use App\Http\Requests\GalleriesCategoryRequest;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Session;


class GalleriesCategoriesComponent extends Controller
{

	private $defaultView = 'admin.galleriescategories';

	public function index() 
	{
		$category = new GalleriesCategoryModel;
		$categories = $category->with('galleries')->get();
		return view($this->defaultView, array('categories' => $categories));
	}


	public function create(FormBuilder $formBuilder, Request $request)
	{

		$category = new GalleriesCategoryModel;
		$category->pictures = FileModel::where('model_field', 'pictures')->whereIn('id', explode(',', $request->old('pictures_new')))->get();

	
		$form = $formBuilder->create(
			'App\Forms\GalleriesCategoryForm', 
			array(
				'method' => 'POST',
				'url' => route('admin.galleries.categories.store'),
				'model' => $category
			), 
			array(
				'model_table'=> $category->getTable(),
				'model_id'=> NULL
			)
		)->add('actions', 'submit', array(
			'label' => trans('admin.gallery.action.create'),
            'attr' => array('class' => 'btn btn-success'),
            'wrapper' => array('class' => 'form-group actions'),
            'others_actions' => array(
                'back' => array(
                    'value' => trans('admin.global.action.back'), 
                    'class' => 'btn-default',
                    'url' => route('admin.galleries.categories.index')
                )
            )
        ));

		return view($this->defaultView, array(
			'category' 	=> $category,
			'form'  	=> $form
		));
	}

	public function store(GalleriesCategoryRequest $request)
	{
	
		// Create category
		$category = GalleriesCategoryModel::create($request->all());

		// Get files added for this pages
		$file = new FileModel();
		$files = $file->whereIn('id', explode(',', $request->input('pictures_new')))->get();

		// Save relation
		$category->pictures()->saveMany($files);

		return redirect(route('admin.galleries.categories.index'));
	}
	
	public function edit($id, Request $request, FormBuilder $formBuilder)
	{

		$category = new GalleriesCategoryModel;
		$category = $category->with(array(
			'pictures' => function($query) {
				$query
				->OfOrder()
				->where('model_table', 'gallerycategories')
				->where('model_field', 'pictures');
			}
		))->findOrFail($id);

		$category->pictures = $category->pictures->merge(FileModel::whereIn('id', explode(',', $request->old('pictures_new')))->get());


		$form = $formBuilder->create(
			'App\Forms\GalleriesCategoryForm',
			array(
				'method' => 'PUT',
				'url' => route('admin.galleries.categories.update', $id),
				'model' => $category
			), 
			array(
				'model_table'=> $category->getTable(),
				'model_id'=> $category->id
			)
		)->add('actions', 'submit', array(
			'label' => trans('admin.gallery.action.save'),
            'attr' => array('class' => 'btn btn-primary'),
            'wrapper' => array('class' => 'form-group actions'),
            'others_actions' => array(
                'back' => array(
                    'value' => trans('admin.global.action.back'), 
                    'class' => 'btn-default',
                    'url' => route('admin.galleries.categories.index')
                )
            )
        ));
		return view($this->defaultView,  array(
			'category' 	=> $category,
			'form' 		=> $form
		));
	}


	public function update($id, GalleriesCategoryRequest $request)
	{
		$category = GalleriesCategoryModel::findOrFail($id);
		$category->update($request->all());

		// Get files pictures added for this gallery
		$file = new FileModel();
		$files = $file->whereIn('id', explode(',', $request->input('pictures_new')))->get();

		// Save relation
		$category->pictures()->saveMany($files);

		Session::flash('feedback', array(
			'message'=> trans('admin.global.feedback.update.ok'),
			'type' => 'success'
		));

		return redirect(route('admin.galleries.categories.index'));
	}

	public function delete($id) {
		$category = GalleriesCategoryModel::findOrFail($id);
		return view($this->defaultView,  array(
			'category' 	=> $category
		));
	}

	public function destroy($id)
	{
		$category = GalleriesCategoryModel::findOrFail($id);
		if (count($category->galleries)==0) {
			$category->delete();
		} 
		Session::flash('feedback', array(
			'message'	=> trans('admin.global.feedback.delete.ok'),
			'type' 		=> 'success'
		));
		return redirect(route('admin.galleries.categories.index'));
	}


}