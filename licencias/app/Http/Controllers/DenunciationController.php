<?php

namespace CityBoard\Http\Controllers;

use CityBoard\Http\Controllers\Controller;

use CityBoard\Repositories\DenunciationRepository;
use CityBoard\Repositories\LicenseRepository;

use CityBoard\Http\Requests;
use CityBoard\Http\Requests\StoreDenunciationRequest;
use CityBoard\Http\Requests\UpdateDenunciationRequest;
use CityBoard\Entities\Denunciation;
use Illuminate\Http\Request;

class DenunciationController extends Controller
{
    protected $denunciationRepository;
    protected $licenseRepository;

    public function __construct()
    {
        $this->denunciationRepository = new DenunciationRepository();
        $this->licenseRepository = new LicenseRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amount = $this->denunciationRepository->all()->count();
        $denunciations = $this->denunciationRepository->paginate(20);

        return view('denunciation.index', compact('denunciations', 'amount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $licenses = $this->licenseRepository->selectControl();

        return view('denunciation.create', compact('licenses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreDenunciationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDenunciationRequest $request)
    {
        $denunciation_id = $this->denunciationRepository->create($request);

        return redirect(route('denunciation.show', ['id' => $denunciation_id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $denunciation = $this->denunciationRepository->findOrFailById($id);

        return view('denunciation.show', compact('denunciation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $denunciation = $this->denunciationRepository->findOrFailById($id);
        $file = $denunciation->file;
        $licenses = $this->licenseRepository->selectControl();

        return view('denunciation.edit', compact('denunciation', 'file', 'licenses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateDenunciationRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDenunciationRequest $request, $id)
    {

        $denunciation_id = $this->denunciationRepository->update($request, $id);

        return redirect(route('denunciation.show', ['id' => $denunciation_id]));
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

    /**
     * Show the form for creating a new resource from a License.
     *
     * @param integer $license_id
     * @return \Illuminate\Http\Response
     */
    public function createFromLicense($license_id)
    {
        $license = $this->licenseRepository->findOrFailById($license_id);

        return view('denunciation.create', compact('license'));
    }

    /**
     * Show the form for editing the specified resource from a License.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editFromLicense($license_id, $denunciation_id)
    {
        $license = $this->licenseRepository->findOrFailById($license_id);
        $denunciation = $this->denunciationRepository->findOrFailById($denunciation_id);

        return view('denunciation.edit', compact('license', 'denunciation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createModal(Request $request) {
        try{
            Denunciation::create($request->all());
            return ['created' => true];
        }catch (Exception $e){
            \Log::info('Error creating user: '.$e);
            return \Response::json(['created' => false], 500);
        }
    }

    public function getDenunciaLicenses($id) {
        $Denunciation = Denunciation::where('license_id', $id)->get();
        return $Denunciation;
    }

    public  function  updateEstatus (Request $request){
        try{
            $Denunciation = Denunciation::find($request->input('id'));
            $Denunciation->status=$request->input('status');
            $Denunciation->save();
            return ['update' => true];
        }catch (Exception $e){
            \Log::info('Error creating user: '.$e);
            return \Response::json(['update' => false], 500);
        }
    }
}
