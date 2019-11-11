<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\Contacts;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;


    /**
     * {@inheritdoc}
     */
    public function rules()
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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('common', 'Name'),
            'email' => Yii::t('common', 'Email'),
            'subject' => Yii::t('common', 'Subject'),
            'body' => Yii::t('common', 'Body'),
            'verifyCode' => Yii::t('common', 'Verification Code')
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function saveContact()
    {
        $model = new Contacts();
        $model->name = $this->name;
        $model->email = $this->email;
        $model->subject = $this->subject;
        $model->body = $this->body;
        return $model->save();
    }
}
