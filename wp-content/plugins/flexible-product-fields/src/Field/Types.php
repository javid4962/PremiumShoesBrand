<?php

namespace WPDesk\FPF\Free\Field;

use WPDesk\FPF\Free\Field\Type\CheckboxType;
use WPDesk\FPF\Free\Field\Type\ColorType;
use WPDesk\FPF\Free\Field\Type\DateType;
use WPDesk\FPF\Free\Field\Type\EmailType;
use WPDesk\FPF\Free\Field\Type\FileType;
use WPDesk\FPF\Free\Field\Type\HeadingType;
use WPDesk\FPF\Free\Field\Type\HtmlType;
use WPDesk\FPF\Free\Field\Type\ImageType;
use WPDesk\FPF\Free\Field\Type\MultiCheckboxType;
use WPDesk\FPF\Free\Field\Type\MultiselectType;
use WPDesk\FPF\Free\Field\Type\NumberType;
use WPDesk\FPF\Free\Field\Type\ParagraphType;
use WPDesk\FPF\Free\Field\Type\RadioColorsType;
use WPDesk\FPF\Free\Field\Type\RadioImagesType;
use WPDesk\FPF\Free\Field\Type\RadioType;
use WPDesk\FPF\Free\Field\Type\SelectType;
use WPDesk\FPF\Free\Field\Type\TextareaType;
use WPDesk\FPF\Free\Field\Type\TextType;
use WPDesk\FPF\Free\Field\Type\TimeType;
use WPDesk\FPF\Free\Field\Type\TypeIntegration;
use WPDesk\FPF\Free\Field\Type\UrlType;

/**
 * Supports management of field types.
 */
class Types {

	const FIELD_GROUP_TEXT   = 'text';
	const FIELD_GROUP_OPTION = 'option';
	const FIELD_GROUP_PICKER = 'picker';
	const FIELD_GROUP_OTHER  = 'other';

	/**
	 * Initializes actions for class.
	 *
	 * @return void
	 */
	public function init() {
		( new TypeIntegration( new TextType() ) )->hooks();
		( new TypeIntegration( new TextareaType() ) )->hooks();
		( new TypeIntegration( new NumberType() ) )->hooks();
		( new TypeIntegration( new EmailType() ) )->hooks();
		( new TypeIntegration( new UrlType() ) )->hooks();
		( new TypeIntegration( new CheckboxType() ) )->hooks();
		( new TypeIntegration( new MultiCheckboxType() ) )->hooks();
		( new TypeIntegration( new SelectType() ) )->hooks();
		( new TypeIntegration( new MultiselectType() ) )->hooks();
		( new TypeIntegration( new RadioType() ) )->hooks();
		( new TypeIntegration( new RadioImagesType() ) )->hooks();
		( new TypeIntegration( new RadioColorsType() ) )->hooks();
		( new TypeIntegration( new DateType() ) )->hooks();
		( new TypeIntegration( new TimeType() ) )->hooks();
		( new TypeIntegration( new FileType() ) )->hooks();
		( new TypeIntegration( new ColorType() ) )->hooks();
		( new TypeIntegration( new HeadingType() ) )->hooks();
		( new TypeIntegration( new ParagraphType() ) )->hooks();
		( new TypeIntegration( new ImageType() ) )->hooks();
		( new TypeIntegration( new HtmlType() ) )->hooks();
	}
}
