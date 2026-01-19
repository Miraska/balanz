<?php
/**
 * Forms - Contact Form Handler, SMTP, Submissions
 * 
 * @package Balanz
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Save form submission to database/file (backup)
 * Only saves if WP_DEBUG is enabled or email fails
 */
function balanz_save_submission_to_file($data, $force = false) {
    // Only save in debug mode or when forced (email failed)
    if (!WP_DEBUG && !$force) {
        return false;
    }
    
    $upload_dir = wp_upload_dir();
    $submissions_file = $upload_dir['basedir'] . '/form-submissions.log';
    
    $entry = "\n" . str_repeat('=', 60) . "\n";
    $entry .= date('Y-m-d H:i:s') . "\n";
    $entry .= str_repeat('-', 60) . "\n";
    $entry .= "Name: " . $data['name'] . "\n";
    $entry .= "Contact: " . $data['contact'] . "\n";
    $entry .= "Message: " . $data['message'] . "\n";
    $entry .= "Subscribe: " . ($data['subscribe'] ? 'Yes' : 'No') . "\n";
    $entry .= "IP: " . balanz_get_client_ip() . "\n";
    $entry .= str_repeat('=', 60) . "\n";
    
    file_put_contents($submissions_file, $entry, FILE_APPEND);
    
    return $submissions_file;
}

/**
 * Configure SMTP for email sending
 * Alternative: use WP Mail SMTP plugin instead
 */
function balanz_configure_smtp($phpmailer) {
    // Only configure if not already using SMTP plugin
    if (defined('WPMS_ON') || defined('WP_MAIL_SMTP_VERSION')) {
        if (WP_DEBUG) {
            error_log('Balanz SMTP: Skipped - using WP Mail SMTP plugin');
        }
        return;
    }
    
    // Get SMTP settings from options (you can configure in Theme Settings)
    $smtp_host = get_field('smtp_host', 'option');
    $smtp_port = get_field('smtp_port', 'option') ?: 587;
    $smtp_user = get_field('smtp_username', 'option');
    $smtp_pass = get_field('smtp_password', 'option');
    $smtp_from = get_field('smtp_from_email', 'option');
    $smtp_from_name = get_field('smtp_from_name', 'option') ?: get_bloginfo('name');
    
    // If SMTP not configured in options, log warning and skip
    if (!$smtp_host || !$smtp_user || !$smtp_pass) {
        if (WP_DEBUG) {
            error_log('Balanz SMTP: NOT CONFIGURED! Go to Theme Settings → Form Settings');
            error_log('Balanz SMTP: Host=' . ($smtp_host ?: 'EMPTY') . ', User=' . ($smtp_user ?: 'EMPTY') . ', Pass=' . ($smtp_pass ? 'SET' : 'EMPTY'));
        }
        return;
    }
    
    // Enable debug in WP_DEBUG mode
    if (WP_DEBUG) {
        $phpmailer->SMTPDebug = 2;
        $phpmailer->Debugoutput = function($str, $level) {
            error_log("PHPMailer [$level]: $str");
        };
    }
    
    $phpmailer->isSMTP();
    $phpmailer->Host = $smtp_host;
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = intval($smtp_port);
    $phpmailer->Username = $smtp_user;
    $phpmailer->Password = $smtp_pass;
    $phpmailer->SMTPSecure = intval($smtp_port) == 465 ? PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS : PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
    $phpmailer->From = $smtp_from ?: $smtp_user;
    $phpmailer->FromName = $smtp_from_name;
    
    if (WP_DEBUG) {
        error_log("Balanz SMTP: Configured - Host=$smtp_host, Port=$smtp_port, User=$smtp_user, From=" . ($smtp_from ?: $smtp_user));
    }
}
add_action('phpmailer_init', 'balanz_configure_smtp');

/**
 * Log email failures for debugging
 */
function balanz_log_mail_failure($wp_error) {
    if (WP_DEBUG && is_wp_error($wp_error)) {
        error_log('=== WP_MAIL FAILED ===');
        error_log('Error Code: ' . $wp_error->get_error_code());
        error_log('Error Message: ' . $wp_error->get_error_message());
        $error_data = $wp_error->get_error_data();
        if ($error_data) {
            error_log('Error Data: ' . print_r($error_data, true));
        }
        error_log('======================');
    }
}
add_action('wp_mail_failed', 'balanz_log_mail_failure');

/**
 * Share with Balanz - Contact Form AJAX Handler
 */
