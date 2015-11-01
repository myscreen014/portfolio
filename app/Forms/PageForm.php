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
       	->add('files', 'files', 
            array(
                'model_table' => $this->getData('model_table'),
                'model_id' => $this->getData('model_id'),
            )
        )
        ->add(trans('admin.pages.action.save'), 'submit', ['attr' => ['class' => 'btn btn-success'] ]);
    }
}