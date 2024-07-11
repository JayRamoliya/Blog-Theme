<?php

// Template Name: Add Products Page

get_header();

$terms = get_terms([
    'taxonomy' => 'product_category',
    'hide_empty' => false,
]);

?>

<style>

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
</style>

<form id="productForm" method="post" enctype="multipart/form-data" class="productForm">
    <label for="productName">Product Name:</label>
    <input type="text" id="productName" name="productName">
    <span id="nameError" class="error"></span><br>  

    <label for="price">Price:</label>
    <input type="text" id="price" name="price" >
    <span id="priceError" class="error"></span><br> 

    <label for="price">Sell Price:</label>
    <input type="text" id="sellprice" name="sellprice" oninput="checkPrice()">
    <span id="sellpriceError" class="error"></span><br> 

    <label for="stock">Stock:</label>
    <input type="number" id="stock" name="stock" >
    <span id="stockError" class="error"></span><br> 

    <label for="description">Description:</label>
    <textarea id="description" name="description" ></textarea>
    <span id="descriptionError" class="error"></span><br>  

    <label for="category">Category:</label>
    <?php foreach($terms as $term) { ?>
        <label>
            <input type="checkbox" name="categories[]" value="<?php echo $term->term_id; ?>">
            <?php echo $term->name; ?>
        </label><br>
    <?php } ?>

    <label for="image">Image:</label>
    <!-- <input type="file" id="image" name="image"> -->
    <button id="custom_file_upload" class="button">Upload File</button>
    <input type="hidden" id="image" name="image" readonly /> 

    <span id="imageError" class="error"></span><br> 

    <input type="submit" name="addproducts" value="Submit" id="addproductapi">
</form>


<?php get_footer();?>


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
</script>