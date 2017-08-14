<?php
namespace frontend\widgets\hot;

use common\models\PostExtendModel;
use common\models\PostModel;
use yii\base\Widget;
use yii\db\Query;

class HotWidget extends Widget
{
    public $title = '';
    public $limit = '';
    public function run()
    {
        $res = (new Query())
            ->select('a.browser,b.id,b.title')
            ->from(['a'=>PostExtendModel::tableName()])
            ->join('LEFT JOIN',['b'=>PostModel::tableName()],'a.post_id =b.id')
            ->where('b.is_valid = '.PostModel::IS_VALID)
            ->orderBy(['browser' => SORT_DESC])
            ->limit($this->limit)
            ->all();

        $result['title'] = $this->title?:'热门浏览';
        $result['body'] = $res?:[];

        return $this->render('index',['data'=>$result]);
    }
}