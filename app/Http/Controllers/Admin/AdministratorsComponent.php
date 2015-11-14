<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/* My uses */
use App\Http\Requests\AdministratorRequest;
use Illuminate\Support\Str;
use App\Models\AdministratorModel;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use Event;
use App\Listeners\UserEventListener;

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
		$administrators = $administrator->get();
		
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
		)->add(trans('admin.administrators.action.create'), 'submit', array(
			'attr' => array('class' => 'btn btn-success'),
			'wrapper' => array('class' => 'form-group actions'),
			'others_actions' => array(
				'back' => array(
					'value' => trans('admin.global.action.back'), 
					'class' => 'btn-default',
					'url' => route('admin.administrators.index')
				)
			)
		));


		return view($this->defaultView, array('form' => $form));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(AdministratorRequest $request)
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
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id, FormBuilder $formBuilder)
	{
		$administrator = AdministratorModel::findOrFail($id);

		$form = $formBuilder->create(
			'App\Forms\AdministratorForm', 
			array(
				'method' => 'PUT',
				'url' => route('admin.administrators.update', $id),
				'model' => $administrator
			)
		)->remove('password')->remove('password_confirmation')->add(trans('admin.administrators.action.update'), 'submit', array(
			'attr' => array('class' => 'btn btn-primary'),
			'wrapper' => array('class' => 'form-group actions'),
			'others_actions' => array(
                'back' => array(
                    'value' => trans('admin.global.action.back'), 
                    'class' => 'btn-default',
                    'url' => route('admin.administrators.index')
                )
            )
		));

		return view($this->defaultView, array('form' => $form));
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
		$administrator = AdministratorModel::findOrFail($id);
		$administrator->update($request->only('name', 'email'));

		Session::flash('feedback', array(
			'message'=> trans('admin.global.feedback.update.ok'),
			'type' => 'success'
		));

		return redirect(route('admin.administrators.index'));
	}


	public function delete($id) {
		if (Auth::user()->id == $id) {
			Session::flash('feedback', array(
				'message'=> trans('admin.administrators.feedback.delete.suicide'),
				'type' => 'warning'
			));
			return redirect(route('admin.administrators.index'));
		}
		$administrator = AdministratorModel::findOrFail($id);
		return view($this->defaultView,  array(
			'administrator' => $administrator
		));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$administrator = AdministratorModel::findOrFail($id);
		$administrator->delete();
		Session::flash('feedback', array(
			'message'=> trans('admin.global.feedback.delete.ok'),
			'type' => 'success'
		));
		return redirect(route('admin.administrators.index'));
	}
}
