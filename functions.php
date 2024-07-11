<?php

function start_session(){
    if (!session_id()) {
        session_start();
    }
}
add_action('init', 'start_session', 1);

add_theme_support('title-tag');
add_theme_support('post-thumbnails');
add_theme_support('custom-header');
add_theme_support('custom-background');

add_post_type_support('page', 'excerpt');



// ----------------------------------------------------------------------------------------



// here link script and css file 
function mb_scripts(){
    // Regiater styles.css file with Enqueue
    wp_enqueue_style('bt-style', get_theme_file_uri('/css/styles.css'), array(), '1.0');

    // Register jQuery CDN
    wp_register_script('jquery-cdn', 'https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js', array(), '3.7.1', true);

    // Enqueue jQuery CDN
    wp_enqueue_script('jquery-cdn'); 

    wp_enqueue_script('bt-style', get_theme_file_uri('/js/scripts.js'), array('jquery-cdn'), '1.0', true);

    wp_localize_script( 'bt-style', 'my_ajax_object', array( 
        'ajax_url' => admin_url( 'admin-ajax.php' ), 
    ));  
}
add_action('wp_enqueue_scripts', 'mb_scripts');


// -----------------------------------------------------------------------------------------



// add custom css for admin side file link
function enqueue_admin_styles(){
    wp_enqueue_style('admin-bt-style', get_theme_file_uri('/css/admin-styles.css'), array(), '1.0');
}
add_action('admin_enqueue_scripts', 'enqueue_admin_styles');



// ----------------------------------------------------------------------------------------



// register menu footer and nav manu
register_nav_menus(array(
    'main_menu' => 'Main Menu',
    'footer_menu' => 'Footer Menu',
));



// -----------------------------------------------------------------------------------------



// register a sidebar 
register_sidebar(
    array(
        'name' => 'Sidebar Location',
        'id' => 'sidebar',
    )
);



// -----------------------------------------------------------------------------------------



// custom pagination use anytime
// function admin_pagination(){
//     // store the current query object
//     global $wp_query;

//     $big = 9999999999;
//     $pages = paginate_links(array(
//         // Checks and cleans a URL
//         'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))), // URL for a given page number
//         'format' => '?paged=%#%',
//         'current' => max(1, get_query_var('paged')),
//         'total' => $wp_query->max_num_pages,
//         'type' => 'array',
//     ));

//     if (is_array($pages)) {
//         echo '<div class="custom-pagination"><ul class="pagination">';
//         foreach ($pages as $page) {
//             echo '<li>' . $page . '</li>';
//         }
//         echo '</ul></div>';
//     }
// }


// fully custom paginations here
function custom_pagination($total_pages, $current_page, $base_url) {
    $output = '<div class="custom-pagination"><ul class="pagination">';

    // Previous Page Link
    if ($current_page > 1) {
        $prev_page = $current_page - 1;
        $output .= '<li><a href="' . esc_url(add_query_arg('paged', $prev_page, $base_url)) . '">&laquo; Previous</a></li>';
    }

    // Page Number Links
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $current_page) {
            $output .= '<li class="active disabled"><a href="' . esc_url(add_query_arg('paged', $i, $base_url)) . '">' . $i . '</a></li>';
        } else {
            $output .= '<li><a href="' . esc_url(add_query_arg('paged', $i, $base_url)) . '">' . $i . '</a></li>';
        }
    }

    // Next Page Link
    if ($current_page < $total_pages) {
        $next_page = $current_page + 1;
        $output .= '<li><a href="' . esc_url(add_query_arg('paged', $next_page, $base_url)) . '">Next &raquo;</a></li>';
    }

    $output .= '</ul></div>';

    echo $output;
}



// -----------------------------------------------------------------------------------------



class Custom_Widgets extends WP_Widget{
    // Constructor
    public function __construct(){
        $widget_opt = array(
            'classname' => 'custom_widget',
            'description' => 'My Custom Widget',
        );
        parent::__construct('custom_widget', 'Custom Widget', $widget_opt);
    }

    // Widget Backend Form
    public function form($instance){
        // Retrieve previous values from instance or set default values
        $title = !empty($instance['title']) ? $instance['title'] : 'Default Title';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    // Updating widget and replacing old instances with new
    public function update($new_instance, $old_instance){
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }

    // Widget Frontend Display
    public function widget($args, $instance){
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
    }
}


// Register the widget
function register_custom_widgets(){
    register_widget('Custom_Widgets');
}
add_action('widgets_init', 'register_custom_widgets');


class least_post extends WP_Widget{
    public function __construct(){
        parent::__construct('least_post', 'Least Post', array('description' => 'Least Post Widget'));
    }

    public function form($instance){
        $selected_post = !empty($instance['selected_post']) ? $instance['selected_post'] : '';

        // Get the latest posts
        $args = array(
            'posts_per_page' => 10,
            'orderby' => 'date',
            'order' => 'DESC',
        );
        $recent_posts = get_posts($args);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('selected_post'); ?>">Select a Post:</label>
            <select class="widefat" id="<?php echo $this->get_field_id('selected_post'); ?>" name="<?php echo $this->get_field_name('selected_post'); ?>">
                <?php
                foreach ($recent_posts as $post) {
                    $selected = ($post->ID == $selected_post) ? 'selected="selected"' : '';
                    echo '<option value="' . $post->ID . '" ' . $selected . '>' . esc_html($post->post_title) . '</option>';
                }
        ?>
            </select>
        </p>
        <?php
    }

    // Updating widget and replacing old instances with new
    public function update($new_instance, $old_instance){
        $instance = array();
        $instance['selected_post'] = (!empty($new_instance['selected_post'])) ? strip_tags($new_instance['selected_post']) : '';
        return $instance;
    }

