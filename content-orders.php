
<div class="card">
    <div class="image">
        <?php the_post_thumbnail();?>
    </div>
    <div class="content">
        <a href="<?php the_permalink();?>">
            <span class="title">
                <?php the_title();?>
            </span>
        </a>
    </div>
</div>