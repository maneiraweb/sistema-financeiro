<?php

namespace SisFin\Http\Controllers\Api;

use SisFin\Http\Controllers\Controller;
use SisFin\Http\Requests;
use SisFin\Http\Requests\BillPayCreateRequest;
use SisFin\Http\Requests\BillPayUpdateRequest;
use SisFin\Repositories\BillPayRepository;


class BillPaysController extends Controller
{

    /**
     * @var BillPayRepository
     */
    protected $repository;

    public function __construct(BillPayRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $billPays = $this->repository->paginate();

        return $billPays;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ContaBancariaCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ContaBancariaCreateRequest $request)
    {
        $billPay = $this->repository->create($request->all());
        return response()->json($billPay, 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $billPay = $this->repository->find($id);
        return response()->json($billPay);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  ContaBancariaUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(ContaBancariaUpdateRequest $request, $id)
    {
        $billPay = $this->repository->update($request->all(), $id);
        return response()->json($billPay);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $this->repository->delete($id);
       return response()->json([], 204);
    }
}
