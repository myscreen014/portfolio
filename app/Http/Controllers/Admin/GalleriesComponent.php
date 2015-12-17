<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers;


/* My uses */
use App\Models\GalleryModel;
use App\Models\FileModel;
use App\Http\Requests\GalleryRequest;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Session;


class GalleriesComponent extends Controller
{

	private $defaultView = 'admin.galleries';

	
	public function index() 
	{
		$gallery = new GalleryModel;
		$galleries = $gallery->orderBy('ordering', 'ASC')->with('category')->get();
		return view($this->defaultView, array('galleries' => $galleries));
	}

	public function create(FormBuilder $formBuilder, Request $request)
	{

		$gallery = new GalleryModel;
		$gallery->pictures = FileModel::where('model_field', 'pictures')->whereIn('id', explode(',', $request->old('pictures_new')))->get();

	   
		$form = $formBuilder->create(
			'App\Forms\GalleryForm', 
			array(
				'method' => 'POST',
				'url' => route('admin.galleries.store'),
				'model' => $gallery
			), 
			array(
				'model_table'=> $gallery->getTable(),
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
                    'url' => route('admin.galleries.index')
                )
            )
        ));

		return view($this->defaultView, array(
			'gallery'=>$gallery,
			'form'=>$form
		));
	}

	public function store(GalleryRequest $request)
	{
	
		// Validation pictures required !!!
		if (empty($request->input('pictures_new'))) {
	   		return redirect(route('admin.galleries.create'))
                ->withErrors(
                	array(
                		'message' => trans('validation.required', array(
                			'attribute'=> trans('validation.attributes.pictures')
                		)
                )))
                ->withInput();
	   	}
	
		// Create gallery
		$gallery = GalleryModel::create($request->all());

		// Get files added for this pages
		$file = new FileModel();
		$files = $file->whereIn('id', explode(',', $request->input('pictures_new')))->get();

		// Save relation
		$gallery->pictures()->saveMany($files);

		return redirect(route('admin.galleries.index'));
	}
	
	public function edit($id, Request $request, FormBuilder $formBuilder)
	{

		$gallery = new GalleryModel;
		$gallery = $gallery->with(array(
			'pictures' => function($query) {
				$query
				->OfOrder()
				->where('model_table', 'galleries')
				->where('model_field', 'pictures');
			}
		))->findOrFail($id);

		$gallery->pictures = $gallery->pictures->merge(FileModel::whereIn('id', explode(',', $request->old('pictures_new')))->get());

		$form = $formBuilder->create(
			'App\Forms\GalleryForm',
			array(
				'method' => 'PUT',
				'url' => route('admin.galleries.update', $id),
				'model' => $gallery
			), 
			array(
				'model_table'=> $gallery->getTable(),
				'model_id'=> $gallery->id
			)
		)->add('actions', 'submit', array(
			'label' => trans('admin.gallery.action.save'),
            'attr' => array('class' => 'btn btn-primary'),
            'wrapper' => array('class' => 'form-group actions'),
            'others_actions' => array(
                'back' => array(
                    'value' => trans('admin.global.action.back'), 
                    'class' => 'btn-default',
                    'url' => route('admin.galleries.index')
                )
            )
        ));
		return view($this->defaultView,  array(
			'gallery' => $gallery,
			'form' => $form
		));
	}


	public function update($id, GalleryRequest $request)
	{

		// Validation pictures required !!!
		if (empty($request->input('pictures_new'))) {
	   		return redirect(route('admin.galleries.edit', $id))
                ->withErrors(
                	array(
                		'message' => trans('validation.required', array(
                			'attribute'=> trans('validation.attributes.pictures')
                		)
                )))
                ->withInput();
	   	}

		$gallery = GalleryModel::findOrFail($id);
		$gallery->update($request->all());

		// Get files pictures added for this gallery
		$file = new FileModel();
		$files = $file->whereIn('id', explode(',', $request->input('pictures_new')))->get();

		// Save relation
		$gallery->pictures()->saveMany($files);
		Session::flash('feedback', array(
			'message'=> trans('admin.global.feedback.update.ok'),
			'type' => 'success'
		));

		return redirect(route('admin.galleries.index'));
	}

	public function delete($id) {
		$gallery = GalleryModel::findOrFail($id);
		return view($this->defaultView,  array(
			'gallery' => $gallery
		));
	}

	public function destroy($id)
	{
		$gallery = GalleryModel::findOrFail($id);
		$gallery->delete();
		Session::flash('feedback', array(
			'message'=> trans('admin.global.feedback.delete.ok'),
			'type' => 'success'
		));
		return redirect(route('admin.galleries.index'));
	}
}
