<?php
namespace orcsis\components;

use Yii;
use yii\di\Instance;
use yii\web\User;

class EmpresaControl extends \yii\base\ActionFilter
{

	/**
	 * 
	 * */
	public $user = 'user';

	/**
	 * 
	 * */
	public function init()
    {
        parent::init();
        $this->user = Instance::ensure($this->user, User::className());
    }

	/**
	 * 
	 * */
	public function beforeAction($action)
	{
		if($action->id == 'sel-empresa' && Yii::$app->request->isPost)
		{
			Yii::trace('Esta devolviendo en Post');
			return true;
		}
		$user = $this->user;
		if(!isset($user->identity->osempresa->permissionName) || !$user->can($user->identity->osempresa->permissionName) || !$user->identity->osempresa->emp_estado || $action->id == 'sel-empresa' )
		{
			$osusuario = Yii::$app->user->getidentity();
            $osusuario->setEmpresa(null);
            $osusuario->save();
			return $this->selEmpresa($action);
		}

		return true;
	}

	    /**
     * @inheritdoc
     */
    public function selEmpresa($action)
    {
        $empresas = \common\models\Osempresas::getEmpresas();

        if(count($empresas) < 1)
        {
            Yii::$app->session->setFlash('danger',Yii::t('app','No access to companies or not created'));
            Yii::$app->session->removeFlash('SelEmpresa');
            return $action->controller->goHome();
        }

        if(count($empresas) == 1)
        {
            $user = Yii::$app->user->getidentity();
            $user->setEmpresa(key($empresas));
            $user->save();
            Yii::$app->session->removeFlash('SelEmpresa');
            Yii::$app->session->setFlash('warning',Yii::t('app','Only one company found'));
            return true;
        }
        Yii::$app->session->setFlash('SelEmpresa',true);
        //return Yii::$app->getResponse()->redirect('site/sel-empresa');
        return $action->controller->goHome();
    }
}