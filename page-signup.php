<?php
/*
Template Name: Signup Page
*/
get_header(); 

?>

<?php
// $user = wp_get_current_user();
// echo $user;
?>

<div class="main-header">
    <h1>This is the CUSTOM-TEMPLATE.PHP Page</h1>
</div>

<!-- this is signup form -->
<div class="signup-container">
        <h2>Sign Up</h2>
        <form id="signup-form" method="post" onsubmit="return validateForm()" class="ajax_signup_form">
            <p>
                <label for="firstname">First Name</label>
                <input type="text" name="firstname" id="firstname">
                <span class="error-message" id="firstname-error"></span>
            </p>
            <p>
                <label for="lastname">Last Name</label>
                <input type="text" name="lastname" id="lastname">
                <span class="error-message" id="lastname-error"></span>
            </p>
            <p>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" >
                <span class="error-message" id="username-error"></span>
            </p>
            <p>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" >
                <span class="error-message" id="email-error"></span>
            </p>
            <p>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" >
                <span class="error-message" id="password-error"></span>
            </p>
            <p>
                <label for="phone">Phone Number</label>
                <input type="text" name="phone" id="phone" >
                <span class="error-message" id="phone-error"></span>
            </p>
            <p>
                <label for="hobbies">Hobbies</label><br>
                <input type="checkbox" name="hobbies[]" id="multihobbies1" value="Reading"> Reading<br>
                <input type="checkbox" name="hobbies[]" id="multihobbies2" value="Traveling"> Traveling<br>
                <input type="checkbox" name="hobbies[]" id="multihobbies3" value="Sports"> Sports<br>
                <span class="error-message" id="hobbies-error"></span>
            </p>
            <p>
                <label for="gender">Gender</label>
                <select name="gender" id="gender" >
                    <option value="" disabled selected>Select your gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
                <span class="error-message" id="gender-error"></span>
            </p>
            <p>
                <label for="profile-photo">Profile Photo</label>
                <input type="file" name="profile-photo" id="profile-photo" accept="image/*" >
                <span class="error-message" id="profile-photo-error"></span>
            </p>
            <p>
                <input type="hidden" name="photoid" value="" id="photoid">
                <input type="submit" name="submit" value="Sign Up">
            </p>
        </form>
</div>

<?php get_footer(); ?>
