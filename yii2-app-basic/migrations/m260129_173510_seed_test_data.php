<?php

use yii\db\Migration;
use app\models\Author;
use app\models\Book;
use app\models\BookAuthor;
use app\models\User;
use app\models\Subscription;

class m260129_173510_seed_test_data extends Migration
{
    public function safeUp()
    {
        // --- Авторы ---
        $authors = [
            ['full_name' => 'Лев Толстой'],
            ['full_name' => 'Фёдор Достоевский'],
            ['full_name' => 'Антон Чехов'],
            ['full_name' => 'Александр Пушкин'],
            ['full_name' => 'Николай Гоголь'],
        ];

        foreach ($authors as $data) {
            $author = new Author();
            $author->full_name = $data['full_name'];
            $author->save(false);
        }

        // --- Книги ---
        $books = [
            ['title' => 'Война и мир', 'year' => 1869, 'description' => 'Эпический роман', 'isbn' => '1111111111111', 'cover_photo' => null],
            ['title' => 'Преступление и наказание', 'year' => 1866, 'description' => 'Роман о морали', 'isbn' => '2222222222222', 'cover_photo' => null],
            ['title' => 'Анна на шее', 'year' => 1895, 'description' => 'Рассказ', 'isbn' => '3333333333333', 'cover_photo' => null],
            ['title' => 'Евгений Онегин', 'year' => 1833, 'description' => 'Роман в стихах', 'isbn' => '4444444444444', 'cover_photo' => null],
            ['title' => 'Мёртвые души', 'year' => 1842, 'description' => 'Сатирический роман', 'isbn' => '5555555555555', 'cover_photo' => null],
        ];

        foreach ($books as $data) {
            $book = new Book();
            $book->title = $data['title'];
            $book->year = $data['year'];
            $book->description = $data['description'];
            $book->isbn = $data['isbn'];
            $book->cover_photo = $data['cover_photo'];
            $book->save(false);
        }

        // --- Связи книги-авторы ---
        $bookAuthorMap = [
            1 => [1],        // Война и мир -> Лев Толстой
            2 => [2],        // Преступление и наказание -> Достоевский
            3 => [3],        // Анна на шее -> Чехов
            4 => [4],        // Евгений Онегин -> Пушкин
            5 => [5],        // Мёртвые души -> Гоголь
        ];

        foreach ($bookAuthorMap as $bookId => $authorIds) {
            foreach ($authorIds as $authorId) {
                $ba = new BookAuthor();
                $ba->book_id = $bookId;
                $ba->author_id = $authorId;
                $ba->save(false);
            }
        }

        // --- Юзер ---
        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@test.com';
        $user->password_hash = Yii::$app->security->generatePasswordHash('admin');
        $user->role = 'user';
        $user->created_at = time();
        $user->save(false);

        // --- Подписки гостей ---
        $subscriptions = [
            ['author_id' => 1, 'guest_phone' => '+79000000001'],
            ['author_id' => 2, 'guest_phone' => '+79000000002'],
            ['author_id' => 3, 'guest_phone' => '+79000000003'],
        ];

        foreach ($subscriptions as $data) {
            $sub = new Subscription();
            $sub->author_id = $data['author_id'];
            $sub->guest_phone = $data['guest_phone'];
            $sub->save(false);
        }
    }

    public function safeDown()
    {
        $this->delete('{{%subscription}}');
        $this->delete('{{%book_author}}');
        $this->delete('{{%book}}');
        $this->delete('{{%author}}');
        $this->delete('{{%user}}');
    }
}
