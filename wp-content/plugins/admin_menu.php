<?php

/**
 * @package Admin menu
 * @version 3.6
 */
/*
  Plugin Name:Admin Menu Management
  Plugin URI: http://wordpress.org/extend/plugins/hello-dolly/
  Description: This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in two words sung most famously by Louis Armstrong: Hello, Dolly. When activated you will randomly see a lyric from <cite>Hello, Dolly</cite> in the upper right of your admin screen on every page.
  Author: Shib Shnakar Maji
  Version: 3.6
  Author URI: http://ma.tt/
 */

function adminForMenu() {

// Add a new top-level menu (ill-advised):
    add_menu_page(__('Site Manage', 'menu-test'), __('Site Manage', 'menu-test'), 'manage_options', 'mt-top-level-handle', 'mt_toplevel_page');

    /* view user details */
    add_submenu_page('mt-top-level-handle', 'view Customer Details', 'view Customer Details', 'manage_options', 'viewCustomer_details', 'viewCustomer_details');

    /* Add testimonial */
    add_submenu_page('mt-top-level-handle', 'Add Testimonial', 'Add Testimonial', 'manage_options', 'add_testimonial', 'add_testimonial');

    /* View patient resource Submission */
    add_submenu_page('mt-top-level-handle', 'View Testimonial', 'View Testimonial', 'manage_options', 'viewTestimonial', 'viewTestimonial');

    /* Add Search Category */
    add_submenu_page('mt-top-level-handle', 'Add Search Category', 'Add Search Category', 'manage_options', 'add_SearchCategory', 'add_SearchCategory');

    /* View Search Category */
    add_submenu_page('mt-top-level-handle', 'View Search Category', 'View Search Category', 'manage_options', 'view_SearchCategory', 'view_SearchCategory');

    /* Add Search Location */
    add_submenu_page('mt-top-level-handle', 'Add Search Location', 'Add Search Location', 'manage_options', 'add_SearchLocation', 'add_SearchLocation');

    /* View Search Location */
    add_submenu_page('mt-top-level-handle', 'View Search Location', 'View Search Location', 'manage_options', 'view_SearchLocation', 'view_SearchLocation');

    /* Add Search Details */
    add_submenu_page('mt-top-level-handle', 'Add Search Details', 'Add Search Details', 'manage_options', 'add_SearchDetails', 'add_SearchDetails');


    /* Add Search Details */
    add_submenu_page('mt-top-level-handle', 'View Search Details', 'View Search Details', 'manage_options', 'view_SearchDetails', 'view_SearchDetails');
}

function mt_toplevel_page() {
    echo "Manage";
}

function show_notice($str) {
    print '<DIV STYLE = "position:absolute; top: 15px; border:1px solid blue; width:90%; background:#CCFFFF;padding:10px; ">' . $str . '</DIV>';
}

/* customer details Form  */

function viewCustomer_details() {
    global $wpdb;
    $upload_dir = wp_upload_dir();
    $upload_url_alt = ( $upload_dir['baseurl'] . $upload_dir['subdir'] );

    /* delete  customer details */
    if (isset($_POST['delete'])) {
        $delete_query = "delete from project_astha.astha_users where id=" . $_POST['customer_id'];
        $delete_query1 = "delete from project_astha.astha_user_details where user_id=" . $_POST['customer_id'];
        $result1 = $wpdb->query($delete_query1);
        $result = $wpdb->query($delete_query);


        show_notice("customer details deleted Successfully.");
    }

    /* update  customer details */

    $customer_details = $wpdb->get_results("SELECT astha_users.id as main_user_id,astha_users.user_login,astha_users.user_email,astha_user_details.* FROM project_astha.astha_users inner join project_astha.astha_user_details on astha_users.id = astha_user_details.user_id", ARRAY_A);

    echo '<h2 style="text-align:center;font-size:30px" >View Customer Details</h2>';
    if (!empty($customer_details)) {
        echo '<center><table border="5" width="100%" style="text-align:center;padding:5px;">'
        . '<tr style="color:white;background:black">'
        . '<th>Serial No.</th>'
        . '<th>Username</th>'
        . '<th>Email</th>'
        . '<th>phone</th>'
        . '<th>address</th>'
        . '<th>Prescription Upload</th>'
        . '<th>Report File</th>'
        . '<th>Case History</th>'
        . '<th>Action</th>'
        . '</tr>';
        $serial_no = 1;
        foreach ($customer_details as $customer_detail) {
            echo '<form action="" method="post" enctype="multipart/form-data" >';
            echo '<tr>'
            . '<td>' . $serial_no . '</td>';
            echo '<td>' . $customer_detail['user_login'] . '</td>'
            . '<td>' . $customer_detail['user_email'] . '</td>'
            . '<td>' . $customer_detail['phone'] . '</td>'
            . '<td>' . $customer_detail['address'] . '</td>'
            . '<td> <a href="' . $upload_url_alt . '/' . $customer_detail['prescription_upload'] . '" download="' . $upload_url_alt . '/' . $customer_detail['prescription_upload'] . '"><img src="' . $upload_url_alt . '/1.png" width="28"></a></td>'
            . '<td> <a href="' . $upload_url_alt . '/' . $customer_detail['report_file'] . '" download="' . $upload_url_alt . '/' . $customer_detail['report_file'] . '"><img src="' . $upload_url_alt . '/1.png" width="28"></a></td>'
            . '<td>' . $customer_detail['case_history'] . '</td>'
            . '<td colspan="2"> '
            . '<input type="hidden" value="' . $customer_detail['main_user_id'] . '" name="customer_id">';
            echo '<input type="submit" name="delete" style="background:#c03e31;color:white" value="Delete" onclick = "return delfunc();">';
            echo '</td>'
            . '</tr> ';
            $serial_no++;
            echo '</form>';
        }
        echo '</table></center>';
    }
}

