<?php

namespace SisFin\Http\Controllers\Api;

use SisFin\Http\Controllers\Controller;
use SisFin\Repositories\CategoriaRepository;
use SisFin\Http\Requests\CategoriaRequest;
use SisFin\Criteria\FindRootCategoriasCriteria;



class CategoriasController extends Controller
{

    /**
     * @var CategoriaRepository
     */
    protected $repository;

    public function __construct(CategoriaRepository $repository)
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
        $this->repository->pushCriteria(new FindRootCategoriasCriteria());
        $categorias = $this->repository->all();

        return $categorias;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoriaRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriaRequest $request)
    {
        $categoria = $this->repository->create($request->all());
        return response()->json($categoria, 201);
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
        $categoria = $this->repository->find($id);
        return response()->json($categoria);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  CategoriaRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(CategoriaRequest $request, $id)
    {
        $categoria = $this->repository->update($request->all(), $id);
        return response()->json($categoria);
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
