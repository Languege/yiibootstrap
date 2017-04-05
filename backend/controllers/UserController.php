<?php
namespace backend\controllers;

class UserController extends BaseController{

	public function actionAdd(){
		return $this->render('add');
	}
}