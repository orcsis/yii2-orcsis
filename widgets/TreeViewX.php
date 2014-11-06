<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package yii2-dropdown-x
 * @version 1.0.0
 */

namespace orcsis\widgets;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * An extended dropdown menu for Bootstrap 3 - that offers
 * submenu drilldown
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class TreeViewX extends \yii\bootstrap\Widget
{
	 /**
     * @var array list of menu items in the dropdown. Each array element can be either an HTML string,
     * or an array representing a single menu with the following structure:
     *
     * - label: string, required, the label of the item link
     * - url: string, optional, the url of the item link. Defaults to "#".
     * - visible: boolean, optional, whether this menu item is visible. Defaults to true.
     * - linkOptions: array, optional, the HTML attributes of the item link.
     * - options: array, optional, the HTML attributes of the item.
     * - items: array, optional, the submenu items. The structure is the same as this property.
     *   Note that Bootstrap doesn't support dropdown submenu. You have to add your own CSS styles to support it.
     *
     * To insert divider use `<li role="presentation" class="divider"></li>`.
     */
    public $items = [];
    /**
     * @var boolean whether the labels for header items should be HTML-encoded.
     */
    public $encodeLabels = true;
    
    public $subMenuOptions = [];
    
    /**
     * Initializes the widget
     */
    public function init()
    {
        parent::init();
        Html::addCssClass($this->options, 'treeview-menu');
        //DropdownXAsset::register($this->view);
    }
    
	/**
     * Renders the widget.
     */
    public function run()
    {
        echo $this->renderItems($this->items);
    }
    
    /**
     * Renders menu items.
     * @param array $items the menu items to be rendered
     * @return string the rendering result.
     * @throws InvalidConfigException if the label option is not specified in one of the items.
     */
    protected function renderItems($items)
    {
        $lines = [];
        foreach ($items as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }
            if (is_string($item)) {
                $lines[] = $item;
                continue;
            }
            if (!isset($item['label'])) {
                throw new InvalidConfigException("The 'label' option is required.");
            }
            $label = $this->encodeLabels ? Html::encode($item['label']) : $item['label'];
            $options = ArrayHelper::getValue($item, 'options', []);
            $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
            $linkOptions['tabindex'] = '-1';
            
            if (!empty($item['items'])) {
                Html::addCssClass($linkOptions, 'dropdown-toggle');
                $linkOptions['data-toggle'] = 'dropdown';
                $content = Html::a($label, ArrayHelper::getValue($item, 'url', '#'), $linkOptions) .
                           $this->renderItems($item['items']);
                $options = ArrayHelper::merge($this->subMenuOptions, $options);
                Html::addCssClass($options, 'dropdown dropdown-submenu');
            }
            else {
                $content = Html::a($label, ArrayHelper::getValue($item, 'url', '#'), $linkOptions);
            }
            $lines[] = Html::tag('li', $content, $options);
        }
        return Html::tag('ul', implode("\n", $lines), $this->options);
    }
}
