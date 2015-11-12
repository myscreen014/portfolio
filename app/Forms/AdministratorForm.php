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
            'label'=>trans('admin.pages.field.name')
        ))->add('email', 'text', array(
            'label'=>trans('admin.pages.field.name')
        ))->add('password', 'text', array(
            'label'=>trans('admin.pages.field.name')
        ));

    }
}