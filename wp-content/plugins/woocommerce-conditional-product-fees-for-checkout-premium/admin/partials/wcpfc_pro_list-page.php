<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

////////////////////////
////// New Layout //////
////////////////////////

/**
 * WCPFC_Rule_Listing_Page class.
 */
if ( ! class_exists( 'WCPFC_Rule_Listing_Page' ) ) {

    class WCPFC_Rule_Listing_Page {

        /**
         * Output the Admin UI
         *
         * @since 3.9.0
         */
        const wcpfc_post_type = 'wc_conditional_fee';
        private static $admin_object = null;

        /**
         * Display output
         *
         * @since 3.5
         *
         * @uses wcpfc_sj_save_method
         * @uses wcpfc_sj_add_extra_fee_form
         * @uses wcpfc_sj_edit_method_screen
         * @uses wcpfc_sj_delete_method
         * @uses wcpfc_sj_duplicate_method
         * @uses wcpfc_sj_list_methods_screen
         *
         * @access   public
         */
        public static function wcpfc_sj_output() {
            self::$admin_object = new Woocommerce_Conditional_Product_Fees_For_Checkout_Pro_Admin( '', '' );
            $action             = filter_input( INPUT_GET, 'action', FILTER_SANITIZE_STRING );
            $post_id_request    = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT );
            $get_wcpfc_add      = filter_input( INPUT_GET, '_wpnonce', FILTER_SANITIZE_STRING );
            if ( isset( $action ) && ! empty( $action ) ) {
                if ( 'add' === $action ) {
                    self::wcpfc_sj_save_method();
                    self::wcpfc_sj_add_extra_fee_form();
                } elseif ( 'edit' === $action ) {
                    if ( isset( $get_wcpfc_add ) && ! empty( $get_wcpfc_add ) ) {
                        $getnonce = wp_verify_nonce( $get_wcpfc_add, 'edit_' . $post_id_request );
                        if ( isset( $getnonce ) && 1 === $getnonce ) {
                            self::wcpfc_sj_save_method( $post_id_request );
                            self::wcpfc_sj_edit_method();
                        } else {
                            self::$admin_object->wcpfc_updated_message( 'nonce_check', "" );
                        }
                    }
                } elseif ( 'delete' === $action ) {
                    self::wcpfc_sj_delete_method( $post_id_request );
                } elseif ( 'duplicate' === $action ) {
                    self::wcpfc_sj_duplicate_method( $post_id_request );
                } else {
                    self::wcpfc_sj_list_methods_screen();
                }
            } else {
                self::wcpfc_sj_list_methods_screen();
            }
        }

        /**
         * Save extra fee method when add or edit
         *
         * @param int $method_id
         *
         * @return bool false when nonce is not verified, $zone id, $zone_type is blank, Country also blank, Postcode field also blank, saving error when form submit
         * @uses dpad_sm_count_method()
         *
         * @since    3.5
         *
         * @uses Woocommerce_Dynamic_Pricing_And_Discount_Pro_Admin::dpad_updated_message()
         */
        public static function wcpfc_sj_save_method( $method_id = 0 ){
            global $sitepress;
            if ( is_network_admin() ) {
                $admin_url = admin_url( 'admin.php' );
            } else {
                $admin_url = admin_url( 'admin.php' );
            }
            $action                     = filter_input( INPUT_GET, 'action', FILTER_SANITIZE_STRING );
            $post_type                 = filter_input( INPUT_POST, 'post_type', FILTER_SANITIZE_STRING );
            $wcpfc_pro_conditions_save  = filter_input( INPUT_POST, 'wcpfc_pro_fees_conditions_save', FILTER_SANITIZE_STRING );
            if ( isset( $wcpfc_pro_conditions_save ) && wp_verify_nonce( sanitize_text_field( $wcpfc_pro_conditions_save ), 'wcpfc_pro_fees_conditions_save_action' ) && self::wcpfc_post_type === $post_type ) {
                if ( ( isset( $action ) && ! empty( $action ) ) ) {
                    delete_transient( "get_all_fees" );
                    $get_method_id                      = filter_input( INPUT_POST, 'fee_post_id', FILTER_SANITIZE_NUMBER_INT );
                    $get_fee_settings_product_fee_title = filter_input( INPUT_POST, 'fee_settings_product_fee_title', FILTER_SANITIZE_STRING );
                    $get_fee_settings_product_cost      = filter_input( INPUT_POST, 'fee_settings_product_cost', FILTER_SANITIZE_STRING );
                    $get_fee_settings_select_fee_type   = filter_input( INPUT_POST, 'fee_settings_select_fee_type', FILTER_SANITIZE_STRING );
                    $get_fee_settings_start_date        = filter_input( INPUT_POST, 'fee_settings_start_date', FILTER_SANITIZE_STRING );
                    $get_fee_settings_end_date          = filter_input( INPUT_POST, 'fee_settings_end_date', FILTER_SANITIZE_STRING );
                    $get_fee_settings_status            = filter_input( INPUT_POST, 'fee_settings_status', FILTER_SANITIZE_STRING );
                    $get_fee_settings_select_taxable    = filter_input( INPUT_POST, 'fee_settings_select_taxable', FILTER_SANITIZE_STRING );
                    $get_fee_show_on_checkout_only      = filter_input( INPUT_POST, 'fee_show_on_checkout_only', FILTER_SANITIZE_STRING );
                    $get_fees_on_cart_total            	= filter_input( INPUT_POST, 'fees_on_cart_total', FILTER_SANITIZE_STRING );
                    $get_ds_time_from            		= filter_input( INPUT_POST, 'ds_time_from', FILTER_SANITIZE_STRING );
                    $get_ds_time_to            			= filter_input( INPUT_POST, 'ds_time_to', FILTER_SANITIZE_STRING );
                    $get_ds_select_day_of_week          = filter_input( INPUT_POST, 'ds_select_day_of_week', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY );

                    $method_id                          = !empty($get_method_id) ? intval($get_method_id) : 0;
                    $fee_settings_product_fee_title     = isset( $get_fee_settings_product_fee_title ) ? sanitize_text_field( $get_fee_settings_product_fee_title ) : '';
                    $fee_settings_product_cost          = isset( $get_fee_settings_product_cost ) ? sanitize_text_field( $get_fee_settings_product_cost ) : '';
                    $fee_settings_select_fee_type       = isset( $get_fee_settings_select_fee_type ) ? sanitize_text_field( $get_fee_settings_select_fee_type ) : '';
                    $fee_settings_start_date            = isset( $get_fee_settings_start_date ) ? sanitize_text_field( $get_fee_settings_start_date ) : '';
                    $fee_settings_end_date              = isset( $get_fee_settings_end_date ) ? sanitize_text_field( $get_fee_settings_end_date ) : '';
                    $fee_settings_status                = isset( $get_fee_settings_status ) ? sanitize_text_field( $get_fee_settings_status ) : 'off';
                    $fee_settings_select_taxable        = isset( $get_fee_settings_select_taxable ) ? sanitize_text_field( $get_fee_settings_select_taxable ) : '';
                    $fee_show_on_checkout_only          = isset( $get_fee_show_on_checkout_only ) ? sanitize_text_field( $get_fee_show_on_checkout_only ) : '';
                    $fees_on_cart_total                 = isset( $get_fees_on_cart_total ) ? sanitize_text_field( $get_fees_on_cart_total ) : '';
                    $ds_time_from                  		= isset( $get_ds_time_from ) ? sanitize_text_field( $get_ds_time_from ) : '';
                    $ds_time_to                  		= isset( $get_ds_time_to ) ? sanitize_text_field( $get_ds_time_to ) : '';
                    $ds_select_day_of_week              = isset( $get_ds_select_day_of_week ) ? array_map( 'sanitize_text_field', $get_ds_select_day_of_week ) : array();

                    if( !empty($fee_settings_product_fee_title) ){
                        $fee_exist = post_exists($fee_settings_product_fee_title, '', '',self::wcpfc_post_type);
                        if( ($fee_exist > 0 && $action === 'add') || ( $fee_exist > 0 && $fee_exist !== $method_id && $action === 'edit') ){
                            wp_safe_redirect( add_query_arg( array(
                                'page'      => 'wcpfc-pro-list',
                                'message'   => 'exist'
                            ), $admin_url ) );
                            exit();
                        }
                    }

                    $get_condition_key                  = filter_input( INPUT_POST, 'condition_key', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY );
                    $fees                               = filter_input( INPUT_POST, 'fees', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY );
                    
                    if ( wcpffc_fs()->is__premium_only() ) {
                        if ( wcpffc_fs()->can_use_premium_code() ) {
                            $get_fee_chk_qty_price                      = filter_input( INPUT_POST, 'fee_chk_qty_price', FILTER_SANITIZE_STRING );
                            $get_fee_per_qty                            = filter_input( INPUT_POST, 'fee_per_qty', FILTER_SANITIZE_STRING );
                            $get_extra_product_cost                     = filter_input( INPUT_POST, 'extra_product_cost', FILTER_SANITIZE_STRING );
                            $get_fee_settings_select_optional           = filter_input( INPUT_POST, 'fee_settings_select_optional', FILTER_SANITIZE_STRING );
                            $get_fee_settings_optional_type             = filter_input( INPUT_POST, 'fee_settings_optional_type', FILTER_SANITIZE_STRING );
                            $get_fee_settings_optional_description      = filter_input( INPUT_POST, 'fee_settings_optional_description', FILTER_SANITIZE_STRING );
                            $get_default_optional_checked 	            = filter_input( INPUT_POST, 'default_optional_checked', FILTER_SANITIZE_STRING );

                            $get_is_allow_custom_weight_base			= filter_input( INPUT_POST, 'is_allow_custom_weight_base', FILTER_SANITIZE_STRING );
                            $get_sm_custom_weight_base_cost				= filter_input( INPUT_POST, 'sm_custom_weight_base_cost', FILTER_SANITIZE_STRING );
                            $get_sm_custom_weight_base_per_each			= filter_input( INPUT_POST, 'sm_custom_weight_base_per_each', FILTER_SANITIZE_STRING );
                            $get_sm_custom_weight_base_over				= filter_input( INPUT_POST, 'sm_custom_weight_base_over', FILTER_SANITIZE_STRING );

                            $fee_chk_qty_price                          = isset( $get_fee_chk_qty_price ) ? sanitize_text_field( $get_fee_chk_qty_price ) : 'off';
                            $fee_per_qty                                = isset( $get_fee_per_qty ) ? sanitize_text_field( $get_fee_per_qty ) : '';
                            $extra_product_cost                         = isset( $get_extra_product_cost ) ? sanitize_text_field( $get_extra_product_cost ) : '';
                            $fee_settings_select_optional               = isset( $get_fee_settings_select_optional ) ? sanitize_text_field( $get_fee_settings_select_optional ) : 'checkbox';
                            $fee_settings_optional_type                 = isset( $get_fee_settings_optional_type ) ? sanitize_text_field( $get_fee_settings_optional_type ) : '';
                            $fee_settings_optional_description          = isset( $get_fee_settings_optional_description ) ? sanitize_text_field( $get_fee_settings_optional_description ) : '';
                            $default_optional_checked               	= isset( $get_default_optional_checked ) ? sanitize_text_field( $get_default_optional_checked ) : '';
                            
                            $is_allow_custom_weight_base        		= isset( $get_is_allow_custom_weight_base ) ? sanitize_text_field( $get_is_allow_custom_weight_base ) : '';
                            $sm_custom_weight_base_cost         		= isset( $get_sm_custom_weight_base_cost ) ? sanitize_text_field( $get_sm_custom_weight_base_cost ) : '';
                            $sm_custom_weight_base_per_each    			= isset( $get_sm_custom_weight_base_per_each ) ? sanitize_text_field( $get_sm_custom_weight_base_per_each ) : '';
                            $sm_custom_weight_base_over        			= isset( $get_sm_custom_weight_base_over ) ? sanitize_text_field( $get_sm_custom_weight_base_over ) : '';

                            $get_fee_settings_tooltip_desc              = filter_input( INPUT_POST, 'wcpfc_tooltip_desc', FILTER_SANITIZE_STRING );
                            $get_first_order_for_user              		= filter_input( INPUT_POST, 'first_order_for_user', FILTER_SANITIZE_STRING );
                            $get_fee_settings_recurring            		= filter_input( INPUT_POST, 'fee_settings_recurring', FILTER_SANITIZE_STRING );
                            $get_cost_rule_match                        = filter_input( INPUT_POST, 'cost_rule_match', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY );
                            $get_ap_rule_status                         = filter_input( INPUT_POST, 'ap_rule_status', FILTER_SANITIZE_STRING );
                            $get_cost_on_product_status                 = filter_input( INPUT_POST, 'cost_on_product_status', FILTER_SANITIZE_STRING );
                            $get_cost_on_product_weight_status          = filter_input( INPUT_POST, 'cost_on_product_weight_status', FILTER_SANITIZE_STRING );
                            $get_cost_on_product_subtotal_status        = filter_input( INPUT_POST, 'cost_on_product_subtotal_status', FILTER_SANITIZE_STRING );
                            $get_cost_on_category_status                = filter_input( INPUT_POST, 'cost_on_category_status', FILTER_SANITIZE_STRING );
                            $get_cost_on_category_weight_status         = filter_input( INPUT_POST, 'cost_on_category_weight_status', FILTER_SANITIZE_STRING );
                            $get_cost_on_category_subtotal_status       = filter_input( INPUT_POST, 'cost_on_category_subtotal_status', FILTER_SANITIZE_STRING );
                            $get_cost_on_total_cart_qty_status          = filter_input( INPUT_POST, 'cost_on_total_cart_qty_status', FILTER_SANITIZE_STRING );
                            $get_cost_on_total_cart_weight_status       = filter_input( INPUT_POST, 'cost_on_total_cart_weight_status', FILTER_SANITIZE_STRING );
                            $get_cost_on_total_cart_subtotal_status     = filter_input( INPUT_POST, 'cost_on_total_cart_subtotal_status', FILTER_SANITIZE_STRING );
                            $get_cost_on_shipping_class_subtotal_status = filter_input( INPUT_POST, 'cost_on_shipping_class_subtotal_status', FILTER_SANITIZE_STRING );
                            $fee_settings_tooltip_desc                  = isset( $get_fee_settings_tooltip_desc ) ? substr(sanitize_text_field( $get_fee_settings_tooltip_desc ), 0, 25) : '';
                            $first_order_for_user                  		= isset( $get_first_order_for_user ) ? sanitize_text_field( $get_first_order_for_user ) : '';
                            $fee_settings_recurring                  	= isset( $get_fee_settings_recurring ) ? sanitize_text_field( $get_fee_settings_recurring ) : '';
                            $ap_rule_status                             = isset( $get_ap_rule_status ) ? sanitize_text_field( $get_ap_rule_status ) : 'off';
                            $cost_rule_match                            = isset( $get_cost_rule_match ) ? array_map( 'sanitize_text_field', $get_cost_rule_match ) : array();
                            $cost_on_product_status                     = isset( $get_cost_on_product_status ) ? sanitize_text_field( $get_cost_on_product_status ) : 'off';
                            $cost_on_product_weight_status              = isset( $get_cost_on_product_weight_status ) ? sanitize_text_field( $get_cost_on_product_weight_status ) : 'off';
                            $cost_on_product_subtotal_status            = isset( $get_cost_on_product_subtotal_status ) ? sanitize_text_field( $get_cost_on_product_subtotal_status ) : 'off';
                            $cost_on_category_status                    = isset( $get_cost_on_category_status ) ? sanitize_text_field( $get_cost_on_category_status ) : 'off';
                            $cost_on_category_weight_status             = isset( $get_cost_on_category_weight_status ) ? sanitize_text_field( $get_cost_on_category_weight_status ) : 'off';
                            $cost_on_category_subtotal_status           = isset( $get_cost_on_category_subtotal_status ) ? sanitize_text_field( $get_cost_on_category_subtotal_status ) : 'off';
                            $cost_on_total_cart_qty_status              = isset( $get_cost_on_total_cart_qty_status ) ? sanitize_text_field( $get_cost_on_total_cart_qty_status ) : 'off';
                            $cost_on_total_cart_weight_status           = isset( $get_cost_on_total_cart_weight_status ) ? sanitize_text_field( $get_cost_on_total_cart_weight_status ) : 'off';
                            $cost_on_total_cart_subtotal_status         = isset( $get_cost_on_total_cart_subtotal_status ) ? sanitize_text_field( $get_cost_on_total_cart_subtotal_status ) : 'off';
                            $cost_on_shipping_class_subtotal_status     = isset( $get_cost_on_shipping_class_subtotal_status ) ? sanitize_text_field( $get_cost_on_shipping_class_subtotal_status ) : 'off';
                        }
                    }
                    if ( isset( $fee_settings_status ) && ! empty( $fee_settings_status ) && "on" === $fee_settings_status ) {
                        $post_status = 'publish';
                    } else {
                        $post_status = 'draft';
                    }
                    $wcpfc_fee_count = self::wcpfc_sj_count_method();
                    if ( '' === $method_id || 0 === $method_id ) {
                        $fee_post = array(
                            'post_title'  => wp_strip_all_tags( $fee_settings_product_fee_title ),
                            'post_status' => $post_status,
                            'post_type'   => self::wcpfc_post_type,
                            'menu_order'  => $wcpfc_fee_count + 1,
                        );
                        $post_id  = wp_insert_post( $fee_post );
                    } else {
                        $fee_post = array(
                            'ID'          => sanitize_text_field( $method_id ),
                            'post_title'  => wp_strip_all_tags( $fee_settings_product_fee_title ),
                            'post_status' => $post_status,
                            'post_type'   => self::wcpfc_post_type,
                        );
                        $post_id  = wp_update_post( $fee_post );
                    }
                    if ( '' !== $post_id && 0 !== $post_id ) {
                        if ( $post_id > 0 ) {
                            $feesArray             = array();
                            $conditionsValuesArray = array();
                            $condition_key         = isset( $get_condition_key ) ? $get_condition_key : array();
                            $fees_conditions       = $fees['product_fees_conditions_condition'];
                            $conditions_is         = $fees['product_fees_conditions_is'];
                            $conditions_values     = isset( $fees['product_fees_conditions_values'] ) && ! empty( $fees['product_fees_conditions_values'] ) ? $fees['product_fees_conditions_values'] : array();
                            $size                  = count( $fees_conditions );
                            foreach ( array_keys( $condition_key ) as $key ) {
                                if ( ! array_key_exists( $key, $conditions_values ) ) {
                                    $conditions_values[ $key ] = array();
                                }
                            }
                            uksort( $conditions_values, 'strnatcmp' );
                            foreach ( $conditions_values as $v ) {
                                $conditionsValuesArray[] = $v;
                            }
                            for ( $i = 0; $i < $size; $i ++ ) {
                                $feesArray[] = array(
                                    'product_fees_conditions_condition' => $fees_conditions[ $i ],
                                    'product_fees_conditions_is'        => $conditions_is[ $i ],
                                    'product_fees_conditions_values'    => $conditionsValuesArray[ $i ],
                                );
                            }
                            
                            update_post_meta( $post_id, 'fee_settings_product_cost', $fee_settings_product_cost );
                            update_post_meta( $post_id, 'fee_settings_select_fee_type', $fee_settings_select_fee_type );
                            update_post_meta( $post_id, 'fee_settings_start_date', $fee_settings_start_date );
                            update_post_meta( $post_id, 'fee_settings_end_date', $fee_settings_end_date );
                            update_post_meta( $post_id, 'fee_settings_status', $fee_settings_status );
                            update_post_meta( $post_id, 'fee_settings_select_taxable', $fee_settings_select_taxable );
                            update_post_meta( $post_id, 'fee_show_on_checkout_only', $fee_show_on_checkout_only );
                            update_post_meta( $post_id, 'fees_on_cart_total', $fees_on_cart_total );
                            update_post_meta( $post_id, 'ds_time_from', $ds_time_from );
                            update_post_meta( $post_id, 'ds_time_to', $ds_time_to );
                            update_post_meta( $post_id, 'ds_select_day_of_week', $ds_select_day_of_week );
                            
                            update_post_meta( $post_id, 'product_fees_metabox', $feesArray );
                            if ( wcpffc_fs()->is__premium_only() ) {
                                if ( wcpffc_fs()->can_use_premium_code() ) {
                                    $ap_product_arr                 = array();
                                    $ap_product_weight_arr          = array();
                                    $ap_product_subtotal_arr        = array();
                                    $ap_category_arr                = array();
                                    $ap_category_weight_arr         = array();
                                    $ap_category_subtotal_arr       = array();
                                    $ap_total_cart_qty_arr          = array();
                                    $ap_total_cart_weight_arr       = array();
                                    $ap_total_cart_subtotal_arr     = array();
                                    $ap_shipping_class_subtotal_arr = array();
                                    /* Apply per quantity postmeta start */
                                    update_post_meta( $post_id, 'fee_settings_select_optional', $fee_settings_select_optional );
                                    update_post_meta( $post_id, 'fee_settings_optional_type', $fee_settings_optional_type );
                                    update_post_meta( $post_id, 'fee_settings_optional_description', $fee_settings_optional_description );
                                    update_post_meta( $post_id, 'default_optional_checked', $default_optional_checked );
                                    update_post_meta( $post_id, 'fee_chk_qty_price', $fee_chk_qty_price );
                                    update_post_meta( $post_id, 'fee_per_qty', $fee_per_qty );
                                    update_post_meta( $post_id, 'extra_product_cost', $extra_product_cost );
                                    /* Apply per quantity postmeta end */

                                    /** Apply per weight postmeta start */
                                    update_post_meta( $post_id, 'is_allow_custom_weight_base', $is_allow_custom_weight_base );
                                    update_post_meta( $post_id, 'sm_custom_weight_base_cost', $sm_custom_weight_base_cost );
                                    update_post_meta( $post_id, 'sm_custom_weight_base_per_each', $sm_custom_weight_base_per_each );
                                    update_post_meta( $post_id, 'sm_custom_weight_base_over', $sm_custom_weight_base_over );
                                    /**Apply per weight postmeta end */
                                    
                                    update_post_meta( $post_id, 'ap_rule_status', $ap_rule_status );
                                    update_post_meta( $post_id, 'cost_rule_match', maybe_serialize( $cost_rule_match ) );
                                    /* Advance Pricing Rules Particular Status */
                                    update_post_meta( $post_id, 'cost_on_product_status', $cost_on_product_status );
                                    update_post_meta( $post_id, 'cost_on_product_weight_status', $cost_on_product_weight_status );
                                    update_post_meta( $post_id, 'cost_on_product_subtotal_status', $cost_on_product_subtotal_status );
                                    update_post_meta( $post_id, 'cost_on_category_status', $cost_on_category_status );
                                    update_post_meta( $post_id, 'cost_on_category_weight_status', $cost_on_category_weight_status );
                                    update_post_meta( $post_id, 'cost_on_category_subtotal_status', $cost_on_category_subtotal_status );
                                    update_post_meta( $post_id, 'cost_on_total_cart_qty_status', $cost_on_total_cart_qty_status );
                                    update_post_meta( $post_id, 'cost_on_total_cart_weight_status', $cost_on_total_cart_weight_status );
                                    update_post_meta( $post_id, 'cost_on_total_cart_subtotal_status', $cost_on_total_cart_subtotal_status );
                                    update_post_meta( $post_id, 'cost_on_shipping_class_subtotal_status', $cost_on_shipping_class_subtotal_status );
                                    update_post_meta( $post_id, 'fee_settings_tooltip_desc', $fee_settings_tooltip_desc );
                                    update_post_meta( $post_id, 'first_order_for_user', $first_order_for_user );
                                    update_post_meta( $post_id, 'fee_settings_recurring', $fee_settings_recurring );
                                    //qty for Multiple product
                                    //define advanced pricing Product variables
                                    if ( isset( $fees['ap_product_fees_conditions_condition'] ) ) {
                                        $fees_products         	= $fees['ap_product_fees_conditions_condition'];
                                        $fees_ap_prd_min_qty   	= $fees['ap_fees_ap_prd_min_qty'];
                                        $fees_ap_prd_max_qty   	= $fees['ap_fees_ap_prd_max_qty'];
                                        $fees_ap_price_product 	= $fees['ap_fees_ap_price_product'];
                                        $fees_ap_per_product 	= $fees['ap_fees_ap_per_product'];
                                        $prd_arr               = array();
                                        foreach ( $fees_products as $fees_prd_val ) {
                                            $prd_arr[] = $fees_prd_val;
                                        }
                                        $size_product_cond = count( $fees_products );
                                        if ( ! empty( $size_product_cond ) && $size_product_cond > 0 ):
                                            for ( $product_cnt = 0; $product_cnt < $size_product_cond; $product_cnt ++ ) {
                                                foreach ( $prd_arr as $prd_key => $prd_val ) {
                                                    if ( $prd_key === $product_cnt ) {
                                                        $fees_ap_per_product[ $product_cnt ] = isset($fees_ap_per_product[ $product_cnt ]) ? $fees_ap_per_product[ $product_cnt ] : 'no';
                                                        $ap_product_arr[] = array(
                                                            'ap_fees_products'         	=> $prd_val,
                                                            'ap_fees_ap_prd_min_qty'  	=> $fees_ap_prd_min_qty[ $product_cnt ],
                                                            'ap_fees_ap_prd_max_qty'   	=> $fees_ap_prd_max_qty[ $product_cnt ],
                                                            'ap_fees_ap_price_product' 	=> $fees_ap_price_product[ $product_cnt ],
                                                            'ap_fees_ap_per_product' 	=> strpos($fees_ap_price_product[ $product_cnt ], '%') ? $fees_ap_per_product[ $product_cnt ] : 'no',
                                                        );
                                                    }
                                                }
                                            }
                                        endif;
                                    }
                                    //product weight
                                    //define advanced pricing product weight
                                    if ( isset( $fees['ap_product_weight_fees_conditions_condition'] ) ) {
                                        $fees_product_weight            = $fees['ap_product_weight_fees_conditions_condition'];
                                        $fees_ap_product_weight_min_qty = $fees['ap_fees_ap_product_weight_min_weight'];
                                        $fees_ap_product_weight_max_qty = $fees['ap_fees_ap_product_weight_max_weight'];
                                        $fees_ap_price_product_weight   = $fees['ap_fees_ap_price_product_weight'];
                                        $product_weight_arr             = array();
                                        foreach ( $fees_product_weight as $fees_product_weight_val ) {
                                            $product_weight_arr[] = $fees_product_weight_val;
                                        }
                                        $size_product_weight_cond = count( $fees_product_weight );
                                        if ( ! empty( $size_product_weight_cond ) && $size_product_weight_cond > 0 ):
                                            for ( $product_weight_cnt = 0; $product_weight_cnt < $size_product_weight_cond; $product_weight_cnt ++ ) {
                                                if ( ! empty( $product_weight_arr ) && '' !== $product_weight_arr ) {
                                                    foreach ( $product_weight_arr as $product_weight_key => $product_weight_val ) {
                                                        if ( $product_weight_key === $product_weight_cnt ) {
                                                            $ap_product_weight_arr[] = array(
                                                                'ap_fees_product_weight'            => $product_weight_val,
                                                                'ap_fees_ap_product_weight_min_qty' => $fees_ap_product_weight_min_qty[ $product_weight_cnt ],
                                                                'ap_fees_ap_product_weight_max_qty' => $fees_ap_product_weight_max_qty[ $product_weight_cnt ],
                                                                'ap_fees_ap_price_product_weight'   => $fees_ap_price_product_weight[ $product_weight_cnt ],
                                                            );
                                                        }
                                                    }
                                                }
                                            }
                                        endif;
                                    }
                                    //product subtotal
                                    if ( isset( $fees['ap_product_subtotal_fees_conditions_condition'] ) ) {
                                        $fees_product_subtotal            = $fees['ap_product_subtotal_fees_conditions_condition'];
                                        $fees_ap_product_subtotal_min_qty = $fees['ap_fees_ap_product_subtotal_min_subtotal'];
                                        $fees_ap_product_subtotal_max_qty = $fees['ap_fees_ap_product_subtotal_max_subtotal'];
                                        $fees_ap_product_subtotal_price   = $fees['ap_fees_ap_price_product_subtotal'];
                                        $product_subtotal_arr             = array();
                                        foreach ( $fees_product_subtotal as $fees_product_subtotal_val ) {
                                            $product_subtotal_arr[] = $fees_product_subtotal_val;
                                        }
                                        $size_product_subtotal_cond = count( $fees_product_subtotal );
                                        if ( ! empty( $size_product_subtotal_cond ) && $size_product_subtotal_cond > 0 ):
                                            for ( $product_subtotal_cnt = 0; $product_subtotal_cnt < $size_product_subtotal_cond; $product_subtotal_cnt ++ ) {
                                                if ( ! empty( $product_subtotal_arr ) && '' !== $product_subtotal_arr ) {
                                                    foreach ( $product_subtotal_arr as $product_subtotal_key => $product_subtotal_val ) {
                                                        if ( $product_subtotal_key === $product_subtotal_cnt ) {
                                                            $ap_product_subtotal_arr[] = array(
                                                                'ap_fees_product_subtotal'                 => $product_subtotal_val,
                                                                'ap_fees_ap_product_subtotal_min_subtotal' => $fees_ap_product_subtotal_min_qty[ $product_subtotal_cnt ],
                                                                'ap_fees_ap_product_subtotal_max_subtotal' => $fees_ap_product_subtotal_max_qty[ $product_subtotal_cnt ],
                                                                'ap_fees_ap_price_product_subtotal'        => $fees_ap_product_subtotal_price[ $product_subtotal_cnt ],
                                                            );
                                                        }
                                                    }
                                                }
                                            }
                                        endif;
                                    }
                                    //qty for Multiple category
                                    //define advanced pricing Category variables
                                    if ( isset( $fees['ap_category_fees_conditions_condition'] ) ) {
                                        $fees_categories        = $fees['ap_category_fees_conditions_condition'];
                                        $fees_ap_cat_min_qty    = $fees['ap_fees_ap_cat_min_qty'];
                                        $fees_ap_cat_max_qty    = $fees['ap_fees_ap_cat_max_qty'];
                                        $fees_ap_price_category = $fees['ap_fees_ap_price_category'];
                                        $cat_arr                = array();
                                        foreach ( $fees_categories as $fees_cat_val ) {
                                            $cat_arr[] = $fees_cat_val;
                                        }
                                        $size_category_cond = count( $fees_categories );
                                        if ( ! empty( $size_category_cond ) && $size_category_cond > 0 ):
                                            for ( $category_cnt = 0; $category_cnt < $size_category_cond; $category_cnt ++ ) {
                                                if ( ! empty( $cat_arr ) && '' !== $cat_arr ) {
                                                    foreach ( $cat_arr as $cat_key => $cat_val ) {
                                                        if ( $cat_key === $category_cnt ) {
                                                            $ap_category_arr[] = array(
                                                                'ap_fees_categories'        => $cat_val,
                                                                'ap_fees_ap_cat_min_qty'    => $fees_ap_cat_min_qty[ $category_cnt ],
                                                                'ap_fees_ap_cat_max_qty'    => $fees_ap_cat_max_qty[ $category_cnt ],
                                                                'ap_fees_ap_price_category' => $fees_ap_price_category[ $category_cnt ],
                                                            );
                                                        }
                                                    }
                                                }
                                            }
                                        endif;
                                    }
                                    //category weight
                                    //define advanced pricing category weight
                                    if ( isset( $fees['ap_category_weight_fees_conditions_condition'] ) ) {
                                        $fees_category_weight            = $fees['ap_category_weight_fees_conditions_condition'];
                                        $fees_ap_category_weight_min_qty = $fees['ap_fees_ap_category_weight_min_weight'];
                                        $fees_ap_category_weight_max_qty = $fees['ap_fees_ap_category_weight_max_weight'];
                                        $fees_ap_price_category_weight   = $fees['ap_fees_ap_price_category_weight'];
                                        $category_weight_arr             = array();
                                        foreach ( $fees_category_weight as $fees_category_weight_val ) {
                                            $category_weight_arr[] = $fees_category_weight_val;
                                        }
                                        $size_category_weight_cond = count( $fees_category_weight );
                                        if ( ! empty( $size_category_weight_cond ) && $size_category_weight_cond > 0 ):
                                            for ( $category_weight_cnt = 0; $category_weight_cnt < $size_category_weight_cond; $category_weight_cnt ++ ) {
                                                if ( ! empty( $category_weight_arr ) && '' !== $category_weight_arr ) {
                                                    foreach ( $category_weight_arr as $category_weight_key => $category_weight_val ) {
                                                        if ( $category_weight_key === $category_weight_cnt ) {
                                                            $ap_category_weight_arr[] = array(
                                                                'ap_fees_categories_weight'          => $category_weight_val,
                                                                'ap_fees_ap_category_weight_min_qty' => $fees_ap_category_weight_min_qty[ $category_weight_cnt ],
                                                                'ap_fees_ap_category_weight_max_qty' => $fees_ap_category_weight_max_qty[ $category_weight_cnt ],
                                                                'ap_fees_ap_price_category_weight'   => $fees_ap_price_category_weight[ $category_weight_cnt ],
                                                            );
                                                        }
                                                    }
                                                }
                                            }
                                        endif;
                                    }
                                    //category subtotal
                                    if ( isset( $fees['ap_category_subtotal_fees_conditions_condition'] ) ) {
                                        $fees_category_subtotal            = $fees['ap_category_subtotal_fees_conditions_condition'];
                                        $fees_ap_category_subtotal_min_qty = $fees['ap_fees_ap_category_subtotal_min_subtotal'];
                                        $fees_ap_category_subtotal_max_qty = $fees['ap_fees_ap_category_subtotal_max_subtotal'];
                                        $fees_ap_price_category_subtotal   = $fees['ap_fees_ap_price_category_subtotal'];
                                        $category_subtotal_arr             = array();
                                        foreach ( $fees_category_subtotal as $fees_category_subtotal_val ) {
                                            $category_subtotal_arr[] = $fees_category_subtotal_val;
                                        }
                                        $size_category_subtotal_cond = count( $fees_category_subtotal );
                                        if ( ! empty( $size_category_subtotal_cond ) && $size_category_subtotal_cond > 0 ):
                                            for ( $category_subtotal_cnt = 0; $category_subtotal_cnt < $size_category_subtotal_cond; $category_subtotal_cnt ++ ) {
                                                if ( ! empty( $category_subtotal_arr ) && '' !== $category_subtotal_arr ) {
                                                    foreach ( $category_subtotal_arr as $category_subtotal_key => $category_subtotal_val ) {
                                                        if ( $category_subtotal_key === $category_subtotal_cnt ) {
                                                            $ap_category_subtotal_arr[] = array(
                                                                'ap_fees_category_subtotal'                 => $category_subtotal_val,
                                                                'ap_fees_ap_category_subtotal_min_subtotal' => $fees_ap_category_subtotal_min_qty[ $category_subtotal_cnt ],
                                                                'ap_fees_ap_category_subtotal_max_subtotal' => $fees_ap_category_subtotal_max_qty[ $category_subtotal_cnt ],
                                                                'ap_fees_ap_price_category_subtotal'        => $fees_ap_price_category_subtotal[ $category_subtotal_cnt ],
                                                            );
                                                        }
                                                    }
                                                }
                                            }
                                        endif;
                                    }
                                    //qty for total cart qty
                                    //define advanced pricing total cart qty variables
                                    if ( isset( $fees['ap_total_cart_qty_fees_conditions_condition'] ) ) {
                                        $fees_total_cart_qty            = $fees['ap_total_cart_qty_fees_conditions_condition'];
                                        $fees_ap_total_cart_qty_min_qty = $fees['ap_fees_ap_total_cart_qty_min_qty'];
                                        $fees_ap_total_cart_qty_max_qty = $fees['ap_fees_ap_total_cart_qty_max_qty'];
                                        $fees_ap_price_total_cart_qty   = $fees['ap_fees_ap_price_total_cart_qty'];
                                        $total_cart_qty_arr             = array();
                                        foreach ( $fees_total_cart_qty as $fees_total_cart_qty_val ) {
                                            $total_cart_qty_arr[] = $fees_total_cart_qty_val;
                                        }
                                        $size_total_cart_qty_cond = count( $fees_total_cart_qty );
                                        if ( ! empty( $size_total_cart_qty_cond ) && $size_total_cart_qty_cond > 0 ):
                                            for ( $total_cart_qty_cnt = 0; $total_cart_qty_cnt < $size_total_cart_qty_cond; $total_cart_qty_cnt ++ ) {
                                                if ( ! empty( $total_cart_qty_arr ) && '' !== $total_cart_qty_arr ) {
                                                    foreach ( $total_cart_qty_arr as $total_cart_qty_key => $total_cart_qty_val ) {
                                                        if ( $total_cart_qty_key === $total_cart_qty_cnt ) {
                                                            $ap_total_cart_qty_arr[] = array(
                                                                'ap_fees_total_cart_qty'            => $total_cart_qty_val,
                                                                'ap_fees_ap_total_cart_qty_min_qty' => $fees_ap_total_cart_qty_min_qty[ $total_cart_qty_cnt ],
                                                                'ap_fees_ap_total_cart_qty_max_qty' => $fees_ap_total_cart_qty_max_qty[ $total_cart_qty_cnt ],
                                                                'ap_fees_ap_price_total_cart_qty'   => $fees_ap_price_total_cart_qty[ $total_cart_qty_cnt ],
                                                            );
                                                        }
                                                    }
                                                }
                                            }
                                        endif;
                                    }
                                    //category weight
                                    //define advanced pricing category weight
                                    if ( isset( $fees['ap_total_cart_weight_fees_conditions_condition'] ) ) {
                                        $fees_total_cart_weight               = $fees['ap_total_cart_weight_fees_conditions_condition'];
                                        $fees_ap_total_cart_weight_min_weight = $fees['ap_fees_ap_total_cart_weight_min_weight'];
                                        $fees_ap_total_cart_weight_max_weight = $fees['ap_fees_ap_total_cart_weight_max_weight'];
                                        $fees_ap_price_total_cart_weight      = $fees['ap_fees_ap_price_total_cart_weight'];
                                        $total_cart_weight_arr                = array();
                                        foreach ( $fees_total_cart_weight as $fees_total_cart_weight_val ) {
                                            $total_cart_weight_arr[] = $fees_total_cart_weight_val;
                                        }
                                        $size_total_cart_weight_cond = count( $fees_total_cart_weight );
                                        if ( ! empty( $size_total_cart_weight_cond ) && $size_total_cart_weight_cond > 0 ):
                                            for ( $total_cart_weight_cnt = 0; $total_cart_weight_cnt < $size_total_cart_weight_cond; $total_cart_weight_cnt ++ ) {
                                                if ( ! empty( $total_cart_weight_arr ) && '' !== $total_cart_weight_arr ) {
                                                    foreach ( $total_cart_weight_arr as $total_cart_weight_key => $total_cart_weight_val ) {
                                                        if ( $total_cart_weight_key === $total_cart_weight_cnt ) {
                                                            $ap_total_cart_weight_arr[] = array(
                                                                'ap_fees_total_cart_weight'               => $total_cart_weight_val,
                                                                'ap_fees_ap_total_cart_weight_min_weight' => $fees_ap_total_cart_weight_min_weight[ $total_cart_weight_cnt ],
                                                                'ap_fees_ap_total_cart_weight_max_weight' => $fees_ap_total_cart_weight_max_weight[ $total_cart_weight_cnt ],
                                                                'ap_fees_ap_price_total_cart_weight'      => $fees_ap_price_total_cart_weight[ $total_cart_weight_cnt ],
                                                            );
                                                        }
                                                    }
                                                }
                                            }
                                        endif;
                                    }
                                    //Cart subtotal
                                    if ( isset( $fees['ap_total_cart_subtotal_fees_conditions_condition'] ) ) {
                                        $fees_total_cart_subtotal                 = $fees['ap_total_cart_subtotal_fees_conditions_condition'];
                                        $fees_ap_total_cart_subtotal_min_subtotal = $fees['ap_fees_ap_total_cart_subtotal_min_subtotal'];
                                        $fees_ap_total_cart_subtotal_max_subtotal = $fees['ap_fees_ap_total_cart_subtotal_max_subtotal'];
                                        $fees_ap_price_total_cart_subtotal        = $fees['ap_fees_ap_price_total_cart_subtotal'];
                                        $total_cart_subtotal_arr                  = array();
                                        foreach ( $fees_total_cart_subtotal as $total_cart_subtotal_key => $total_cart_subtotal_val ) {
                                            $total_cart_subtotal_arr[] = $total_cart_subtotal_val;
                                        }
                                        $size_total_cart_subtotal_cond = count( $fees_total_cart_subtotal );
                                        if ( ! empty( $size_total_cart_subtotal_cond ) && $size_total_cart_subtotal_cond > 0 ):
                                            for ( $total_cart_subtotal_cnt = 0; $total_cart_subtotal_cnt < $size_total_cart_subtotal_cond; $total_cart_subtotal_cnt ++ ) {
                                                if ( ! empty( $total_cart_subtotal_arr ) && $total_cart_subtotal_arr !== '' ) {
                                                    foreach ( $total_cart_subtotal_arr as $total_cart_subtotal_key => $total_cart_subtotal_val ) {
                                                        if ( $total_cart_subtotal_key === $total_cart_subtotal_cnt ) {
                                                            $ap_total_cart_subtotal_arr[] = array(
                                                                'ap_fees_total_cart_subtotal'                 => $total_cart_subtotal_val,
                                                                'ap_fees_ap_total_cart_subtotal_min_subtotal' => $fees_ap_total_cart_subtotal_min_subtotal[ $total_cart_subtotal_cnt ],
                                                                'ap_fees_ap_total_cart_subtotal_max_subtotal' => $fees_ap_total_cart_subtotal_max_subtotal[ $total_cart_subtotal_cnt ],
                                                                'ap_fees_ap_price_total_cart_subtotal'        => $fees_ap_price_total_cart_subtotal[ $total_cart_subtotal_cnt ],
                                                            );
                                                        }
                                                    }
                                                }
                                            }
                                        endif;
                                    }
                                    //Shipping Class subtotal
                                    if ( isset( $fees['ap_shipping_class_subtotal_fees_conditions_condition'] ) ) {
                                        $fees_shipping_class_subtotal                 = $fees['ap_shipping_class_subtotal_fees_conditions_condition'];
                                        $fees_ap_shipping_class_subtotal_min_subtotal = $fees['ap_fees_ap_shipping_class_subtotal_min_subtotal'];
                                        $fees_ap_shipping_class_subtotal_max_subtotal = $fees['ap_fees_ap_shipping_class_subtotal_max_subtotal'];
                                        $fees_ap_price_shipping_class_subtotal        = $fees['ap_fees_ap_price_shipping_class_subtotal'];
                                        $shipping_class_subtotal_arr                  = array();
                                        foreach ( $fees_shipping_class_subtotal as $shipping_class_subtotal_key => $shipping_class_subtotal_val ) {
                                            $shipping_class_subtotal_arr[] = $shipping_class_subtotal_val;
                                        }
                                        $size_shipping_class_subtotal_cond = count( $fees_shipping_class_subtotal );
                                        if ( ! empty( $size_shipping_class_subtotal_cond ) && $size_shipping_class_subtotal_cond > 0 ):
                                            for ( $shipping_class_subtotal_cnt = 0; $shipping_class_subtotal_cnt < $size_shipping_class_subtotal_cond; $shipping_class_subtotal_cnt ++ ) {
                                                if ( ! empty( $shipping_class_subtotal_arr ) && $shipping_class_subtotal_arr !== '' ) {
                                                    foreach ( $shipping_class_subtotal_arr as $shipping_class_subtotal_key => $shipping_class_subtotal_val ) {
                                                        if ( $shipping_class_subtotal_key === $shipping_class_subtotal_cnt ) {
                                                            $ap_shipping_class_subtotal_arr[] = array(
                                                                'ap_fees_shipping_class_subtotals'                => $shipping_class_subtotal_val,
                                                                'ap_fees_ap_shipping_class_subtotal_min_subtotal' => $fees_ap_shipping_class_subtotal_min_subtotal[ $shipping_class_subtotal_cnt ],
                                                                'ap_fees_ap_shipping_class_subtotal_max_subtotal' => $fees_ap_shipping_class_subtotal_max_subtotal[ $shipping_class_subtotal_cnt ],
                                                                'ap_fees_ap_price_shipping_class_subtotal'        => $fees_ap_price_shipping_class_subtotal[ $shipping_class_subtotal_cnt ],
                                                            );
                                                        }
                                                    }
                                                }
                                            }
                                        endif;
                                    }
                                    update_post_meta( $post_id, 'sm_metabox_ap_product', $ap_product_arr );
                                    update_post_meta( $post_id, 'sm_metabox_ap_product_weight', $ap_product_weight_arr );
                                    update_post_meta( $post_id, 'sm_metabox_ap_product_subtotal', $ap_product_subtotal_arr );
                                    update_post_meta( $post_id, 'sm_metabox_ap_category', $ap_category_arr );
                                    update_post_meta( $post_id, 'sm_metabox_ap_category_weight', $ap_category_weight_arr );
                                    update_post_meta( $post_id, 'sm_metabox_ap_category_subtotal', $ap_category_subtotal_arr );
                                    update_post_meta( $post_id, 'sm_metabox_ap_total_cart_qty', $ap_total_cart_qty_arr );
                                    update_post_meta( $post_id, 'sm_metabox_ap_total_cart_weight', $ap_total_cart_weight_arr );
                                    update_post_meta( $post_id, 'sm_metabox_ap_total_cart_subtotal', $ap_total_cart_subtotal_arr );
                                    update_post_meta( $post_id, 'sm_metabox_ap_shipping_class_subtotal', $ap_shipping_class_subtotal_arr );
                                }
                            }
                        } else {
                            echo '<div class="updated error"><p>' . esc_html__( 'Error saving Fees.', 'woocommerce-conditional-product-fees-for-checkout' ) . '</p></div>';
                            return false;
                        }
                    }
                    if ( 'add' === $action ) {
                        $message = 'created';
                    }
                    if ( 'edit' === $action ) {
                        $message = 'saved';
                    }
                    
                    wp_safe_redirect( add_query_arg( array(
                        'page'      => 'wcpfc-pro-list',
                        'action'    => 'edit',
                        'id'        => $post_id,
                        '_wpnonce'  => wp_create_nonce( 'edit_' . $post_id ),
                        'message'    => $message
                    ), $admin_url ) );
                    exit();
                }
            }
        }

        /**
         * Edit discount rule
         *
         * @since    3.9.0
         */
        public static function wcpfc_sj_edit_method() {
            require_once( plugin_dir_path( __FILE__ ) . 'wcpfc-pro-add-new-page.php' );
        }

        /**
         * Add discount rule
         *
         * @since    3.9.0
         */
        public static function wcpfc_sj_add_extra_fee_form() {
            require_once( plugin_dir_path( __FILE__ ) . 'wcpfc-pro-add-new-page.php' );
        }

        /**
         * Delete shipping method
         *
         * @param int $id
         *
         * @access   public
         *
         * @since    3.9.0
         *
         */
        public static function wcpfc_sj_delete_method( $id ) {
            $_wpnonce = filter_input( INPUT_GET, '_wpnonce', FILTER_SANITIZE_STRING );

            $getnonce = wp_verify_nonce( $_wpnonce, 'del_' . $id );
            if ( isset( $getnonce ) && 1 === $getnonce ) {
                wp_delete_post( $id );
                wp_safe_redirect( add_query_arg( array(
                    'page'    => 'wcpfc-pro-list',
                    'delete' => 'true'
                ), admin_url( 'admin.php' ) ) );
                exit;
            } else {
                self::$admin_object->wcpfc_updated_message( 'nonce_check', "" );
            }
        }

        /**
         * Duplicate shipping method
         *
         * @param int $id
         *
         * @access   public
         * @uses Woocommerce_Dynamic_Pricing_And_Discount_Pro_Admin::dpad_updated_message()
         *
         * @since    1.0.0
         *
         */
        public static function wcpfc_sj_duplicate_method( $post_id ) {
            $_wpnonce = filter_input( INPUT_GET, '_wpnonce', FILTER_SANITIZE_STRING );

            $getnonce = wp_verify_nonce( $_wpnonce, 'duplicate_' . $post_id );
            if ( isset( $getnonce ) && 1 === $getnonce ) {
                /* Get all the original post data */
                $post = get_post( $post_id );
                /* Get current user and make it new post user (duplicate post) */
                $current_user    = wp_get_current_user();
                $new_post_author = $current_user->ID;
                /* If post data exists, duplicate the data into new duplicate post */
                if ( isset( $post ) && null !== $post ) {
                    /* New post data array */
                    $args = array(
                        'comment_status' => $post->comment_status,
                        'ping_status'    => $post->ping_status,
                        'post_author'    => $new_post_author,
                        'post_content'   => $post->post_content,
                        'post_excerpt'   => $post->post_excerpt,
                        'post_name'      => $post->post_name,
                        'post_parent'    => $post->post_parent,
                        'post_password'  => $post->post_password,
                        'post_status'    => 'draft',
                        'post_title'     => $post->post_title . '-duplicate',
                        'post_type'      => self::wcpfc_post_type,
                        'to_ping'        => $post->to_ping,
                        'menu_order'     => $post->menu_order,
                    );
                    /* Duplicate the post by wp_insert_post() function */
                    $new_post_id = wp_insert_post( $args );
                    /* Duplicate all post meta-data */
                    $post_meta_data = get_post_meta( $post_id );
                    if ( 0 !== count( $post_meta_data ) ) {
                        foreach ( $post_meta_data as $meta_key => $meta_data ) {
                            if ( '_wp_old_slug' === $meta_key ) {
                                continue;
                            }
                            $meta_value = maybe_unserialize( $meta_data[0] );
                            update_post_meta( $new_post_id, $meta_key, $meta_value );
                        }
                    }
                }
                $wcpfcnonce   = wp_create_nonce( 'edit_' . $new_post_id );
                wp_safe_redirect( add_query_arg( array(
                    'page'     => 'wcpfc-pro-list',
                    'id'       => $new_post_id,
                    'action'   => 'edit',
                    '_wpnonce' => esc_attr( $wcpfcnonce ),
                ), admin_url( 'admin.php' ) ) );
                exit;
            } else {
                self::$admin_object->wcpfc_updated_message( 'nonce_check', "" );
            }
        }

        /**
         * Count total shipping method
         *
         * @return int $count_method
         * @since    3.5
         *
         */
        public static function wcpfc_sj_count_method() {
            $shipping_method_args = array(
                'post_type'      => self::wcpfc_post_type,
                'post_status'    => array( 'publish', 'draft' ),
                'posts_per_page' => -1,
                'orderby'        => 'ID',
                'order'          => 'DESC',
            );
            $sm_post_query        = new WP_Query( $shipping_method_args );
            $shipping_method_list = $sm_post_query->posts;

            return count( $shipping_method_list );
        }

        /**
         * list_shipping_methods function.
         *
         * @since    3.9.0
         *
         * @uses WC_Conditional_product_Fees_Table class
         * @uses WC_Conditional_product_Fees_Table::process_bulk_action()
         * @uses WC_Conditional_product_Fees_Table::prepare_items()
         * @uses WC_Conditional_product_Fees_Table::search_box()
         * @uses WC_Conditional_product_Fees_Table::display()
         *
         * @access public
         *
         */
        public static function wcpfc_sj_list_methods_screen() {
            if ( ! class_exists( 'WC_Conditional_product_Fees_Table' ) ) {
                require_once plugin_dir_path( dirname( __FILE__ ) ) . 'list-tables/class-wc-conditional-product-fees-table.php';
            }
            $link = add_query_arg( array(
                'page'   => 'wcpfc-pro-list',
                'action' => 'add'
            ), admin_url( 'admin.php' ) );

            require_once( plugin_dir_path( __FILE__ ) . 'header/plugin-header.php' );
            ?>
            <div class="wrap">
                <form method="post" enctype="multipart/form-data">
                    <div class="wcpfc-section-left">
                        <div class="wcpfc-main-table res-cl">
                            <h1 class="wp-heading-inline"><?php esc_html_e( 'Product Fees', 'woocommerce-conditional-product-fees-for-checkout' ); ?></h1>
                            <a class="page-title-action" href="<?php echo esc_url( $link ); ?>"><?php esc_html_e( 'Add New', 'woocommerce-conditional-product-fees-for-checkout' ); ?></a>
                            <!-- <a id="conditional-fee-order" class="conditional-fee-order page-title-action">Save order</a> -->
                            <?php
                            $request_s = filter_input( INPUT_POST, 's', FILTER_SANITIZE_STRING );
                            if ( isset( $request_s ) && ! empty( $request_s ) ) {
                                echo sprintf( '<span class="subtitle">' . esc_html__( 'Search results for &#8220;%s&#8221;', 'woocommerce-conditional-product-fees-for-checkout' ) . '</span>', esc_html( $request_s ) );
                            }
                            wp_nonce_field('sorting_conditional_fee_action','sorting_conditional_fee');
                            $WC_Conditional_product_Fees_Table = new WC_Conditional_product_Fees_Table();
                            $WC_Conditional_product_Fees_Table->process_bulk_action();
                            $WC_Conditional_product_Fees_Table->prepare_items();
                            $WC_Conditional_product_Fees_Table->search_box( esc_html__( 'Search Fee Rule', 'woocommerce-conditional-product-fees-for-checkout' ), 'shipping-method' );
                            $WC_Conditional_product_Fees_Table->display();
                            ?>
                        </div>
                        <?php
                        if ( wcpffc_fs()->is__premium_only() ) {
                            if ( wcpffc_fs()->can_use_premium_code() ) {
                                require_once( plugin_dir_path( __FILE__ ) . 'wcpfc-master-settings-page.php' );
                            }
                        }
                        ?>
                    </div>
                </form>
            </div>
            <?php
            require_once( plugin_dir_path( __FILE__ ) . 'header/plugin-sidebar.php' );
        }
    }
}
?>