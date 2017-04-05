<?php
namespace common\tools;

use yii\base\Component;
/**
* 
*/
class MenuTool extends Component
{
	
	public function isSubUrl($menuArray, $route){

	    if (isset($menuArray) && is_array($menuArray)) {

	        if (isset($menuArray['items'])) {
	            foreach ($menuArray['items'] as $item){
	                if (self::isSubUrl($item, $route)) {
	                    return true;
	                }
	            }
	        } else {
	            $url = is_array($menuArray['url']) ? $menuArray['url'][0] : $menuArray['url'];
	            if (strpos($url, $route)) {
	                return true;
	            }
	        }
	    } else {
	        $url = is_array($menuArray['url']) ? $menuArray['url'][0] : $menuArray['url'];
	        if (strpos($url, $route)) {
	            return true;
	        }
	    }
	    return false;

	}

	public function isSubMenu($menuArray, $controllerName){
	    if (isset($menuArray) && is_array($menuArray)) {
	        if (isset($menuArray['items'])) {
	            foreach ($menuArray['items'] as $item){
	                if (self::isSubMenu($item, $controllerName)) {
	                    return true;
	                }
	            }
	        } else {
	            $url = is_array($menuArray['url']) ? $menuArray['url'][0] : $menuArray['url'];
	            if (strpos($url, $controllerName.'/')) {
	                return true;
	            }
	        }
	    } else {
	        $url = is_array($menuArray['url']) ? $menuArray['url'][0] : $menuArray['url'];
	        if (strpos($url, $controllerName.'/')) {
	            return true;
	        }
	    }
	    return false;
	}



	public function initMenu($menuArray, $controllerName, $isSubUrl, $isShowIcon=false){
		if (isset($menuArray) && is_array($menuArray)) {

		    $url = is_array($menuArray['url']) ? $menuArray['url'][0] : $menuArray['url'];

		    if (empty($isSubUrl)) {
		        $isSubMenu = isSubMenu($menuArray, $controllerName);
		    } else {
		        $route = Yii::$app->controller->getRoute();
		        $isSubMenu = self::isSubUrl($menuArray, $route);
		    }
		    if ($isSubMenu) {
		        $class = ' active ';
		    } else {
		        $class = '';
		    }

		    if (isset($menuArray['items'])) {
		        echo '<li class="sub-menu">';
		    } else {
		        echo '<li class="'.$class.'">';
		    }
		    $url = $url == '#' ? 'javascript:;' : Url::toRoute($url);
		    echo '<a href="'.$url.'"  class="'.$class.'">'.($isShowIcon ? '<i class="fa fa-sitemap"></i>' : '').'<span>'.$menuArray['label'].'</span></a>';

		    if (isset($menuArray['items'])) {
		        echo '<ul class="sub">';
		        foreach ($menuArray['items'] as $item)
		        {
		            echo self::initMenu($item, $controllerName, $isSubUrl);
		        }
		        echo '</ul>';
			}
			echo '</li>';
		}
	}

    public function createLeftMenu($menuRows = array(), $controllerName, $route){
        if(isset($menuRows)){
            $isSubUrl = false;
            foreach($menuRows as $menuRow){
                $isSubUrl = self::isSubUrl($menuRow, $route);
                if ($isSubUrl) {
                    break;
                }
            }
            foreach($menuRows as $menuRow){
                self::initMenu($menuRow, $controllerName, $isSubUrl, true);
            }
        }
    }
}