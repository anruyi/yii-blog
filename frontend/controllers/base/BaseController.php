<?php
/**
 * Created by PhpStorm.
 * User: chenyi
 * Date: 17-7-30
 * Time: 14:07
 */

namespace frontend\controllers\base;
/**
 * 基础控制器
*/
use yii\web\Controller;

class BaseController extends Controller{
    public function beforeAction($action){
        if(!parent::beforeAction($action)){
            return false;
        }
        return true;
    }
}