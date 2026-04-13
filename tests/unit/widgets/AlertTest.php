<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\tests\unit\widgets;

use app\widgets\Alert;
use Yii;

/**
 * Unit tests for {@see \app\widgets\Alert} widget.
 */
class AlertTest extends \Codeception\Test\Unit
{
    /**
     * @var array<string, array{string, string, string[]}>
     */
    private const ALERT_TYPE_CASES = [
        'danger' => [
            'danger',
            'alert-danger',
            ['alert-success', 'alert-info', 'alert-warning'],
        ],
        'error' => [
            'error',
            'alert-danger',
            ['alert-success', 'alert-info', 'alert-warning'],
        ],
        'info' => [
            'info',
            'alert-info',
            ['alert-danger', 'alert-success', 'alert-warning'],
        ],
        'success' => [
            'success',
            'alert-success',
            ['alert-danger', 'alert-info', 'alert-warning'],
        ],
        'warning' => [
            'warning',
            'alert-warning',
            ['alert-danger', 'alert-success', 'alert-info'],
        ],
    ];

    /**
     * @return array<string, array{string, string, string[]}>
     */
    public static function multipleMessagesProvider(): array
    {
        return self::ALERT_TYPE_CASES;
    }

    /**
     * @return array<string, array{string, string, string[]}>
     */
    public static function singleMessageProvider(): array
    {
        return self::ALERT_TYPE_CASES;
    }

    public function testFlashIntegrity(): void
    {
        $errorMessage = 'This is an error message';
        $unrelatedMessage = 'This is a message that is not related to the alert widget';

        Yii::$app->session->setFlash('error', $errorMessage);
        Yii::$app->session->setFlash('unrelated', $unrelatedMessage);

        Alert::widget();

        // Simulate redirect
        Yii::$app->session->close();
        Yii::$app->session->open();

        verify(Yii::$app->session->getFlash('error'))
            ->empty('Failed asserting that handled "error" flash is consumed after rendering.');
        verify(Yii::$app->session->getFlash('unrelated'))
            ->equals($unrelatedMessage, 'Failed asserting that unhandled "unrelated" flash is preserved.');
    }

    /**
     * @dataProvider multipleMessagesProvider
     *
     * @param string[] $excludedClasses
     */
    public function testMultipleMessages(string $flashType, string $expectedClass, array $excludedClasses): void
    {
        $firstMessage = "This is the first {$flashType} message";
        $secondMessage = "This is the second {$flashType} message";

        Yii::$app->session->setFlash($flashType, [$firstMessage, $secondMessage]);

        $renderingResult = Alert::widget();

        verify($renderingResult)
            ->stringContainsString($firstMessage, "Failed asserting that first \"{$flashType}\" message is rendered.");
        verify($renderingResult)
            ->stringContainsString($secondMessage, "Failed asserting that second \"{$flashType}\" message is rendered.");
        verify($renderingResult)
            ->stringContainsString($expectedClass, "Failed asserting that \"{$expectedClass}\" CSS class is present.");

        foreach ($excludedClasses as $excludedClass) {
            verify($renderingResult)
                ->stringNotContainsString($excludedClass, "Failed asserting that \"{$excludedClass}\" CSS class is absent.");
        }
    }

    public function testMultipleMixedMessages(): void
    {
        $types = ['error', 'danger', 'success', 'info', 'warning'];
        $messages = [];

        foreach ($types as $type) {
            $messages[$type] = [
                "This is the first {$type} message",
                "This is the second {$type} message",
            ];
            Yii::$app->session->setFlash($type, $messages[$type]);
        }

        $renderingResult = Alert::widget();

        foreach ($messages as $type => $typeMessages) {
            foreach ($typeMessages as $message) {
                verify($renderingResult)
                    ->stringContainsString($message, "Failed asserting that \"{$type}\" message is rendered in mixed output.");
            }
        }

        verify($renderingResult)
            ->stringContainsString('alert-danger', 'Failed asserting that "alert-danger" CSS class is present.');
        verify($renderingResult)
            ->stringContainsString('alert-success', 'Failed asserting that "alert-success" CSS class is present.');
        verify($renderingResult)
            ->stringContainsString('alert-info', 'Failed asserting that "alert-info" CSS class is present.');
        verify($renderingResult)
            ->stringContainsString('alert-warning', 'Failed asserting that "alert-warning" CSS class is present.');
    }

