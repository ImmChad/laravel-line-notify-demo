<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationUserInfo extends Model
{
    public $timestamps = false; //set time to false
    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'displayName',
        'pictureUrl',
        'phone_number',
        'password'
    ];
    protected $primaryKey = 'id';
    protected $table = 'notification_user_info';
}