/* TESTIMONIAL Add Form  */

function add_testimonial() {

    global $wpdb;

    if (isset($_POST['addtestimonial'])) {
        $raves = array(
            'testimonial_title' => $_POST['testimonial_title'],
            'testimonial_details' => $_POST['testimonial_details'],
            'author_name' => $_POST['author_name'],
            'author_designation' => $_POST['author_designation']
        );
        if (isset($_FILES['profile_image']) && ($_FILES['profile_image']['size'] > 0)) {
            $arr_file_type = wp_check_filetype(basename($_FILES['profile_image']['name']));
            $uploaded_file_type = $arr_file_type['type'];
            $allowed_file_types = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png');
            if (in_array($uploaded_file_type, $allowed_file_types)) {
                $upload_overrides = array('test_form' => false);
                $uploaded_file = wp_handle_upload($_FILES['profile_image'], $upload_overrides);
            } else { // wrong file type
                $upload_feedback = 'Please upload only image files (jpg, gif or png).';
            }
            $raves['author_image'] = str_replace(' ', '-', $_FILES['profile_image']['name']);
        }

        $wpdb->insert('astha_testimonial', $raves, array('%s', '%s', '%s', '%s', '%s'));
        show_notice("Testimonial Successfully Added.");
    }

    /* TESTIMONIAL Add Form Form */
    echo '<center><h2 style = "margin-top: 80px;">Add Testimonial</h2>';
    echo '<form action="" method="POST" enctype="multipart/form-data">'
    . '<table class="" border="5">'
    . '<tr>'
    . '<td>Testimonial Name</td>'
    . '<td><input type="text" name="testimonial_title" value="" style="width:400px;" required></td>'
    . '</tr>'
    . '<tr>'
    . '<td>Testimonial Details </td>'
    . '<td><textarea class="wp-editor-area" style="width:400px;" autocomplete="off" cols="100" rows="" name="testimonial_details" id="content"></textarea></td>'
    . '</tr>'
    . '<tr>'
    . '<td>Author Image</td>'
    . '<td><input type="file" name="profile_image" value="" style="width:400px;" required></td>'
    . '</tr>'
    . '<tr>'
    . '<td>Author Name</td>'
    . '<td><input type="text" name="author_name" value="" style="width:400px;" required></td>'
    . '</tr>'
    . '<tr>'
    . '<td>Author Designation</td>'
    . '<td><input type="text" name="author_designation" value="" style="width:400px;" required></td>'
    . '</tr>'
    . '<tr colspan="2">'
    . '<td><input type="submit" name="addtestimonial" value="ADD TESTIMONIAL"/></td>'
    . '</tr>'
    . '</table>'
    . '</form></center>';
}

/* TESTIMONIAL view Form */