    // Widget Frontend Display
    public function widget($args, $instance){
        if (!empty($instance['selected_post'])) {
            $post_id = $instance['selected_post'];
            $post = get_post($post_id);
            if ($post) {
                echo $args['before_title'] . apply_filters('widget_title', $post->post_title) . $args['after_title'];
                echo '<p>' . esc_html($post->post_excerpt) . '</p>';
                echo '<a href="' . get_permalink($post_id) . '">Read more</a>';
            }
        }
    }
}
add_action('widgets_init', function () { register_widget('least_post');});



// ----------------------------------------------------------------------------------------



// when page-signup page form submit to call this fucntion and add first time data
function handle_signup_form_submission(){
    if (isset($_POST['submit'])) {
        $firstname = sanitize_text_field($_POST['firstname']);
        $lastname = sanitize_text_field($_POST['lastname']);
        $username = sanitize_user($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $password = sanitize_text_field($_POST['password']);
        $phone = sanitize_text_field($_POST['phone']);
        $hobbies = isset($_POST['hobbies']) ? array_map('sanitize_text_field', $_POST['hobbies']) : array();
        $gender = sanitize_text_field($_POST['gender']);
        
        $userdata = array(
            'user_login' => $username,
            'user_email' => $email,
            'user_pass' => $password,
            'first_name' => $firstname,
            'last_name' => $lastname,
        );

        // Insert user data
        $user_id = wp_insert_user($userdata);

        if (!is_wp_error($user_id)) {
            $phone_updated = add_user_meta($user_id, 'phone', $phone);
            $hobbies_updated = add_user_meta($user_id, 'hobbies', $hobbies);
            $gender_updated = add_user_meta($user_id, 'gender', $gender);

            if ($phone_updated && $hobbies_updated && $gender_updated) {
                wp_redirect(home_url('/login'));
                exit;
            } else {
                $error_message = 'There was an error saving your data. Please try again.';
            }
        } else {
            $error_message = $user_id->get_error_message();
        }
    }
}
// add_action('init', 'handle_signup_form_submission');



// ----------------------------------------------------------------------------------------



// when page-edit-user page form submit to call this function and update user data
function handle_edituser_form_submission(){
    if (isset($_POST['update'])) {
        $firstname = sanitize_text_field($_POST['firstname']);
        $lastname = sanitize_text_field($_POST['lastname']);
        $username = sanitize_user($_POST['username']);
        $email = sanitize_email($_POST['email']);
        // $password = sanitize_text_field($_POST['password']);
        $phone = sanitize_text_field($_POST['phone']);
        $hobbies = isset($_POST['hobbies']) ? array_map('sanitize_text_field', $_POST['hobbies']) : array();
        $gender = sanitize_text_field($_POST['gender']);
        $user_id = sanitize_text_field($_POST['user_id']);

        // set a role
        $make_admin = isset($_POST['make_admin']) ? true : false;
        $user = new WP_User($user_id);

        if ($make_admin) {
            $user->set_role('custom_role');
        } else {
            $user->set_role('subscriber');
        }

        $user = get_user_by('login', $username);

        if ($user) {
            $userdata = array(
                'ID' => $user->ID,
                'user_email' => $email,
                'first_name' => $firstname,
                'last_name' => $lastname,
                'user_login' => $username,
            );

            $user_id = wp_update_user($userdata);

            if (!is_wp_error($user_id)) {
                update_user_meta($user_id, 'phone', $phone);
                update_user_meta($user_id, 'hobbies', $hobbies);
                update_user_meta($user_id, 'gender', $gender);

                wp_redirect(home_url('/user-list'));
                exit;
            } else {
                $error_message = $user_id->get_error_message();
            }
        } else {
            $error_message = 'User not found.';
        }
    }
}
// add_action('init', 'handle_edituser_form_submission');



// ----------------------------------------------------------------------------------------



// add new user role in admin side
add_role(
    'custom_role',
    'Custom Role',
    array(
        'read' => true,
        'delete_posts' => true,
        'edit_posts' => true,
        'edit_pages' => true,
    )
);



// -----------------------------------------------------------------------------------------



// diff add_action va add_filter check
// function add_custom_footer_message()
// {
//     echo '<p>Custom footer message.</p>';
// }
// add_action('wp_footer', 'add_custom_footer_message');


// function my_custom_content_filter($content)
// {
//     $custom_content = '<p>Custom text added before the content.</p>' . $content;
//     return $custom_content;
// }
// add_filter('the_content', 'my_custom_content_filter');


// function my_custom_title_filter($content) {
//     $custom_content = '<p class="custom_title">Jay Ramoliya</p>' . $content;
//     return $custom_content;
// }
// add_filter('the_title', 'my_custom_title_filter');



// -----------------------------------------------------------------------------------------



// register custom post type products
function create_custom_post_type(){
    $supports = array(
        'title', // post title
        'editor', // post content
        'author', // post author
        'thumbnail', // featured images
        'excerpt', // post excerpt
        'custom-fields', // custom fields
        'comments', // post comments
        'revisions', // post revisions
        'post-formats', // post formats
    );

    $labels = array(
        'name' => _x('Products', 'Post Type General Name', 'blog'), // left side inside top corner
        'singular_name' => _x('Product', 'Post Type Singular Name', 'blog'),
        'menu_name' => _x('Products', 'blog'), // main first sidebar name
        'name_admin_bar' => _x('Product', 'blog'), // plus vada icon inside
        'add_new' => _x('Add New', 'blog'), // main third sidebar and left side name ni bajuma
        'add_new_item' => __('Add New Product', 'blog'), // inside add page ma and when post upload left sidebar
        'view_item' => __('View Product'), // when post upload to left side bar
        'search_items' => __('Search Product'), // left side corner
        'new_item' => __('New Product'),
        'edit_item' => __('Edit Product'),
        'all_items' => __('All Product'),
        'not_found' => __('No Product found.'),
    );

    $args = array(
        'supports' => $supports,
        'labels' => $labels,
        'description' => 'Holds our Product and specific data',
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'can_export' => true,
        'capability_type' => 'post',
        'show_in_rest' => true,
        'query_var' => true,
        'hierarchical' => false,
        // 'taxonomies' => array('category', 'post_tag'),
        // 'menu_position' => 6,
        'public' => true,
        'rewrite' => array('slug' => 'products'),
        // 'has_archive' => false,
        'has_archive' => 'products-archive', // Enable archives and set the archive slug
    );

    register_post_type('products', $args);
}
add_action('init', 'create_custom_post_type');



// -----------------------------------------------------------------------------------------



// when user not login to store random string in cookies and login to store user id
function set_custom_cookies(){
    $id = get_current_user_id();

    if (!is_user_logged_in()) {
        if (!isset($_COOKIE['token'])) {
            $random_string = bin2hex(random_bytes(16)); // Generate a random string
            setcookie('token', $random_string, time() + (86400 * 30), '/'); // Set the cookie
        }
    }else{
        // setcookie('token', $id, time() + (86400 * 30), '/'); // Set the cookie
        $token = $_COOKIE['token'];
        $updatedAt = current_time( 'mysql' );

        global $wpdb;
        if (isset($token)) {
            $existing_cart = $wpdb->get_row("SELECT * FROM cart WHERE cart_user_id = '$token'");
            if ($existing_cart) {
                $wpdb->update('cart', array(
                    'cart_user_id' => $id,
                    'updatedAt' => $updatedAt
                ), array('cart_user_id' => $token));
            }
        }
        setcookie('token', $id, time() + (86400 * 30), '/'); // Set the cookie
    }

}
add_action('init','set_custom_cookies');



// -----------------------------------------------------------------------------------------



// create ragister a custom product_category taxonomies
function create_product_taxonomies(){
    $labels = array(
        'name' => _x('Product Categories', 'taxonomy general name'), // left side inside top corner
        'add_new_item' => __('Add New Category'), // inside top page ma and bottom page
        'menu_name' => __('Product Categories'), // main third sidebar name
        'singular_name' => _x('Category', 'taxonomy singular name'),
        'search_items' => __('Search Product Categories'),
        'all_items' => __('All Product Categories'),
        'parent_item' => __('Product Parent Category'), // label for parent
        'parent_item_colon' => __('Parent Product Category:'),
        'edit_item' => __('Edit Product Category'),
        'update_item' => __('Update Product Category'),
        'new_item_name' => __('New Product Category Name'),
    );

    register_taxonomy('product_category', array('products'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_rest' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'product-category'),
    ));
}
add_action('init', 'create_product_taxonomies', 0);



// -----------------------------------------------------------------------------------------



// add usermeta into admin side users -> profile page 
add_action('show_user_profile', 'display_user_custom_hash');
add_action('edit_user_profile', 'display_user_custom_hash');
add_action('personal_options_update', 'save_user_custom_hash');
add_action('edit_user_profile_update', 'save_user_custom_hash');

function display_user_custom_hash($user){?>
    <h3>Custom Information</h3>
    <table class="form-table">
        <tr>
            <th><label>Phone</label></th>
            <td>
                <input type="text" name="phone" value="<?php echo esc_attr(get_user_meta($user->ID, 'phone', true)); ?>" class="regular-text"/>
            </td>
        </tr>
        <tr>
            <th><label>Hobbies</label></th>
            <td>
                <select name="hobbies[]" multiple>
                    <?php
                        $hobbies = ['Reading', 'Traveling', 'Sports'];
                        $user_hobbies = get_user_meta($user->ID, 'hobbies', true);
                            foreach ($hobbies as $hobby) {
                                $selected = in_array($hobby, (array) $user_hobbies) ? 'selected="selected"' : '';
                                echo "<option value='$hobby' $selected>$hobby</option>";
                            }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label>Gender</label></th>
            <td>
                <select name="gender">
                    <?php
                        $genders = ['Male', 'Female', 'Other'];
                        $user_gender = get_user_meta($user->ID, 'gender', true);
                            foreach ($genders as $gender) {
                                $selected = $gender == $user_gender ? 'selected="selected"' : '';
                                echo "<option value='$gender' $selected>$gender</option>";
                            }
                    ?>
                </select>
            </td>
            </tr>
            <tr>
            <th><label>Profile Photo</label></th>
            <td>
                <?php 
                $photoid = get_user_meta($user->ID, 'photoid', true);
                if ($photoid) {
                    echo '<img src="' . wp_get_attachment_url( $photoid ) . '" alt="Profile Photo" style="max-width: 100px; display: block; margin-bottom: 10px;" />';
                }
                ?>
            </td>
        </tr>
    </table>
    <?php 
}


// when user change data in admin side and click update btn to store data in user_meta table
function save_user_custom_hash($user_id){
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    update_user_meta($user_id, 'phone', sanitize_text_field($_POST['phone']));

    $hobbies = array_map('sanitize_text_field', $_POST['hobbies']);
    update_user_meta($user_id, 'hobbies', $hobbies);

    update_user_meta($user_id, 'gender', sanitize_text_field($_POST['gender']));


}



// -----------------------------------------------------------------------------------------



// add register product price meta box 
function product_price_meta_box(){
    add_meta_box(
        'product_price_meta', // id
        __('Product Price'), // title
        'product_price_meta_box_callback', // callback function
        'products', // custom post type
    );
}
add_action('add_meta_boxes', 'product_price_meta_box');


// show custom product price meta box in admin side
function product_price_meta_box_callback($post){
    $Pricevalue = get_post_meta($post->ID, 'price', true);
    $salepricevalue = get_post_meta($post->ID, 'sale_price', true);
    $stockvalue = get_post_meta($post->ID, 'ecommerce_stock', true);
    ?>
    <label for="price">Product Price</label>
    <input type="text" id="price" name="price" value="<?php echo esc_attr($Pricevalue); ?>" /><br>

    <label for="sale_price">Sale Price</label>
    <input type="text" id="sale_price" name="sale_price" value="<?php echo esc_attr($salepricevalue); ?>" /><br>

    <label for="ecommerce_stock">Stock</label><br>
    <input type="number" id="ecommerce_stock" name="ecommerce_stock" value="<?php echo esc_attr($stockvalue); ?>" />
    <?php
}


// when product edit page update to store custom product price meta box data store in post_meta table
function save_product_price_meta_box_data($post_id){
    // Check and sanitize the price field
    if (isset($_POST['price'])) {
        $new_price_value = sanitize_text_field($_POST['price']);
        update_post_meta($post_id, 'price', $new_price_value);
    }
    if (isset($_POST['sale_price'])) {
        $new_sale_price_value = sanitize_text_field($_POST['sale_price']);
        update_post_meta($post_id, 'sale_price', $new_sale_price_value);
    }
    if (isset($_POST['ecommerce_stock'])) {
        $new_stock_value = intval($_POST['ecommerce_stock']);
        update_post_meta($post_id, 'ecommerce_stock', $new_stock_value);
    }
}
add_action('save_post', 'save_product_price_meta_box_data');



// ----------------------------------------------------------------------------------------



// when single-products page form submit to call this function and first time create a session
function handle_add_to_cart(){
    if (isset($_POST['quantitysub'])) {

        $product_id = sanitize_text_field($_POST['id']);
        $quantity = intval($_POST['quantity']);
        $stock = intval($_POST['stock']);
        $user_id = intval($_POST['user_id']);

        $cart = array(); // empty array

        if (isset($_SESSION['cart_json'])) {
            $cart = json_decode($_SESSION['cart_json'], true); // decodes it as a JSON object
        }

        $found = false;

        foreach ($cart as &$item) {
            if ($item['product_id'] === $product_id) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $cart[] = array(
                'product_id' => $product_id,
                'quantity' => $quantity,
                'stock' => $stock,
            );
        }

        $_SESSION['cart_json'] = json_encode($cart);

        $createdAt = current_time( 'mysql' );
        $updatedAt = current_time( 'mysql' );
        $token = $_COOKIE['token'];
       

        global $wpdb;
        if (isset($token)) {
            $existing_cart = $wpdb->get_row("SELECT * FROM cart WHERE cart_user_id = '$token'");
            if ($existing_cart) {
                $wpdb->update('cart', array(
                    'session_data' => serialize($cart),
                    'updatedAt' => $updatedAt
                ), array('cart_user_id' => $token));
            } else {
                $wpdb->insert('cart', array(
                    'cart_user_id' => $token,
                    'session_data' => serialize($cart),
                    'createdAt' => $createdAt,
                    'updatedAt' => $updatedAt
                ));
            }
        }
        
        wp_redirect(home_url('/add-to-cart/'));
        exit;
    }
}
add_action('template_redirect', 'handle_add_to_cart');



// ----------------------------------------------------------------------------------------



// when addtocart page + btn click to call this function and session quantity change 
function handle_checkout_inc(){
    if (isset($_POST['increment'])) {
        $product_id = sanitize_text_field($_POST['id']);
        $quantity = intval($_POST['quantity']);

        // $product_stock = get_post_meta($product_id, 'ecommerce_stock', true);
        // $new_quan = $product_stock + 1;
        // if ($new_quan) {
        //     // $new_stock_value = intval($_POST['ecommerce_stock']);
        //     update_post_meta($product_id, 'ecommerce_stock', $new_quan);
        // }

        $cart = array();

        if (isset($_SESSION['cart_json'])) {
            $cart = json_decode($_SESSION['cart_json'], true);
        }

        foreach ($cart as &$item) {
            if ($item['product_id'] === $product_id) {
                $item['quantity'] += 1;
                break;
            }
        }
        $_SESSION['cart_json'] = json_encode($cart);

        $createdAt = current_time( 'mysql' );
        $updatedAt = current_time( 'mysql' );
        $token = $_COOKIE['token'];
       
        global $wpdb;
        if (isset($token)) {
            $existing_cart = $wpdb->get_row("SELECT * FROM cart WHERE cart_user_id = '$token'");
            if ($existing_cart) {
                $wpdb->update('cart', array(
                    'session_data' => serialize($cart),
                    'updatedAt' => $updatedAt
                ), array('cart_user_id' => $token));
            } else {
                $wpdb->insert('cart', array(
                    'cart_user_id' => $token,
                    'session_data' => serialize($cart),
                    'createdAt' => $createdAt,
                    'updatedAt' => $updatedAt
                ));
            }
        }
    }
}
add_action('init', 'handle_checkout_inc');


// when addtocart page - btn click to call this function session quantity change
function handle_checkout_dec(){
    if (isset($_POST['decrement'])) {
        $product_id = sanitize_text_field($_POST['id']);
        $quantity = intval($_POST['quantity']);

        // $product_stock = get_post_meta($product_id, 'ecommerce_stock', true);
        // $new_quan = $product_stock - 1;
        // if ($new_quan) {
        //     // $new_stock_value = intval($_POST['ecommerce_stock']);
        //     update_post_meta($product_id, 'ecommerce_stock', $new_quan);
        // }

        $cart = array();

        if (isset($_SESSION['cart_json'])) {
            $cart = json_decode($_SESSION['cart_json'], true);
        }

        foreach ($cart as &$item) {
            if ($item['product_id'] === $product_id) {
                if ($item['quantity'] > 1) {
                    $item['quantity'] -= 1;
                }
                break;
            }
        }
        $_SESSION['cart_json'] = json_encode($cart);

        $createdAt = current_time( 'mysql' );
        $updatedAt = current_time( 'mysql' );
        $token = $_COOKIE['token'];
       
        global $wpdb;
        if (isset($token)) {
            $existing_cart = $wpdb->get_row("SELECT * FROM cart WHERE cart_user_id = '$token'");
            if ($existing_cart) {
                $wpdb->update('cart', array(
                    'session_data' => serialize($cart),
                    'updatedAt' => $updatedAt
                ), array('cart_user_id' => $token));
            } else {
                $wpdb->insert('cart', array(
                    'cart_user_id' => $token,
                    'session_data' => serialize($cart),
                    'createdAt' => $createdAt,
                    'updatedAt' => $updatedAt
                ));
            }
        }
    }
}
add_action('init', 'handle_checkout_dec');



// ---------------------------------------------------------------------------------------



// when addtocart page form submit to call this function and redirect page
function handle_checkout(){
    if (isset($_POST['checkout'])) {
        wp_redirect(home_url('/check-out/'));
        exit;
    }
}
add_action('template_redirect', 'handle_checkout');



// -----------------------------------------------------------------------------------------



// register custom post type orders
function create_custom_post_type_order(){
    $supports = array(
        'title', // post title
        'editor', // post content
        'author', // post author
        'thumbnail', // featured images
        'excerpt', // post excerpt
        'custom-fields', // custom fields
        'comments', // post comments
        'revisions', // post revisions
        'post-formats', // post formats
    );

    $labels = array(
        'name' => _x('Orders', 'Post Type General Name', 'blog'), // left side inside top corner
        'singular_name' => _x('Order', 'Post Type Singular Name', 'blog'),
        'menu_name' => _x('Orders', 'blog'), // main first sidebar name
        'name_admin_bar' => _x('Order', 'blog'), // plus vada icon inside
        'add_new' => _x('Add New', 'blog'), // main third sidebar and left side name ni bajuma
        'add_new_item' => __('Add New Order', 'blog'), // inside add page ma and when post upload left sidebar
        'view_item' => __('View Order'), // when post upload to left side bar
        'search_items' => __('Search Order'), // left side corner
        'new_item' => __('New Order'),
        'edit_item' => __('Edit Order'),
        'all_items' => __('All Orders'),
        'not_found' => __('No Orders found.'),
    );

    $args = array(
        'supports' => $supports,
        'labels' => $labels,
        'description' => 'Holds our Orders and specific data',
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'can_export' => true,
        'capability_type' => 'post',
        'show_in_rest' => true,
        'query_var' => true,
        'hierarchical' => false,
        'public' => true,
        'rewrite' => array('slug' => 'orders'),
        'has_archive' => 'orders-archive', // Enable archives and set the archive slug
    );
    register_post_type('orders', $args);
}
add_action('init', 'create_custom_post_type_order');



// -----------------------------------------------------------------------------------------



// create a new post for custom post type order and store data when checkout page form submit
function handle_checkout_form_submission(){
    if (isset($_POST['checkout_submit'])) {

        $cart = array();
        if (isset($_SESSION['cart_json'])) {
            $cart = json_decode($_SESSION['cart_json'], true);
        }
        
        foreach ($cart as $val) {
            $product_id=$val['product_id'];
            $quantity = $val['quantity'];
            
            $product_stock = get_post_meta($product_id, 'ecommerce_stock', true);
            $sell_count = get_post_meta($product_id, 'sell_count', true);

            $new_quantity = $product_stock - $quantity;
            $new_sell_count = intval($sell_count) + $quantity;

            update_post_meta($product_id, 'sell_count', $new_sell_count);
            update_post_meta($product_id, 'ecommerce_stock', $new_quantity);
        }

        $id = sanitize_text_field($_POST['user_id']);
        $createdAt = current_time( 'mysql' );
        $updatedAt = current_time( 'mysql' );
        $token = $_COOKIE['token'];

        global $wpdb;
        if (isset($token)) {
            $existing_cart = $wpdb->get_row("SELECT * FROM cart WHERE cart_user_id = '$token'");
            if ($existing_cart) {
                $wpdb->update('cart', array(
                    'session_data' => serialize($cart),
                    'updatedAt' => $updatedAt
                ), array('cart_user_id' => $token));
            } else {
                $wpdb->insert('cart', array(
                    'cart_user_id' => $token,
                    'session_data' => serialize($cart),
                    'createdAt' => $createdAt,
                    'updatedAt' => $updatedAt
                ));
            }
        }

        $first_name = sanitize_text_field($_POST['first_name']);
        $last_name = sanitize_text_field($_POST['last_name']);
        $email = sanitize_email($_POST['email']);
        $address = sanitize_text_field($_POST['address']);
        $address_2 = sanitize_text_field($_POST['address_2']);
        $country = sanitize_text_field($_POST['country']);
        $state = sanitize_text_field($_POST['state']);
        $zip = sanitize_text_field($_POST['zip']);
        $payment_method = sanitize_text_field($_POST['payment_method']);


        $cart = array();
        if (isset($_SESSION['cart_json'])) {
            $cart = json_decode($_SESSION['cart_json'], true);
        }

        $order_data = array(
            'post_title' => 'Order - ' . $first_name . ' ' . $last_name,
            'post_type' => 'orders',
            'post_status' => 'publish',
            'meta_input' => array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'address' => $address,
                'address_2' => $address_2,
                'country' => $country,
                'state' => $state,
                'zip' => $zip,
                'payment_method' => $payment_method,
                'cart' => $cart,
                'grand_total' => calculate_grand_total($cart),
            ),
        );

        $order_id = wp_insert_post($order_data);

        if (!is_wp_error($order_id)) {
            wp_redirect(home_url('/check-out/'));
            exit;
        } else {
            wp_die('There was an error processing your order. Please try again.');
        }
    }
}
add_action('template_redirect', 'handle_checkout_form_submission');


// calculate total for show in admin side
function calculate_grand_total($cart){
    $grand_total = 0;
    foreach ($cart as $item) {
        $p_id = $item['product_id'];
        $product_price = get_post_meta($p_id, 'price', true);
        $grand_total += $product_price * $item['quantity'];
    }
    return $grand_total;
}



// ----------------------------------------------------------------------------------------



// when page-login form submit to call this function and login the user
function handle_login_form(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
        $username = sanitize_user($_POST['username']);
        $password = sanitize_text_field($_POST['password']);
    
        $credentials = array(
            'user_login'    => $username,
            'user_password' => $password,
            'remember'      => true,
        );  
    
        $user = wp_signon($credentials, false);
    
        if (is_wp_error($user)) {
            $login_errors = array($user->get_error_message());
        } else {
            wp_redirect(get_site_url());
            exit;
        }
    }
}
// add_action('template_redirect', 'handle_login_form');



