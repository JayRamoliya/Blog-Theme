<?php
/*
Template Name: Login Page
*/
$id = get_current_user_id();

get_header(); 
?>
<div class="main-header">
    <h1>This is the PAGE-SLUG.PHP Page</h1>
</div>


<div class="login-container">
    <h2>Login</h2>
    <form id="login-form" method="post" class="ajax_login_form">
        <p>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
        </p>
        <p>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </p>
        <p>
            <input type="submit" name="login" value="Login">
        </p>
    </form>


    <?php
    // Display login errors if any
    if (!empty($login_errors)) {
        foreach ($login_errors as $error) {
            echo '<p class="login-error">' . $error . '</p>';
        }
    }
    ?>
    <p class="signup-button">If you have don't have an account
        <a href="<?php echo home_url('/sign-up'); ?>">Sign Up</a>
    </p>
    <p class="reset-password-link">
        <a href="<?php echo home_url('/reset'); ?>">Forgot your password?</a>
    </p>
</div>


<?php 
get_footer(); 
?>


