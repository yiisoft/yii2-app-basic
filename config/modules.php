<?php
return [
    // 微信模块
    'wechat' => [
        'class' => 'callmez\wechat\Module',
        'adminId' => [100, 101] // 这里填写管理员ID(拥有wechat最高管理权限)
    ],
    'example' => [ // 微信扩展示例模块, 生产环境可删除
        'class' => 'app\modules\example\Module',
    ],
];