<?php
namespace backend\controllers;

class PostController extends BaseController{

	public function actionCreate(){
		return $this->render('create');
	}
}