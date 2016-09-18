<?php

namespace CityBoard\Repositories;

use CityBoard\Repositories\RepositoryInterface;
use CityBoard\Entities\LicenseTypeStage;
use Illuminate\Http\Request;


class LicenseTypeStageRepository implements RepositoryInterface
{
    private $licenseStageRepository;
    private $licenseCurrentStageRepository;
    private $licenseRepository;
    private $licenseType;
    private $weight;

    /**
     * LicenseTypeStageRepository constructor.
     */
    public function __construct()
    {
        $this->licenseStageRepository = new LicenseStageRepository();
        $this->licenseCurrentStageRepository = new LicenseCurrentStageRepository();
        $this->licenseRepository = new LicenseRepository();
    }
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return LicenseTypeStage::all();
    }

    /**
     * @param $number
     * @return mixed
     */
    public function paginate($number)
    {
        return LicenseTypeStage::paginate($number);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFailById($id)
    {
        return LicenseTypeStage::findOrFail($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $licenseTypeStage = new LicenseTypeStage();
        return $this->assignValues($request, $licenseTypeStage);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $licenseTypeStage = $this->findOrFailById($id);
        return $this->updateValues($request, $licenseTypeStage);
    }

    /**
     * @return static
     */
    public function selectControl()
    {
        return $this->all()->lists('id', 'id');
    }

    /**
     * @param Request $request
     * @param LicenseTypeStage $licenseTypeStage
     * @return mixed
     */
    private function assignValues(Request $request, LicenseTypeStage $licenseTypeStage)
    {
        $licenseTypeStage->license_type_id = $request->input('license_type_id');
        $licenseTypeStage->license_stage_id = $request->input('license_stage_id');
        $licenseTypeStage->weight = $request->input('weight');
        $licenseTypeStage->previous = $this->processingStage($request->input('previous'));
        $licenseTypeStage->next = $this->processingStage($request->input('next'));
        $licenseTypeStage->license_generate = $this->processingCheckbox($request->input('license_generate'));

        $licenseTypeStage->save();

        return $licenseTypeStage->id;
    }

    /**
     * @param Request $request
     * @param LicenseTypeStage $licenseTypeStage
     * @return mixed
     */
    private function updateValues(Request $request, LicenseTypeStage $licenseTypeStage)
    {
        $licenseTypeStage->license_type_id = $request->input('license_type_id');
        $licenseTypeStage->license_stage_id = $request->input('license_stage_id');
        $licenseTypeStage->weight = $request->input('weight');
        $licenseTypeStage->previous = $this->processingStage($request->input('previous'));
        $licenseTypeStage->next = $this->processingStage($request->input('next'));
        $licenseTypeStage->license_generate = $this->processingCheckbox($request->input('license_generate'));

        $licenseTypeStage->save();

        return $licenseTypeStage->id;
    }

    /**
     * @param $field
     * @return null
     */
    private function processingStage($field)
    {
        if(!$field) {
            return null;
        }

        return $field;
    }

    /**
     * @param $field
     * @return bool
     */
    private function processingCheckbox($field)
    {
        if (!isset($field)) {
            return false;
        }

        return true;
    }

    /**
     * @param $licenseType
     * @return array
     */
    public function stagesForALicenseType($licenseType) {
        $stagesForLicenseType = LicenseTypeStage::where('license_type_id', $licenseType)->orderBy('weight', 'asc')->get();

        $stagesForLicenseTypeAsArray = [];

        foreach ($stagesForLicenseType as $stage) {
            $stagesForLicenseTypeAsArray[] = $stage->licenseStage;
        }

        return $stagesForLicenseTypeAsArray;
    }

    /**
     * @param $licenseType
     * @return array
     */
    public function stagesNotForALicenseType($licenseType)
    {
        $stagesForLicenseType = $this->stagesForALicenseType($licenseType);

        $stagesNotForLicenseTypeAsArray = [];

        $stagesLicense = $this->licenseStageRepository->all();
        foreach ($stagesLicense as $stage) {
            if (!in_array($stage, $stagesForLicenseType)) {
                $stagesNotForLicenseTypeAsArray[] = $stage;
            }
        }

        return $stagesNotForLicenseTypeAsArray;
    }

    /**
     * @param $licenseType
     * @param $response
     */
    public function saveJson($licenseType, $response) {
        LicenseTypeStage::where('license_type_id', $licenseType)->delete();
        $this->weight = 0;
        $this->licenseType = $licenseType;
        array_walk($response, array($this, 'storeStageJson'));
    }

    /**
     * @param $stage
     */
    public function storeStageJson($stage)
    {
        if ($this->weight != 0) {
            $licenseTypeStagePrevious = LicenseTypeStage::where('license_type_id',
              $this->licenseType)->where('weight', $this->weight - 1)->first();
        }
        $licenseTypeStage = new LicenseTypeStage();
        $licenseTypeStage->license_type_id = $this->licenseType;
        $licenseTypeStage->license_stage_id = $stage['id'];
        $licenseTypeStage->weight = $this->weight;

        $licenseTypeStage->previous = NULL;
        if ($this->weight != 0) {
            $licenseTypeStage->previous = $licenseTypeStagePrevious->license_stage_id;
        }

        $licenseTypeStage->next = NULL;
        if ($this->weight != 0) {
            $licenseTypeStagePrevious->next = $stage['id'];
            $licenseTypeStagePrevious->save();
        }

        $licenseTypeStage->license_generate = true;
        if ($this->weight != 0) {
            $licenseTypeStagePrevious->license_generate = false;
            $licenseTypeStagePrevious->save();
        }

        $licenseTypeStage->save();

        $this->weight++;
    }

    /**
     * @param $license_type_id
     * @return mixed
     */
    public function firstStageForLicenseType($license_type_id) {
        return LicenseTypeStage::where('license_type_id', $license_type_id)->orderBy('weight', 'ASC')->first();
    }

    /**
     * @param $license_type_id
     * @param $stage_id
     * @return mixed
     */
    public function nextStageForLicenseType($license_type_id, $stage_id = null) {
        $licenseStageRepository = new LicenseStageRepository();

        if (is_null($stage_id)) {
            $currentStage = $this->firstStageForLicenseType($license_type_id);
        } else {
            $currentStage = LicenseTypeStage::where('license_type_id', $license_type_id)
              ->where('license_stage_id', $stage_id)
              ->first();
        }

        if (is_null($currentStage) || is_null($currentStage->next)) {
            return NULL;
        }

        return $licenseStageRepository->findOrFailById($currentStage->next);
    }

    /**
     * @param $license_id
     * @param $stage_id
     * @return mixed
     */
    public function currentStageForLicenseType($license_id, $stage_id = null)
    {
        if(is_null($stage_id)){
            $stage_id = $this->licenseCurrentStageRepository->currentStage($license_id)->id;
        }
        $license = $this->licenseRepository->findOrFailById($license_id);

        $currentLicenseTypeStage = LicenseTypeStage::where('license_type_id', $license->license_type_id)
          ->where('license_stage_id', $stage_id)
          ->first();
        return $currentLicenseTypeStage;
    }
}