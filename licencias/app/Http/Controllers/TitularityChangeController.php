<?php

namespace CityBoard\Http\Controllers;

use CityBoard\Entities\TitularityChange;
use CityBoard\Http\Controllers\Controller;

use CityBoard\Repositories\LicenseRepository;
use CityBoard\Repositories\TitularityChangeRepository;
use CityBoard\Repositories\TitularRepository;

use CityBoard\Http\Requests;
use CityBoard\Http\Requests\StoreTitularityChangeRequest;
use CityBoard\Http\Requests\UpdateTitularityChangeRequest;
use Illuminate\Http\Request;

class TitularityChangeController extends Controller
{
    protected $licenseRepository;
    protected $titularRepository;
    protected $titularityChangeRepository;
    protected $titularityChangeStatuses;

    public function __construct()
    {
        $this->titularityChangeRepository = new TitularityChangeRepository();
        $this->licenseRepository = new LicenseRepository();
        $this->titularRepository = new TitularRepository();
        $this->titularityChangeStatuses = [
          'Solicitado' => 'Solicitado',
          'Concedido' => 'Concedido',
          'Desistido' => 'Desistido',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amount = $this->titularityChangeRepository->all()->count();
        $titularityChanges = $this->titularityChangeRepository->paginate(20);

        return view('titularityChange.index', compact('titularityChanges', 'amount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $licenses = $this->licenseRepository->selectTitularityChangeControl();
        $titulars = $this->titularRepository->selectControl();

        return view('titularityChange.create', compact('licenses', 'titulars'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreTitularityChangeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTitularityChangeRequest $request)
    {
        $titularity_change_id = $this->titularityChangeRepository->create($request);

        return redirect(route('titularitychange.show', ['id' => $titularity_change_id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $titularityChange = $this->titularityChangeRepository->findOrFailById($id);
        $titularityChangeStatuses =$this->titularityChangeStatuses;
        return view('titularityChange.show', compact('titularityChange', 'titularityChangeStatuses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $titularityChange = $this->titularityChangeRepository->findOrFailById($id);
        $file = $titularityChange->file;
        $licenses = $this->licenseRepository->selectControl();
        $titulars = $this->titularRepository->selectControl();

        $titularityChangeStatuses = $this->titularityChangeStatuses;

        return view('titularityChange.edit', compact('titularityChange', 'file', 'licenses', 'titulars', 'titularityChangeStatuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateTitularityChangeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTitularityChangeRequest $request, $id)
    {
        $titularity_change_id = $this->titularityChangeRepository->update($request, $id);

        return redirect(route('titularitychange.show', ['id' => $titularity_change_id]));
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
        $titulars = $this->titularRepository->selectControl();

        return view('titularityChange.create', compact('license', 'titulars'));
    }

    /**
     * Show the form for editing the specified resource from a License.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editFromLicense($license_id, $id)
    {
        $titularityChange = $this->titularityChangeRepository->findOrFailById($id);
        $license = $this->licenseRepository->findOrFailById($license_id);
        $titulars = $this->titularRepository->selectControl();

        $titularityChangeStatuses = $this->titularityChangeStatuses;

        return view('titularityChange.edit', compact('titularityChange', 'license', 'titulars', 'titularityChangeStatuses'));
    }

    /**
     * Change Status of titularityChange.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function change(Request $request, $id)
    {
        $titularityChange = $this->titularityChangeRepository->findOrFailById($id);
        $license = $this->licenseRepository->findOrFailById($titularityChange->license_id);

        $status = $request->input('titularChange_status');

        if($status == 'Concedido') {
            $license->titular_id = $titularityChange->titular_id;
            $license->save();

        }

        if($status == 'Concedido' || $status == 'Desistido'){
            $titularityChange->status = $status;
            $titularityChange->finished = true;
            $titularityChange->finished_date = $request->input('titular_change_date');

            $titularityChange->save();
        }

        return redirect()->route('license.show', [$license->id]);
    }
}
