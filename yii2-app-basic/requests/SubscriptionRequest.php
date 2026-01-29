<?php

namespace app\requests;

use app\models\Subscription;
use yii\base\Model;
use app\models\Author;

class SubscriptionRequest extends Model
{
    public $author_id;
    public $guest_phone;

    public function rules()
    {
        return [
            [['author_id', 'guest_phone'], 'required', 'message' => 'Это поле обязательно'],
            [['author_id'], 'integer', 'message' => 'Неверный идентификатор автора'],
            [['author_id'], 'exist', 'targetClass' => Author::class, 'targetAttribute' => 'id', 'message' => 'Автор не найден'],
            [['guest_phone'], 'string', 'max' => 20, 'tooLong' => 'Номер телефона не должен превышать 20 символов'],
            [['author_id', 'guest_phone'], 'unique',
                'targetClass' => Subscription::class,
                'targetAttribute' => ['author_id', 'guest_phone'],
                'message' => 'Вы уже подписаны на этого автора с этим номером телефона'
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'author_id' => 'Автор',
            'guest_phone' => 'Номер телефона',
        ];
    }

    /**
     * Заполняет модель Subscription из Request
     * @param \app\models\Subscription $subscription
     */
    public function fillSubscription($subscription)
    {
        $subscription->author_id = $this->author_id;
        $subscription->guest_phone = $this->guest_phone;
    }
}

