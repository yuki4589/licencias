<?php

namespace CityBoard\Repositories;

use CityBoard\Repositories\RepositoryInterface;
use CityBoard\Entities\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileRepository implements RepositoryInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return File::all();
    }

    /**
     * @param $number
     * @return mixed
     */
    public function paginate($number)
    {
        return File::paginate($number);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFailById($id)
    {
        return File::findOrFail($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $file = new File();
        return $this->assignValues($request, $file);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $file = $this->findOrFailById($id);
        return $this->updateValues($request, $file);
    }

    /**
     * @return static
     */
    public function selectControl()
    {
        return $this->all()->lists('url', 'id');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \CityBoard\Entities\File $file
     * @return mixed
     */
    public function saveFile(Request $request, File $file) {
        $uploadedFile = $request->file('filename');

        $name = time() . $uploadedFile->getClientOriginalName();

        $mimeType = $uploadedFile->getMimeType();

        Storage::put(
          $name,
          file_get_contents($uploadedFile->getRealPath())
        );

        $file->filename = $name;

        $file->mime_type = $mimeType;

        $file->save();

        return $file->id;
    }
    /**
     * @param Request $request
     * @param $file
     * @return mixed
     */
    private function assignValues(Request $request, File $file)
    {
        return $this->saveFile($request, $file);
    }

    /**
     * @param Request $request
     * @param $file
     * @return mixed
     */
    private function updateValues(Request $request, $file)
    {
        return $this->saveFile($request, $file);
    }


}