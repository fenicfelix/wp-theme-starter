<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Module\Hero;

Class Hero_6_Option extends HeroOptionAbstract
{
    protected $number_post = 4;
	protected $second_thumbnail = true;


    public function get_module_name()
    {
        return esc_html__('JNews - Hero 6', 'jnews');
    }
}