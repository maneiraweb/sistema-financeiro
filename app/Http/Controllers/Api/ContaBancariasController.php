<?php

namespace SisFin\Http\Controllers\Api;

use SisFin\Http\Controllers\Controller;
use SisFin\Http\Requests;
use SisFin\Http\Requests\ContaBancariaCreateRequest;
use SisFin\Http\Requests\ContaBancariaUpdateRequest;
use SisFin\Repositories\ContaBancariaRepository;
use SisFin\Criteria\FindByNameCriteria;
use SisFin\Criteria\FindByLikeAgenciaCriteria;


class ContaBancariasController extends Controller
{

    /**
     * @var ContaBancariaRepository
     */
    protected $repository;

    public function __construct(ContaBancariaRepository $repository)
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
        /*$this->repository->pushCriteria(new FindByNameCriteria('Lake Mustafaborough'))
            ->pushCriteria(new FindByLikeAgenciaCriteria('4'));*/
        $contaBancarias = $this->repository->paginate();

        return $contaBancarias;
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
        $contaBancaria = $this->repository->create($request->all());
        return response()->json($contaBancaria, 201);
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
        $contaBancaria = $this->repository->find($id);
        return response()->json($contaBancaria);
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
        $contaBancaria = $this->repository->update($request->all(), $id);
        return response()->json($contaBancaria);
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
