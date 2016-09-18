<?php

namespace CityBoard\Http\Controllers;

use CityBoard\Http\Controllers\Controller;

use CityBoard\Repositories\FileRepository;

use CityBoard\Http\Requests;
use CityBoard\Http\Requests\StoreFileRequest;
use CityBoard\Http\Requests\UpdateFileRequest;

use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    protected $fileRepository;

    public function __construct()
    {
        $this->fileRepository = new FileRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amount = $this->fileRepository->all()->count();
        $files = $this->fileRepository->paginate(20);

        return view('file.index', compact('files', 'amount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('file.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreFileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFileRequest $request)
    {
        $file_id = $this->fileRepository->create($request);

        return redirect(route('file.show', ['id' => $file_id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $file = $this->fileRepository->findOrFailById($id);

        return view('file.show', compact('file'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $file = $this->fileRepository->findOrFailById($id);

        return view('file.edit', compact('file'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateFileRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFileRequest $request, $id)
    {

        $file_id = $this->fileRepository->update($request, $id);

        return redirect(route('file.show', ['id' => $file_id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function download($id) {
        $file = $this->fileRepository->findOrFailById($id);

        return response(Storage::get($file->filename), 200)
          ->header('Content-Type', $file->mime_type)
          ->header('Content-Disposition', 'inline; filename=' . $file->filename);
    }
}
