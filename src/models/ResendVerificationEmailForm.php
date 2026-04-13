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
 * Handles resending of verification email to inactive users.
 *
 * @author Wilmer Arambula <terabytesoftw@gmail.com>
 * @since 0.1
 */
final class ResendVerificationEmailForm extends Model
{
    public string $email = '';

    public function rules(): array
    {
        return [
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
                'exist',
                'targetClass' => User::class,
                'filter' => ['status' => User::STATUS_INACTIVE],
                'message' => 'There is no user with this email address.',
            ],
        ];
    }

    /**
     * Sends confirmation email to user.
     */
    public function sendEmail(MailerInterface $mailer, string $supportEmail, string $appName): bool
    {
        $user = User::findOne(
            [
                'email' => $this->email,
                'status' => User::STATUS_INACTIVE,
            ],
        );

        if ($user === null) {
            return false;
        }

        $transaction = null;

        try {
            $transaction = Yii::$app->db->beginTransaction();

            $user->generateEmailVerificationToken();

            if (!$user->save(false)) {
                $transaction->rollBack();

                return false;
            }

            $sent = $mailer
                ->compose(['html' => 'emailVerify-html', 'text' => 'emailVerify-text'], ['user' => $user])
                ->setFrom([$supportEmail => "{$appName} robot"])
                ->setTo($this->email)
                ->setSubject("Account registration at {$appName}")
                ->send();

            if (!$sent) {
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
}
