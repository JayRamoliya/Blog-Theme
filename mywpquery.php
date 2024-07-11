<?php

// Template Name: My WP Query Page

get_header();

// $query = new WP_Query();


$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
query_posts(array(
    // 'meta_key' => 'ecommerce_stock',
    // 'meta_value' => 0,
    // 'meta_compare' => '>',
   'post_type' => 'products',
   'posts_per_page' => 2,
   'paged' => $paged,
));

global $wp_query;
$big = 9999999999;
$pages = paginate_links(array(
    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))), // URL for a given page number
    'format' => '?paged=%#%',
    'current' => max(1, get_query_var('paged')),
    'total' => $wp_query->max_num_pages,
    'type' => 'array',
));
if (is_array($pages)) {
    echo '<div class="custom-pagination"><ul class="pagination">';
    foreach ($pages as $page) {
        echo '<li>' . $page . '</li>';
    }
    echo '</ul></div>';
}

// $args = array(
//     'post_type' => 'products',
//     // 'category_name' => 'laptop',
//     // 'posts_per_page' => -1, // retrieve all products
//     // 'meta_key' => 'sell_count', 
//     // 'meta_query' => array(
// 	// 	array(
// 	// 		'key' => 'ecommerce_stock',
// 	// 		'value' => 0,
//     //         'type' => 'numeric',
// 	// 		'compare' => '>=',
// 	// 	)
// 	// )
//     // 'orderby' => 'meta_value_num', 
//     // 'order' => 'DESC' 
//     // 'tax_query' => array(
//     // array(
//     //     'taxonomy' => 'product_category',
//     //     'field'    => 'slug',
//     //     'terms'    => array( 'laptop', 'shoes' ),
//     //     ),
//     // ),
//     'meta_key' => 'ecommerce_stock',
//     'meta_value' => 0,
//     'meta_compare' => '>',
//     'posts_per_page' => 3,
//     'paged' => $paged,
// );


// $args = array(
//     'post_type' => 'products',
//     'posts_per_page' => 12,
//     // 'meta_key' => 'sell_count',
//     // 'orderby' => 'meta_value_num', 
//     // 'order' => 'DESC',
//     // 'meta_key' => 'ecommerce_stock',
//     // 'meta_value' => 0,
//     // 'meta_compare' => '>',
    
//     'meta_query' => array(
//         array(
//             'meta_key' => 'ecommerce_stock',
//             'meta_value' => 0,
//             'meta_compare' => '>',
//         ),
//     ),
// );
// $args = array(
//     'post_type' => 'products',
//     'posts_per_page' => 12,
//     // 'meta_key' => 'ecommerce_stock',
//     // 'meta_value' => 1,
//     // 'meta_compare' => '>=',
//     // 'orderby' => array(
//     //     'meta_value_num' => 'DESC',
//     // ),
//     'meta_query' => array(
//         // 'relation' => 'AND',
//         array(
//             'meta_key' => 'ecommerce_stock',
//             'meta_value' => 0,
//             'meta_compare' => '>',
//         ),
//         // array(
//         //     // 'meta_key' => 'sell_count',
//         //     // 'meta_value' => 0,
//         //     // 'meta_compare' => '>',
//         // ),
//     ),
//     // 'meta_key' => 'sell_count',
// );

$args = array(
    'post_type' => 'products',
    'posts_per_page' => 12,
    'meta_key' => 'sell_count',
    'orderby' => 'meta_value_num',
    'order' => 'DESC',
    'meta_query' => array(
        array(
            'key' => 'ecommerce_stock',
            'value' => 0,
            'compare' => '>',
        ),
    ),
);


$query = new WP_Query( $args );

// $query = new WP_Query( array( 'category_name' => 'laptop' ) );

echo '<pre>';
// print_r($query);
// print_r($q);
// print_r($query->query);
// print_r($query->query_vars);
// print_r($query->tax_query);
// print_r($query->meta_query);
echo '</pre>';

// $query = new WP_Query( array( 'post_type' => 'products','posts_per_page' => 4 ) );

// The Loop.
if ( $query->have_posts() ) {
	echo '<ul>';
	while ( $query->have_posts() ) {
		$query->the_post();
		echo '<li>' . esc_html( get_the_title() ) . '</li>';
	}
	echo '</ul>';
} else {
	esc_html_e( 'Sorry, no posts matched your criteria.' );
}


    // if ($query->have_posts()) {
    //     $output = '';
    //     foreach ($query->posts as $product) {
    //         $id = $product->ID;
    //         echo $id;
    //     }
    // } 
    
    // else {
    //     $output = 'No products found';
    // }

//     wp_reset_postdata();

//     return $output;
// }

// // Create a shortcode to display the top selling products
// add_shortcode('top_selling_products', 'get_top_selling_products');


