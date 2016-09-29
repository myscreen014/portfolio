<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;

/* My uses */
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use App\Models\FileModel;
use App\Forms\FileForm;
use Kris\LaravelFormBuilder\FormBuilder;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Config;

class FilesComponent extends Controller {
	
	public function store(Request $request) {
		if (!is_null($request->input('model_table')) && !is_null($request->input('model_field')) && !is_null($request->input('model_id'))) {

			ini_set('memory_limit', '512M');
			ini_set('max_execution_time', 300);

			$fileUploadedName = 'file';
			$destinationPath = config('app.uploads_path');
			$modelTable = $request->input('model_table');
			$modelField = $request->input('model_field');
			$modelId = $request->input('model_id');

			if (!empty($_FILES)) {
				if ($request->hasFile($fileUploadedName)) {
					if ($request->file($fileUploadedName)->isValid()) {
						$fileUploaded = $request->file($fileUploadedName);

						$uploadPath =  Config::get('app.uploads_path');
						if (!File::exists($uploadPath)) {
							File::makeDirectory($uploadPath);
						}

						// On créé l'instance File
						$file = new FileModel();
						$file->name = preg_replace("/[^A-Za-z0-9\_\-\.]/", '',$fileUploaded->getClientOriginalName());
						$file->path = $file->name;
						$file->model_table = $modelTable;
						$file->model_field = $modelField;
						$file->model_id = $modelId;
						$file->type = $fileUploaded->getMimeType();
						$file->hash = hash_file('md5', $fileUploaded);	

						$pathInfosFile = pathinfo($file->name);


						$isSave = false;
						$isUploaded = false;


						/* 
						 * Gestion de l'entrée dans la table "files" 
						 */

						// On vérifie si on à déjà un fichier identique (même Hash, même nom)
						if (FileModel::where('hash', $file->hash)->where('path', $file->path)->count()>0) {
							// On enregistre uniquement le fichier
							$isUploaded = true;
						} elseif (FileModel::where('hash', '<>', $file->hash)->where('path', $file->path)->count()>=1) {
							// Un autre fichier avec le même nom existe déjà
							// Recherche d'un nouveau nom
							$cmpt = 1;
							while (FileModel::where('hash', '<>', $file->hash)->where('path', $file->path)->count()>=1) {
								$file->name = $pathInfosFile['filename'].'-'.($cmpt++).'.'.$pathInfosFile['extension'];
								$file->path = $file->name;
							}
						}
					

						/* 
						 * Gestion du fichier sur le serveur 
						 */
						if (!$isUploaded) {
							if ($file->isPicture()) {
								$thumbnailDefault = Config::get('thumbnail.thumbnail_default');
								$thumbnail = Image::make($fileUploaded->getRealPath());
								$thumbnail->resize(1920, 1080, function ($constraint) {
	                                $constraint->aspectRatio();
	                                $constraint->upsize();
	                            });
	                            $isUploaded = $thumbnail->save($destinationPath.'/'.$file->name, 100);
							} else {
								$isUploaded = $fileUploaded->move($destinationPath, $file->name);	
							}
						}

						$isSave = $file->save();
						
						if ($isSave && $isUploaded) {
							return array(
								'file' => $file->toArray()
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
					'template' => '_forms.forms.file',
		            'model' => $file
				)
	        )->add(trans('admin.file.action.save'), 'submit', ['attr' => ['class' => 'btn btn-primary']]);

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
	        		'route' => route('picture', array('show', $file->name))	
	        ), 200));
	    } else {
	    	return (new Response(NULL, 403));
	    }
    }

	public function updateAjax($id, Request $request) {
    	if ($request->ajax()) {
	        $file = FileModel::findOrFail($id);
	        $file->update($request->only('title', 'legend'));
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
    			'value' => trans('admin.file.message.delete', array(
    				'file' => $file->path
    			))
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

    public function getitemfilebrowserAjax(Request $request) {
    	if ($request->ajax()) {
    		$file = FileModel::findOrFail($request->input('file_id'));
    		return view('_forms.fields.file', array('file' => $file));
    	}
    	return (new Response('fileId', 200));
    }


	
}
