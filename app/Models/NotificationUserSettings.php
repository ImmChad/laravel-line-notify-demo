<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationUserSettings extends Model
{
    public $timestamps = false; //set time to false
    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'user_id',
        'address',
        'notification_channel_id',
        'created_at',
        'updated_at'
    ];
    protected $primaryKey = 'id';
    protected $table = 'notification_user_settings';
}
