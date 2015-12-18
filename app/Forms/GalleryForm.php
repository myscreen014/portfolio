<?php 

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Models\GalleriesCategoryModel;

/* No rules validation here !! => see GalleryRequest */ 

class GalleryForm extends Form
{


    public function buildForm()
    {

    	// Create form
        $this
        ->add('category_id', 'select', array(
            'label' => trans('admin.gallery.field.category'),
            'choices' => GalleriesCategoryModel::get((array('id', 'name')))->lists('name', 'id')->toArray(),
            'empty_value' => trans('admin.gallery.label.category.select')
        ))
        ->add('name', 'text', array(
            'label'=> trans('admin.gallery.field.name')
        ))
        ->add('description', 'textarea', array(
            'label'=>trans('admin.gallery.field.description'),
            'attr' => array('class' => 'form-control')
        ))
        ->add('pictures', 'files', 
            array(
                'label'=>trans('admin.gallery.field.pictures'),
                'dropzone_acceptedFiles' => 'image/*',
                'model_table' => $this->getData('model_table'),
                'model_field' => 'pictures',
                'model_id' => $this->getData('model_id'),
            )
        );
    }
}