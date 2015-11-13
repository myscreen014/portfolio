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
            'label'=>trans('admin.users.field.name')
        ))->add('email', 'text', array(
            'label'=>trans('admin.users.field.email')
        ))->add('password', 'password', array(
            'label'=>trans('admin.users.field.password')
        ))->add('password_confirmation', 'password', array(
            'label'=>trans('admin.users.field.password_confirmation')
        ));

    }
}