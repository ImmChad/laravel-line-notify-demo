<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public $timestamps = false; //set time to false
    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'type',
        'announce_title',
        'announce_content',
        'created_at',
        'is_sent',
        'is_scheduled',
        'scheduled_at',
        'deleted_at'
    ];
    protected $primaryKey = 'id';
    protected $table = 'notification';
}
