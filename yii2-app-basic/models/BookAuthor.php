<?php

namespace app\models;

use yii\db\ActiveRecord;

class BookAuthor extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%book_author}}';
    }
}
