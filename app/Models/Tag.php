<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
	protected $primaryKey = 'id';
	protected $fillable = [
        'name'
    ];

    public function users()
    {
    	return $this->belongsToMany(User::class);
    }
}


