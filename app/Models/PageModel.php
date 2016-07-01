<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/* My uses */
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;

class PageModel extends Model
{
    
    protected $table = 'pages';
    protected $fillable = ['controller', 'menu', 'name', 'content', 'meta-title', 'meta-description'];

    /* Relations */
    public function files() {
    	return $this
            ->hasMany('App\Models\FileModel', 'model_id')
            ->where('model_table', 'pages')
            ->where('model_field', 'files');
    }

    public function pictures() {
        return $this
            ->hasMany('App\Models\FileModel', 'model_id')
            ->where('model_table', 'pages')
            ->where('model_field', 'pictures');
    }

    public function getpictures() {
        return $this;
    }

    /* Scopes */
    public function scopePublished($query){
        return $query
            ->where('publish', 1);
    }

     /* Boot */
    public static function boot() {   
        
        parent::boot();

        static::saving(function ($page) {
            $slugCandidateRoot = str_slug($page->name);
            if (empty($slugCandidateRoot)) {
                $slugCandidateRoot = 'page-'.$page->id;
            }
            $slugCandidate = $slugCandidateRoot;
            $cmptProposal = 0;
            $wheres = array(
                'slug' => $slugCandidate
            );
            while(PageModel::where('slug', $slugCandidate)->where(function($query) use ($page) {
                if (!is_null($page->id)) {
                    return $query->where('id', '<>', $page->id);
                }
            })->count()>0) {
                $slugCandidate = $slugCandidateRoot . '-' . intval(++$cmptProposal);
            }
            $page->slug = $slugCandidate;   
        });

        static::deleted(function($page) {
            foreach($page->pictures()->get() as $file) {
                $file->delete();
            }
        });
        
    }  	

}