function viewTestimonial() {

    global $wpdb;
    $upload_dir = wp_upload_dir();
    $upload_url_alt = ( $upload_dir['baseurl'] . $upload_dir['subdir'] );

    /* delete  Testimonial */
    if (isset($_POST['delete'])) {
        $delete_query = "delete from astha_testimonial where id=" . $_POST['testimonial_id'];
        $result = $wpdb->query($delete_query);
        show_notice("testimonial deleted Successfully.");
    }

    /* TESTIMONIAL Details */

    $testimonial_lists = $wpdb->get_results("SELECT * FROM astha_testimonial", ARRAY_A);
    echo '<h2 style="text-align:center;font-size:30px" >Testimonial List</h2>';
    if (!empty($testimonial_lists)) {
        echo '<center><table border="5">'
        . '<tr style="color:white;background:black">'
        . '<th>Serial No.</th>'
        . '<th>Testimonial Name</th>'
        . '<th>Testimonial Details</th>'
        . '<th>Author Image</th>'
        . '<th>Author Name</th>'
        . '<th>Author Description</th>'
        . '<th>Action</th>'
        . '</tr>';
        $serial_no = 1;
        foreach ($testimonial_lists as $testimonial_list) {
            echo '<form action="" method="post" enctype="multipart/form-data" >';
            echo '<tr>'
            . '<td>' . $serial_no . '</td>'
            . '<td>' . $testimonial_list['testimonial_title'] . '</td>'
            . '<td>' . substr($testimonial_list['testimonial_details'], 0, 100) . '...</td>'
            . '<td><img src="' . $upload_url_alt . '/' . $testimonial_list['author_image'] . '" width="100px" height="100px"></td>'
            . '<td>' . $testimonial_list['author_name'] . '</td>'
            . '<td>' . $testimonial_list['author_designation'] . '</td>'
            . '<td colspan="2"> '
            . '<input type="hidden" value="' . $testimonial_list['id'] . '" name="testimonial_id">'
            . '<input type="submit" name="delete" style="background:#c03e31;color:white" value="Delete" onclick = "return delfunc();">'
            . '</td>'
            . '</tr> ';
            $serial_no++;
            echo '</form>';
        }
        echo '</table></center>';
    }
}

/* Search Category Add Form  */

function add_SearchCategory() {

    global $wpdb;

    if (isset($_POST['addCategory'])) {
        $category = array(
            'category_name' => $_POST['category_name'],
            'type' => $_POST['type']
        );
        $wpdb->insert('astha_search_category', $category, array('%s', '%s', '%s'));
        show_notice("Category Successfully Added.");
    }

    /*  Search Category Add Form  */
    echo '<center><h2 style = "margin-top: 80px;">Add Search Category</h2>';
    echo '<form action="" method="POST" enctype="multipart/form-data">'
    . '<table class="" border="5">'
    . '<tr>'
    . '<td>Category Name</td>'
    . '<td><input type="text" name="category_name" value="" style="width:400px;" required></td>'
    . '</tr>'
    . '<tr>'
    . '<td>Category Type</td>'
    . '<td><select name="type">'
    . '<option value="0">Select categoty</option>'
    . '<option value="1">Doctor</option>'
    . '<option value="2">Ambulance</option>'
    . '</select>'
    . '</td>'
    . '</tr>'
    . '<tr colspan="2">'
    . '<td><input type="submit" name="addCategory" value="ADD CATEGORY"/></td>'
    . '</tr>'
    . '</table>'
    . '</form></center>';
}

/* Search Category view Form  */