// -----------------------------------------------------------------------------------------



// add register order info meta box
function order_info_meta_box(){
    add_meta_box(
        'order_info_meta', // id
        __('Order Info'), // title
        'order_info_meta_box_callback', // callback function
        'orders', // custom post type
    );
}
add_action('add_meta_boxes', 'order_info_meta_box');


// show custom box order info in admin side
function order_info_meta_box_callback($post){
    $first_name = get_post_meta($post->ID, 'first_name', true);
    $last_name = get_post_meta($post->ID, 'last_name', true);
    $email = get_post_meta($post->ID, 'email', true);
    $address = get_post_meta($post->ID, 'address', true);
    $zip = get_post_meta($post->ID, 'zip', true);
    $country = get_post_meta($post->ID, 'country', true);
    $state = get_post_meta($post->ID, 'state', true);
    $payment_method = get_post_meta($post->ID, 'payment_method', true);
    $status = get_post_meta($post->ID, 'status', true);

    ?>
    <p>First Name: <?php echo esc_attr($first_name); ?></p>
    <p>Last Name: <?php echo esc_attr($last_name); ?></p>
    <p>Email: <?php echo esc_attr($email); ?></p>
    <p>address: <?php echo esc_attr($address); ?></p>
    <p>State: <?php echo esc_attr($state); ?></p>
    <p>ZIP: <?php echo esc_attr($zip); ?></p>
    <p>Country: <?php echo esc_attr($country); ?></p>
    <p>Payment Method: <?php echo esc_attr($payment_method); ?></p>
    <p>Status: <?php echo esc_attr($status); ?></p>
    <?php
}



