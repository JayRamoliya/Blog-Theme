<?php
get_header();
$authors = get_users(array('who' => 'authors'));
?>
<div class="main-header">
    <h1>This is the AUTHOR.PHP Page</h1>
</div>
<div class="cards-container">
<?php
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $author_id = (get_query_var('author')) ? get_query_var('author') : 0;

    $args = array(
        'author' => $author_id,
        'paged' => $paged
    );

    $query = new WP_Query($args);
?>

<?php
if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
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
<?php
}else {
    echo '<p>No posts found.</p>';
}?>
</div>


<?php 
custom_pagination(); 
// wp_pagenavi();
?>

<?php
get_footer();
?>


