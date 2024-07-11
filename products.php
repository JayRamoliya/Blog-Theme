<?php

// Template Name: Product Page

get_header();
echo apply_filters("the_content",get_the_content());

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
// query_posts(array(
//    'post_type' => 'products',
//    'posts_per_page' => 6,
//    'paged' => $paged,
// ));

global $wpdb;
echo '<pre>';
// print_r($wpdb);
echo '</pre>';

$terms = get_terms([
    'taxonomy' => 'product_category',
    'hide_empty' => false,
]);

$table = 'cart';
$id = get_current_user_id();
$query = $wpdb->prepare("SELECT * FROM $table WHERE id=%s;", $id );
$row = $wpdb->get_row( $query );
// $data = $row->session_data;
// print_r($data);

// if (!empty($terms) && !is_wp_error($terms)) {
//     foreach ($terms as $term) {
//         $cus_meta = get_term_meta($term->term_id, 'custom_meta', true);
//         echo '<h1 id="custom_meta">' . $cus_meta . '</h1>';
//     }
// }
?>


<style>
    
    #category{
        display: flex;
        gap: 10px;
        position: absolute;
        bottom: 0;
        left: 0;
    }
    h3{
        color:black;
        background:#ebeef0;
        width:100px; 
        text-align:center;
        padding: 2px;
    }
    .cards-container {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        margin: 20px;
    }

    .card {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        width: 250px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin: 10px;
        position: relative;
    }
    .cat{
        position: absolute;
        left: 0;
    }

    .card.out-of-stock {
    opacity: 0.5;
    pointer-events: none; /* Disable click events */
    }
    .image {
        height: 300px;
        overflow: hidden;
    }

    .image img {
        width: 100%;
        height: auto;
    }

    .product-category {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(0, 0, 0, 0.1);
        padding: 5px 10px;
        border-radius: 3px;
        font-size: 14px;
    }

    .product-price, .sale-price {
        text-align: center;
        font-size: 1.1em;
        margin-top: 8px;
        color: #333;
    }

    .sale-price {
        text-align: center;
        color: red;
        text-decoration: line-through;
    }

    .content {
        padding: 10px;
    }

    .content a {
        text-decoration: none;
        color: #000;
    }

    .content .title {
        text-align: center;
        font-size: 1.2em;
        margin: 10px 0;
        display: block;
    }

    .card:hover {
        transform: scale(1.05);
        transition: transform 0.2s;
    }
    .outstock{
        font-size: 25px;
        text-align: center;
        width: 188px;
        position: absolute;
        top: 10%;
        left: -43px;
        background: red;
        overflow: hidden;
        color: white;
        transform:rotate(-46deg);
    }
    
</style>

<?php 
// echo do_shortcode('[mostsell terms="laptop,shoes"]');
// echo do_shortcode('[mostsell]');


$args = array(
    'posts_per_page' => 6,
    'paged' => $paged,
    'post_type' => 'products',
    // 'meta_key' => 'sell_count',
    // 'orderby' => 'meta_value_num'

    'orderby' => array(
        'sel_count' => 'meta_value_num'
    ),
    
    'order' => 'DESC',
    'meta_query' => array(
        'ecom_stock' => array(
            'key' => 'ecommerce_stock',
            'value' => 0,
            'compare' => '>',
        ),
        'sel_count' => array(
            'key' => 'sell_count'
        )
    ),
);
$query = new WP_Query( $args );

?>



<div class="category-container">
    <form method="get" action="">
        <select name="cat" id="category-select" onchange="if(this.value) window.location.href=this.value;">
            <option value="">Select a category</option>
            <?php

            if (!empty($terms) && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                    echo '<option value="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</option>';
                }
            } else {
                echo '<option value="">No categories found</option>';
            }
            ?>
        </select>
    </form>
</div>


<div class="cards-container">
    <?php
    while ($query -> have_posts()) {
        $query -> the_post(); // Iterate the post index in the loop.
        
        get_template_part('content', 'product-card');
        ?>
        <?php
    }
    ?>
</div>





<!-- <div class="cards-container"></div>
<div class="pagination-container"></div> -->

<?php
$total_pages = $query->max_num_pages;
$base_url = get_pagenum_link(1);

custom_pagination($total_pages, $paged, $base_url);

// custom_pagination(); 
get_footer();
?>
