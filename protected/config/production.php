<?php
return CMap::mergeArray(
    require(dirname(__FILE__) . '/main.php'),
    array(
        'name'       => 'Yii CRM (production)',
        'components' => array(
            'db'   => array_merge(
                require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'db.php'),
                array('schemaCachingDuration' => 108000)
            ),
            'user' => array(
                'admins' => array('fad'), // !user names with full access!
            ),
            'cache' => array('class' => 'CApcCache'),
        )
    )
);
