<?php

/**
 * @copyright Copyright &copy; Orcsis, orcsis.com.ve, 2014
 * @package yii2-orcsis
 * @version 1.0.0
 */

namespace orcsis\widgets;

use Yii;

/**
 * Extend \yii\widgets\DetailView for aditional buttons panel
 */
class DetailView extends \kartik\detail\DetailView
{
	/**
	 * @var array Aditional Buttons for panel
	 * `[
	 * 	  'options => 'HTML Options',
	 *    'label' => 'text or HTML Label',
	 *    'title' => 'title of button (Not displayed)'
	 * `
	 */
	public $buttons = [];
	
	/**
     * @var string the buttons to show when in view mode. The following tags will be replaced:
     * - `{view}`: the view button
     * - `{update}`: the update button
     * - `{delete}`: the delete button
     * - `{save}`: the save button
     * Defaults to `{edit} {delete}`.
     */
    public $buttons1 = '{tools} {update} {delete}';
	
	/**
     * Renders the buttons for a specific mode
     *
     * @param integer $mode
     * @return string the buttons content
     */
    protected function renderButtons($mode = 1)
    {
        $buttons = "buttons{$mode}";
        $ret =  strtr($this->$buttons, [
            '{view}' => $this->renderButton('view'),
            '{update}' => $this->renderButton('update'),
            '{delete}' => $this->renderButton('delete'),
            '{save}' => $this->renderButton('save'),
            '{reset}' => $this->renderButton('reset'),
        	'{tools}' => $this->renderTools()
        ]);
        //var_dump(json_encode($ret));
        return $ret;
    }
    
    /**
     * Renders aditional buttons
     * @return string
     */
    protected function renderTools()
    {
    	if(!isset($this->buttons) || count($this->buttons)<1)
    	{
    		return '';
    	}
    	$buttons = '';
    	foreach ($this->buttons as $key => $value)
    	{
    		$options = isset($value['options']) ? $value['options'] : [];
    		$label = isset($value['label']) ? $value['label'] : '';
    		$title = isset($value['title']) ? $value['title'] : '';
    		//$buttons .= ' ' . $this->getDefaultButton('tools',$label,$title,$options);
            $buttons .= isset($value['html']) ? $value['html'] : $this->getDefaultButton('tools',$label,$title,$options);
    	}
    	return $buttons;
    }
}