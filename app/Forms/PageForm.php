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
        ->add('name', 'text', array(
            'label'=>trans('admin.page.field.name')
        ))
         ->add('menu', 'select', array(
            'label'=>trans('admin.page.field.menu'),
            'choices' => array(
                'primary'   => trans('admin.page.option.menu.primary'),
                'secondary' => trans('admin.page.option.menu.secondary'),
            )
        ))
        ->add('controller', 'select', array(
            'label'=>trans('admin.page.field.controller'),
            'choices' => array(
                'pages'     => trans('admin.page.option.controller.pages'),
                'galleries' => trans('admin.page.option.controller.galleries'),
            )
        ))
        ->add('content', 'textarea', array(
            'wrapper' => ['class' => 'form-group form-group-wysiwyg'],
            'label'=> trans('admin.page.field.content'),
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
        )

        // Metas datas
        ->add('group-metadatas', 'static', [
            'tag' => 'h2', 
            'attr' => ['class' => 'form-control-static'], 
            'value' => trans('admin.page.form.group.metadatas')
        ])

        ->add('meta-title', 'text', array(
            'wrapper' => ['class' => 'form-group'],
            'label'=> trans('admin.page.field.meta-title'),
            'attr' => array('class' => 'form-control')
        ))
        ->add('meta-description', 'textarea', array(
            'wrapper' => ['class' => 'form-group'],
            'label'=> trans('admin.page.field.meta-description'),
            'attr' => array('class' => 'form-control')
        ))
        ;

    }
}