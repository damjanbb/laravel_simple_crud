<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{


    protected $table = 'categories';
	protected $primaryKey = 'id';
	protected $fillable = [
        'name'
    ];

    public function users()
    {
    	return $this->hasMany(User::class);
    }

    public function getUserIdsAttribute()
    {
    	return $this->users->pluck('id');
    }
}
