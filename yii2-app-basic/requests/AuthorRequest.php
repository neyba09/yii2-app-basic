<?php

namespace app\requests;

use yii\base\Model;

class AuthorRequest extends Model
{
    public $full_name;

    public function rules()
    {
        return [
            [['full_name'], 'required', 'message' => 'Имя автора обязательно'],
            [['full_name'], 'string', 'max' => 255, 'tooLong' => 'Максимум 255 символов'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'full_name' => 'ФИО',
        ];
    }

    /**
     * Заполняет модель Author из Request
     * @param \app\models\Author $author
     */
    public function fillAuthor($author)
    {
        $author->full_name = $this->full_name;
    }

    /**
     * Загружает данные из модели Author в Request
     * @param \app\models\Author $author
     */
    public function loadFromAuthor($author)
    {
        $this->full_name = $author->full_name;
    }
}

