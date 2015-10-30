<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\File;

class FilesComponent extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $data = $request->all();
        varlog($data);
        varlog('FilesComponent');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fileUploadedName = 'file';
        $destinationPath = config('app.uploads_path');
        if (!empty($_FILES)) {
            if ($request->hasFile($fileUploadedName)) {
                if ($request->file($fileUploadedName)->isValid()) {
                    $fileUploaded = $request->file($fileUploadedName);

                    // Create File
                    $file = new File();
                    $file->name = $fileUploaded->getClientOriginalName();
                    $file->path = $destinationPath.'/'.$file->name;
                    $file->type = $fileUploaded->getMimeType();
                    $file->save();

                    // Move uploaded file
                    $fileUploaded->move($destinationPath, $fileUploaded->getClientOriginalName());
                }
            } 
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
