<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Module\Block;

Class Block_3_View extends BlockViewAbstract
{
    public function render_block_type_1($post, $image_size)
    {
        $is_feed = jnews_get_rss_post_id($post->ID);
        $thumbnail = $is_feed ? $post->get_thumbnail($image_size) : $this->get_thumbnail($post->ID, $image_size);
        $title = $is_feed ? $post->title : get_the_title($post->ID);
        $permalink = $is_feed ? $post->permalink : get_the_permalink($post->ID);
        $edit = $is_feed ? '' : jnews_edit_post( $post->ID );
        $excerpt = $is_feed ? $post->description : $this->get_excerpt($post);

        $output =
            "<article " . jnews_post_class("jeg_post jeg_pl_md_2", $post->ID) . ">
                <div class=\"jeg_thumb\">
                    " . $edit . "
                    <a href=\"" . $permalink . "\" aria-label=\"" . esc_html__( 'Read article: ', 'jnews' ) . get_the_title( $post ) . "\">" . $thumbnail . "</a>
                </div>
                <div class=\"jeg_postblock_content\">
                    <h3 class=\"jeg_post_title\">
                        <a href=\"" . $permalink . "\">" . $title . "</a>
                    </h3>
                    " . $this->post_meta_1($post, false, $is_feed) . "
                    <div class=\"jeg_post_excerpt\">
                        <p>" . $excerpt . "</p>
                    </div>
                </div>
            </article>";

        return $output;
    }


    public function build_column_1($results)
    {
        $first_block   = '';
        $ads_position  = $this->random_ads_position(sizeof($results));

        for ( $i = 0; $i < sizeof($results); $i++ )
        {
            if ( $i == $ads_position )
            {
                $first_block .= $this->render_module_ads();
            }

            $first_block .= $this->render_block_type_1($results[$i], 'jnews-120x86');
        }

        $output =
            "<div class=\"jeg_posts jeg_load_more_flag\">
                {$first_block}
            </div>";

        return $output;
    }

    public function build_column_2($results)
    {
        $first_block  = '';
        $ads_position = $this->random_ads_position(sizeof($results));

        for ( $i = 0; $i < sizeof($results); $i++ )
        {
            if ( $i == $ads_position )
            {
                $first_block .= $this->render_module_ads();
            }

            $first_block .= $this->render_block_type_1($results[$i], 'jnews-350x250');
        }

        $output =
            "<div class=\"jeg_posts jeg_load_more_flag\">
                {$first_block}
            </div>";

        return $output;
    }

    public function build_column_1_alt($results)
    {
        $first_block   = '';
        $ads_position  = $this->random_ads_position(sizeof($results));

        for ( $i = 0; $i < sizeof($results); $i++ )
        {
            if ( $i == $ads_position )
            {
                $first_block .= $this->render_module_ads('jeg_ajax_loaded anim_' . $i);
            }

            $first_block .= $this->render_block_type_1($results[$i], 'jnews-120x86');
        }

        $output = $first_block;

        return $output;
    }

    public function build_column_2_alt($results)
    {
        $first_block   = '';
        $ads_position  = $this->random_ads_position(sizeof($results));

        for ( $i = 0; $i < sizeof($results); $i++ )
        {
            if ( $i == $ads_position )
            {
                $first_block .= $this->render_module_ads('jeg_ajax_loaded anim_' . $i);
            }

            $first_block .= $this->render_block_type_1($results[$i], 'jnews-350x250');
        }

        $output = $first_block;

        return $output;
    }

    public function render_output($attr, $column_class)
    {
	    if ( isset( $attr['results'] ) ) {
		    $results = $attr['results'];
	    } else {
		    $results = $this->build_query($attr);
	    }

        $navigation = $this->render_navigation($attr, $results['next'], $results['prev'], $results['total_page']);

        if(!empty($results['result'])) {
            $content = $this->render_column($results['result'], $column_class);
        } else {
            $content = $this->empty_content();
        }

        return
            "<div class=\"jeg_posts jeg_block_container\">
                {$this->get_content_before($attr)}
                {$content}
                {$this->get_content_after($attr)}
            </div>
            <div class=\"jeg_block_navigation\">
                {$this->get_navigation_before($attr)}
                {$navigation}
                {$this->get_navigation_after($attr)}
            </div>";
    }

    public function render_column($result, $column_class)
    {
        switch($column_class)
        {
            case "jeg_col_1o3" :
                $content = $this->build_column_1($result);
                break;
            case "jeg_col_3o3" :
            case "jeg_col_2o3" :
            default :
                $content = $this->build_column_2($result);
                break;
        }

        return $content;
    }

    public function render_column_alt($result, $column_class)
    {
        switch($column_class)
        {
            case "jeg_col_1o3" :
                $content = $this->build_column_1_alt($result);
                break;
            case "jeg_col_3o3" :
            case "jeg_col_2o3" :
            default :
                $content = $this->build_column_2_alt($result);
                break;
        }

        return $content;
    }
}
