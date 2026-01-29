<?php

namespace app\components;

use Yii;
use yii\base\Component;

class SmsComponent extends Component
{
    public $apiKey;
    public $apiUrl = 'https://smspilot.ru/api.php';

    public function init()
    {
        parent::init();

        if (empty($this->apiKey)) {
            $this->apiKey = Yii::$app->params['smsApiKey'] ?? 'TEST_EMULATOR_KEY';
            Yii::info("SMS: using API key {$this->apiKey}", 'sms');
        }
    }

    /**
     * Отправка SMS
     *
     * @param string $phone
     * @param string $message
     * @return bool
     */
    public function send($phone, $message)
    {
        if (empty($phone) || empty($message)) {
            Yii::warning('SMS: отстутствует номер или сообщение', 'sms');
            return false;
        }

        $url = "{$this->apiUrl}?send=1&to={$phone}&text=" . urlencode($message) . "&apikey={$this->apiKey}&format=json";

        Yii::info("SMS: sending request to URL: {$url}", 'sms');

        try {
            $result = @file_get_contents($url);

            if ($result === false) {
                Yii::error("SMS: request failed for {$phone}", 'sms');
                return false;
            }

            Yii::info("SMS: response: {$result}", 'sms');

            $data = json_decode($result, true);

            if (isset($data['error'])) {
                Yii::error("SMS send error: " . $data['error'], 'sms');
                return false;
            }

            if (isset($data['balance'])) {
                Yii::info("SMS: current balance: " . $data['balance'], 'sms');
            }

            $status = $data['send'][0]['status'] ?? null;
            $serverId = $data['send'][0]['server_id'] ?? null;

            if ($status === '0' || $status === 0) {
                Yii::info("SMS queued successfully for {$phone}, server_id: {$serverId}", 'sms');
                return true;
            }

            Yii::info("SMS send status: {$status} for {$phone}, server_id: {$serverId}", 'sms');
            return $status == 2;

        } catch (\Exception $e) {
            Yii::error("SMS send exception: " . $e->getMessage(), 'sms');
            return false;
        }
    }
}