<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Poststatus;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// index.php就是一个展示页面
// 标题
$this->title = '文章管理';
// 面包屑
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- 创建文章的按钮 这里用到htmlhelper -->
    <p>
        <?= Html::a('创建文章', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 生成一个查询表单
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            // 'content:ntext',
            ['attribute'=>'authorName',
            'label'=>'作者',
            'value'=>'author.nickname',
            ],
            'tags:ntext',

            ['attribute'=>'status',
            'value'=>'status0.name',
            'filter'=>Poststatus::find()
                    ->select(['name','id'])
                    ->orderBy('position')
                    ->indexBy('id')
                    ->column(),
             ],

            // 'status',
            // 'create_time:datetime',
            // 'update_time:datetime',
            // 'author_id',
            ['attribute'=>'update_time',
             'format'=>['date','php:Y-m-d H:i:s'],
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
