<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Commentstatus;
use yii\grid\Column;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '评论管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'content:ntext',
            [
            'attribute'=>'id',
            'contentOptions'=>['width'=>'30px'],
            ],
            [
            'attribute'=>'content',
            'value'=>'beginning',
            ],
            
            // 'status',
            [
            'attribute'=>'status',
            'value'=>'status0.name',
            'filter'=>Commentstatus::find()
                      ->select(['name','id'])
                      ->orderBy('position')
                      ->indexBy('id')
                      ->column(),
            'contentOptions'=>
                    function($model)
                    {
                        return ($model->status==1)?['class'=>'bg-danger']:[];
                    }
            ],
            // 'create_time:datetime',
            [
                'attribute'=>'create_time',
                'format'=>['date','php:m-d H:i'],
            ],
            // 'userid',
            [
            'attribute'=>'user.username',
            'label'=>'作者',
            'value'=>'user.username',   
            ],
            // 'email:email',
            // 'url:url',
            // 'post_id',
            'post.title',

            [
            'class' => 'yii\grid\ActionColumn',
            // 按钮
            'template'=>'{view} {update} {delete} {approve}',
            'buttons'=>
                [
                // 动作列为按钮创建的url
                // 当前要渲染的模型对象
                // 数据提供者数组中模型的键
                'approve'=>function($url,$model,$key)
                        {
                            $options=[
                                'title'=>Yii::t('yii', '审核'),
                                'aria-label'=>Yii::t('yii','审核'),
                                'data-confirm'=>Yii::t('yii','你确定通过这条评论吗？'),
                                'data-method'=>'post',
                                'data-pjax'=>'0',
                                    ];
                            return Html::a('<span class="glyphicon glyphicon-check"></span>',$url,$options);
                            
                        },
                ],  
                    

                    
            ],
        ],
    ]); ?>
</div>
