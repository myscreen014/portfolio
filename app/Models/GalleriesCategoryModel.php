<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class GalleriesCategoryModel extends Model
{
    
    protected $table = 'gallerycategories';
    protected $fillable = ['category', 'name', 'description'];

    /* Boot  */
    public static function boot() {   
        
        parent::boot();

        static::deleted(function($category) {
            $category->pictures()->delete();
        });

        static::saving(function ($category) {
            $slugCandidateRoot = str_slug($category->name);
            $slugCandidate = $slugCandidateRoot;
            $cmptProposal = 0;
            while(GalleriesCategoryModel::where('slug', $slugCandidate)->where(function($query) use ($category) {
                if (!is_null($category->id)) {
                    return $query->where('id', '<>', $category->id);
                }
            })->count()>0) {
                $slugCandidate = $slugCandidateRoot . '-' . intval(++$cmptProposal);
            }
            $category->slug = $slugCandidate;   
        });
        
    }

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

    /* Scopes */
    public function scopePublished($query){
        return $query
            ->where('publish', 1);
    }
    
}