<?php

namespace CityBoard\Repositories;

use CityBoard\Repositories\RepositoryInterface;
use CityBoard\Entities\LicenseStage;
use Illuminate\Http\Request;


class LicenseStageRepository implements RepositoryInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return LicenseStage::all();
    }

    /**
     * @param $number
     * @return mixed
     */
    public function paginate($number)
    {
        return LicenseStage::paginate($number);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFailById($id)
    {
        return LicenseStage::findOrFail($id);
    }

    public function find($id) {
        return LicenseStage::where('id', $id)->first();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $licenseStage = new LicenseStage();
        return $this->assignValues($request, $licenseStage);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $licenseStage = $this->findOrFailById($id);
        return $this->updateValues($request, $licenseStage);
    }

    /**
     * @return static
     */
    public function selectControl()
    {
        return $this->all()->lists('name', 'id');
    }

    /**
     * @param Request $request
     * @param LicenseStage $licenseStage
     * @return mixed
     */
    private function assignValues(Request $request, LicenseStage $licenseStage)
    {
        $licenseStage->name = $request->input('name');
        $licenseStage->date = $this->processingCheckbox($request->input('date'));
        $licenseStage->person = $this->processingCheckbox($request->input('person'));
        $licenseStage->number = $this->processingCheckbox($request->input('number'));
        $licenseStage->file = $this->processingCheckbox($request->input('file'));
        $licenseStage->objection = $this->processingCheckbox($request->input('objection'));
        $licenseStage->date_required = $this->processingCheckbox($request->input('date_required'));
        $licenseStage->person_required = $this->processingCheckbox($request->input('person_required'));
        $licenseStage->number_required = $this->processingCheckbox($request->input('number_required'));
        $licenseStage->file_required = $this->processingCheckbox($request->input('file_required'));
        $licenseStage->objection_required = $this->processingCheckbox($request->input('objection_required'));

        $licenseStage->save();

        return $licenseStage->id;
    }

    /**
     * @param Request $request
     * @param LicenseStage $licenseStage
     * @return mixed
     */
    private function updateValues(Request $request, LicenseStage $licenseStage)
    {
        $licenseStage->name = $request->input('name');
        $licenseStage->date = $this->processingCheckbox($request->input('date'));
        $licenseStage->person = $this->processingCheckbox($request->input('person'));
        $licenseStage->number = $this->processingCheckbox($request->input('number'));
        $licenseStage->file = $this->processingCheckbox($request->input('file'));
        $licenseStage->objection = $this->processingCheckbox($request->input('objection'));
        $licenseStage->date_required = $this->processingCheckbox($request->input('date_required'));
        $licenseStage->person_required = $this->processingCheckbox($request->input('person_required'));
        $licenseStage->number_required = $this->processingCheckbox($request->input('number_required'));
        $licenseStage->file_required = $this->processingCheckbox($request->input('file_required'));
        $licenseStage->objection_required = $this->processingCheckbox($request->input('objection_required'));

        $licenseStage->save();

        return $licenseStage->id;
    }

    private function processingCheckbox($field)
    {
        if (!isset($field)) {
            return false;
        }

        return true;
    }
}