function view_SearchCategory() {

    global $wpdb;
    $upload_dir = wp_upload_dir();
    $upload_url_alt = ( $upload_dir['baseurl'] . $upload_dir['subdir'] );

    /* delete  Category */
    if (isset($_POST['delete'])) {

        $delete_query1 = "delete from astha_search_masterdata where category_id=" . $_POST['category_id'];
        $delete_query = "delete from astha_search_category where id=" . $_POST['category_id'];
        $result1 = $wpdb->query($delete_query1);
        $result = $wpdb->query($delete_query);

        show_notice("Category deleted Successfully.");
    }

    /* edit Category Details */
    if (isset($_POST['editCategory'])) {

        $cat_id = $_POST['cat_id'];

        $cat_update = array(
            'category_name' => $_POST['category_name'],
        );

        $cat_sql = "update astha_search_category set category_name ='" . $cat_update['category_name'] . "'";
        $cat_sql.= "where id=" . $cat_id;



        $run_raves_edit = $wpdb->query($cat_sql);
        show_notice("category Updated Successfully.");
    }

    /* Category Details */

    $category_lists = $wpdb->get_results("SELECT * FROM astha_search_category", ARRAY_A);
    echo '<h2 style="text-align:center;font-size:30px" >Category Lists</h2>';
    if (!empty($category_lists)) {
        echo '<center><table border="5">'
        . '<tr style="color:white;background:black">'
        . '<th>Serial No.</th>'
        . '<th>Category Type</th>'
        . '<th>Category Name</th>'
        . '<th>Action</th>'
        . '</tr>';
        $serial_no = 1;
        foreach ($category_lists as $category_list) {
            echo '<form action="" method="post" enctype="multipart/form-data" >';
            echo '<tr>'
            . '<td>' . $serial_no . '</td>';
            if ($category_list['type'] == 1) {
                echo '<td>Doctor</td>';
            } elseif ($category_list['type'] == 2) {
                echo '<td>Ambulance</td>';
            }
            echo '<td>' . $category_list['category_name'] . '</td>'
            . '<td colspan="2"> '
            . '<input type="hidden" value="' . $category_list['id'] . '" name="category_id">'
            . '<input type="submit" name="Edit" style="width:58px;background:#c03e31;color:white" value="Edit">'
            . '<input type="submit" name="delete" style="background:#c03e31;color:white" value="Delete" onclick = "return delfunc();">'
            . '</td>'
            . '</tr> ';
            $serial_no++;
            echo '</form>';
        }
        echo '</table></center>';
    }
    if (isset($_POST['Edit'])) {
        $category_id = $_POST['category_id'];
        $categories = $wpdb->get_results("SELECT * FROM astha_search_category where id=" . $category_id, ARRAY_A);

        /*  Search Category edit Form  */
        echo '<center><h2 style = "margin-top: 80px;">edit Search Category</h2>';
        echo '<form action="" method="POST" enctype="multipart/form-data">'
        . '<table class="" border="5">'
        . '<tr>'
        . '<td>Category Type</td>'
        . '<td><input type="text" name="c" value="';
        if ($categories[0]['type'] == 1) {
            echo 'Doctor';
        } elseif ($categories[0]['type'] == 2) {
            echo 'Ambulance';
        }
        echo '" style="width:400px;" readonly >'
        . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td>Category Name</td>'
        . '<td><input type="text" name="category_name" value="' . $categories[0]['category_name'] . '" style="width:400px;" required></td>'
        . '</tr>'
        . '<tr colspan="2">'
        . '<td><input type="hidden" value="' . $categories[0]['id'] . '" name="cat_id">'
        . '<td><input type="submit" name="editCategory" value="EDIT CATEGORY"/></td>'
        . '</tr>'
        . '</table>'
        . '</form></center>';
    }
}

/* Search location Add Form  */

function add_SearchLocation() {

    global $wpdb;

    if (isset($_POST['addLocation'])) {

        $location = array(
            'location_name' => $_POST['location_name']
        );
        $wpdb->insert('astha_search_locationmaster', $location, array('%s', '%s', '%s'));
        show_notice("Location Successfully Added.");
    }

    /*  Search Category Add Form  */
    echo '<center><h2 style = "margin-top: 80px;">Add Search Location</h2>';
    echo '<form action="" method="POST" enctype="multipart/form-data">'
    . '<table class="" border="5">'
    . '<tr>'
    . '<td>Location Name</td>'
    . '<td><input type="text" name="location_name" value="" style="width:400px;" required></td>'
    . '</tr>'
    . '<tr colspan="2">'
    . '<td><input type="submit" name="addLocation" value="ADD LOCATION"/></td>'
    . '</tr>'
    . '</table>'
    . '</form></center>';
}

/* View Search Location */

