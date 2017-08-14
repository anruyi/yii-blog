<?php
namespace frontend\models;

use Codeception\Verify;
use yii\base\Model;
use common\models\UserModel;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $rePassword;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
//           检测用户名唯一性
            ['username', 'unique', 'targetClass' => '\common\models\UserModel', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 16],
            ['username', 'match','pattern'=>'/^[(\x{4E00}-\x{9FA5})a-zA-Z]+[(\x{4E00}-\x{9FA5})a-zA-Z_\d]*$/u','message'=>'用户名由字母，汉字，数字，下划线组成，且不能以数字和下划线开头。'],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\UserModel', 'message' => 'This email address has already been taken.'],

            [['password','rePassword'], 'required'],
            [['password','rePassword'], 'string', 'min' => 6],
            ['verifyCode','captcha'],
            ['rePassword', 'compare' ,'compareAttribute' =>  'password','message'=> 'hello'],
//            [Yii::t('common','Two times password is not consitent!')]
        ];
    }
    public function attrbuteLabels(){
        return [
          'Verifycode' => '验证码',
        ];
    }
    /**
     * Signs user up.
     *
     * @return UserModel|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new UserModel();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