function balanz_handle_share_form() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'balanz_nonce')) {
        wp_send_json_error([
            'message' => 'Security check failed. Please refresh the page and try again.'
        ], 403);
    }
    
    // Sanitize and validate inputs
    $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $contact = isset($_POST['contact']) ? sanitize_text_field($_POST['contact']) : '';
    $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';
    $subscribe = isset($_POST['subscribe']) && $_POST['subscribe'] === 'true';
    
    // Validation errors
    $errors = [];
    
    // Name validation
    if (empty($name)) {
        $errors['name'] = 'Please enter your name.';
    } elseif (strlen($name) < 2) {
        $errors['name'] = 'Name must be at least 2 characters.';
    } elseif (strlen($name) > 100) {
        $errors['name'] = 'Name is too long.';
    }
    
    // Contact validation (email or phone)
    if (empty($contact)) {
        $errors['contact'] = 'Please enter your phone number or email.';
    } else {
        // Check if it's an email
        $is_email = filter_var($contact, FILTER_VALIDATE_EMAIL);
        
        // Check if it's a phone (basic validation - digits, spaces, +, -, parentheses)
        $phone_clean = preg_replace('/[\s\-\(\)\+]/', '', $contact);
        $is_phone = preg_match('/^[0-9]{7,15}$/', $phone_clean);
        
        if (!$is_email && !$is_phone) {
            $errors['contact'] = 'Please enter a valid email or phone number.';
        }
    }
    
    // Message validation (optional but check length if provided)
    if (!empty($message) && strlen($message) > 2000) {
        $errors['message'] = 'Message is too long (max 2000 characters).';
    }
    
    // Return errors if any
    if (!empty($errors)) {
        wp_send_json_error([
            'message' => 'Please fix the errors below.',
            'errors' => $errors
        ], 400);
    }
    
    // Get email from ACF options (configurable by admin)
    $to = get_field('form_recipient_email', 'option');
    if (empty($to) || !is_email($to)) {
        // Fallback to admin email if ACF field not set
        $to = get_option('admin_email');
    }
    
    $subject = 'Balanz: New message from ' . $name;
    
    // Build HTML email body (reduces spam score vs plain text)
    $email_body = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color: #f5f5f5;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5; padding: 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden;">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #1a1a1a; padding: 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px;">New Contact Form Submission</h1>
                        </td>
                    </tr>
                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding: 10px 0; border-bottom: 1px solid #eee;">
                                        <strong style="color: #666;">Name:</strong><br>
                                        <span style="color: #333; font-size: 16px;">' . esc_html($name) . '</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0; border-bottom: 1px solid #eee;">
                                        <strong style="color: #666;">Contact:</strong><br>
                                        <span style="color: #333; font-size: 16px;">' . esc_html($contact) . '</span>
                                    </td>
                                </tr>';
    
    if (!empty($message)) {
        $email_body .= '
                                <tr>
                                    <td style="padding: 10px 0; border-bottom: 1px solid #eee;">
                                        <strong style="color: #666;">Message:</strong><br>
                                        <span style="color: #333; font-size: 16px;">' . nl2br(esc_html($message)) . '</span>
                                    </td>
                                </tr>';
    }
    
    $email_body .= '
                                <tr>
                                    <td style="padding: 10px 0;">
                                        <strong style="color: #666;">Subscribe to tips:</strong><br>
                                        <span style="color: #333; font-size: 16px;">' . ($subscribe ? 'Yes' : 'No') . '</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9f9f9; padding: 20px; text-align: center; font-size: 12px; color: #999;">
                            Sent from ' . esc_url(home_url()) . '<br>
                            ' . date_i18n('F j, Y \a\t g:i a') . '<br>
                            IP: ' . balanz_get_client_ip() . '
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';
    
    // Get SMTP From settings (important: must match SMTP credentials domain!)
    $smtp_from = get_field('smtp_from_email', 'option');
    $smtp_from_name = get_field('smtp_from_name', 'option') ?: 'Balanz';
    
    // Use SMTP From if configured, otherwise fallback to site domain
    if ($smtp_from && is_email($smtp_from)) {
        $from_email = $smtp_from;
        $from_name = $smtp_from_name;
    } else {
        // Fallback - but this likely won't work without SMTP!
        $from_email = 'noreply@' . parse_url(home_url(), PHP_URL_HOST);
        $from_name = 'Balanz Website';
        
        if (WP_DEBUG) {
            error_log('Balanz Form: WARNING - No SMTP From email configured! Using fallback: ' . $from_email);
        }
    }
    
    // Email headers (HTML format reduces spam score)
    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . $from_name . ' <' . $from_email . '>',
        'X-Mailer: Balanz WordPress Theme',
    ];
    
    // Add reply-to if contact is email (so admin can reply directly)
    if (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
        $headers[] = 'Reply-To: ' . $name . ' <' . $contact . '>';
    }
    
    if (WP_DEBUG) {
        error_log('Balanz Form: Sending to=' . $to . ', from=' . $from_email);
    }
    
    // Prepare submission data
    $submission_data = [
        'name' => $name,
        'contact' => $contact,
        'message' => $message,
        'subscribe' => $subscribe
    ];
    
    // Save to file as backup (always saves)
    $log_file = balanz_save_submission_to_file($submission_data, true);
    
    // Try to send email
    $sent = wp_mail($to, $subject, $email_body, $headers);
    
    // Get last error if mail failed
    $mail_error = error_get_last();
    
    if ($sent) {
        // Log successful send
        if (WP_DEBUG) {
            error_log('Balanz Form: Email sent successfully to ' . $to);
        }
        
        wp_send_json_success([
            'message' => 'Thank you! Your message has been sent successfully.'
        ]);
    } else {
        // Log failure
        if (WP_DEBUG) {
            error_log('Balanz Form: Email failed to send. Error: ' . ($mail_error['message'] ?? 'Unknown'));
            error_log('Balanz Form: Saved to file: ' . $log_file);
        }
        
        // Still return success - form data is saved to file
        // Admin can check submissions in WordPress admin
        wp_send_json_success([
            'message' => 'Thank you! Your message has been received.',
            'debug' => WP_DEBUG ? [
                'email_sent' => false,
                'saved_to' => $log_file,
                'recipient' => $to,
                'error' => $mail_error['message'] ?? 'Email sending failed'
            ] : null
        ]);
    }
}
add_action('wp_ajax_balanz_share_form', 'balanz_handle_share_form');
add_action('wp_ajax_nopriv_balanz_share_form', 'balanz_handle_share_form');

