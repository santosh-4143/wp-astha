<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage astha
 * @since astha 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width">
	<link rel="shortcut icon" href="<?php echo esc_url(get_template_directory_uri()); ?>/images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?php echo esc_url(get_template_directory_uri()); ?>/images/favicon.ico" type="image/x-icon">	
        <title><?php wp_title(' '); ?>
            <?php
            if (wp_title(' ', false)) {

                echo ' | ';
            }
            ?> 
            <?php bloginfo('name'); ?>
        </title>
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <!-- Bootstrap -->
        <link href="<?php echo esc_url(get_template_directory_uri()); ?>/css/bootstrap.min.css" rel="stylesheet">

        <!--font-awesome-->
        <link href="<?php echo esc_url(get_template_directory_uri()); ?>/css/font-awesome.min.css" rel="stylesheet"/>
        <link href="<?php echo esc_url(get_template_directory_uri()); ?>/fonts/loto/stylesheet.css" rel="stylesheet"/>
        <link href="<?php echo esc_url(get_template_directory_uri()); ?>/fonts/oswald/stylesheet.css" rel="stylesheet"/>
        <link href="<?php echo esc_url(get_template_directory_uri()); ?>/css/font-_css/oswald.css" rel="stylesheet"/>
        <link href="<?php echo esc_url(get_template_directory_uri()); ?>/fonts/webfontkit-Muli/stylesheet.css" rel="stylesheet"/>
        <link href="<?php echo esc_url(get_template_directory_uri()); ?>/fonts/rbno-3/stylesheet.css" rel="stylesheet"/>

        <!--jquery-accordian-menu-->
        <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri()); ?>/css/jquery-accordion-menu.css">
        <!--for zoom in-->
        <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri()); ?>/css/etalage.css">

        <link href="<?php echo esc_url(get_template_directory_uri()); ?>/css/style_flexise.css" rel="stylesheet" type="text/css" />
        <!--text_animation-->
        <link href="<?php echo esc_url(get_template_directory_uri()); ?>/css/text_animation/reset.css" rel="stylesheet"/>
        <link href="<?php echo esc_url(get_template_directory_uri()); ?>/css/text_animation/style.css" rel="stylesheet"/>
        <!--end Text_animation-->

        <!--owl_carusel-->
        <link href="<?php echo esc_url(get_template_directory_uri()); ?>/css/owl_carusel/owl.carousel.css" rel="stylesheet"/>
        <link href="<?php echo esc_url(get_template_directory_uri()); ?>/css/owl_carusel/owl.theme.css" rel="stylesheet"/>

        <!--Animate-->
        <link href="<?php echo esc_url(get_template_directory_uri()); ?>/css/animate.css" rel="stylesheet"/>

        <!--sweet alert-->
        <link href="<?php echo esc_url(get_template_directory_uri()); ?>/css/sweetalert.css" rel="stylesheet"/>
        <script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/sweetalert.min.js"></script>

        <!--custom-->
        <link href="<?php echo esc_url(get_template_directory_uri()); ?>/css/custom.css" rel="stylesheet"/>
        <link href="<?php echo esc_url(get_template_directory_uri()); ?>/css/responsive.css" rel="stylesheet"/>
        <style>
            textarea.form-control {
                height: 70px;
            }
        </style>
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <div class="top_area">
            <div class="container">
                <div class="row as">
                    <div class="col_lg-3 col-md-3 col-sm-6 col-xs-12 p_1">
                        <div class="phone">
                            <h6><a href="/contact"><i class="fa fa-phone"></i> +91 8583882431</a></h6>
                        </div>
                    </div>
                    <div class="col_lg-3 col-md-3 col-sm-6 col-xs-12  p_2">
                        <div class="phone">
                            <h6><a href="#"><i class="fa fa-envelope"></i> asthamedic@gmail.com </a></h6>
                        </div>
                    </div>
                    <div class="col_lg-4 col-md-4 col-sm-6 col-xs-12  p_3">
                        <?php if (!is_user_logged_in()) { ?>
                            <div class="phone_1">
                                <h6><a href="#" data-toggle="modal" data-target="#login_modal" >Login</a> | <a href="#" data-toggle="modal" data-target="#sub_form" >Sign Up</a></h6>
                            </div>
                        <?php } else { ?>
                            <div class="phone_1">
                                <h6>
                                    <a href="/my-account" >My Account</a> | 
                                    <?php
                                    printf(__('<a href="%2$s">Log out</a>', 'woocommerce') . ' ', $current_user->display_name, wc_get_endpoint_url('customer-logout', '', wc_get_page_permalink('myaccount')));
                                    ?>
                                </h6>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col_lg-2 col-md-2 col-sm-6 col-xs-12  p_4">
                        <form role="search" method="get" action="<?php echo home_url('/'); ?>">
                        <div class="search_area">
                            <a href="#"><i class="fa fa-search s_1"></i></a>
                            <div class="search_box">
                                <input type="search" name="s" value="<?php echo get_search_query() ?>" title="<?php echo esc_attr_x('Search for:', 'label', 'woocommerce'); ?>" autocomplete="off" class="form-control s_1" size="50" placeholder="search"/>
                                <input type="hidden" name="post_type" value="product" />          
                            </div>
                        </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <header>
            <div class="container">
                <div class="row as_1">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <div class="logo_area">
                            <a href="/"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/logo/logo_2.png" alt="pic"/></a>
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-9 col-sm-9 col-xs-12">
                        <div class="logo_area_1">
                            <h3><a href="/contact">+91 8583882431</a></h3>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="main_nav">
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <nav>
                                    <ul>  
                                        <li><a href="/">Home </a></li>
                                        <?php wp_nav_menu(array('theme_location' => 'primary', 'container' => '', 'items_wrap' => '%3$s')); ?>                                    
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <?php wc_print_notices(); ?>
