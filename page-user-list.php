<?php
/*
Template Name: User List Page
*/
get_header(); 
?>

<?php
$user_id = get_current_user_id();
$user_info = get_userdata($user_id); // Retrieves user info by user ID.
$user_meta = get_user_meta($user_id);


$is_admin = in_array('administrator', $user_info->roles);
$disabled_class = !user_can($user_info, 'administrator') ? ' disabled' : '';
// $disabled_class = user_can($user_info, 'administrator') ? ' disabled' : '';
// print_r($disabled_class);

global $wp_roles;
$roles = $wp_roles->roles;

$selected_role = isset($_GET['role']) ? sanitize_text_field($_GET['role']) : '';

// $blogusers = array(
    // 'orderby' => 'ID',
    // 'order' => 'ASC'
// );
// if ($selected_role) {
//     $blogusers['role'] = $selected_role;
// }
// $blogusers = get_users($blogusers);


$no=2; // Number of users per page

// Get the current page number
$paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
// echo $paged;

// Set up the query arguments
$args = array(
    'orderby' => 'ID',
    'order' => 'ASC',
    'role' => $selected_role,
    'number' => $no,
    'paged' => $paged,
);

$user_query = new WP_User_Query( $args );
$blogusers = $user_query->get_results(); // Returns the list of users.

$total_user = $user_query->get_total(); // Returns the total number of users for the current query.

$total_pages = ceil($total_user / $no);

// Generate pagination links
$base_url = add_query_arg(array('role' => $selected_role), get_pagenum_link(1)); // Retrieves a modified URL query string.
$pages = paginate_links(array(
    'base' => $base_url . '%_%',
    'format' => '&paged=%#%',
    'current' => $paged,
    'total' => $total_pages,
    'type' => 'array',
    'prev_text' => 'Previous',
    'next_text' => 'Next'
));

?>


<div class="user-list">
        <div class="form-filter">
            <form method="GET" action="">
                <label for="role">Filter by Role:</label>
                <select name="role" id="role" onchange="this.form.submit()">
                    <option value="">All Roles</option>
                    <?php foreach ($roles as $role_name => $role_info){ ?>
                        <option value="<?php echo esc_attr($role_name); ?>" <?php selected($selected_role, $role_name); ?>>
                            <?php echo esc_html($role_info['name']); ?>
                        </option>
                    <?php } ?>
                </select>
                <input type="hidden" name="paged" value="1">
            </form>
        </div>

        <div class="user-info-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User Login</th>
                        <th>User Email</th>
                        <th>Phone</th>
                        <th>Hobbies</th>
                        <th>Gender</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach ($blogusers as $user) {
                            $user_id = $user->ID;
                            $phone = get_user_meta($user_id, 'phone', true);
                            $hobbies = get_user_meta($user_id, 'hobbies', true);
                            $gender = get_user_meta($user_id, 'gender', true);

                            if (is_array($hobbies)) {
                                $hobbies = implode(', ', $hobbies);
                            }

                            echo '<tr>';
                            echo '<td>' . esc_html($user->ID) . '</td>';
                            echo '<td>' . esc_html($user->user_login) . '</td>';
                            echo '<td>' . esc_html($user->user_email) . '</td>';
                            echo '<td>' . esc_html($phone) . '</td>';
                            echo '<td>' . esc_html($hobbies) . '</td>';
                            echo '<td>' . esc_html($gender) . '</td>';

                            echo '<td>';
                            echo '<a href="' . esc_url(home_url('/edit-user?user_id=' . $user->ID)) . '" class="btn-edit' . $disabled_class . '">Edit</a>';
                            echo '<a href="' . esc_url(home_url('/delete-user?user_id=' . $user->ID)) . '" class="btn-delete' . $disabled_class . '" onclick="return confirm(\'Are you sure you want to delete this user?\')">Delete</a>';
                            echo '</td>';
                            echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
</div>



<?php 
if (is_array($pages)) {
    echo '<div class="custom-pagination"><ul class="pagination">';
    foreach ($pages as $page) {
        echo '<li>' . $page . '</li>';
    }
    echo '</ul></div>';
}
?>



<?php get_footer(); ?>
