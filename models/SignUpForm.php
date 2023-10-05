<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

class SignUpForm extends Model
{
    public $username;
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['username','email','password',],'required'],
            ['email', 'email'],
        ];
        
    }

    public function createUser()
    {
        $user = new User();
        $user->userName = $this->username;
        $user->email = $this->email;
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $user->authKey = Yii::$app->getSecurity()->generateRandomString($length=32);
        
        $user->save();

        return $user;
    }


}