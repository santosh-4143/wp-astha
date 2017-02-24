<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage astha
 * @since astha 1.0
 */
?>
<footer>
    <div class="container">
        <div class="row as_4">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="footer_heading">
                    <h4>About Us</h4>
                </div>
                <div class="footer_abt">
                    <?php
                    if (function_exists('show_text_block')) {
                        echo show_text_block('home-about-us', true);
                    }
                    ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="footer_heading">
                    <h4>Sitemap</h4>
                </div>
                <div class="footer_site">
                    <ul>
                        <li><a href="#">Home</a></li>
                        <?php wp_nav_menu(array('theme_location' => 'footer-menu', 'container' => '', 'items_wrap' => '%3$s')); ?>                                   
                    </ul>

                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="footer_heading">
                    <h4>Contact</h4>
                </div>
                <div class="footer_address">
                    <?php
                    if (function_exists('show_text_block')) {
                        echo show_text_block('footer-contact-details', true);
                    }
                    ?>
                </div>
                <div class="footer_fallow">
                    <h3>Follow Us</h3>
                    <ul>
                        <li><a href="#"><i class="fa fa-facebook"></i> </a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i> </a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i> </a></li>
                    </ul>

                </div>
            </div>
        </div>

    </div>
</footer>
<div class="copy_right">
    <div class="container">
        <div class="container_middle">
            <h6>© 2016 Astha Medic. All rights reserved.  <span class="g_1">| <a href="/terms-of-services">Terms of Service</a> | <a href="/privacy-policy">Privacy Policy</a></span> </h6>
        </div>
    </div>
</div>
<!--end_footer-->
<!-- Modal -->
<div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Login</h4>
            </div>
            <div class="modal-body">
                <div class="sub_en">
                    <form method="post" class="login">
                        <?php do_action('woocommerce_login_form_start'); ?>

                        <div class="form_line_1">
                            <input type="text" placeholder="Username or Email" class="form-control su_en" name="username" id="username" value="<?php if (!empty($_POST['username'])) echo esc_attr($_POST['username']); ?>" />
                        </div>
                        <div class="form_line_1">    

                            <input class="form-control su_en" placeholder="Password" type="password" name="password" id="password" />
                            <p class="woocommerce-LostPassword lost_password">
                                <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php _e('Lost your password?', 'woocommerce'); ?></a>
                            </p>
                        </div>

                        <?php do_action('woocommerce_login_form'); ?>

                        <div class="modal-footer">
                            <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                            <input type="submit" class="btn btn-primary su_1" name="login" value="<?php esc_attr_e('Login', 'woocommerce'); ?>" />
                            <!--                            <label for="rememberme" class="inline">
                                                            <input class="woocommerce-Input woocommerce-Input--checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e('Remember me', 'woocommerce'); ?>
                                                        </label>-->

                        </div>


                        <?php do_action('woocommerce_login_form_end'); ?>

                    </form>                
                </div>    
            </div>
        </div>
    </div>
