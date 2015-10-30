<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class File extends Model
{


	protected $fillable = array('name', 'path', 'type');

    //
    public function page() {
    	return $this->belongsTo('App\Models\Page', 'model_id');
    }


}
