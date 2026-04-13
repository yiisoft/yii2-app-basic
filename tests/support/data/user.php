<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

return [
    [
        'username' => 'admin',
        'auth_key' => 'admin-test-auth-key-value-ok32',
        // password_0
        'password_hash' => '$2y$13$nJ1WDlBaGcbCdbNC5.5l4.sgy.OMEKCqtDQOdQ2OWpgiKRWYyzzne',
        'created_at' => 1391885313,
        'updated_at' => 1391885313,
        'email' => 'admin@example.com',
        'status' => 10,
    ],
    [
        'username' => 'okirlin',
        'auth_key' => 'iwTNae9t34OmnK6l4vT4IeaTk-YWI2Rv',
        // password_0
        'password_hash' => '$2y$13$nJ1WDlBaGcbCdbNC5.5l4.sgy.OMEKCqtDQOdQ2OWpgiKRWYyzzne',
        'password_reset_token' => 't5GU9NwpuGYSfb7FEZMAxqtuz2PkEvv_' . time(),
        'created_at' => 1391885313,
        'updated_at' => 1391885313,
        'email' => 'okirlin@example.com',
        'status' => 10,
    ],
    [
        'username' => 'troy.becker',
        'auth_key' => 'EdKfXrx88weFMV0vIxuTMWKgfK2tS3Lp',
        // password_0
        'password_hash' => '$2y$13$nJ1WDlBaGcbCdbNC5.5l4.sgy.OMEKCqtDQOdQ2OWpgiKRWYyzzne',
        'password_reset_token' => '4BSNyiZNAuxjs5Mty990c47sVrgllIi_' . time(),
        'created_at' => 1391885313,
        'updated_at' => 1391885313,
        'email' => 'troy.becker@example.com',
        'status' => 0,
    ],
    [
        'username' => 'test.test',
        'auth_key' => 'O87GkY3_UfmMHYkyezZ7QLfmkKNsllzT',
        // Test1234
        'password_hash' => '$2y$13$d17z0w/wKC4LFwtzBcmx6up4jErQuandJqhzKGKczfWuiEhLBtQBK',
        'email' => 'test.test@example.com',
        'status' => 9,
        'created_at' => 1548675330,
        'updated_at' => 1548675330,
        'verification_token' => '4ch0qbfhvWwkcuWqjN8SWRq72SOw1KYT_' . time(),
    ],
    [
        'username' => 'test2.test',
        'auth_key' => '4XXdVqi3rDpa_a6JH6zqVreFxUPcUPvJ',
        // Test1234
        'password_hash' => '$2y$13$d17z0w/wKC4LFwtzBcmx6up4jErQuandJqhzKGKczfWuiEhLBtQBK',
        'email' => 'test2.test@example.com',
        'status' => 10,
        'created_at' => 1548675330,
        'updated_at' => 1548675330,
        'verification_token' => 'already_used_token_' . time(),
    ],
];
