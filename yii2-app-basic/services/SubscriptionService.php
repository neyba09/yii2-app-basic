<?php

namespace app\services;

use app\jobs\SmsJob;
use app\models\Book;
use app\models\Subscription;
use app\repositories\SubscriptionRepository;
use Yii;

class SubscriptionService
{
    private SubscriptionRepository $subscriptionRepository;
    private $smsComponent;
    private $queue;

    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->smsComponent = Yii::$app->sms;
        $this->queue = Yii::$app->queue;
    }

    /**
     * Создает подписку и отправляет уведомление
     *
     * @param Subscription $subscription
     * @return bool true если подписка сохранена, false если нет
     */
    public function createSubscription(Subscription $subscription): bool
    {
        if (!$this->subscriptionRepository->save($subscription)) {
            return false;
        }

        $smsMessage = "Вы успешно подписались на автора: " . $subscription->author->full_name;

        $smsSent = $this->smsComponent->send($subscription->guest_phone, $smsMessage);

        if (!$smsSent) {
            $this->queue->push(new SmsJob([
                'phone' => $subscription->guest_phone,
                'message' => $smsMessage,
            ]));
        }

        return true;
    }

    /**
     * Уведомляет подписчиков о новой книге
     * @param Book $book
     */
    public function notifySubscribers(Book $book)
    {
        $book->refresh();
        foreach ($book->authors as $author) {
            $subscriptions = $this->subscriptionRepository->findByAuthorId($author->id);
            
            foreach ($subscriptions as $subscription) {
                $message = "Новая книга: {$book->title}";
                $this->smsComponent->send($subscription->guest_phone, $message);
            }
        }
    }
}

