<?php
/**
 * Plugin Name: My Booking Reservation
 * Description: Custom plugin for booking reservation.
 * Version: 1.0.0
 * Author: Omomoh Agiogu
 * Text Domain: my-booking-reservation
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Autoload dependencies if using Composer
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require __DIR__ . '/vendor/autoload.php';
}

// Include the Main_Class file directly if Composer is not used
//require_once plugin_dir_path( __FILE__ ) . 'src/Main_Class.php';

// Use the namespace if needed
use MyBookingReservation\Main_Class;

// Initialize the plugin
function my_booking_reservation_plugin_name_init() {
    $plugin = Main_Class::get_instance();
    $plugin->run();
}
add_action( 'plugins_loaded', 'my_booking_reservation_plugin_name_init' );

// Hooks for activation and deactivation
register_activation_hook( __FILE__, [ 'Main_Class', 'activate' ] );
register_deactivation_hook( __FILE__, [ 'Main_Class', 'deactivate' ] );
