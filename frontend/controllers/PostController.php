<?php
/**
 * Created by PhpStorm.
 * User: chenyi
 * Date: 17-7-30
 * Time: 14:23
 */
namespace frontend\controllers;

use common\models\CatModel;
use frontend\controllers\base\BaseController;
use frontend\models\PostForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\PostExtendModel;

class PostController extends BaseController {

    /**
     * 控制登陆权限
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'upload', 'ueditor'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,//无论登陆与否否可以访问
                    ],
                    [
                        'actions' => ['create', 'upload', 'ueditor'],
                        'allow' => true,
                        'roles' => ['@'], //登陆之后能访问
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    '*' => ['post','get'],
                ],
            ],
        ];
    }

    /**
     * 文章列表
    */
    public function actionIndex(){

        return $this->render('index'); //默认方法，渲染index界面，没有他，界面混沌一片；

    }

    /**
     * 创建文章
     * @return string
     */
    public function actionCreate()
    {
        $model = new PostForm();
        //定义场景
        $model -> setScenario(PostForm::SCENARIOS_CREATE);
        if ($model->load(Yii::$app->request->post())&& $model->validate()){
            if(!$model->create()) {
                Yii::$app->session->setFlash('warning', $model->_lastError);
            }
            else{
                echo '<br><br><br><br><br><br>hello';
                return $this->redirect(['post/view','id'=>$model->id]);
            }
        }
        //获取所有分类
        $cat = CatModel::getAllCats();
        return $this->render('create',['model'=>$model,'cat' => $cat]);
    }

    /**
     * 文章详情
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $model = new PostForm();
        $data = $model->getViewById($id);

        //文章统计
        $model = new PostExtendModel();
        $model->upCounters(['post_id'=>$id], 'browser' ,1);
        return $this->render('view',['data'=>$data]);

    }

    /**
     * @return array
     * 文件上传组件
     * BaiDu编辑器
     */
    public function actions()
    {
        return [
            'upload'=>[
                'class' => 'common\widgets\file_upload\UploadAction',     //这里扩展地址别写错
                'config' => [
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}",
                ]
            ],
            'ueditor'=>[
                'class' => 'common\widgets\ueditor\UeditorAction',
                'config'=>[
                    //上传图片配置
                    'imageUrlPrefix' => "", /* 图片访问路径前缀 */
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                ],
            ]
        ];
    }



}