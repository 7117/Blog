<?php
namespace common\models;

use Yii;
use yii\base\Model;


/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * @inheritdoc
     */
    // 相关字段的验证
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            // 
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    // 验证密码
    // 两个参数
    // 参数一：要验证的参数
    // 参数二：提供的参数
    public function validatePassword($attribute, $params)
    {
        // 没有错误
        if (!$this->hasErrors()) {
            // 存在该用户
            $user = $this->getUser();
            // 验证密码  没有用户并且密码错误
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
    // 登录后的操作 通过验证规则然后进行保留用户的
    public function login()
    {
        // 是否符合验证规则
        if ($this->validate()) {
            // 表示用户已经登录好 进行注入到系统中
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            // user相当于保安 执行方法findbyusername
            // 
            // 调用user模型的findByUsername得到姓名
            // 查找是否存在这个用户
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
