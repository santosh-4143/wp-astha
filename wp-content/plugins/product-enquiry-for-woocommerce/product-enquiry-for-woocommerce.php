<?php
/**
 * Plugin Name: Product Enquiry for WooCommerce
 * Description: Allows prospective customers or visitors to make enquiry about a product, right from within the product page.
 * Version: 1.4
 * Author: WisdmLabs
 * Author URI: https://wisdmlabs.com
 * Plugin URI: https://wordpress.org/plugins/product-enquiry-for-woocommerce
 * License: GPL2
 * Text Domain: product-enquiry-for-woocommerce
 * Domain Path: /languages/
 */

add_action('plugins_loaded', 'wdm_pe_init');
function wdm_pe_init()
{
    load_plugin_textdomain('product-enquiry-for-woocommerce', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

add_action('admin_notices', 'check_woo_dependency');

//Check whether WooCommerce is active or not

function check_woo_dependency()
{
    if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

        echo "<div class='error'><p>". sprintf(__('%s WooCommerce %s plugin is not active. In order to make %s Product Enquiry %s plugin work, you need to install and activate %s WooCommerce %s first', 'product-enquiry-for-woocommerce'), "<strong>", "</strong>", "<strong>", "</strong>", "<strong>", "</strong>") . "</p></div>";
    }
}

/*deactivation of pro version*/
register_activation_hook(__FILE__, 'fun_create_tbl_enquiry');

function fun_create_tbl_enquiry()
{

    $my_plugin = 'product-enquiry-pro/product_enquiry_pro.php';


    if (is_plugin_active($my_plugin)) {

        add_action('update_option_active_plugins', 'deactivate_dependent_product_enquiry_pro');
    }
}
    
function deactivate_dependent_product_enquiry_pro()
{
    $my_plugin = 'product-enquiry-pro/product_enquiry_pro.php';

    deactivate_plugins($my_plugin);
}

add_action('wp_head', 'wdm_display_btn_func', 11);

function wdm_display_btn_func()
{

    $form_init_data = get_option('wdm_form_data');

    if (!empty($form_init_data)) {
        if (isset($form_init_data['show_after_summary'])) {
            if ($form_init_data['show_after_summary'] == 'after_add_cart') {
                //show ask button after a single product summary add to cart
                add_action('woocommerce_single_product_summary', 'ask_about_product_button', 30);
    
            }
        }
    
        if (isset($form_init_data['show_at_page_end'])) {
            if ($form_init_data['show_at_page_end'] == 1) {
                //show ask button at the end of the page of a single product
                add_action('woocommerce_after_single_product', 'ask_about_product_button', 10);
            }
        }
        if (isset($form_init_data['show_after_summary'])) {
            if ($form_init_data['show_after_summary'] == 'after_product_summary') {
                //show ask button after a single product summary
                add_action('woocommerce_after_single_product_summary', 'ask_about_product_button');
            }
        }
    } else {
        //show ask button after a single product summary as default
        add_action('woocommerce_single_product_summary', 'ask_about_product_button', 30);
    }

}

function ask_about_product_button()
{
    $form_data = get_option('wdm_form_data');
    ?>
     <div id="enquiry">
            <input type="button" name="contact" value="<?php echo empty($form_data['custom_label']) ?
            __('Make an enquiry for this product', 'product-enquiry-for-woocommerce'): $form_data['custom_label'];?>" class="contact wpi-button" />
     </div>
		
<?php }

add_action('wp_footer', 'ask_about_product');

function ask_about_product()
{
    $form_data = get_option('wdm_form_data');
    global $wpdb,$post;
    $query = "select user_email from {$wpdb->posts} as p join {$wpdb->users} as u on p.post_author=u.ID where p.ID=%d";
    $authorEmail = $wpdb->get_var($wpdb->prepare($query, $post->ID));

    ?>
     <!-- Page styles -->
        <?php
           // wp_enqueue_style("wdm-contact-css", plugins_url("css/contact.css", __FILE__));
        wp_enqueue_style("wdm-juery-css", plugins_url("css/wdm-jquery-ui.css", __FILE__));
        ?>
    <?php if (is_singular('product')/*&&(!empty($form_data['show_at_page_end']))||(!empty($form_data['show_after_summary']))*/) { ?>
    <div id="contact-form" title="<?php _e("Product Enquiry", "product-enquiry-for-woocommerce");?>" style="display:none;">
    <form id="enquiry-form" action="#" method="POST">
    <label id="wdm_product_name" for='product_name'> <?php echo get_the_title();?> </label>
	    <div class="wdm-pef-form-row">
		<label for='contact-name'>*<?php _e("Name", "product-enquiry-for-woocommerce");?>:</label>
        <input type='hidden' name='author_email' id='author_email' value='<?php echo $authorEmail ?>'>
		<input type='text' id='contact-name' class='contact-input' name='wdm_customer_name' value=""/>
	    </div>
	    <div class="wdm-pef-form-row">
		<label for='contact-email'>*<?php _e("Email", "product-enquiry-for-woocommerce");?>:</label>
		<input type='text' id='contact-email' class='contact-input' name='wdm_customer_email'  />
	    </div>
	    <div class="wdm-pef-form-row">
		<label for='contact-subject'><?php _e("Subject", "product-enquiry-for-woocommerce");?>:</label>
		<input type='text' id='contact-subject' class='contact-input' name='wdm_subject' value=''  />
	    </div>
	    <div class="wdm-pef-form-row">
		<label for='contact-message'>*<?php _e("Enquiry", "product-enquiry-for-woocommerce");?>:</label>
		<textarea id='contact-message' class='contact-input' name='wdm_enquiry' cols='40' rows='4' style="resize:none"></textarea>
	    </div>
	    <?php if (!empty($form_data['enable_send_mail_copy'])) {?>
	    <div class="wdm-pef-send-copy">
		<input type='checkbox' id='contact-cc' name='cc' value='1' /> <span class='contact-cc'>
		<?php _e("Send me a copy", "product-enquiry-for-woocommerce");?></span>
	    </div>
	    <?php }?>
	    <div id="errors"></div>
	    <div class="wdm-enquiry-action-btns">
		<button id="send-btn" type='submit' class='contact-send contact-button' ><?php _e("Send", "product-enquiry-for-woocommerce");?></button>
		<button id="cancel" type='button' class='contact-cancel contact-button' ><?php _e("Cancel", "product-enquiry-for-woocommerce");?></button>
	    </div>
	    <?php echo wp_nonce_field('enquiry_action', 'product_enquiry', true, false); ?>
	    
  </form>
    <?php
 
    $site_url=site_url();
    $domain_name=htmlspecialchars(url_to_domain($site_url));
    $domain_name_value=ord($domain_name);
    if ($domain_name_value>=97 && $domain_name_value<=102) {
        $display_url="https://wisdmlabs.com/";
        $display_message = 'WordPress Development Experts';
        $prefix = "Brought to you by WisdmLabs: ";
        $suffix = "";
    } else if ($domain_name_value>=103 && $domain_name_value<=108) {
        $display_url="https://wisdmlabs.com/wordpress-development-services/plugin-development/";
        $display_message = 'Expert WordPress Plugin Developer';
        $prefix = "Brought to you by WisdmLabs: ";
        $suffix = "";
    } elseif ($domain_name_value>=109 && $domain_name_value<=114) {
        $display_url="https://wisdmlabs.com/woocommerce-extension-development-customization-services/";
        $display_message = 'Expert WooCommerce Developer';
        $prefix = "Brought to you by WisdmLabs: ";
        $suffix = "";
    } else {
        $display_url="https://wisdmlabs.com/woocommerce-product-enquiry-pro/";
        $display_message = 'WooCommerce Enquiry Plugin';
        $prefix = "";
        $suffix = " by WisdmLabs";
    }
?>
<!--<div class='contact-bottom'><a href='#' onclick="return false;"><?php //echo $prefix; ?></a><a href='<?php //echo $display_url ?>' target='_blank' rel='nofollow'><?php //echo $display_message;?></a><a href='#' onclick="return false;"><?php //echo $suffix; ?></a></div>-->
        <div class='contact-bottom'><a href="javascript:void(0)">Please submit your enquiry,We will contact you soon.</a></div>

    </div>
  <!-- preload the images -->
	    
		<div id="loading" style='display:none'>
			<div id="send_mail"><p><?php _e("Sending...", "product-enquiry-for-woocommerce");?></p>
			<img src='<?php echo plugins_url("img/contact/loading.gif", __FILE__)?>' alt='' />
			</div>
		</div> <?php } ?>
    <!-- Load JavaScript files -->
    <?php
    
    wp_enqueue_script("jquery");
    wp_enqueue_script("jquery-ui-core", array("jquery"));
    wp_enqueue_script("jquery-ui-dialog", array("jquery"));
    wp_enqueue_script("wdm-validate", plugins_url("js/wdm_jquery.validate.min.js", __FILE__));
    //wp_enqueue_script("wdm-validate", plugins_url("js/jquery.validate.min.js", __FILE__));
    wp_enqueue_script("wdm-contact", plugins_url("js/contact.js", __FILE__), array("jquery"));
    wp_localize_script(
        'wdm-contact',
        'object_name',
        array('ajaxurl' => admin_url('admin-ajax.php'),
                'product_name'=>get_the_title(),
                'wdm_customer_name' => __('Name is required.', 'product-enquiry-for-woocommerce'),
                'wdm_customer_email'=>__('Enter valid Email Id.', 'product-enquiry-for-woocommerce'),
                'wdm_enquiry' => __(
                    'Enquiry length must be atleast 10 characters.',
                    'product-enquiry-for-woocommerce'
                ) )
    );
}
/* Thanks to davejamesmiller*/
function url_to_domain($site_url)
{
    $host = @parse_url($site_url, PHP_URL_HOST);

    // If the URL can't be parsed, use the original URL
    // Change to "return false" if you don't want that
    if (!$host) {
        $host = $site_url;
    }

    // The "www." prefix isn't really needed if you're just using
    // this to display the domain to the user
    if (substr($host, 0, 4) == "www.") {
        $host = substr($host, 4);
    }

    // You might also want to limit the length if screen space is limited
    if (strlen($host) > 50) {
        $host = substr($host, 0, 47) . '...';
    }

    return $host;
}


add_action('admin_menu', 'create_ask_product_menu');

function create_ask_product_menu()
{
    //create a submenu under Woocommerce 'Products' menu
    // add_submenu_page('edit.php?post_type=product', __('Product Enquiry', 'product-enquiry-for-woocommerce'), __('Product Enquiry', 'product-enquiry-for-woocommerce'), 'manage_options', 'pefw', 'add_ask_product_settings');
    add_menu_page(__('Product Enquiry', 'product-enquiry-for-woocommerce'), __('Product Enquiry', 'product-enquiry-for-woocommerce'), 'manage_options', 'product-enquiry-for-woocommerce',  'add_ask_product_settings');
}

function add_ask_product_settings()
{
    //settings page
    
    wp_enqueue_script('wdm_wpi_validation', plugins_url("js/wdm_jquery.validate.min.js", __FILE__), array('jquery'));
    ?>
    
      <div class="wrap wdm_leftwrap">
      	<div class='wdm-pro-notification'>
      
      <div class='wdm-title-layer'>
		<h4><?php _e("Get The New Premium Version", "product-enquiry-for-woocommerce");?></h4>
      </div> <!--wdm-title-layer ends-->
      
      <div class="wdm-content-layer">
        <div class="wdm-left-content">
            <img src='<?php echo plugins_url('img/PEP_new.png', __FILE__); ?>' class='wdm_pro_logo'>
            <div class="wdm_upgrade">
                        <a class='wdm_upgrade_pro_link' href='https://wisdmlabs.com/woocommerce-product-enquiry-pro/?utm_medium=in-product-clicks&utm_campaign=product-enquiry-free&utm_source=in-product-ads&utm_content=top-banner-image
' target='_blank'><?php _e("UPGRADE TO PRO", "product-enquiry-for-woocommerce");?> </a>
                </div>
        </div>
        <div class="wdm-right-content"> 
            <div class="wdm-features">
               
               <div class='wdm-feature-list'>
                    <div>
                        <div class="wdm-feature">
                            <span class="wdmicon-filter"></span>
                            <p><?php _e("Filter enquires", "product-enquiry-for-woocommerce");?></p>
                        </div>
                    
                        <div class="wdm-feature">
                            <span class="wdmicon-enlarge"></span>
                            <p><?php _e("Responsive", "product-enquiry-for-woocommerce");?></p>
                        </div>
                                                                                    
                        <div class="wdm-feature">
                            <span class="wdmicon-paint-format"></span>
                            <p><?php _e("Custom styling", "product-enquiry-for-woocommerce");?></p>
                        </div>

                         <div class="wdm-feature">
                            <span class="wdmicon-earth"></span>
                            <p><?php _e("WPML Compatible", "product-enquiry-for-woocommerce");?></p>
                         </div>
                    </div>
                    <div class="clear"></div>
                    <div>
                        <div class="wdm-feature">
                            <span class="wdmicon-eye"></span>
                            <p style="width: 60%;"><?php _e("Enquiries in dashboard", "product-enquiry-for-woocommerce");?></p>
                        </div>
                            
                        <div class="wdm-feature">
                            <span class="wdmicon-drawer2"></span>
                            <p style="width: 70%;"><?php _e("Export enquiry records", "product-enquiry-for-woocommerce");?></p>
                        </div>  
                            
                        <div class="wdm-feature">
                            <span class="wdmicon-bubbles3"></span>
                            <p><?php _e("Localization ready", "product-enquiry-for-woocommerce");?></p>
                        </div>

                        <div class="wdm-feature">
                            <span class="wdmicon-pencil2"></span>
                            <p style="width: 60%;"><?php _e("Customizable Enquiry Form", "product-enquiry-for-woocommerce");?></p>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div>
                        <div class="wdm-feature">
                            <span class="wdmicon-variable-products"></span>
                            <p style="width: 65%;"><?php _e("Supports Variable Products", "product-enquiry-for-woocommerce");?></p>
                        </div>

                        <div class="wdm-feature">
                            <span class="wdmicon-quotation-system"></span>
                            <p style="width: 65%;"><?php _e("Integrated Quotation System", "product-enquiry-for-woocommerce");?></p>
                        </div>

                        <div class="wdm-feature">
                            <span class="wdmicon-quote-pdf"></span>
                            <p style="width: 65%;"><?php _e("Auto-Generate Quote PDFs", "product-enquiry-for-woocommerce");?></p>
                        </div>

                        <div class="wdm-feature">
                            <span class="wdmicon-multiproduct-enquiry"></span>
                            <p style="width: 65%;"><?php _e("Multi-Product Enquiry or Quote Request", "product-enquiry-for-woocommerce");?></p>
                        </div>
                </div>
                <div class="clear"></div>
                </div>
        </div>
        </div>
        </div>
      <div class='clear'></div>
    </div> <!--wdm-pro-notification ends-->
    
    

        <h2><?php _e("Product Enquiry", "product-enquiry-for-woocommerce");?></h2>
<br />
	<?php
    if (isset($_GET[ 'tab' ])) {
            $active_tab = $_GET[ 'tab' ];
    } else {
            $active_tab = 'form';
    }
        
        ?>
            <h2 class="nav-tab-wrapper">  
                <a href="admin.php?page=product-enquiry-for-woocommerce&tab=form" class="nav-tab <?php echo $active_tab == 'form' ? 'nav-tab-active' : ''; ?>"><?php _e("Enquiry Settings", "product-enquiry-for-woocommerce");?></a>
		<a href="admin.php?page=product-enquiry-for-woocommerce&tab=entry" class="nav-tab <?php echo $active_tab == 'entry' ? 'nav-tab-active' : ''; ?>"><?php _e("Enquiry Details", "product-enquiry-for-woocommerce");?></a>
		<a href="admin.php?page=product-enquiry-for-woocommerce&tab=contact" class="nav-tab <?php echo $active_tab == 'contact' ? 'nav-tab-active' : ''; ?>"><?php _e("Product Enquiry Ideas", "product-enquiry-for-woocommerce");?></a>
		<a href="admin.php?page=product-enquiry-for-woocommerce&tab=hireus" class="nav-tab <?php echo $active_tab == 'hireus' ? 'nav-tab-active' : ''; ?>"><?php _e("Hire Us", "product-enquiry-for-woocommerce");?></a>
        <a href="admin.php?page=product-enquiry-for-woocommerce&tab=premium" class="premium nav-tab <?php echo $active_tab == 'premium' ? 'nav-tab-active' : ''; ?>"><?php _e("Premium Version", "product-enquiry-for-woocommerce");?></a>
            </h2>  
	
    <?php if ($active_tab === 'entry') {
    
    ?>
	<div id='entry_dummy'>
	    <div class="layer_parent">
		    <div class="pew_upgrade_layer">
			<div class="pew_uptp_cont">
			    <p> <?php _e("This feature is available in the PRO version. Click below to know more.", "product-enquiry-for-woocommerce");?></p>
			<a class="wdm_view_det_link" href="https://wisdmlabs.com/woocommerce-product-enquiry-pro/?utm_medium=in-product-clicks&utm_campaign=product-enquiry-free&utm_source=in-product-ads&utm_content=enquiry-details-tab
" target="_blank"> <?php _e("View Details", "product-enquiry-for-woocommerce");?> </a>
			</div>
		    </div>
		    <img src="<?php echo plugins_url('/img/entries.png', __FILE__); ?>" style='width:100%;height: 700px'/>
	    </div>
	    
	</div>
	<?php
     
} elseif ($active_tab === 'contact') { ?>
<div class="wdm-tab-container">
<div class="wdm-container">
<fieldset>

<div class="col-1 wdm-abt" >
<p class="wdm-about" style="text-align:center">
    <?php
    echo sprintf(__('Product Enquiry Pro is one of WisdmLabs early plugins and a very successful one. With over  %s 800+ satisfied customers  %s we continue to improve PEP and give the best to our customers. We stand by our products and make sure we give our customers what they are looking for with great quality and even better features.', 'product-enquiry-for-woocommerce'), "<b class='wdm-color'>", "</b>"); ?>
    
<br><br>
<b class="wdm-color" style="width: 100%; margin: 0px auto; text-align: center; font-size: 16px;"><?php _e("THIS IS WHERE WE NEED YOU! ", "product-enquiry-for-woocommerce");?></b>
<br><br> <?php
echo sprintf(__('We need you, the users of PEP to %s pitch in your ideas %s  for the plugin. Based on the number of interested users, we will incorporate the feature and make it available at a minimal cost. ', 'product-enquiry-for-woocommerce'), "<b style='color:#961914;'>", "</b>"); ?>

<br>
</p>

</div>
<div class="clear"></div>
</fieldset>
</div>

<div class="wdm-container wdm-services-offered clearfix">
<?php global $current_user;
wp_get_current_user();
?>
<ul class="wdm-services-list clearfix">
<li class="wdm-services-item">
<div class="wdm-services-icon wdm-custom-eq-form" ></div>
<h3><?php _e("Customize Your Enquiry Form ", "product-enquiry-for-woocommerce");?></h3>
<p class="wdm-services-desc">
    <?php _e("Flexibility to create your own fields within the enquiry form. ", "product-enquiry-for-woocommerce");?>
</p>
<a class="wdm_upgrade_pro_link" href="https://wisdmlabs.com/woocommerce-product-enquiry-pro/?utm_medium=in-product-clicks&utm_campaign=product-enquiry-free&utm_source=in-product-ads&utm_content=product-enquiry-ideas-tab
" target="_blank"><?php _e("UPGRADE TO PRO", "product-enquiry-for-woocommerce"); ?></a>
</li>
<li class="wdm-services-item">
<div class="wdm-services-icon wdm-display-eq-button" ></div>
<h3><?php _e("Display Enquiry Button On Shop ", "product-enquiry-for-woocommerce");?></h3>
<p class="wdm-services-desc">
<?php _e("Allow visitors to enquire about your products directly from the shop page. ", "product-enquiry-for-woocommerce");?>
</p>
<a class="wdm_upgrade_pro_link" href="https://wisdmlabs.com/woocommerce-product-enquiry-pro/?utm_medium=in-product-clicks&utm_campaign=product-enquiry-free&utm_source=in-product-ads&utm_content=product-enquiry-ideas-tab
" target="_blank"><?php _e("UPGRADE TO PRO", "product-enquiry-for-woocommerce"); ?></a>
<div class="hide_class">
<?php echo "<h4 class='wdm-req-title'>Please confirm your feature request</h4>"; ?>
<form class="wdm-req-form display-enquiry-button-on-shop" >
<br><small><?php _e("Confirm Email-id : ", "product-enquiry-for-woocommerce");?></small>
<input type="text" class="wdm-req-text" name="wdm-req-email" value="<?php echo $current_user->user_email ?>" />
<input type="button" class="wdm-req-button" value="Send Request" name="request-feature" />
<input type="hidden" class="id" name="id" value="display-enquiry-button-on-shop" />
<div class="loading"></div>
</form>
<span class="wdm-close" ></span>
</div>
</li>
<!---for selerating two rows---->
<!--<div class="clear"></div> -->
<li class="wdm-services-item">
<div class="wdm-services-icon wdm-hide-re-cart" ></div>
<h3><?php _e("Hide or Replace Add-to-Cart Button ", "product-enquiry-for-woocommerce");?></h3>
<p class="wdm-services-desc">
<?php _e("Replace the add-to-cart button with the enquiry button for your products. ", "product-enquiry-for-woocommerce");?>
</p>
<a class="wdm_upgrade_pro_link" href="https://wisdmlabs.com/woocommerce-product-enquiry-pro/?utm_medium=in-product-clicks&utm_campaign=product-enquiry-free&utm_source=in-product-ads&utm_content=product-enquiry-ideas-tab
" target="_blank"><?php _e("UPGRADE TO PRO", "product-enquiry-for-woocommerce"); ?></a>
</li>
<li class="wdm-services-item">
<div class="wdm-services-icon wdm-create-cu-email" ></div>
<h3><?php _e("Create a Custom Email Template ", "product-enquiry-for-woocommerce");?></h3>
<p class="wdm-services-desc">
<?php _e("Style and create templates for your enquiry emails from your dashboard. ", "product-enquiry-for-woocommerce");?>
</p>
<input type="button" class="wdm-services-button one" value="Request Feature" />
<div class="hide_class">
<?php echo "<h4 class='wdm-req-title'>Please confirm your feature request</h4>"; ?>
<form class="wdm-req-form create-a-custom-email" >
<br><small><?php _e("Confirm Email-id : ", "product-enquiry-for-woocommerce");?></small>
<input type="text" class="wdm-req-text" name="wdm-req-email" value="<?php echo $current_user->user_email ?>" />
<input type="button" class="wdm-req-button" value="Send Request" name="request-feature" />
<input type="hidden" class="id" name="id" value="create-a-custom-email" />
    
<div class="loading"></div>
</form>
<span class="wdm-close" ></span>
</div>
</li>
<li class="wdm-services-item">
<div class="wdm-services-icon wdm-analytics-eq" ></div>
<h3><?php _e("Analytics For Your Enquiries ", "product-enquiry-for-woocommerce");?></h3>
<p class="wdm-services-desc">
<?php _e("Get detailed analytics for your enquiries based on products and other attributes. ", "product-enquiry-for-woocommerce");?>
</p>
<input type="button" class="wdm-services-button" value="Request Feature" />
<div class="hide_class">
<?php echo "<h4 class='wdm-req-title'>".__("Please confirm your feature request", "product-enquiry-for-woocommerce")."</h4>"; ?>
<form class="wdm-req-form Analytics-for-your-enquiry" >
<br><small><?php _e("Confirm Email-id : ", "product-enquiry-for-woocommerce");?></small>
<input type="text" class="wdm-req-text" name="wdm-req-email" value="<?php echo $current_user->user_email ?>" />
<input type="button" class="wdm-req-button" value="Send Request" name="request-feature" />
<input type="hidden" class="id" name="id" value="Analytics-for-your-enquiry" />
    
<div class="loading"></div>
</form>
<span class="wdm-close" ></span>
</div>
</li>
<li class="wdm-services-item">
<div class="wdm-services-icon wdm-newsletter-int" ></div>
<h3><?php _e("Newsletter Integration With PEP ", "product-enquiry-for-woocommerce");?></h3>
<p class="wdm-services-desc">
<?php _e("Get your newsletter plugin integrated seamlessly with PEP. ", "product-enquiry-for-woocommerce");?>
</p>
<input type="button" class="wdm-services-button" value="Request Feature" />
<div class="hide_class">
<h4 class='wdm-req-title'><?php _e("Please confirm your feature request", "product-enquiry-for-woocommerce");?></h4>
<form class="wdm-req-form newsletter-integration-with-pep" >
<br><small><?php _e("Confirm Email-id : ", "product-enquiry-for-woocommerce");?></small>
<input type="text" class="wdm-req-text" name="wdm-req-email" value="<?php echo $current_user->user_email ?>" />
<input type="button" class="wdm-req-button" value="Send Request" name="request-feature" />
<input type="hidden" class="id" name="id" value="newsletter-integration-with-pep" />
    
<div class="loading"></div>
</form>
<span class="wdm-close" ></span>
</div>
</li>
</ul>
<!-- //code for displaying the hidden send button -->
<script type="text/javascript">
//jQuery(this.className).click(function() {
// jQuery(this.className).css('display','block');
// console.log(this.className);
//});
jQuery('.wdm-services-button').click(function (e) {
if (((e.target.id == 'hide_class') || (e.target.id == 'wdm-req-form') || (e.target.nodeName == 'H4') || (e.target.nodeName == 'INPUT') || (e.target.nodeName == 'SMALL'))) {
console.log(jQuery(e.target));
jQuery(".hide_class").hide();
//jQuery(!jQuery(e.target).siblings(".hide_class")).hide();
jQuery(e.target).siblings(".hide_class").fadeIn();
console.log('yes');
} else {
jQuery(".hide_class").fadeIn("slow");
console.log('no');
}
});
//jQuery('#').css('border','none');
jQuery('.wdm-close').click(function (event) {
console.log('clicked');
jQuery(event.target).parent('.hide_class').fadeOut("slow");
});
//jQuery('#wdm-close').css('display','block');
</script>
</div><!-- /.wdm-services-offered -->

<div class="wdm-container wdm-services-details">
<fieldset>
<!--<legend>Details</legend>-->
<div class="wdm-details">
   <h2 class="wdm-color" style="text-align: center;" ><?php _e("Get A Feature Developed in PEP ", "product-enquiry-for-woocommerce");?></h2>
   <hr>
    <?php _e("Select a feature you want us to develop and leave us a note about it. We will get in touch with you and keep you posted on its progress. ", "product-enquiry-for-woocommerce");?><br><br>
   <b class="wdm-color"><?php _e("Need a custom feature developed in PEP ? ", "product-enquiry-for-woocommerce");?></b>
   <br><br><a href="https://wisdmlabs.com/contact-us/" target="_blank" class="wdm-contact-button" title="Wisdmlabs" ><?php _e("Contact Us ", "product-enquiry-for-woocommerce");?></a>
</div>
</fieldset>
</div><!-- /.wdm-services-details -->
</div><!-- /.wdm-tab-container -->
<?php      } elseif ($active_tab === 'hireus') { ?>
		<div class="wdm-tab-container">
		<div class="wdm-container">
		<fieldset class="wdm-plugin-customize">
		<h2 class="wdm-color"><?php _e("Plugin Development and Customization ", "product-enquiry-for-woocommerce");?></h2><hr>
		<p><?php _e("Our area of expertise is WordPress plugins. We specialize in creating bespoke plugin solutions for your business needs. Our competence with plugin development and customization has been certified by WordPress biggies like WooThemes and Event Espresso. ", "product-enquiry-for-woocommerce");?><br><br>
		<a class="wdm-contact-button" style="padding:8px 30px; margin-top:10px;" href="https://wisdmlabs.com/contact-us/" target="_blank"><?php _e("Contact Us ", "product-enquiry-for-woocommerce");?></a>
		</p>
		</fieldset>
		<div class="wdm-container">
		<h2 style="text-align: center;" class="wdm-color"><?php _e("Our Premium Plugins ", "product-enquiry-for-woocommerce");?></h2>
		<ul class="wdm-premium-plugins">
		    <li class="wdm-plugins-item first">
			<h3><?php _e("Customer Specific Pricing for WooCommerce ", "product-enquiry-for-woocommerce");?></h3>
			<p style="text-align: center;">
			    <?php _e("This simple yet powerful plugin, allows you to set a different price for a WooCommerce product on a per customer basis. ", "product-enquiry-for-woocommerce");?> <br><br>
			</p>
			<a class="wdm-contact-button wdm-know-more" href="https://wisdmlabs.com/woocommerce-user-specific-pricing-extension/" target="_blank"><?php _e("Know more ", "product-enquiry-for-woocommerce");?> </a>
		    </li>
		    <li class="wdm-plugins-item">
			<h3><?php _e("WooCommerce Custom Product Boxes ", "product-enquiry-for-woocommerce");?></h3>
			<p style="text-align: center;">
			    <?php _e("This plugin allows customers, to select and create their own product bundles, which can be purchased as a single product! ", "product-enquiry-for-woocommerce");?>
			</p>
			<a class="wdm-contact-button wdm-know-more" href="https://wisdmlabs.com/assorted-bundles-woocommerce-custom-product-boxes-plugin/" target="_blank"><?php _e("Know more ", "product-enquiry-for-woocommerce");?> </a>
		    </li>
		    <li class="wdm-plugins-item">
			<h3 style="min-height:54px;"><?php _e("Instagram WooCommerce Integration ", "product-enquiry-for-woocommerce");?>  </h3>
			<p style="text-align: center;">
			    <?php _e("A perfect solution, to create collages using Instagram images, right from your WooCommerce store. ", "product-enquiry-for-woocommerce");?>
			</p>
			<a class="wdm-contact-button wdm-know-more" href="https://wisdmlabs.com/instagram-woocommerce-integration-solution/" target="_blank"><?php _e("Know more ", "product-enquiry-for-woocommerce");?> </a>
		    </li>
		    <li class="wdm-plugins-item last">
			<h3><?php _e("WooCommerce Moodle Integration", "product-enquiry-for-woocommerce");?></h3>
			<p style="text-align: center;">
			    <?php _e("Want to sell Moodle Courses in your WooCommerce store? This plugin allows you to do the same and much more. ", "product-enquiry-for-woocommerce");?>
			</p>
			<a class="wdm-contact-button wdm-know-more" href="https://wisdmlabs.com/woocommerce-moodle-integration-solution/" target="_blank"><?php _e("Know more ", "product-enquiry-for-woocommerce");?> </a>
		    </li>
		</ul>
		<ul class="wdm-premium-plugins three-grids">
		    <li class="wdm-plugins-item first">
			<h3><?php _e("WooCommerce Scheduler", "product-enquiry-for-woocommerce");?></h3>
			<p style="text-align: center;">
			    <?php _e("With the WooCommerce Scheduler Plugin, you can manage product availability as per your business needs.", "product-enquiry-for-woocommerce");?>
			</p>
			<a class="wdm-contact-button wdm-know-more" href="https://wisdmlabs.com/woocommerce-scheduler-plugin-for-product-availability/" target="_blank"><?php _e("Know more ", "product-enquiry-for-woocommerce");?> </a>
		    </li>
		    <li class="wdm-plugins-item">
			<h3><?php _e("WooCommerce Bookings: Availability Search Widget", "product-enquiry-for-woocommerce");?></h3>
			<p style="text-align: center;">
			    <?php _e("An WooCommerce Bookings plugin extension, which allows customers to search for Available Bookings on requested dates.", "product-enquiry-for-woocommerce");?>
			</p>
			<a class="wdm-contact-button wdm-know-more" href="https://wisdmlabs.com/woocommerce-bookings-availability-search-widget/" target="_blank"><?php _e("Know more ", "product-enquiry-for-woocommerce");?> </a>
		    </li>
		    <li class="wdm-plugins-item last">
			<h3><?php _e("Empty Cart Timer for WooCommerce", "product-enquiry-for-woocommerce");?></h3>
			<p style="text-align: center;">
			    <?php _e("Empty Cart Timer for WooCommerce deletes products from the cart after a certain predefined amount of expiration time. ", "product-enquiry-for-woocommerce");?>
			</p>
			<a class="wdm-contact-button wdm-know-more" href="https://wisdmlabs.com/empty-cart-timer-woocommerce-plugin/" target="_blank"><?php _e("Know more ", "product-enquiry-for-woocommerce");?> </a>
		    </li>
		</ul>
		</div>
		<div class="clear"></div>
		<fieldset class="wdm-bouquet-of-services">
		<h2 class="wdm-color"><?php _e("Entire Array of Services ", "product-enquiry-for-woocommerce");?></h2><hr>
		<p><?php _e("We specialize in WordPress website development and customization with an entire range of services under our belt. We have expertise in domains such as eCommerce, LMS, Event Management System, etc. Explore our services now and cater to all your WordPress requirements under one roof. ", "product-enquiry-for-woocommerce");?><br><br>
		<a class="wdm-contact-button" style="padding:8px 30px; margin-top:10px;" href="https://wisdmlabs.com/services/" target="_blank"><?php _e("View Our Services ", "product-enquiry-for-woocommerce");?></a>
		</p>
		</fieldset>
		</div>
		</div>
		<?php         
        } elseif ($active_tab === 'premium') {
            wp_enqueue_script('jquery');
            wp_enqueue_style('premium-style',plugins_url('css/style.css',__FILE__));
            wp_enqueue_style('premium-fontstyle',plugins_url('css/font.css',__FILE__));
            wp_enqueue_script('viewportChecker-min',plugins_url('/js/jquery.viewportChecker.min.js', __FILE__), array('jquery'));
            wp_enqueue_script('debouncedResize',plugins_url('/js/jquery.debouncedresize.js', __FILE__), array('jquery'));
            wp_enqueue_script('main',plugins_url('/js/main.js', __FILE__), array('jquery'));
            require('premium.php');
        } else {
            wp_enqueue_script('wdm-tip', plugins_url("js/tooltip.js", __FILE__), array('jquery'));
            wp_enqueue_style('woocommerce_admin_styles', plugin_dir_url((dirname(__FILE__))) . 'woocommerce/assets/css/admin.css');
            wp_enqueue_script('jquery-tiptip', array( 'jquery' ));
    $pro = "<span title='Pro Feature' class='pew_pro_txt'>".__('[Available in PRO]', 'product-enquiry-for-woocommerce')."</span>";
    ?>
 <form name="ask_product_form" id="ask_product_form" method="POST" action="options.php" style="background: #fff; padding: 10px 15px 0 15px;">
    <?php
        settings_fields('wdm_form_options');
       $default_vals =   array('show_after_summary'=>'after_add_cart');
       $form_data = get_option('wdm_form_data', $default_vals);
       if(!isset($form_data['show_after_summary'])){
        $form_data['show_after_summary'] = "";
       }
        ?>
      <div id="ask_abt_product_panel">
	<fieldset>
	    <?php echo '<legend>'. __("Emailing Information", 'product-enquiry-for-woocommerce').'</legend>'; ?>
	<div class="fd">
	<div class='left_div'>
            <label for="wdm_user_email"><?php _e(" Recipient's Email ", "product-enquiry-for-woocommerce");?> </label> 
	</div>
	<div class='right_div'>
    <?php
        $helptip = __( 'You can add one reciepient email address', 'product-enquiry-for-woocommerce' );
        echo wdmHelpTip($helptip);
    ?>
	    <input type="text" class="wdm_wpi_input wdm_wpi_text email" name="wdm_form_data[user_email]" id="wdm_user_email" value="<?php echo empty($form_data['user_email']) ? get_option('admin_email') : $form_data['user_email'];?>" />
	    <span class='email_error'> </span>
	</div>
	<div class='clear'></div>
	</div >
	<div class="fd">
	<div class='left_div'>
	    <label for="wdm_default_sub"> <?php _e("Default Subject ", "product-enquiry-for-woocommerce");?> </label>
	</div>
	<div class='right_div'>
    <?php
        $helptip = __( 'Subject to be used if customer leaves subject field blank', 'product-enquiry-for-woocommerce' );
        echo wdmHelpTip($helptip);
    ?>		
	    <input type="text" class="wdm_wpi_input wdm_wpi_text" name="wdm_form_data[default_sub]" id="wdm_default_sub" value="<?php echo empty($form_data['default_sub']) ? __('Enquiry for a product from ', 'product-enquiry-for-woocommerce').get_bloginfo('name') : $form_data['default_sub'];?>"  />
        <br>
	    <?php echo '<em>'.__(' Will be used if the customer does not enter a subject', 'product-enquiry-for-woocommerce').'</em>'; ?>
	</div>
	<div class='clear'></div>
	</div>
        </fieldset>
	<!-- <br/> -->
	    <fieldset>
	
        <?php echo '<legend>'. __("Form Options", 'product-enquiry-for-woocommerce').'</legend>'; ?>
	<div class="fd">
			<div class='left_div'>
            <label for="custom_label"> <?php _e("Button-Text for enquiry button", "product-enquiry-for-woocommerce");?> </label> 
	    </div>
			<div class='right_div'>
            <?php
                $helptip = __( 'Add custom label for enquiry button', 'product-enquiry-for-woocommerce' );
                echo wdmHelpTip($helptip);
            ?>
            <input type="text" class="wdm_wpi_input wdm_wpi_text" name="wdm_form_data[custom_label]" value="<?php echo empty($form_data['custom_label']) ? __('Make an enquiry for this product', 'product-enquiry-for-woocommerce') : $form_data['custom_label'];?>" id="custom_label"  />
        </div>
			<div class='clear'></div>
		</div>
	<div class="fd">
			<div class='left_div'>
	    <label> <?php _e("Enquiry Button Location", "product-enquiry-for-woocommerce");?> </label>
	    </div>
			<div class='right_div'>	 
	   <input type='radio' class='wdm_wpi_input wdm_wpi_checkbox input-without-tip' value='after_add_cart' name='wdm_form_data[show_after_summary]' <?php echo (($form_data['show_after_summary'])=='after_add_cart' ) ? ' checked="checked" ' : ''; ?> />
	  <label for="show_after_product_summary"><?php _e(" After add to cart button", "product-enquiry-for-woocommerce");?></label>
	    <br />
	  
	  <input type='radio' class='wdm_wpi_input wdm_wpi_checkbox input-without-tip' value='after_product_summary' name='wdm_form_data[show_after_summary]' <?php echo (($form_data['show_after_summary']== 'after_product_summary') ? ' checked="checked" ' : '');?> />
	  <label for="show_after_cart"><?php _e(" After single product summary ", "product-enquiry-for-woocommerce");?></label>
	    <br />
	  
	  <input type="checkbox" class="wdm_wpi_input wdm_wpi_checkbox input-without-tip" name="wdm_form_data[show_at_page_end]" value="1" <?php echo (isset($form_data["show_at_page_end"]) ? "checked" : "" );?> id="show_at_page_end" />
		   
	   
	    <label for="show_at_page_end"> <?php _e("At the end of single product page ", "product-enquiry-for-woocommerce");?></label>
	    
        </div>
	    <div class='clear'></div>
	</div>
        
	<div class="fd">
	    <div class='left_div'>
		<label> <?php _e("Enable sending an email copy", "product-enquiry-for-woocommerce");?> </label>
		 </div>
	    <div class='right_div'>
        <?php
            $helptip = __( 'This will display \'send me a copy\' checkbox on enquiry form', 'product-enquiry-for-woocommerce' );
            echo wdmHelpTip($helptip);
        ?>
            <input type="checkbox" class="wdm_wpi_input wdm_wpi_checkbox" name="wdm_form_data[enable_send_mail_copy]" value="1" <?php echo (isset($form_data["enable_send_mail_copy"]) ? "checked" : "" );?> id="enable_send_mail_copy" />
	  
	    <label for="enable_send_mail_copy"><?php _e(" Enable option on the enquiry form to send an email copy to customer", "product-enquiry-for-woocommerce");?> </label>
        </div>
			<div class='clear'></div>
	</div>
	<!--
	<div class="fd">
	    <div class='left_div'>
	    <label for="link">
		<?php // _e("Display 'Powered by WisdmLabs'", "product-enquiry-for-woocommerce");?>
	    </label>
	    </div>
	    <div class='right_div'>
	    <input type="checkbox" disabled class="wdm_wpi_input wdm_wpi_checkbox" value="1" id="show_powered_by_link" />
            <?php //echo $pro; ?>
	    </div>
	<div class="clear"></div>
	</div>
    -->
	
	<div class="fd">
	    <div class='left_div'>
	    <label for="enable_telephone_no_txtbox">
		<?php _e("Display 'Telephone Number Field'", "product-enquiry-for-woocommerce");?>
	    </label>
	    </div>
	    <div class='right_div'>
        <?php
            $helptip = __( 'Displays telephone number field on the enquiry form', 'product-enquiry-for-woocommerce' );
            echo wdmHelpTip($helptip);
        ?>
		<input type="checkbox" disabled class="wdm_wpi_input wdm_wpi_checkbox" value="1" id="enable_telephone_no_txtbox" />
            <?php echo $pro; ?>
	    </div>
	<div class="clear"></div>
	</div>
	
	<div class="fd">
	    <div class='left_div'>
	    <label for="enable_telephone_no_txtbox">
		<?php _e("Show enquiry button only when product is out of stock", "product-enquiry-for-woocommerce");?>
	    </label>
	    </div>
	    <div class='right_div'>
        <?php
            $helptip = __( 'Show enquiry button only when product is out of stock', 'product-enquiry-for-woocommerce' );
            echo wdmHelpTip($helptip);
        ?>
		<input type="checkbox" disabled class="wdm_wpi_input wdm_wpi_checkbox" value="1" id="enable_for_out_stock" />
            <?php echo $pro; ?>
	    </div>
	<div class="clear"></div>
	</fieldset>
	    <!-- <br> -->
	    <fieldset>
		    <legend><?php _e("Styling Options", "product-enquiry-for-woocommerce");?> </legend>
			<div class='fd'>
                <div class='left_div'>
                <label for="enable_telephone_no_txtbox">
                <?php _e("Custom Styling", "product-enquiry-for-woocommerce");?>
               </label>
                </div>
                <div class='right_div'>
                <input type="radio" class="wdm_wpi_input wdm_wpi_checkbox input-without-tip" value="theme_css" name="wdm_radio_data" id="theme_css" checked />
                <em> <?php _e("Use Activated Theme CSS", "product-enquiry-for-woocommerce");?> </em><br>
										 
                <input type="radio" class="wdm_wpi_input wdm_wpi_checkbox input-without-tip" value="manual_css" name="wdm_radio_data" id="manual_css" />
					
                <em><?php _e("Manually specify color settings", "product-enquiry-for-woocommerce");?></em>
              </div>
                <div class="clear"></div>
			</div>
	    </fieldset>  
	   <!-- <br /> -->
	   <div name="Other_Settings" id="Other_Settings" style="display: none;">
	    <fieldset style="padding: 0;">
		<?php echo '<legend>'. __("Specify CSS Settings ", 'product-enquiry-for-woocommerce').'</legend>';?>
	    <br />
		<div class="layer_parent">
		    <div class="pew_upgrade_layer">
			<div class="pew_uptp_cont">
            <p><?php _e(" This feature is available in the PRO version. Click below to know more. ", "product-enquiry-for-woocommerce");?></p>
			<a class="wdm_view_det_link" href="https://wisdmlabs.com/woocommerce-product-enquiry-pro/?utm_medium=in-product-clicks&utm_campaign=product-enquiry-free&utm_source=in-product-ads&utm_content=enquiry-settings-tab
" target="_blank"><?php _e("View Details ", "product-enquiry-for-woocommerce");?> </a>
			</div>
		    </div>
		    <img src="<?php echo plugins_url('img/buttons-css.png', __FILE__);?>" />
		</div>
	    </fieldset>
	    </div>
           <br>
	    <div id="available">
	    <div class="layer_parent">
		    <div class="pew_upgrade_layer">
           <div class="pew_uptp_cont">
            <p><?php _e(" This feature is available in the PRO version. Click below to know more. ", "product-enquiry-for-woocommerce");?></p>
			<a class="wdm_view_det_link" href="https://wisdmlabs.com/woocommerce-product-enquiry-pro/?utm_medium=in-product-clicks&utm_campaign=product-enquiry-free&utm_source=in-product-ads&utm_content=enquiry-settings-tab
" target="_blank"><?php _e("View Details ", "product-enquiry-for-woocommerce");?> </a>
			</div>
		   </div>	 
	    <fieldset>
		    <legend><?php _e("Enable/Disable Add to Cart for all Products", "product-enquiry-for-woocommerce");?> </legend>
            <img  src="<?php echo plugins_url('/img/img3.png', __FILE__); ?>" style='width:1048px;height:59px'/>
         </fieldset>
<!-- 	    <br />
	    <br> -->
	 <fieldset>
		    <legend><?php _e("Enable/Disable PEP for all Products", "product-enquiry-for-woocommerce");?> </legend>
			<img src="<?php echo plugins_url('/img/img2.png', __FILE__); ?>" style='width:953px;height:47px'/>
	  </fieldset>  
<!-- 	   <br />
	   <br> -->
	    <fieldset>
		    <legend><?php _e("Redirect Page URL", "product-enquiry-for-woocommerce");?> </legend>
	     <br>	
	     <img  src="<?php echo plugins_url('/img/img1.png', __FILE__); ?>" style='width:735px;height:68px'/>
         <br/> 
	    </fieldset>
    
	    </div>
	</div>
	   
	 <p>
            <input type="submit" class="wdm_wpi_input button-primary" value="Save Changes" id="wdm_ask_button" />
        </p>
        
	<br/>
     </form>
     
         <script type="text/javascript">
	jQuery(document).ready(
               function($)
               {
                $("#ask_product_form").validate();
					
                if($("#manual_css").is(':checked')) {
                    $("#Other_Settings").show();
                }
                else{
                   $("#Other_Settings").hide(); 
                }
					
                $("#theme_css").click(function(){$("#Other_Settings").hide();});
                $("#manual_css").click(function(){$("#Other_Settings").show();});
            }
            );
    </script>
	 
        <?php     } ?>
    </div>
        <?php
      //add styles for settings page
        wp_enqueue_style("wdm-admin-css", plugins_url("css/wpi_admin.css", __FILE__));
      
      //include WisdmLabs sidebar
    
        $plugin_data  = get_plugin_data(__FILE__);
        $plugin_name = $plugin_data['Name'];
        $wdm_plugin_slug = 'product-enquiry-for-woocommerce';
    
   // include_once('wisdm_sidebar/wisdm_sidebar.php');
   // pew_create_wisdm_sidebar($plugin_name, $wdm_plugin_slug);
}

add_action('wp_ajax_wdm_send', 'contact_email');
add_action('wp_ajax_nopriv_wdm_send', 'contact_email');
function contact_email()
{
         
    if (isset($_POST['security'])&&check_ajax_referer('enquiry_action', 'security', false)) {
        $form_data = get_option('wdm_form_data');
        $name = isset($_POST['wdm_name']) ? $_POST['wdm_name'] : "";
        $to = isset($_POST['wdm_emailid']) ? $_POST['wdm_emailid'] : "";
        $subject = (isset($_POST['wdm_subject'])&&!empty($_POST['wdm_subject'])) ? $_POST['wdm_subject'] :$form_data['default_sub'];
        $message = isset($_POST['wdm_enquiry']) ?  $_POST['wdm_enquiry'] : "";
        $cc = isset($_POST['wdm_cc']) ? $_POST['wdm_cc'] : "";
        $product_name=isset($_POST['wdm_product_name']) ? $_POST['wdm_product_name'] : "";
        $product_url = isset($_POST['wdm_product_url']) ? $_POST['wdm_product_url'] : "";
        $admin_email=get_option('admin_email');
        $site_name =get_bloginfo('name');
        $recipient_email=(!empty($form_data['user_email']))?$form_data['user_email']:"";
        if (empty($recipient_email)) {
            $recipient_email=$admin_email;
        }
        $authorEmail = $_POST['uemail'];

    //$group_emails = array($recipient_email,$admin_email);
        $headers = "Reply-To: $to \n";    
    //UTF-8
        if (function_exists('mb_encode_mimeheader')) {
            $subject = mb_encode_mimeheader($subject, "UTF-8", "B", "\n");
        } else {
            // you need to enable mb_encode_mimeheader or risk
            // getting emails that are not UTF-8 encoded
        }
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=utf-8\n";
        // $headers .= "Content-Transfer-Encoding: quoted-printable\n";
    
    // Set and wordwrap message body
        $body = __('Product Enquiry from', 'product-enquiry-for-woocommerce')." <strong>". $site_name . "</strong> <br /><br />";
        $body .= "<strong>".__('Product Name:', 'product-enquiry-for-woocommerce')."</strong> '". $product_name ."'<br /><br />";
        $body .= "<strong>".__('Product URL:', 'product-enquiry-for-woocommerce')."</strong> ". $product_url ."<br /><br />";
        $body .= "<strong>".__('Customer Name:', 'product-enquiry-for-woocommerce')."</strong> ". $name ."<br /><br />";
        $body .= "<strong>".__('Customer Email:', 'product-enquiry-for-woocommerce')."</strong> ". $to ."<br /><br />";
        $body .= "<strong>".__('Message:', 'product-enquiry-for-woocommerce')."</strong> <br />". $message;

        $adminMailBody = $body;
        $linkStatement = sprintf(__('%s Learn More %s', 'product-enquiry-for-woocommerce'), "<a href='https://wisdmlabs.com/woocommerce-product-enquiry-pro/?utm_source=in-product-ads&utm_medium=in-product-clicks&utm_content=admin-enquiry-email&utm_campaign=product-enqiry-free'>", "</a>");
        // $linkStatement = "<a href='https://wisdmlabs.com/woocommerce-product-enquiry-pro/'> Upgrade to Pro </a>";
        $premiumMail = "<br><hr>";
        $premiumMail .= "<p>" . __('Checkout Product Enquiry Pro for these <b>PREMIUM</b> features' , 'product-enquiry-for-woocommerce') .": </p>";
        $premiumMail .= "<ul>
                        <li> " . __('View all enquiries in dashboard' , 'product-enquiry-for-woocommerce') . "</li>
                        <li>" . __('Support for Variable Products', 'product-enquiry-for-woocommerce') . "</li>
                        <li>" . __('Receive enquiries for multiple products, at once', 'product-enquiry-for-woocommerce') . "</li>
                        <li>" . __('Send out consolidated quotes', 'product-enquiry-for-woocommerce') . "</li>
                </ul>";

        $premiumMail .= $linkStatement;

        $adminMailBody .= $premiumMail;
        $adminMailBody = wordwrap($adminMailBody, 100);
        $send_mail=wp_mail($recipient_email, $subject, $adminMailBody, $headers); //or  die(__("Unfortunately, a server issue prevented delivery of your message.","product-enquiry-for-woocommerce"));
        if (isset($authorEmail) && $authorEmail != $recipient_email) {
            wp_mail($authorEmail, $subject, $body, $headers);
        }
    
        if ($send_mail) {
            _e("Enquiry was sent succesfully", "product-enquiry-for-woocommerce");
            if ($cc == 1) {
                wp_mail($to, $subject, wordwrap($body, 100), $headers);
            }        
        } else {
       
            _e("Unfortunately, a server issue prevented delivery of your message.", "product-enquiry-for-woocommerce");
        }
        die();
    }
    
    die(__("Unauthorized access.", "product-enquiry-for-woocommerce"));
      
}

add_action('admin_init', 'reg_form_settings');

function reg_form_settings()
{
    //register plugin settings
    register_setting('wdm_form_options', 'wdm_form_data');
}

add_action('admin_footer', 'wdm_action_javascript'); // Write our JS below here

function wdm_action_javascript()
{
    if (isset($_GET["page"]) && $_GET["page"] == "product-enquiry-for-woocommerce") { ?>
    <script type="text/javascript" >
    jQuery(document).ready(function($) {
    jQuery(".wdm-req-button").click(function() {
    var data = {};
    data.email = $(this).siblings(".wdm-req-text").val();
    data.id = $(this).siblings( ".id" ).val();
    data.updates = $(this).siblings(".wdm-req-confirm").prop("checked");
    data.action = "wdm_pe_action";
    var email = $(this).siblings(".wdm-req-text").val();
    var txt = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!txt.test(email)) {
    $(this).siblings("input.wdm-req-text").css('border','1px solid red');
    e.preventDefault();
    } else {
    $(this).siblings("input.wdm-req-text").css('border','1px solid #ccc');
    }
    var id = $(this).siblings( ".id" ).val();
    var loading = $(this).siblings(".loading").show();
    // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
    $.post(ajaxurl, data, function(response) {
    //alert('Got this from the server: ' + response + '<br>id is :' + ids);
    var id = jQuery.trim(response);
    //jQuery(this).siblings('.wdm-req-title').hide();
    jQuery('.loading').hide();
    alert('Your request has been sent');
    jQuery(id).find("div.loading").hide();
    });
    });
    });
    </script>
    <?php
    }
}

