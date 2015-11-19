<?php namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

/* No rules validation here !! => see PageRequest */ 

class AdministratorForm extends Form
{


    public function buildForm()
    {

    	// Create form
        $this
        ->add('name', 'text', array(
            'label'=>trans('admin.user.field.name')
        ))->add('email', 'text', array(
            'label'=>trans('admin.user.field.email')
        ))->add('password', 'password', array(
            'label'=>trans('admin.user.field.password')
        ))->add('password_confirmation', 'password', array(
            'label'=>trans('admin.user.field.password_confirmation')
        ));

    }
}