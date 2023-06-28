<?php

namespace App\Models;

use App\Filters\InvestigatorFilters\AddressFilter;
use App\Filters\InvestigatorFilters\CityFilter;
use App\Filters\InvestigatorFilters\DistanceFilter;
use App\Filters\InvestigatorFilters\LanguageFilter;
use App\Filters\InvestigatorFilters\LicenseFilter;
use App\Filters\InvestigatorFilters\MiscFilter;
use App\Filters\InvestigatorFilters\ServiceTypeFilter;
use App\Filters\InvestigatorFilters\ServiceTypeMiscFilter;
use App\Filters\InvestigatorFilters\ServiceTypeStatementsFilter;
use App\Filters\InvestigatorFilters\ServiceTypeSurveillanceFilter;
use App\Filters\InvestigatorFilters\StateFilter;
use App\Filters\InvestigatorFilters\StatementFilter;
use App\Filters\InvestigatorFilters\SurveillanceFilter;
use App\Filters\InvestigatorFilters\ZipcodeFilter;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Roles
    const ADMIN        = 1;
    const COMPANYADMIN = 2;
    const INVESTIGATOR = 3;
    const HR           = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'role',
        'phone',
        'address',
        'address_1',
        'city',
        'state',
        'country',
        'zipcode',
        'password',
        'is_investigator_profile_submitted',
        'lat',
        'lng',
        'bio'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'company_is_admin'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userRole()
    {
        return $this->belongsTo(Role::class, 'role', 'id');
    }

    /* Check if logged in user is company admin or not */
    public function getCompanyIsAdminAttribute(): bool
    {
        /* If logged in user role is admin or investigator. Then return false as user can't be company admin. */
        if (Auth::user()->role === USER::ADMIN || Auth::user()->role === USER::INVESTIGATOR) {
            return false;
        }

        /* If logged in user is in parent_id, then logged in user is company admin else not an company admin */
        return  CompanyUser::where('parent_id', Auth::id())->exists();
    }

    /**
     * Get the investigator's service lines.
     * @return HasMany
     */
    public function investigatorServiceLines(): HasMany
    {
        return $this->hasMany(InvestigatorServiceLine::class);
    }

    public function CompanyAdminProfile(): HasOne
    {
        return $this->hasOne(CompanyAdminProfile::class);
    }


    /**
     * Get the investigator's review.
     * @return HasOne
     */
    public function investigatorReview(): HasOne
    {
        return $this->hasOne(InvestigatorReview::class);
    }

    /**
     * Get the investigator's equipment.
     * @return HasOne
     */
    public function investigatorEquipment(): HasOne
    {
        return $this->hasOne(InvestigatorEquipment::class);
    }

    /**
     * Get the investigator's licenses.
     * @return HasMany
     */
    public function investigatorLicenses(): HasMany
    {
        return $this->hasMany(InvestigatorLicense::class);
    }

    /**
     * Get the investigator's work vehicles.
     * @return HasMany
     */
    public function investigatorWorkVehicles(): HasMany
    {
        return $this->hasMany(InvestigatorWorkVehicle::class);
    }

    /**
     * Get the investigator's languages.
     * @return HasMany
     */
    public function investigatorLanguages(): HasMany
    {
        return $this->hasMany(InvestigatorLanguage::class);
    }

    /**
     * Get the investigator's document.
     * @return HasOne
     */
    public function investigatorDocument(): HasOne
    {
        return $this->hasOne(InvestigatorDocument::class);
    }

    /**
     * Get the investigator's availability.
     * @return HasOne
     */
    public function investigatorAvailability(): HasOne
    {
        return $this->hasOne(InvestigatorAvailability::class);
    }

    public function investigatorBlockedCompanyAdmins(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'investigator_blocked_company_admins',
            'investigator_id',
            'company_admin_id'
        );
    }

    public function companyAdminBlockedInvestigators()
    {
        return $this->belongsToMany(
            User::class,
            'investigator_blocked_company_admins',
            'company_admin_id',
            'investigator_id'
        );
    }

    // Check from pivot table
    public function checkIsBlockedCompanyAdmin($user_id)
    {
        return $this->investigatorBlockedCompanyAdmins->contains('id', $user_id);
    }

    public function checkIsBlockedInvestigator($user_id)
    {
        return $this->companyAdminBlockedInvestigators->contains('id', $user_id);
    }

    // Filter method through pipeline
    public static function investigatorFiltered($request)
    {

        $user = Auth::user();
        /* Assuming logged in user as Company Admin */
        $companyId = $user->id;
        $userRole = $user->role;
        /* If logged in user's role is sub admin or HR. Then get the company id of the logged in user */
        if (($userRole === USER::COMPANYADMIN && !$user->company_is_admin) || $userRole === USER::HR) {
            $companyId = CompanyUser::where('user_id', $user->id)->select('parent_id')->first()->parent_id;
        }

        $query = self::query()
            ->with([
                'investigatorServiceLines',
                'investigatorLicenses',
                'investigatorLanguages',
                'investigatorReview',
                'investigatorAvailability',
                'investigatorBlockedCompanyAdmins'
            ])->where('zipcode', '!=', null)
            ->where('lat', '!=', null)
            ->where('lng', '!=', null)
            ->whereHas('userRole', function ($q) {
                $q->where('role', 'investigator');
            })
            // check companyId is in blocked list or not
            ->whereDoesntHave('investigatorBlockedCompanyAdmins', function ($q) use ($companyId) {
                $q->where('company_admin_id', $companyId);
            })
            // Get calculated distance from lat lng
            ->selectRaw(
                'users.*, ST_Distance_Sphere(point(users.lng, users.lat), point(?, ?)) * .000621371192 as calculated_distance',
                [request('lng'), request('lat')]
            )
            ->join('investigator_availabilities', 'investigator_availabilities.user_id', '=', 'users.id')
            // check investigators distance within calculated distance
            ->whereRaw(
                'ST_Distance_Sphere(point(users.lng, users.lat), point(?, ?)) * .000621371192 <= investigator_availabilities.distance',
                [request('lng'), request('lat')]
            );

        return app(Pipeline::class)
            ->send($query)
            ->through([
                new LicenseFilter($request),
                new LanguageFilter($request),
                new ServiceTypeFilter($request)
            ])
            ->thenReturn();
    }

    public function getServiceType($service_type)
    {
        return $this->investigatorServiceLines()->where('investigation_type', $service_type)->first();
    }

}