function view_SearchLocation() {

    global $wpdb;
    $upload_dir = wp_upload_dir();
    $upload_url_alt = ( $upload_dir['baseurl'] . $upload_dir['subdir'] );

    /* delete  Category */
    if (isset($_POST['delete'])) {

        $delete_query1 = "delete from astha_search_location where location_id=" . $_POST['location_id'];
        $delete_query = "delete from astha_search_locationmaster where id=" . $_POST['location_id'];
        $result1 = $wpdb->query($delete_query1);
        $result = $wpdb->query($delete_query);

        show_notice("location deleted Successfully.");
    }

    /* edit Category Details */
    if (isset($_POST['editLocation'])) {

        $locate_id = $_POST['locate_id'];

        $location_update = array(
            'location_name' => $_POST['location_name'],
        );

        $loc_sql = "update astha_search_locationmaster set location_name ='" . $location_update['location_name'] . "'";
        $loc_sql.= "where id=" . $locate_id;



        $run_raves_edit = $wpdb->query($loc_sql);
        show_notice("Location Updated Successfully.");
    }

    /* search location Details */

    $location_lists = $wpdb->get_results("SELECT * FROM astha_search_locationmaster", ARRAY_A);
    echo '<h2 style="text-align:center;font-size:30px" >Location Lists</h2>';
    if (!empty($location_lists)) {
        echo '<center><table border="5">'
        . '<tr style="color:white;background:black">'
        . '<th>Serial No.</th>'
        . '<th>Location</th>'
        . '<th>Action</th>'
        . '</tr>';
        $serial_no = 1;
        foreach ($location_lists as $location_list) {
            echo '<form action="" method="post" enctype="multipart/form-data" >';
            echo '<tr>'
            . '<td>' . $serial_no . '</td>';
            echo '<td>' . $location_list['location_name'] . '</td>'
            . '<td colspan="2"> '
            . '<input type="hidden" value="' . $location_list['id'] . '" name="location_id">'
            . '<input type="submit" name="Edit" style="width:58px;background:#c03e31;color:white" value="Edit">'
            . '<input type="submit" name="delete" style="background:#c03e31;color:white" value="Delete" onclick = "return delfunc();">'
            . '</td>'
            . '</tr> ';
            $serial_no++;
            echo '</form>';
        }
        echo '</table></center>';
    }
    if (isset($_POST['Edit'])) {
        $location_id = $_POST['location_id'];
        $locations = $wpdb->get_results("SELECT * FROM astha_search_locationmaster where id=" . $location_id, ARRAY_A);

        /*  Search location edit Form  */
        echo '<center><h2 style = "margin-top: 80px;">edit Search Location</h2>';
        echo '<form action="" method="POST" enctype="multipart/form-data">'
        . '<table class="" border="5">'
        . '<tr>'
        . '<td>Location Name</td>'
        . '<td><input type="text" name="location_name" value="' . $locations[0]['location_name'] . '" style="width:400px;" required></td>'
        . '</tr>'
        . '<tr colspan="2">'
        . '<td><input type="hidden" value="' . $locations[0]['id'] . '" name="locate_id">'
        . '<td><input type="submit" name="editLocation" value="EDIT LOCATION"/></td>'
        . '</tr>'
        . '</table>'
        . '</form></center>';
    }
}

/* Search details Add Form  */

