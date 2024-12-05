<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Repositories\BookRepository;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/books",
     *     tags={"Books"},
     *     summary="Lista todos os livros",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de livros",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", description="ID do livro"),
     *                 @OA\Property(property="name", type="string", description="Nome do livro")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return $this->bookRepository->all();
    }

    /**
     * @OA\Post(
     *     path="/api/books/store",
     *     tags={"Books"},
     *     summary="Cria um novo livro",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"title", "year"},
     *             @OA\Property(property="title", type="string", description="Título do livro"),
     *             @OA\Property(property="year", type="string", description="2024")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="livro criado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Record saved successfully!"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", description="ID do livro"),
     *                 @OA\Property(property="name", type="string", description="Nome do livro"),
     *                 @OA\Property(property="year", type="string", description="Ano do livro")
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
    public function store(Request $request)
    {
        try{
            $book = $this->bookRepository->create($request->input());

            return response()->json([
                'success' => true,
                'message' => 'Record saved successfully!',
                'data' => $book,
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
     *     path="/api/books/{id}/show",
     *     tags={"Books"},
     *     summary="Exibe os detalhes de um livro",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do livro",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", description="ID do livro"),
     *             @OA\Property(property="name", type="string", description="Nome do livro")
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        return BookResource::make($this->bookRepository->show($id, 'authors'));
    }

    /**
     * @OA\Put(
     *     path="/api/books/{id}/update",
     *     tags={"Books"},
     *     summary="Atualiza os dados de um livro",
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
     *             @OA\Property(property="name", type="string", description="Nome do livro")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="livro atualizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Record changed successfully!"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", description="ID do livro"),
     *                 @OA\Property(property="name", type="string", description="Nome do livro")
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
    public function update(BookRequest $request, string $id)
    {
        try{
            $book = $this->bookRepository->update($id, $request->input());

            return response()->json([
                'success' => true,
                'message' => 'Record changed successfully!',
                'data' => $book,
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
     *     path="/api/books/{id}/destroy",
     *     tags={"Books"},
     *     summary="Remove um livro",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="livro removido com sucesso"
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
        return $this->bookRepository->delete($id);
    }

    /**
     * @OA\Post(
     *     path="/api/books/{id}/attach-authors",
     *     tags={"Books"},
     *     summary="Adiciona autores a um novo livro",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do livro ao qual os autores serão associados",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"authors"},
     *             @OA\Property(
     *                 property="authors",
     *                 type="array",
     *                 @OA\Items(
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 description="Lista de IDs dos autores a serem associados ao livro"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Autores adicionados com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Record saved successfully!"),
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
    public function attachAuthors(BookRequest $request, int $id)
    {

        try{
            $this->bookRepository->attachAuthors($id, $request->authors);

            return response()->json([
                'success' => true,
                'message' => 'Record changed successfully!'
            ], 201);

        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Error trying to update.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
