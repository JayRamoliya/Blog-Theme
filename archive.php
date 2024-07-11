<?php
get_header();
?>

<div class="main-header">
    <h1>This is the ARCHIVE.PHP Page</h1>
</div>

<div class="cards-container">
<?php
if (have_posts()) {
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
} else {
    echo '<p>No posts found.</p>';
}
?>
</div>

<?php
custom_pagination(); // Your custom pagination function
?>
<?php
get_footer();
?>

