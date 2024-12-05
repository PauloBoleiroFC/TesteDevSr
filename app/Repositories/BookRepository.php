<?php

namespace App\Repositories;

use App\Models\Book;

class BookRepository extends AbstractRepository
{

    /**
     * @var Book
     */
    protected $model;

    /**
     * @param Book $model
     */
    public function __construct(Book $model)
    {
        $this->model = $model;
    }

    /**
     * @param int $id
     * @param array $authors
     * @return mixed
     */
    public function attachAuthors(int $id, array $authors)
    {

        return Book::find($id)->authors()->attach($authors);

    }

}
