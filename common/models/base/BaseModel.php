<?php
/**
 * Created by PhpStorm.
 * User: chenyi
 * Date: 17-7-30
 * Time: 15:45
 */
namespace common\models\base;

use yii\db\ActiveRecord;
/**
 * 基础模型
*/

class BaseModel extends ActiveRecord{
    /**
     * 获取分页数据
     * @param $query
     * @param int $curPage
     * @param int $pageSize
     * @param null $serach
     * @return array
     */
    public function getPages($query, $curPage = 1, $pageSize = 10, $search = null){
        if($search){
            $query = $query->andFilerWhere($search);
        }
        $data['count'] = $query->count();

        if(!$data['count']){
            return ['count'=>0,'curPage'=> $curPage,'pageSize'=>$pageSize,'start'=>0,'end'=>0,'data'=>0];
        }

        //输入页数不对的时候，取余
        $curPage = (ceil($data['count']/$pageSize)<$curPage)?ceil($data['count']/$pageSize):$curPage;
        //当前页
        $data['curPage'] = $curPage;
        //每页显示条数
        $data['pageSize'] = $pageSize;
        //起始页面
        $data['start'] = ($curPage-1)*$pageSize+1;
        //末尾页面
        $data['end'] = ceil(($data['count']/$pageSize) == $curPage )?$data['count']:($curPage-1)*$pageSize+$pageSize;

        //数据
        $data['data'] = $query
            ->offset(($curPage-1)*$pageSize)
            ->limit($pageSize) //限制条数
            ->asArray()
            ->all();
        return $data;
    }
}