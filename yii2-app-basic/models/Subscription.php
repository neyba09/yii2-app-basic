<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\Author;

class Subscription extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%subscription}}';
    }

    public function rules()
    {
        return [
            [['author_id', 'guest_phone'], 'required'],
            [['author_id'], 'integer'],
            [['guest_phone'], 'string', 'max' => 20],
            [['author_id', 'guest_phone'], 'unique', 'targetAttribute' => ['author_id', 'guest_phone']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Автор',
            'guest_phone' => 'Номер телефона',
            'created_at' => 'Дата создания',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->created_at = time();
            }
            return true;
        }
        return false;
    }

    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }
}
