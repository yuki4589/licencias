<?php

namespace CityBoard\Repositories;

use CityBoard\Repositories\RepositoryInterface;
use CityBoard\Entities\Archive;
use Illuminate\Http\Request;


class ArchiveRepository implements RepositoryInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return Archive::all();
    }

    /**
     * @param $number
     * @return mixed
     */
    public function paginate($number)
    {
        return Archive::paginate($number);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFailById($id)
    {
        return Archive::findOrFail($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $archive = new Archive();
        return $this->assignValues($request, $archive);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $archive = $this->findOrFailById($id);
        return $this->updateValues($request, $archive);
    }

    /**
     * @return static
     */
    public function selectControl()
    {
        return $this->all()->lists('full_name', 'id');
    }

    /**
     * @param Request $request
     * @param Archive $archive
     * @return mixed
     */
    private function assignValues(Request $request, Archive $archive)
    {
        $archive->name = $request->input('name');
        $archive->place = $request->input('place');
        $archive->save();

        return $archive->id;
    }

    /**
     * @param Request $request
     * @param Archive $archive
     * @return mixed
     */
    private function updateValues(Request $request, Archive $archive)
    {
        $archive->name = $request->input('name');
        $archive->place = $request->input('place');
        $archive->save();

        return $archive->id;
    }


}