<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers;
use App\Models\FileModel;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Config;

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_thumbnail)
    {
    	$fileInfos = explode('.', $id_thumbnail);
    	$fileId = $fileInfos[0];

    	$file = FileModel::findOrFail($fileId);

        $uploadPath = config('app.uploads_path');
      
    	/* Thumbnail ? */
    	if (isset($fileInfos[1])) {
            $thumbnailName = $fileInfos[1]; 
            $thumbnailsDir = base_path().'/uploads'.Config::get('thumbnail.path');

            if (File::exists($thumbnailsDir.'/'.$thumbnailName.'-'.$file->name)) {
                $fileContent = File::get($thumbnailsDir.'/'.$thumbnailName.'-'.$file->name);
            } else {
                if (File::exists($uploadPath.'/'.$file->path)) {
                    $thumbnailsAvailables = Config::get('thumbnail.thumbnails');
                    if (in_array($thumbnailName, array_keys($thumbnailsAvailables))) {
                        
                        if (!File::exists($thumbnailsDir)) {
                            File::makeDirectory($thumbnailsDir);
                        }

                        $thumbnail = Image::make($uploadPath.'/'.$file->path);
                        foreach ($thumbnailsAvailables[$thumbnailName]['filters'] as $filter => $filterParams) {
                            switch ($filter) {

                                // Custom filters
                                case 'max':
                                    $thumbnail->resize($filterParams[0], $filterParams[1], function ($constraint) {
                                        $constraint->aspectRatio();
                                        $constraint->upsize();
                                    });
                                    break;
                                default:  // default filters
                                    call_user_func_array(array($thumbnail, $filter), array_values($filterParams));
                                    break;
                           }
                           
                        }
                        $thumbnail->save(
                            $thumbnailsDir.'/'.$thumbnailName.'-'.$file->name,
                            (isset($thumbnailsAvailables[$thumbnailName]['quality']) ? $thumbnailsAvailables[$thumbnailName]['quality'] : Config::get('thumbnail.quality') )
                        );
                        $fileContent = File::get($thumbnailsDir.'/'.$thumbnailName.'-'.$file->name);
                    } else {
                         $fileContent = File::get($uploadPath.'/'.$file->path);
                    }
                } else {
                     return new Response('', 404);
                }
            }
    	} else {
            return new Response('', 404);
        } 

        $response = new Response($fileContent);
        $response->header('Content-Type', 'image/jpeg');
        return $response;
      
    }


}
