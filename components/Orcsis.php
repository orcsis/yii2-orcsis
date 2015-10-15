<?php
/**
*
*
**/

namespace orcsis\components;

use Yii;
use yii\base\Component;
use \yii\helpers\ArrayHelper;

class Orcsis extends Component {
	/**
	 * 
	 * */
	public $OpcTabModelClass;

	/**
	 * 
	 * */
	public $ConfEmpModelClass = 'common\models\empresa\Osconfemp';

	/**
	 * 
	 * */
	public function init()
	{
		if ($this->OpcTabModelClass === null) {
            throw new InvalidConfigException('Orcsis::OpcTabModelClass must be set.');
        }
		parent::init();
	}

	/**
	 * 
	 * 
	 * */
	public function getOpcTab($tabla, $campo, $asModel = false, $opcion = null)
	{
		$model = new $this->OpcTabModelClass();
		if($asModel)
		{
			return $model->find()->where(['opt_tabla'=>$tabla, 'opt_campo'=>$campo, 'opt_opcion' => $opcion])->one();
		}
		$opciones = $model->find()->select(['opt_opcion','opt_descri'])->where(['opt_tabla'=>$tabla, 'opt_campo'=>$campo])->asArray()->all();
		return ArrayHelper::map($opciones,'opt_opcion', 'opt_descri');
	}

	/**
	 * 
	 * */
	public function Convert($data, $type = 'string')
	{
		$value = $data;
		switch ($type) {
			case 'int':
				$value = (int)$value;
				break;

			case 'integer':
				$value = (int)$value;
				break;

			case 'float':
				$value = (float)$value;
				break;

			case 'decimal':
				$value = (float)$value;
				break;

			case 'array':
				$value = json_decode($value);
				break;

			case 'json':
				$value = json_encode($value);
				break;

			case 'bool':
				$value = (int)$value == 1 ? true : false;
				break;
			
			default:
				$value = (string)$value;
				break;
		}
		return $value;
	}

	/**
	 * 
	 * */
	public function getEmpVar($var)
	{
		$var = strtoupper($var);
		$model = new $this->ConfEmpModelClass();
		$osconfemp = $model->find()->where(['coe_nombre' => $var])->one();
		if(!$osconfemp)
		{
			return null;
		}
		$osopctab = $this->getOpcTab($osconfemp->tableName(), 'coe_tipo', true, $osconfemp->coe_tipo);
		return $this->Convert($osconfemp->coe_data, $osopctab->opt_dato);
	}

	/**
	 * @inheritdoc
	 */
	public function getEmpVarLabel($var)
	{
		$var = strtoupper($var);
		$model = new $this->ConfEmpModelClass();
		$osconfemp = $model->find()->where(['coe_nombre' => $var])->one();
		if(!$osconfemp)
		{
			return null;
		}

		return trim($osconfemp->coe_descri);
	}
}
?>