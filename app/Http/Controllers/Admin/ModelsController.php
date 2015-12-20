<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers;

/* My uses */
use Illuminate\Http\Response;


class ModelsController extends Controller
{

	public function reorderAjax(Request $request) {
    	if ($request->ajax()) {
    		$model = 'App\Models\\'.$request->input('model').'Model';
	    	$itemIds = $request->input('itemsIds');
	  		$itemOrder = array_flip($itemIds);
	    	$items = $model::whereIn('id', $itemIds)->get();
			foreach ($items as $key => $item) {
				$item->ordering = $itemOrder[$item->id];
				$item->update(); 
			}
	    	return (new Response(NULL, 200));
	    } else {
	    	return (new Response(NULL, 403));
	    }
    }

    public function publishAjax(Request $request) {
    	if ($request->ajax()) {
    		$model = 'App\Models\\'.$request->input('model').'Model';
	    	$itemId = $request->input('itemId');
	    	$item = $model::findOrFail($itemId);
			$item->publish = !$item->publish;
			$item->update(); 
	    	return (new Response((int)$item->publish, 200));
	    } else {
	    	return (new Response(NULL, 403));
	    }
    }

}
