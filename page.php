<?php
// here get header usign this function
get_header();

// here get token using this 
$token = $_COOKIE['token'];
echo get_theme_file_uri();
// echo $token;
// echo gettype($token);

// $request = new WP_REST_Request( 'GET', '/wp/v2/posts' );
// $response = rest_do_request( $request );

// echo '<pre>';
// print_r($response);
// echo '</pre>';

// echo do_shortcode('[mostsell terms="laptop,shoes"]');


global $wpdb;
$tablename='cart';

// here get id using this functions
$id = get_current_user_id();

// $existing_cart = $wpdb->get_row("SELECT * FROM cart WHERE cart_user_id = '$token'");
$user = $wpdb->get_results( "SELECT * FROM $tablename WHERE cart_user_id = '$token'" );

echo '<pre>';
// print_r($wpdb);
// print_r($user);
echo '</pre>';


$cart = array();
if (isset($_SESSION['cart_json'])) {
    $cart = json_decode($_SESSION['cart_json'], true);
}


echo '<pre>';
print_r($cart);
echo '</pre>';

foreach ($cart as $val) {
    $product_id=$val['product_id'];
    $quantity = $val['quantity'];
}

if ($user) {    
    $json_string = $user[0]->session_data;
    $data = maybe_unserialize($json_string);

    // print_r($data[0]['product_id']);
    // print_r($data[0]['quantity']);
    // print_r($data[0]['stock']);

    $cart[] = array(
        'product_id' => $data[0]['product_id'],
        'quantity' => $data[0]['quantity'],
        'stock' => $data[0]['stock'],
    );

    echo '<pre>';
    // print_r($data);
    echo '</pre>';
}

// $query = new WP_Query( array( 'post_type' => 'products') );
// $query = new WP_Query( array( 'posts_per_page' => 3 ) );

echo '<pre>';
// print_r($query);
echo '</pre>';


?>

<div class="main-header">
    <h1>This is the PAGE.PHP Page</h1>
</div>

<div><button class="banana">Banana</button></div>



<h1>
<?php 
// Displays or retrieves the current post title
// the_title();
?>
</h1>

<?php 

// the_post_thumbnail(array(500,500)); // Displays the post thumbnail.
// the_content(); // Displays the post content.

// $imagepath = wp_get_attachment_image_src(get_post_thumbnail_id(),'medium');
// print_r($imagepath);
// echo get_the_content();
?>

<!-- <img src="<?php echo $imagepath[0];?>" width="200" alt=""> -->


<?php
get_footer();
?>


<button id="your-custom-button-id" class="button">Upload File</button>
<input type="text" id="selected-image" name="selected-image" readonly /> 


<!-- 

function handle_checkout_form_submission(){
    // ... (rest of the function remains the same)

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
            'sell_count' => 1, // Initialize sell count to 1
        ),
    );

    $order_id = wp_insert_post($order_data);

    // ... (rest of the function remains the same)
}

To increment the sell count when the user places another order, you can add a check to see if the user has previously placed an order. If they have, you can retrieve the old sell count value and increment it by 1. Here's an updated version of the handle_checkout_form_submission function:

function handle_checkout_form_submission(){
    // ... (rest of the function remains the same)

    $user_id = get_current_user_id();
    $previous_orders = get_posts(array(
        'post_type' => 'orders',
        'post_status' => 'publish',
        'author' => $user_id,
    ));

    if ($previous_orders) {
        $previous_order = array_shift($previous_orders);
        $previous_sell_count = get_post_meta($previous_order->ID, 'sell_count', true);
        $new_sell_count = intval($previous_sell_count) + 1;
    } else {
        $new_sell_count = 1;
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
            'sell_count' => $new_sell_count,
        ),
    );

    $order_id = wp_insert_post($order_data);

    // ... (rest of the function remains the same)
}

This code checks if the user has previously placed an order by retrieving their previous orders using get_posts. If they have, it retrieves the old sell count value using get_post_meta and increments it by 1. If they haven't, it sets the sell count to 1. The new sell count value is then stored in the sell_count meta field of the new order.
-->