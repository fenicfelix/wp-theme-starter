<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Ajax;

/**
 * Class JNews Website Fragment
 */
Class FirstLoadAction
{
    public function build_response($action) {
        $response = apply_filters('jnews_do_first_load_action', array(), $action);

        wp_send_json($response);
    }

    public function account_nonce()
    {
        return wp_create_nonce('jnews_nonce');
    }

    public function top_bar_account()
    {
        if(!is_user_logged_in()) {

            $output = "<li><a href=\"#jeg_loginform\" aria-label=\"" . esc_html__( 'Login popup button', 'jnews') . "\" class=\"jeg_popuplink\"><i class=\"fa fa-lock\"></i> " .  jnews_return_translation('Login', 'jnews', 'login') . "</a></li>";

            if(get_option( 'users_can_register' )) {
                $output .= "<li><a href=\"#jeg_registerform\" aria-label=\"Register popup button\" class=\"jeg_popuplink\"><i class=\"fa fa-user\"></i> " . jnews_return_translation('Register', 'jnews', 'register') . "</a></li>";
            }

        } else {
	        $current_user = wp_get_current_user();
	        $endpoint = \JNews\AccountPage::getInstance()->get_endpoint();
	        $account_url = apply_filters('jnews_top_bar_account_url', esc_url( jnews_home_url_multilang($endpoint['account']['slug']) ) );

            $output =
                "<li>
                    <a href=\"" . $account_url . "\" class=\"logged\">
                        " . get_avatar( $current_user->ID, '22', '', $current_user->display_name, array( 'class' => 'img-rounded' ) ) . jeg_get_author_name( $current_user->ID ) . "
                    </a>                    
                    " . $this->dropdown() . "
                </li>";
        }

        return $output;
    }

    public function mobile_account()
    {
        $cartoutput = "";

        if(function_exists('is_woocommerce')) {
            $cartoutput = "<li class=\"cart\"><a aria-label=\"Shop cart button\" href=\"" . wc_get_cart_url() . "\"><i class=\"fa fa-shopping-cart\"></i> " . jnews_return_translation('Cart', 'jnews', 'cart') . "</a></li>";
        }

        if(!is_user_logged_in()) {

            $registeroutput = "";

            if(get_option( 'users_can_register' )) {
                $registeroutput = "<li><a href=\"#jeg_registerform\" aria-label=\"Register popup button\" class=\"jeg_popuplink\"><i class=\"fa fa-user\"></i> " . jnews_return_translation('Sign Up', 'jnews', 'sign_up') . "</a></li>";
            }

            $output =
                "<ul class=\"jeg_accountlink\">
                    <li><a href=\"#jeg_loginform\" aria-label=\"" . esc_html__( 'Login popup button', 'jnews') . "\" class=\"jeg_popuplink\"><i class=\"fa fa-lock\"></i> " .  jnews_return_translation('Login', 'jnews', 'login') . "</a></li>
                    {$registeroutput}
                    {$cartoutput}
                </ul>";

        } else {

            $current_user = wp_get_current_user();
	        $endpoint = \JNews\AccountPage::getInstance()->get_endpoint();
            $account_url = apply_filters('jnews_mobile_account_url', esc_url( jnews_home_url_multilang('/' . $endpoint['account']['slug']) ) );

            $output =
                "<div class=\"profile_box\">
                    <a href=\"{$account_url}\" class=\"profile_img\">" . get_avatar( $current_user->ID, 55 ) . "</a>
                    <h3><a href=\"{$account_url}\" class=\"profile_name\">" . esc_html(get_the_author_meta('display_name', get_current_user_id())) . "</a></h3>
                    <ul class=\"profile_links\">
                        <li><a href=\"{$account_url}\"><i class=\"fa fa-user\"></i> " . jnews_return_translation('Account', 'jnews', 'account') . "</a></li>
                        {$cartoutput}
                        <li><a href=\"" . esc_url(wp_logout_url()) . "\" class=\"logout\"><i class=\"fa fa-sign-out\"></i> " . jnews_return_translation('Logout', 'jnews', 'logout') . "</a></li>
                    </ul>
                </div>";

        }

        return apply_filters( 'jnews_mobile_account_element', $output ) ;
    }

    public function dropdown()
    {
        $dropdown_html = '';
        $dropdown = array();

        if(function_exists('is_woocommerce'))
        {
            $dropdown['order'] = array(
                'text' => jnews_return_translation('Order List', 'jnews', 'order_list'),
                'url' => wc_get_account_endpoint_url('orders')
            );

            $dropdown['edit-account'] = array(
                'text' => jnews_return_translation('Edit Account', 'jnews', 'edit_profile'),
                'url' => wc_get_account_endpoint_url('edit-account')
            );
        }

        $dropdown['logout'] = array(
            'text' => jnews_return_translation('Logout', 'jnews', 'logout'),
            'url' => wp_logout_url()
        );

        $dropdown = apply_filters('jnews_dropdown_link', $dropdown);

        foreach($dropdown as $key => $value)
        {
            $dropdown_html .= "<li><a href=\"{$value['url']}\" class=\"{$key}\">{$value['text']}</a></li>";
        }

        return "<ul>" . $dropdown_html . "</ul>";
    }

    public function social_login()
    {
        $output = "<h3>" . jnews_return_translation('Welcome Back!', 'jnews', 'welcome_back') . "</h3>";
        return defined('JNEWS_SOCIAL_LOGIN') ? $output .= apply_filters( 'jnews_social_login', '', 'login' ) : $output;
    }

    public function social_register()
    {
        $output = "<h3>" . jnews_return_translation('Create New Account!', 'jnews', 'create_new_account') . "</h3>";
        return defined('JNEWS_SOCIAL_LOGIN') ? $output .= apply_filters( 'jnews_social_login', '', 'register' ) : $output;
    }
}