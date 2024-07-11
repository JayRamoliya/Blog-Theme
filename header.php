<!DOCTYPE html>
<html <?php language_attributes(); ?>>    
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <?php wp_head(); ?>
</head>
<?php
if ( is_user_logged_in() ) {
       $output="<style>.login {display: none !important;}
       .logout {display: block !important;}</style>";
        echo $output;
    } else {  
        $output="<style>.login {display: block !important;}
        .logout {display: none !important;}</style>";
        echo $output;
}
?>
    
<body <?php body_class(); // Displays the class names for the body element.?>>

    <?php
        // Displays a navigation menu.
        wp_nav_menu(array(
            'theme_location'=>'main_menu',
            'menu_class'=>'custom_navbar',
        ))
    ?>

