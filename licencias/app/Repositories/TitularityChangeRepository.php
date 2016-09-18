<?php

namespace CityBoard\Repositories;

use CityBoard\Entities\File;
use CityBoard\Entities\Titular;
use CityBoard\Repositories\RepositoryInterface;
use CityBoard\Entities\TitularityChange;
use Illuminate\Http\Request;

use CityBoard\Repositories\FileRepository;

class TitularityChangeRepository implements RepositoryInterface
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
        return TitularityChange::all();
    }

    /**
     * @param $number
     * @return mixed
     */
    public function paginate($number)
    {
        return TitularityChange::paginate($number);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFailById($id)
    {
        return TitularityChange::findOrFail($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $titularityChange = new TitularityChange();
        return $this->assignValues($request, $titularityChange);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $titularityChange = $this->findOrFailById($id);

        return $this->updateValues($request, $titularityChange);
    }

    /**
     * @param Request $request
     * @param $titularityChange
     * @return mixed
     */
    private function assignValues(Request $request, TitularityChange $titularityChange)
    {
        $titularityChange->license_id = $request->input('license_id');
        $titularityChange->expedient_number = $request->input('expedient_number');
        $titularityChange->register_number = $request->input('register_number');
        $titularityChange->register_date = $request->input('register_date');

        // Titular
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
            $titularityChange->titular_id = $titular->id;
        }
        // End Titular

        $titularityChange->finished = $request->input('finished');
        $titularityChange->finished_date = $request->input('finished_date');

        if ($request->hasFile('filename')) {
            $file = new File();
            $fileId = $this->fileRepository->saveFile($request, $file);
            $titularityChange->file_id = $fileId;
        }

        $titularityChange->save();

        return $titularityChange->id;
    }

    /**
     * @param Request $request
     * @param $titularityChange
     * @return mixed
     */
    private function updateValues(Request $request, TitularityChange $titularityChange)
    {
        $titularityChange->license_id = $request->input('license_id');
        $titularityChange->expedient_number = $request->input('expedient_number');
        $titularityChange->register_number = $request->input('register_number');
        $titularityChange->register_date = $request->input('register_date');

        // Titular
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
            $titularityChange->titular_id = $titular->id;
        }
        // End Titular

        if ($request->input('finished')) {
            $titularityChange->finished = $request->input('finished');
        }

        if ($request->input('finished_date')) {
            $titularityChange->finished_date = $request->input('finished_date');
        }

        if ($request->input('status')) {
            $titularityChange->status = $request->input('status');
        }

        if($request->input('file_id')) {
            $titularityChange->file_id = $request->input('file_id');
        }

        if ($request->hasFile('filename')) {
            $file = new File();
            $fileId = $this->fileRepository->saveFile($request, $file);
            $titularityChange->file_id = $fileId;
        }

        $titularityChange->save();

        return $titularityChange->id;
    }

    public function lastTitular(TitularityChange $titularChange) {
        $licenseRepository = new LicenseRepository();
        $license = $licenseRepository->findOrFailById($titularChange->license_id);
        $titularityChanges = $license->titularChanges->where('status', 'Concedido');
        
        $titularityChangeBefore = $titularityChanges->filter(function ($item) use ($titularChange) {
            return $item['id'] < $titularChange->id;
        });
        
        if (is_null($titularityChangeBefore->last())) return null;
        
        return $titularityChangeBefore->last()->titular;
    }
}