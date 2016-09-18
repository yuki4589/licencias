<?php

namespace CityBoard\Repositories;

use CityBoard\Repositories\RepositoryInterface;
use CityBoard\Entities\LicenseStatus;
use Illuminate\Http\Request;


class LicenseStatusRepository implements RepositoryInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return LicenseStatus::all();
    }

    /**
     * @param $number
     * @return mixed
     */
    public function paginate($number)
    {
        return LicenseStatus::paginate($number);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFailById($id)
    {
        return LicenseStatus::findOrFail($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $licenseStatus = new LicenseStatus();
        return $this->assignValues($request, $licenseStatus);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $licenseStatus = $this->findOrFailById($id);
        return $this->updateValues($request, $licenseStatus);
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
     * @param LicenseStatus $licenseStatus
     * @return mixed
     */
    private function assignValues(Request $request, LicenseStatus $licenseStatus)
    {
        $licenseStatus->name = $request->input('name');
        $licenseStatus->save();

        return $licenseStatus->id;
    }

    /**
     * @param Request $request
     * @param LicenseStatus $licenseStatus
     * @return mixed
     */
    private function updateValues(Request $request, LicenseStatus $licenseStatus)
    {
        $licenseStatus->name = $request->input('name');
        $licenseStatus->save();

        return $licenseStatus->id;
    }

    public function findByName($string) {
        $licenseStatus = LicenseStatus::where('name', $string)->first();

        if (is_null($licenseStatus)) return null;

        return $licenseStatus;
    }

    public function rejectSelectControl() {
        $licenseStatuses = LicenseStatus::where('reject', true)->lists('name', 'id');
        
        return $licenseStatuses;
    }

    public function successSelectControl() {
        $licenseStatuses = LicenseStatus::where('success', true)->lists('name', 'id');

        return $licenseStatuses;
    }

    public function initial() {
        $initialStatus = LicenseStatus::where('initial', true)->first();

        return $initialStatus;
    }

    public function reopen() {
        $initialStatus = LicenseStatus::where('reopen', true)->first();

        return $initialStatus;
    }

    public function identifier()
    {
        $identifierStatus = LicenseStatus::where('identifier', true)->first();

        return $identifierStatus;
    }
}