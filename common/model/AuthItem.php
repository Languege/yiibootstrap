<?php
namespace common\model;
use yii\rbac\Item;
class AuthItem extends BaseModel{
	
	public function getDirectPermissionsByUserId($userId){
		/**Step 1 : 获取用户角色**/
		$assigns = AuthAssignment::find()->where(['user_id'=>$userId])->asArray()->all();
		$roles = array_column($assigns, 'item_name');
		/**Step 2: 获取用户直接许可**/
		$data = self::find()->select('i.child first_per, i2.child second_per')->from(AuthItemChild::tableName().' i')
					->leftJoin(AuthItemChild::tableName().' i2', 'i2.parent=i.child')
					->where(['in','i.parent', $roles])->asArray()->all();
		$permissions = array();
		foreach ($data as $k => $v) {
			if($v['second_per']){
				$permissions[$v['first_per']][] = $v['second_per'];
			}
		}
		var_dump($permissions);exit;
		return $permissions;
	}
}