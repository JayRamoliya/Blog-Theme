<?php

// Template Name: Order Page

get_header();

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
query_posts(array(
    'post_type' => 'orders',
    'posts_per_page' => 6,
    'paged' => $paged,
));
$state = get_post_meta(get_the_ID(), 'state', true);
echo $state;
print_r($paged);

?>


<style>

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

<div class="cards-container">
    <?php
while (have_posts()) {
    the_post();

    get_template_part('content', 'orders');
    ?>
    <?php
}
?>
</div>



<?php
custom_pagination();
get_footer();
?>

