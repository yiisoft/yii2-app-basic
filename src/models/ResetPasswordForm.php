<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\models;

use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Model;

/**
 * Handles password reset with a valid token.
 */
final class ResetPasswordForm extends Model
{
    public string $password = '';

    private User|null $user = null;

    /**
     * Creates a form model given a token.
     *
     * @param string $token the password reset token.
     * @param array<string, mixed> $config name-value pairs that will be used to initialize the object properties.
     *
     * @throws InvalidArgumentException if token is empty or not valid.
     */
    public function __construct(string $token, array $config = [])
    {
        if ($token === '') {
            throw new InvalidArgumentException('Password reset token cannot be blank.');
        }

        $this->user = User::findByPasswordResetToken($token);

        if ($this->user === null) {
            throw new InvalidArgumentException('Wrong password reset token.');
        }

        parent::__construct($config);
    }

    /**
     * Resets password.
     */
    public function resetPassword(): bool
    {
        if ($this->user === null) {
            return false;
        }

        $this->user->setPassword($this->password);
        $this->user->removePasswordResetToken();
        $this->user->generateAuthKey();

        return $this->user->save(false);
    }

    public function rules(): array
    {
        return [
            [
                'password',
                'required',
            ],
            [
                'password',
                'string',
                'min' => Yii::$app->params['user.passwordMinLength'],
            ],
        ];
    }
}
