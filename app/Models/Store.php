<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Casts\EncryptCast;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * Class Store
 *
 * @property string $id
 * @property string|null $store_name
 * @property string|null $time_start
 * @property string|null $time_end
 * @property string|null $count_react
 * @property string|null $count_comment
 * @property int|null $business_type_id
 * @property int|null $type_of_permit_id
 * @property string|null $permit_url
 * @property int|null $status_of_business_id
 * @property string|null $expected_opening_date
 * @property int|null $plan_for_publication_id
 * @property string|null $mail_address
 * @property string|null $phone_number
 * @property string|null $contact_admin_number
 * @property string|null $person_in_charge_name
 * @property int|null $address_id
 * @property int|null $attraction_info_id
 * @property string|null $comment
 * @property int|null $option_application_id
 * @property int|null $station_cd
 * @property int|null $area_cd
 * @property int|null $store_status
 * @property string|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $post_status
 * @property string|null $store_links
 * @property string|null $store_title
 * @property string|null $line_notify_link
 * @property string|null $store_introduction
 * @property string|null $store_admin_id
 * @property string|null $nearest_station
 * @property int|null $clothes_type_id
 * @property string|null $clothes_comment
 * @property string|null $homepage_link
 * @property string|null $SNS_link
 * @property int|null $store_manager_id
 * @property Carbon|null $setting_password_at
 * @property int|null $is_published
 * @property string|null $setting_area_detail
 * @property string|null $google_map_setting
 * @property string|null $title_tag_setting
 * @property string|null $h1_setting
 * @property string|null $description_setting
 * @property Carbon|null $grand_opening_date
 * @property string|null $admin_comment
 * @package App\Models
 * @property string|null $publication_reviewer_id
 * @property-read \App\Models\StaticArea|null $staticArea
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Store newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Store newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Store query()
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereAreaCd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereAttractionInfoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereBusinessTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereClothesComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereClothesTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereContactAdminNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereDescriptionSetting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereExpectedOpeningDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereGoogleMapSetting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereGrandOpeningDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereH1Setting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereHomepageLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereLineNotifyLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereMailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereNearestStation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereOptionApplicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store wherePermitUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store wherePersonInChargeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store wherePlanForPublicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store wherePostStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store wherePublicationReviewerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereSNSLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereSettingAreaDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereSettingPasswordAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereStationCd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereStatusOfBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereStoreAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereStoreIntroduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereStoreLinks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereStoreManagerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereStoreName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereStoreStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereStoreTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereTimeEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereTimeStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereTitleTagSetting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereTypeOfPermitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereUserId($value)
 * @mixin \Eloquent
 */
class Store extends Model
{
    protected $table = 'store';
    public $incrementing = false;
    public $keyType = 'string';

    protected $casts = [
        'phone_number'=> EncryptCast::class,
        'mail_address'=> EncryptCast::class,
        'person_in_charge_name'=> EncryptCast::class,
        'contact_admin_number'=> EncryptCast::class,
        'business_type_id' => 'int',
        'type_of_permit_id' => 'int',
        'status_of_business_id' => 'int',
        'plan_for_publication_id' => 'int',
        'address_id' => 'int',
        'attraction_info_id' => 'int',
        'option_application_id' => 'int',
        'station_cd' => 'int',
        'area_cd' => 'int',
        'store_status' => 'int',
        'post_status' => 'int',
        'clothes_type_id' => 'int',
        'store_manager_id' => 'int',
        'is_published' => 'int',
    ];

    protected $dates = [
        'setting_password_at',
    ];

    protected $fillable = [
        'id',
        'store_name',
        'business_type_id',
        'type_of_permit_id',
        'permit_url',
        'status_of_business_id',
        'expected_opening_date',
        'plan_for_publication_id',
        'mail_address',
        'phone_number',
        'contact_admin_number',
        'person_in_charge_name',
        'address_id',
        'attraction_info_id',
        'comment',
        'option_application_id',
        'station_cd',
        'area_cd',
        'store_status',
        'user_id',
        'post_status',
        'store_links',
        'store_title',
        'line_notify_link',
        'store_introduction',
        'store_admin_id',
        'nearest_station',
        'clothes_type_id',
        'clothes_comment',
        'homepage_link',
        'SNS_link',
        'store_manager_id',
        'setting_password_at',
        'is_published',
        'setting_area_detail',
        'google_map_setting',
        'title_tag_setting',
        'h1_setting',
        'description_setting',
        'grand_opening_date',
        'commencement_business_date',
        'admin_comment'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function staticArea(): BelongsTo
    {
        return $this->belongsTo(StaticArea::class, 'area_cd', 'area_cd');
    }

    public function address() : BelongsTo
    {
        return $this->belongsTo(StoreAddress::class, 'address_id', 'id');
    }

    public function businessType() : BelongsTo
    {
        return $this->belongsTo(StaticBusinessType::class, 'business_type_id', 'id');
    }

    public function salary() : HasOne
    {
        return $this->hasOne(StoreSalary::class, 'store_id');
    }

    public function storeFullDayPayment() : HasMany
    {
        return $this->hasMany(StoreFullDayPayment::class, 'store_id');
    }

    public function workingTime() : HasOne
    {
        return $this->hasOne(StoreWorkingTime::class, 'store_id');
    }

    public function storeRegularDayOff(): HasMany
    {
        return $this->hasMany(StoreRegularDayoff::class, 'store_id');
    }

    public function workingGirlsAgeGroups(): HasMany
    {
        return $this->hasMany(StoreWorkingGirlAge::class, 'store_id');
    }

    public function atmosphere() : HasOne
    {
        return $this->hasOne(StoreAtmosphere::class, 'store_id');
    }

    public function nearestStations() : HasMany
    {
        return $this->hasMany(StoreNearestStation::class, 'store_id');
    }

    public function movie() : HasOne
    {
        return $this->hasOne(StoreMovie::class, 'store_id');
    }

    public function costumeImages(): HasMany
    {
        return $this->hasMany(StoreCostumeImage::class, 'store_id');
    }

    public function storeImages(): HasMany
    {
        return $this->hasMany(StoreImage::class, 'store_id');
    }

    public function staffImages(): HasMany
    {
        return $this->hasMany(StoreStaffImage::class, 'store_id');
    }

    public function menuImages(): HasMany
    {
        return $this->hasMany(StoreMenuImage::class, 'store_id');
    }

    public function managerImages(): HasMany
    {
        return $this->hasMany(StoreManagerImage::class, 'store_id');
    }

    public function interiorImages() : HasMany
    {
        return $this->hasMany(StoreInteriorImage::class, 'store_id');
    }

    public function exteriorImages() : HasMany
    {
        return $this->hasMany(StoreExteriorImage::class, 'store_id');
    }

    public function storeManager() : HasOne
    {
        return $this->hasOne(StoreManager::class, 'store_id');
    }

    public function storeCostumeImage() : HasMany
    {
        return $this->hasMany(StoreCostumeImage::class, 'store_id');
    }

    public function storeAreaAdvertisement() : HasMany
    {
        return $this->hasMany(StoreAreaAdvertisement::class, 'store_id');
    }
}
