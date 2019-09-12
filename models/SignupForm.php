<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\Html;
use app\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'max' => 45],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Имя пользователя уже используется.'],
            
            ['password', 'required'],
            ['password', 'string', 'min' => 8],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->active = User::STATUS_ACTIVE;
        $user->setPassword($this->password);
        
        return $user->save();
            
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'password' => 'Пароль'
        ];
    }
}
