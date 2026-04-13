<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\widgets;

use Yii;
use yii\bootstrap5\Alert as BootstrapAlert;

/**
 * Alert widget renders a message from session flash. All flash messages are displayed in the sequence they were
 * assigned using setFlash. You can set message as following:
 *
 * ```php
 * Yii::$app->session->setFlash('error', 'This is the message');
 * Yii::$app->session->setFlash('success', 'This is the message');
 * Yii::$app->session->setFlash('info', 'This is the message');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * Yii::$app->session->setFlash('error', ['Error 1', 'Error 2']);
 */
final class Alert extends \yii\bootstrap5\Widget
{
    /**
     * @var array<string, string> the alert types configuration for the flash messages.
     *
     * This array is setup as $key => $value, where:
     * - key: the name of the session flash variable
     * - value: the bootstrap alert type (i.e. danger, success, info, warning)
     */
    public array $alertTypes = [
        'error' => 'alert-danger',
        'danger' => 'alert-danger',
        'success' => 'alert-success',
        'info' => 'alert-info',
        'warning' => 'alert-warning',
    ];
    /**
     * @var array<string, mixed> the options for rendering the close button tag.
     */
    public array $closeButton = [];

    public function run(): void
    {
        $session = Yii::$app->session;

        if (!$session->getIsActive() && !$session->getHasSessionId()) {
            return;
        }

        $appendClass = isset($this->options['class']) && is_string($this->options['class'])
            ? ' ' . $this->options['class']
            : '';

        foreach (array_keys($this->alertTypes) as $type) {
            $flash = $session->getFlash($type);

            foreach ((array) $flash as $i => $message) {
                echo BootstrapAlert::widget(
                    [
                        'body' => $message,
                        'closeButton' => $this->closeButton,
                        'options' => [
                            ...$this->options,
                            'id' => $this->getId() . '-' . $type . '-' . $i,
                            'class' => $this->alertTypes[$type] . $appendClass,
                        ],
                    ],
                );
            }

            $session->removeFlash($type);
        }
    }
}
