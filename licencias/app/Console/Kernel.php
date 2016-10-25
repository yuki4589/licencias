<?php

namespace CityBoard\Console;

use Illuminate\Console\Scheduling\Schedule;
use CityBoard\Entities\Alert;
use CityBoard\Entities\License;
use CityBoard\Entities\LicenseCurrentStage;
use CityBoard\Entities\Street;
use CityBoard\Entities\Activity;
use CityBoard\Entities\TimeLimit;
use Carbon\Carbon;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \CityBoard\Console\Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();
        $schedule->call(function () {

            $licenseObjeto = License::whereIn('license_status_id', [1,2])->get();
            foreach ($licenseObjeto as $key => $value) {
                try { 
                
                    $licenciaCurrentStage = LicenseCurrentStage::where('license_id', $value->id)
                        ->where('id', $value->last_current_stage_id)->get()[0];
                    
                    $fechaActual = Carbon::now();
                    $ultimaModificacion = Carbon::parse($licenciaCurrentStage->updated_at);
                    
                    $timeLimit = TimeLimit::where('code', 'LTAP')->get()[0];
                    
                    if ($fechaActual->diffInDays($ultimaModificacion) > $timeLimit->days) {
                        $descripcion = '';
                        $alertPlaso = Alert::where('license_id', $value->id)
                            ->where('type_alert_id', 3)->get();
                        foreach ($alertPlaso as $key => $alert) {
                            $alert->forceDelete();
                        }
                        $alertaObjeto = new Alert();
                        
                        $alertaObjeto->date = Carbon::now()->toDateTimeString();
                        $alertaObjeto->title = $value->expedient_number . ' - Plazo';
                        $alertaObjeto->license_id = $value->id;
                        $alertaObjeto->type_alert_id = 3;

                        $streets = Street::find($value->street_id);
                        
                        $activties = Activity::find($value->activity_id);

                        $descripcion .= '* Nombre del negocio: ' . $value->commerce_name; 
                        $descripcion .= " * Dirección:  ". $streets->name . ' número: ' . $value->street_number; 
                        $descripcion .= " * Ciudad: ". $value->city; 
                        $descripcion .= " * Actividad: ". $activties->name;  
                            
                        $alertaObjeto->description = $descripcion;
                    
                        Alert::create(json_decode($alertaObjeto, true));
                    }  
                } catch(\Exception $e) { 
                    get_class($e); 
                }
            }
        })->dailyAt('00:05');
    }
}
