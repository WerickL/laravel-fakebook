<?php

namespace Api\File\Http\Controllers;

use Api\File\Http\Requests\CreateFileRequest;
use Api\File\Model\File;
use Api\File\Repository\IFileRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class FileController extends Controller
{
    public function __construct(protected IFileRepository $repository)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        //
    }
    public function postFile(CreateFileRequest $request){
        
        $file = $this->repository->create($request->toDto());
        if (!empty($file)) {
            $contentFile =  $request->file('content');
            if (empty($contentFile)) {
                return response()->json([
                    "detail" => "Nenhum arquivo foi localizado"
                ], 422);
            }
            $success = $this->repository->setContent($file,$contentFile);
            if (!$success) {
                return response()->json([
                    "detail" => "Não foi possível salvar o arquivo no disco"
                ], 422);
            }
            return response()->json($file,201);
        }
        return response()->json([
            "detail" => "Um erro desconhecido ocorreu"
        ],400);
    }
    public function getFile(Request $request){
        return response()->json("Opa",200);
    }
}
