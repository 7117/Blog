<?php
// 查看文章信息的页面
// 帮助类
use yii\helpers\Html;
// 数据小部件
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
// 首页
$this->title = $model->title;
// 文章管理
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
// 文章的名字
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <!-- 标题 -->
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- 两个按钮 -->
    <p>
        <!-- 修改按钮的操作 -->
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <!-- 这里应用的bootstrap的操作 删除的时候的弹出框 -->
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
            // 查询获得的标签名字
            [
            'label'=>'状态',
            'value'=>$model->status0->name,     
            ],
            // 
            // 'create_time:datetime',
            // 新建时间
            [
                'attribute'=>'create_time',
                'value'=>date('Y-m-d H:i:s',$model->create_time),
            ],
            // 更新时间
            'update_time:datetime',                
            // 作者名字
            [            
            'attribute'=>'author_id',
            'value'=>$model->author->nickname,      
            ],
            'author_id',
        ],
    ]) ?>

</div>
