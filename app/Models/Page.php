<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    
 
    protected $fillable = ['name', 'content'];

  	public static function boot() {   
        static::saving(function ($page) {
           $page->slug = str_slug($page->name);
        });
    }

}
