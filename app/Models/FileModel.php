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
            ->orderBy(DB::raw('ISNULL(ordering)'), 'ASC')
            ->orderBy('ordering', 'ASC')
            ->orderBy('id', 'ASC');
    }

  	/* Relations */
    public function page() {
    	return $this->belongsTo('App\Models\PageModel', 'model_id');
    }

    /* Methods */
    public function isPicture() {
    	if (in_array($this->type, array('image/jpeg', 'image/png', 'image/jpg', 'image/gif'))) {
    		return true;
    	}
    	return false;
    }

    public function getIconClass() {
    	$type = $this->type;
    	$iconClass = 'fa-file-o';
        varlog($type);
    	switch ($type) {
    		case 'application/excel':
    			$iconClass = 'fa-file-excel-o';
    			break;
    		case 'application/msword':
    			$iconClass = 'fa-file-word-o';
    			break;
    		break;
    		case "text/rtf":
    			$iconClass = 'fa-file-text-o';
    			break;
    		case "application/pdf":
    			$iconClass = 'fa-file-pdf-o';
    			break;
    	}
    	return $iconClass;
    }


}
