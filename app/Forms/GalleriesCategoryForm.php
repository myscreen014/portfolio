<?php 

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Models\GalleriesCategoryModel;

/* No rules validation here !! => see GalleryRequest */ 

class GalleriesCategoryForm extends Form
{


    public function buildForm()
    {

    	// Create form
        $this
        ->add('name', 'text', array(
            'label'=> trans('admin.galleriescategory.field.name')
        ))
        ->add('description', 'textarea', array(
            'label'=>trans('admin.galleriescategory.field.description'),
            'attr' => array('class' => 'form-control wysiwyg')
        ));
    }
}