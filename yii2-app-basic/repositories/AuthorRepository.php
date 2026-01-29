<?php

namespace app\repositories;

use app\models\Author;
use yii\db\ActiveQuery;

class AuthorRepository
{
    /**
     * @return ActiveQuery
     */
    public function findAll()
    {
        return Author::find();
    }

    /**
     * @param int $id
     * @return Author|null
     */
    public function findById($id)
    {
        return Author::find()
            ->where(['id' => $id])
            ->with('books')
            ->one();
    }

    /**
     * @param array $ids
     * @return Author[]
     */
    public function findByIds(array $ids)
    {
        return Author::find()
            ->where(['id' => $ids])
            ->all();
    }

    /**
     * @param Author $author
     * @return bool
     */
    public function save(Author $author)
    {
        return $author->save();
    }

    /**
     * @param Author $author
     * @return bool|int
     */
    public function delete(Author $author)
    {
        return $author->delete();
    }

    /**
     * @param int $year
     * @param int $limit
     * @return Author[]
     */
    public function findTopByYear($year, $limit = 10)
    {
        return Author::find()
            ->select(['author.*', 'COUNT(book_author.book_id) as books_count'])
            ->innerJoin('book_author', 'author.id = book_author.author_id')
            ->innerJoin('book', 'book_author.book_id = book.id')
            ->where(['book.year' => $year])
            ->groupBy('author.id')
            ->orderBy(['books_count' => SORT_DESC])
            ->limit($limit)
            ->all();
    }
}