</div>
<?php
wc_print_notices();
?>
<!-- Modal -->
<div class="modal fade" id="sub_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="u-column2 col-2">
            <form method="post" class="register" id="register_form1" enctype="multipart/form-data">
                <?php do_action('woocommerce_register_form_start'); ?>
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel_1">Get Started Now</h4>
                    </div>
                    <div class="modal-body">
                        <span id="all_error" style="color:red;font-size: 17px;font-weight: bold;margin-left: 150px;display: none;" >All (*) Fields are mendatory </span>
                        <div class="sub_en"> 
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 p_less">
                                <div class="form_line_1">
                                    <input type="text" name="name" id="fname" class="form-control su_en" size="30" placeholder="Full Name" />
                                </div>
                                <div class="form_line_1">
                                    <input type="email" name="email" id="reg_email" value="<?php if (!empty($_POST['email'])) echo esc_attr($_POST['email']); ?>"  class="form-control su_en" size="30" placeholder="Email Id"/>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 p_less">
                                <div class="form_line_1">
                                    <input type="text" name="phone" id="number" class="form-control su_en" size="30" placeholder="Phone Number"/>
                                </div>
                                <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>

                                    <div class="form_line_1">                              
                                        <input type="password" class="form-control su_en" name="password" id="reg_password"  placeholder="Password"/>
                                    </div>

                                <?php endif; ?>

                            </div>
                            <div class="form_line_1">
                                <textarea class="form-control su_en_1" name="address" id="address1" placeholder="Address"></textarea>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 p_less">
                                <div class="form_line_1">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Upload Your Prescription</label>
                                        <input type="file" name="prescription_upload" id="exampleInputFile">
                                        <p class="help-block">Example block-level help text here.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 p_less">
                                <div class="form_line_1">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Upload Your Report</label>
                                        <input type="file" name="report_file" id="exampleInputFile_1">
                                        <p class="help-block">Example block-level help text here.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form_line_1">
                                <textarea class="form-control su_en_1" name="case_history" id="case_history_1" placeholder="Case History"></textarea>
                            </div>
                            <!-- Spam Trap -->
                            <div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e('Anti-spam', 'woocommerce'); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

                            <?php do_action('woocommerce_register_form'); ?>
                            <?php do_action('register_form'); ?>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                        <input type="button" name="register" id="hello" onclick="return register_validation()" class="btn btn-primary su_1" value="<?php esc_attr_e('Register', 'woocommerce'); ?>" >
                    </div>
                </div>
                <?php do_action('woocommerce_register_form_end'); ?>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/jquery-1.12.4.min.js"></script>
<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/bootstrap.min.js"></script>
<!--text_animation-->
<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/text_animation/modernizr.js"></script>
<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/text_animation/main.js"></script>
<!--End text_animation-->
<!--owl_carusel-->
<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/owl_carusel/jquery-1.9.1.min.js"></script>
<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/owl_carusel/owl.carousel.js"></script>
<!--end_owl_carusel-->
<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/wow.min.js"></script>
<script>
                            new WOW().init();
</script>
<!--auto slider js--> 
<script type="text/javascript" src="<?php echo esc_url(get_template_directory_uri()); ?>/js/jquery.flexisel.js"></script> 
<!--jquery-accordian-menu--> 
<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/jquery-accordion-menu.js" type="text/javascript"></script> 
<!--for zoom in-->  
<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/jquery.etalage.min.js"></script>
<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/custom.js"></script>
<script>
                            $("#exampleInputFile").change(function () {
                                var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'pdf'];
                                if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                                    $("#exampleInputFile").val('');
                                    sweetAlert("Oops", "Only formats are allowed : " + fileExtension.join(', '), "error");
                                }
                            });

                            $("#exampleInputFile_1").change(function () {
                                var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'pdf'];
                                if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                                    $("#exampleInputFile_1").val('');
                                    sweetAlert("Oops", "Only formats are allowed : " + fileExtension.join(', '), "error");
                                }
                            });
</script>
<script>
    function register_validation() {
        var name = $('#fname').val();
        var email = $('#reg_email').val();
        var phone = $('#number').val();
        var password = $('#reg_password').val();
        var address = $('#address1').val();
        var case_history = $('#case_history_1').val();


        if (name == "" || email == "" || phone == "" || password == "" || address == "" || case_history == "") {


            $('#all_error').show();

        } else {
            swal("Good job!", "You have registerd successfully!", "success");
            $('#hello').attr('type', 'submit');

        }
    }
</script>

<script>

    function autoSelection(type_id) {

        //alert(type_id);
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'post',
            data: {
                type_id: type_id,
                action: 'subscribe_email',
            },
            success: function (data) {

                $('#specialization').html("");
                $('#specialization').html(data);

            }
        });
    }

</script>

<?php wp_footer(); ?>


</body>
</html>
