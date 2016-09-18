<?php

namespace CityBoard\Repositories;

use CityBoard\Entities\File;
use CityBoard\Repositories\RepositoryInterface;
use CityBoard\Entities\Denunciation;
use Illuminate\Http\Request;

use CityBoard\Repositories\FileRepository;

class DenunciationRepository implements RepositoryInterface
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
        return Denunciation::all();
    }

    /**
     * @param $number
     * @return mixed
     */
    public function paginate($number)
    {
        return Denunciation::paginate($number);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFailById($id)
    {
        return Denunciation::findOrFail($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $denunciation = new Denunciation();
        return $this->assignValues($request, $denunciation);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $denunciation = $this->findOrFailById($id);
        return $this->updateValues($request, $denunciation);
    }

    /**
     * @return static
     */
    public function selectControl()
    {
        /**
         * @todo SelectControl for Denunciation Entity
         */
        //return $this->all()->lists('full_name', 'id');
    }

    /**
     * @param Request $request
     * @param Denunciation $denunciation
     * @return mixed
     */
    private function assignValues(Request $request, Denunciation $denunciation)
    {
        $denunciation->license_id = $request->input('license_id');
        $denunciation->register_date = $request->input('register_date');
        $denunciation->expedient_number = $request->input('expedient_number');

        $reason = $request->input('reason');
        if(! is_null($reason)) {
            $denunciation->reason = $reason;
        }

        if ($request->hasFile('filename')) {
            $file = new File();
            $fileId = $this->fileRepository->saveFile($request, $file);
            $denunciation->file_id = $fileId;
        }

        $denunciation->save();

        return $denunciation->id;
    }

    /**
     * @param Request $request
     * @param Denunciation $denunciation
     * @return mixed
     */
    private function updateValues(Request $request, Denunciation $denunciation)
    {
        $denunciation->license_id = $request->input('license_id');
        $denunciation->register_date = $request->input('register_date');
        $denunciation->expedient_number = $request->input('expedient_number');

        $reason = $request->input('reason');
        if(! is_null($reason)) {
            $denunciation->reason = $reason;
        }

        $denunciation->file_id = $request->input('file_id');

        if ($request->hasFile('filename')) {
            $file = new File();
            $fileId = $this->fileRepository->saveFile($request, $file);
            $denunciation->file_id = $fileId;
        }

        $denunciation->save();

        return $denunciation->id;
    }


}