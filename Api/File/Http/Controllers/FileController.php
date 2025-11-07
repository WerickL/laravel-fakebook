<?php

namespace Api\File\Http\Controllers;

use Api\File\Http\Requests\CreateFileRequest;
use Api\File\Model\File;
use Api\File\Repository\IFileRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Gate;

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
        $fileable = null;
        
        if (!empty($request->post_id)) {
            $post = \Api\Post\Model\Post::find($request->post_id);
            if (empty($post)) {
                return response()->json([
                    "detail" => "Post não encontrado"
                ], 404);
            }
            if ($post->status != \Api\Post\Model\PostStatusEnum::Draft) {
                return response()->json([
                    "detail" => "Post não está em rascunho"
                ], 403);
            }
            if (!Gate::allows("attachFile", $post)) {
                return response()->json([
                    "detail" => "Você não tem permissão para anexar arquivos a este post"
                ], 403);
            }
            $fileable = $post;
        }
        $fileDto = $request->toDto();
        if (!empty($fileable)) {
            $fileDto->fileable_id = $fileable->id;
            $fullyQualifiedName = $fileable::class;
            $baseName = basename(str_replace('\\', '/', $fullyQualifiedName));
            $fileDto->fileable_type = $baseName;
        }

        $file = $this->repository->create($fileDto);
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
    public function getFile(Request $request, ?string $uuid = null){
        if (empty($uuid)) {
            return response()->json([
                "detail" => "UUID do arquivo não informado"
            ], 422);
        }
        $file = $this->repository->findByUuid($uuid);
        if (empty($file)) {
            return response()->json([
                "detail" => "Arquivo não encontrado"
            ], 404);
        }
        $content = $this->repository->getContent($file);
        if (empty($content)) {
            return response()->json([
                "detail" => "Conteúdo do arquivo não encontrado"
            ], 404);
        }
        return response($content, 200)
    ->header('Content-Type', $file->content_type);
    }
}
