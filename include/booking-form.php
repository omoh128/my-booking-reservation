<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
// In booking-form.php
function display_booking_form() {
    ob_start(); // Start output buffering
    ?>
    <form method="POST" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <input type="date" name="booking_date" required>
        <input type="submit" value="Book Now">
    </form>
    <?php
    return ob_get_clean(); // Return the buffered output
}

// Register the shortcode
add_shortcode('booking_form', 'display_booking_form');
