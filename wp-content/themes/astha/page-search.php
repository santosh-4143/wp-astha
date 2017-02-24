<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * Template Name: search
 */
get_header();

global $wpdb;

if (isset($_POST['submit'])) {

    $cat_value = $_POST['cate'];
    $specialize_value = $_POST['specialize'];
    $location_value = $_POST['locate'];

    $advance_search_query = "SELECT asm.*,asl.master_data_id,asl.location_id,asl.id as asl_id,aslm.location_name,ascat.category_name as category_name FROM

        astha_search_masterdata asm 

	LEFT JOIN astha_search_category ascat
    
    	ON asm.category_id = ascat.id
        
	LEFT JOIN astha_search_location asl 
    
    	ON asm.id = asl.master_data_id
        
	LEFT JOIN astha_search_locationmaster aslm
    
    	ON aslm.id = asl.location_id where asm.type=" . $cat_value . " ";

    if (!empty($specialize_value)) {

        $advance_search_query .= "and asm.category_id=" . $specialize_value . " ";
    }
    if (!empty($location_value)) {

        $advance_search_query .= "and asl.location_id=" . $location_value;
    }
	
	//echo $advance_search_query;die;
    $search_results = $wpdb->get_results($advance_search_query, ARRAY_A);
    //print_r();
}
$upload_dir = wp_upload_dir();
$upload_url_alt = $upload_dir['baseurl'];
?>

<div class="banner_area">
    <div class="about_banner"> <img class="img-responsive" alt="pic" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/contact/banner.jpg"> </div>
</div>    
<div class="search_result_wrapper">
    <div class="container">
        <h1>Search Results</h1>
        <div class="search_result_wrap">
            <?php
            if (!empty($search_results)) {
                foreach ($search_results as $search_result) {
                    ?>
                    <div class="col-lg-6 col-sm-6">
                        <div class="search_result_box">
                            <div class="search_result_box_img">
                                <img src="<?php echo $upload_url_alt . '/' . $search_result['profile_image']; ?>" alt="images" class="img-responsive"> 
                            </div>
                            <div class="search_result_box_content">
                                <h3><?php echo $search_result['name']; ?><span>(<?php echo $search_result['category_name']; ?>)</span></h3>                                                      
                                <p><span>Location : <?php echo $search_result['location_name']; ?></span></p>
                                <p><span>contact no : <?php echo $search_result['phone']; ?></span></p>
                                <p><span>Description :</span> <?php echo $search_result['description']; ?></p>
                            </div>
                            <div class="clearfix"></div>
                        </div>    
                    </div>
                <?php }
            } else { ?>

                <!--404 section-->
                <div class="error_wrapper">
                    <div class="container">
                        <div class="error_wrap">
                            <div class="box">
                                <p><img alt="Obaju template" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon/404.png" class="img-responsive"></p>
                                <h3>We are sorry - No Search Found</h3>                               	
                                <p>To continue please use the <strong>Search form</strong> or <strong>Menu</strong> above.</p>
                                <a class="btn btn-primary" href="/"><i class="fa fa-home"></i> Go to Homepage</a>
                            </div>
                        </div>
                    </div>
                </div>   

                <?php } ?>

        </div>
    </div>
</div>

<?php
get_footer();
?>
