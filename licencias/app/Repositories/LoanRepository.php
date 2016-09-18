<?php

namespace CityBoard\Repositories;

use CityBoard\Entities\Person;
use CityBoard\Repositories\RepositoryInterface;
use CityBoard\Entities\Loan;
use Illuminate\Http\Request;


class LoanRepository implements RepositoryInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return Loan::all();
    }

    /**
     * @param $number
     * @return mixed
     */
    public function paginate($number)
    {
        return Loan::paginate($number);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFailById($id)
    {
        return Loan::findOrFail($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $loan = new Loan();
        return $this->assignValues($request, $loan);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $loan = $this->findOrFailById($id);
        return $this->updateValues($request, $loan);
    }

    /**
     * @return static
     */
    public function selectControl()
    {
        return $this->all()->lists('id', 'id');
    }

    /**
     * @param Request $request
     * @param Loan $loan
     * @return mixed
     */
    private function assignValues(Request $request, Loan $loan)
    {
        $loan->license_id = $request->input('license_id');
        $loan->person_id = $request->input('person_id');
        $loan->loan_date = $request->input('loan_date');
        $loan->giving_back_date = $request->input('giving_back_date');

        $loan->save();

        return $loan->id;
    }

    /**
     * @param Request $request
     * @param Loan $loan
     * @return mixed
     */
    private function updateValues(Request $request, Loan $loan)
    {
        $loan->license_id = $request->input('license_id');
        $loan->person_id = $request->input('person_id');
        $loan->loan_date = $request->input('loan_date');
        $loan->giving_back_date = $request->input('giving_back_date');

        $loan->save();

        return $loan->id;
    }

    public function saveLoan(PersonRepository $personRepository, PersonPositionRepository $personPositionRepository, Request $request, $license_id) {
        $loan_id = $request->input('id');

        if(is_null($loan_id)){
            $loan = new Loan();
        } else {
            $loan = $this->findOrFailById($request->input('id'));
        }

        $loan->license_id = $license_id;

        $person_id = $request->input('person.id');

        if (is_null($person_id)) {
            $person = new Person();
        } else {
            $person = $personRepository->findOrFailById($person_id);
        }

        $person->first_name = $request->input('person.first_name');
        $person->last_name = $request->input('person.last_name');

        if(! is_null($request->input('person.email'))) {
            $person->email = $request->input('person.email');
        }

        if(is_null($person->person_position_id)) {
            $defaultPersonPosition = $personPositionRepository->obtainDefaultPersonPosition();
            $person->person_position_id = $defaultPersonPosition;
        }

        $person->save();

        $loan->person_id = $person->id;

        $loan->loan_date = $request->input('loan_date');

        //$loan->giving_back_date = $request->input('giving_back_date');

        $loan->giving_back_date = null;

        $loan->save();
    }

    public function saveCloseLoan(PersonRepository $personRepository, PersonPositionRepository $personPositionRepository, Request $request, $license_id) {
        $loan_id = $request->input('id');

        if(is_null($loan_id)){
            $loan = new Loan();
        } else {
            $loan = $this->findOrFailById($request->input('id'));
        }

        $loan->license_id = $license_id;

        $person_id = $request->input('person.id');

        if (is_null($person_id)) {
            $person = new Person();
        } else {
            $person = $personRepository->findOrFailById($person_id);
        }

        $person->first_name = $request->input('person.first_name');
        $person->last_name = $request->input('person.last_name');

        if(! is_null($request->input('person.email'))) {
            $person->email = $request->input('person.email');
        }

        if(is_null($person->person_position_id)) {
            $defaultPersonPosition = $personPositionRepository->obtainDefaultPersonPosition();
            $person->person_position_id = $defaultPersonPosition;
        }

        $person->save();

        $loan->person_id = $person->id;

        $loan->loan_date = $request->input('loan_date');

        $loan->giving_back_date = $request->input('giving_back_date');

        $loan->save();
    }
}