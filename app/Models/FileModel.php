<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileModel extends Model
{

	protected $table = 'files';
	protected $fillable = array('name', 'legend', 'path', 'type');

    //
    public function page() {
    	return $this->belongsTo('App\Models\PageModel', 'model_id');
    }

    public static function test() {
    	varlog('Test');
    }


}
