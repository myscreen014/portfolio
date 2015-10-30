<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    
 
    protected $fillable = ['name', 'content', 'files'];


    public function files() {
    	return $this->hasMany('App\Models\File', 'model_id');
    }

  	public static function boot() {   
  		parent::boot();
        static::saving(function ($page) {
        	$slugCandidateRoot = str_slug($page->name);
        	$slugCandidate = $slugCandidateRoot;
        	$cmptProposal = 0;
        	while(Page::where('slug', $slugCandidate)->count()>0) {
        		$slugCandidate = $slugCandidateRoot . '-' . intval(++$cmptProposal);
        	}
           	$page->slug = $slugCandidate;	
        });
    }

}
