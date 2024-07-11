<?php
get_header();

$examplePost = get_post();
// echo '<pre>';
// print_r($examplePost);
// echo '</pre>';


// echo $examplePost->post_content; // Don't do this
// echo apply_filters( 'the_content', $examplePost->post_content ); // Do this instead


$cat = get_categories(); // Retrieves a list of category objects.
$tags = get_tags(); // Retrieves all post tags.

$authors = get_users(array('who' => 'authors')); // Retrieves list of users matching criteria.

// echo '<pre>';
// print_r($taxo);
// echo '</pre>';


// $logoimg = get_header_image(); // Retrieves header image for custom header.
// echo $logoimg;

?>

<!-- <div class="sidebar">
<?php 
// get_sidebar();
?>
</div> -->

<div id="filter">
<div class="author-container">
    <form method="get" action="">
        <select name="author" id="author-select" onchange="if(this.value) window.location.href='<?php echo home_url(); ?>/?author=' + this.value;">
            <option value="">Select an author</option>
            <?php
            foreach ($authors as $author) {
                echo '<option value="' . esc_attr($author->ID) . '">' . esc_html($author->display_name) . '</option>';
            }
            ?>
        </select>
    </form>
</div>

<div class="tag-container">
    <form method="get" action="">
        <select name="tag" id="tag-select" onchange="if(this.value) window.location.href=this.value;">
            <option value="">Select a tag</option>
            <?php
            foreach ($tags as $tag) {
                echo '<option value="' . esc_url(get_tag_link($tag->term_id)) . '">' . esc_html($tag->name) . '</option>';
            }
            ?>
        </select>
    </form>
</div>

<div class="category-container">
    <form method="get" action="">
        <select name="cat" id="category-select" onchange="if(this.value) window.location.href=this.value;">
            <option value="">Select a category</option>
            <?php
            foreach ($cat as $catvalue) {
                echo '<option value="' . esc_url(get_category_link($catvalue->term_id)) . '">' . esc_html($catvalue->name) . '</option>';
            }
            ?>
        </select>
    </form>
</div>
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


