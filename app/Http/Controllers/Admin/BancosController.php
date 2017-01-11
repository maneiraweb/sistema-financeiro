<?php

namespace SisFin\Http\Controllers\Admin;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use SisFin\Http\Controllers\Controller;
use SisFin\Http\Controllers\Response;
use SisFin\Http\Requests\BancoCreateRequest;
use SisFin\Http\Requests\BancoUpdateRequest;
use SisFin\Repositories\BancoRepository;
use SisFin\Models\Banco;


class BancosController extends Controller
{

    /**
     * @var BancoRepository
     */
    protected $repository;


    public function __construct(BancoRepository $repository)
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
        $bancos = $this->repository->paginate(5);

        /*if (request()->wantsJson()) {

            return response()->json([
                'data' => $bancos,
            ]);
        }*/
        return view('admin.bancos.index', compact('bancos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BancoCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    
    public function create() {
        return view('admin.bancos.create');
    }
    
    public function store(BancoCreateRequest $request)
    {
        $data = $request->all();
        $banco = $this->repository->create($data);

            /*if ($request->wantsJson()) {
                $response = [
                    'message' => 'Banco criado.',
                    'data'    => $banco->toArray(),
                ];
                return response()->json($response);
            }*/

        return redirect()->route('admin.bancos.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banco = $this->repository->find($id);
        return view('admin.bancos.edit', compact('banco'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  BancoUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(BancoUpdateRequest $request, $id)
    {
        $banco = $this->repository->update($request->all(), $id);

            /*if ($request->wantsJson()) {
                $response = [
                    'message' => 'Banco updated.',
                    'data'    => $banco->toArray(),
                ];
                return response()->json($response);
            }*/

        return redirect()->route('admin.bancos.index');
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
        $deleted = $this->repository->delete($id);

        // if (request()->wantsJson()) {

        //     return response()->json([
        //         'message' => 'Bank deleted.',
        //         'deleted' => $deleted,
        //     ]);
        // }

        return redirect()->back()->with('message', 'Banco deletado.');
    }
}