// -----------------------------------------------------------------------------------------



// add register cart info meta box
function cart_info_meta_box(){
    add_meta_box(
        'cart_info_meta', // id
        __('Cart Info'), // title
        'cart_info_meta_box_callback', // callback function
        'orders', // custom post type
    );
}
add_action('add_meta_boxes', 'cart_info_meta_box');


// show custom box cart info in admin side
function cart_info_meta_box_callback($post){
    $cart = get_post_meta($post->ID, 'cart', true);
    $grand_total = get_post_meta($post->ID, 'grand_total', true);
    ?>
    <table class="table">
        <thead class="thead">
            <tr>
                <td>Image</td>
                <td>Title</td>
                <td>Qty</td>
                <td>Price</td>
                <td>Subtotal</td>
            </tr>
        </thead>
        <tbody class="tbody">
            <?php
                $grand_total = 0;
                foreach ($cart as $item) {
                    $p_id = $item['product_id'];
                    $product_price = get_post_meta($p_id, 'price', true);
                    $product = get_post($p_id);
                    $subtotal = $product_price * $item['quantity'];
                    $grand_total += $subtotal;
                    ?>
                    <tr>
                        <td><?php echo get_the_post_thumbnail($p_id, array(110, 110)); ?></td>
                        <td><?php echo esc_html($product->post_title); ?></td>
                        <td><?php echo esc_html($item['quantity']); ?></td>
                        <td>₹<?php echo esc_html(number_format($product_price)); ?></td>
                        <td>₹<?php echo esc_html(number_format($subtotal)); ?></td>
                    </tr>
                    <?php } ?>
        </tbody>
    </table>
    <hr>
    <p style="text-align: right; margin-right:77px;">₹<?php echo esc_html(number_format($grand_total)); ?></p>
    <?php
}



