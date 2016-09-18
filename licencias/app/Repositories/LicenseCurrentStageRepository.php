<?php

namespace CityBoard\Repositories;

use CityBoard\Entities\File;
use CityBoard\Entities\Objection;
use CityBoard\Repositories\RepositoryInterface;
use CityBoard\Entities\LicenseCurrentStage;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class LicenseCurrentStageRepository implements RepositoryInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return LicenseCurrentStage::all();
    }

    /**
     * @param $number
     * @return mixed
     */
    public function paginate($number)
    {
        return LicenseCurrentStage::paginate($number);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFailById($id)
    {
        return LicenseCurrentStage::findOrFail($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $licenseCurrentStage = new LicenseCurrentStage();
        return $this->assignValues($request, $licenseCurrentStage);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $licenseCurrentStage = $this->findOrFailById($id);
        return $this->updateValues($request, $licenseCurrentStage);
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
     * @param LicenseCurrentStage $licenseCurrentStage
     * @return mixed
     */
    private function assignValues(Request $request, LicenseCurrentStage $licenseCurrentStage)
    {
        $fileRepository = new FileRepository();

        $licenseCurrentStage->license_id = $request->input('license_id');
        $licenseCurrentStage->license_stage_id = $request->input('license_stage_id');

        if ($request->input('date')) {
            $licenseCurrentStage->date = $request->input('date');
        } else {
            $licenseCurrentStage->date = null;
        }

        if ($request->input('person_id')) {
            $licenseCurrentStage->person_id = $request->input('person_id');
        } else {
            $licenseCurrentStage->person_id  = null;
        }

        if ($request->input('number')) {
            $licenseCurrentStage->number = $request->input('number');
        } else {
            $licenseCurrentStage->number  = null;
        }

        if ($request->hasFile('filename')) {
            $file = new File();
            $fileId = $fileRepository->saveFile($request, $file);
            $licenseCurrentStage->file_id = $fileId;
        }

        if ($request->input('objection_id')) {
            $licenseCurrentStage->objection_id = $request->input('objection_id');
        } else {
            $licenseCurrentStage->objection_id = null;
        }

        $licenseCurrentStage->save();

        return $licenseCurrentStage->id;
    }

    /**
     * @param Request $request
     * @param LicenseCurrentStage $licenseCurrentStage
     * @return mixed
     */
    private function updateValues(Request $request, LicenseCurrentStage $licenseCurrentStage)
    {
        $fileRepository = new FileRepository();
        $licenseCurrentStage->license_id = $request->input('license_id');
        $licenseCurrentStage->license_stage_id = $request->input('license_stage_id');

        if ($request->input('date')) {
            $licenseCurrentStage->date = $request->input('date');
        } else {
            $licenseCurrentStage->date = null;
        }

        if ($request->input('person_id')) {
            $licenseCurrentStage->person_id = $request->input('person_id');
        } else {
            $licenseCurrentStage->person_id  = null;
        }

        if ($request->input('number')) {
            $licenseCurrentStage->number = $request->input('number');
        } else {
            $licenseCurrentStage->number  = null;
        }

        $licenseCurrentStage->file_id = $request->input('file_id');

        if ($request->hasFile('filename')) {
            $file = new File();
            $fileId = $fileRepository->saveFile($request, $file);
            $licenseCurrentStage->file_id = $fileId;
        }


        if ($request->input('objection_id')) {
            $licenseCurrentStage->objection_id = $request->input('objection_id');
        } else {
            $licenseCurrentStage->objection_id = null;
        }

        $licenseCurrentStage->save();

        return $licenseCurrentStage->id;
    }

    /**
     * @param $request
     * @param $requestJson
     * @param $license_id
     * @param $stage_id
     * @param bool $finished
     * @return mixed
     */
    public function saveJson($request, $requestJson, $license_id, $stage_id, $finished = false) {
        $licenseRepository = new LicenseRepository();

        $licenseCurrentStage = LicenseCurrentStage::where('license_id',
          $license_id)->where('license_stage_id', $stage_id)->first();

        if (is_null($licenseCurrentStage)) {
            $licenseCurrentStage = new LicenseCurrentStage();
        }

        $licenseCurrentStage->license_id = $license_id;
        $licenseCurrentStage->license_stage_id = $stage_id;

        if (Input::file('file')) {
            $file = new File();

            $uploadedFile = Input::file('file');

            $name = time() . $uploadedFile->getClientOriginalName();

            $mimeType = $uploadedFile->getMimeType();

            Storage::put(
              $name,
              file_get_contents($uploadedFile->getRealPath())
            );

            $file->filename = $name;

            $file->mime_type = $mimeType;

            $file->save();

            $licenseCurrentStage->file_id = $file->id;

            $licenseCurrentStage->save();

            $license = $licenseRepository->findOrFailById($license_id);

            $license->last_current_stage_id = $licenseCurrentStage->id;

            $license->save();

            return $licenseCurrentStage->id;
        }

        if (Input::file('objectionFile')) {

            if (is_null($licenseCurrentStage->objection)) {
                $objection = new Objection();
            } else {
                $objection = $licenseCurrentStage->objection;
            }

            $objection->license_current_stage_id = $licenseCurrentStage->id;
            $objection->license_id = $license_id;
            $objection->license_stage_id = $stage_id;

            $file = new File();

            $uploadedFile = Input::file('objectionFile');

            $name = time() . $uploadedFile->getClientOriginalName();

            $mimeType = $uploadedFile->getMimeType();

            Storage::put(
              $name,
              file_get_contents($uploadedFile->getRealPath())
            );

            $file->filename = $name;

            $file->mime_type = $mimeType;

            $file->save();

            $objection->file_id = $file->id;

            $objection->save();

            $licenseCurrentStage->objection_id = $objection->id;

            $licenseCurrentStage->save();

            $license = $licenseRepository->findOrFailById($license_id);

            $license->last_current_stage_id = $licenseCurrentStage->id;

            $license->save();

            return $licenseCurrentStage->id;
        }

        if (isset($requestJson['date']) && ! empty($requestJson['date'])) {
            $licenseCurrentStage->date = $requestJson['date'];
        }
        else {
            $licenseCurrentStage->date = NULL;
        }

        if (isset($requestJson['person_id']) && ! empty($requestJson['person_id'])) {
            $licenseCurrentStage->person_id = $requestJson['person_id'];
        }
        else {
            $licenseCurrentStage->person_id = NULL;
        }

        if (isset($requestJson['number']) && ! empty($requestJson['number'])) {
            $licenseCurrentStage->number = $requestJson['number'];
        }
        else {
            $licenseCurrentStage->number = NULL;
        }

        if (isset($requestJson['stageObjection']) && ! empty($requestJson['stageObjection'])) {
            if (is_null($licenseCurrentStage->objection)) {
                $objection = new Objection();
            } else {
                $objection = $licenseCurrentStage->objection;
            }

            $objection->license_current_stage_id = $licenseCurrentStage->id;
            $objection->license_id = $license_id;
            $objection->license_stage_id = $stage_id;
            
            if (isset($requestJson['stageObjection']['first_person_position_id']) && ! empty($requestJson['stageObjection']['first_person_position_id'])) {
                $objection->first_person_position_id = $requestJson['stageObjection']['first_person_position_id'];
            } else {
                $objection->first_person_position_id = NULL;
            }

            if (isset($requestJson['stageObjection']['second_person_position_id']) && ! empty($requestJson['stageObjection']['second_person_position_id'])) {
                $objection->second_person_position_id = $requestJson['stageObjection']['second_person_position_id'];
            } else {
                $objection->second_person_position_id = NULL;
            }

            if (isset($requestJson['stageObjection']['report_date']) && ! empty($requestJson['stageObjection']['report_date'])) {
                $objection->report_date = $requestJson['stageObjection']['report_date'];
            } else {
                $objection->report_date = NULL;
            }

            $objection->save();

            $licenseCurrentStage->objection_id = $objection->id;
        } else {
            $licenseCurrentStage->objection_id = NULL;
        }

        if (isset($requestJson['previous'])) {
            $licenseCurrentStage->previous = $requestJson['previous'];
        }

        if (isset($requestJson['next'])) {
            $licenseCurrentStage->next = $requestJson['next'];
        }

        if (isset($requestJson['license_generate'])) {
            $licenseCurrentStage->license_generate = $requestJson['license_generate'];
        }

        $licenseCurrentStage->save();

        $license = $licenseRepository->findOrFailById($license_id);

        $license->last_current_stage_id = $licenseCurrentStage->id;

        $license->save();

        return $licenseCurrentStage->id;
    }

    /**
     * @param $license_id
     * @param null $stage_id
     * @return mixed
     */
    public function currentStage($license_id, $stage_id = null)
    {
        $licenseRepository = new LicenseRepository();
        $licenseTypeStageRepository = new LicenseTypeStageRepository();
        $licenseStageRepository = new LicenseStageRepository();

        $license = $licenseRepository->findOrFailById($license_id);
        $currentStage = $this->stageData($license_id, $stage_id);

        if (is_null($currentStage)) {
            $currentStage = $licenseTypeStageRepository->firstStageForLicenseType($license->license_type_id);
        }

        return $licenseStageRepository->findOrFailById($currentStage->license_stage_id);
    }


    /**
     * @param $license_id
     * @param null $stage_id
     * @return mixed
     */
    public function nextStage($license_id, $stage_id = null){
        $licenseRepository = new LicenseRepository();
        $licenseTypeStageRepository = new LicenseTypeStageRepository();
        $licenseStageRepository = new LicenseStageRepository();

        $license = $licenseRepository->findOrFailById($license_id);
        $stageData = $this->stageData($license_id, $stage_id);

        if (is_null($stageData)) {
            return $licenseTypeStageRepository->nextStageForLicenseType($license->license_type_id, $stage_id);
        }

        if ($stageData->license_generate) {
            return null;
        }

        if (is_null($stageData->next)) {
            $nextStage = $licenseTypeStageRepository->nextStageForLicenseType($license->license_type_id, $stageData->stage_id);

            if (is_null($nextStage)) {
                return null;
            }
        } else {
            $nextStage = $licenseStageRepository->find($stageData->next);
        }

        return $nextStage;
    }

    /**
     * @param $license_id
     * @param null $stage_id
     * @return mixed
     */
    public function previousStage($license_id, $stage_id = null)
    {
        $licenseRepository = new LicenseRepository();
        $licenseStageRepository = new LicenseStageRepository();
        $licenseTypeStageRepository = new LicenseTypeStageRepository();

        $license = $licenseRepository->findOrFailById($license_id);
        $stageData = $this->stageData($license_id, $stage_id);

        if (is_null($stageData) || is_null($stageData->previous)) {
            if( ! is_null($stageData)) {
                $first_step = $license->licenseCurrentStages()->first();
                if ($first_step->license_stage_id == $stageData->license_stage_id) {
                    return null;
                }
            }

            $currentStage = $licenseTypeStageRepository->currentStageForLicenseType($license_id, $stage_id);
            return $licenseStageRepository->find($currentStage->previous);
        }

        $previousStage = $licenseStageRepository->find($stageData->previous);

        return $previousStage;
    }

    /**
     * @param $license_id
     * @param $stage_id
     * @return mixed
     */
    public function stageData($license_id, $stage_id = null) {
        if (is_null($stage_id)) {
            return LicenseCurrentStage::where('license_id', $license_id)
              ->orderBy('id', 'ASC')
              ->first();
        }

        return LicenseCurrentStage::where('license_id', $license_id)
          ->where('license_stage_id', $stage_id)
          ->first();
    }

    public function loadStages($license_id) {
        $licenseRepository = new LicenseRepository();
        $license = $licenseRepository->findOrFailById($license_id);
        $currentStages = $license->licenseCurrentStages;

        foreach($currentStages as $currentStage) {
            $currentStage->delete();
        }

        $licenseStages = $license->licenseType->licenseTypeStages;

        foreach($licenseStages as $stage) {
            $currentStage = new LicenseCurrentStage();
            $currentStage->license_id = $license_id;
            $currentStage->license_stage_id = $stage->license_stage_id;
            $currentStage->weight = $stage->weight;
            $currentStage->previous = $stage->previous;
            $currentStage->next = $stage->next;
            $currentStage->license_generate = $stage->license_generate;
            $currentStage->optional = $stage->licenseStage->optional;
            $currentStage->save();
        }
    }

    public function fieldsRequiredAreFill($license_id)
    {
        $licenseRepository = new LicenseRepository();
        $license = $licenseRepository->findOrFailById($license_id);
        $currentStages = $license->licenseCurrentStages;

        $requiredFailFields = [];

        foreach($currentStages as $currentStage) {
            $licenseStage = $currentStage->licenseStage;

            if($licenseStage->optional === false) {
                if($licenseStage->name_required) {
                    if(empty($currentStage->name)) {
                        $requiredFailFields[] = [
                          'id' => $licenseStage->id,
                          'field' => "Nombre",
                          'stage' =>$licenseStage->name,
                        ];
                    }
                }

                if($licenseStage->date_required) {
                    if(empty($currentStage->date)) {
                        $requiredFailFields[] = [
                          'id' => $licenseStage->id,
                          'field' => "Fecha",
                          'stage' =>$licenseStage->name,
                        ];
                    }
                }

                if($licenseStage->person_required) {
                    if(empty($currentStage->person_id)) {
                        $requiredFailFields[] = [
                          'id' => $licenseStage->id,
                          'field' => "Persona",
                          'stage' =>$licenseStage->name,
                        ];
                    }
                }

                if($licenseStage->number_required) {
                    if(empty($currentStage->number)) {
                        $requiredFailFields[] = [
                          'id' => $licenseStage->id,
                          'field' => "Número",
                          'stage' =>$licenseStage->name,
                        ];
                    }
                }

                if($licenseStage->file_required) {
                    if(empty($currentStage->file_id)) {
                        $requiredFailFields[] = [
                          'id' => $licenseStage->id,
                          'field' => "Fichero",
                          'stage' => $licenseStage->name,
                        ];
                    }
                }

                if($licenseStage->objection_required) {
                    if(empty($currentStage->objection_id)) {
                        $requiredFailFields[] = [
                          'id' => $licenseStage->id,
                          'field' => "Reparo",
                          'stage' =>$licenseStage->name,
                        ];
                    }
                }
            }
        }

        return $requiredFailFields;
    }

    public function obtainRequiredStages($license_id) {
        $licenseRepository = new LicenseRepository();
        $license = $licenseRepository->findOrFailById($license_id);
        $currentStages = $license->licenseCurrentStages;

        $requiredStages = [];

        foreach($currentStages as $currentStage) {
            $licenseStage = $currentStage->licenseStage;
            $requiredStages[$licenseStage->id] = false;
            
            if($licenseStage->name_required) {
                if(empty($currentStage->name)) {
                    $requiredStages[$licenseStage->id] = true;
                }
            }

            if($licenseStage->date_required) {
                if(empty($currentStage->date)) {
                    $requiredStages[$licenseStage->id] = true;
                }
            }

            if($licenseStage->person_required) {
                if(empty($currentStage->person_id)) {
                    $requiredStages[$licenseStage->id] = true;
                }
            }

            if($licenseStage->number_required) {
                if(empty($currentStage->number)) {
                    $requiredStages[$licenseStage->id] = true;
                }
            }

            if($licenseStage->file_required) {
                if(empty($currentStage->file_id)) {
                    $requiredStages[$licenseStage->id] = true;
                }
            }

            if($licenseStage->objection_required) {
                if(empty($currentStage->objection_id)) {
                    $requiredStages[$licenseStage->id] = true;
                }
            }            
        }

        return $requiredStages;
    }
}