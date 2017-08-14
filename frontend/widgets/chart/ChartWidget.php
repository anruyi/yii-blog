<?php
/**
 * Created by PhpStorm.
 * User: chenyi
 * Date: 17-8-11
 * Time: 15:09
 */

namespace frontend\widgets\chart;

use frontend\models\FeedForm;
use Yii;
use yii\base\Widget;

class ChartWidget extends Widget
{
    public function run()
    {
        $feed = new FeedForm();
        $data['feed'] = $feed->getList();
        return $this->render('index',['data'=>$data]);
    }

}