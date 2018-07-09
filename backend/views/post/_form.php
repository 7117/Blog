<?php
// 使用htmlhelper类
use yii\helpers\Html;
// 这里因为有哦表单 Yii中进行封装了表单的代码 所以进行调用activeform
use yii\widgets\ActiveForm;
// 下拉菜单用到了文章的状态
use common\models\Poststatus;
// 数组帮助类
use yii\helpers\ArrayHelper;
// 使用adminuser模型 这里面有一个模型进行查询了作者 索引进行引用模型类
use common\models\Adminuser;


/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>
<!-- 新增页面与修改页面会进行调用这个页面 -->
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
        // 然后⽤ArrayHelper的静态⽅法map把psOjbs这个对象数组进⾏转换，转换为键值对
        // 数组，也就是下拉菜单需要的键值对数组格式。
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
        // 混合的一张形式
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
