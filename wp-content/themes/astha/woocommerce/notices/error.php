<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.12.4.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>
<?php
/**
 * Show error messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/error.php.
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
 * @version     1.6.4
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!$messages) {
    return;
} else {
    ?>
    <script  type="text/javascript">
        var j = $.noConflict();
        j(document).ready(function () {
            j('#error_modal').modal({show: true});
        });
    </script>

<?php } ?>

<div class="modal fade" id="error_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="validaion">
                    <div class="container">
                        <ul class="woocommerce-error">
                            <?php foreach ($messages as $message) : ?>
                                <li>
                                    <div class="alert alert-danger">
                                        <?php echo wp_kses_post($message); ?>
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                    </div>

                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
