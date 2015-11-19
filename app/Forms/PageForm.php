<?php 

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

/* No rules validation here !! => see PageRequest */ 

class PageForm extends Form
{


    public function buildForm()
    {

    	// Create form
        $this
        ->add('controller', 'select', array(
            'label'=>trans('admin.page.field.controller'),
            'choices' => array(
                'pages' => 'Controller pages',
                'galleries' => 'Controller galerie',
            )
        ))
        ->add('name', 'text', array(
            'label'=>trans('admin.page.field.name')
        ))
        ->add('content', 'textarea', array(
            'label'=>trans('admin.page.field.content'),
            'attr' => array('class' => 'form-control wysiwyg')
        ))
        ->add('pictures', 'files', 
            array(
                'label'=>trans('admin.page.field.pictures'),
                'dropzone_acceptedFiles' => 'image/*',
                'model_table' => $this->getData('model_table'),
                'model_field' => 'pictures',
                'model_id' => $this->getData('model_id'),
            )
        )
        ->add('files', 'files', 
            array(
                'label'=>trans('admin.page.field.files'),
                'dropzone_acceptedFiles' => 'application/*, text/*, audio/*',
                'model_table' => $this->getData('model_table'),
                'model_field' => 'files',
                'model_id' => $this->getData('model_id'),
            )
        );

    }
}