<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
  * @method static Builder|NotificationRead whereNotificationId($value)
 */
class NotificationRead extends Model
{
    public $timestamps = false; //set time to false
    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'notification_id',
        'user_id',
        'read_at'
    ];
    protected $primaryKey = 'id';
    protected $table = 'notification_read';
}
