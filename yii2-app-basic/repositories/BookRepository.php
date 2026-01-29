<?php

namespace app\repositories;

use app\models\Book;
use yii\db\ActiveQuery;

class BookRepository
{
    /**
     * @return ActiveQuery
     */
    public function findAll()
    {
        return Book::find()->with('authors');
    }

    /**
     * @param int $id
     * @return Book|null
     */
    public function findById($id)
    {
        return Book::find()
            ->where(['id' => $id])
            ->with('authors')
            ->one();
    }

    /**
     * @param Book $book
     * @return bool
     */
    public function save(Book $book)
    {
        return $book->save();
    }

    /**
     * @param Book $book
     * @return bool|int
     */
    public function delete(Book $book)
    {
        return $book->delete();
    }
}

