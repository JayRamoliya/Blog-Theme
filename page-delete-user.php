<?php
/*
Template Name: Delete User Page
*/
get_header();
?>

<?php

// Returns whether the current user has the specified capability
if (current_user_can('delete_users')) {

    if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
        $user_id = absint($_GET['user_id']); 

        if ($user_id !== get_current_user_id()) {
            $user = get_userdata($user_id);

            if ($user) {
                require_once( ABSPATH.'wp-admin/includes/user.php' );
                $deleted = wp_delete_user($user_id);

                if ($deleted) {
                    echo '<div class="notice success">User has been successfully deleted.</div>';
                } else {
                    echo '<div class="notice error">There was an error deleting the user.</div>';
                }
            } else {
                echo '<div class="notice error">User not found.</div>';
            }
        } else {
            echo '<div class="notice error">You cannot delete your own account.</div>';
        }
    } else {
        echo '<div class="notice error">No user ID provided.</div>';
    }
} else {
    echo '<div class="notice error">You do not have permission to delete users.</div>';
}
?>


<?php get_footer(); ?>

