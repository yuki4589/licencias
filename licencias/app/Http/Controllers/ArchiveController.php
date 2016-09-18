<?php

namespace CityBoard\Http\Controllers;

use CityBoard\Http\Controllers\Controller;

use CityBoard\Repositories\ArchiveRepository;

use CityBoard\Http\Requests;
use CityBoard\Http\Requests\StoreArchiveRequest;
use CityBoard\Http\Requests\UpdateArchiveRequest;

class ArchiveController extends Controller
{
    protected $archiveRepository;

    public function __construct()
    {
        $this->archiveRepository = new ArchiveRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amount = $this->archiveRepository->all()->count();
        $archives = $this->archiveRepository->paginate(20);

        return view('archive.index', compact('archives', 'amount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('archive.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreArchiveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArchiveRequest $request)
    {
        $archive_id = $this->archiveRepository->create($request);

        return redirect(route('archive.show', ['id' => $archive_id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $archive = $this->archiveRepository->findOrFailById($id);

        return view('archive.show', compact('archive'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $archive = $this->archiveRepository->findOrFailById($id);

        return view('archive.edit', compact('archive'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateArchiveRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArchiveRequest $request, $id)
    {

        $archive_id = $this->archiveRepository->update($request, $id);

        return redirect(route('archive.show', ['id' => $archive_id]));
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
}
