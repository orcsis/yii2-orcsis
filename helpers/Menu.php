<?php

namespace orcsis\helpers;

use Yii;
use kartik\icons\Icon;

/*
 * Clase para generar o formatear Menús en el sistema Orcsis
 * @author Oliver C.
 */
class Menu
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
		$data = eval('return '.$menu['men_data'].';');
		if (!empty($menu['men_url'])) {
			$url = [];
			$r = explode('&', $menu['men_url']);
			$url[0] = $r[0];
			unset($r[0]);
			foreach ($r as $part) {
				$part = explode('=', $part);
				$url[$part[0]] = isset($part[1]) ? $part[1] : '';
			}
		} else {
			$url = '#';
		}
		$menuItem = [
			'label' => ($data['enableLabel'] ? $menu['men_nombre'] : ''),
			'url' => $url,
			
		];
		if(isset($data['options']) && !empty($data['options'])){
			$menuItem[] = ['options'];
			$menuItem['options'] =  $data['options'];
		}
		if(isset($data['linkOptions']) && !empty($data['linkOptions'])){
			$menuItem[] = ['linkOptions'];
			$menuItem['linkOptions'] =  $data['linkOptions'];
		}
		if(isset($data['icon']) && !empty($data['icon'])){
			$menuItem['label'] = Icon::show($data['icon'],(isset($data['iconClass']) &&
					!empty($data['iconClass'])?['class'=>$data['iconClass']]:'')) .
					$menuItem['label'];
		}
	 	if ($menu['children'] != []) {
	 		$menuItem['items'] = $menu['children'];
	 	}
		return $menuItem;
	}
	
	/*
	 * Retorna los items del menú de usuario
	 * @return Array Arreglo con el menú de usuario
	 */
	public static function getUserMenu()
	{
		$userItems = [];
		if (Yii::$app->user->isGuest) {
				$userItems[]=['label' => Icon::show('sign-in',['class'=>'fa-fw']).Yii::t('app','Login'), 'url' => ['/site/login']];
			} else {
				$userItems[]=[
                    'label' => Icon::show('sign-out',['class'=>'fa-fw']).Yii::t('app','Logout'),
                    'url' => ['/site/logout'],
					'linkOptions' => ['data-method' => 'post'],
                ];
		}
		return $userItems;
	}
	
}