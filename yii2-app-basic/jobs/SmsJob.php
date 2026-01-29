<?php

namespace app\jobs;

use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class SmsJob extends BaseObject implements JobInterface
{
    public string $phone;
    public string $message;
    public int $attempts = 3;

    /**
     * Выполняется при обработке очереди
     *
     * @param \yii\queue\Queue $queue
     */
    public function execute($queue)
    {
        $sms = Yii::$app->sms;

        for ($i = 0; $i < $this->attempts; $i++) {
            Yii::info("Попытка отправки SMS на {$this->phone}, попытка " . ($i + 1), 'sms');

            if ($sms->send($this->phone, $this->message)) {
                Yii::info("SMS успешно отправлено на {$this->phone}", 'sms');
                return;
            }

            Yii::warning("Не удалось отправить SMS на {$this->phone}, повтор через 5 секунд", 'sms');
            sleep(5);
        }

        Yii::error("Не удалось отправить SMS на {$this->phone} после {$this->attempts} попыток", 'sms');
    }
}
