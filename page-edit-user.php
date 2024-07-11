<?php
/*
Template Name: Edit User Page
*/
get_header(); ?>

<?php
// $user_id = get_current_user_id();
$id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
$user_info = get_userdata($id);
$user_meta = get_user_meta($id);
echo $id;

// echo '<pre>';
// print_r($user_info);
// echo '</pre>';

// Display the roles
echo '<pre>';
print_r($user_info->roles);
echo '</pre>';
// echo '<pre>';
// print_r($user_meta);
// echo '</pre>';

$is_admin = in_array('administrator', $user_info->roles);
?>

<div class="signup-container">
        <h2>Sign Up</h2>
        <form id="signup-form" method="post" class="ajax_edit_form" onsubmit="return validateForm()">
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
            <p>
                <label for="make_admin">Make Admin</label>
                <input type="checkbox" name="make_admin" id="make_admin" <?php checked($is_admin); ?> />
            </p>
            <p>
                <label for="firstname">First Name</label>
                <input type="text" name="firstname" id="firstname" value="<?php echo $user_meta['first_name'][0];?>" />
                <span class="error-message" id="firstname-error"></span>
            </p>
            <p>
                <label for="lastname">Last Name</label>
                <input type="text" name="lastname" id="lastname" value="<?php echo $user_meta['last_name'][0]; ?>">
                <span class="error-message" id="lastname-error"></span>
            </p>
            <p>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="<?php echo $user_info->user_login; ?>">
                <span class="error-message" id="username-error"></span>
            </p>
            <p>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo $user_info->user_email; ?>">
                <span class="error-message" id="email-error"></span>
            </p>
            <!-- <p>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" >
                <span class="error-message" id="password-error"></span>
            </p> -->
            <p>
                <label for="phone">Phone Number</label>
                <input type="text" name="phone" id="phone" value="<?php echo $user_meta['phone'][0]; ?>">
                <span class="error-message" id="phone-error"></span> 
            </p>
            <!-- <p>
                <label for="hobbies">Hobbies</label><br>
                <input type="checkbox" name="hobbies[]" value="Reading" > Reading<br>
                <input type="checkbox" name="hobbies[]" value="Traveling"> Traveling<br>
                <input type="checkbox" name="hobbies[]" value="Sports"> Sports<br>
                <span class="error-message" id="hobbies-error"></span>
            </p> -->

            <?php
            $hobbies_array = unserialize($user_meta['hobbies'][0]);
            $possible_hobbies = ['Reading', 'Traveling', 'Sports'];

            foreach ($possible_hobbies as $hobby) {
                $checked = (in_array($hobby, $hobbies_array)) ? 'checked' : '';
                echo '<input type="checkbox" name="hobbies[]" value="' . $hobby . '" ' . $checked . '> ' . ucfirst($hobby) . '<br>';
            }
            ?>

            <p>
                <label for="gender">Gender</label>
                <select name="gender" id="gender">
                    <option value="" disabled>Select your gender</option>
                    <option value="Male" <?php echo ($user_meta['gender'][0] === 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo ($user_meta['gender'][0] === 'Female') ? 'selected' : ''; ?>>Female</option>
                    <option value="Other" <?php echo ($user_meta['gender'][0] === 'Other') ? 'selected' : ''; ?>>Other</option>
                </select>
                <span class="error-message" id="gender-error"></span>
            </p>

            <p>
                <label for="profile-photo">Profile Photo</label>
                <input type="file" name="profile-photo" id="profile-photo" accept="image/*" >
                <span class="error-message" id="profile-photo-error"></span>
            </p>
            <p>
                <input type="submit" name="update" value="Update">
            </p>
        </form>
</div>

<?php get_footer(); ?>







<!-- user_activation_key is one of those keys that WordPress uses for authenticity of a Reset Password request.

So, when you are saying this key is empty for some users, the reason is, those users have never requested for a password reset.

When a password reset is requested a temporary key is generated called check_password_reset_key and sent via email for the reset process.

When the user goes to the generated link, this key is directly compared with user_activation_key. If both keys don't match then it is considered to be an Invalid Request. Otherwise it proceeds and the user will be allowed to enter a new password for his account.

If you want to understand how it works with more details, you can check the wordpress documentation. -->