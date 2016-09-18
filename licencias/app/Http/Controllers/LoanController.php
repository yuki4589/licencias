<?php

namespace CityBoard\Http\Controllers;

use CityBoard\Http\Controllers\Controller;

use CityBoard\Repositories\LoanRepository;
use CityBoard\Repositories\LicenseRepository;
use CityBoard\Repositories\PersonPositionRepository;
use CityBoard\Repositories\PersonRepository;

use CityBoard\Http\Requests;
use CityBoard\Http\Requests\StoreLoanRequest;
use CityBoard\Http\Requests\UpdateLoanRequest;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    protected $loanRepository;
    protected $licenseRepository;
    protected $personRepository;

    public function __construct()
    {
        $this->loanRepository = new LoanRepository();
        $this->licenseRepository = new LicenseRepository();
        $this->personRepository = new PersonRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amount = $this->loanRepository->all()->count();
        $loans = $this->loanRepository->paginate(20);

        return view('loan.index', compact('loans', 'amount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $licenses = $this->licenseRepository->selectControl();
        $people = $this->personRepository->selectControl();

        return view('loan.create', compact('licenses', 'people'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreLoanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLoanRequest $request)
    {
        $loan_id = $this->loanRepository->create($request);

        return redirect(route('loan.show', ['id' => $loan_id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loan = $this->loanRepository->findOrFailById($id);

        return view('loan.show', compact('loan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loan = $this->loanRepository->findOrFailById($id);
        $licenses = $this->licenseRepository->selectControl();
        $people = $this->personRepository->selectControl();

        return view('loan.edit', compact('loan', 'licenses', 'people'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateLoanRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLoanRequest $request, $id)
    {

        $loan_id = $this->loanRepository->update($request, $id);

        return redirect(route('loan.show', ['id' => $loan_id]));
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
     * @param \Illuminate\Http\Request $request
     * @param \CityBoard\Repositories\LicenseRepository $licenseRepository
     * @param \CityBoard\Repositories\LoanRepository $loanRepository
     * @param \CityBoard\Repositories\PersonPositionRepository $personPositionRepository
     * @param \CityBoard\Repositories\PersonRepository $personRepository
     * @param $license_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveLoan(Request $request, LicenseRepository $licenseRepository, LoanRepository $loanRepository, PersonPositionRepository $personPositionRepository, PersonRepository $personRepository, $license_id) {
        $loanRepository->saveLoan($personRepository, $personPositionRepository, $request, $license_id);

        $license = $licenseRepository->findOrFailById($license_id);
        $people = $personRepository->all();

        $response = [
            'people' => $people,
            'active_loan' => $license->active_loan,
        ];

        return response()->json($response, 200);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \CityBoard\Repositories\LicenseRepository $licenseRepository
     * @param \CityBoard\Repositories\LoanRepository $loanRepository
     * @param \CityBoard\Repositories\PersonPositionRepository $personPositionRepository
     * @param \CityBoard\Repositories\PersonRepository $personRepository
     * @param $license_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveCloseLoan(Request $request, LicenseRepository $licenseRepository, LoanRepository $loanRepository, PersonPositionRepository $personPositionRepository, PersonRepository $personRepository, $license_id) {
        $loanRepository->saveCloseLoan($personRepository, $personPositionRepository, $request, $license_id);

        $license = $licenseRepository->findOrFailById($license_id);
        $people = $personRepository->all();

        $response = [
          'people' => $people,
          'license' => $license,
        ];

        return response()->json($response, 200);
    }
}
