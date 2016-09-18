<?php

namespace CityBoard\Repositories;

use Carbon\Carbon;
use CityBoard\Repositories\RepositoryInterface;
use CityBoard\Entities\ObjectionNotification;
use Illuminate\Http\Request;


class ObjectionNotificationRepository implements RepositoryInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return ObjectionNotification::all();
    }

    /**
     * @param $number
     * @return mixed
     */
    public function paginate($number)
    {
        return ObjectionNotification::paginate($number);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFailById($id)
    {
        return ObjectionNotification::findOrFail($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $objectionNotification = new ObjectionNotification();
        return $this->assignValues($request, $objectionNotification);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $objectionNotification = $this->findOrFailById($id);
        return $this->updateValues($request, $objectionNotification);
    }

    /**
     * @return static
     */
    public function selectControl()
    {
        return $this->all()->lists('url', 'id');
    }

    /**
     * @param Request $request
     * @param $objectionNotification
     * @return mixed
     */
    private function assignValues(Request $request, $objectionNotification)
    {
        $objectionNotification->objection_id = $request->input('objection_id');
        $objectionNotification->time_limit_id = $request->input('time_limit_id');
        $objectionNotification->notification_date = $request->input('notification_date');
        $objectionNotification->finish_date = $request->input('finish_date');

        $objectionNotification->save();

        return $objectionNotification->id;
    }

    /**
     * @param Request $request
     * @param $objectionNotification
     * @return mixed
     */
    private function updateValues(Request $request, $objectionNotification)
    {

        $objectionNotification->objection_id = $request->input('objection_id');
        $objectionNotification->time_limit_id = $request->input('time_limit_id');
        $objectionNotification->notification_date = $request->input('notification_date');
        $objectionNotification->finish_date = $request->input('finish_date');

        $objectionNotification->save();

        return $objectionNotification->id;
    }

    public function numberOfNotifications($id)
    {
        $objectionRepository = new ObjectionRepository();
        $objection = $objectionRepository->findOrFailById($id);
        return $objection->objectionNotifications()->count();
    }

    public function listOfTimeLimitIds($id)
    {

        $objectionRepository = new ObjectionRepository();
        $objection = $objectionRepository->findOrFailById($id);

        $ids = [];

        foreach ($objection->objectionNotifications as $notification) {
            $ids[] = $notification->time_limit_id;
        }

        return $ids;
    }

    /**
     * @param $requestJson
     * @param $objection
     */
    public function createNewObjectionNotification($requestJson, $objection) {
        $objectionRepository = new ObjectionRepository();

        $timeLimit = $objectionRepository->nextTimeLimit($objection);

        $notification_date = $requestJson['notification_date'];
        if(!empty($requestJson['notification_date'])) {
            $objectionNotification = new ObjectionNotification();

            $objectionNotification->objection_id = $objection->id;
            $objectionNotification->time_limit_id = $timeLimit->id;

            $objectionNotification->notification_date = $notification_date;
            $objectionNotification->finish_date = Carbon::createFromTimestamp(strtotime($notification_date))
              ->addDays($timeLimit->days);

            $objectionNotification->save();
        }
    }
}