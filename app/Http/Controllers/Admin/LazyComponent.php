<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers;

/* My uses */
use App\Models\FileModel;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Session;

abstract class LazyComponent extends Controller
{

	public $lazyConfig;
	private $defaultConfig = array(
		'view' => 'admin.lazy'
	);

	private $modelClass;
	private $modelRequestClass;
	private $modelFormClass;

	abstract public function configure();

	public function __construct() { 
		global $shin;
		$this->configure();
		$this->lazyConfig = array_merge($this->defaultConfig, $this->lazyConfig);
		$this->modelClass = 'App\Models\\'.ucfirst($this->lazyConfig['modelName']).'Model';
		$this->modelRequest = $this->lazyConfig['request'];
		$this->modelForm = $this->lazyConfig['form'];
	}

	public function index()
	{
		$model = new $this->modelClass;
		$items = $model->orderBy('ordering', 'ASC')->get();
		return view($this->lazyConfig['view'], array(
			'componentName' 	=> $this->lazyConfig['componentName'],
			'modelName' 		=> $this->lazyConfig['modelName'],
			'listFields'		=> $this->lazyConfig['list']['fields'],
			'items' 			=> $items
		));
	}

	public function create(FormBuilder $formBuilder, Request $request)
	{

		$model = new $this->modelClass;
	
		foreach ($this->lazyConfig['fieldsFile'] as $fieldName) {
			$model[$fieldName] = $model[$fieldName]->merge(FileModel::whereIn('id', explode(',', $request->old($fieldName.'_new')))->get());
		}
		
		varlog($this->modelForm->getFields());

		$form = $formBuilder->create(
			get_class($this->modelForm),
			array(
				'method' => 'POST',
				'url' => route('admin.'.$this->lazyConfig['componentName'].'.store'),
				'model' => $model			
			), 
			array(
				'model_table'=> $model->getTable(),
				'model_id'=> NULL
			)
		);

		$form->add(trans('admin.'.$this->lazyConfig['modelName'].'.action.create'), 'submit', array(
            'attr' => array('class' => 'btn btn-success'),
            'wrapper' => array('class' => 'form-group actions'),
            'others_actions' => array(
                'back' => array(
                    'value' => trans('admin.global.action.back'), 
                    'class' => 'btn-default',
                    'url' => route('admin.'.$this->lazyConfig['componentName'].'.index')
                )
            )
        ));       	


		return view($this->lazyConfig['view'], array(
			'componentName' 	=> $this->lazyConfig['componentName'],
			'modelName' 		=> $this->lazyConfig['modelName'],
			'item'=>$model,
			'form'=>$form
		));
	}

	
	public function store(Request $request)
	{
		$customRequest = $this->modelRequest;
		$this->validate($request, $customRequest->rules());

		$modelClass = $this->modelClass;
		$model = $modelClass::create($request->all());

		$file = new FileModel();
		foreach ($this->lazyConfig['fieldsFile'] as $fieldName) {
			$files = $file->whereIn('id', explode(',', $request->input($fieldName.'_new')))->get();
			$model->$fieldName()->saveMany($files);
		}

		return redirect(route('admin.'.$this->lazyConfig['componentName'].'.index'));
	}

	public function edit($id, Request $request, FormBuilder $formBuilder)
	{

		$model = new $this->modelClass;
		$model = $model->with($this->lazyConfig['width'])->findOrFail($id);

		/* fields files ? */
		foreach ($this->lazyConfig['fieldsFile'] as $fieldName) {
			$model[$fieldName] = $model[$fieldName]->merge(FileModel::whereIn('id', explode(',', $request->old($fieldName.'_new')))->get());
		}

		// Recreate form width $model
		$form = $formBuilder->create(
			get_class($this->modelForm),
			array(
				'method' => 'PUT',
				'url' => route('admin.'.$this->lazyConfig['componentName'].'.update', $id),
				'model' => $model
			), 
			array(
				'model_table'=> $model->getTable(),
				'model_id'=> $model->id
			)
		)->add(trans('admin.'.$this->lazyConfig['modelName'].'.action.save'), 'submit', array(
            'attr' => array('class' => 'btn btn-primary'),
            'wrapper' => array('class' => 'form-group actions'),
            'others_actions' => array(
                'back' => array(
                    'value' => trans('admin.global.action.back'), 
                    'class' => 'btn-default',
                    'url' => route('admin.'.$this->lazyConfig['componentName'].'.index')
                )
            )
        ));

		return view($this->lazyConfig['view'],  array(
			'componentName' 	=> $this->lazyConfig['componentName'],
			'modelName' 		=> $this->lazyConfig['modelName'],
			'model' => $model,
			'form' => $form
		));
	}

	public function update($id, Request $request)
	{
		$customRequest = $this->modelRequest;

		$modelClass = $this->modelClass;
		$model = $modelClass::findOrFail($id);
		$model->update($request->only('controller', 'name', 'content'));

		$this->validate($request, $customRequest->rules());

		// Get files added for this pages
		/*$file = new FileModel();
		$files = $file->whereIn('id', explode(',', $request->input('files_new')))->get();
		*/

		Session::flash('feedback', array(
			'message'=> trans('admin.global.feedback.update.ok'),
			'type' => 'success'
		));

		return redirect(route('admin.'.$this->lazyConfig['componentName'].'.index'));
	}

	public function delete($id) {
		$modelClass = $this->modelClass;
		$model = $modelClass::findOrFail($id);
		return view($this->lazyConfig['view'],  array(
			'componentName' 	=> $this->lazyConfig['componentName'],
			'modelName' 		=> $this->lazyConfig['modelName'],
			'model' => $model
		));
	}

	public function destroy($id)
	{
		$modelClass = $this->modelClass;
		$model = $modelClass::findOrFail($id);
		$model->delete();
		Session::flash('feedback', array(
			'message'=> trans('admin.global.feedback.delete.ok'),
			'type' => 'success'
		));
		return redirect(route('admin.'.$this->lazyConfig['componentName'].'.index'));
	}
	


}