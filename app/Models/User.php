<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class User extends Model
{
    
    const PHOTO_PATH = 'images';

    protected $table = 'users';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'surname',
        'name',
        'email',
        'password',
        'phone_number',
        'photo',
        'category_id',
        'birthday'
    ];

    public $Sortable = [
        'name'
     ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
