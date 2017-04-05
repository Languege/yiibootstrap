<?php
namespace frontend\controllers;

use Yii;
use common\rules as cr;

class RbacController extends BaseController{

	public function actionIndex(){
		$auth = Yii::$app->authManager;
		//add "createPost" Permission
		$createPost = $auth->createPermission('createPost');
		$createPost->description = 'Create a post';
		$auth->add($createPost);

		//add "updatePost" Permission
		$updatePost = $auth->createPermission('updatePost');
		$updatePost->description = 'update a post';
		$auth->add($updatePost);

		//add "author" Role
		$author = $auth->createRole('author');
		$auth->add($author);
		$auth->addChild($author, $createPost);

		//add "admin" Role
		$admin = $auth->createRole('admin');
		$auth->add($admin);
		$auth->addChild($admin, $updatePost);
		$auth->addChild($admin, $author);
	}
	
	public function actionAddrule(){
		$auth = Yii::$app->authManager;
		/*$rule = new cr\AuthorRule();
		$auth->add($rule);

		//add "updateOwnPost" Permission
		$updateOwnPost = $auth->createPermission('updateOwnPost');
		$updateOwnPost->description = 'update own a post';
		$updateOwnPost->ruleName = $rule->name;
		$auth->add($updateOwnPost);*/

		$updatePost = $auth->getPermission('updatePost');
		$updateOwnPost = $auth->getPermission('updateOwnPost');
		$auth->addChild($updateOwnPost, $updatePost);

		$author = $auth->getRole('author');
		$auth->addChild($author, $updateOwnPost);

	}

	public function actionAssignrole(){
		$auth = Yii::$app->authManager;
		$author = $auth->getRole('author');
		$auth->assign($author, Yii::$app->user->getId());
		echo "SUCCESS";exit;
	}

	public function actionCreatepost(){
		if(Yii::$app->user->can('createPost')){
			echo "has Permission";exit;
		}else{
			echo "no Permission";exit;
		}
	}

	public function actionUserpermission(){
		$auth = Yii::$app->authManager;
		$pemissions = $auth->getPermissionsByUser(Yii::$app->user->getId());
		$result = array();
		foreach ($pemissions as $key => $value) {
			$v = is_object($vlaue) ? get_object_vars($value) : $v;
			$result[] = $v;
		}
		print_r($result);exit;
	}
}