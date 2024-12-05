<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookBorrowingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "user"  => $this->user->name,
            "book"  => $this->book->title,
            "from"  => $this->from,
            "to"    => $this->to

        ];
    }
}
