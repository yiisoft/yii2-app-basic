<?php
return [
    // 微信模块
    'wechat' => [
        'class' => 'callmez\wechat\Module',
        'modules' => [
            'admin' => 'callmez\wechat\modules\admin\Module' // 微信后台管理模块
        ]
    ],
    'example' => [ // 微信扩展示例模块, 生产环境可删除
        'class' => 'app\modules\example\Module',
    ],
];