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

						// On créé le repertoire de destination 	
						if (!File::exists($destinationPath)) {
							File::makeDirectory($destinationPath);
						}

						// On créé l'instance File
						$file = new FileModel();
						$file->name = $fileUploaded->getClientOriginalName();
						$file->path = $modelTable.'/'.$file->name;
						$file->model_table = $modelTable;
						$file->model_field = $modelField;
						$file->model_id = $modelId;
						$file->type = $fileUploaded->getMimeType();
						$file->hash = hash_file('md5', $fileUploaded);	


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
							$pathInfos = pathinfo($file->name);
							$newPath = $file->model_table.'/'.$file->name;
							$cmpt = 1;
							while (FileModel::where('hash', '<>', $file->hash)->where('path', $newPath)->count()>=1) {
								$newName = $pathInfos['filename'].'-'.($cmpt++).'.'.$pathInfos['extension'];
								$newPath = $file->model_table.'/'.$newName;
							}
							$file->name = $newName;
							$file->path = $newPath;
							
						}
						$isSave = $file->save();


						/* 
						 * Gestion du fichier sur le serveur 
						 */
						$isUploaded = $fileUploaded->move($destinationPath, $file->name);
						
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
				$file->update(); 
			}
	    	return (new Response(NULL, 200));
	    } else {
	    	return (new Response(NULL, 403));
	    }
    }

    public function getitemfilebrowserAjax(Request $request) {
    	if ($request->ajax()) {
    		$file = FileModel::findOrFail($request->input('file_id'));
    		return view('_forms.itemfilesfield', array('file' => $file));
    	}
    	return (new Response('fileId', 200));
    }


	
}
