<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Poststatus;
use yii\helpers\ArrayHelper;
use common\models\Adminuser;


/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>
<!-- 因为文章新增的页面也需要 这个表单 所以就进行封装了起来-->
<div class="post-form">

    <!-- 使用activeform与activeend进行表示表单 -->
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tags')->textarea(['rows' => 6]) ?>

    <?php 
        //第1种查询方法-ar
        // $psObjs=Poststatus::find()->all();//查到文章状态表的所有数据
        // 使用arrayhelper将数据进行转换成键值对的形式
        // $allStatus=ArrayHelper::map($psObjs,'id','name');
    
        // 第2种方法-command
        // $psArray=Yii::$app->db->createCommand('select id,name from poststatus')->queryAll();
        // $allStatus=ArrayHelper::map($psArray,'id','name');

        // 第3种方法-querybuild
        // $allStatus=(new \yii\db\Query())
        // ->select(['name','id'])
        // ->from('poststatus')
        // ->indexBy('id')
        // ->column();

        // 第4种方法--不需要arrayhelper 不需要new对象
        // --ar对象
        $allStatus=Poststatus::find()
        ->select(['name','id'])
        ->from('poststatus')
        ->indexBy('id')
        ->column();
    ?>

    <?= $form->field($model,'status')
             ->dropDownList($allStatus,['prompt'=>'请选择状态']);?>

    <!-- <?= $form->field($model, 'create_time')->textInput() ?> -->

    <!-- <?= $form->field($model, 'update_time')->textInput() ?> -->

    <?php
        $Adminuser=Adminuser::find()
        ->select(['nickname','id'])
        ->indexBy('id')
        ->column();
    ?>
    
    <?= $form->field($model,'author_id')
         ->dropDownList($Adminuser,['prompt'=>'请选择作者']);?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
