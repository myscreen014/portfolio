<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/* My uses */
use Illuminate\Support\Str;
use App\Models\AdministratorModel;
use Kris\LaravelFormBuilder\FormBuilder;

class AdministratorsComponent extends Controller
{

    private $defaultView = 'admin.administrators';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $administrator = new AdministratorModel();
        $administrators = $administrator
            ->get();
        
        return view($this->defaultView, array('administrators' => $administrators));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $administrator = new AdministratorModel;
        $form = $formBuilder->create(
            'App\Forms\AdministratorForm', 
            array(
                'method' => 'POST',
                'url' => route('admin.administrators.store'),
                'model' => $administrator
            ), 
            array()
        )->add(trans('admin.administrators.action.create'), 'submit', ['attr' => ['class' => 'btn btn-success'] ]);


        return view($this->defaultView, array('form' => $form));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $administrator = new AdministratorModel;
        $administrator->name = $request->name;
        $administrator->email = $request->email;
        $administrator->password = bcrypt($request->password);
        $administrator->role = 'admin';
        $administrator->setRememberToken(Str::random(60));
        $administrator->save();
        return redirect(route('admin.administrators.index'));
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
