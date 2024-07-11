<?php

// Template Name: Add to cart Page

get_header();
?>



<!-- this is css for this file -->
<style>
        #nocart{
            height: calc(100vh - 97px);
            display: flex;
            flex-direction:column;
            justify-content: center;
            align-items:center;
            gap:10px;
        }
        .cartempty{
            font-size:30px;
        }
        input[type="submit"]{
            all: unset;
            border-radius:20px;
            padding: 10px 15px;
            border:none;
            cursor: pointer;
            background:#42446E;
            color:white;
        }
</style>



<?php
$cart = array();
// get cart json data form session
if (isset($_SESSION['cart_json'])) {
    $cart = json_decode($_SESSION['cart_json'], true);
}


// if cart is not empty to go inside
if (!empty($cart)){ ?>
    <!-- this is css for this if only -->
    <style>
        #remove{
            width:20px;
            height:20px;
            background: red;
            color: white;
        }
        #check{
            /* all:unset; */
            width: 90px;
            margin: 10px 90px;
            text-align: center;
            line-height: 30px;
            border: 1px solid #ddd;
            background-color: #f2f2f2;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
            color: #333;
            border-radius: 4px;
        }
        h1{
            text-align: center;
        }
        .main{
            display: flex;
        }
        .cart-container {
            padding: 20px;
            margin: 20px auto;
            display: flex;
            border: 1px solid #000;
            width: 900px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .cart-item {
            padding: 16px;
            width: 800px;
            gap: 10px;
            display: flex;
            align-items: center;
        }
        .cart-item img {
            max-width: 100%;
            height: auto;
            margin-bottom: 16px;
        }
        .cart-item h3 {
            margin: 0 0 8px;
            font-size: 18px;
        }
        .cart-item .price {
            font-size: 16px;
            color: #555;
            margin-bottom: 8px;
        }
        .cart-item .quantity,
        .cart-item .stock {
            font-size: 14px;
            color: #888;
        }
        .quantity-form {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 8px;
        }
        .price1{
            display: flex;
            gap:10px;
        }

        .quantity-button {
            width: 30px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            border: 1px solid #ddd;
            background-color: #f2f2f2;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
            color: #333;
            border-radius: 4px;
        }

        .quantity-button:hover {
            background-color: #ddd;
        }

        .quantity-button:active {
            background-color: #ccc;
        }

        #quantity {
            width: 30px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            color: #333;
            background-color: #fff;
        }
        hr{
            margin: 0px 100px;
        }
        .bottom{
            /* display: flex; */
            border: 1px solid #000;
            margin: 20px;
        }
        .bottom h1{
            margin: 5px 100px;
        }
        .bottom button{
            margin: 5px 100px;
            padding: 2px 7px;
        }
        input[type="text"]{
            margin: 0;
            width: 30px;
            height: 12px;
            text-align: center;
            line-height: 30px;
            border: 1px solid #ddd;
            background-color: #f2f2f2;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
            color: #333;
            border-radius: 4px;

        }
        .cart-item .quantity{
            width: 30px;
            height: 12px;
            text-align: center;
            line-height: 30px;
            border: 1px solid #ddd;
            background-color: #f2f2f2;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
            color: #333;
            border-radius: 4px;
        }
        input[type="submit"] {
            all:unset;
            width: 30px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            border: 1px solid #ddd;
            background-color: #f2f2f2;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
            color: #333;
            border-radius: 4px;
        }
        
    </style>


<h1>Cart Details</h1>
<div class="main">
<div class="cart-container">
    <?php 
    $grand_total = 0;
    // usning foreach loop to show all item
    foreach ($cart as $item) {
        $p_id = $item['product_id'];
        $product_price = get_post_meta($p_id, 'price', true);
        $product = get_post($p_id);
        $subtotal = $product_price * $item['quantity']; 
        $grand_total += $subtotal; 
        ?>
        <div class="cart-item">
            <div class="price1">
                <?php echo get_the_post_thumbnail($p_id, array(110, 110)); ?>
                <div>
                    <h3><?php echo esc_html($product->post_title); ?></h3>
                    ₹<?php echo esc_html(number_format($product_price)); ?>
                </div>
            </div>
            <div>
                <form action="" method="post" class="quantity-form">
                    <input type="hidden" name="id" class="id" value="<?php echo esc_html($item['product_id']); ?>">
                    <input type="hidden" name="stock" class="stock" value="<?php echo esc_html($item['stock']); ?>">
                    <input type="hidden" name="price" class="price" value="<?php echo esc_html(number_format($product_price)); ?>">
                    <input type="submit" class="quantity-button decrement" value="-" name="decrement">
                    <input type="text" name="quantity" class="quantity" value="<?php echo esc_html($item['quantity']); ?>" readonly>
                    <input type="submit" class="quantity-button increment" name="increment" value="+">
                </form>
            </div>
            <p class="subtotal">Subtotal: ₹<?php echo esc_html(number_format($product_price * $item['quantity'])); ?></p>
        </div>
        <?php } ?>
    </div>

    <div class="bottom">
        <h1>Total</h1>
        <h2 class="total">₹<?php echo esc_html(number_format($grand_total)); ?></h2>
        <form method="post">
            <input type="submit" id="check" value="Check Out" name="checkout">
        </form>
    </div>
</div>

<?php } else { ?>
    <div id="nocart">
        <p class="cartempty">Your cart is empty</p>
        <form action="" method="post">
            <input type="submit" name="gopage" value="Go to Product Page">
        </form>
    </div>
<?php } ?>

<!-- <script>
    document.querySelectorAll('.cart-item').forEach(item => {
        const decrementButton = item.querySelector('.quantity-button.decrement');
        const incrementButton = item.querySelector('.quantity-button.increment');
        const quantityInput = item.querySelector('.quantity');
        const stock = item.querySelector('.stock');
        const price = item.querySelector('.price');
        const id = item.querySelector('.id');
        const subtotalElement = item.querySelector('.subtotal');
        
        const priceWithoutComma = price.value.replace(/,/g, '');

        function updateSubtotal() {
            const currentValue = parseInt(quantityInput.value);
            const subtotal = priceWithoutComma * currentValue;
            subtotalElement.textContent = 'Subtotal: ₹' + subtotal.toLocaleString();
            updateGrandTotal();
        }

        function updateGrandTotal() {
        let grandTotal = 0;
        document.querySelectorAll('.cart-item').forEach(item => {
            const price = item.querySelector('.price').value.replace(/,/g, '');
            const quantity = item.querySelector('.quantity').value;
            grandTotal += parseInt(price) * parseInt(quantity);
        });
        document.querySelector('.total').textContent = '₹' + grandTotal.toLocaleString();
        }


        decrementButton.addEventListener('click', () => {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
                updateSubtotal();
            }
        });

        incrementButton.addEventListener('click', () => {
            let currentValue = parseInt(quantityInput.value);
            let maxValue = parseInt(stock.value);
            if (currentValue < maxValue) {
                quantityInput.value = currentValue + 1;
                updateSubtotal();
            }
        });
    });
</script> -->

<?php get_footer(); ?>


