<?php
get_header();

$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https://" : "http://";
$url .= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$path = parse_url($url, PHP_URL_PATH);
$segments = explode('/', trim($path, '/'));
$category_slug = end($segments);

$term = get_term_by('slug', $category_slug, 'product_category');

if ($term && !is_wp_error($term)) {
    $term_id = $term->term_id;
} else {
    echo 'No category found with the slug: ' . $category_slug;
}

$cus_meta = get_term_meta($term->term_id, 'custom_meta', true);
echo '<h1 id="custom_meta">' . $cus_meta . '</h1>';
?>

<style>
    #category{
        display: flex;
        gap: 10px;
        position: absolute;
        bottom: 0;
        left: 0;
    }
    h3{
        color:black;
        background:#ebeef0;
        width:100px; 
        text-align:center;
        padding: 2px;
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
    <h1>This is the TAXONOMY-TAXONOMY-TERM.PHP Page</h1>
</div>

<div class="category-container">
    <form method="get" action="">
        <select name="cat" id="category-select" onchange="if(this.value) window.location.href=this.value;">
            <option value="">Select a category</option>
            <?php
            $terms = get_terms([
                'taxonomy' => 'product_category',
                'hide_empty' => false,
            ]);

            if (!empty($terms) && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                    echo '<option value="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</option>';
                }
            } else {
                echo '<option value="">No categories found</option>';
            }
            ?>
        </select>
    </form>
</div>

<div class="cards-container">
<?php
while (have_posts()) { 
    the_post(); // Iterate the post index in the loop.
    get_template_part('content', 'product-card');

?>

<?php
}
?>
</div>





<?php 
$query = new WP_Query();

$total_pages = $query->max_num_pages;
$base_url = get_pagenum_link(1);

custom_pagination($total_pages, $paged, $base_url);
// custom_pagination();
?>
<?php
get_footer();
?>

