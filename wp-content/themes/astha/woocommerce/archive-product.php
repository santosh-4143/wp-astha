<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header('shop');
?>


<?php
/**
 * woocommerce_before_main_content hook.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 */
do_action('woocommerce_before_main_content');
?>
<?php if (is_product_category('services')) { ?>
    <div class="banner_area">
        <div class="about_banner"> <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/contact/banner.jpg" alt="pic" class="img-responsive"/> </div>
    </div>
<?php } else { ?>
    <div class="banner_area">
        <div class="about_banner"> <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/contact/instrument.jpg" alt="pic" class="img-responsive"/> </div>
    </div>
<?php } ?>

<div class="category_wrapper">
    <div class="container"> 
        <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
            <div class="instrumen_details">
                <h3 class="page-title"><?php woocommerce_page_title(); ?></h3>
                <h6></h6>
            </div>

        <?php endif; ?>

        <?php
        /**
         * woocommerce_archive_description hook.
         *
         * @hooked woocommerce_taxonomy_archive_description - 10
         * @hooked woocommerce_product_archive_description - 10
         */
        do_action('woocommerce_archive_description');
        ?>

        <?php if (have_posts()) : ?>
            <div class="col-lg-3 col-sm-3 less_lt">
                <div class="category_wrap">
                    <div class="category_box">
                        <div class="jquery-accordion-menu" id="jquery-accordion-menu">
                            <ul>
                                <?php
                                $args = array(
                                    'number' => $number,
                                    'hide_empty' => $hide_empty,
                                    'include' => $ids,
                                    'hierarchical' => true,
                                    'parent' => '0'
                                );
                                $product_categories = get_terms('product_cat', $args);

                                $arr = explode("/", $_SERVER['REQUEST_URI']);

                                if (in_array("instruments", $arr)) {
                                    $parent_id = 6;
                                }
                                if (in_array("services", $arr)) {
                                    $parent_id = 7;
                                }
                                foreach ($product_categories as $cat) {
                                    if ($cat->term_id == $parent_id) {
                                        $args2 = array(
                                            'number' => $number,
                                            'hide_empty' => $hide_empty,
                                            'include' => $ids,
                                            'parent' => $cat->term_id,
                                            'hierarchical' => true
                                        );
                                        $sub_categories = get_terms('product_cat', $args2);
                                        ?>                               
                                        <li>                                    
                                            <!--<a href="javascript:void();" class=""><?php // echo $cat->name;  ?> <span class="submenu-indicator">+</span></a>-->
                                            <ul class="submenu" style="display: block;">
                                                <?php
                                                if (is_array($sub_categories) && count($sub_categories) > 0) {

                                                    foreach ($sub_categories as $subcat) {

                                                        $args3 = array(
                                                            'number' => $number,
                                                            'hide_empty' => $hide_empty,
                                                            'include' => $ids,
                                                            'parent' => $subcat->term_id,
                                                            'hierarchical' => true
                                                        );
                                                        $sub_categories_nexts = get_terms('product_cat', $args3);
                                                        ?>
                                                        <li> 
                                                            <?php if (count($sub_categories_nexts) != 0) { ?>
                                                                <a href="javascript:void();" class=""> <?php echo $subcat->name; ?> <span class="submenu-indicator">+</span></a>
                                                            <?php } else { ?>
                                                                <a href="<?php echo get_term_link($subcat); ?>"><?php echo $subcat->name; ?></a>
                                                            <?php } ?>
                                                            <?php if (count($sub_categories_nexts) != 0) { ?>
                                                                <ul class="submenu" style="display: none;">
                                                                    <?php
                                                                    if (is_array($sub_categories_nexts) && count($sub_categories_nexts) > 0) {
                                                                        foreach ($sub_categories_nexts as $sub_categories_next) {
                                                                            ?>
                                                                            <li> 
                                                                                <a href="<?php echo get_term_link($sub_categories_next); ?>"><?php echo $sub_categories_next->name; ?></a> 
                                                                            </li>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </ul>
                                                            <?php } ?>
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </li>            
                                    <?php
                                    }
                                }
                                ?>



                            </ul>


                        </div>
                    </div>
                </div>

            </div>


            <?php
            /**
             * woocommerce_before_shop_loop hook.
             *
             * @hooked woocommerce_result_count - 20
             * @hooked woocommerce_catalog_ordering - 30
             */
            do_action('woocommerce_before_shop_loop');
            ?>

            <?php woocommerce_product_loop_start(); ?>

            <?php woocommerce_product_subcategories(); ?>

            <?php while (have_posts()) : the_post(); ?>

                <?php wc_get_template_part('content', 'product'); ?>

            <?php endwhile; // end of the loop.  ?>

            <?php woocommerce_product_loop_end(); ?>

            <?php
            /**
             * woocommerce_after_shop_loop hook.
             *
             * @hooked woocommerce_pagination - 10
             */
            do_action('woocommerce_after_shop_loop');
            ?>

        <?php elseif (!woocommerce_product_subcategories(array('before' => woocommerce_product_loop_start(false), 'after' => woocommerce_product_loop_end(false)))) : ?>

            <?php wc_get_template('loop/no-products-found.php'); ?>

        <?php endif; ?>

        <?php
        /**
         * woocommerce_after_main_content hook.
         *
         * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
         */
        do_action('woocommerce_after_main_content');
        ?>

        <?php
        /**
         * woocommerce_sidebar hook.
         *
         * @hooked woocommerce_get_sidebar - 10
         */
        do_action('woocommerce_sidebar');
        ?>

        <?php get_footer('shop'); ?>
