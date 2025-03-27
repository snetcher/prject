<?php
/**
 * Theme Options Page
 */

function voice_smm_add_theme_page() {
    add_menu_page(
        'Theme Settings', // Page title
        'Theme Settings', // Menu text
        'manage_options', // Required permissions
        'voice-smm-settings', // Page slug
        'voice_smm_theme_page_html', // Display function
        'dashicons-admin-generic', // Icon
        60 // Menu position
    );
}
add_action('admin_menu', 'voice_smm_add_theme_page');

// Settings registration
function voice_smm_settings_init() {
    // Register settings group
    register_setting('voice_smm_options', 'voice_smm_options');

    // Add section for contacts
    add_settings_section(
        'voice_smm_contacts_section',
        'Contact Information',
        'voice_smm_contacts_section_cb',
        'voice-smm-settings'
    );

    // Add fields
    add_settings_field(
        'voice_smm_phone',
        'Phone',
        'voice_smm_text_field_cb',
        'voice-smm-settings',
        'voice_smm_contacts_section',
        array('label_for' => 'phone', 'placeholder' => '+1 (234) 567-8900')
    );

    add_settings_field(
        'voice_smm_email',
        'Email',
        'voice_smm_text_field_cb',
        'voice-smm-settings',
        'voice_smm_contacts_section',
        array('label_for' => 'email', 'placeholder' => 'example@domain.com')
    );

    add_settings_field(
        'voice_smm_facebook',
        'Facebook',
        'voice_smm_text_field_cb',
        'voice-smm-settings',
        'voice_smm_contacts_section',
        array('label_for' => 'facebook', 'placeholder' => 'https://facebook.com/username')
    );

    add_settings_field(
        'voice_smm_instagram',
        'Instagram',
        'voice_smm_text_field_cb',
        'voice-smm-settings',
        'voice_smm_contacts_section',
        array('label_for' => 'instagram', 'placeholder' => 'https://instagram.com/username')
    );

    add_settings_field(
        'voice_smm_whatsapp',
        'WhatsApp',
        'voice_smm_text_field_cb',
        'voice-smm-settings',
        'voice_smm_contacts_section',
        array('label_for' => 'whatsapp', 'placeholder' => '+12345678900')
    );

    add_settings_field(
        'voice_smm_telegram',
        'Telegram',
        'voice_smm_text_field_cb',
        'voice-smm-settings',
        'voice_smm_contacts_section',
        array('label_for' => 'telegram', 'placeholder' => '@username or https://t.me/username')
    );
}
add_action('admin_init', 'voice_smm_settings_init');

// Section callback
function voice_smm_contacts_section_cb($args) {
    ?>
    <p>Enter contact information to display on the website.</p>
    <?php
}

// Text fields callback
function voice_smm_text_field_cb($args) {
    $options = get_option('voice_smm_options');
    ?>
    <input type="text" 
           id="<?php echo esc_attr($args['label_for']); ?>"
           name="voice_smm_options[<?php echo esc_attr($args['label_for']); ?>]"
           value="<?php echo isset($options[$args['label_for']]) ? esc_attr($options[$args['label_for']]) : ''; ?>"
           placeholder="<?php echo esc_attr($args['placeholder']); ?>"
           class="regular-text">
    <?php
}

// Settings page HTML
function voice_smm_theme_page_html() {
    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_GET['settings-updated'])) {
        add_settings_error('voice_smm_messages', 'voice_smm_message', 'Settings saved', 'updated');
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <?php settings_errors('voice_smm_messages'); ?>
        <form action="options.php" method="post">
            <?php
            settings_fields('voice_smm_options');
            do_settings_sections('voice-smm-settings');
            submit_button('Save Settings');
            ?>
        </form>
    </div>
    <?php
}

// Helper function for getting contact data
function voice_smm_get_contact($key) {
    $options = get_option('voice_smm_options');
    return isset($options[$key]) ? $options[$key] : '';
} 