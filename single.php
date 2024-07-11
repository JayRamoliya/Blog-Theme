<?php
get_header();

// the_ID ✅
// the_title ✅
// the_post_thumbnail ✅
// the_content ✅
// the_excerpt ✅
// the_time ✅
// the_category ✅
// the_tags ✅
// the_shortlink ✅
// the_permalink ✅
// next_post_link ✅
// previous_post_link ✅
?>


<main>
    <div class="container">
        <article>
            <h1><?php the_title(); ?></h1>
            <div class="metadata">
                <span class="author">by John Doe</span>
                <span class="date">August 4, 2016</span>
            </div>
            <p><?php the_content(); ?></p>
        </article>
    </div>
</main>

<?php
get_footer();
?>

<!-- 
<div class="post-container">
    <h1 class="post-title"><?php the_title(); ?></h1>
    
    <p class="post-meta">
        <span class="post-number">Post Number: <?php the_ID(); ?></span>
        <span class="post-author">This post was written by <?php the_author(); ?></span>
        <span class="post-time">Posted at <?php the_time(); ?></span>
    </p>
    
    <div class="post-categories">
        <strong>Categories: </strong><?php the_category('&bull;'); ?>
    </div>
    
    <div class="post-tags">
        <strong>Tags: </strong><?php the_tags('<ul><li>', '</li><li>', '</li></ul>'); ?>
    </div>
    
    <div class="post-shortlink">
        <?php the_shortlink('Shortlink: '); ?>
    </div>
    
	<ul class="pagination justify-content-center mb-4">
		<li class="page-item">
			<?php next_post_link(); ?>
        </li>
	    <li class="page-item">
	        <?php previous_post_link('%link'); ?>
	    </li>
    </ul>
</div> -->

<?php
// comments_template();
// comment_form();
?>