// -----------------------------------------------------------------------------------------



// add a new columns in custom post type order 
function add_order_columns($columns){
    $columns['products'] = 'Products';
    $columns['price'] = 'Price';
    $columns['status'] = 'Status';
    return $columns;
}
add_filter('manage_orders_posts_columns', 'add_order_columns');


// add data in new columns in all order page 
function add_order_column_content($column, $post_id){
    // show products value in this column
    if ($column === 'products') {
        $cart = get_post_meta($post_id, 'cart', true);
        $grand_total = 0;
        foreach ($cart as $item) {
            $p_id = $item['product_id'];
            $product_price = get_post_meta($p_id, 'price', true);
            $product = get_post($p_id);
            $subtotal = $product_price * $item['quantity'];
            $grand_total += $subtotal;
            ?>
                <p><?php echo esc_html($product->post_title); ?> X <?php echo esc_html($item['quantity']); ?></p>
            <?php
        }
    }

    // show status value in this column
    if ($column === 'status') {
        // $status = get_post_meta($post_id, 'status', true);
        $status = get_post_status($post_id);
        echo $status;
    }

    // show price value in this column
    if ($column === 'price') {
        $cart = get_post_meta($post_id, 'cart', true);
        $grand_total = 0;
        foreach ($cart as $item) {
            $p_id = $item['product_id'];
            $product_price = get_post_meta($p_id, 'price', true);
            $product = get_post($p_id);
            $subtotal = $product_price * $item['quantity'];
            $grand_total += $subtotal;
            ?>
            <p>₹<?php echo esc_html(number_format($product_price)); ?></p>
        <?php
        }
    }
}
add_action('manage_orders_posts_custom_column', 'add_order_column_content', 10, 2);



// -----------------------------------------------------------------------------------------



// Registers a new post status like completed, processing, shipped
function my_custom_status_creation(){
    $statuses = array(
        'completed' => 'Completed',
        'processing' => 'Processing',
        'shipped' => 'Shipped',
    );

    foreach ($statuses as $status => $label) {
        register_post_status($status, array(
            'label' => _x($label, 'orders'),
            'label_count' => _n_noop("$label <span class=\"count\">(%s)</span>", "$label <span class=\"count\">(%s)</span>"),
            'public' => true,
            'exclude_from_search' => false,
            'show_in_admin_all_list' => true,
            'show_in_admin_status_list' => true,
        ));
    }
}
add_action('init', 'my_custom_status_creation');


// edit page dropdown add 
function add_to_post_status_dropdown(){
    global $post; // allowing access to the current post object
    if ($post->post_type != 'orders') {
        return false;
    }
    $statuses = array('completed', 'processing', 'shipped');
    $current_status_script = '';

    foreach ($statuses as $status) {
        // Checks if the current post status matches the looped status. If it does, it adds JavaScript code to update the current status display and select the corresponding option in the dropdown.
        $current_status_script .= ($post->post_status == $status) ? "jQuery('#post-status-display').text('" . ucfirst($status) . "'); jQuery('select[name=\"post_status\"]').val('$status');" : '';
    }

    echo "<script> 
        jQuery(document).ready(function() { " 
            . implode('', array_map(function ($status) {
                return "jQuery('select[name=\"post_status\"]').append('<option value=\"$status\">" . ucfirst($status) . "</option>');";
            }, $statuses)) . " " . $current_status_script . "

        jQuery('select[name=\"post_status\"]').on('change', function(){
            var new_status = jQuery(this).val();
            jQuery('#post_status').val(new_status);
            jQuery('#post').submit();
        });

    }); </script>";
}
add_action('post_submitbox_misc_actions', 'add_to_post_status_dropdown');


// quick edit page dropdown add
function custom_status_add_in_quick_edit(){
    global $post;
    if ($post->post_type != 'orders') {
        return false;
    }

    $statuses = array('completed', 'processing', 'shipped');

    echo "<script>
    jQuery(document).ready(function() {
        " . implode('', 
            array_map(function ($status) {
                return "jQuery('select[name=\"_status\"]').append('<option value=\"$status\">" . ucfirst($status) . "</option>');";
            }, $statuses)) . "
    });
    </script>";
}
add_action('admin_footer-edit.php', 'custom_status_add_in_quick_edit');


// display in archive page
function display_archive_state($states){
    global $post;

    // Check if the global $post is set and is an object
    if (!isset($post) || !is_object($post)) {
        return $states;
    }

    $arg = get_query_var('post_status');
    $statuses = array('completed', 'processing', 'shipped');

    foreach ($statuses as $status) {
        if ($arg != $status && $post->post_status == $status) {
            $states[] = ucfirst($status);
            break;
        }
    }

    return $states;
}
add_filter('display_post_states', 'display_archive_state');



