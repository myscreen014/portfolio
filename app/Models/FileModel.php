<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileModel extends Model
{

	use SoftDeletes;

	protected $table = 'files';
	protected $dates = ['deleted_at'];
	protected $fillable = array('name', 'legend', 'path', 'type');

    //
    public function page() {
    	return $this->belongsTo('App\Models\PageModel', 'model_id');
    }


}
