<?php
namespace MyBookingReservation; // Add this line

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Main_Class {

    // Holds the singleton instance of this class
    private static $instance = null;

    // Constructor: Initializes core plugin functionality
    private function __construct() {
        $this->define_constants();
        $this->load_dependencies();
        $this->init_hooks();
    }

    // Singleton pattern to ensure only one instance
    public static function get_instance() {
        if ( self::$instance === null ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Define necessary plugin constants
    private function define_constants() {
        define( 'PLUGIN_VERSION', '1.0.0' );
        define( 'PLUGIN_NAME', 'Booking Reservation Tool' );
        define( 'PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
        define( 'PLUGIN_URL', plugin_dir_url( __FILE__ ) );
    }

    // Load required files and dependencies
    private function load_dependencies() {
        require_once PLUGIN_DIR . '../include/helpers.php';
        require_once plugin_dir_path( __FILE__ ) . '../include/booking-form.php'; // Include the booking form
        
    }

    // Initialize WordPress hooks and actions
    private function init_hooks() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );
        add_action( 'init', [ $this, 'register_custom_post_type' ] );
    }

    // Enqueue frontend scripts and styles
    public function enqueue_scripts() {
        wp_enqueue_style( 'plugin-style', PLUGIN_URL . 'assets/css/style.css', [], PLUGIN_VERSION );
        wp_enqueue_script( 'plugin-script', PLUGIN_URL . 'assets/js/script.js', [ 'jquery' ], PLUGIN_VERSION, true );
    }

    // Enqueue admin scripts and styles
    public function enqueue_admin_scripts() {
        wp_enqueue_style( 'plugin-admin-style', PLUGIN_URL . 'assets/css/admin-style.css', [], PLUGIN_VERSION );
        wp_enqueue_script( 'plugin-admin-script', PLUGIN_URL . 'assets/js/admin-script.js', [ 'jquery' ], PLUGIN_VERSION, true );
    }

    // Register a custom post type for bookings (example)
    public function register_custom_post_type() {
        $args = [
            'labels'      => [
                'name'          => __( 'Bookings', 'text-domain' ),
                'singular_name' => __( 'Booking', 'text-domain' ),
            ],
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => [ 'slug' => 'bookings' ],
            'supports'    => [ 'title', 'editor', 'custom-fields' ],
        ];
        register_post_type( 'booking', $args );
    }

    // Activate plugin: Setup tasks like database or custom roles
    public static function activate() {
        self::get_instance()->register_custom_post_type();
        flush_rewrite_rules(); // Ensure permalinks are updated
    }

    // Deactivate plugin: Clean up on deactivation
    public static function deactivate() {
        flush_rewrite_rules(); // Clean up permalinks
    }

    // Run the plugin
    public function run() {
        // Additional run functionality if needed
    }
}

// Hooks for activation and deactivation
register_activation_hook( __FILE__, [ 'Main_Class', 'activate' ] );
register_deactivation_hook( __FILE__, [ 'Main_Class', 'deactivate' ] );
