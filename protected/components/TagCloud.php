<?php

Yii::import('zii.widgets.CPortlet');

class TagCloud extends CWidget
{
	public $title='Tags';
	public $maxTags=20;

	public $tagName='';
	/**
	 * @var string the CSS class for the decoration container tag. Defaults to 'portlet-decoration'.
	 */
	public $decorationCssClass='';
	/**
	 * @var string the CSS class for the portlet title tag. Defaults to 'portlet-title'.
	 */
	public $titleCssClass='';
	/**
	 * @var string the CSS class for the content container tag. Defaults to 'portlet-content'.
	 */
	public $contentCssClass='well';
	/**
	 * @var boolean whether to hide the portlet when the body content is empty. Defaults to true.
	 * @since 1.1.4
	 */
	public $hideOnEmpty=true;

	private $_openTag;

	/**
	 * Initializes the widget.
	 * This renders the open tags needed by the portlet.
	 * It also renders the decoration, if any.
	 */
	public function init()
	{
		ob_start();
		ob_implicit_flush(false);

		echo "<div class=\"{$this->contentCssClass}\" style=\"padding: 8px\">\n";

		$this->_openTag=ob_get_contents();
		ob_clean();
	}

	/**
	 * Renders the content of the portlet.
	 */
	public function run()
	{
		$this->renderContent();
		$content=ob_get_clean();
		if($this->hideOnEmpty && trim($content)==='')
			return;
		echo $this->_openTag;
		echo $content;
		echo "</div>\n";
		echo CHtml::closeTag($this->tagName);
	}

	protected function renderContent()
	{
		$tags=Tag::model()->findTagWeights($this->maxTags);

		$menu = array();
		array_push($menu, array('label'=>$this->title));

		foreach($tags as $tag=>$weight)
		{
			$link=CHtml::link(CHtml::encode($tag), array('shop/taglist','tag'=>$tag));

			array_push($menu, array('label'=>CHtml::encode($tag).' ('.$weight.')', 'url'=>array('shop/taglist','tag'=>$tag)));
			/*echo CHtml::tag('li', array(
				'style'=>"font-size:{$weight}pt",
			), $link)."\n";*/
		}

		$this->widget('bootstrap.widgets.TbMenu', array(
		    'type'=>'list',
		    'items'=>$menu,
		));
	}
}