    public function testRenderWithCustomCssClass(): void
    {
        Yii::$app->session->setFlash('success', 'Custom class message');

        $renderingResult = Alert::widget(['options' => ['class' => 'my-custom-class']]);

        verify($renderingResult)
            ->stringContainsString('Custom class message', 'Failed asserting that custom class alert message is rendered.');
        verify($renderingResult)
            ->stringContainsString('alert-success my-custom-class', 'Failed asserting that custom CSS class is appended.');
    }

    /**
     * @dataProvider singleMessageProvider
     *
     * @param string[] $excludedClasses
     */
    public function testSingleMessage(string $flashType, string $expectedClass, array $excludedClasses): void
    {
        $message = "This is a {$flashType} message";

        Yii::$app->session->setFlash($flashType, $message);

        $renderingResult = Alert::widget();

        verify($renderingResult)
            ->stringContainsString($message, "Failed asserting that single \"{$flashType}\" message is rendered.");
        verify($renderingResult)
            ->stringContainsString($expectedClass, "Failed asserting that \"{$expectedClass}\" CSS class is present.");

        foreach ($excludedClasses as $excludedClass) {
            verify($renderingResult)
                ->stringNotContainsString($excludedClass, "Failed asserting that \"{$excludedClass}\" CSS class is absent.");
        }
    }

    public function testSingleMixedMessages(): void
    {
        $errorMessage = 'This is an error message';
        $dangerMessage = 'This is a danger message';
        $successMessage = 'This is a success message';
        $infoMessage = 'This is an info message';
        $warningMessage = 'This is a warning message';

        Yii::$app->session->setFlash('error', $errorMessage);
        Yii::$app->session->setFlash('danger', $dangerMessage);
        Yii::$app->session->setFlash('success', $successMessage);
        Yii::$app->session->setFlash('info', $infoMessage);
        Yii::$app->session->setFlash('warning', $warningMessage);

        $renderingResult = Alert::widget();

        verify($renderingResult)
            ->stringContainsString($errorMessage, 'Failed asserting that "error" message is rendered.');
        verify($renderingResult)
            ->stringContainsString($dangerMessage, 'Failed asserting that "danger" message is rendered.');
        verify($renderingResult)
            ->stringContainsString($successMessage, 'Failed asserting that "success" message is rendered.');
        verify($renderingResult)
            ->stringContainsString($infoMessage, 'Failed asserting that "info" message is rendered.');
        verify($renderingResult)
            ->stringContainsString($warningMessage, 'Failed asserting that "warning" message is rendered.');

        verify($renderingResult)
            ->stringContainsString('alert-danger', 'Failed asserting that "alert-danger" CSS class is present.');
        verify($renderingResult)
            ->stringContainsString('alert-success', 'Failed asserting that "alert-success" CSS class is present.');
        verify($renderingResult)
            ->stringContainsString('alert-info', 'Failed asserting that "alert-info" CSS class is present.');
        verify($renderingResult)
            ->stringContainsString('alert-warning', 'Failed asserting that "alert-warning" CSS class is present.');
    }

    public function testSkipsSessionStartWhenNoSessionExists(): void
    {
        $session = Yii::$app->session;
        $cookieName = $session->getName();
        $previousCookie = $_COOKIE[$cookieName] ?? null;

        try {
            $session->close();
            unset($_COOKIE[$cookieName]);

            verify($session->getIsActive())
                ->false('Failed asserting that session is inactive after close.');
            verify($session->getHasSessionId())
                ->false('Failed asserting that no session ID exists.');

            $renderingResult = Alert::widget();

            verify($renderingResult)
                ->equals('', 'Failed asserting that widget renders empty string without session.');
            verify($session->getIsActive())
                ->false('Failed asserting that widget did not start a new session.');
        } finally {
            if ($previousCookie === null) {
                unset($_COOKIE[$cookieName]);
            } else {
                $_COOKIE[$cookieName] = $previousCookie;
            }
        }
    }
}
