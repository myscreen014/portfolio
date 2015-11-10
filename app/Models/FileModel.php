<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Illuminate\Support\Facades\DB;

class FileModel extends Model
{

	use SoftDeletes;

	protected $table = 'files';
	protected $dates = ['deleted_at'];
	protected $fillable = array('name', 'legend', 'path', 'type', 'ordering');

	/* Scopes */
	public function scopeOfOrder($query){
        return $query
            ->orderBy('ordering', 'ASC')
            ->orderBy(DB::raw('ISNULL(ordering)'), 'DESC')
            ->orderBy('id', 'ASC');
    }

  	/* Relations */
    public function page() {
    	return $this->belongsTo('App\Models\PageModel', 'model_id');
    }


}
