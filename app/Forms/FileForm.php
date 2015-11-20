<?php namespace App\Forms;

use Kris\LaravelFormBuilder\Form;


class FileForm extends Form
{


    public function buildForm()
    {
    	
    	// Create form
        $this
        ->add('title', 'text', array(
        	'label'=> trans('admin.file.field.title')
        ))
        ->add('legend', 'textarea', array(
        	'label'=> trans('admin.file.field.legend'),
        	'attr' => array(
        		'rows' => 4
        	)
        ));

    }
}