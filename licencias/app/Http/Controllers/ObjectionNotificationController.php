<?php

namespace CityBoard\Http\Controllers;

use CityBoard\Http\Controllers\Controller;

use CityBoard\Repositories\ObjectionNotificationRepository;
use CityBoard\Repositories\ObjectionRepository;
use CityBoard\Repositories\TimeLimitRepository;

use CityBoard\Http\Requests;
use CityBoard\Http\Requests\StoreObjectionNotificationRequest;
use CityBoard\Http\Requests\UpdateObjectionNotificationRequest;
use Illuminate\Http\Request;


class ObjectionNotificationController extends Controller
{
    protected $objectionNotificationRepository;
    protected $objectionRepository;
    protected $timeLimitRepository;

    public function __construct()
    {
        $this->objectionNotificationRepository = new ObjectionNotificationRepository();
        $this->objectionRepository = new ObjectionRepository();
        $this->timeLimitRepository = new TimeLimitRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amount = $this->objectionNotificationRepository->all()->count();
        $objectionNotifications = $this->objectionNotificationRepository->paginate(20);

        return view('objectionNotification.index', compact('objectionNotifications', 'amount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $objections = $this->objectionRepository->selectControl();
        $timeLimits = $this->timeLimitRepository->selectControl();

        return view('objectionNotification.create', compact('objections', 'timeLimits'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreObjectionNotificationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreObjectionNotificationRequest $request)
    {
        $objectionNotification_id = $this->objectionNotificationRepository->create($request);

        return redirect(route('objectionnotification.show', ['id' => $objectionNotification_id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $objectionNotification = $this->objectionNotificationRepository->findOrFailById($id);

        return view('objectionNotification.show', compact('objectionNotification'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $objectionNotification = $this->objectionNotificationRepository->findOrFailById($id);
        $objections = $this->objectionRepository->selectControl();
        $timeLimits = $this->timeLimitRepository->selectControl();

        return view('objectionNotification.edit', compact('objectionNotification', 'objections', 'timeLimits'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateObjectionNotificationRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateObjectionNotificationRequest $request, $id)
    {

        $objectionNotification_id = $this->objectionNotificationRepository->update($request, $id);

        return redirect(route('objectionnotification.show', ['id' => $objectionNotification_id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $objection_id
     * @param $notification_id
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Request $request, $objection_id, $notification_id)
    {
        $notification = $this->objectionNotificationRepository->findOrFailById($notification_id);
        if ($notification->objection_id == $objection_id) {
            $notification->delete();
        }

        $objection = $this->objectionRepository->findOrFailById($objection_id);

        $response = [
          'stageObjectionNotifications' => $objection->objectionNotifications()->get(),
          'stageObjectionNotificationNext' => $this->objectionRepository->nextTimeLimit($objection),
        ];

        return response()->json($response, 200);
    }
}
