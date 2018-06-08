<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class AdminLoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            // 验证密码的方法
            ['password', 'validatePassword'],
        ];
    }

    public function  attributeLabels()
    {
        return [
                'username'=>'用户名',
                'password'=>'密码',
                'rememberMe'=>'记住密码',
        ];
    }


    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    // 两个参数
    // 参数一：要验证的参数
    // 参数二：
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            // 是否存在该用户
            $user = $this->getUser();
            // 验证密码
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '不正确的用户名或者密码.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        // 是否符合验证规则
        if ($this->validate()) {
            // 表示用户已经登录好 进行注入到系统中
            // 如果存在这个用户名的话  就进行保留 
            // 反之不保存
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    // 返回是否这得到  是一个bool值
    protected function getUser()
    {
        if ($this->_user === null) {
            // user相当于保安 执行方法findbyusername
            $this->_user = AdminUser::findByUsername($this->username);
        }

        return $this->_user;
    }
}
