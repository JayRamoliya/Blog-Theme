<?php 
$stock = get_post_meta(get_the_ID(), 'ecommerce_stock', true);
$product_price = get_post_meta(get_the_ID(), 'price', true);
$sale_price = get_post_meta(get_the_ID(), 'sale_price', true);
$categories = get_the_terms(get_the_ID(), 'product_category' );
?>

<div class="card" <?php  if($stock == 0) { ?>style="opacity: 0.5; pointer-events: none;"<?php } ?>>
    <div class="image">
        <?php the_post_thumbnail();?>
    </div>
        <?php
            if (!empty($sale_price)) {
                echo '<p class="sale-price">Sale Price: ₹' . esc_html(number_format($sale_price)) . '</p>';
            }
            if (!empty($product_price)) {
                echo '<p class="product-price">Price: ₹' . esc_html(number_format($product_price)) . '</p>';
            }
            if (empty($stock)) {
                echo '<p class="outstock">' . 'Out of Stock' . '</p>';
            }
        ?>
    <div class="content">
        <a href="<?php the_permalink();?>">
            <span class="title">
                <?php the_title();?>
            </span>
        </a>
        <div id="category">
        <?php
            foreach ($categories as $term) {
                    echo '<h3>' . esc_html($term->name) . '</h3>';
            }
        ?> 
        </div>       
    </div>
</div>