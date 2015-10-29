<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class File extends Model
{
    //
    public function page() {
    	return $this->belongsTo('App\Models\Page');
    }


}
