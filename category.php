<?php
get_header();
$cat = get_categories();
?>

<div class="main-header">
    <h1>This is the CATEGORY.PHP Page</h1>
</div>

<!-- <div class="sidebar">
<?php 
// get_sidebar();
?>
</div> -->

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

