<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */
// html类
// 表单类
// Captcha类
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
    </p>

    <div class="row">
        <div class="col-lg-5">
                <!-- 表单开始 -->
                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                <!-- 姓名 -->
                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
                <!-- 邮件 -->
                <?= $form->field($model, 'email') ?>
                <!-- 类别 -->
                <?= $form->field($model, 'subject') ?>
                <!-- 身体 -->
                <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>
                <!-- 验证码 -->
                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                ]) ?>
                <!-- 提交 -->
                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>
            <!-- 表单结束 -->
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
