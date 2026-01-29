<?php

namespace app\repositories;

use app\models\Subscription;
use yii\db\ActiveQuery;

class SubscriptionRepository
{
    /**
     * @param int $authorId
     * @return Subscription[]
     */
    public function findByAuthorId($authorId)
    {
        return Subscription::find()
            ->where(['author_id' => $authorId])
            ->with('author')
            ->all();
    }

    /**
     * @param Subscription $subscription
     * @return bool
     */
    public function save(Subscription $subscription)
    {
        return $subscription->save();
    }
}

