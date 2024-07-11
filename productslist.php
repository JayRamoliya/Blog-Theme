<?php

// Template Name: List Products Page

get_header();


$paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;

$args = array(
    'posts_per_page' => 6,
    'post_type' => 'products',
    'paged' => $paged,
);
$query = new WP_Query( $args );

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
    .delete-product{
        color:black;
        border:none;
        padding: 7px 12px;
        cursor: pointer;
    }
    .edit-product{
        color:black;
        border:none;
        padding: 7px 12px;
        cursor: pointer;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 16px;
        text-align: left;
    }

    table thead tr {
        background-color: #f2f2f2;
        border-bottom: 2px solid #ddd;
    }

    table th, table td {
        padding: 12px 15px;
        border: 1px solid #ddd;
    }

    table tbody tr:nth-of-type(even) {
        background-color: #f9f9f9;
    }

    table tbody tr:nth-of-type(odd) {
        background-color: #fff;
    }

    table tbody tr:hover {
        background-color: #f1f1f1;
    }

    table tbody tr td a {
        color:black;
        border:none;
        padding: 7px 12px;
        cursor: pointer;
        text-decoration: none;
    }

    .table-container {
        overflow-x: auto;
        margin: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

</style>


<h1>Products List</h1>
<div class="product-list-container"></div>
<div class="list-pagination"></div>


<!-- <?php
    if ($query->have_posts()) {
        echo '<table border="1">';
        echo '<thead><tr>';
        echo '<th>Product ID</th>';
        echo '<th>Product Name</th>';
        echo '<th>Product Price</th>';
        echo '<th>Stock</th>';
        echo '<th>Sell Price</th>';
        echo '<th>Categories</th>';
        echo '<th>Action</th>';
        echo '<th>Action</th>';
        echo '</tr></thead><tbody>';
    
        while ($query->have_posts()) {
            $query->the_post();
            echo '<tr>';

            $product_id = get_the_ID();
            $categories = get_the_terms(get_the_ID(), 'product_category' );
            $category_names = array();
            foreach ($categories as $category) {
                $category_names[] = $category->name;
            }
            $category_names = implode(', ', $category_names);

            $edit = '<a href="' . esc_url(home_url('/edit-products?id=' . $product_id)) . '">Edit</a>';

            echo '<td>' . esc_html($product_id) . '</td>';
            echo '<td>' . esc_html(get_the_title()) . '</td>';
            echo '<td>' . esc_html(get_post_meta($product_id, 'price', true)) . '</td>';
            echo '<td>' . esc_html(get_post_meta($product_id, 'ecommerce_stock', true)) . '</td>';
            echo '<td>' . esc_html(get_post_meta($product_id, 'sale_price', true)) . '</td>';
            echo '<td>' . $category_names  . '</td>';
            echo '<td>' . $edit . '</td>';
            echo '<td><button class="delete-product" data-id=' .$product_id. ' >Delete</button></td>';
            echo '</tr>';
        }
        echo '</tbody></table>';

        $pagination_args = array(
            'total' => $query->max_num_pages,
            'current' => $paged,
            'format' => '?paged=%#%',
        );

        echo paginate_links($pagination_args);

    } else {
        echo 'No products found.';
    }
?> -->
 
<?php 
get_footer();
?>