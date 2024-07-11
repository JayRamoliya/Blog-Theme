<?php
get_header(); 
?>

<div class="main-header">
    <h1>This is the ARCHIVE-POSTTYPE.PHP Page</h1>
</div>

<?php
// here get paged 
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
// create a loop
query_posts(array(
   'post_type' => 'orders',
   'posts_per_page' => 6,
   'paged' => $paged,
));

?>


<!-- this css for this page -->
<style>
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

</style>

<div class="cards-container">
<?php
while (have_posts()) { // Determines whether current WordPress query has posts to loop over.
    the_post(); // Iterate the post index in the loop.
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