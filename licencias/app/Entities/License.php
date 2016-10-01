<?php

namespace CityBoard\Entities;

use Illuminate\Database\Eloquent\Model;
use CityBoard\Repositories\LicenseCurrentStageRepository;

class License extends Model
{
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
      'finished' => 'boolean',
      'on_query' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
      'on_loan',
      'active_loan',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'activity_id',
        'archive_id',
        'license_type_id',
        'titular_id',
        'expedient_number',
        'register_number',
        'register_date',
        'finished',
        'street',
        'street_number',
        'postcode',
        'city',
        'archive_location',
        'year',
        'number',
        'identifier',
        'last_current_stage_id',
        'visit_status',
        'license_status_id',
        'volume_year',
        'closet',
        'on_query',
        'commerce_name',// Se agrega el campo trade_name
    ];

    protected $licenseCurrentStageRepository;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->licenseCurrentStageRepository = new LicenseCurrentStageRepository();
    }

    /**
     * A License belongs to Activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function activity()
    {
        return $this->belongsTo('CityBoard\Entities\Activity');
    }

    /**
     * A License belongs to Archive.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function archive()
    {
        return $this->belongsTo('CityBoard\Entities\Archive');
    }

    /**
     * A License belongs to Street.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function street()
    {
        return $this->belongsTo('CityBoard\Entities\Street');
    }

    /**
     * A License belongs to LicenseType.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function licenseType()
    {
        return $this->belongsTo('CityBoard\Entities\LicenseType');
    }

    /**
     * A License belongs to Titular.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function titular()
    {
        return $this->belongsTo('CityBoard\Entities\Titular');
    }

    /**
     * A License has Many TitularityChange.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function titularChanges()
    {
        return $this->hasMany('CityBoard\Entities\TitularityChange');
    }

    /**
     * A License has Many Loan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loans()
    {
        return $this->hasMany('CityBoard\Entities\Loan');
    }

    public function getTitularityChangeActiveAttribute() {
        return $this->titularChanges->where('status', 'Solicitado')->count() > 0;
    }

    /**
     * A License has Many Denunciations.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function denunciations()
    {
        return $this->hasMany('CityBoard\Entities\Denunciation');
    }
    public function getDenunciationActiveAttribute() {
        return $this->denunciations->where('', 'Solicitado')->count() > 0;
    }

    /**
     * A License has Many LicenseCurrentStage.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function licenseCurrentStages()
    {
        return $this->hasMany('CityBoard\Entities\LicenseCurrentStage');
    }

    /**
     * A License belongs To LicenseStatus.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function licenseStatus()
    {
        return $this->belongsTo('CityBoard\Entities\LicenseStatus');
    }
    
    /**
     * license_data_current_stage
     *
     * @return integer
     */
    public function getLicenseDataCurrentStageAttribute()
    {
        if(is_null($this->last_current_stage_id)) {
            return null;
        } else {
            $current_stage_data = $this->licenseCurrentStageRepository->findOrFailById($this->last_current_stage_id);
            $stage_id = $current_stage_data->licenseStage->id;
        }

        return $this->licenseCurrentStageRepository->stageData($this->id, $stage_id);
    }

    /**
     * current_stage
     *
     * @return integer
     */
    public function getCurrentStageAttribute()
    {
        if(is_null($this->last_current_stage_id)) {
            $current_stage = $this->licenseCurrentStageRepository->currentStage($this->id);
            $stage_id = $current_stage->id;
        } else {
            $current_stage_data = $this->licenseCurrentStageRepository->findOrFailById($this->last_current_stage_id);
            $stage_id = $current_stage_data->licenseStage->id;
        }

        return $this->licenseCurrentStageRepository->currentStage($this->id, $stage_id);
    }

    /**
     * register_date_output
     *
     * @return bool|string
     */
    public function getRegisterDateOutputAttribute()
    {
        if (is_null($this->register_date)) {
            return "";
        }

        return date('d-m-Y', strtotime($this->register_date));
    }

    /**
     * activity_name
     *
     * @return integer
     */
    public function getActivityNameAttribute()
    {
        if (is_null($this->activity)) return null;

        return $this->activity->name;
    }

    /**
     * street_name
     *
     * @return integer
     */
    public function getStreetNameAttribute()
    {
        if (is_null($this->street)) return null;

        return $this->street->name;
    }
    
    /**
     * titular_nif
     *
     * @return integer
     */
    public function getTitularNifAttribute()
    {
        if (is_null($this->titular)) return null;

        return $this->titular->nif;
    }

    /**
     * titular_first_name
     *
     * @return integer
     */
    public function getTitularFirstNameAttribute()
    {
        if (is_null($this->titular)) return null;

        return $this->titular->first_name;
    }

    /**
     * titular_first_name
     *
     * @return integer
     */
    public function getTitularLastNameAttribute()
    {
        if (is_null($this->titular)) return null;

        return $this->titular->last_name;
    }

    /**
     * titular_phone_number
     *
     * @return integer
     */
    public function getTitularPhoneNumberAttribute()
    {
        if (is_null($this->titular)) return null;

        return $this->titular->phone_number;
    }

    /**
     * titular_phone_number
     *
     * @return integer
     */
    public function getTitularEmailAttribute()
    {
        if (is_null($this->titular)) return null;

        return $this->titular->email;
    }
    
    /**
     * license_date
     * 
     * @return date
     */
    public function getLicenseDateAttribute() {
        $lastStageData = $this->licenseCurrentStages->where('license_generate', '1')->first();

        if(is_null($lastStageData)) return null;

        return $lastStageData->date;
    }

    /**
     * Get if the license is loans
     *
     * @return bool
     */
    public function getOnLoanAttribute()
    {
        return $this->loans->where('giving_back_date', null)->count() > 0;
    }

    /**
     * Get the active loan for a license
     *
     * @return bool
     */
    public function getActiveLoanAttribute()
    {
        return $this->loans->where('giving_back_date', null)->first();
    }

    /**
     * A License has Many Alert.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alert()
    {
        return $this->hasMany('CityBoard\Entities\Alert');
    }
}
