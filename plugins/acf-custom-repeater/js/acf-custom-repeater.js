(function($) {
    'use strict';

    console.log('ACF Custom Repeater - Module loaded');

    if (typeof acf === 'undefined') {
        console.error('ACF Custom Repeater - ACF is not loaded');
        return;
    }

    // Debug info
    console.log('ACF Custom Repeater - Configuration:', acfcr_data);

    // Create new ACF field type
    var CustomRepeater = acf.Field.extend({
        type: 'custom_repeater',
        
        wait: 'ready',
        
        events: {
            'click [data-name="add-row"]': 'onClickAdd',
            'click [data-name="remove-row"]': 'onClickRemove',
            'mouseenter [data-name="add-row"]': 'onHoverAdd',
        },
        
        initialize: function() {
            console.log('ACF Custom Repeater - Field initialized:', this);
            
            // Set up sortable if enabled
            if (this.get('sortable')) {
                this.$rows().sortable({
                    items: '> .acf-row',
                    handle: '> .acf-row-handle',
                    forceHelperSize: true,
                    forcePlaceholderSize: true,
                    scroll: true,
                    stop: this.proxy(function() {
                        this.$input().trigger('change');
                    })
                });
            }
        },
        
        $rows: function() {
            return this.$('.acf-repeater-rows');
        },
        
        $row: function(index) {
            return this.$('.acf-row:eq(' + index + ')');
        },
        
        $input: function() {
            return this.$('input[type="hidden"]');
        },
        
        onClickAdd: function(e) {
            e.preventDefault();
            console.log('ACF Custom Repeater - Add row clicked');
            
            var $row = this.addRow();
            if ($row) {
                this.$input().trigger('change');
            }
        },
        
        onClickRemove: function(e) {
            e.preventDefault();
            console.log('ACF Custom Repeater - Remove row clicked');
            
            var $row = $(e.target).closest('.acf-row');
            this.removeRow($row);
            this.$input().trigger('change');
        },
        
        onHoverAdd: function(e) {
            console.log('ACF Custom Repeater - Add button hovered');
        },
        
        addRow: function() {
            // Check max rows
            var maxRows = parseInt(this.get('max_rows'));
            if (maxRows && this.$rows().children('.acf-row').length >= maxRows) {
                alert('Maximum rows reached (' + maxRows + ')');
                return false;
            }
            
            // Clone row template
            var $row = this.$('.acf-repeater-row-template').clone();
            $row.removeClass('acf-repeater-row-template');
            
            // Add row
            this.$rows().append($row);
            
            // Enable inputs
            acf.enable($row);
            
            return $row;
        },
        
        removeRow: function($row) {
            // Check min rows
            var minRows = parseInt(this.get('min_rows'));
            if (minRows && this.$rows().children('.acf-row').length <= minRows) {
                alert('Minimum rows reached (' + minRows + ')');
                return false;
            }
            
            // Remove row
            acf.remove($row);
            
            return true;
        }
    });
    
    // Register field type
    acf.registerFieldType(CustomRepeater);
    console.log('ACF Custom Repeater - Field type registered');

})(jQuery);