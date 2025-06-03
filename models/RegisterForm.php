<?php

namespace app\models;

use Yii;
use yii\base\Model;

class RegisterForm extends Model
{
    public $name;
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['name', 'email', 'password'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Такий email вже зареєстровано.'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Ім’я',
            'email' => 'Email',
            'password' => 'Пароль',
        ];
    }

    public function register()
    {
        if ($this->validate()) {
            $user = new User();
            $user->name = $this->name;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->is_admin = 0;
            $user->date = date('Y-m-d H:i:s');
            return $user->save();
        }
        return false;
    }
}
