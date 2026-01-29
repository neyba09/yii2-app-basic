<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],
            [['username', 'email'], 'string', 'max' => 255],
            ['email', 'email'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'Это имя пользователя уже занято.'],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Этот email уже занят.'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        $user->role = 'user';
        $user->created_at = time();

        if ($user->save()) {
            return $user;
        }

        return null;
    }
}

