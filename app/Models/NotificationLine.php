<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationUserLine extends Model
{
    public $timestamps = false;
    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'user_id',
        'line_id',
        'created_at'
    ];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $table = 'notification_user_line';
}
