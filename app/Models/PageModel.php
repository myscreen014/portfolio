<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/* My uses */
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

class PageModel extends Model
{
    
    protected $table = 'pages';
    protected $fillable = ['controller', 'name', 'content'];

    /* Relations */
    public function files() {
    	return $this->hasMany('App\Models\FileModel', 'file_id');
    }

    public function pictures() {
        return $this->hasMany('App\Models\FileModel', 'file_id');
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
        $controllers = DB::table((new PageModel())->getTable())->distinct()->get(array('controller', 'slug'));
        foreach ($controllers as $key => $controller) {
            if ($controller->controller != 'pages') {
                $methods = array_diff(get_class_methods('App\Http\Controllers\Site\GalleriesController'), get_class_methods('App\Http\Controllers\Controller'));
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
                    Route::any($uri, 'Site\\'.ucfirst($controller->controller).'Controller@'.$method);
                }
              
            }
        }
    }

  	

}