function add_SearchDetails() {

    global $wpdb;

    if (isset($_POST['addDetails'])) {

        $detailsData = array(
            'type' => $_POST['type'],
            'category_id' => $_POST['specification'],
            'name' => $_POST['name'],
            'phone' => $_POST['phone'],
            'description' => $_POST['description']
        );
        if (isset($_FILES['profile_image']) && ($_FILES['profile_image']['size'] > 0)) {
            $arr_file_type = wp_check_filetype(basename($_FILES['profile_image']['name']));
            $uploaded_file_type = $arr_file_type['type'];
            $allowed_file_types = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png');
            if (in_array($uploaded_file_type, $allowed_file_types)) {
                $upload_overrides = array('test_form' => false);
                $uploaded_file = wp_handle_upload($_FILES['profile_image'], $upload_overrides);
            } else { // wrong file type
                $upload_feedback = 'Please upload only image files (jpg, gif or png).';
            }
            $detailsData['profile_image'] = str_replace(' ', '-', $_FILES['profile_image']['name']);
        }
        $insert = $wpdb->insert('astha_search_masterdata', $detailsData, array('%s', '%s', '%s', '%s', '%s', '%s'));

        if ($insert) {
            $lastid = $wpdb->insert_id;
            $los = $_POST['location'];
            if (!empty($los)) {
                foreach ($los as $lo) {
                    $location_data = array(
                        'master_data_id' => $lastid,
                        'location_id' => $lo
                    );
                    $insert1 = $wpdb->insert('astha_search_location', $location_data, array('%s', '%s', '%s'));
                }
            }

            show_notice("Entry Details Successfully Added.");
        }
    }
    /*  Search Category Add Form  */
    $type = '';
    if (isset($_GET['usertype'])) {
        $type = $_GET['usertype'];
        $categories = $wpdb->get_results("SELECT * FROM astha_search_category where type=" . $_GET['usertype'], ARRAY_A);
    } else {
        $categories = $wpdb->get_results("SELECT * FROM astha_search_category", ARRAY_A);
    }

    $locations = $wpdb->get_results("SELECT * FROM astha_search_locationmaster", ARRAY_A);
    echo '<center><h2 style = "margin-top: 80px;">Add Search Details</h2>';
    echo '<form action="" method="POST" enctype="multipart/form-data">'
    . '<table class="" border="5">'
    . '<tr>'
    . '<td>Type</td>'
    . '<td><select name="type" onchange="return catSelect(this.value);">'
    . '<option value="">Select categoty</option>'
    . '<option ';
    if ($type == 1) {
        echo 'selected ';
    }
    echo' value="1">Doctor</option>'
    . '<option ';
    if ($type == 2) {
        echo 'selected ';
    }
    echo'value="2">Ambulance</option>'
    . '</select>'
    . '</td>'
    . '</tr>'
    . '<tr>'
    . '<td>Specifications</td>'
    . '<td><select name="specification">'
    . '<option value="0">Select specification</option>';
    foreach ($categories as $category) {
        echo '<option value="' . $category['id'] . '">' . $category['category_name'] . '</option>';
    }
    echo '</select>'
    . '</td>'
    . '</tr>'
    . '<tr>'
    . '<td>Entry Name</td>'
    . '<td><input type="text" name="name" value="" style="width:400px;" required></td>'
    . '</tr>'
    . '<tr>'
    . '<td>Entry Image</td>'
    . '<td><input type="file" name="profile_image" value="" style="width:400px;" required></td>'
    . '</tr>'
    . '<tr>'
    . '<td>Entry Phone Number</td>'
    . '<td><input type="text" name="phone" value="" style="width:400px;" required></td>'
    . '</tr>'
    . '<tr>'
    . '<td>Entry Description</td>'
    . '<td><textarea name="description" required></textarea></td>'
    . '</tr>'
    . '<tr>'
    . '<td>Location</td>'
    . '<td><select name="location[]"  multiple="multiple" size="5" >';
    foreach ($locations as $location) {
        echo '<option value="' . $location['id'] . '">' . $location['location_name'] . '</option>';
    }
    echo '</select>'
    . '</td>'
    . '</tr>'
    . '<tr colspan="2">'
    . '<td><input type="submit" name="addDetails" value="ADD DETAILS"/></td>'
    . '</tr>'
    . '</table>'
    . '</form></center>';
}

