<?php

namespace Api\File\Http\Controllers;

use Api\File\Model\File;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class FileController extends Controller
{
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
    public function postFile(Request $request){
        $file = File::create([
            "name"=>"teste_arquivo.png",
            "description" => "teste",
            "uuid" => Uuid::uuid4(),
            "content_type" => "image/png"
        ]);
        // cria model 
        // cria uuid
        // cria arquivo com o uuid
        // adiciona nomne na model
        return response()->json($file,201);
    }
    public function getFile(Request $request){
        return response()->json("Opa",200);
    }
}