/**
 * Test SMTP Settings - Send test email
 */
function balanz_send_test_email() {
    // Check admin permission
    if (!current_user_can('manage_options')) {
        return;
    }
    
    $test_email = get_field('smtp_test_email', 'option');
    if (!$test_email || !is_email($test_email)) {
        return;
    }
    
    $subject = 'Test Email from Balanz Theme';
    $message = "This is a test email to verify your SMTP settings are working correctly.\n\n";
    $message .= "If you received this email, your SMTP configuration is successful!\n\n";
    $message .= "Sent from: " . home_url() . "\n";
    $message .= "Time: " . date('Y-m-d H:i:s');
    
    $sent = wp_mail($test_email, $subject, $message);
    
    if ($sent) {
        add_settings_error(
            'smtp_test',
            'smtp_test_success',
            'Test email sent successfully to ' . $test_email . '. Check your inbox!',
            'success'
        );
    } else {
        add_settings_error(
            'smtp_test',
            'smtp_test_error',
            'Failed to send test email. Please check your SMTP settings.',
            'error'
        );
    }
}

// Send test email when SMTP settings are saved
add_action('acf/save_post', function($post_id) {
    if ($post_id === 'options' && isset($_POST['acf']['field_5f9a1b2c3d9ec'])) {
        balanz_send_test_email();
    }
});

/**
 * Add admin page to view form submissions
 */
function balanz_add_submissions_menu() {
    add_menu_page(
        'Form Submissions',
        'Form Submissions',
        'manage_options',
        'balanz-submissions',
        'balanz_render_submissions_page',
        'dashicons-email-alt',
        30
    );
}
add_action('admin_menu', 'balanz_add_submissions_menu');

/**
 * Render submissions page
 */
function balanz_render_submissions_page() {
    $upload_dir = wp_upload_dir();
    $file = $upload_dir['basedir'] . '/form-submissions.log';
    
    echo '<div class="wrap">';
    echo '<h1>📧 Form Submissions</h1>';
    
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $file_size = size_format(filesize($file));
        $file_url = $upload_dir['baseurl'] . '/form-submissions.log';
        
        echo '<p><strong>File:</strong> ' . esc_html($file) . '</p>';
        echo '<p><strong>Size:</strong> ' . esc_html($file_size) . '</p>';
        echo '<p><a href="' . esc_url($file_url) . '" class="button" download>Download Log File</a></p>';
        
        echo '<hr>';
        
        if (!empty(trim($content))) {
            echo '<div style="background: #1e1e1e; color: #d4d4d4; padding: 20px; border-radius: 4px; overflow: auto; max-height: 80vh; font-family: monospace; font-size: 13px; line-height: 1.6;">';
            echo '<pre style="margin: 0; color: #d4d4d4;">' . esc_html($content) . '</pre>';
            echo '</div>';
        } else {
            echo '<p>No submissions yet.</p>';
        }
        
        // Clear log button
        if (!empty(trim($content))) {
            echo '<hr>';
            echo '<form method="post" style="margin-top: 20px;">';
            wp_nonce_field('balanz_clear_log', 'balanz_clear_log_nonce');
            echo '<button type="submit" name="clear_log" class="button button-secondary" onclick="return confirm(\'Are you sure you want to clear all submissions?\')">Clear All Submissions</button>';
            echo '</form>';
        }
    } else {
        echo '<div class="notice notice-warning"><p>No submissions file found yet. The file will be created automatically when someone submits the form.</p></div>';
        echo '<p><strong>Expected location:</strong> <code>' . esc_html($file) . '</code></p>';
    }
    
    echo '</div>';
    
    // Handle clear log action
    if (isset($_POST['clear_log']) && check_admin_referer('balanz_clear_log', 'balanz_clear_log_nonce')) {
        if (file_exists($file)) {
            unlink($file);
            echo '<div class="notice notice-success"><p>All submissions have been cleared.</p></div>';
            echo '<script>setTimeout(function(){ window.location.reload(); }, 1000);</script>';
        }
    }
}
