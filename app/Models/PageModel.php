<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageModel extends Model
{
    
    protected $table = 'pages';
    protected $fillable = ['name', 'content', 'files'];


    public function files() {
    	return $this->hasMany('App\Models\FileModel', 'model_id');
    }

  	public static function boot() {   
  		
        parent::boot();

        static::saving(function ($page) {
        	$slugCandidateRoot = str_slug($page->name);
        	$slugCandidate = $slugCandidateRoot;
        	$cmptProposal = 0;
        	while(PageModel::where('slug', $slugCandidate)->count()>0) {
        		$slugCandidate = $slugCandidateRoot . '-' . intval(++$cmptProposal);
        	}
           	$page->slug = $slugCandidate;	
        });

        static::deleted(function($page)
        {
            $page->files()->delete();
        });
        
    }

}
