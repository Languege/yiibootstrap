<?php
namespace common\model;

class AdminAction extends BaseModel{
	const TYPE_MENU = 1;
	public static function getAdminMenus(){
		$menus = self::find()->select('a2.*, a1.type first_type, a1.action_id first_action_id, a1.sign first_type, a1.name first_name, a1.auth_name first_auth_name, a1.action_order first_action_order, a1.url first_url')->from(self::tableName().' a2')
				->leftJoin(self::tableName().' a1', 'a1.action_id=a2.pid')
				->where(['a2.type'=>self::TYPE_MENU])->asArray()->all();
		$return = array();
		foreach ($menus as $k => $v) {
			if($v['pid'] > 0){
				$return[$v['first_action_id']]['child_actions'][] = $v;
			}else{
				$return[$v['action_id']] = $v;
			}
		}

		return $return;
	}
}