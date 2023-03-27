<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationCampaignWaiting extends Model
{
    public $timestamps = false; //set time to false
    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'notification_title',
        'notification_content',
        'sms_user',
        'line_user',
        'mail_user',
        'created_at'
    ];
    protected $primaryKey = 'id';
    protected $table = 'notification_draft';
}
