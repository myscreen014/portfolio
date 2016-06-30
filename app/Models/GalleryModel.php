<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class GalleryModel extends Model
{
    
    protected $table = 'galleries';
    protected $fillable = ['category_id', 'name', 'description'];

    /* Relations */
    public function category() {
    	return $this->belongsTo('App\Models\GalleriesCategoryModel', 'category_id');
    }

    public function pictures() {
        return $this
            ->hasMany('App\Models\FileModel', 'model_id')
            ->where('model_table', 'galleries')
            ->where('model_field', 'pictures');
    }

    /* Scopes */
    public function scopePublished($query){
        return $query
            ->where('publish', 1);
    }

  	/* Boot */
    public static function boot() {   
        
        parent::boot();

        static::saving(function ($gallery) {
            $slugCandidateRoot = str_slug($gallery->name);
            $slugCandidate = $slugCandidateRoot;
            $cmptProposal = 0;
            while(GalleryModel::where('slug', $slugCandidate)->where(function($query) use ($gallery) {
                if (!is_null($gallery->id)) {
                    return $query->where('id', '<>', $gallery->id);
                }
            })->count()>0) {
                $slugCandidate = $slugCandidateRoot . '-' . intval(++$cmptProposal);
            }
            $gallery->slug = $slugCandidate;   
        });

        static::deleted(function($gallery)
        {
            foreach($gallery->pictures()->get() as $file) {
                $file->delete();
            }
        });
        
    }

    
}