<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Formmodel extends Model
{
    public $text1;
    public $text2;    
    public $date1;
    public $date2;
    public $date3;
    public $date4;    
    public $select1;
    public $select2;
    public $radio_list;
    public $checkbox_list;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['text1','text2','date1', 'date2','date3','date4', 'select1','select2','radio_list'], 'required'],
            // email has to be a valid email address
           // ['email', 'email'],
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
            'verifyCode' => 'Verification Code',
            'date2' =>'',
            'text1' => '',
            'text2' => '',
            'radio_list' => '',
            'select1' =>'',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */

}
