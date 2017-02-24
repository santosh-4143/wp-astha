<?php
/**
 * Displayed when no products are found matching the current query
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/no-products-found.php.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
                <div class="error_wrapper">
                    <div class="container">
                        <div class="error_wrap">
                            <div class="box">
                                <p><img alt="Obaju template" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon/404.png" class="img-responsive"></p>
                                <h3>We are sorry - <?php _e( 'No products were found matching your selection.', 'woocommerce' ); ?></h3>                               	
                                <p>To continue please use the <strong>Search form</strong> or <strong>Menu</strong> above.</p>
                                <a class="btn btn-primary" href="/"><i class="fa fa-home"></i> Go to Homepage</a>
                            </div>
                        </div>
                    </div>
                </div>   


