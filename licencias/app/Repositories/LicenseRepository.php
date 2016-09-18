<?php

namespace CityBoard\Repositories;

use Carbon\Carbon;

use CityBoard\Entities\Activity;
use CityBoard\Entities\Street;
use CityBoard\Entities\LicenseStatusChange;
use CityBoard\Entities\Titular;
use CityBoard\Entities\TitularityChange;
use CityBoard\Repositories\RepositoryInterface;
use CityBoard\Entities\License;
use Illuminate\Http\Request;

class LicenseRepository implements RepositoryInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return License::all();
    }

    /**
     * @param $number
     * @return mixed
     */
    public function paginate($number)
    {
        return License::paginate($number);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFailById($id)
    {
        return License::with('titular', 'licenseCurrentStages', 'licenseCurrentStages.licenseStage', 'licenseCurrentStages.person', 'licenseCurrentStages.file', 'licenseCurrentStages.objections', 'licenseCurrentStages.objections.firstPersonPosition', 'licenseCurrentStages.objections.secondPersonPosition', 'licenseCurrentStages.objections.file', 'licenseCurrentStages.objections.objectionNotifications', 'loans', 'loans.person')->findOrFail($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $license = new License();
        return $this->assignValues($request, $license);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $license = $this->findOrFailById($id);
        return $this->updateValues($request, $license);
    }

    /**
     * @return static
     */
    public function selectControl()
    {
        return $this->all()->lists('expedient_number' , 'id');
    }


    public function selectTitularityChangeControl() {
        $nulls = \CityBoard\Entities\License::all()->where('identifier', null)->all();
        $diff = \CityBoard\Entities\License::all()->diff($nulls);
        return $diff->lists('expedient_number' , 'id');
    }

    /**
     * @param Request $request
     * @param $license
     * @return mixed
     */
    private function assignValues(Request $request, $license)
    {
        $licenseCurrentStageRepository = new LicenseCurrentStageRepository();
        $licenseStatusRepository = new LicenseStatusRepository();

        if (is_null($license->last_current_stage_id)) {
            $license->license_type_id = $request->input('license_type_id');
        }

        $license->expedient_number = $request->input('expedient_number');
        $license->register_date = $request->input('register_date');
        $license->register_number = $request->input('register_number');
        $license->closet = $request->input('closet');

        if (!empty($request->input('activity_id'))) {
            $license->activity_id = $request->input('activity_id');
        } else if(!empty($request->input('activity_name'))) {
            $activity = new Activity();
            $activity->name = $request->input('activity_name');
            $activity->save();
            $license->activity_id = $activity->id;
        }

        if (!empty($request->input('street_id'))) {
            $license->street_id = $request->input('street_id');
        } else if(!empty($request->input('street_name'))) {
            $street = new Street();
            $street->name = $request->input('street_name');
            $street->save();
            $license->street_id = $street->id;
        }

        $license->street_number = $request->input('street_number');
        $license->postcode = $request->input('postcode');
        $license->city = $request->input('city');

        if(is_null($license->identifier)) {
            if (!empty($request->input('titular_id'))) {
                $titular_id = $request->input('titular_id');
                $titular = Titular::findOrFail($titular_id);
            } else if(!empty($request->input('titular_nif'))) {
                $titular = new Titular();
            }
            if(isset($titular)) {
                $titular->nif = $request->input('titular_nif');
                $titular->first_name = $request->input('titular_first_name');
                $titular->last_name = $request->input('titular_last_name');
                $titular->phone_number = $request->input('titular_phone_number');
                $titular->email = $request->input('titular_email');
                $titular->save();
                $license->titular_id = $titular->id;
            }
        }

        $license->year = date('Y', strtotime($license->register_date));

        $license->number = $this->lastNumberOfLicenseTypeForYear($license->license_type_id, $license->year) + 1;

        $licenseStatus = $licenseStatusRepository->findByName('Solicitada');
        if (!is_null($licenseStatus)) {
            $license->license_status_id = $licenseStatus->id;
        }

        $license->save();
        
        $licenseStatusChange = new LicenseStatusChange();
        $licenseStatusChange->license_id = $license->id;
        $licenseStatusChange->license_status_id = $license->license_status_id;
        $licenseStatusChange->change_date = Carbon::now();
        $licenseStatusChange->save();

        if (is_null($license->last_current_stage_id)) {
            $licenseCurrentStageRepository->loadStages($license->id);
        }

        return $license->id;
    }

    /**
     * @param $license_type
     * @param $year
     * @return int
     */
    private function lastNumberOfLicenseTypeForYear($license_type, $year)
    {
        $license = License::where('license_type_id', $license_type)->where('year', $year)->orderBy('number', 'desc')->first();
        if($license === null) {
            return 0;
        }

        return $license->number;
    }

    /**
     * @param Request $request
     * @param $license
     * @return mixed
     */
    private function updateValues(Request $request, $license)
    {
        $licenseCurrentStageRepository = new LicenseCurrentStageRepository();

        if (is_null($license->last_current_stage_id)) {
            $license->license_type_id = $request->input('license_type_id');
        }

        $license->expedient_number = $request->input('expedient_number');
        $license->register_date = $request->input('register_date');
        $license->register_number = $request->input('register_number');
        $license->closet = $request->input('closet');

        if (!empty($request->input('activity_id'))) {
            $license->activity_id = $request->input('activity_id');
        } else if(!empty($request->input('activity_name'))) {
            $activity = new Activity();
            $activity->name = $request->input('activity_name');
            $activity->save();
            $license->activity_id = $activity->id;
        }

        if (!empty($request->input('street_id'))) {
            $license->street_id = $request->input('street_id');
        } else if(!empty($request->input('street_name'))) {
            $street = new Street();
            $street->name = $request->input('street_name');
            $street->save();
            $license->street_id = $street->id;
        }
        
        $license->street_number = $request->input('street_number');
        $license->postcode = $request->input('postcode');
        $license->city = $request->input('city');

        if(is_null($license->identifier)) {
            if (!empty($request->input('titular_id'))) {
                $titular_id = $request->input('titular_id');
                $titular = Titular::findOrFail($titular_id);
            } else if(!empty($request->input('titular_nif'))) {
                $titular = new Titular();
            }
            if(isset($titular)) {
                $titular->nif = $request->input('titular_nif');
                $titular->first_name = $request->input('titular_first_name');
                $titular->last_name = $request->input('titular_last_name');
                $titular->phone_number = $request->input('titular_phone_number');
                $titular->email = $request->input('titular_email');
                $titular->save();
                $license->titular_id = $titular->id;
            }
        }

        if ($request->input('archive_id')) {
            $license->archive_id = $request->input('archive_id');
        } else {
            $license->archive_id = null;
        }

        if ($request->input('archive_location')) {
            $license->archive_location = $request->input('archive_location');
        } else {
            $license->archive_location = null;
        }

        $license->save();

        if (is_null($license->last_current_stage_id)) {
            $licenseCurrentStageRepository->loadStages($license->id);
        }

        return $license->id;
    }

    public function finish($license_id) {
        $license = $this->findOrFailById($license_id);
        if (is_null($license->identifier)) {
            $this->createTitularChange($license);
        }
        $this->setIdentifier($license);
        $this->changeStatusToIdentifier($license);
        $this->changeFinished($license, true);
    }

    public function open($license_id) {
        $license = $this->findOrFailById($license_id);
        $this->changeStatusToOpen($license);
        $this->changeFinished($license, false);
    }

    private function changeFinished($license, $finished) {
        $license->finished = $finished;

        $license->save();
    }

    private function setIdentifier($license)
    {
        if (is_null($license->identifier)) {
            $license->identifier = $this->lastIdentifier() + 1;
            $license->save();
        }
    }

    public function lastIdentifier() {
        $last =  License::all()->sortByDesc('identifier')->first();

        if (is_null($last->identifier)) {
            return env('LAST_IDENTIFIER');
        }

        return $last->identifier;
    }

    private function changeStatusToOpen($license) {
        $licenseStatusRepository = new LicenseStatusRepository();

        $reopenStatus = $licenseStatusRepository->reopen();
        $license->license_status_id = $reopenStatus->id;
        $license->save();

        $licenseStatusChange = new LicenseStatusChange();
        $licenseStatusChange->license_id = $license->id;
        $licenseStatusChange->license_status_id = $reopenStatus->id;
        $licenseStatusChange->change_date = Carbon::now();
        $licenseStatusChange->save();
    }

    /**
     * @param $license
     */
    private function createTitularChange($license)
    {
        $titularityChange = new TitularityChange();
        $titularityChange->license_id = $license->id;
        $titularityChange->titular_id = $license->titular_id;
        $titularityChange->expedient_number = $license->expedient_number;
        $titularityChange->register_number = $license->register_number;
        $titularityChange->register_date = $license->register_date;
        $titularityChange->finished = true;
        $titularityChange->finished_date = $license->license_date;
        $titularityChange->status = 'Concedido';
        $titularityChange->save();
    }

    private function changeStatusToIdentifier($license)
    {
        $licenseStatusRepository = new LicenseStatusRepository();

        $identifierStatus = $licenseStatusRepository->identifier();
        $license->license_status_id = $identifierStatus->id;
        $license->save();

        $licenseStatusChange = new LicenseStatusChange();
        $licenseStatusChange->license_id = $license->id;
        $licenseStatusChange->license_status_id = $identifierStatus->id;
        $licenseStatusChange->change_date = Carbon::now();
        $licenseStatusChange->save();
    }

    public function closets() {
        $closets = [
          'A',
          'B',
          'C',
          'D',
          'E',
          'F',
          'G',
          'H',
          'I',
          'J',
          'K',
          'L',
          'M',
          'N',
          'Ñ',
          'O',
          'P',
          'Q',
          'R',
          'S',
          'T',
          'U',
          'V',
          'W',
          'X',
          'Y',
          'Z',
        ];

        return $closets;
    }


    public function closetsSelectControl() {
        $closets = [
          'A' => 'A',
          'B' => 'B',
          'C' => 'C',
          'D' => 'D',
          'E' => 'E',
          'F' => 'F',
          'G' => 'G',
          'H' => 'H',
          'I' => 'I',
          'J' => 'J',
          'K' => 'K',
          'L' => 'L',
          'M' => 'M',
          'N' => 'N',
          'Ñ' => 'Ñ',
          'O' => 'O',
          'P' => 'P',
          'Q' => 'Q',
          'R' => 'R',
          'S' => 'S',
          'T' => 'T',
          'U' => 'U',
          'V' => 'V',
          'W' => 'W',
          'X' => 'X',
          'Y' => 'Y',
          'Z' => 'Z',
        ];

        return $closets;
    }
}