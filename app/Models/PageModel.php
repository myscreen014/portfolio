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

        static::deleted(function($page)
        {
            $page->files()->delete();
        });
        
    }

    /* Methodes */
    public static function loadControllersRoutes() { 
    /* Unused from 25/10/2015 */
        $controllers = DB::table((new PageModel())->getTable())->distinct()->get(array('controller', 'slug'));
        foreach ($controllers as $key => $controller) {
            if ($controller->controller != 'pages') {
                $methods = array_diff(get_class_methods('App\Http\Controllers\Site\\'.ucfirst($controller->controller).'Controller'), get_class_methods('App\Http\Controllers\Controller'));
                $methods = array_reverse($methods); // to load index (first method) latest
                foreach ($methods as $key => $method) {
                    $ref = new \ReflectionMethod('App\Http\Controllers\Site\\'.$controller->controller.'Controller', $method);
                    $parameters = $ref->getParameters();
                    $parametersToUrl = array();
                    foreach ($parameters as $key => $parameter) {
                        if ($parameter->isOptional()) {
                            array_push($parametersToUrl, '{'.$parameter->getName().'?}');
                        } else {
                            array_push($parametersToUrl, '{'.$parameter->getName().'}');
                        }
                    }
                    $parametersRoute = implode('/', $parametersToUrl);
                    $uri = $controller->slug;
                    if ($method != 'index') {
                        $uri .= '/'.$method;
                    }
                    $uri .= (!empty($parametersToUrl)?'/'.$parametersRoute:'');
                    Route::any($uri, array(
                        'as'=>'site.gallery', 
                        'uses' => 'Site\\'.ucfirst($controller->controller).'Controller@'.$method
                        )
                    );
                }
              
            }
        }
    }

  	

}
