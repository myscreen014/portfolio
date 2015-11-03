<?php namespace App\Forms;

use Kris\LaravelFormBuilder\Form;


class FileForm extends Form
{


    public function buildForm()
    {
    	
    	// Create form
        $this
        ->add('legend', 'textarea', array('label'=>trans('admin.files.field.legend')));

    }
}