<?php

namespace CityBoard\Http\Controllers;

use Illuminate\Http\Request;

use CityBoard\Http\Requests;
use CityBoard\Http\Controllers\Controller;
use CityBoard\Entities\License;
use CityBoard\Entities\Alert;
use CityBoard\Entities\TypeAlert;
use CityBoard\Entities\TimeLimit;
use Carbon\Carbon;
use CityBoard\Repositories\LicenseRepository;

class AlertController extends Controller
{

    protected $licenseRepository;

    public function __construct()
    {
        $this->licenseRepository = new LicenseRepository();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
        $alerts2 = Alert::whereDate('date', '=', date('Y-m-d'))->get();
        
        $alerts = array();

        $expedient_number;
        $type;

        foreach ($alerts2 as $key => $value) {
            
            $value->license = License::all()->where('id', $value->license_id);
            foreach ($value->license as $key => $lis) {
                $expedient_number = $lis->expedient_number;
            }
            $typeA = TypeAlert::all()->where('id', $value->type_alert_id);
            foreach ($typeA as $key => $typAl) {
                $type = $typAl->type;
            }
            if ($value->type_alert_id == 1) {
                $alerts[] = array(
                    'id' => $value->id,
                    'title' => $value->title,
                    'description' => $value->description,
                    'type' => $type,
                    'expedient_number' => $expedient_number,
                    'date' => $value->date
                );
            } elseif($value->type_alert_id == 4) {
                $alerts[] = array(
                    'id' => $value->id,
                    'title' => $value->title,
                    'description' => $value->description,
                    'type' => $type,
                    'expedient_number' => $expedient_number,
                    'date' => $value->date
                );
            }elseif ($value->type_alert_id == 2) {
                
                $alerts[] = array(
                    'id' => $value->id,
                    'title' => $value->title,
                    'description' => $value->description,
                    'type' => $type,
                    'expedient_number' => $expedient_number,
                    'date' => $value->date
                );
            }
        }
        return view('alert.index', compact('alerts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $licence = $this->licenseRepository->selectControl();
        $typeAlert = TypeAlert::OrderBy('id','ASC')->lists('type','id');

        return view('alert.create', compact('licence', 'typeAlert'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        Alert::create($request->all());
        return redirect(route('alert.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $licence = $this->licenseRepository->selectControl();
        $alert = Alert::all()->where('id', $id);
        $typeAlert = TypeAlert::OrderBy('id','ASC')->lists('type','id');
        $objetoAlerta;
        foreach ($alert as $key => $value) {
            # code...
            $objetoAlerta = $value;
        }
        //dd($objetoAlerta);
        return view('alert.edit', compact('objetoAlerta','licence', 'typeAlert'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $alert = Alert::find($id);
            //dd($alert);
            $alert->update($request->all());
            return redirect(route('alert.index'));
        }catch (Exception $e){
            \Log::info('Error creating user: '.$e);
            return \Response::json(['created' => false], 500);
        }
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
        //dd($id);
        Alert::destroy($id);
        return \Response::json(['deleted' => true], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createModal(Request $request) {
        try{

            Alert::create($request->all());
            return ['created' => true];
        }catch (Exception $e){
            \Log::info('Error creating user: '.$e);
            return \Response::json(['created' => false], 500);
        }
    }

    /**
    *
    */
    public function getAlertLicenses($id) {
        $alerts = Alert::where('license_id', $id)
        ->where('type_alert_id', 4)->get();
        foreach ($alerts as $key => $value) {
            $typeA = TypeAlert::all()->where('id', $value->type_alert_id);
            foreach ($typeA as $key => $lis) {
                $value->type = $lis->type;
            }
        }
        return $alerts;
    }

    public function getTypeAlert(){
        return TypeAlert::all();
    }


    public function getAlertCalendar() {
        $alert = Alert::all();
        $result = array();

        foreach ($alert as $key => $value) {
            
            # Se setea los valores de las alertas 
            # para enviarlos al calendario.
            $value->license = License::all()->where('id', $value->license_id);
            foreach ($value->license as $key => $lis) {
                $value->expedient_number = $lis->expedient_number;
            }
            $typeA = TypeAlert::all()->where('id', $value->type_alert_id);
            foreach ($typeA as $key => $typAl) {
                $value->type = $typAl->type;
            }
            $date = $value->date;

            if ($value->type_alert_id == 2) {
                
                $result[] = array(
                    'id' => $value->id,
                    'title' => $value->title,
                    'url' => "",
                    'class' => "event-warning",
                    'start' => strtotime($date) . '000',
                    'end' => strtotime($date) . '999',
                    'description' => $value->description,
                    'license' => $value->expedient_number,
                    'type_alert' => $value->type,
                    'urlLicencia' => "../license/".$value->license_id
                );
            }
            if ($value->type_alert_id == 3) {
                $result[] = array(
                    'id' => $value->id,
                    'title' => $value->title,
                    'url' => "",
                    'class' => "event-success",
                    'start' => strtotime($date) . '000',
                    'end' => strtotime($date) . '999',
                    'description' => $value->description,
                    'license' => $value->expedient_number,
                    'type_alert' => $value->type,
                    'urlLicencia' => "../license/".$value->license_id
                );
            }
        }
        return json_encode($result);
    }
}
