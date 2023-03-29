<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Seeker
 *
 * @property string $id
 * @property string|null $realname
 * @property string|null $nickname
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 * @property string|null $birthday
 * @property string|null $user_id
 * @property int|null $age_group_id
 * @property int|null $hourly_wage_id
 * @property string|null $personal_message
 * @property int|null $number_working_day
 * @property int|null $number_working_hour
 * @property int|null $benefit
 * @property string|null $current_job
 * @property int|null $year_of_experience
 * @property string|null $pr_comment
 * @property int|null $weight
 * @property int|null $height
 * @property int|null $notification
 * @property string|null $avatar_url
 * @property string|null $profile_url
 * @property SeekerBank $seekerBank
 * @property User|null $user
 * @property StaticYearOfExp|null $yearOfExperience
 * @property StaticHourlyWage|null $hourlyWage
 * @property StaticBenefit|null $staticBenefit
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|Seeker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Seeker newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Seeker query()
 * @method static \Illuminate\Database\Eloquent\Builder|Seeker whereAgeGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seeker whereAvatarUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seeker whereBenefit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seeker whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seeker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seeker whereCurrentJob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seeker whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seeker whereHourlyWageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seeker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seeker whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seeker whereNotification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seeker whereNumberWorkingDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seeker whereNumberWorkingHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seeker wherePersonalMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seeker wherePrComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seeker whereProfileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seeker whereRealname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seeker whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seeker whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seeker whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seeker whereYearOfExperience($value)
 * @mixin \Eloquent
 */
class Seeker extends Model
{
    protected $table = 'seeker';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $casts = [
        'realname' => 'encrypted',
        'birthday' => 'encrypted',
        'age_group_id' => 'int',
        'hourly_wage_id' => 'int',
        'number_working_day' => 'int',
        'number_working_hour' => 'int',
        'benefit' => 'int',
        'year_of_experience' => 'int',
        'weight' => 'int',
        'height' => 'int',
        'notification' => 'int',
        'stations' => 'array',
    ];

    protected $fillable = [
        'id',
        'realname',
        'nickname',
        'birthday',
        'stations',
        'user_id',
        'age_group_id',
        'hourly_wage_id',
        'personal_message',
        'number_working_day',
        'number_working_hour',
        'benefit',
        'current_job',
        'year_of_experience',
        'pr_comment',
        'weight',
        'height',
        'notification',
        'avatar_url',
        'profile_url',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasOne
     */
    public function seekerBank(): HasOne
    {
        return $this->hasOne(SeekerBank::class);
    }

    /**
     * @return BelongsTo
     */
    public function yearOfExperience(): BelongsTo
    {
        return $this->belongsTo(StaticYearOfExp::class, 'year_of_experience', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function hourlyWage(): BelongsTo
    {
        return $this->belongsTo(StaticHourlyWage::class, 'hourly_wage_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function staticBenefit(): BelongsTo
    {
        return $this->belongsTo(StaticBenefit::class, 'benefit', 'id');
    }
}
