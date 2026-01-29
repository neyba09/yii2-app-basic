<?php

namespace app\requests;

use yii\base\Model;
use yii\web\UploadedFile;

class BookRequest extends Model
{
    public $title;
    public $year;
    public $description;
    public $isbn;
    public $cover_photo;
    public $cover_photo_file;
    public $authors = [];

    public function rules()
    {
        return [
            [['title', 'year', 'description', 'isbn', 'authors'], 'required', 'message' => 'Это поле обязательно'],
            [['year'], 'integer', 'message' => 'Год выпуска должен быть числом'],
            [['description'], 'string', 'message' => 'Описание должно быть текстом'],
            [['title', 'isbn', 'cover_photo'], 'string', 'max' => 255, 'tooLong' => 'Максимум 255 символов'],
            [['isbn'], 'integer', 'message' => 'isbn должен быть числом'],
            [['authors'], 'each', 'rule' => ['integer']],
            [['cover_photo_file'], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'jpg, jpeg, png, gif, webp',
                'wrongExtension' => 'Разрешены только изображения: JPG, JPEG, PNG, GIF, WEBP',
                'mimeTypes' => 'image/jpeg, image/png, image/gif, image/webp',
                'wrongMimeType' => 'Неверный формат файла. Должно быть изображение JPG, PNG, GIF или WEBP',
                'maxSize' => 5 * 1024 * 1024,
                'tooBig' => 'Файл не должен превышать 5 MB',
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Название',
            'year' => 'Год выпуска',
            'description' => 'Описание',
            'isbn' => 'ISBN',
            'cover_photo' => 'Фото главной страницы',
            'cover_photo_file' => 'Фото главной страницы',
            'authors' => 'Авторы',
        ];
    }

    /**
     * Заполняет модель Book из Request
     * @param \app\models\Book $book
     * @param string|null $coverPhotoPath Путь к загруженному файлу
     */
    public function fillBook($book, $coverPhotoPath = null)
    {
        $book->title = $this->title;
        $book->year = $this->year;
        $book->description = $this->description;
        $book->isbn = $this->isbn;
        
        // Если загружен новый файл, используем его путь
        if ($coverPhotoPath !== null) {
            $book->cover_photo = $coverPhotoPath;
        } elseif ($this->cover_photo) {
            // Иначе сохраняем существующий путь
            $book->cover_photo = $this->cover_photo;
        }
    }

    /**
     * Загружает данные из модели Book в Request
     * @param \app\models\Book $book
     */
    public function loadFromBook($book)
    {
        $this->title = $book->title;
        $this->year = $book->year;
        $this->description = $book->description;
        $this->isbn = $book->isbn;
        $this->cover_photo = $book->cover_photo;
        
        $this->authors = [];
        foreach ($book->authors as $author) {
            $this->authors[] = $author->id;
        }
    }
}

