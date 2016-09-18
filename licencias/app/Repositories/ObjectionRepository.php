<?php

namespace CityBoard\Repositories;

use Carbon\Carbon;
use CityBoard\Entities\File;
use CityBoard\Entities\LicenseCurrentStage;
use CityBoard\Repositories\RepositoryInterface;
use CityBoard\Entities\Objection;
use Illuminate\Http\Request;

use CityBoard\Repositories\FileRepository;

class ObjectionRepository implements RepositoryInterface
{
    private $fileRepository;

    public function __construct()
    {
        $this->fileRepository = new FileRepository();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return Objection::all();
    }

    /**
     * @param $number
     * @return mixed
     */
    public function paginate($number)
    {
        return Objection::paginate($number);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFailById($id)
    {
        return Objection::findOrFail($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $objection = new Objection();
        return $this->assignValues($request, $objection);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $objection = $this->findOrFailById($id);
        return $this->updateValues($request, $objection);
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
     * @param Objection $objection
     * @return mixed
     */
    private function assignValues(Request $request, Objection $objection)
    {
        $objection->license_id = $request->input('license_id');
        $objection->first_person_position_id = $request->input('first_person_position_id');
        if($request->input('second_person_position_id')) {
            $objection->second_person_position_id = $request->input('second_person_position_id');
        }
        $objection->report_date = $request->input('report_date');

        $file = new File();
        $fileId = $this->fileRepository->saveFile($request, $file);

        $objection->file_id = $fileId;

        $objection->save();

        return $objection->id;
    }

    /**
     * @param Request $request
     * @param Objection $objection
     * @return mixed
     */
    private function updateValues(Request $request, Objection $objection)
    {
        $objection->license_id = $request->input('license_id');
        $objection->first_person_position_id = $request->input('first_person_position_id');
        if($request->input('second_person_position_id')) {
            $objection->second_person_position_id = $request->input('second_person_position_id');
        }
        $objection->report_date = $request->input('report_date');

        $objection->file_id = $request->input('file_id');

        if ($request->hasFile('filename')) {
            $file = new File();
            $fileId = $this->fileRepository->saveFile($request, $file);
            $objection->file_id = $fileId;
        }

        $objection->save();

        return $objection->id;
    }

    public function nextTimeLimit(Objection $objection)
    {
        $timeLimitRepository = new TimeLimitRepository();

        $notification = $objection->objectionNotifications()->get()->last();

        if(is_null($notification)) {
            return $timeLimitRepository->next(null);
        }

        return $timeLimitRepository->next($notification->timeLimit->weight);
    }


    /**
     * @param $license_id
     * @param $stage_id
     * @return \CityBoard\Entities\Objection
     */
    public function obtainObjection($license_id, $stage_id) {
        $objection = Objection::where('license_id', $license_id)
          ->where('license_stage_id', $stage_id)
          ->first();

        if (is_null($objection)) {
            $objection = new Objection();

            $objection->license_id = $license_id;
            $objection->license_stage_id = $stage_id;

            $objection->save();

            $licenseCurrentStage = LicenseCurrentStage::where('license_id', $license_id)
              ->where('license_stage_id', $stage_id)
              ->first();

            if (is_null($licenseCurrentStage)) {
                $licenseCurrentStage = new LicenseCurrentStage();
                $licenseCurrentStage->license_id = $license_id;
                $licenseCurrentStage->license_stage_id = $stage_id;
                $licenseCurrentStage->save();
            }

            $licenseCurrentStage->objection_id = $objection->id;
            $licenseCurrentStage->save();
        }

        return $objection;
    }

    /**
     * @param $requestJson
     * @param $objection_id
     * @return \CityBoard\Entities\Objection
     */
    public function saveCloseObjection($requestJson, $objection_id) {
        $objection = $this->findOrFailById($objection_id);
        
        if (isset($requestJson['correction_date']) && ! empty($requestJson['correction_date'])) {
            $objection->correction_date = $requestJson['correction_date'];
        } else {
            $objection->correction_date = NULL;
        }
        
        $objection->save();
        
        $currentStage = LicenseCurrentStage::where('license_id', $objection->license_id)
            ->where('license_stage_id', $objection->license_stage_id)
            ->first();
        $currentStage->objection_id = null;
        $currentStage->save();

        return $objection;
    }

    /**
     * @param $objection_id
     * @return \CityBoard\Entities\Objection
     */
    public function saveOpenObjection($objection_id) {
        $objection = $this->findOrFailById($objection_id);

        $objection->correction_date = null;
        $objection->save();

        $currentStage = LicenseCurrentStage::where('license_id', $objection->license_id)
          ->where('license_stage_id', $objection->license_stage_id)
          ->first();
        $currentStage->objection_id = $objection->id;
        $currentStage->save();

        return $objection;
    }

}