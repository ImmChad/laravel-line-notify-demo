<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    public $timestamps = false; //set time to false
    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'username',
        'password'
    ];
    protected $primaryKey = 'id';
    protected $table = 'admin';
}
