<?php
$first_name = get_post_meta(get_the_ID(), 'first_name', true);
$last_name = get_post_meta(get_the_ID(), 'last_name', true);
$address = get_post_meta(get_the_ID(), 'address', true);
$address_2 = get_post_meta(get_the_ID(), 'address_2', true);
$email = get_post_meta(get_the_ID(), 'email', true);
$zip = get_post_meta(get_the_ID(), 'zip', true);
$country = get_post_meta(get_the_ID(), 'country', true);
$payment_method = get_post_meta(get_the_ID(), 'payment_method', true);
$grand_total = get_post_meta(get_the_ID(), 'grand_total', true);
$cart = get_post_meta(get_the_ID(), 'cart', true);

get_header();
?>


<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: #333;
    }

    .container {
        width: 80%;
        margin-bottom: 100px;
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    header {
        text-align: center;
        margin-bottom: 20px;
    }

    h1 {
        font-size: 24px;
        color: #555;
    }

    .customer-info {
        text-align: center;
        margin-bottom: 20px;
    }

    .customer-info .customer-note {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #333;
    }

    .order-details {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        padding: 0 10px;
    }

    .address,
    .payment-details {
        width: 30%;
    }

    h3 {
        font-size: 16px;
        margin-bottom: 10px;
        color: #666;
    }

    .order-summary {
        margin-bottom: 20px;
        padding: 0 10px;
    }

    .order-summary p {
        margin-bottom: 10px;
        color: #666;
    }

    .order-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        padding: 10px;
        border-bottom: 1px solid #eaeaea;
    }

    .order-item img {
        width: 110px;
        height: 110px;
        object-fit: cover;
        border-radius: 4px;
        margin-right: 20px;
    }

    .order-item div {
        flex-grow: 1;
    }

    .order-item p {
        margin-bottom: 5px;
    }

    .order-item .price {
        font-weight: bold;
        color: #e60000;
    }

    .order-totals {
        text-align: right;
        font-weight: bold;
        font-size: 18px;
        color: #333;
    }
</style>


<div class="container">
        <header>
            <h1>ORDER CONFIRMATION</h1>
        </header>

        <section class="customer-info">
            <p class="customer-note">DEAR CUSTOMER</p>
            <p>Thank you for shopping</p>
        </section>

        <section class="order-details">
            <div class="address">
                <h3>BILLING ADDRESS</h3>
                <p>Mr. <?php echo $first_name . " " . $last_name; ?></p>
                <p><?php echo $address;?></p>
                <p><?php echo $zip . " " . $address_2;?></p>
                <p><?php echo $country;?></p>
            </div>

            <div class="address">
                <h3>DELIVERY ADDRESS</h3>
                <p>Mr. Name Surname</p>
                <p>Street, No</p>
                <p>ZIP City</p>
                <p>Country</p>
            </div>

            <div class="payment-details">
                <h3>PAYMENT DETAILS</h3>
                <p><?php echo $payment_method; ?></p>
            </div>
        </section>

        <section class="order-summary">
            <p>Order number: 00000000 | Date: 05.06.2013</p>

            <?php
                foreach ($cart as $item) { 
                    $p_id = $item['product_id'];
                    $product_price = get_post_meta($p_id, 'price', true);
                    $product = get_post($p_id);
                    ?>
            <div class="order-item">
                <?php echo get_the_post_thumbnail($p_id, array(110, 110)); ?>
                <div>
                    <p><?php echo esc_html($product->post_title); ?></p>
                    <p class="price">₹<?php echo esc_html(number_format($product_price)); ?> X <?php  echo esc_html($item['quantity']); ?></p>
                </div>
            </div>
            <?php } ?>
    
            <div class="order-totals">
                <p>TOTAL ₹<?php echo esc_html(number_format($grand_total)); ?></p>
            </div>
        </section>
</div>


<?php
get_footer();
?>

