<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Represents the login form model with username/password authentication.
 *
 * @property User|null $user
 */
class LoginForm extends Model
{
    public string $password = '';
    public bool $rememberMe = true;
    public string $username = '';

    private User|null $user = null;

    /**
     * Finds user by [[username]].
     */
    public function getUser(): User|null
    {
        if ($this->user === null) {
            $this->user = User::findByUsername($this->username);
        }

        return $this->user;
    }

    /**
     * Logs in a user using the provided username and password.
     */
    public function login(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->getUser();

        if ($user === null) {
            return false;
        }

        return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
    }

    public function rules(): array
    {
        return [
            [
                [
                    'username',
                    'password',
                ],
                'required',
            ],
            [
                'rememberMe',
                'boolean',
            ],
            [
                'password',
                'validatePassword',
            ],
        ];
    }

    /**
     * Validates the password.
     *
     * This method serves as the inline validation for password.
     */
    public function validatePassword(string $attribute, mixed $params): void
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if ($user === null || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }
}
