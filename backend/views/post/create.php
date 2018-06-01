<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = '新增文章';
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-create">

    <h1><?= Html::encode($this->title) ?></h1>
	<!-- 新建页面与修改页面  共同调用的一个表单 -->
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
