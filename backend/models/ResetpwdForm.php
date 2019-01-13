<?php
namespace backend\models;

// 基层的模型
use yii\base\Model;
use common\models\Adminuser;
use yii\helpers\VarDumper;

/**
 * Signup form
 */
class ResetpwdForm extends Model
{
    // 去除了除了关于密码所有的属性
    public $password;
    public $password_repeat;

    /**
     * @inheritdoc
     */
    // 对应的规则
    // 两个属性  一个是密码   一个是验证密码
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        		
        	['password_repeat','compare','compareAttribute'=>'password','message'=>'两次输入的密码不一致！'],
        ];
    }
    // 对应的转化
    public function attributeLabels()
    {
    	return [
    			'password' => '密码',
    			'password_repeat'=>'重输密码',
    	];
    }
    
    
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function resetPassword($id)
    {
        if (!$this->validate()) {
            return null;
        }
        
        $admuser = Adminuser::findOne($id);
        $admuser->setPassword($this->password);
        $admuser->removePasswordResetToken();
        
        return $admuser->save() ? true : false;
    }
}
