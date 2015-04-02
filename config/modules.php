<?php
return [
    // 微信模块
    'wechat' => [
        'class' => 'callmez\wechat\Module',
        'modules' => [
            'admin' => 'callmez\wechat\modules\admin\Module' // 微信后台管理模块
        ]
    ],
];