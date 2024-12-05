<?php

namespace App\Repositories;

use App\Models\Author;

class AuthorRepository extends AbstractRepository
{

    /**
     * @var Author
     */
    protected $model;

    /**
     * @param Author $model
     */
    public function __construct(Author $model)
    {
        $this->model = $model;
    }

}
