<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DateHelper;
use App\Models\User;


class AjaxController extends Controller
{

	/**
     * @return \Illuminate\Http\Response
     */
    public function days(request $request)
    {	
        $helper = new DateHelper(); 
        
        $remainingDay = $helper->calculate($request->file);

        return response()->json(['result' => $remainingDay]);
        
    }
}
