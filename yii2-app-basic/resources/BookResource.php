<?php

namespace app\resources;

use app\models\Book;

class BookResource
{
    private $book;

    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $authors = [];
        foreach ($this->book->authors as $author) {
            $authors[] = [
                'id' => $author->id,
                'full_name' => $author->full_name,
            ];
        }

        return [
            'id' => $this->book->id,
            'title' => $this->book->title,
            'year' => $this->book->year,
            'description' => $this->book->description,
            'isbn' => $this->book->isbn,
            'cover_photo' => $this->book->cover_photo,
            'authors' => $authors,
        ];
    }

    /**
     * @param Book[] $books
     * @return array
     */
    public static function collection($books)
    {
        $result = [];
        foreach ($books as $book) {
            $result[] = (new self($book))->toArray();
        }
        return $result;
    }
}

