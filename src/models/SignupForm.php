<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\models;

use Throwable;
use Yii;
use yii\base\Model;
use yii\mail\MailerInterface;

/**
 * Handles user registration with email verification.
 */
final class SignupForm extends Model
{
    public string $email = '';
    public string $password = '';
    public string $username = '';

    public function rules(): array
    {
        return [
            [
                'username',
                'trim',
            ],
            [
                'username',
                'required',
            ],
            [
                'username',
                'unique',
                'targetClass' => User::class,
                'message' => 'This username has already been taken.',
            ],
            [
                'username',
                'string',
                'min' => 2,
                'max' => 255,
            ],

            [
                'email',
                'trim',
            ],
            [
                'email',
                'required',
            ],
            [
                'email',
                'email',
            ],
            [
                'email',
                'string',
                'max' => 255,
            ],
            [
                'email',
                'unique',
                'targetClass' => User::class,
                'message' => 'This email address has already been taken.',
            ],

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

    /**
     * Signs user up.
     *
     * @return bool|null whether the creating new account was successful and email was sent.
     */
    public function signup(MailerInterface $mailer, string $supportEmail, string $appName): bool|null
    {
        if (!$this->validate()) {
            return null;
        }

        $transaction = null;

        try {
            $transaction = Yii::$app->db->beginTransaction();

            $user = new User();

            $user->username = $this->username;
            $user->email = $this->email;

            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();

            if (!$user->save()) {
                $transaction->rollBack();

                return false;
            }

            if (!$this->sendEmail($mailer, $user, $supportEmail, $appName)) {
                $transaction->rollBack();

                return false;
            }

            $transaction->commit();

            return true;
        } catch (Throwable $e) {
            if ($transaction !== null && $transaction->isActive) {
                $transaction->rollBack();
            }

            Yii::error($e->getMessage(), __METHOD__);

            return false;
        }
    }

    /**
     * Sends confirmation email to user.
     */
    protected function sendEmail(MailerInterface $mailer, User $user, string $supportEmail, string $appName): bool
    {
        return $mailer
            ->compose(['html' => 'emailVerify-html', 'text' => 'emailVerify-text'], ['user' => $user])
            ->setFrom([$supportEmail => "{$appName} robot"])
            ->setTo($this->email)
            ->setSubject("Account registration at {$appName}")
            ->send();
    }
}
