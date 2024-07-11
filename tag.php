<?php
get_header();
?>

<div class="main-header">
    <h1>This is the TAG.PHP Page</h1>
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
            <p class="desc">
                <?php the_excerpt(); ?>
            </p>
            <a class="action" href="<?php the_permalink(); ?>">
                Find out more
                <span aria-hidden="true">
                    →
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
// wp_pagenavi();
?>

<?php
get_footer();
?>
