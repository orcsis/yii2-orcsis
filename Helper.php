<?php

namespace orcsis\helper;

use Yii;
use kartik\icons\Icon;

/*
 * Clase para ayudar algunos procesos o formatos en el sistema Orcsis
 * @author Oliver C.
 */
class Helper
{
	/*
	 * Callback para ser utilizado con el modulo admin
	 * @return Array Arreglo con el Menú
	 * 
	 * [
     *	'options' => [],
     *  'enableLabel' => false,
     *  'linkOptions' => [],
     *  'icon' => 'dashboard',
     *  'iconClass' => 'fa-2x'
	 * ]
	 */
	public static function menuCallBack($menu)
	{
		$data = eval($menu['men_data']);
		$menuItem = [
			'label' => ($data['enableLabel'] ? $menu['men_nombre'] : ''),
			'url' => (empty($menu['men_url']) ? '#' : [$menu['men_url']]),
			
		];
		if(isset($menu['options']) && !empty($menu['options'])){
			$menuItem[] = ['options'];
			$menuItem['options'] =  $menu['options'];
		}
		if(isset($menu['linkOptions']) && !empty($menu['linkOptions'])){
			$menuItem[] = ['linkOptions'];
			$menuItem['linkOptions'] =  $menu['linkOptions'];
		}
		if(isset($menu['icon']) && !empty($menu['icon'])){
			$menuItem['label'] = Icon::show($menu['icon'],(isset($menu['iconClass']) &&
					!empty($menu['iconClass'])?['class'=>$menu['iconClass']]:null)) .
					$menuItem['label'];
		}
	 	if ($menu['children'] != []) {
	 		$menuItem['items'] = $menu['children'];
	 	}
		return $menuItem;
	}
}