// ------------------------------------------------------------------------------------



// when addtocart form submit to call this function and redirect the page
function handle_gopage_form(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['gopage'])) {
        wp_redirect(home_url('/product/'));
        exit;
    }
}
add_action('template_redirect', 'handle_gopage_form');



// -----------------------------------------------------------------------------------------



// add register sell count meta box 
function sell_count_meta_box(){
    add_meta_box(
        'sell_count', // id
        __('Sell Count'), // title
        'sell_count_meta_box_callback', // callback function
        'products', // custom post type
    );
}
add_action('add_meta_boxes', 'sell_count_meta_box');


// show custom sell count meta box in admin side
function sell_count_meta_box_callback($post){
    $sell_count = get_post_meta($post->ID, 'sell_count', true);
    ?>
    <label for="sell_count">Sell Count</label>
    <input type="text" id="sell_count" name="sell_count" value="<?php echo esc_attr($sell_count); ?>" /><br>
    <?php
}


// when product edit page update to store custom sell count meta box data store in post_meta table
function save_sell_count_meta_box_data($post_id){
    // Check and sanitize the price field
    if (isset($_POST['sell_count'])) {
        $sell_count = sanitize_text_field($_POST['sell_count']);
        update_post_meta($post_id, 'sell_count', $sell_count);
    }
}
add_action('save_post', 'save_sell_count_meta_box_data');



// -----------------------------------------------------------------------------------------



// Function to add subscribe text to posts and pages
function subscribe_link_shortcode() {
    return '<p>Custom Short Code Jay Ramoliya</p>';
}
add_shortcode('subscribe', 'subscribe_link_shortcode');


// Most sell count show inside short code 
function most_sell_count_product($atts){
    $terms = explode(',', $atts['terms']);
    $args = array(
        'post_type' => 'products',
        'posts_per_page' => -1,
        'meta_key' => 'sell_count',
        'orderby' => 'meta_value_num', 
        'order' => 'DESC',
        'tax_query' => array(
            array(
                'taxonomy' => 'product_category',
                'field'    => 'slug',
                'terms'    => $terms,
            ),
        ),
        // 'meta_key' => 'ecommerce_stock',
        // 'meta_value' => 0,
        // 'meta_compare' => '>',
    );
    
    $query = new WP_Query( $args );

    if ($query->have_posts()) {
        $output = '';
        $output .= '<div class="mostsell">';

        foreach ($query->posts as $product) {
            $id = $product->ID;
            $stock = get_post_meta($id, 'stock', true);
            $sale_price = get_post_meta($id, 'sale_price', true);
            $product_price = get_post_meta($id, 'product_price', true);
            $categories = get_the_category($id);
            
            $output .= '<div class="mostinside"><a href="' . get_permalink($id) . '" class="mosttitle">' . get_the_title($id) . '</a>' . get_the_post_thumbnail($id, 'thumbnail', array('class' => 'img-fluid')) . '</div>';
        }
        $output .= '</div>';
    }
    return $output; 
}


// Create a shortcode to display the top selling products
add_shortcode('mostsell', 'most_sell_count_product');



// -----------------------------------------------------------------------------------------



// here add custom meta box for taxonomy
add_action('product_category_add_form_fields', 'custom_product_category_add_meta_box');
add_action('product_category_edit_form_fields', 'custom_product_category_edit_meta_box');

function custom_product_category_add_meta_box($term) {
    ?>
    <div class="form-field term-group">
        <label for="custom-meta"><?php _e('Custom Meta', 'textdomain'); ?></label>
        <input type="text" id="custom-meta" name="custom_meta" value="" />
    </div>
    <?php
}

function custom_product_category_edit_meta_box($term) {
    $custom_meta = get_term_meta($term->term_id, 'custom_meta', true);
    ?>
    <tr class="form-field term-group">
        <th scope="row"><label for="custom-meta"><?php _e('Custom Meta', 'textdomain'); ?></label></th>
        <td>
            <input type="text" id="custom-meta" name="custom_meta" value="<?php echo esc_attr($custom_meta); ?>" />
        </td>
    </tr>
    <?php
}

add_action('created_product_category', 'save_custom_product_category_meta', 10, 2);
add_action('edited_product_category', 'save_custom_product_category_meta', 10, 2);

function save_custom_product_category_meta($term_id) {
    if (isset($_POST['custom_meta'])) {
        update_term_meta($term_id, 'custom_meta', sanitize_text_field($_POST['custom_meta']));
    }
}



// -----------------------------------------------------------------------------------------



// Add a new column in the product_category taxonomy
add_filter('manage_edit-product_category_columns', 'add_new_columns');
function add_new_columns($columns) {
    $columns['custom_meta'] = __('Custom Meta', 'textdomain');
    return $columns;
}


// Add data to the new column
function add_data_in_new_columns($content, $column_name, $term_id) {
    if ($column_name === 'custom_meta') {
        $custom_meta = get_term_meta($term_id, 'custom_meta', true);
        $content = $custom_meta ? $custom_meta : __('No Meta', 'textdomain');
    }
    return $content;
}
add_filter('manage_product_category_custom_column', 'add_data_in_new_columns', 10, 3);



// -----------------------------------------------------------------------------------------
// ALL AJAX CALL BELOW NOW



// -----------------------------------------------------------------------------------------



// this function call when user login to ajax call and page redirect home page
function login_form() {
    if (isset($_POST['action']) && $_POST['action'] == 'login_form') {
        $username = sanitize_user($_POST['username']);
        $password = sanitize_text_field($_POST['password']);
    
        $credentials = array(
            'user_login'    => $username,
            'user_password' => $password,
            'remember'      => true,
        );  
    
        $user = wp_signon($credentials, false);
    
        if (is_wp_error($user)) {
            wp_send_json_error(array('message' => $user->get_error_message()));
        } else {
            wp_send_json_success(array('redirect' => get_site_url()));
        }
    }
    
    wp_die();
}
add_action( 'wp_ajax_login_form', 'login_form' );
add_action( 'wp_ajax_nopriv_login_form', 'login_form' );



// -----------------------------------------------------------------------------------------



