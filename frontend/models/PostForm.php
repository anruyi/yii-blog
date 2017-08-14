<?php
/**
 * Created by PhpStorm.
 * User: chenyi
 * Date: 17-7-30
 * Time: 15:56
 */
namespace frontend\models;

use common\models\PostModel;
use common\models\RelationPostTagModel;
use yii\base\Model;
use Yii;
use yii\db\Exception;
use yii\db\Query;

/**
 * 文章表单模型
 * Class PostForm
 * @package frontend\models
 */
class PostForm extends Model{
    public $id;
    public $title;
    public $content;
    public $label_img;
    public $cat_id;
    public $tags;
    public $_lastError = "";
    /**
     * 场景创建
     * SCENARIOS_CREATE创建
     * SCENARIOS_UPDATE更新
     */
    const SCENARIOS_CREATE = 'create';
    const SCENARIOS_UPDATE = 'update';

    const EVENT_AFTER_CREATE = "evenAfterCreate";
    const EVENT_AFTER_UPDATE = "eventAfterUpdate";
    /**
     * 场景设置
     * @return array
     */
    public function scenarios(){

        $scenarios =[
          self::SCENARIOS_CREATE => ['title', 'content', 'label_img', 'cat_id', 'tags'],
          self::SCENARIOS_UPDATE => ['title', 'content', 'label_img', 'cat_id', 'tags'],
        ];
        //返回合并数组
        return array_merge(parent::scenarios(),$scenarios);
    }

    /**
     * 表单模型中，表单审核规则敲定
     * @return array
     */
    public function rules(){
        return[
            [['id','title','content','cat_id'],'required'],
            [['id','cat_id'],'integer'],
            ['title','string','min'=>2,'max'=>50],
        ];
    }

    public function attributeLabels(){
        return[
            'id' => Yii::t('common','编码'),
            'title' => '标题',
            'content' =>  ' 内容',
              'label_ i mg' => '标签图',
            'tags' => '标签',
            'cat_id' => '分类',
        ];
    }

    /**
     * 获取文章列表参数
     */
    public static function getList($cond, $curPage = 1, $pageSize = 5, $orderBy = ['id'=>SORT_DESC]){
        $model = new PostModel();
        //查询语句
        $select = ['id','title','summary','label_img','cat_id','user_id','user_name','is_valid'
            ,'created_at','updated_at'
        ];
        $query = $model
            ->find()
            ->select($select)
            ->where($cond)
            ->with('relate.tag','extend')
            ->orderBy($orderBy);
        //获取分页数据
        $res = $model->getPages($query,$curPage,$pageSize);
        //格式化获取到的分页数据
        $res['data'] = self::_formatList($res['data']);
        return $res;
    }

    /**
     * 数据格式化
     * @param $data
     * @return mixed
     */
    public static function _formatList($data){
        foreach ($data as &$list){
            $list['tags'] = [];
            if(isset($list['relate']) && !empty($list['relate'])){
                foreach ($list['relate'] as $lt){
                    $list['tags'][] = $lt['tag']['tag_name'];
                }
            }
            unset($list['relate']);
        }
        return $data;
    }

    /**
     * 文章创建
     * @return bool
     */
    public function create(){
        //事物
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $model = new PostModel();
            $model -> setAttributes($this->attributes);
            $model -> summary = $this->_getSummary();
            $model -> user_id = Yii::$app->user->identity->id;
            $model -> user_name = Yii::$app->user->identity->username;
            $model -> is_valid = PostModel::IS_VALID;
            $model -> created_at = time();
            $model -> updated_at = time();
            if(!$model->save()){
                throw new \Exception('文章保存失败！');
            }
            $this->id = $model->id;
            //单独处理tags表，用下面的方法
            $data = array_merge($this->getAttributes(),$model->getAttributes());
            $this ->_eventAfterCreate($data);

            $transaction -> commit();
            return true;
        }catch(\Exception $e){
            $transaction -> rollBack();
            $this->_lastError = $e->getMessage();
            return false;
        }
    }

    public function getViewById($id){
        $res = PostModel::find()->with('relate.tag','extend')->where(['id'=>$id])->asArray()->one();
        if(!$res){
            throw new \Exception("文章不存在!");
        }
        //处理标签格式
        $res['tag'] = [];
        if(isset($res['relate']) && !empty($res['relate'])){
            foreach ($res['relate'] as $list){
                $res['tags'][] = $list['tag']['tag_name'];
            }
        }
        //移除不需要的字段
        unset($res['relate']);
        return $res;
    }

    /**
     * 截取文章摘要
     * @param int $s
     * @param int $e
     * @param string $char
     * @return null|string
     */
    private function _getSummary($s=0,$e=40,$char ='utf-8'){
        if(empty($this->content))
            return null;
        return (mb_substr(str_replace('&nbsp;','',strip_tags($this->content)),$s,$e,$char));
    }

    /**
     * 创建完成后事件
     */
    public function _eventAfterCreate($data){
        //添加事件
        $this->on(self::EVENT_AFTER_CREATE,[$this,'_eventAddTag'],$data);
        //触发事件
        $this->trigger(self::EVENT_AFTER_CREATE);
    }

    /**
     * 添加标签
     */
    public function _eventAddTag($event){
        //保存标签
        $tag = new TagForm();
        $tag->tags = $event->data['tags'];
        $tagids = $tag->saveTags();

        //删除原先表关系
        RelationPostTagModel::deleteAll(['post_id'=>$event->data['id']]);

        //批量保存文章和标签关联关系
        if(!empty($tagids)){
            foreach ($tagids as $k=>$id){
                $row[$k]['post_id'] = $this->id;
                $row[$k]['tag_id'] = $id;
            }
            //批量插入Tag标签
            $res = (new Query()) -> createCommand()
                ->batchInsert(RelationPostTagModel::tableName(),['post_id','tag_id'],$row)
                ->execute();
            //检测返回结果
            if(!$res){
                throw new \Exception("关联关系删除失败");
            }
        }
    }

}