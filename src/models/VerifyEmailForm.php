<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\models;

use yii\base\InvalidArgumentException;
use yii\base\Model;

/**
 * Handles email verification after user registration.
 */
final class VerifyEmailForm extends Model
{
    private User|null $user = null;

    /**
     * Creates a form model with given token.
     *
     * @param string $token The verification token.
     * @param array<string, mixed> $config name-value pairs that will be used to initialize the object properties.
     *
     * @throws InvalidArgumentException if token is empty or not valid.
     */
    public function __construct(string $token, array $config = [])
    {
        if ($token === '') {
            throw new InvalidArgumentException('Verify email token cannot be blank.');
        }

        $this->user = User::findByVerificationToken($token);

        if ($this->user === null) {
            throw new InvalidArgumentException('Wrong verify email token.');
        }

        parent::__construct($config);
    }

    /**
     * Verifies email.
     *
     * @return User|null the saved model or `null` if saving fails.
     */
    public function verifyEmail(): User|null
    {
        if ($this->user === null) {
            return null;
        }

        $this->user->status = User::STATUS_ACTIVE;
        $this->user->verification_token = null;

        return $this->user->save(false) ? $this->user : null;
    }
}
