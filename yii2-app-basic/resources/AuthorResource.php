<?php

namespace app\resources;

use app\models\Author;

class AuthorResource
{
    private $author;

    public function __construct(Author $author)
    {
        $this->author = $author;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $books = [];
        foreach ($this->author->books as $book) {
            $books[] = [
                'id' => $book->id,
                'title' => $book->title,
            ];
        }

        return [
            'id' => $this->author->id,
            'full_name' => $this->author->full_name,
            'books' => $books,
            'books_count' => count($this->author->books),
        ];
    }

    /**
     * @param Author[] $authors
     * @return array
     */
    public static function collection($authors)
    {
        $result = [];
        foreach ($authors as $author) {
            $result[] = (new self($author))->toArray();
        }
        return $result;
    }
}