// this function call when new user signup to ajax call and page redirect login page
function signup_form(){
    if (isset($_POST['action']) && $_POST['action'] == 'signup_form') {

        $firstname = sanitize_text_field($_POST['firstname']);
        $photoid = sanitize_text_field($_POST['photoid']);
        $lastname = sanitize_text_field($_POST['lastname']);
        $username = sanitize_user($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $password = sanitize_text_field($_POST['password']);
        $phone = sanitize_text_field($_POST['phone']);
        $gender = sanitize_text_field($_POST['gender']);
        $hobbies = isset($_POST['multihobbies']) ? array_map('sanitize_text_field', $_POST['multihobbies']) : array();


        $userdata = array(
            'user_login' => $username,
            'user_email' => $email,
            'user_pass' => $password,
            'first_name' => $firstname,
            'last_name' => $lastname,
        );

        // Insert user data
        $user_id = wp_insert_user($userdata);

        if (!is_wp_error($user_id)) {
            $phone_updated = add_user_meta($user_id, 'phone', $phone);
            $hobbies_updated = add_user_meta($user_id, 'hobbies', $hobbies);
            $gender_updated = add_user_meta($user_id, 'gender', $gender);
            $gender_updated = add_user_meta($user_id, 'photoid', $photoid);

            if ($phone_updated && $hobbies_updated && $gender_updated) {
                wp_send_json_success(array('redirect' => home_url('/login')));
            } else {
                wp_send_json_error(array('message' => 'There was an error saving your data. Please try again.'));
            }
        } else {
            wp_send_json_error(array('message' => $user_id->get_error_message()));
        }

    }

    $uploaded_file = $_FILES['profile_photo'];
    // check file name is not empty 
    if (!empty($_FILES['profile_photo']['name'])) {
        $uploaded_file = $_FILES['profile_photo'];
        
        // here check error when error to send msg
        if ($uploaded_file['error'] !== UPLOAD_ERR_OK) {
            wp_send_json_error(array('message' => 'File upload error.'));
        }

        // this two path it allows us to use wp_handle_upload() functions
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        // update medatata, regenerate image sizes
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        // this is to file upload
        $upload = wp_handle_upload($uploaded_file, array('test_form' => false));

        if (isset($upload['error']) && !empty($upload['error'])) { // TT
            wp_send_json_error(array('message' => $upload['error']));
        } else {
            // when file upload done
            $attachment_id = wp_insert_attachment(array(
                'guid' => $upload['url'], 
                'post_mime_type' => $upload['type'],
                'post_title' => basename($upload['file']),
                'post_content' => '',
                'post_status' => 'inherit'
            ), $upload['file']);

            // Generate attachment metadata and update the database record
            $attach_data = wp_generate_attachment_metadata($attachment_id, $upload['file']);
            wp_update_attachment_metadata($attachment_id, $attach_data);

            wp_send_json_success(array('message' => 'File uploaded successfully.','photoid' => $attachment_id));
            // wp_send_json_success($attachment_id);
            // wp_send_json_success($attach_data);
        }
    } else {
        wp_send_json_error(array('message' => 'No file uploaded.'));
    }
}
add_action( 'wp_ajax_signup_form', 'signup_form' );
add_action( 'wp_ajax_nopriv_signup_form', 'signup_form' );



// -----------------------------------------------------------------------------------------



// this function call when edit user to ajax call and page redirect user list page
function edit_form(){
        $firstname = sanitize_text_field($_POST['firstname']);
        $lastname = sanitize_text_field($_POST['lastname']);
        $username = sanitize_user($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $phone = sanitize_text_field($_POST['phone']);
        $hobbies = isset($_POST['multihobbies']) ? array_map('sanitize_text_field', $_POST['multihobbies']) : array();
        $gender = sanitize_text_field($_POST['gender']);
        $user_id = sanitize_text_field($_POST['user_id']);

        // set a role
        $make_admin = isset($_POST['make_admin']) ? true : false;
        $user = new WP_User($user_id);

        if ($make_admin) {
            $user->set_role('custom_role');
        } else {
            $user->set_role('subscriber');
        }

        $user = get_user_by('login', $username);

        if ($user) {
            $userdata = array(
                'ID' => $user->ID,
                'user_email' => $email,
                'first_name' => $firstname,
                'last_name' => $lastname,
                'user_login' => $username,
            );

            $user_id = wp_update_user($userdata);

            if (!is_wp_error($user_id)) {
                update_user_meta($user_id, 'phone', $phone);
                update_user_meta($user_id, 'hobbies', $hobbies);
                update_user_meta($user_id, 'gender', $gender);

                wp_send_json_success(array('redirect' => home_url('/user-list')));
            } else {
                wp_send_json_error(array('message' => $user_id->get_error_message()));

            }
        } else {
            wp_send_json_error(array('message' => 'User not found.'));
        }

}
add_action( 'wp_ajax_edit_form', 'edit_form' );
add_action( 'wp_ajax_nopriv_edit_form', 'edit_form' );



// -----------------------------------------------------------------------------------------



// this function call when image upload to ajax call and store in database
function file_upload(){
    $uploaded_file = $_FILES['profile_photo'];

    // check file name is not empty 
    if (!empty($_FILES['profile_photo']['name'])) {
        $uploaded_file = $_FILES['profile_photo'];
        
        // here check error when error to send msg
        if ($uploaded_file['error'] !== UPLOAD_ERR_OK) {
            wp_send_json_error(array('message' => 'File upload error.'));
        }

        // this two path it allows us to use wp_handle_upload() functions
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        // update medatata, regenerate image sizes
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        // this is to file upload
        $upload = wp_handle_upload($uploaded_file, array('test_form' => false));

        if (isset($upload['error']) && !empty($upload['error'])) { // TT
            wp_send_json_error(array('message' => $upload['error']));
        } else {
            // when file upload done
            $attachment_id = wp_insert_attachment(array(
                'guid' => $upload['url'], 
                'post_mime_type' => $upload['type'],
                'post_title' => basename($upload['file']),
                'post_content' => '',
                'post_status' => 'inherit'
            ), $upload['file']);

            // Generate attachment metadata and update the database record
            $attach_data = wp_generate_attachment_metadata($attachment_id, $upload['file']);
            wp_update_attachment_metadata($attachment_id, $attach_data);

            wp_send_json_success(array('message' => 'File uploaded successfully.','photoid' => $attachment_id));
            // wp_send_json_success($attachment_id);
            // wp_send_json_success($attach_data);
        }
    } else {
        wp_send_json_error(array('message' => 'No file uploaded.'));
    }
    // wp_send_json_success($uploaded_file);


}
add_action( 'wp_ajax_file_upload', 'file_upload');
add_action( 'wp_ajax_nopriv_file_upload', 'file_upload');



// -----------------------------------------------------------------------------------------



// this function call when page change to ajax call and redirect page
// function paginations(){
//     if (isset($_POST['action']) && $_POST['action'] == 'paginations') {
//         $href = sanitize_user($_POST['href']);
//         wp_send_json_success($href);
//     }
// }
// add_action( 'wp_ajax_paginations', 'paginations');
// add_action( 'wp_ajax_nopriv_paginations', 'paginations');


function paginations() {
    if (isset($_POST['action']) && $_POST['action'] == 'paginations') {
        $href = sanitize_text_field($_POST['href']);

        parse_str(parse_url($href, PHP_URL_QUERY), $query_vars);
        $paged = isset($query_vars['paged']) ? intval($query_vars['paged']) : 1;

        $args = array(
            'posts_per_page' => 6,
            'paged' => $paged,
            'post_type' => 'products',
            'orderby' => array(
                'sell_count' => 'meta_value_num'
            ),
            'order' => 'DESC',
            'meta_query' => array(
                'ecom_stock' => array(
                    'key' => 'ecommerce_stock',
                    'value' => 0,
                    'compare' => '>',
                ),
                'sell_count' => array(
                    'key' => 'sell_count'
                )
            ),
        );

        $query = new WP_Query($args);

        $products = array();
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                $stock = get_post_meta(get_the_ID(), 'ecommerce_stock', true);
                $product_price = get_post_meta(get_the_ID(), 'price', true);
                $sale_price = get_post_meta(get_the_ID(), 'sale_price', true);
                $categories = get_the_terms(get_the_ID(), 'product_category');
                $category_names = array();

                if (!empty($categories) && !is_wp_error($categories)) {
                    foreach ($categories as $term) {
                        $category_names[] = esc_html($term->name);
                    }
                }

                $products[] = array(
                    'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
                    'title' => get_the_title(),
                    'stock' => $stock,
                    'product_price' => $product_price,
                    'sale_price' => $sale_price,
                    'categories' => $category_names,
                    'permalink' => get_the_permalink(),
                );
            }
        } else {
            $products[] = array('message' => 'No products found.');
        }

        $total_pages = $query->max_num_pages;
        $current_page = max(1, $paged);
        $base_url = home_url('/products/');

        ob_start();
        custom_pagination($total_pages, $current_page, $base_url);
        $pagination = ob_get_clean();

        wp_reset_postdata();

        wp_send_json_success(array('products' => $products, 'pagination' => $pagination));
    } else {
        wp_send_json_error(array('message' => 'Invalid request.'));
    }
}
add_action('wp_ajax_paginations', 'paginations');
add_action('wp_ajax_nopriv_paginations', 'paginations');



