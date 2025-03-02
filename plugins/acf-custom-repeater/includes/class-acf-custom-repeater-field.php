<?php
/**
 * ACF Custom Repeater Field Class
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Check if we have ACF
if (!class_exists('acf_field')) {
    return;
}

if (!class_exists('ACFCR_Custom_Repeater_Field')) {
    class ACFCR_Custom_Repeater_Field extends acf_field {
        /**
         * Initialize the field type
         */
        function __construct() {
            error_log('ACF Custom Repeater Field - Constructor called');
            
            // Field name and label
            $this->name = 'custom_repeater';
            $this->label = __('Custom Repeater', 'acf-custom-repeater');
            $this->category = 'layout';
            $this->defaults = array(
                'sub_fields'     => array(),
                'min'            => 0,
                'max'            => 0,
                'layout'         => 'table',
                'button_label'   => __('Add Row', 'acf-custom-repeater'),
                'collapsed'      => ''
            );
            
            // Do the parent constructor
            parent::__construct();
            
            error_log('ACF Custom Repeater Field - Constructor finished');
        }

        /**
         * Create the HTML interface for your field
         */
        function render_field($field) {
            error_log('ACF Custom Repeater - Rendering field input');
            error_log('Field: ' . print_r($field, true));

            // Ensure field has rows
            $field['value'] = isset($field['value']) ? $field['value'] : array();
            
            // Get the layout
            $layout = isset($field['layout']) ? $field['layout'] : 'table';
            
            // Set default button label
            if (!$field['button_label']) {
                $field['button_label'] = __('Add Row', 'acf');
            }
            
            // Create the hidden input that stores the array of rows
            acf_hidden_input(array(
                'name'  => $field['name'],
                'value' => ''
            ));
            
            ?>
            <div class="acf-repeater" data-min="<?php echo esc_attr($field['min']); ?>" 
                                    data-max="<?php echo esc_attr($field['max']); ?>">
                <table class="acf-table">
                    <?php if (!empty($field['sub_fields'])): ?>
                    <thead>
                        <tr>
                            <?php foreach ($field['sub_fields'] as $sub_field): ?>
                                <th class="acf-th">
                                    <label><?php echo esc_html($sub_field['label']); ?></label>
                                    <?php if(isset($sub_field['instructions'])): ?>
                                        <p class="description"><?php echo esc_html($sub_field['instructions']); ?></p>
                                    <?php endif; ?>
                                </th>
                            <?php endforeach; ?>
                            <th class="acf-row-handle"></th>
                        </tr>
                    </thead>
                    <?php endif; ?>
                    
                    <tbody>
                        <?php 
                        if (!empty($field['value'])): 
                            foreach ($field['value'] as $i => $row):
                                $this->render_row($field, $i, $row);
                            endforeach;
                        endif;
                        
                        // Create an empty row as template
                        $this->render_row($field, 'acfcloneindex', array());
                        ?>
                    </tbody>
                </table>
                
                <div class="acf-actions">
                    <a class="acf-button button button-primary" href="#" data-event="add-row">
                        <?php echo esc_html($field['button_label']); ?>
                    </a>
                </div>
            </div>
            <?php
        }

        /**
         * Create extra settings for your field
         */
        function render_field_settings($field) {
            error_log('ACF Custom Repeater - Rendering field settings');
            
            // Sub Fields
            acf_render_field_setting($field, array(
                'label'         => __('Sub Fields','acf'),
                'instructions'  => __('Add the sub fields for your repeater','acf'),
                'type'         => 'repeater',
                'name'         => 'sub_fields',
                'prefix'       => $field['prefix'],
                'value'        => $field['sub_fields'],
                'fields'       => array(
                    array(
                        'type'      => 'text',
                        'name'      => 'label',
                        'label'     => __('Label', 'acf'),
                        'required'  => 1,
                    ),
                    array(
                        'type'      => 'text',
                        'name'      => 'name',
                        'label'     => __('Name', 'acf'),
                        'required'  => 1,
                    ),
                    array(
                        'type'      => 'select',
                        'name'      => 'type',
                        'label'     => __('Type', 'acf'),
                        'required'  => 1,
                        'choices'   => acf_get_field_types(),
                    ),
                ),
            ));
            
            // Layout
            acf_render_field_setting($field, array(
                'label'         => __('Layout','acf'),
                'instructions'  => __('Select the layout for this repeater field','acf'),
                'type'         => 'radio',
                'name'         => 'layout',
                'layout'       => 'horizontal',
                'choices'      => array(
                    'table'    => __('Table','acf'),
                    'block'    => __('Block','acf'),
                    'row'      => __('Row','acf')
                )
            ));
            
            // Min
            acf_render_field_setting($field, array(
                'label'         => __('Minimum Rows','acf'),
                'instructions'  => __('Set a minimum number of rows that must be created','acf'),
                'type'         => 'number',
                'name'         => 'min',
            ));
            
            // Max
            acf_render_field_setting($field, array(
                'label'         => __('Maximum Rows','acf'),
                'instructions'  => __('Set a maximum number of rows that can be created (0 = unlimited)','acf'),
                'type'         => 'number',
                'name'         => 'max',
            ));
            
            // Button Label
            acf_render_field_setting($field, array(
                'label'         => __('Button Label','acf'),
                'instructions'  => __('Customize the add row button text','acf'),
                'type'         => 'text',
                'name'         => 'button_label',
                'placeholder'  => __('Add Row','acf'),
            ));
        }

        /**
         * Render individual row
         */
        function render_row($field, $i, $value) {
            error_log('ACF Custom Repeater - Rendering row ' . $i);
            
            // Add clone class
            $class = 'acf-row';
            if ($i === 'acfcloneindex') {
                $class .= ' acf-clone';
            }
            ?>
            <tr class="<?php echo esc_attr($class); ?>" data-id="<?php echo esc_attr($i); ?>">
                <?php 
                if (!empty($field['sub_fields'])):
                    foreach ($field['sub_fields'] as $sub_field):
                        // Prepare sub field
                        $sub_field = acf_get_valid_field($sub_field);
                        $sub_field['value'] = isset($value[$sub_field['key']]) ? $value[$sub_field['key']] : '';
                        $sub_field['name'] = $field['name'] . '[' . $i . '][' . $sub_field['key'] . ']';
                        ?>
                        <td class="acf-field">
                            <?php acf_render_field_wrap($sub_field); ?>
                        </td>
                        <?php
                    endforeach;
                endif;
                ?>
                <td class="acf-row-handle">
                    <a class="acf-icon -minus small" href="#" data-event="remove-row" title="<?php _e('Remove row', 'acf'); ?>"></a>
                </td>
            </tr>
            <?php
        }

        /**
         * Update field value
         */
        function update_value($value, $post_id, $field) {
            error_log('ACF Custom Repeater - Updating value');
            error_log('Value: ' . print_r($value, true));
            
            // Bail early if no value
            if (empty($value)) {
                return $value;
            }
            
            // Convert to array if string
            if (is_string($value)) {
                $value = acf_decode_choices($value);
            }
            
            // Return value
            return $value;
        }

        /**
         * Load field value
         */
        function load_value($value, $post_id, $field) {
            error_log('ACF Custom Repeater - Loading value');
            error_log('Value: ' . print_r($value, true));
            
            // Return value or empty array
            return $value ? $value : array();
        }
    }
    
    // Initialize
    acf_register_field_type('ACFCR_Custom_Repeater_Field');
}
