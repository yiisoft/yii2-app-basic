<?php

namespace tests\unit\widgets;

use app\widgets\Alert;
use Yii;

class AlertTest extends \Codeception\Test\Unit
{
    public function testSingleErrorMessage()
    {
        $message = 'This is an error message';

        Yii::$app->session->setFlash('error', $message);

        $renderingResult = Alert::widget();

        expect($renderingResult)->stringContainsString($message);
        expect($renderingResult)->stringContainsString('alert-danger');

        expect($renderingResult)->stringNotContainsString('alert-success');
        expect($renderingResult)->stringNotContainsString('alert-info');
        expect($renderingResult)->stringNotContainsString('alert-warning');
    }

    public function testMultipleErrorMessages()
    {
        $firstMessage = 'This is the first error message';
        $secondMessage = 'This is the second error message';

        Yii::$app->session->setFlash('error', [$firstMessage, $secondMessage]);

        $renderingResult = Alert::widget();

        expect($renderingResult)->stringContainsString($firstMessage);
        expect($renderingResult)->stringContainsString($secondMessage);
        expect($renderingResult)->stringContainsString('alert-danger');

        expect($renderingResult)->stringNotContainsString('alert-success');
        expect($renderingResult)->stringNotContainsString('alert-info');
        expect($renderingResult)->stringNotContainsString('alert-warning');
    }

    public function testSingleDangerMessage()
    {
        $message = 'This is a danger message';

        Yii::$app->session->setFlash('danger', $message);

        $renderingResult = Alert::widget();

        expect($renderingResult)->stringContainsString($message);
        expect($renderingResult)->stringContainsString('alert-danger');

        expect($renderingResult)->stringNotContainsString('alert-success');
        expect($renderingResult)->stringNotContainsString('alert-info');
        expect($renderingResult)->stringNotContainsString('alert-warning');
    }

    public function testMultipleDangerMessages()
    {
        $firstMessage = 'This is the first danger message';
        $secondMessage = 'This is the second danger message';

        Yii::$app->session->setFlash('danger', [$firstMessage, $secondMessage]);

        $renderingResult = Alert::widget();

        expect($renderingResult)->stringContainsString($firstMessage);
        expect($renderingResult)->stringContainsString($secondMessage);
        expect($renderingResult)->stringContainsString('alert-danger');

        expect($renderingResult)->stringNotContainsString('alert-success');
        expect($renderingResult)->stringNotContainsString('alert-info');
        expect($renderingResult)->stringNotContainsString('alert-warning');
    }

    public function testSingleSuccessMessage()
    {
        $message = 'This is a success message';

        Yii::$app->session->setFlash('success', $message);

        $renderingResult = Alert::widget();

        expect($renderingResult)->stringContainsString($message);
        expect($renderingResult)->stringContainsString('alert-success');

        expect($renderingResult)->stringNotContainsString('alert-danger');
        expect($renderingResult)->stringNotContainsString('alert-info');
        expect($renderingResult)->stringNotContainsString('alert-warning');
    }

    public function testMultipleSuccessMessages()
    {
        $firstMessage = 'This is the first danger message';
        $secondMessage = 'This is the second danger message';

        Yii::$app->session->setFlash('success', [$firstMessage, $secondMessage]);

        $renderingResult = Alert::widget();

        expect($renderingResult)->stringContainsString($firstMessage);
        expect($renderingResult)->stringContainsString($secondMessage);
        expect($renderingResult)->stringContainsString('alert-success');

        expect($renderingResult)->stringNotContainsString('alert-danger');
        expect($renderingResult)->stringNotContainsString('alert-info');
        expect($renderingResult)->stringNotContainsString('alert-warning');
    }

    public function testSingleInfoMessage()
    {
        $message = 'This is an info message';

        Yii::$app->session->setFlash('info', $message);

        $renderingResult = Alert::widget();

        expect($renderingResult)->stringContainsString($message);
        expect($renderingResult)->stringContainsString('alert-info');

        expect($renderingResult)->stringNotContainsString('alert-danger');
        expect($renderingResult)->stringNotContainsString('alert-success');
        expect($renderingResult)->stringNotContainsString('alert-warning');
    }

    public function testMultipleInfoMessages()
    {
        $firstMessage = 'This is the first info message';
        $secondMessage = 'This is the second info message';

        Yii::$app->session->setFlash('info', [$firstMessage, $secondMessage]);

        $renderingResult = Alert::widget();

        expect($renderingResult)->stringContainsString($firstMessage);
        expect($renderingResult)->stringContainsString($secondMessage);
        expect($renderingResult)->stringContainsString('alert-info');

        expect($renderingResult)->stringNotContainsString('alert-danger');
        expect($renderingResult)->stringNotContainsString('alert-success');
        expect($renderingResult)->stringNotContainsString('alert-warning');
    }

    public function testSingleWarningMessage()
    {
        $message = 'This is a warning message';

        Yii::$app->session->setFlash('warning', $message);

        $renderingResult = Alert::widget();

        expect($renderingResult)->stringContainsString($message);
        expect($renderingResult)->stringContainsString('alert-warning');

        expect($renderingResult)->stringNotContainsString('alert-danger');
        expect($renderingResult)->stringNotContainsString('alert-success');
        expect($renderingResult)->stringNotContainsString('alert-info');
    }

    public function testMultipleWarningMessages()
    {
        $firstMessage = 'This is the first warning message';
        $secondMessage = 'This is the second warning message';

        Yii::$app->session->setFlash('warning', [$firstMessage, $secondMessage]);

        $renderingResult = Alert::widget();

        expect($renderingResult)->stringContainsString($firstMessage);
        expect($renderingResult)->stringContainsString($secondMessage);
        expect($renderingResult)->stringContainsString('alert-warning');

        expect($renderingResult)->stringNotContainsString('alert-danger');
        expect($renderingResult)->stringNotContainsString('alert-success');
        expect($renderingResult)->stringNotContainsString('alert-info');
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

        expect($renderingResult)->stringContainsString($errorMessage);
        expect($renderingResult)->stringContainsString($dangerMessage);
        expect($renderingResult)->stringContainsString($successMessage);
        expect($renderingResult)->stringContainsString($infoMessage);
        expect($renderingResult)->stringContainsString($warningMessage);

        expect($renderingResult)->stringContainsString('alert-danger');
        expect($renderingResult)->stringContainsString('alert-success');
        expect($renderingResult)->stringContainsString('alert-info');
        expect($renderingResult)->stringContainsString('alert-warning');
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

        expect($renderingResult)->stringContainsString($firstErrorMessage);
        expect($renderingResult)->stringContainsString($secondErrorMessage);
        expect($renderingResult)->stringContainsString($firstDangerMessage);
        expect($renderingResult)->stringContainsString($secondDangerMessage);
        expect($renderingResult)->stringContainsString($firstSuccessMessage);
        expect($renderingResult)->stringContainsString($secondSuccessMessage);
        expect($renderingResult)->stringContainsString($firstInfoMessage);
        expect($renderingResult)->stringContainsString($secondInfoMessage);
        expect($renderingResult)->stringContainsString($firstWarningMessage);
        expect($renderingResult)->stringContainsString($secondWarningMessage);

        expect($renderingResult)->stringContainsString('alert-danger');
        expect($renderingResult)->stringContainsString('alert-success');
        expect($renderingResult)->stringContainsString('alert-info');
        expect($renderingResult)->stringContainsString('alert-warning');
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

        expect(Yii::$app->session->getFlash('error'))->null();
        expect(Yii::$app->session->getFlash('unrelated'))->equals($unrelatedMessage);
    }
}
