<?php
namespace yii2lab\extension\widget;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Class Menu
 * @package backend\components\widget
 */
class Menu extends \yii\widgets\Menu
{
	/**
	 * @var string
	 */
	public $linkTemplate = "<a href=\"{url}\">\n{icon}\n{label}\n{right-icon}\n{badge}</a>";
	/**
	 * @var string
	 */
	public $labelTemplate = "{icon}\n{label}\n{badge}";

	/**
	 * @var string
	 */
	public $badgeTag = 'span';
	/**
	 * @var string
	 */
	public $badgeClass = 'badge pull-right';
	/**
	 * @var string
	 */
	public $badgeType = 'default';

	/**
	 * @var string
	 */
	public $parentRightIcon = '<i class="fa fa-angle-left pull-right"></i>';

	/**
	 * @inheritdoc
	 */
	protected function renderItem($item)
	{
		$item['badgeOptions'] = isset($item['badgeOptions']) ? $item['badgeOptions'] : [];

		if (!ArrayHelper::getValue($item, 'badgeOptions.class')) {
			$bg = isset($item['badgeType']) ? 'badge-' . $item['badgeType'] : 'badge-' . $this->badgeType;
			$item['badgeOptions']['class'] = $this->badgeClass.' '.$bg;
		}

		if (isset($item['items']) && !isset($item['right-icon'])) {
			$item['right-icon'] = $this->parentRightIcon;
		}

		if (isset($item['url'])) {
			$template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);

			return strtr($template, [
				'{badge}'=> isset($item['badge'])
					? Html::tag('small', $item['badge'], $item['badgeOptions'])
					: '',
				'{icon}'=>isset($item['icon']) ? $item['icon'] : '',
				'{right-icon}'=>isset($item['right-icon']) ? $item['right-icon'] : '',
				'{url}' => Url::to($item['url']),
				'{label}' => $item['label'],
			]);
		} else {
			$template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);

			return strtr($template, [
				'{badge}'=> isset($item['badge'])
					? Html::tag('small', $item['badge'], $item['badgeOptions'])
					: '',
				'{icon}'=>isset($item['icon']) ? $item['icon'] : '',
				'{right-icon}'=>isset($item['right-icon']) ? $item['right-icon'] : '',
				'{label}' => $item['label'],
			]);
		}
	}
}
