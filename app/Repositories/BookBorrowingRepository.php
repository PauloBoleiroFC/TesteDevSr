<?php

namespace App\Repositories;

use App\Models\BookBorrowing;

class BookBorrowingRepository extends AbstractRepository
{

    /**
     * @var BookBorrowing
     */
    protected $model;

    /**
     * @param BookBorrowing $model
     */
    public function __construct(BookBorrowing $model)
    {
        $this->model = $model;
    }

}
