<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Casts\EncryptCast;

/**
 * Class User
 *
 * @property string $id
 * @property string|null $email
 * @property string|null $password
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property int $role
 * @property string|null $deleted_at
 * @property Carbon|null $email_verified_at
 * @property Carbon|null $subcontracting_accepted_at
 * @property string|null $ip
 * @property string|null $info
 * @property int|null $old_id
 * @property string|null $owner_id
 * @property Carbon|null $account_closed_at
 * @property string|null $phone_number_landline
 * @property Carbon|null $anonymized_at
 * @property bool|null $uses_strict_ips
 * @property string|null $registration_reason
 * @property bool|null $close_account_email_sent
 * @property bool|null $uses_independent_limits
 * @property string|null $usage_direction
 * @property Carbon|null $otp_verified_at
 * @property string|null $remember_token
 * @property string|null $login_id
 * @property Collection|Admin[] $admins
 * @property Collection|Authentication[] $authentications
 * @property Collection|Conversation[] $conversations
 * @property Collection|OtpRequest[] $otp_requests
 * @property OtpSetting $otp_setting
 * @property Collection|Seeker[] $seekers
 * @property Collection|SeekerExpectCostume[] $seekerExpectCostumes
 * @property Collection|SeekerExpectLocation[] $seekerExpectLocations
 * @property Collection|SeekerExpectIndustry[] $seekerExpectIndustries
 * @property UserGuide $user_guide
 * @property Store $store
 * @property Seeker $seeker
 * @package App\Models
 * @mixin Builder
 * @property-read int|null $admins_count
 * @property-read int|null $authentications_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read int|null $otp_requests_count
 * @property-read int|null $seeker_expect_costumes_count
 * @property-read int|null $seeker_expect_industries_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereAccountClosedAt($value)
 * @method static Builder|User whereAnonymizedAt($value)
 * @method static Builder|User whereCloseAccountEmailSent($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereDeletedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereInfo($value)
 * @method static Builder|User whereIp($value)
 * @method static Builder|User whereLoginId($value)
 * @method static Builder|User whereOldId($value)
 * @method static Builder|User whereOtpVerifiedAt($value)
 * @method static Builder|User whereOwnerId($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePhoneNumberLandline($value)
 * @method static Builder|User whereRegistrationReason($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereRole($value)
 * @method static Builder|User whereSubcontractingAcceptedAt($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUsageDirection($value)
 * @method static Builder|User whereUsesIndependentLimits($value)
 * @method static Builder|User whereUsesStrictIps($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

//    use SoftDeletes;
    protected $table = 'user';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'email' => EncryptCast::class,
        'phone_number_landline' => EncryptCast::class,
        'login_id' => EncryptCast::class,
        'role' => 'int',
        'old_id' => 'int',
        'uses_strict_ips' => 'bool',
        'close_account_email_sent' => 'bool',
        'uses_independent_limits' => 'bool',
        'blocked_at' => 'datetime',
    ];

    protected $dates = [
        'email_verified_at',
        'subcontracting_accepted_at',
        'account_closed_at',
        'anonymized_at',
        'otp_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $fillable = [
        'id',
        'email',
        'password',
        'role',
        'email_verified_at',
        'subcontracting_accepted_at',
        'ip',
        'info',
        'old_id',
        'owner_id',
        'account_closed_at',
        'phone_number_landline',
        'anonymized_at',
        'uses_strict_ips',
        'registration_reason',
        'close_account_email_sent',
        'uses_independent_limits',
        'usage_direction',
        'otp_verified_at',
        'remember_token',
        'login_id',
        'blocked_at',
    ];

    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class);
    }

    public function authentications(): HasMany
    {
        return $this->hasMany(Authentication::class);
    }

    public function otp_requests(): HasMany
    {
        return $this->hasMany(OtpRequest::class);
    }

    public function otp_setting(): HasOne
    {
        return $this->hasOne(OtpSetting::class);
    }

    public function seekers(): HasOne
    {
        return $this->hasOne(Seeker::class);
    }

    public function seekerExpectCostumes(): BelongsToMany
    {
        return $this->belongsToMany(StaticCostume::class, 'seeker_expect_costume', 'user_id', 'costume_id');
    }

    public function seekerExpectLocations(): BelongsToMany
    {
        return $this->belongsToMany(StaticArea::class, 'seeker_expect_location', 'user_id', 'area_id');
    }

    public function seekerExpectIndustries(): HasMany
    {
        return $this->hasMany(SeekerExpectIndustry::class);
    }

    public function user_guide(): HasOne
    {
        return $this->hasOne(UserGuide::class);
    }

    public function store(): HasOne
    {
        return $this->hasOne(Store::class);
    }

    public function seeker(): HasOne
    {
        return $this->hasOne(Seeker::class);
    }

    public function admin(): HasOne
    {
        return $this->HasOne(Admin::class);
    }
}
