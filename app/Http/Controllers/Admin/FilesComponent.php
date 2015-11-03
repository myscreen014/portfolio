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

class FilesComponent extends Controller
{
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		
		if (!is_null($request->input('model_table')) && !is_null($request->input('model_id'))) {
			$fileUploadedName = 'file';
			$destinationPath = config('app.uploads_path');
			$modelTable = $request->input('model_table');
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

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id, FormBuilder $formBuilder)
	{

		$file = new FileModel;
		$file = $file->findOrFail($id);

		$form = $formBuilder->create(
            'App\Forms\FileForm', 
            array(
				'method' => 'PUT',
				'url' => route('admin.files.update', $id),
	            'model' => $file
			)
        );

        return (new Response(form($form), '200'));

	}

 	/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function update($id, Request $request) // Need FileRequest ???
    {
        $file = FileModel::findOrFail($id);
        $file->update($request->only('legend'));
        return (new Response(NULL, '200'));
    }

	
}
