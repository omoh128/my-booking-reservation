<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Convert date to a specific format.
 *
 * @param string $date Date string to format.
 * @param string $format Optional. The desired date format. Default is 'Y-m-d'.
 * @return string Formatted date.
 */
function your_plugin_format_date( $date, $format = 'Y-m-d' ) {
    $date_obj = date_create( $date );
    return $date_obj ? date_format( $date_obj, $format ) : '';
}

/**
 * Check if a booking slot is available.
 *
 * @param int $slot_id ID of the booking slot.
 * @return bool True if available, false otherwise.
 */
function your_plugin_is_slot_available( $slot_id ) {
    $is_available = get_post_meta( $slot_id, '_is_available', true );
    return 'yes' === $is_available;
}

/**
 * Get all available booking slots.
 *
 * @return array List of available slots.
 */
function your_plugin_get_available_slots() {
    $args = [
        'post_type'      => 'booking',
        'posts_per_page' => -1,
        'meta_key'       => '_is_available',
        'meta_value'     => 'yes',
    ];
    $query = new WP_Query( $args );
    $slots = [];

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $slots[] = [
                'id'    => get_the_ID(),
                'title' => get_the_title(),
                'date'  => get_post_meta( get_the_ID(), '_booking_date', true ),
            ];
        }
    }

    wp_reset_postdata();
    return $slots;
}

/**
 * Send booking confirmation email.
 *
 * @param string $email User's email address.
 * @param string $booking_details Details of the booking.
 * @return void
 */
function your_plugin_send_confirmation_email( $email, $booking_details ) {
    $subject = __( 'Booking Confirmation', 'your-plugin-textdomain' );
    $message = sprintf( __( 'Thank you for your booking. Here are the details: %s', 'your-plugin-textdomain' ), $booking_details );
    $headers = [ 'Content-Type: text/html; charset=UTF-8' ];

    wp_mail( $email, $subject, $message, $headers );
}

/**
 * Generate a unique booking reference number.
 *
 * @return string Unique booking reference.
 */
function your_plugin_generate_booking_reference() {
    return strtoupper( uniqid( 'BOOK-' ) );
}
