<?php

/**
 * @copyright Copyright &copy; Orcsis, orcsis.com.ve, 2014
 * @package yii2-orcsis
 * @version 1.0.0
 */

namespace orcsis\widgets;

use Yii;

/**
 * Extend \yii\widgets\DetailView for Osusuarios Model
 */
class DetailView extends \yii\widgets\DetailView
{
	/**
     * Detail View Modes
     */
    const MODE_VIEW = 'view';
    const MODE_EDIT = 'edit';
    
	/**
	 * @var string The mode for DetailView when its initialized
	 */
	public $mode = self::MODE_VIEW;
	
	/**
     * Renders the main detail view widget
     *
     * @return string the detail view content
     */
    /*protected function renderDetailView()
    {
        $rows = [];
        $i = 0;
        foreach ($this->attributes as $attribute) {
            $rows[] = $this->renderAttribute($attribute, $i++);
        }
        $tag = ArrayHelper::remove($this->options, 'tag', 'table');
        $output = Html::tag($tag, implode("\n", $rows), $this->options);
        return ($this->bootstrap && $this->responsive) ?
            '<div class="table-responsive">' . $output . '</div>' :
            $output;
    }*/
}