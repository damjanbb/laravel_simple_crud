<?php

namespace App\Models;

use App\Models\User;
use Carbon\Carbon;


class DateHelper 

{

	public function calculate($file)	
	{  
        
        $newfile = Carbon::parse($file);
        

        $currentYear = $newfile->year(date('Y'));
        $diffInDays = Carbon::now()->diffInDays($newfile, false);
        $remainingDays = $diffInDays;
        
        if ($diffInDays < 0) {
            $currentYear->addYears(1);
            $remainingDays = Carbon::now()->diffInDays($newfile, false);  
        }

		return $remainingDays;
	}
}
