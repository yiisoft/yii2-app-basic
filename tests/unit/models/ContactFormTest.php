<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\tests\unit\models;

use app\models\ContactForm;
use app\tests\support\UnitTester;
use Yii;
use yii\mail\MessageInterface;

/**
 * Unit tests for {@see \app\models\ContactForm} model.
 */
final class ContactFormTest extends \Codeception\Test\Unit
{
    public UnitTester|null $tester = null;

    public function testEmailIsSentOnContact(): void
    {
        $model = new ContactForm();

        $model->attributes = [
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'phone' => '(555) 123-4567',
            'subject' => 'very important letter subject',
            'body' => 'body of current message',
            'verifyCode' => 'testme',
        ];

        verify(
            $model->contact(
                Yii::$app->mailer,
                'admin@example.com',
                'noreply@example.com',
                'Example.com mailer',
            ),
        )->notEmpty(
            "Failed asserting that 'contact' email is sent successfully.",
        );

        // using Yii2 module actions to check email was sent
        $this->tester?->seeEmailIsSent();

        /** @var \yii\symfonymailer\Message $emailMessage */
        $emailMessage = $this->tester?->grabLastSentEmail();

        verify($emailMessage)
            ->instanceOf(
                MessageInterface::class,
                "Failed asserting that a 'contact' email was captured.",
            );
        verify($emailMessage->getTo())
            ->arrayHasKey(
                'admin@example.com',
                'Failed asserting that email is sent to the admin address.',
            );
        verify($emailMessage->getFrom())
            ->arrayHasKey(
                'noreply@example.com',
                "Failed asserting that email is sent from the 'noreply' address.",
            );
        verify($emailMessage->getReplyTo())
            ->arrayHasKey(
                'tester@example.com',
                "Failed asserting that 'reply-to' is set to the contact email.",
            );
        verify($emailMessage->getSubject())
            ->equals(
                'very important letter subject',
                "Failed asserting that email 'subject' matches the form input.",
            );
        verify($emailMessage->getSymfonyEmail()->getTextBody())
            ->stringContainsString(
                'body of current message',
                "Failed asserting that email 'body' contains the form message.",
            );
    }
}
