<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers;

use Kris\LaravelFormBuilder\FormBuilder;

/* My uses */
use App\Models\Page;
use App\Models\File;
use App\Http\Requests\PageRequest;
use DB;


class PagesComponent extends Controller
{

    private $defaultView = 'admin.pages';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::get();
        $page = new Page;
        return view($this->defaultView, array('pages' => $pages));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $page = new Page;

        $form = $formBuilder->create(
            'App\Forms\PageForm', 
            array(
                'method' => 'POST',
                'url' => route('admin.pages.store'),
                'showFieldErrors' => false
            ), 
            array(
                'model_table'=> $page->getTable(),
                'model_id'=> NULL
            )
        );

        return view($this->defaultView, array(
            'page'=>$page,
            'form'=>$form
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
    
        // Create pages
        $page = Page::create($request->only('name', 'content'));

        // Get files added for this pages
        $file = new File();
        $files = $file->whereIn('id', explode(',', $request->input('files')))->get();

        // Save relation
        $page->files()->saveMany($files);

        return redirect(route('admin.pages.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page = Page::findOrFail($id);
        return view($this->defaultView, array('page' => $page));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, FormBuilder $formBuilder)
    {
        $page = new Page;
        $page = $page->with('files')->findOrFail($id);

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
        );
        return view($this->defaultView,  array(
            'page' => $page,
            'form' => $form
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, PageRequest $request)
    {
        $page = Page::findOrFail($id);
        $page->update($request->all());
        return redirect(route('admin.pages.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();
        return redirect(route('admin.pages.index'));
    }
}
