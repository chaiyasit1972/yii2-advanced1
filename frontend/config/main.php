<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
use \yii\web\Request;
// $baseUrl = str_replace('../public', '', (new Request)->getBaseUrl());
 $baseUrl = str_replace('/frontend/web', '', (new Request)->getBaseUrl());

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'mycomponent' => [
            'class' => 'frontend\components\MyComponent',
        ],   
        'currency' => [
            'class' => 'frontend\components\Money',
        ],        
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
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
        'view' => [
             'theme' => [
                 'pathMap' => [
                     '@frontend/views' =>'@frontend/themes/unify/views'
                ],
            ],
        ],    
    
        'request' => [
            'baseUrl' => $baseUrl,
        ],        
       'urlManager' => [ 
               'baseUrl' => $baseUrl,               
               'class' =>'yii\web\UrlManager',
               'enablePrettyUrl' => true,
               'showScriptName' => false,      
               'rules' => []           
        ],       
        'db1' => require(__DIR__ . '/db1.php'),   
    ],
    'modules' =>[
               'gridview' => [
                      'class' => '\kartik\grid\Module',
                      //'downloadAction' => 'gridview/export/download',
                      'i18n' => [
                                'class' => '\yii\i18n\PhpMessageSource',
                                'basePath' => '@kvgrid/messages',
                                'forceTranslation' => true
                      ]
               ]        
    ],
    'params' => $params,
];