// -----------------------------------------------------------------------------------------



// the function call when add products to ajax call and page redirect products list page
function addproducts() {

    if (isset($_POST['action']) && $_POST['action'] == 'addproducts') {

        $name = sanitize_text_field($_POST['productname']);
        $price = $_POST['price'];
        $image = $_POST['image'];
        $sellprice = $_POST['sellprice'];
        $stock = $_POST['stock'];
        $description = sanitize_textarea_field($_POST['description']);
        $categories = isset($_POST['categories']) ? array_map('intval', $_POST['categories']) : [];

    
        if (!function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
        }
    
        $post_id = wp_insert_post(array(
            'post_title' => $name, 
            'post_content' => $description,
            'post_status' => 'publish',
            'post_type' => 'products'
        ));
    
        if (is_wp_error($post_id)) {
            wp_send_json_error(array('message' => $post_id->get_error_message()));
            wp_die();
        }
    
        update_post_meta($post_id, 'price', $price);
        update_post_meta($post_id, 'sale_price', $sellprice);
        update_post_meta($post_id, 'ecommerce_stock', $stock);

        wp_set_post_terms($post_id, $categories, 'product_category');
        set_post_thumbnail($post_id, $image);

        // if (!empty($_FILES['image']) && !$_FILES['image']['error']) {
        //     require_once(ABSPATH . 'wp-admin/includes/file.php');
        //     require_once(ABSPATH . 'wp-admin/includes/image.php');
        //     require_once(ABSPATH . 'wp-admin/includes/media.php');
    
        //     $attachment_id = media_handle_upload('image', $post_id);
        //     if (is_wp_error($attachment_id)) {
        //         wp_send_json_error(['message' => 'Error uploading image.']);
        //         return;
        //     }
        //     set_post_thumbnail($post_id, $attachment_id);
        // }
    
        wp_send_json_success(array('redirect' => home_url('/list-products')));
    
        wp_die();
    }
    
}
add_action('wp_ajax_addproducts', 'addproducts');
add_action('wp_ajax_nopriv_addproducts', 'addproducts');



// -----------------------------------------------------------------------------------------



// this function call when delete products to ajax call and page redirect products list page
function delete_product() {
    $product_id = intval($_POST['productid']);

    if (current_user_can("delete_post", $product_id)) {
        wp_delete_post($product_id);
        echo json_encode(array('status' => 'success', 'message' => 'Product successfully deleted!'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Failed to delete product.'));
    }
    wp_die();
}
add_action('wp_ajax_delete_product', 'delete_product');
add_action('wp_ajax_nopriv_delete_product', 'delete_product');



// -----------------------------------------------------------------------------------------



// this function call when edit products to ajax call and page redirect products list page
function editproducts() {
    if (isset($_POST['action']) && $_POST['action'] == 'editproducts') {

        if (isset($_POST['productid'])) {
            $productid = intval($_POST['productid']);
            if (has_post_thumbnail($productid)) {
                delete_post_thumbnail($productid);
            }
        }

        $id = intval($_POST['id']);
        $name = sanitize_text_field($_POST['productname']);
        $price = $_POST['price'];
        $image = $_POST['image'];
        $sellprice = $_POST['sellprice'];
        $stock = $_POST['stock'];
        $categories = isset($_POST['categories']) ? array_map('intval', $_POST['categories']) : [];    
        
        wp_update_post(array(
            'ID' => $id,
            'post_title' => $name,
        ));
    
        update_post_meta($id, 'price', $price);
        update_post_meta($id, 'sale_price', $sellprice);
        update_post_meta($id, 'ecommerce_stock', $stock);

        wp_set_post_terms($id, $categories, 'product_category');
        set_post_thumbnail($id, $image);

        // if (!empty($_FILES['image']) && !$_FILES['image']['error']) {
        //     require_once(ABSPATH . 'wp-admin/includes/file.php');
        //     require_once(ABSPATH . 'wp-admin/includes/image.php');
        //     require_once(ABSPATH . 'wp-admin/includes/media.php');
    
        //     $attachment_id = media_handle_upload('image', $id);
        //     if (is_wp_error($attachment_id)) {
        //         wp_send_json_error(['message' => 'Error uploading image.']);
        //         return;
        //     }
        //     set_post_thumbnail($id, $attachment_id);
        // }

        wp_send_json_success(array('redirect' => home_url('/list-products')));
    } else {
        wp_send_json_error(array('message' => 'Invalid request'));
    }
}
add_action('wp_ajax_editproducts', 'editproducts'); 
add_action('wp_ajax_nopriv_editproducts', 'editproducts');



// -----------------------------------------------------------------------------------------



function custom_media_enqueue() {
    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'custom_media_enqueue');
add_action('wp_enqueue_scripts', 'custom_media_enqueue');



// -----------------------------------------------------------------------------------------






// The user triggers an Ajax request, which is first passed to the admin-ajax.php file in the wp-admin folder.
// The Ajax request needs to supply at least one piece of data (using the GET or POST method). This request is called the action.
// The code in admin-ajax.php uses the action to create two hooks: wp_ajax_youraction and wp_ajax_nopriv_youraction. Here, youraction is the value of the GET or POST variable action.
// The first hook wp_ajax_youraction executes only for logged-in users, while the second hook wp_ajax_nopriv_youraction caters exclusively for logged-out users. If you want to target all users, you need to fire them both separately.


// what is a plugin?

// a wordpress plugin is a program or a set of one or more function written in the php scripting language, that adds a sprecific set of features or services to the wordpress site.

// create a plugin

// name file and locations

// plugin name unique name, minimum one php file, plugins/ inside







function save_custom_meta($post_id) {
    if (get_post_type($post_id) == 'products') {
        delete_transient('products_transient');
    }
}
add_action('save_post', 'save_custom_meta');


function count_blocks_on_post_save($post_id) {
    if (get_post_type($post_id) == 'products') {
        $post = get_post($post_id);
        $blocks = parse_blocks($post->post_content);
        $block_count = count($blocks);
        update_post_meta($post_id, 'block_count', $block_count);
    }
}
add_action('save_post', 'count_blocks_on_post_save');






// To count the number of blocks used in a post in the Gutenberg editor when the save_post hook is called, you can use the following code:

// function count_blocks_on_post_save($post_id) {
//   $post = get_post($post_id);
//   $blocks = parse_blocks($post->post_content);
//   $block_count = count($blocks);
//   // Do something with the count, like logging or updating a meta field
//   error_log("Post $post_id uses $block_count blocks.");
// }
// add_action('save_post', 'count_blocks_on_post_save');

// Here's how it works:

// 1. The save_post hook is triggered when a post is saved.
// 2. The count_blocks_on_post_save function is called, which retrieves the post content using get_post.
// 3. The parse_blocks function is used to parse the post content into an array of block objects.
// 4. The count function is used to count the number of blocks in the array.
// 5. The count is logged using error_log, but you can modify the code to do something else with the count, like updating a meta field.

// Note that this code uses the parse_blocks function, which is part of the Gutenberg API. This function takes the post content and returns an array of block objects, which can be counted using the count function.