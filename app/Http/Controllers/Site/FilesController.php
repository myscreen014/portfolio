<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\FileModel;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Config;

use Illuminate\Support\Facades\Cache;

class FilesController extends Controller
{

	public function file($fileName)
	{
		$uploadPath =  Config::get('app.uploads_path');
		if (File::exists($uploadPath.'/'.$fileName)) {
			$fileContent = File::get($uploadPath.'/'.$fileName);
			$response = new Response($fileContent);
			$response->header('Content-Type', File::mimeType($uploadPath.'/'.$fileName));
			return $response;
		} else {
			abort(403);
		}
	}
	
	public function picture($thumbnailName=NULL, $fileName)
	{
		/* La thumbnails n'existe pas, le .htaccess nous redirige ici */

		$uploadPath =  Config::get('app.uploads_path');
		$thumbnailsDir = Config::get('thumbnail.path').'/'.$thumbnailName;

		if (!File::exists(Config::get('thumbnail.path'))) {
			File::makeDirectory(Config::get('thumbnail.path'));
		}

		if (File::exists($uploadPath.'/'.$fileName)) {
			$thumbnailsAvailables = Config::get('thumbnail.thumbnails');
			if (in_array($thumbnailName, array_keys($thumbnailsAvailables))) {
				if (!File::exists($thumbnailsDir)) {
					File::makeDirectory($thumbnailsDir);
				}

				$thumbnail = Image::make($uploadPath.'/'.$fileName);
				foreach ($thumbnailsAvailables[$thumbnailName]['filters'] as $filter => $filterParams) {
					switch ($filter) {

						// Custom filters
						case 'max':
							$thumbnail->resize($filterParams[0], $filterParams[1], function ($constraint) {
								$constraint->aspectRatio();
								$constraint->upsize();
							});
							break;
						case 'watermark':
							if (file_exists($filterParams[0])) {
								$watermark = Image::make($filterParams[0]);
								$watermark->resize($thumbnail->width(), null, function ($constraint) {
    								$constraint->aspectRatio();
								});
								$thumbnail->insert(
									$watermark, 
									(isset($filterParams[1])?$filterParams[1]:'center'),
									(isset($filterParams[2])?$filterParams[2]:0),
									(isset($filterParams[3])?$filterParams[3]:0)
								);
							}
							break;
						default:  // default filters
							call_user_func_array(array($thumbnail, $filter), array_values($filterParams));
							break;
				   }
				   
				}
				
				

				$thumbnail->save(
					$thumbnailsDir.'/'.$fileName,
					(isset($thumbnailsAvailables[$thumbnailName]['quality']) ? $thumbnailsAvailables[$thumbnailName]['quality'] : Config::get('thumbnail.quality') )
				);
				$fileContent = File::get($thumbnailsDir.'/'.$fileName);
			} else {
				return new Response('', 404);
			}
		} else {
			return new Response('', 404);
		}

		$response = new Response($fileContent);
		$response->header('Content-Type', File::mimeType($uploadPath.'/'.$fileName));
		return $response;
	  
	}


}
