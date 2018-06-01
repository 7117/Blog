<?php

/* @var $this \yii\web\View */
/* @var $content string */
// main.php是用来布局文件的

use backend\assets\AppAsset;
// 使用帮助类
use yii\helpers\Html;
// 使用bootstrap
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
// 使用小部件
use yii\widgets\Breadcrumbs;
//  使用小部件
use common\widgets\Alert;
use common\models\Comment;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <!-- 设置编码 -->
    <meta charset="<?= Yii::$app->charset ?>">
    <!-- 设置兼容 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- 设置兼容 -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 设置csrf -->
    <?= Html::csrfMetaTags() ?>
    <!-- 设置title -->
    <title><?= Html::encode($this->title) ?></title>
    <!-- 设置head -->
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '我的博客',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => '文章管理', 'url' => ['/post/index']],
        ['label' => '评论管理', 'url' => ['/comment/index']],
        '<li><span class="badge">'.Comment::getPengdingCommentCount().'</span></li>',
        ['label' => '用户管理', 'url' => ['/user/index']],
        ['label' => '管理员', 'url' => ['/adminuser/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '登录', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                '注销 (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
