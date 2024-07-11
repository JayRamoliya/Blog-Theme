<?php

// Template Name: Logout Page

if (is_user_logged_in()) {
    wp_logout();
    wp_redirect(get_site_url() . '/login');
    exit;
} else {
    wp_redirect(wp_login_url());
    exit;
}
?>
