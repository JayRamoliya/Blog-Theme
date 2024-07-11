<?php
/* Template Name: Checkout Page */

get_header();
$cart = array();

if (isset($_SESSION['cart_json'])) {
    $cart = json_decode($_SESSION['cart_json'], true);
}
$id = get_current_user_id();
echo $id;

echo '<pre>';
print_r($cart);
echo '</pre>';

// echo serialize($cart);

// $enco = json_encode($cart);
// print_r($enco);

// echo "current_time( 'mysql' ) returns local site time: " . current_time( 'mysql' ) . '<br />';
// echo "current_time( 'mysql', 1 ) returns GMT: " . current_time( 'mysql', 1 ) . '<br />';
// echo "current_time( 'timestamp' ) returns local site time: " . date( 'Y-m-d H:i:s', current_time( 'timestamp', 0 ) );
// echo "current_time( 'timestamp', 1 ) returns GMT: " . date( 'Y-m-d H:i:s', current_time( 'timestamp', 1 ) );

?>


<style>
    body {
        background-color: #f8f9fa;
    }

    .checkout-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .checkout-form {
        display: flex;
        flex-direction: row;
        flex: 1;
    }

    .billing-address, .payment {
        flex: 2;
        margin-right: 20px;
    }

    .cart-summary {
        flex: 1;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
    }

    h2 {
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-group input, .form-group select, .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .form-group input[type="checkbox"], .form-group input[type="radio"] {
        width: auto;
        margin-right: 10px;
    }

    .cart-summary ul {
        list-style-type: none;
        padding: 0;
    }

    .cart-summary ul li {
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
    }

    .checkout-button {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 12px 24px;
        font-size: 16px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 100%;
    }

    .checkout-button:hover {
        background-color: #218838;
    }

    .checkout-button:active {
        background-color: #1e7e34;
    }

    .checkout-button:focus {
        outline: none;
        box-shadow: 0 0 0 4px rgba(40, 167, 69, 0.5);
    }
</style>

<div class="checkout-container">
    <form action="" method="post" class="checkout-form">
        <input type="hidden" name="user_id" value="<?php echo $id; ?>">
        <div class="billing-address">
            <h2>Billing address</h2>
            <div class="form-group">
                <label for="first-name">First name</label>
                <input type="text" id="first-name" name="first_name" value='ramoliya'>
            </div>
            <div class="form-group">
                <label for="last-name">Last name</label>
                <input type="text" id="last-name" name="last_name" value="jay">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="ramoliya@gmail.com">
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" value="rajkot">
            </div>
            <div class="form-group">
                <label for="address-2">Address 2 (Optional)</label>
                <input type="text" id="address-2" name="address_2">
            </div>
            <div class="form-group">
                <label for="country">Country</label>
                <select id="country" name="country" required>
                    <option value="">Choose...</option>
                    <option value="India">India</option>
                </select>
            </div>
            <div class="form-group">
                <label for="state">State</label>
                <select id="state" name="state" required>
                    <option value="">Choose...</option>
                    <option value="gujrat">Gujrat</option>
                </select>
            </div>
            <div class="form-group">
                <label for="zip">Zip</label>
                <input type="text" id="zip" name="zip" value="360370">
            </div>
        </div>

        <div class="payment">
            <h2>Payment</h2>
            <div class="form-group">
                <input type="radio" id="credit-card" name="payment_method" value="credit_card" >
                <label for="credit-card">Credit card</label>
                <input type="radio" id="cod" name="payment_method" value="COD" >
                <label for="cod">Cash On Delivery</label>
            </div>
        </div>

        <div class="cart-summary">
            <h2>Your cart</h2>
            <ul>
                <?php
                $grand_total = 0;
                foreach ($cart as $item) { 
                    $p_id = $item['product_id'];
                    $product_price = get_post_meta($p_id, 'price', true);
                    $product = get_post($p_id);
                    $subtotal = $product_price * $item['quantity'];
                    $grand_total += $subtotal;  
                    ?>
                <li><?php echo esc_html($product->post_title); ?><span>₹<?php echo esc_html(number_format($product_price * $item['quantity'])); ?></span></li>
                <li>Quantity: <?php echo esc_html($item['quantity']); ?></li>
                <hr>
                <?php } ?>
                <li>Total (INR): <span>₹<?php echo esc_html(number_format($grand_total)); ?></span></li>
            </ul>
            <input type="submit" name="checkout_submit" value="Place Order" class="checkout-button">
        </div>
    </form>
</div>

<?php
get_footer();
?>

