<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return array(
    'basePath'          => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'defaultController' => 'crm/client',
    'language'          => 'ru',
    'preload'           => array('log', 'bootstrap'),
    'import'            => array(
        'application.components.*',
        'application.modules.user.models.User',
        'ext.bootstrap.helpers.*'
    ),
    'modules'           => require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'modules.php'),
    // application components
    'components'        => array(
        'user'          => array(
            'class'          => 'auth.components.AuthWebUser',
            'loginUrl'       => '/user/account/login',
            'allowAutoLogin' => true, // enable cookie-based authentication
        ),
        'clientScript'  => array(
            'packages' => array(
                'jquery'    => array(
                    'baseUrl' => '//ajax.googleapis.com/ajax/libs/jquery/1.8/',
                    'js'      => array('jquery.min.js'),
                ),
                'jquery.ui' => array(
                    'baseUrl' => '//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/',
                    'js'      => array('jquery-ui.min.js'),
                ),
                'cookie'    => array(
                    'baseUrl' => '//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.3.1/',
                    'js'      => array('jquery.cookie.min.js')
                ),
                'bbq'       => array(
                    'baseUrl' => '//cdnjs.cloudflare.com/ajax/libs/jquery.ba-bbq/1.2.1/',
                    'js'      => array('jquery.ba-bbq.min.js'),
                ),
                'history'   => array(
                    'baseUrl' => '//cdnjs.cloudflare.com/ajax/libs/history.js/1.8/bundled/html5/',
                    'js'      => array('jquery.history.js'),
                ),
                'punycode'  => array(
                    'baseUrl' => '//cdnjs.cloudflare.com/ajax/libs/punycode/1.0.0/',
                    'js'      => array('punycode.min.js')
                ),
            ),
        ),
        'widgetFactory' => array(
            'widgets' => array(
                'TbEditableField' => array(
                    'emptytext' => ' — ',
                    'options'   => array(
                        'showbuttons' => false,
                        'clear'       => '<i class="icon icon-remove"></i>',
                        'datepicker'  => array('autoclose' => true, 'todayBtn' => 'linked')
                    ),
                ),
                'TbDatePicker'    => array(
                    'options' => array('autoclose' => true, 'todayBtn' => 'linked')
                ),
            ),
        ),
        'urlManager'    => array(
            'urlFormat'      => 'path',
            'urlSuffix'      => '/',
            'showScriptName' => false,
            'cacheID'        => 'cache',
            'rules'          => array(
                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'        => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>/<slug:[\w\_-]+>' => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>'                 => '<module>/<controller>/<action>',
                '<controller:\w+>/<id:\d+>'                                  => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'                     => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>'                              => '<controller>/<action>',
            )
        ),
        'authManager'   => array(
            'class'           => 'auth.components.CachedDbAuthManager',
            'cachingDuration' => 3600,
            'itemTable'       => '{{auth_item}}',
            'itemChildTable'  => '{{auth_item_child}}',
            'assignmentTable' => '{{auth_assignment}}',
            'behaviors'       => array('auth' => array('class' => 'auth.components.AuthBehavior')),
        ),
        'errorHandler'  => array('errorAction' => 'site/error'),
        'cache'         => array('class' => 'CFileCache'),
        'log'           => array(
            'class'  => 'CLogRouter',
            'routes' => array(
                array(
                    'class'  => 'CFileLogRoute',
                    'levels' => 'error, warning, info',
                ),
            ),
        ),
        'bootstrap'     => array(
            'class'            => 'ext.bootstrap.components.Bootstrap',
            'jqueryCss'        => false,
            'enableBootboxJS'  => false,
            'enableNotifierJS' => false,
            'enableCdn'        => true,
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    /*'params' => array(

    ),*/
);
