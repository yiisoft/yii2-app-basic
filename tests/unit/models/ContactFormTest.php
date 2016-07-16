<?php

namespace tests\models;

use app\models\ContactForm;

class ContactFormTest extends \Codeception\Test\Unit
{
    private $model;

    protected function _before()
    {
        \Yii::$app->mailer->fileTransportCallback = function () {
            return 'testing_message.eml';
        };
    }

    protected function _after()
    {
        unlink($this->getMessageFile());
    }

    public function testEmailIsSentOnContact()
    {
        /** @var ContactForm $model */
        $this->model = $this->getMockBuilder('app\models\ContactForm')
            ->setMethods(['validate'])
            ->getMock();

        $this->model->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(true));

        $this->model->attributes = [
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'subject' => 'very important letter subject',
            'body' => 'body of current message',
        ];

        expect_that($this->model->contact('admin@example.com'));
        expect_that(file_exists($this->getMessageFile()));

        $emailMessage = file_get_contents($this->getMessageFile());

        expect($emailMessage)->contains($this->model->name);
        expect($emailMessage)->contains($this->model->email);
        expect($emailMessage)->contains($this->model->subject);
        expect($emailMessage)->contains($this->model->body);
    }

    private function getMessageFile()
    {
        return \Yii::getAlias(\Yii::$app->mailer->fileTransportPath) . '/testing_message.eml';
    }
}
