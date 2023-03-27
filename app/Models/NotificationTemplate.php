<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationTemplate extends Model
{
    public $timestamps = false; //set time to false
    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'template_type',
        'template_name',
        'template_title',
        'template_content',
        'region_id',
        'area_id',
        'industry_id',
        'store_id',
        'created_at'
    ];
    protected $primaryKey = 'id';
    protected $table = 'notification_template';
}