add_action('wp_ajax_wdm_pe_action', 'wdm_pe_action_callback');

function wdm_pe_action_callback()
{
    global $wpdb; // this is how you get access to the database
    $email = $_POST['email'];
    $id = $_POST['id'];
    $updates = $_POST['updates'];
    $subscribes_message = "";
    $subscribes_message_client = "";
    if ($updates == "true") {
        $subscribes_message = __("And Congrats! They have subscribed to your newsletter too!", 'product-enquiry-for-woocommerce');
        $subscribes_message_client =__("We'll keep you updated with the latest developments.", 'product-enquiry-for-woocommerce');
    } else {
    //$subscribes_message = "Oh shoot! They haven't subscribed.";
    //$subscribes_message_client = "To stay up-to-date with the latest developments, do subscribe to our newsletter!";
    }
    $message =__("
Hi,A feature request has been made for Product enquiry free, by $email.Requested Feature: $id
$subscribes_message
Thanks and Regards,This is an automated mail, sent by WisdmLabs", "product-enquiry-for-woocommerce");

    $message_client = sprintf(__("Hi there, \n\nThank you for requesting the %s feature for Product Enquiry for WooCommerce.We will keep you updated with the latest developments. \n\nThanks and Regards,\nWisdmLabs", "product-enquiry-for-woocommerce"), $id);

//echo $email . " id is --:" . $id;
    wp_mail('support@wisdmlabs.com', 'PE Feature Request', $message);
//mail for client
    $client_header[] = 'From: WisdmLabs <donotreply@wisdmlabs.com>';
    wp_mail($email, 'Your Feature Request Has Been Sent!', $message_client, $client_header);
    echo "." . $id;
    die(); // this is required to terminate immediately and return a proper response
}

function checkIfNoData($fileData, $current_response_code, $valid_response_code)
{
    if ($fileData == null || ! in_array($current_response_code, $valid_response_code)) {
        $GLOBALS[ 'wdm_server_null_response' ] = true;
        return false;
    }
    return true;
}

function wdmHelpTip($helptip)
{
    $wooVersion = WC_VERSION;
    $wooVersion = floatval($wooVersion);
    if ($wooVersion < 2.5) {
        return '<img class="help_tip" data-tip="' . esc_attr($helptip) . '" src="' . WC()->plugin_url() . '/assets/images/help.png" height="16" width="16" />';
    } else {
        return wc_help_tip($helptip);
    }
}
?>