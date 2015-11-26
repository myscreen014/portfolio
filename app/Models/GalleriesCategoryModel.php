<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class GalleriesCategoryModel extends Model
{
    
    protected $table = 'gallerycategories';
    protected $fillable = ['category', 'name', 'description'];

    /* Relations */
    public function galleries() {
    	return $this->hasMany('App\Models\GalleryModel', 'category_id');
    }

    public function pictures() {
    	return $this
    		->hasMany('App\Models\FileModel', 'model_id')
    		->where('model_table', 'gallerycategories')
    		->where('model_field', 'pictures');
    }
    
}