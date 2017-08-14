<?php
/**
 * Created by PhpStorm.
 * User: chenyi
 * Date: 17-8-10
 * Time: 8:42
 */

namespace frontend\widgets\banner;

use Yii;
use yii\base\Widget;

class BannerWidget extends Widget
{
    public $items = [];

    public function init()
    {
        if(empty($this->items))
        $this->items = [
            [
                'label'=>'demo',
                'img_url'=>'/statics/imgs/banner/b_0.png',
                'url'=>['site/index'],
                'html'=> '',
                'active' => 'active',
            ],
            [
                'label'=>'demo',
                'img_url'=>'/statics/imgs/banner/b_0.png',
                'url'=>['site/index'],
                'html'=> '',
//                'active' => 'active',
            ],
            [
                'label'=>'demo',
                'img_url'=>'/statics/imgs/banner/b_0.png',
                'url'=>['site/index'],
                'html'=> '',
//                'active' => 'active',
            ],
        ];
    }

    public function run(){
        $data['items'] = $this->items;
        return $this->render('index',['data'=>$data]);
    }
}