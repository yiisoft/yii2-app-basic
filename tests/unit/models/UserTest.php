<?php

namespace tests\unit\models;

use app\models\User;

class UserTest extends \Codeception\Test\Unit
{
    public function testFindUserById()
    {
        verify($user = User::findIdentity(100))->isNotEmpty();
        verify($user->username)->equals('admin');

        verify(User::findIdentity(999))->isEmpty();
    }

    public function testFindUserByAccessToken()
    {
        verify($user = User::findIdentityByAccessToken('100-token'))->isNotEmpty();
        verify($user->username)->equals('admin');

        verify(User::findIdentityByAccessToken('non-existing'))->isEmpty();        
    }

    public function testFindUserByUsername()
    {
        verify($user = User::findByUsername('admin'))->isNotEmpty();
        verify(User::findByUsername('not-admin'))->isEmpty();
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser($user)
    {
        $user = User::findByUsername('admin');
        verify($user->validateAuthKey('test100key'))->isNotEmpty();
        verify($user->validateAuthKey('test102key'))->isEmpty();

        verify($user->validatePassword('admin'))->isNotEmpty();
        verify($user->validatePassword('123456'))->isEmpty();        
    }

}
