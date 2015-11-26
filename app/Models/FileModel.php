<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/* My uses */
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;

class FileModel extends Model
{

	use SoftDeletes;

	protected $table = 'files';
	protected $dates = ['deleted_at'];
	protected $fillable = array('name', 'title', 'legend', 'path', 'type', 'ordering');

	/* Boot  */
	public static function boot() {   
  		
        parent::boot();

        static::deleted(function($file)
        {
        	$uploadPath = config('app.uploads_path');
        	$thumbnailsPath = Config::get('thumbnail.path');
        	$thumbnailsAvailables = Config::get('thumbnail.thumbnails');

        	$fileFullPath = $uploadPath.'/'.$file->path;

        	// Avant de supprimer le fichier on vérifie s'il n'est pas utilisé ailleurs avec son hash
        	if (FileModel::where('hash', $file->hash)->where('path', $file->path)->count()==0) {
     
        		// Delete file
	        	if (File::exists($fileFullPath)) {
	        		File::delete($uploadPath.'/'.$file->path);	
	        	}
	   
	        	// Delete his thumbnails
	        	foreach ($thumbnailsAvailables as $thumbnailName => $thumbnailDefinition) {
	        		$thumbnailFullPath = $thumbnailsPath.'/'.$thumbnailName.'/'.$file->name;
	        		varlog($thumbnailFullPath);
	        		if (File::exists($thumbnailFullPath)) {
	        			varlog('suppression de : '.$thumbnailFullPath);
	        			File::delete($thumbnailFullPath);	
	        		} else {
	        			varlog('le fichier nexiste pas ');
	        		}
	        	}
	        	
        	} else {
        		// Le fichier est utilisé ailleurs, on ne le supprime pas
        	}

        	
        });
        
    }

	/* Scopes */
	public function scopeOfOrder($query){
		return $query
			->orderBy(DB::raw('ISNULL(ordering)'), 'ASC')
			->orderBy('ordering', 'ASC')
			->orderBy('id', 'ASC');
	}

	/* Relations */
	// No relations here, I don't want get owner of file

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
