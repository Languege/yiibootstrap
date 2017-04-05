<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "admin_action".
 *
 * @property string $action_id
 * @property integer $type
 * @property string $sign
 * @property string $name
 * @property string $auth_name
 * @property integer $pid
 * @property integer $action_order
 * @property string $url
 */
class AdminAction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_action';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['action_id', 'type'], 'required'],
            [['action_id', 'type', 'pid', 'action_order'], 'integer'],
            [['sign', 'name', 'url'], 'string', 'max' => 100],
            [['auth_name'], 'string', 'max' => 64],
            [['auth_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'action_id' => Yii::t('app', '操作id'),
            'type' => Yii::t('app', '类型：1.菜单 2.操作'),
            'sign' => Yii::t('app', '操作标识:'),
            'name' => Yii::t('app', '操作名称'),
            'auth_name' => Yii::t('app', '权限验证,对应auth_item中的name'),
            'pid' => Yii::t('app', '父操作id'),
            'action_order' => Yii::t('app', '排序'),
            'url' => Yii::t('app', '菜单链接'),
        ];
    }
}
