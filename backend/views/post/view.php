<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <!-- 标题 -->
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- 两个按钮 -->
    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除吗?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <!-- 数据小部件 -->
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'content:ntext',
            'tags:ntext',
            // 'status',
            [
            'label'=>'状态',
            'value'=>$model->status0->name,     
            ],
            'create_time:datetime',
            'update_time:datetime',                [
            
            'attribute'=>'author_id',
            'value'=>$model->author->nickname,      
            ],
            'author_id',
        ],
    ]) ?>

</div>
