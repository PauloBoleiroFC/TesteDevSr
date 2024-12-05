<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookBorrowingResource;
use App\Mail\SendNotification;
use App\Repositories\BookBorrowingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookBorrowingController extends Controller
{

    protected $bookBorrowingRepository;

    public function __construct(BookBorrowingRepository $bookBorrowingRepository)
    {
        $this->bookBorrowingRepository = $bookBorrowingRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/book-borrowing",
     *     tags={"BookBorrowing"},
     *     summary="Lista todos os livros emprestados",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de autores",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", description="ID do autor"),
     *                 @OA\Property(property="user", type="string", description="Nome do usuário"),
     *                 @OA\Property(property="book", type="string", description="Nome do livro"),
     *                 @OA\Property(property="from", type="string", description="Data do empréstimo"),
     *                 @OA\Property(property="to", type="string", description="Data da devolução")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return BookBorrowingResource::collection($this->bookBorrowingRepository->all());
    }

    /**
     * @OA\Post(
     *     path="/api/book-borrowings/store",
     *     tags={"BookBorrowing"},
     *     summary="Empresat um livro",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"book_id", "user_id", "from", "to"},
     *             @OA\Property(property="book_id", type="string", description="1"),
     *             @OA\Property(property="user_id", type="string", description="1"),
     *             @OA\Property(property="from", type="string", description="2024-12-01"),
     *             @OA\Property(property="to", type="string", description="2024-12-01")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="livro emprestado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Record saved successfully!"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="book_id", type="string", description="1"),
     *                 @OA\Property(property="user_id", type="string", description="1"),
     *                 @OA\Property(property="from", type="string", description="2024-12-01"),
     *                 @OA\Property(property="to", type="string", description="2024-12-01")
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
            $return = $this->bookBorrowingRepository->create($request->input());

            // Send notification
            $bookBorrowing = $this->bookBorrowingRepository->show($return->id);
            $content = new \stdClass();
            $content->name  = $bookBorrowing->user->name;
            $content->email = $bookBorrowing->user->email;
            $content->book  = $bookBorrowing->book->title;
            $content->from  = $bookBorrowing->from;
            $content->to    = $bookBorrowing->to;
            Mail::to($bookBorrowing->user->email, $bookBorrowing->user->name)->send(new SendNotification($content));

            return response()->json([
                'success' => true,
                'message' => 'Record saved successfully!',
            ], 201);

        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Error trying to save.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
