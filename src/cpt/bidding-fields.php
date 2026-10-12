<?php
// Register ACF fields for Bidding CPT
if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
        'key' => 'group_bidding_fields',
        'title' => 'Bidding Fields',
        'fields' => array(
            array(
                'key' => 'field_bidding_due_date',
                'label' => 'Due Date',
                'name' => 'due_date',
                'type' => 'date_picker',
                'display_format' => 'Y-m-d',
                'return_format' => 'Y-m-d',
                'required' => 1,
            ),
            array(
                'key' => 'field_bidding_custom_bid_url',
                'label' => 'Custom Bid URL',
                'name' => 'custom_bid_url',
                'type' => 'url',
                'required' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'bidding',
                ),
            ),
        ),
        'position' => 'side', // Add this line
    ));
}
