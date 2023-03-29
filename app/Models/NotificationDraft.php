<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationDraft extends Model
{
    public $timestamps = false; //set time to false
    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'notification_for',
        'notification_title',
        'notification_content',
        'area_id',
        'industry_id',
        'sms_user',
        'line_user',
        'mail_user',
        'created_at'
    ];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $table = 'notification_draft';
}
