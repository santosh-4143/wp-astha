<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage astha
 * @since astha 1.0
 */
get_header();

?>
<!--banner_area-->
<div class="banner_area">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">


        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/banner/banner_1.jpg" alt="pic">
            </div>
            <div class="item">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/banner/banner_2.jpg" alt="pic">
            </div>
            <div class="item">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/banner/banner_3.jpg" alt="pic">
            </div>
            <div class="item">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/banner/banner_4.jpg" alt="pic">
            </div>
        </div>
    </div>
    <div class="banner_logo">
        <div class="container">
            <div class="lgo_icon">
                <a href="#"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/logo/icon_1.png" alt="pic"/></a>
            </div>
        </div>
    </div>

    <div class="advance_search">
        <div class="container">
            <div class="ad_search_one">
                <div class="ad_search_main">
                    <div class="ad_heading">
                        <h3>Find Your Doctor / Ambulance</h3>
                    </div>
                    <form method="post" action="/search">
                        <div class="add_three">                       
                            <div class="category">
                                <select class="se_1" name="cate" onchange="return autoSelection(this.value)">
                                    <option value="" >Category</option>
                                    <option value="1" >Doctor</option> 
                                    <option value="2" >Ambulance</option>
                                </select>
                            </div>
                            <div class="category_1">
                                <select class="se_1" id="specialization" name="specialize">
                                    <option value="" >Type</option>
                                </select>
                            </div>
                            <?php
                            $locations = $wpdb->get_results("SELECT distinct * FROM astha_search_locationmaster", ARRAY_A);
                            ?>
                            <div class="category_2">
                                <select class="se_2" name="locate">
                                    <option value=""><i class="fa fa-building"></i> Where ?</option>
                                    <?php
                                    foreach ($locations as $location) {
                                        ?>
                                        <option value="<?php echo $location['id']; ?>"><?php echo $location['location_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="category_3">
                                <input type="submit" value="Submit" name="submit" class="btn btn-primary su_1" >
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!--end Banner_area-->


<!--our_service-->
<div class="our_service">
    <div class="container">
        <div class="our_text_heading">
            <h3>Our Services</h3>
            <h6>Healthcare needs to reduce leakage, lower no shows,increase patient acquisition, improve operational efficiencies.openDr offers the most sophisticated self scheduling and registration solution for patients, providers and staffpowered by openSync, our innovative </h6>
        </div>

        <div class="three_boxes">
            <div id="owl-demo_1">
                <?php
                $args = array('post_type' => 'product', 'product_cat' => 'services', 'orderby' => 'rand');
                $loop = new WP_Query($args);
                while ($loop->have_posts()) : $loop->the_post();
                    global $product;
                    ?>
                    <div class="item">
                        <div class="box_1">
                            <div class="box_images">
                                <?php
                                if (has_post_thumbnail($loop->post->ID))
                                    echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog');
                                else
                                    echo '<img src="' . woocommerce_placeholder_img_src() . '" alt="Placeholder" width="300px" height="300px" />';
                                ?>
                            </div>
                            <div class="box_text">
                                <h3><?php the_title(); ?></h3>
                                <h6><?php
                                    $aa = $loop->post->post_excerpt;
                                    echo substr(strip_tags($aa), 0, 100) ;
                                    ?></h6>
                                <a href="<?php echo get_permalink($loop->post->ID) ?>"><button class="btn btn-primary v_1">View more</button></a>
                            </div>
                        </div>
                    </div>                
                <?php endwhile; ?>
                <?php wp_reset_query(); ?>                              
            </div>
        </div>
    </div>
</div>
<!--end Our_servioce-->

<!--our_instrument-->
<div class="our_instrument">
    <div class="container">
        <div class="row as_2">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="machine">
                    <div class="machine_heading">
                        <h3>Take a tour of our medical instrument In home</h3>
                    </div>

                    <div id="owl-demo">
                        <?php
                        $args = array('post_type' => 'product', 'product_cat' => 'instruments', 'orderby' => 'rand');
                        $loop = new WP_Query($args);
                        while ($loop->have_posts()) : $loop->the_post();
                            global $product;
                            ?>
                            <div class="item">
                                <a href="<?php echo get_permalink($loop->post->ID) ?>">
                                    <div class="slid_pic">
                                        <?php
                                        if (has_post_thumbnail($loop->post->ID))
                                            echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog');
                                        else
                                            echo '<img src="' . woocommerce_placeholder_img_src() . '" alt="Placeholder" width="300px" height="300px" />';
                                        ?>
                                    </div>
                                </a>
                            </div>
                        <?php endwhile; ?>
                        <?php wp_reset_query(); ?>                          
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="machine">
                    <div class="machine_heading">
                        <h3>At Home Health Equipment’s services include:</h3>
                    </div>
                    <div class="our_product">
                        <ul>
                            <?php
                            $args = array('post_type' => 'product', 'product_cat' => 'instruments', 'orderby' => 'rand');
                            $loop = new WP_Query($args);
                            while ($loop->have_posts()) : $loop->the_post();
                                global $product;
                                ?>
                                <li><?php the_title(); ?></li>
                            <?php endwhile; ?>
                            <?php wp_reset_query(); ?>

                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<!--end_our_instrument-->


<!--why_choose_us-->
<div class="why_choose_us">
    <div class="container">
        <div class="row as_3">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="left_why">
                    <div class="left_why_heading">
                        <h2>Why Choose us</h2>
                    </div>
                    <div class="why_pic">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/box/why_choose_us.jpg" alt="pic" class="img-responsive"/>
                    </div>
                    <div class="why_text">
                        <h4>Why we are the best</h4>
                        <ul class="left_why_1">
                            <li><i class="fa fa-check"></i> The staff is polite </li>
                            <li><i class="fa fa-check"></i> Nurses are caring </li>
                            <li><i class="fa fa-check"></i> Responds quickly</li>
                            <li><i class="fa fa-check"></i> Nurses are profesional</li>
                        </ul>

                        <ul class="left_why_1">
                            <li><i class="fa fa-check"></i> Staff protects privacy</li>
                            <li><i class="fa fa-check"></i> Mininum costs </li>
                            <li><i class="fa fa-check"></i> Friendly behaviour</li>
                            <li><i class="fa fa-check"></i> Excellent infrastructure</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="left_why">
                    <div class="left_why_heading">
                        <h2>Join Hands</h2>
                    </div>
                    <div class="why_pic">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/box/pic_8.jpg" alt="pic" class="img-responsive"/>
                    </div>
                    <div class="why_text">
                        <h4>Join with us</h4>
                        <h6> At Astha Medic Residental Medical Care, our business is to positively contribute to the health and wellness of our patients. We are a team of compassionate individuals, committed to providing a holistic healthcare experience to all who walk through our doors.</h6>
                        <h6> We are connected with a renounce  IT company named as Numerico Informatic System Pvt.Ltd.If you are seeking a meaningful profession with a purpose and wish to make a difference in people’s lives in the healthcare sector, do contact us with your resume.</h6>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--why_choose_us-->

<!--testimonials-->
<div class="testimonials">
    <div class="container">
        <div class="testimonials_heading">
            <h3>Testimonials</h3>
        </div>
        <div class="test_text">
            <div id="carousel-example-generic_1" class="carousel slide" data-ride="carousel">
                <!-- Wrapper for slides -->
                <div class="carousel-inner t_1" role="listbox">
                    <?php
                    global $wpdb;
                    $i = 1;
                    $upload_dir = wp_upload_dir();
                    $upload_url_alt = ( $upload_dir['baseurl'] . $upload_dir['subdir'] );
                    $testimonials = $wpdb->get_results("SELECT * FROM astha_testimonial", ARRAY_A);
                    foreach ($testimonials as $testimonial) {
                        ?>
                        <div class="item <?php
                        if ($i == 1) {
                            echo 'active';
                        }
                        ?>">
                            <div class="media m_1">
                                <div class="media-left media-middle">
                                    <a href="#">
                                        <img class="media-object img-circle" src="<?php echo $upload_url_alt . '/' . $testimonial['author_image']; ?>" alt="pic">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading heading"><?php echo $testimonial['testimonial_title']; ?></h4>
                                    <h6><?php echo $testimonial['testimonial_details']; ?></h6>
                                    <div class="owner_head">
                                        <h4><?php echo $testimonial['author_name']; ?></h4>
                                        <h6><?php echo $testimonial['author_designation']; ?></h6>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <?php
                        $i++;
                    }
                    ?>                    

                </div>
            </div>
        </div>
    </div>
</div>
<!--end Testimonials-->


<?php get_footer(); ?>
