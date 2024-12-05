<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Repositories\AuthorRepository;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class AuthorController extends Controller
{
    protected $authorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/authors",
     *     tags={"Authors"},
     *     summary="Lista todos os autores",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de autores",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", description="ID do autor"),
     *                 @OA\Property(property="name", type="string", description="Nome do autor")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return $this->authorRepository->all();
    }

    /**
     * @OA\Post(
     *     path="/api/authors/store",
     *     tags={"Authors"},
     *     summary="Cria um novo autor",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "birth_date"},
     *             @OA\Property(property="name", type="string", description="Nome do autor"),
     *             @OA\Property(property="birth_date", type="string", description="1981-10-21")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Autor criado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Record saved successfully!"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", description="ID do autor"),
     *                 @OA\Property(property="name", type="string", description="Nome do autor"),
     *                 @OA\Property(property="birth_date", type="string", description="1981-10-21")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao salvar",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error trying to save."),
     *             @OA\Property(property="error", type="string", example="Detalhes do erro")
     *         )
     *     )
     * )
     */
    public function store(AuthorRequest $request)
    {
        try{
            $author = $this->authorRepository->create($request->input());

            return response()->json([
                'success' => true,
                'message' => 'Record saved successfully!',
                'data' => $author,
            ], 201);

        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Error trying to save.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/authors/{id}/show",
     *     tags={"Authors"},
     *     summary="Exibe os detalhes de um autor",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do autor",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", description="ID do autor"),
     *             @OA\Property(property="name", type="string", description="Nome do autor")
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        return $this->authorRepository->show($id);
    }

    /**
     * @OA\Put(
     *     path="/api/authors/{id}/update",
     *     tags={"Authors"},
     *     summary="Atualiza os dados de um autor",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name"},
     *             @OA\Property(property="name", type="string", description="Nome do autor")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Autor atualizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Record changed successfully!"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", description="ID do autor"),
     *                 @OA\Property(property="name", type="string", description="Nome do autor")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao atualizar",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error trying to update."),
     *             @OA\Property(property="error", type="string", example="Detalhes do erro")
     *         )
     *     )
     * )
     */
    public function update(AuthorRequest $request, string $id)
    {
        try{
            $author = $this->authorRepository->update($id, $request->input());

            return response()->json([
                'success' => true,
                'message' => 'Record changed successfully!',
                'data' => $author,
            ], 201);

        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Error trying to update.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/authors/{id}/destroy",
     *     tags={"Authors"},
     *     summary="Remove um autor",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Autor removido com sucesso"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao remover",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error trying to delete."),
     *             @OA\Property(property="error", type="string", example="Detalhes do erro")
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        return $this->authorRepository->delete($id);
    }
}
