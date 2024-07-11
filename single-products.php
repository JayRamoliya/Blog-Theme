<?php
session_start();
$product_price = get_post_meta(get_the_ID(), 'price', true);
$sale_price = get_post_meta(get_the_ID(), 'sale_price', true);
$product_stock = get_post_meta(get_the_ID(), 'ecommerce_stock', true);
$sell_count = get_post_meta(get_the_ID(), 'sell_count', true);
echo gettype($sell_count);
$id = get_current_user_id();
// echo $id;

$cart = array(); // empty array

if (isset($_SESSION['cart_json'])) {
    $cart = json_decode($_SESSION['cart_json'], true); // decodes it as a JSON object
}

// print_r($cart);

// if (!is_user_logged_in()) {
//     if (!isset($_COOKIE['token'])) {
//         $random_string = bin2hex(random_bytes(16)); // Generate a random string
//         setcookie('token', $random_string, time() + (86400 * 30), '/'); // Set the cookie
//     }
// }

get_header();
?>

<div class="main-header">
    <h1>This is the SINGLE-POSTTYPE.PHP Page</h1>
</div>

<style>
    
    .main{
        display: flex;
        margin: 10px auto;
        width: 80%;
        /* border: 1px solid pink; */
    }
    .left {
        width: 100%;
        height: 500px;
        overflow: hidden;
        /* border: 1px solid red; */
        margin: auto 10px;
    }

    .left img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .right{
        /* border: 1px solid green; */
    }
    .down{
        /* border: 1px solid black; */
        margin: 10px;
        padding: 20px;
        margin-left: 30px;
        padding: 0 20px;
    }
    .center{
        margin: 10px;
        padding: 20px;
    }
    h1{
        text-align: center;
        padding: 10px;
    }
    p{
        margin: 10px;
    }
    .left img:hover {
        transform: scale(1.05);
        transition: transform 0.3s;
    }
    .conten li{
        /* list-style-type:none; */
        margin: 10px;
    }
    .price{
        font-size: 20px;
        color: green;
        margin-left: 30px;
    }
    .stock{
        font-size: 15px;
        margin-left: 30px;
    }
    input[type="submit"] {
        width: 100px;
        padding: 10px;
    }
    input[type="number"] {
        width: 100px;
        padding: 9px;
        margin-left: 30px;
    }
</style>

    <div class="main">
        <div class="left">
            <?php the_post_thumbnail();?>
        </div>
        <div class="right">
            <div class="top">
                <h1>
                    <?php the_title();?>
                </h1>
            </div>
            <div class="center">
                <p class="price">Price: <?php echo number_format($product_price);?></p>
                <p class="stock">Stock: <?php echo $product_stock;?></p>
                <form method="post">
                    <input type="hidden" name="user_id" value="<?php echo $id;?>">
                    <input type="hidden" name="stock" value="<?php echo $product_stock;?>">
                    <input type="hidden" name="id" value="<?php the_id();?>">
                    <input type="number" name="quantity" value="1" min="1" max="<?php echo $product_stock;?>" step="1">
                    <input type="submit" name="quantitysub" value="Add to Cart" class="submitbtn">
                </form>
            </div>
            <div class="down">
                <p class="conten"><?php the_content();?></p>
            </div>
        </div>
    </div>

<?php
get_footer();
?>


<?php
// comments_template();
// comment_form();
?>

<?php
