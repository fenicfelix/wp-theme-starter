<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Module\Block;

Class Block_13_Option extends BlockOptionAbstract
{
    protected $default_number_post = 3;
    protected $show_excerpt = true;
    protected $default_ajax_post = 4;
    protected $second_thumbnail = true;

    public function get_module_name()
    {
        return esc_html__('JNews - Module 13', 'jnews');
    }

	public function set_style_option()
	{
		$this->set_boxed_option();
		parent::set_style_option();
	}
}