function view_SearchDetails() {

    global $wpdb;
    $upload_dir = wp_upload_dir();
    $upload_url_alt = ( $upload_dir['baseurl'] . $upload_dir['subdir'] );

    /* delete  Category */
    if (isset($_POST['delete'])) {

        $delete_query1 = "delete from astha_search_location where master_data_id=" . $_POST['details_id'];
        $delete_query = "delete from astha_search_masterdata where id=" . $_POST['details_id'];
        $result1 = $wpdb->query($delete_query1);
        $result = $wpdb->query($delete_query);

        show_notice("Details deleted Successfully.");
    }

    /* edit search Details */
    if (isset($_POST['editEntry'])) {

        $det_id = $_POST['det_id'];

        $detailsData = array(
            'name' => $_POST['name'],
            'phone' => $_POST['phone'],
            'description' => $_POST['description']
        );
        if (isset($_FILES['profile_image']) && ($_FILES['profile_image']['size'] > 0)) {
            $arr_file_type = wp_check_filetype(basename($_FILES['profile_image']['name']));
            $uploaded_file_type = $arr_file_type['type'];
            $allowed_file_types = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png');
            if (in_array($uploaded_file_type, $allowed_file_types)) {
                $upload_overrides = array('test_form' => false);
                $uploaded_file = wp_handle_upload($_FILES['profile_image'], $upload_overrides);
            } else { // wrong file type
                $upload_feedback = 'Please upload only image files (jpg, gif or png).';
            }
            $detailsData['profile_image'] = str_replace(' ', '-', $_FILES['profile_image']['name']);
        }

        $details_sql = "update astha_search_masterdata set name='" . $detailsData['name'] . "',description='" . $detailsData['description'] . "',phone='" . $detailsData['phone'] . "'";
        if (!empty($_FILES['profile_image']['name'])) {
            $details_sql.= " ,profile_image='" . $detailsData['profile_image'] . "'";
        }

        $details_sql.= "where id=" . $det_id;

        $run_raves_edit = $wpdb->query($details_sql);
        show_notice("Details Updated Successfully.");
    }

    /* search Details */

    $details_lists = $wpdb->get_results("SELECT * FROM astha_search_masterdata", ARRAY_A);
    echo '<h2 style="text-align:center;font-size:30px" >Details Lists</h2>';
    if (!empty($details_lists)) {
        echo '<center><table border="5">'
        . '<tr style="color:white;background:black">'
        . '<th>Serial No.</th>'
        . '<th>Category Type</th>'
        . '<th>Entry Name</th>'
        . '<th>profile_image</th>'
        . '<th>phone</th>'
        . '<th>description</th>'
        . '<th>Action</th>'
        . '</tr>';
        $serial_no = 1;
        foreach ($details_lists as $details_list) {
            echo '<form action="" method="post" enctype="multipart/form-data" >';
            echo '<tr>'
            . '<td>' . $serial_no . '</td>';
            if ($details_list['type'] == 1) {
                echo '<td>Doctor</td>';
            } elseif ($details_list['type'] == 2) {
                echo '<td>Ambulance</td>';
            }
            echo '<td>' . $details_list['name'] . '</td>'
            . '<td><img src="' . $upload_url_alt . '/' . $details_list['profile_image'] . '" width="50px" height="50px"></td>'
            . '<td>' . $details_list['phone'] . '</td>'
            . '<td>' . $details_list['description'] . '</td>'
            . '<td colspan="2"> '
            . '<input type="hidden" value="' . $details_list['id'] . '" name="details_id">'
            . '<input type="submit" name="Edit" style="width:58px;background:#c03e31;color:white" value="Edit">'
            . '<input type="submit" name="delete" style="background:#c03e31;color:white" value="Delete" onclick = "return delfunc();">'
            . '</td>'
            . '</tr> ';
            $serial_no++;
            echo '</form>';
        }
        echo '</table></center>';
    }
    if (isset($_POST['Edit'])) {
        $details_id = $_POST['details_id'];
        $detailss = $wpdb->get_results("SELECT * FROM astha_search_masterdata where id=" . $details_id, ARRAY_A);

        /*  Search Category edit Form  */
        echo '<center><h2 style = "margin-top: 80px;">Edit entry Details</h2>';
        echo '<form action="" method="POST" enctype="multipart/form-data">'
        . '<table class="" border="5">'
        . '<tr>'
        . '<td>Category Type</td>'
        . '<td><input type="text" name="c" value="';
        if ($detailss[0]['type'] == 1) {
            echo 'Doctor';
        } elseif ($detailss[0]['type'] == 2) {
            echo 'Ambulance';
        }
        echo '" style="width:400px;" readonly >'
        . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td>Entry Name</td>'
        . '<td><input type="text" name="name" value="' . $detailss[0]['name'] . '" style="width:400px;" required></td>'
        . '</tr>'
        . '<tr>'
        . '<td>Entry Profile Image</td>'
        . '<td><input type="file" name="profile_image" value="" style="width:400px;"></td>'
        . '</tr>'
        . '<tr style="float:right;margin-right:-71px">'       
        . '<td><img src="' . $upload_url_alt . '/' . $detailss[0]['profile_image'] . '" width="50px" height="50px"></td>'
        . '</tr>'
        . '<tr>'
        . '<td>Entry Phone Number</td>'
        . '<td><input type="text" name="phone" value="' . $detailss[0]['phone'] . '" style="width:400px;" required></td>'
        . '</tr>'
        . '<tr>'
        . '<td>Entry Description</td>'
        . '<td><textarea name="description" required>' . $detailss[0]['description'] . '</textarea></td>'
        . '</tr>'
        . '<tr colspan="2">'
        . '<td><input type="hidden" value="' . $detailss[0]['id'] . '" name="det_id">'
        . '<td><input type="submit" name="editEntry" value="EDIT ENTRIES"/></td>'
        . '</tr>'
        . '</table>'
        . '</form></center>';
    }
}

add_action('admin_menu', 'adminForMenu');
?>
