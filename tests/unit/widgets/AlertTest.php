<?php

namespace tests\unit\widgets;

use app\widgets\Alert;
use Yii;

class AlertTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    public $tester;

    public function testSingleErrorMessage()
    {
        $message = 'This is an error message';

        Yii::$app->session->setFlash('error', $message);

        $renderingResult = Alert::widget();

        $this->tester->assertStringContainsString($message, $renderingResult);
        $this->tester->assertStringContainsString('alert-danger', $renderingResult);

        $this->tester->assertStringNotContainsString('alert-success', $renderingResult);
        $this->tester->assertStringNotContainsString('alert-info', $renderingResult);
        $this->tester->assertStringNotContainsString('alert-warning', $renderingResult);
    }

    public function testMultipleErrorMessages()
    {
        $firstMessage = 'This is the first error message';
        $secondMessage = 'This is the second error message';

        Yii::$app->session->setFlash('error', [$firstMessage, $secondMessage]);

        $renderingResult = Alert::widget();

        $this->tester->assertStringContainsString($firstMessage, $renderingResult);
        $this->tester->assertStringContainsString($secondMessage, $renderingResult);
        $this->tester->assertStringContainsString('alert-danger', $renderingResult);

        $this->tester->assertStringNotContainsString('alert-success', $renderingResult);
        $this->tester->assertStringNotContainsString('alert-info', $renderingResult);
        $this->tester->assertStringNotContainsString('alert-warning', $renderingResult);
    }

    public function testSingleDangerMessage()
    {
        $message = 'This is a danger message';

        Yii::$app->session->setFlash('danger', $message);

        $renderingResult = Alert::widget();

        $this->tester->assertStringContainsString($message, $renderingResult);
        $this->tester->assertStringContainsString('alert-danger', $renderingResult);

        $this->tester->assertStringNotContainsString('alert-success', $renderingResult);
        $this->tester->assertStringNotContainsString('alert-info', $renderingResult);
        $this->tester->assertStringNotContainsString('alert-warning', $renderingResult);
    }

    public function testMultipleDangerMessages()
    {
        $firstMessage = 'This is the first danger message';
        $secondMessage = 'This is the second danger message';

        Yii::$app->session->setFlash('danger', [$firstMessage, $secondMessage]);

        $renderingResult = Alert::widget();

        $this->tester->assertStringContainsString($firstMessage, $renderingResult);
        $this->tester->assertStringContainsString($secondMessage, $renderingResult);
        $this->tester->assertStringContainsString('alert-danger', $renderingResult);

        $this->tester->assertStringNotContainsString('alert-success', $renderingResult);
        $this->tester->assertStringNotContainsString('alert-info', $renderingResult);
        $this->tester->assertStringNotContainsString('alert-warning', $renderingResult);
    }

    public function testSingleSuccessMessage()
    {
        $message = 'This is a success message';

        Yii::$app->session->setFlash('success', $message);

        $renderingResult = Alert::widget();

        $this->tester->assertStringContainsString($message, $renderingResult);
        $this->tester->assertStringContainsString('alert-success', $renderingResult);

        $this->tester->assertStringNotContainsString('alert-danger', $renderingResult);
        $this->tester->assertStringNotContainsString('alert-info', $renderingResult);
        $this->tester->assertStringNotContainsString('alert-warning', $renderingResult);
    }

    public function testMultipleSuccessMessages()
    {
        $firstMessage = 'This is the first danger message';
        $secondMessage = 'This is the second danger message';

        Yii::$app->session->setFlash('success', [$firstMessage, $secondMessage]);

        $renderingResult = Alert::widget();

        $this->tester->assertStringContainsString($firstMessage, $renderingResult);
        $this->tester->assertStringContainsString($secondMessage, $renderingResult);
        $this->tester->assertStringContainsString('alert-success', $renderingResult);

        $this->tester->assertStringNotContainsString('alert-danger', $renderingResult);
        $this->tester->assertStringNotContainsString('alert-info', $renderingResult);
        $this->tester->assertStringNotContainsString('alert-warning', $renderingResult);
    }

    public function testSingleInfoMessage()
    {
        $message = 'This is an info message';

        Yii::$app->session->setFlash('info', $message);

        $renderingResult = Alert::widget();

        $this->tester->assertStringContainsString($message, $renderingResult);
        $this->tester->assertStringContainsString('alert-info', $renderingResult);

        $this->tester->assertStringNotContainsString('alert-danger', $renderingResult);
        $this->tester->assertStringNotContainsString('alert-success', $renderingResult);
        $this->tester->assertStringNotContainsString('alert-warning', $renderingResult);
    }

    public function testMultipleInfoMessages()
    {
        $firstMessage = 'This is the first info message';
        $secondMessage = 'This is the second info message';

        Yii::$app->session->setFlash('info', [$firstMessage, $secondMessage]);

        $renderingResult = Alert::widget();

        $this->tester->assertStringContainsString($firstMessage, $renderingResult);
        $this->tester->assertStringContainsString($secondMessage, $renderingResult);
        $this->tester->assertStringContainsString('alert-info', $renderingResult);

        $this->tester->assertStringNotContainsString('alert-danger', $renderingResult);
        $this->tester->assertStringNotContainsString('alert-success', $renderingResult);
        $this->tester->assertStringNotContainsString('alert-warning', $renderingResult);
    }

    public function testSingleWarningMessage()
    {
        $message = 'This is a warning message';

        Yii::$app->session->setFlash('warning', $message);

        $renderingResult = Alert::widget();

        $this->tester->assertStringContainsString($message, $renderingResult);
        $this->tester->assertStringContainsString('alert-warning', $renderingResult);

        $this->tester->assertStringNotContainsString('alert-danger', $renderingResult);
        $this->tester->assertStringNotContainsString('alert-success', $renderingResult);
        $this->tester->assertStringNotContainsString('alert-info', $renderingResult);
    }

    public function testMultipleWarningMessages()
    {
        $firstMessage = 'This is the first warning message';
        $secondMessage = 'This is the second warning message';

        Yii::$app->session->setFlash('warning', [$firstMessage, $secondMessage]);

        $renderingResult = Alert::widget();

        $this->tester->assertStringContainsString($firstMessage, $renderingResult);
        $this->tester->assertStringContainsString($secondMessage, $renderingResult);
        $this->tester->assertStringContainsString('alert-warning', $renderingResult);

        $this->tester->assertStringNotContainsString('alert-danger', $renderingResult);
        $this->tester->assertStringNotContainsString('alert-success', $renderingResult);
        $this->tester->assertStringNotContainsString('alert-info', $renderingResult);
    }

    public function testSingleMixedMessages() {
        $errorMessage = 'This is an error message';
        $dangerMessage = 'This is a danger message';
        $successMessage = 'This is a success message';
        $infoMessage = 'This is a info message';
        $warningMessage = 'This is a warning message';

        Yii::$app->session->setFlash('error', $errorMessage);
        Yii::$app->session->setFlash('danger', $dangerMessage);
        Yii::$app->session->setFlash('success', $successMessage);
        Yii::$app->session->setFlash('info', $infoMessage);
        Yii::$app->session->setFlash('warning', $warningMessage);

        $renderingResult = Alert::widget();

        $this->tester->assertStringContainsString($errorMessage, $renderingResult);
        $this->tester->assertStringContainsString($dangerMessage, $renderingResult);
        $this->tester->assertStringContainsString($successMessage, $renderingResult);
        $this->tester->assertStringContainsString($infoMessage, $renderingResult);
        $this->tester->assertStringContainsString($warningMessage, $renderingResult);

        $this->tester->assertStringContainsString('alert-danger', $renderingResult);
        $this->tester->assertStringContainsString('alert-success', $renderingResult);
        $this->tester->assertStringContainsString('alert-info', $renderingResult);
        $this->tester->assertStringContainsString('alert-warning', $renderingResult);
    }

    public function testMultipleMixedMessages() {
        $firstErrorMessage = 'This is the first error message';
        $secondErrorMessage = 'This is the second error message';
        $firstDangerMessage = 'This is the first danger message';
        $secondDangerMessage = 'This is the second';
        $firstSuccessMessage = 'This is the first success message';
        $secondSuccessMessage = 'This is the second success message';
        $firstInfoMessage = 'This is the first info message';
        $secondInfoMessage = 'This is the second info message';
        $firstWarningMessage = 'This is the first warning message';
        $secondWarningMessage = 'This is the second warning message';

        Yii::$app->session->setFlash('error', [$firstErrorMessage, $secondErrorMessage]);
        Yii::$app->session->setFlash('danger', [$firstDangerMessage, $secondDangerMessage]);
        Yii::$app->session->setFlash('success', [$firstSuccessMessage, $secondSuccessMessage]);
        Yii::$app->session->setFlash('info', [$firstInfoMessage, $secondInfoMessage]);
        Yii::$app->session->setFlash('warning', [$firstWarningMessage, $secondWarningMessage]);

        $renderingResult = Alert::widget();

        $this->tester->assertStringContainsString($firstErrorMessage, $renderingResult);
        $this->tester->assertStringContainsString($secondErrorMessage, $renderingResult);
        $this->tester->assertStringContainsString($firstDangerMessage, $renderingResult);
        $this->tester->assertStringContainsString($secondDangerMessage, $renderingResult);
        $this->tester->assertStringContainsString($firstSuccessMessage, $renderingResult);
        $this->tester->assertStringContainsString($secondSuccessMessage, $renderingResult);
        $this->tester->assertStringContainsString($firstInfoMessage, $renderingResult);
        $this->tester->assertStringContainsString($secondInfoMessage, $renderingResult);
        $this->tester->assertStringContainsString($firstWarningMessage, $renderingResult);
        $this->tester->assertStringContainsString($secondWarningMessage, $renderingResult);

        $this->tester->assertStringContainsString('alert-danger', $renderingResult);
        $this->tester->assertStringContainsString('alert-success', $renderingResult);
        $this->tester->assertStringContainsString('alert-info', $renderingResult);
        $this->tester->assertStringContainsString('alert-warning', $renderingResult);
    }

    public function testFlashIntegrity()
    {
        $errorMessage = 'This is an error message';
        $unrelatedMessage = 'This is a message that is not related to the alert widget';

        Yii::$app->session->setFlash('error', $errorMessage);
        Yii::$app->session->setFlash('unrelated', $unrelatedMessage);

        Alert::widget();

        // Simulate redirect
        Yii::$app->session->close();
        Yii::$app->session->open();

        $this->tester->assertNull(Yii::$app->session->getFlash('error'));
        $this->tester->assertEquals($unrelatedMessage, Yii::$app->session->getFlash('unrelated'));
    }
}
