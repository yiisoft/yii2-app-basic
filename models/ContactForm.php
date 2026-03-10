<?php

declare(strict_types=1);

namespace app\models;

use yii\base\Model;
use yii\mail\MailerInterface;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public string $name = '';
    public string $email = '';
    public string $subject = '';
    public string $body = '';
    public string $verifyCode = '';

    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels(): array
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param MailerInterface $mailer the mailer component.
     * @param string $email the target email address.
     * @param string $senderEmail the sender email address.
     * @param string $senderName the sender name.
     *
     * @return bool whether the model passes validation.
     */
    public function contact(MailerInterface $mailer, string $email, string $senderEmail, string $senderName): bool
    {
        if ($this->validate()) {
            $mailer->compose()
                ->setTo($email)
                ->setFrom([$senderEmail => $senderName])
                ->setReplyTo([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();

            return true;
        }

        return false;
    }
}
