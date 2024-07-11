<?php
get_header();
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

<div class="main-header">
    <h1>This is the TAXONOMY.PHP Page</h1>
</div>


<div class="cards-container">
<?php
while (have_posts()) { 
    the_post(); // Iterate the post index in the loop.
?>

<div class="card">
    <div class="image">
        <?php the_post_thumbnail(); ?>
    </div>
    <div class="content">
        <a href="<?php the_permalink(); ?>">
            <span class="title">
                <?php the_title(); ?>
            </span>
        </a>
    </div>
</div>

<?php
}
?>
</div>





<?php 
custom_pagination();
?>
<?php
get_footer();
?>

