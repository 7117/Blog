<?php
// main.php主要存放默认的信息  比如控制器  cookie session log user 等信息
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    // 模块的名字   样式：app-名字
    'id' => 'app-backend',
    // 规定默认的路径
    'basePath' => dirname(__DIR__),
    // 控制器的路径
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    // 语言的设置
    'language'=>'zh-CN',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        // 用户的模型配置
        'user' => [
            'identityClass' => 'common\models\Adminuser',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session'=>[
                'name'=>'PHPBACKSESSION',
                'savePath'=>sys_get_temp_dir(),
        ],
        'request'=>[
                'cookieValidationKey'=>'sdfjjksloeedf78789judf',
                'csrfParam'=>'_adminCSRF',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
