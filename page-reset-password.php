<?php
/*
Template Name: Reset Password
*/

// reset password -> enter a email/username -> get user -> create a reset key -> 
get_header();

if (isset($_POST['user_login'])) {

    $user_login = sanitize_text_field($_POST['user_login']);
    $user = get_user_by('login', $user_login);

    if (!$user) {
        $user = get_user_by('email', $user_login);
    }

    if ($user) {
        $reset_key = get_password_reset_key($user);

        $reset_url = home_url("/reset?key=$reset_key&login=" . $user->user_login);
        
        ?>
        <a href="<?php echo $reset_url; ?>">To reset your password, visit here</a>
        <?php

    } else {
        echo '<p class="error-message">No user found with that username or email address.</p>';
    }
}

if (isset($_GET['key']) && isset($_GET['login'])) {

    $user = check_password_reset_key($_GET['key'], $_GET['login']);

    if (!$user || is_wp_error($user)) {
        echo '<p class="error-message">This key is invalid or has already been used.</p>';
    } else {
        
        if (isset($_POST['password']) && isset($_POST['password_confirm'])) {
            
            if ($_POST['password'] === $_POST['password_confirm']) {
                reset_password($user, sanitize_text_field($_POST['password']));

                echo '<p class="success-message">Your password has been reset successfully.</p>';
            } else {
                echo '<p class="error-message">Passwords do not match.</p>';
            }
        } else {
            ?>

            <form method="post" action="" id="repassw">
                <p>
                    <label for="password">New Password</label>
                    <input type="password" name="password" id="password" required>
                </p>
                <p>
                    <label for="password_confirm">Confirm Password</label>
                    <input type="password" name="password_confirm" id="password_confirm" required>
                </p>
                <p>
                    <input type="submit" value="Reset Password">
                </p>
            </form>
            <?php
        }
    }
} else {
?>

    <form method="post" class="repassword">
        <p>
            <label for="user_login">Enter your Email</label>
            <input type="text" name="user_login" id="user_login" required>
        </p>
        <p>
            <input type="submit" value="Get New Password">
        </p>
    </form>



<?php
}
get_footer();
?>



