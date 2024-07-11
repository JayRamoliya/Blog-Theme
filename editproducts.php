<?php

// Template Name: Edit Products Page

get_header();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;


$product_terms = get_the_terms($id, 'product_category');
$product_term_ids = $product_terms ? wp_list_pluck($product_terms, 'term_id') : [];

$terms = get_terms([
    'taxonomy' => 'product_category',
    'hide_empty' => false,
]);


$featured_img_url = get_the_post_thumbnail_url( $id, 'full' );
?>


<style>
    #showimage{
        width: 60px;
        height: 60px;
        border-radius:50%;
    }
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
    }

    form {
        width: 350px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"],
    textarea {
        width: 310px;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 15px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }

    .error {
        color: red;
        font-size: 14px;
        margin-top: -15px;
        margin-bottom: 15px;
        display: block;
    }
    .remove{
        color: white;
        height: 25px;
        padding: 5px;
    }
    #remove{
        display: flex;
        gap: 10px;
        align-items: center;
        margin-bottom: 10px;
    }
</style>

<form id="editForm" method="post" class="updateproductform">
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
    <label for="productName">Product Name:</label>
    <input type="text" id="productName" name="productName" value="<?php echo get_the_title($id) ?>">
    <span id="nameError" class="error"></span><br>  

    <label for="price">Price:</label>
    <input type="text" id="price" name="price" value="<?php echo get_post_meta($id, 'price', true) ?>">
    <span id="priceError" class="error"></span><br>

    <label for="price">Sell Price:</label>
    <input type="text" id="sellprice" name="sellprice" value="<?php echo get_post_meta($id, 'sale_price', true) ?>" oninput="checkPrice()">
    <span id="sellpriceError" class="error"></span><br> 

    <label for="stock">Stock:</label>
    <input type="number" id="stock" name="stock" value="<?php echo get_post_meta($id, 'ecommerce_stock', true) ?>">
    <span id="stockError" class="error"></span><br>

    <label for="category">Category:</label>
    <!-- <?php foreach($terms as $term) { 
        // $checked = in_array($term->term_id, $product_term_ids) ? 'checked' : '';
        ?>
        <label>
            <input type="checkbox" name="categories[]" value="<?php echo $term->name; ?>" >
            <?php echo $term->name; ?>
        </label><br>
    <?php } ?> -->

    <?php foreach($terms as $term) { ?>
  <label>
    <input type="checkbox" name="categories[]" value="<?php echo $term->name; ?>" >
    <?php echo $term->name; ?>
  </label><br>
<?php } ?>
    <br>

    <label for="image">Image:</label>
    <div id="remove">
        <img src="" id="showimage">
        <button type="button" class="remove" data-product-id="<?php echo $id; ?>">Remove</button>
    </div>
    <!-- <?php if ($featured_img_url) {
        ?>
        <div id="remove">
            <img src="<?php echo $featured_img_url;?>" id="showimage">
            <button type="button" class="remove" data-product-id="<?php echo $id; ?>">Remove</button>
        </div>
    <?php } ?> -->
    <input type="hidden" name="hiddenid" id="hiddenid">
    <!-- <input type="file" id="image" name="image"> -->
    
    <button id="custom_edit_file_upload" class="button">Upload File</button>
    <input type="hidden" id="editimage" name="image" readonly />

    <input type="submit" name="updateproducts" value="Update" id="editproductapi">
</form>



<?php get_footer();?>
<!-- <div class="get_one_product"></div> -->

<script>
function checkPrice() {
    var price = parseFloat(document.getElementById("price").value);
    var sellprice = parseFloat(document.getElementById("sellprice").value);

    if (sellprice < price) {
        document.getElementById("sellpriceError").innerHTML = "Sell price cannot be less than Price.";
    } else {
        document.getElementById("sellpriceError").innerHTML = "";
    }
}


price.addEventListener('input', function(event) {
    const keyValue = event.target.value;
    const regex = /^[0-9]+$/;
    if (!regex.test(keyValue)) {
        document.getElementById("priceError").innerHTML = "price only enter number";
        event.target.value = '';
    }
});


sellprice.addEventListener('input', function(event) {
    const keyValue = event.target.value;
    const regex = /^[0-9]+$/;
    if (!regex.test(keyValue)) {
        document.getElementById("sellpriceError").innerHTML = "sell price only enter number";
        event.target.value = '';
    }
});

</script>