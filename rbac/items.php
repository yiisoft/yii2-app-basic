<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

use yii\rbac\Item;

return [
    'admin' => [
        'type' => Item::TYPE_ROLE,
        'description' => 'Administrator',
        'children' => [
            'viewUsers',
        ],
    ],
    'viewUsers' => [
        'type' => Item::TYPE_PERMISSION,
        'description' => 'View the users grid',
    ],
];
