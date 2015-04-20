<?php
namespace app\modules\example\controllers;

class ProcessController extends \callmez\wechat\components\ProcessController
{
    public function actionIndex()
    {
        return $this->responseText('example关键字回复:哈哈');
    }
}