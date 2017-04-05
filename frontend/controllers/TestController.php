<?php
namespace frontend\controllers;

use Yii;

class TestController extends BaseController{

	public function actionIndex(){
		Yii::$app->language = 'zh-CN';
		echo Yii::t('app','Happy'); exit;
	}
	
	public function actionBootstrap(){
		return $this->render('bootstrap');
	}
}