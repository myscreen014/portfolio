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
    protected $fillable = ['parent', 'controller', 'menu', 'name', 'content', 'meta-title', 'meta-description'];

    /* Relations */
    public function parent() {
        return $this
            ->hasOne('App\Models\PageModel', 'id');
    }
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


    /* METHODS */
    public static function getTree($menu) {
        $page = new PageModel;
        $allPages = $page->where('menu', $menu)->orderBy('ordering', 'ASC')->get();
        $tree = array();
        $tree = self::getTreeBranch($allPages);
        return $tree;
    }

    public static function getTreeBranch(&$allPages, $parent=NULL) {
        $branch = array();
        foreach ($allPages as $key => $page) {
            if ($page['parent']==$parent) {
                $pageValue = $page->toArray();
                $pageValue['children'] = self::getTreeBranch($allPages, $pageValue['id']);
                array_push($branch, $pageValue);
                unset($allPages[$key]);
            }
        }
        return $branch;
    }


}
