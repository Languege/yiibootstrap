<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
        	'class' => 'yii\rbac\DbManager',
        	'itemTable' => 'auth_item',
        	'assignmentTable' => 'auth_assignment',
        	'itemChildTable' => 'auth_item_child',
        ],
        'i18n' => [ 
            'translations' => [ 
                'app*' => [ 
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    //'sourceLanguage' => 'zh-CN',
                    'fileMap' => [ 
                        'app' => 'app.php',
                        'app/error' => 'error.php', 
                        'nav' => 'nav.php',
                    ],
                    'on missingTranslation' => ['common\components\TranslationEventHandler', 'missingTranslation'] 
                ]
            ],
        ],
    ],
    'language' => 'zh-CN',
];
