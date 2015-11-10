<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;

/* My uses */
use Illuminate\Http\Response;
use App\Models\FileModel;
use App\Forms\FileForm;
use Kris\LaravelFormBuilder\FormBuilder;

class FilesComponent extends Controller {
	
	public function store(Request $request) {
		
		if (!is_null($request->input('model_table')) && !is_null($request->input('model_field')) && !is_null($request->input('model_id'))) {
			$fileUploadedName = 'file';
			$destinationPath = config('app.uploads_path');
			$modelTable = $request->input('model_table');
			$modelField = $request->input('model_field');
			$modelId = $request->input('model_id');

			if (!empty($_FILES)) {
				if ($request->hasFile($fileUploadedName)) {
					if ($request->file($fileUploadedName)->isValid()) {
						$fileUploaded = $request->file($fileUploadedName);

						$destinationPath = $destinationPath.'/'.$modelTable;

						if (!File::exists($destinationPath)) {
							File::makeDirectory($destinationPath);
						}
	
						// Create File
						$file = new FileModel();
						$file->name = $fileUploaded->getClientOriginalName();
						$file->type = $fileUploaded->getMimeType();
						$file->model_table = $modelTable;
						$file->model_field = $modelField;
						$file->model_id = $modelId;
						$file->path = $modelTable.'/'.$file->name;
						$isSave = $file->save();

						// Move uploaded file
						$isUploaded = $fileUploaded->move($destinationPath, $fileUploaded->getClientOriginalName());
						if ($isSave && $isUploaded) {
							return array(
								'file_id' => $file->id
							);
						} else {
							return false;
						}
						
					}
				} 
			}
		} 
	}

	public function editAjax($id, FormBuilder $formBuilder, Request $request) {
		if ($request->ajax()) {
			$file = new FileModel;
			$file = $file->findOrFail($id);

			$form = $formBuilder->create(
	            'App\Forms\FileForm', 
	            array(
					'method' => 'PUT',
					'url' => route('admin.files.update', $id),
		            'model' => $file
				)
	        )->add(trans('admin.files.action.save'), 'submit', ['attr' => ['class' => 'btn btn-primary']]);

	        return (new Response(form($form), 200));
	    } else {
	    	return (new Response(NULL, 403));
	    }
	}

    public function showAjax($id, Request $request) {
    	if ($request->ajax()) {
	        $file = FileModel::findOrFail($id);
	        return (new Response(
	        	array(
	        		'values' => $file->toJson(),
	        		'route' => route('file', $file->id.'.modal')	
	        ), 200));
	    } else {
	    	return (new Response(NULL, 403));
	    }
    }

	public function updateAjax($id, Request $request) {
    	if ($request->ajax()) {
	        $file = FileModel::findOrFail($id);
	        $file->update($request->only('legend'));
	        return (new Response(NULL, 200));
	    } else {
	    	return (new Response(NULL, 403));
	    }
    }

    public function deleteAjax($id, Request $request, FormBuilder $formBuilder) {

    	if ($request->ajax()) {
	        $file = FileModel::findOrFail($id);
	        $form = $formBuilder->plain(
		        array(
					'method' => 'DELETE',
					'url' => route('admin.files.destroy', $id),
		            'model' => $file
				)
		    )->add('message', 'static', [
   				'tag' => 'p',
   				'label_attr' => ['class' => 'hidden'],
    			'attr' => ['class' => 'text-danger'],
    			'value' => trans('admin.files.message.delete')
			])->add(trans('admin.global.action.delete'), 'submit', ['attr' => ['class' => 'btn btn-danger']]);
		    return (new Response(form($form), 200));
		} else {
	    	return (new Response(NULL, 403));
	    }
    }

    public function destroyAjax($id, Request $request) {
        if ($request->ajax()) {
	        $file = FileModel::findOrFail($id);
	        $file->delete();
	        return (new Response(NULL, 200));
	    } else {
	    	return (new Response(NULL, 403));
	    }
    }

    public function reorderAjax(Request $request) {
    	if ($request->ajax()) {
	    	$filesIds = $request->input('filesIds');
	  		$filesOrder = array_flip($filesIds);
	    	$files = FileModel::whereIn('id', $filesIds)->get();
			foreach ($files as $key => $file) {
				$file->ordering = $filesOrder[$file->id];
				$file->update(); // il faut trouver un solution pour le multiple
			}
	    	return (new Response(NULL, 200));
	    } else {
	    	return (new Response(NULL, 403));
	    }
    }

	
}
