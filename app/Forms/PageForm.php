<?php namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

/* No rules validation here !! => see PageRequest */ 

class PageForm extends Form
{


    public function buildForm()
    {
    	// Add custom fields
    	$this->addCustomField('files', 'App\Forms\Fields\FilesType');

    	// Create form
        $this
        ->add('name', 'text', array('label'=>trans('admin.pages.field.name')))
        ->add('content', 'textarea', array('label'=>trans('admin.pages.field.content')))
        ->add('pictures', 'files', 
            array(
                'dropzone_acceptedFiles' => 'image/*',
                'model_table' => $this->getData('model_table'),
                'model_field' => 'pictures',
                'model_id' => $this->getData('model_id'),
            )
        )
      /*  ->add('files', 'files', 
            array(
                'dropzone_acceptedFiles' => 'application/*, text/*, audio/*',
                'model_table' => $this->getData('model_table'),
                'model_field' => 'files',
                'model_id' => $this->getData('model_id'),
            )
        )*/;

    }
}