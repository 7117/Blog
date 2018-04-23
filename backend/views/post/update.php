<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

// 面包屑部分
$this->title = '文章修改: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="post-update">
	
	<!-- 标题部分 -->
    <h1><?= Html::encode($this->title) ?></h1>
	
	<!-- 下面就是表格的内容部分 -->
	<!-- 采用render进行渲染页面 -->
	<!-- 视图中的render方法不会去应用布局 -->
	<!-- 控制器的render方法会使用布局 -->
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
