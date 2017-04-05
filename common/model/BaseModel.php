<?php
namespace common\model;

use yii\base\Model;

/**
 * 基础类，会被其他应用的baseModel包含  所有model全局控制的东西写在这儿
 * 其他东西不要写在这儿
 */
class BaseModel extends Model
{
    private $models = [];

    function  __construct(){
        
    }

    static public function __callStatic($name,$param){
        $call_class = 	explode('\\',get_called_class());
        $myClass   	=   array_pop($call_class);
    	$method		=	'\common\models\\'. $myClass.'::'.$name;
    	return call_user_func_array($method,$param);
    }



    public function __call($name,$param){
        $call_class =   explode('\\',get_called_class());
        $myClass    =   array_pop($call_class);
        $class      =   '\common\models\\'. $myClass;
        if(empty($this->models[$myClass])){
            $this->models[$myClass] = new $class();
        }
        $flag =  call_user_func_array(array($this->models[$myClass],$name),$param);
        return $flag;
    }




    public function __get($property_name)
    {
        if(isset($this->$property_name))
        {
            return($this->$property_name);
        }else
        {
            $call_class =   explode('\\',get_called_class());
            $myClass    =   array_pop($call_class);
            return $this->models[$myClass]->$property_name;
        }
    }


    public function __set($property_name, $value)
    {
        $call_class =   explode('\\',get_called_class());
        $myClass    =   array_pop($call_class);
        if(empty($this->models[$myClass])){
            $class     =   '\common\models\\'. $myClass;
            $this->models[$myClass] = new $class();
        }
        $this->models[$myClass]->$property_name = $value;
    }

}
