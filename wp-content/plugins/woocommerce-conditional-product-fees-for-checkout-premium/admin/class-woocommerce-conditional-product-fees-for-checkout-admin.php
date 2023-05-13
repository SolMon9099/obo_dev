<?php // phpcs:ignore
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.multidots.com
 * @package    Woocommerce_Conditional_Product_Fees_For_Checkout_Pro
 * @subpackage Woocommerce_Conditional_Product_Fees_For_Checkout_Pro/admin
 * @since      1.0.0
 * @author     Multidots <inquiry@multidots.in>
 */

class Woocommerce_Conditional_Product_Fees_For_Checkout_Pro_Admin {
	const wcpfc_post_type = 'wc_conditional_fee';
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;
	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name
	 * @param string $version
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( $hook ) {
		if ( strpos( $hook, 'dotstore-plugins_page_wcpf' ) !== false ) {
			wp_enqueue_style( $this->plugin_name . 'select2-min', plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), 'all' );
			wp_enqueue_style( $this->plugin_name . '-jquery-ui-css', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . '-timepicker-min-css', plugin_dir_url( __FILE__ ) . 'css/jquery.timepicker.min.css', $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . 'font-awesome', plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . '-webkit-css', plugin_dir_url( __FILE__ ) . 'css/webkit.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . 'main-style', plugin_dir_url( __FILE__ ) . 'css/style.css', array(), 'all' );
			wp_enqueue_style( $this->plugin_name . 'media-css', plugin_dir_url( __FILE__ ) . 'css/media.css', array(), 'all' );
		}
	}
	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook ) {
		global $wp;
		wp_enqueue_style( 'wp-jquery-ui-dialog' );
		wp_enqueue_script( 'jquery-ui-accordion' );
		if ( strpos( $hook, 'dotstore-plugins_page_wcpf' ) !== false ) {
			wp_enqueue_script( $this->plugin_name . '-select2-full-min', plugin_dir_url( __FILE__ ) . 'js/select2.full.min.js', array(
				'jquery',
				'jquery-ui-datepicker',
			), $this->version, false );
			wp_enqueue_script( $this->plugin_name . '-chart-js', plugin_dir_url( __FILE__ ) . 'js/chart.js', array(
				'jquery',
			), $this->version, false );
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woocommerce-conditional-product-fees-for-checkout-admin.js', array(
				'jquery',
				'jquery-ui-dialog',
				'jquery-ui-accordion',
				'jquery-ui-sortable',
				'select2',
			), $this->version, false );
            wp_enqueue_script( 'jquery-tiptip' );
            wp_enqueue_script( 'jquery-blockui' );
			wp_enqueue_script( $this->plugin_name . '-tablesorter-js', plugin_dir_url( __FILE__ ) . 'js/jquery.tablesorter.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( $this->plugin_name . '-timepicker-js', plugin_dir_url( __FILE__ ) . 'js/jquery.timepicker.js', array( 'jquery' ), $this->version, false );
			if ( wcpffc_fs()->is__premium_only() ) {
				if ( wcpffc_fs()->can_use_premium_code() ) {
					$weight_unit = get_option( 'woocommerce_weight_unit' );
					$weight_unit = ! empty( $weight_unit ) ? '(' . $weight_unit . ')' : '';
					wp_localize_script( $this->plugin_name, 'coditional_vars', array(
							'ajaxurl'                          		=> admin_url( 'admin-ajax.php' ),
							'ajax_icon'                        		=> esc_url( plugin_dir_url( __FILE__ ) . '/images/ajax-loader.gif' ),
							'plugin_url'                       		=> plugin_dir_url( __FILE__ ),
							'dsm_ajax_nonce'                   		=> wp_create_nonce( 'dsm_nonce' ),
							'disable_fees_ajax_nonce'          		=> wp_create_nonce( 'disable_fees_nonce' ),
							'dashboard_ajax_nonce'             		=> wp_create_nonce( 'dashboard_nonce' ),
							'country'                          		=> esc_html__( 'Country', 'woocommerce-conditional-product-fees-for-checkout' ),
							'state'                            		=> esc_html__( 'State', 'woocommerce-conditional-product-fees-for-checkout' ),
							'city'                             		=> esc_html__( 'City', 'woocommerce-conditional-product-fees-for-checkout' ),
							'postcode'                         		=> esc_html__( 'Postcode', 'woocommerce-conditional-product-fees-for-checkout' ),
							'zone'                             		=> esc_html__( 'Zone', 'woocommerce-conditional-product-fees-for-checkout' ),
							'cart_contains_product'            		=> esc_html__( 'Cart contains product', 'woocommerce-conditional-product-fees-for-checkout' ),
							'cart_contains_variable_product'   		=> esc_html__( 'Cart contains variable product', 'woocommerce-conditional-product-fees-for-checkout' ),
							'cart_contains_category_product'   		=> esc_html__( 'Cart contains category\'s product', 'woocommerce-conditional-product-fees-for-checkout' ),
							'cart_contains_tag_product'        		=> esc_html__( 'Cart contains tag\'s product', 'woocommerce-conditional-product-fees-for-checkout' ),
							'cart_contains_sku_product'        		=> esc_html__( 'Cart contains SKU\'s product', 'woocommerce-conditional-product-fees-for-checkout' ),
							'cart_contains_product_qty'        		=> esc_html__( 'Cart contains product\'s quantity', 'woocommerce-conditional-product-fees-for-checkout' ),
							'product_qty_msg'                  		=> esc_html__( 'This rule will only work if you have selected any one Product Specific option. ', 'woocommerce-conditional-product-fees-for-checkout' ),
							'user'                             		=> esc_html__( 'User', 'woocommerce-conditional-product-fees-for-checkout' ),
							'user_role'                        		=> esc_html__( 'User Role', 'woocommerce-conditional-product-fees-for-checkout' ),
							'cart_subtotal_before_discount'    		=> esc_html__( 'Cart Subtotal (Before Discount)', 'woocommerce-conditional-product-fees-for-checkout' ),
							'cart_subtotal_after_discount'     		=> esc_html__( 'Cart Subtotal (After Discount)', 'woocommerce-conditional-product-fees-for-checkout' ),
							'cart_subtotal_specific_products'  		=> esc_html__( 'Cart Subtotal (Specific products)', 'woocommerce-conditional-product-fees-for-checkout' ),
							'quantity'                         		=> esc_html__( 'Quantity', 'woocommerce-conditional-product-fees-for-checkout' ),
							'weight'                           		=> esc_html__( 'Weight', 'woocommerce-conditional-product-fees-for-checkout' ) . ' ' . esc_html( $weight_unit ),
							'coupon'                           		=> esc_html__( 'Coupon', 'woocommerce-conditional-product-fees-for-checkout' ),
							'shipping_class'                   		=> esc_html__( 'Shipping Class', 'woocommerce-conditional-product-fees-for-checkout' ),
							'payment_gateway'                  		=> esc_html__( 'Payment Gateway', 'woocommerce-conditional-product-fees-for-checkout' ),
							'shipping_method'                  		=> esc_html__( 'Shipping Method', 'woocommerce-conditional-product-fees-for-checkout' ),
							'min_quantity'                     		=> esc_html__( 'Min Quantity', 'woocommerce-conditional-product-fees-for-checkout' ),
							'max_quantity'                     		=> esc_html__( 'Max Quantity', 'woocommerce-conditional-product-fees-for-checkout' ),
							'amount'                           		=> esc_html__( 'Amount', 'woocommerce-conditional-product-fees-for-checkout' ),
							'equal_to'                         		=> esc_html__( 'Equal to ( = )', 'woocommerce-conditional-product-fees-for-checkout' ),
							'not_equal_to'                     		=> esc_html__( 'Not Equal to ( != )', 'woocommerce-conditional-product-fees-for-checkout' ),
							'less_or_equal_to'                 		=> esc_html__( 'Less or Equal to ( <= )', 'woocommerce-conditional-product-fees-for-checkout' ),
							'less_than'                        		=> esc_html__( 'Less then ( < )', 'woocommerce-conditional-product-fees-for-checkout' ),
							'greater_or_equal_to'              		=> esc_html__( 'greater or Equal to ( >= )', 'woocommerce-conditional-product-fees-for-checkout' ),
							'greater_than'                     		=> esc_html__( 'greater then ( > )', 'woocommerce-conditional-product-fees-for-checkout' ),
							'validation_length1'               		=> esc_html__( 'Please enter 3 or more characters', 'woocommerce-conditional-product-fees-for-checkout' ),
							'select_category'                  		=> esc_html__( 'Select Category', 'woocommerce-conditional-product-fees-for-checkout' ),
							'delete'                           		=> esc_html__( 'Delete', 'woocommerce-conditional-product-fees-for-checkout' ),
							'cart_qty'                         		=> esc_html__( 'Cart Qty', 'woocommerce-conditional-product-fees-for-checkout' ),
							'cart_weight'                      		=> esc_html__( 'Cart Weight', 'woocommerce-conditional-product-fees-for-checkout' ),
							'min_weight'                       		=> esc_html__( 'Min Weight', 'woocommerce-conditional-product-fees-for-checkout' ),
							'max_weight'                       		=> esc_html__( 'Max Weight', 'woocommerce-conditional-product-fees-for-checkout' ),
							'cart_subtotal'                    		=> esc_html__( 'Cart Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ),
							'min_subtotal'                     		=> esc_html__( 'Min Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ),
							'max_subtotal'                     		=> esc_html__( 'Max Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ),
							'validation_length2'               		=> esc_html__( 'Please enter', 'woocommerce-conditional-product-fees-for-checkout' ),
							'validation_length3'               		=> esc_html__( 'or more characters', 'woocommerce-conditional-product-fees-for-checkout' ),
							'location_specific'                		=> esc_html__( 'Location Specific', 'woocommerce-conditional-product-fees-for-checkout' ),
							'product_specific'                 		=> esc_html__( 'Product Specific', 'woocommerce-conditional-product-fees-for-checkout' ),
                            'attribute_specific'                    => esc_html__( 'Attribute Specific', 'woocommerce-conditional-product-fees-for-checkout' ),
							'shipping_specific'                		=> esc_html__( 'Shipping Specific', 'woocommerce-conditional-product-fees-for-checkout' ),
							'user_specific'                    		=> esc_html__( 'User Specific', 'woocommerce-conditional-product-fees-for-checkout' ),
							'cart_specific'                    		=> esc_html__( 'Cart Specific', 'woocommerce-conditional-product-fees-for-checkout' ),
							'payment_specific'                 		=> esc_html__( 'Payment Specific', 'woocommerce-conditional-product-fees-for-checkout' ),
                            'attribute_list'                        => wp_json_encode( $this->wcpfc_pro_attribute_list__premium_only() ),
							'min_max_qty_error'                		=> esc_html__( 'Max qty should greater then min qty', 'woocommerce-conditional-product-fees-for-checkout' ),
							'min_max_weight_error'             		=> esc_html__( 'Max weight should greater then min weight', 'woocommerce-conditional-product-fees-for-checkout' ),
							'min_max_subtotal_error'           		=> esc_html__( 'Max subtotal should greater then min subtotal', 'woocommerce-conditional-product-fees-for-checkout' ),
                            'ajax_redirect_after'                   => esc_url( admin_url( 'admin.php?page=wcpfc-pro-list') ),
							'success_msg1'                     		=> esc_html__( 'Fees order has been saved successfully', 'woocommerce-conditional-product-fees-for-checkout' ),
							'success_msg2'                     		=> esc_html__( 'Your settings has been saved successfully. Reload in moment.', 'woocommerce-conditional-product-fees-for-checkout' ),
							'warning_msg1'                     		=> sprintf( __( '<p><b style="color: red;">Note: </b>If entered price is more than total fee price than Message looks like: <b>Fee Name: Curreny Symbole like($) -60.00 Price </b> and if fee minus price is more than total price than it will set Total Price to Zero(0).</p>', 'woocommerce-conditional-product-fees-for-checkout' ) ),
							'warning_msg2'                     		=> esc_html__( 'Please disable Advanced Fees Price Rules if you dont need because you have not created rule there.', 'woocommerce-conditional-product-fees-for-checkout' ),
							'warning_msg3'                     		=> esc_html__( 'You need to select product specific option in Conditional Fee Rules for product based option', 'woocommerce-conditional-product-fees-for-checkout' ),
							'warning_msg4'                     		=> esc_html__( 'If you active Apply Per Quantity option then Advanced Fees Price Rules will be disable and not working.', 'woocommerce-conditional-product-fees-for-checkout' ),
							'warning_msg5'                     		=> esc_html__( 'Please fill some required field in Advanced Fees Price Rules section', 'woocommerce-conditional-product-fees-for-checkout' ),
							'warning_msg6'                     		=> esc_html__( 'You need to select product specific option in Conditional Fee Rules for product based option', 'woocommerce-conditional-product-fees-for-checkout' ),
							'warning_msg7'                     		=> esc_html__( 'End time should be after start time.', 'woocommerce-conditional-product-fees-for-checkout' ),
							'select_chk'                       		=> esc_html__( 'Please select at least one checkbox', 'woocommerce-conditional-product-fees-for-checkout' ),
							'change_status'                    		=> esc_html__( 'Are You Sure You Want To Change The Status?', 'woocommerce-conditional-product-fees-for-checkout' ),
							'select_atleast_one_checkbox'      		=> esc_html__( 'Please select at least one checkbox', 'woocommerce-conditional-product-fees-for-checkout' ),
							'delete_confirmation_msg'          		=> esc_html__( 'Are You Sure You Want to Delete?', 'woocommerce-conditional-product-fees-for-checkout' ),
							'note'                             		=> esc_html__( 'Note: ', 'woocommerce-conditional-product-fees-for-checkout' ),
							'click_here'                       		=> esc_html__( 'Click Here', 'woocommerce-conditional-product-fees-for-checkout' ),
							'weight_msg'                       		=> esc_html__( 'Please make sure that when you add rules in Advanced Fees Price Rules > Cost per weight Section It contains in above entered weight, otherwise it may be not apply proper fees. For more detail please view our documentation at ', 'woocommerce-conditional-product-fees-for-checkout' ),
							'cart_contains_product_msg'        		=> esc_html__( 'Please make sure that when you add rules in Advanced Fees Price Rules > Cost per product Section It contains in above selected product list, otherwise it may be not apply proper fees. For more detail please view our documentation at ', 'woocommerce-conditional-product-fees-for-checkout' ),
							'cart_contains_category_msg'       		=> esc_html__( 'Please make sure that when you add rules in Advanced Fees Price Rules > Cost per category Section It contains in above selected category list, otherwise it may be not apply proper fees. For more detail please view our documentation at ', 'woocommerce-conditional-product-fees-for-checkout' ),
							'cart_subtotal_after_discount_msg' 		=> esc_html__( 'This rule will apply when you would apply coupon in front side. ', 'woocommerce-conditional-product-fees-for-checkout' ),
							'cart_subtotal_specific_products_msg'	=> esc_html__( 'This rule will apply when you would add cart contain product. ', 'woocommerce-conditional-product-fees-for-checkout' ),
							'city_msg' 						   		=> esc_html__( 'Make sure enter each city name in one line.', 'woocommerce-conditional-product-fees-for-checkout' ),
							'doc_url'                          		=> "https://docs.thedotstore.com/category/191-premium-plugin-settings",
							'list_page_url'                    		=> add_query_arg( array( 'page' => 'wcpfc-pro-list' ), admin_url( 'admin.php' ) ),
							'total_old_revenue_flag'		   		=> get_option('total_old_revenue_flag') ? get_option('total_old_revenue_flag') : false,
							'per_product'							=> esc_html__( 'Apply on Products', 'woocommerce-conditional-product-fees-for-checkout' ),
							'currency_symbol'						=> esc_attr( get_woocommerce_currency_symbol() ),
                            'select2_placeholder'                   => esc_html__( 'Search for options', 'woocommerce-conditional-product-fees-for-checkout' ),
						)
					);
				}
			} else {
				wp_localize_script( $this->plugin_name, 'coditional_vars', array(
						'ajaxurl'                       => admin_url( 'admin-ajax.php' ),
						'ajax_icon'                     => esc_url( plugin_dir_url( __FILE__ ) . '/images/ajax-loader.gif' ),
						'plugin_url'                    => plugin_dir_url( __FILE__ ),
						'dsm_ajax_nonce'                => wp_create_nonce( 'dsm_nonce' ),
						'disable_fees_ajax_nonce'       => wp_create_nonce( 'disable_fees_nonce' ),
						'country'                       => esc_html__( 'Country', 'woocommerce-conditional-product-fees-for-checkout' ),
						'city'                          => esc_html__( 'City', 'woocommerce-conditional-product-fees-for-checkout' ),
						'cart_contains_product'         => esc_html__( 'Cart contains product', 'woocommerce-conditional-product-fees-for-checkout' ),
						'cart_contains_variable_product'=> esc_html__( 'Cart contains variable product', 'woocommerce-conditional-product-fees-for-checkout' ),
						'cart_contains_category_product'=> esc_html__( 'Cart contains category\'s product', 'woocommerce-conditional-product-fees-for-checkout' ),
						'cart_contains_tag_product'     => esc_html__( 'Cart contains tag\'s product', 'woocommerce-conditional-product-fees-for-checkout' ),
						'cart_contains_product_qty'     => esc_html__( 'Cart contains product\'s quantity', 'woocommerce-conditional-product-fees-for-checkout' ),
						'city_msg' 						=> esc_html__( 'Make sure enter each city name in one line.', 'woocommerce-conditional-product-fees-for-checkout' ),
						'user'                          => esc_html__( 'User', 'woocommerce-conditional-product-fees-for-checkout' ),
						'cart_subtotal_before_discount' => esc_html__( 'Cart Subtotal (Before Discount)', 'woocommerce-conditional-product-fees-for-checkout' ),
						'quantity'                      => esc_html__( 'Quantity', 'woocommerce-conditional-product-fees-for-checkout' ),
						'equal_to'                      => esc_html__( 'Equal to ( = )', 'woocommerce-conditional-product-fees-for-checkout' ),
						'not_equal_to'                  => esc_html__( 'Not Equal to ( != )', 'woocommerce-conditional-product-fees-for-checkout' ),
						'less_or_equal_to'              => esc_html__( 'Less or Equal to ( <= )', 'woocommerce-conditional-product-fees-for-checkout' ),
						'less_than'                     => esc_html__( 'Less then ( < )', 'woocommerce-conditional-product-fees-for-checkout' ),
						'greater_or_equal_to'           => esc_html__( 'greater or Equal to ( >= )', 'woocommerce-conditional-product-fees-for-checkout' ),
						'greater_than'                  => esc_html__( 'greater then ( > )', 'woocommerce-conditional-product-fees-for-checkout' ),
						'validation_length1'            => esc_html__( 'Please enter 3 or more characters', 'woocommerce-conditional-product-fees-for-checkout' ),
						'select_category'               => esc_html__( 'Select Category', 'woocommerce-conditional-product-fees-for-checkout' ),
						'delete'                        => esc_html__( 'Delete', 'woocommerce-conditional-product-fees-for-checkout' ),
						'validation_length2'            => esc_html__( 'Please enter', 'woocommerce-conditional-product-fees-for-checkout' ),
						'validation_length3'            => esc_html__( 'or more characters', 'woocommerce-conditional-product-fees-for-checkout' ),
						'location_specific'             => esc_html__( 'Location Specific', 'woocommerce-conditional-product-fees-for-checkout' ),
						'product_specific'              => esc_html__( 'Product Specific', 'woocommerce-conditional-product-fees-for-checkout' ),
						'shipping_specific'             => esc_html__( 'Shipping Specific', 'woocommerce-conditional-product-fees-for-checkout' ),
						'user_specific'                 => esc_html__( 'User Specific', 'woocommerce-conditional-product-fees-for-checkout' ),
						'cart_specific'                 => esc_html__( 'Cart Specific', 'woocommerce-conditional-product-fees-for-checkout' ),
						'payment_specific'              => esc_html__( 'Payment Specific', 'woocommerce-conditional-product-fees-for-checkout' ),
                        'ajax_redirect_after'           => esc_url( admin_url( 'admin.php?page=wcpfc-pro-list') ),
						'success_msg1'                  => esc_html__( 'Fees order has been saved successfully', 'woocommerce-conditional-product-fees-for-checkout' ),
						'success_msg2'                  => esc_html__( 'Your settings has been saved successfully. Reload in moment.', 'woocommerce-conditional-product-fees-for-checkout' ),
						'warning_msg1'                  => sprintf( __( '<p><b style="color: red;">Note: </b>If entered price is more than total fee price than Message looks like: <b>Fee Name: Curreny Symbole like($) -60.00 Price </b> and if fee minus price is more than total price than it will set Total Price to Zero(0).</p>', 'woocommerce-conditional-product-fees-for-checkout' ) ),
						'select_chk'                    => esc_html__( 'Please select at least one checkbox', 'woocommerce-conditional-product-fees-for-checkout' ),
						'change_status'                 => esc_html__( 'Are You Sure You Want To Change The Status?', 'woocommerce-conditional-product-fees-for-checkout' ),
						'select_atleast_one_checkbox'   => esc_html__( 'Please select at least one checkbox', 'woocommerce-conditional-product-fees-for-checkout' ),
						'delete_confirmation_msg'       => esc_html__( 'Are You Sure You Want to Delete?', 'woocommerce-conditional-product-fees-for-checkout' ),
						'note'                          => esc_html__( 'Note: ', 'woocommerce-conditional-product-fees-for-checkout' ),
						'click_here'                    => esc_html__( 'Click Here', 'woocommerce-conditional-product-fees-for-checkout' ),
						'doc_url'                       => "https://docs.thedotstore.com/category/191-premium-plugin-settings",
						'list_page_url'                 => add_query_arg( array( 'page' => 'wcpfc-pro-list' ), admin_url( 'admin.php' ) ),
						'currency_symbol'				=> esc_attr( get_woocommerce_currency_symbol() ),
                        'select2_placeholder'           => esc_html__( 'Search for options', 'woocommerce-conditional-product-fees-for-checkout' ),
					)
				);
			}
		}
	}
	/**
	 * Register Admin menu pages.
	 *
	 * @since    1.0.0
	 */
	public function wcpfc_pro_admin_menu_pages() {
		if ( empty( $GLOBALS['admin_page_hooks']['dots_store'] ) ) {
			add_menu_page(
				'DotStore Plugins', __( 'DotStore Plugins', 'woocommerce-conditional-product-fees-for-checkout' ), 'null', 'dots_store', array(
				$this,
				'wcpfc-pro-list',
			), WCPFC_PRO_PLUGIN_URL . 'admin/images/menu-icon.png', 25
			);
		}
		add_submenu_page( 'dots_store', 'Get Started', 'Get Started', 'manage_options', 'wcpfc-pro-get-started', array(
			$this,
			'wcpfc_pro_get_started_page',
		) );
		add_submenu_page( 'dots_store', 'Introduction', 'Introduction', 'manage_options', 'wcpfc-pro-information', array(
			$this,
			'wcpfc_pro_information_page',
		) );
		if ( wcpffc_fs()->is__premium_only() ) {
			if ( wcpffc_fs()->can_use_premium_code() ) {
				add_submenu_page( 'dots_store', 'WooCommerce Extra Fees Plugin', __( 'WooCommerce Extra Fees Plugin', 'woocommerce-conditional-product-fees-for-checkout' ), 'manage_options', 'wcpfc-pro-list', array(
					$this,
					'wcpfc_pro_fee_list_page',
				) );
			} else {
				add_submenu_page( 'dots_store', 'WooCommerce Conditional Product Fees for Checkout', __( 'WooCommerce Conditional Product Fees for Checkout', 'woocommerce-conditional-product-fees-for-checkout' ), 'manage_options', 'wcpfc-pro-list', array(
					$this,
					'wcpfc_pro_fee_list_page',
				) );
			}
		} else {
			add_submenu_page( 'dots_store', 'WooCommerce Conditional Product Fees for Checkout', __( 'WooCommerce Conditional Product Fees for Checkout', 'woocommerce-conditional-product-fees-for-checkout' ), 'manage_options', 'wcpfc-pro-list', array(
				$this,
				'wcpfc_pro_fee_list_page',
			) );
		}
		add_submenu_page( 'dots_store', 'Add New', 'Add New', 'manage_options', 'wcpfc-pro-add-new', array(
			$this,
			'wcpfc_pro_add_new_fee_page',
		) );
		add_submenu_page( 'dots_store', 'Edit Fee', 'Edit Fee', 'manage_options', 'wcpfc-pro-edit-fee', array(
			$this,
			'wcpfc_pro_edit_fee_page',
		) );
		if ( wcpffc_fs()->is__premium_only() ) {
			if ( wcpffc_fs()->can_use_premium_code() ) {
				add_submenu_page( 'dots_store', 'Import Export Fee', 'Import Export Fee', 'manage_options', 'wcpfc-pro-import-export', array(
					$this,
					'wcpfc_pro_import_export_fee__premium_only',
				) );
				add_submenu_page( 'dots_store', 'Dashboard', 'Dashboard', 'manage_options', 'wcpfc-pro-dashboard', array(
					$this,
					'wcpfc_pro_dashboard__premium_only',
				) );
			} else {
				add_submenu_page( 'dots_store', 'Premium Version', 'Premium Version', 'manage_options', 'wcpfc-premium', array(
					$this,
					'premium_version_wcpfc_page',
				) );
			}
		} else {
			add_submenu_page( 'dots_store', 'Premium Version', 'Premium Version', 'manage_options', 'wcpfc-premium', array(
				$this,
				'premium_version_wcpfc_page',
			) );
		}
	}
	/**
	 * Register Admin information page output.
	 *
	 * @since    1.0.0
	 */
	public function wcpfc_pro_information_page() {
		require_once( plugin_dir_path( __FILE__ ) . '/partials/wcpfc-pro-information-page.php' );
	}
	/**
	 * Register Admin fee list page output.
	 *
	 * @since    1.0.0
	 */
	public function wcpfc_pro_fee_list_page() {
		require_once( plugin_dir_path( __FILE__ ) . '/partials/wcpfc_pro_list-page.php' );
        $wcpfc_rule_lising_obj = new WCPFC_Rule_Listing_Page();
		$wcpfc_rule_lising_obj->wcpfc_sj_output();
	}
	/**
	 * Register Admin add new fee condition page output.
	 *
	 * @since    1.0.0
	 */
	public function wcpfc_pro_add_new_fee_page() {
		require_once( plugin_dir_path( __FILE__ ) . '/partials/wcpfc-pro-add-new-page.php' );
	}
	/**
	 * Register Admin edit fee condition page output.
	 *
	 * @since    1.0.0
	 */
	public function wcpfc_pro_edit_fee_page() {
		require_once( plugin_dir_path( __FILE__ ) . '/partials/wcpfc-pro-add-new-page.php' );
	}
	/**
	 * Register Admin get started page output.
	 *
	 */
	public function wcpfc_pro_get_started_page() {
		require_once( plugin_dir_path( __FILE__ ) . '/partials/wcpfc-pro-get-started-page.php' );
	}
	/**
	 * Premium version info page
	 *
	 */
	public function premium_version_wcpfc_page() {
		require_once( plugin_dir_path( __FILE__ ) . '/partials/wcpfc-premium-version-page.php' );
	}
	/**
	 * Import Export Setting page
	 *
	 */
	public function wcpfc_pro_import_export_fee__premium_only() {
		require_once( plugin_dir_path( __FILE__ ) . '/partials/wcpfc-import-export-setting.php' );
	}
	/**
	 * Dashboard page
	 *
	 */
	public function wcpfc_pro_dashboard__premium_only() {
		require_once( plugin_dir_path( __FILE__ ) . '/partials/wcpfc-dashboard-setting.php' );
	}
	/**
	 * Get meta value by meta key.
	 *
	 * @param string $value
	 *
	 * @return bool if field is empty otherwise return string
	 * @since 1.0.0
	 *
	 */
	function wcpfc_pro_fee_settings_get_meta( $value ) {
		global $post;
		$field = get_post_meta( $post->ID, $value, true );
		if ( ! empty( $field ) ) {
			return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
		} else {
			return false;
		}
	}
    /**
	 * Convert array to json
	 *
	 * @return array $filter_data
	 * @since 3.9.0
	 *
	 */
	public function wcpfc_pro_attribute_list__premium_only() {
		$filter_attr_data     = [];
		$filter_attr_json     = array();
		$attribute_taxonomies = wc_get_attribute_taxonomies();
		if ( $attribute_taxonomies ) {
			foreach ( $attribute_taxonomies as $attribute ) {
				$att_label                               = $attribute->attribute_label;
				$att_name                                = wc_attribute_taxonomy_name( $attribute->attribute_name );
				$filter_attr_json['name']                = $att_label;
				$filter_attr_json['attributes']['value'] = esc_html__( $att_name, 'woocommerce-conditional-product-fees-for-checkout' );
				$filter_attr_data[]                      = $filter_attr_json;
			}
		}
		return $filter_attr_data;
	}
	
	/**
	 * It will display notification message
	 *
	 * @since 1.0.0
	 */
	function wcpfc_pro_notifications() {
		$page    = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS );
		$success = filter_input( INPUT_GET, 'success', FILTER_SANITIZE_SPECIAL_CHARS );
		$delete  = filter_input( INPUT_GET, 'delete', FILTER_SANITIZE_STRING );
		if ( isset( $page, $success ) && $page === ' wcpfc-pro-list' && $success === 'true' ) {
			?>
			<div class="updated notice is-dismissible">
				<p><?php esc_html_e( 'Fee rule has been successfully saved', 'woocommerce-conditional-product-fees-for-checkout' ); ?></p>
			</div>
			<?php
		} else if ( isset( $page, $delete ) && $page === 'wcpfc-pro-list' && $delete === 'true' ) {
			?>
			<div class="updated notice is-dismissible">
				<p><?php esc_html_e( 'Fee rule has been successfully deleted', 'woocommerce-conditional-product-fees-for-checkout' ); ?></p>
			</div>
			<?php
		}
	}
	/**
	 * Get meta data of conditional fee
	 *
	 * @param string $value
	 *
	 * @return bool if $field is empty otherwise it will return string
	 * @since 1.0.0
	 *
	 */
	function wcpfc_pro_product_fees_conditions_get_meta( $value ) {
		global $post;
		$field = get_post_meta( $post->ID, $value, true );
		if ( isset( $field ) && ! empty( $field ) ) {
			return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
		} else {
			return false;
		}
	}
	/**
	 * Display rule Like: country list, state list, zone list, city, postcode, product, category etc.
	 *
	 * @since 1.0.0
	 */
	public function wcpfc_pro_product_fees_conditions_values_ajax() {
		$html = '';
		if ( check_ajax_referer( 'wcpfc_pro_product_fees_conditions_values_ajax_action', 'wcpfc_pro_product_fees_conditions_values_ajax' ) ) {
			$get_condition  = filter_input( INPUT_GET, 'condition', FILTER_SANITIZE_STRING );
			$get_count      = filter_input( INPUT_GET, 'count', FILTER_SANITIZE_NUMBER_INT );
			$posts_per_page = filter_input( INPUT_GET, 'posts_per_page', FILTER_VALIDATE_INT );
			$offset         = filter_input( INPUT_GET, 'offset', FILTER_VALIDATE_INT );
			$condition      = isset( $get_condition ) ? sanitize_text_field( $get_condition ) : '';
			$count          = isset( $get_count ) ? sanitize_text_field( $get_count ) : '';
			$posts_per_page = isset( $posts_per_page ) ? sanitize_text_field( $posts_per_page ) : '';
			$offset         = isset( $offset ) ? sanitize_text_field( $offset ) : '';
			$html           = '';
			if ( wcpffc_fs()->is__premium_only() ) {
				if ( wcpffc_fs()->can_use_premium_code() ) {
                    $att_taxonomy = wc_get_attribute_taxonomy_names();

					if ( 'country' === $condition ) {
						$html .= wp_json_encode( $this->wcpfc_pro_get_country_list( $count, [], true ) );
					} elseif ( 'state' === $condition ) {
						$html .= wp_json_encode( $this->wcpfc_pro_get_states_list__premium_only( $count, [], true ) );
					} elseif ( 'city' === $condition ) {
						$html .= 'textarea';
					} elseif ( 'postcode' === $condition ) {
						$html .= 'textarea';
					} elseif ( 'zone' === $condition ) {
						$html .= wp_json_encode( $this->wcpfc_pro_get_zones_list__premium_only( $count, [], true ) );
					} elseif ( 'product' === $condition ) {
						$html .= wp_json_encode( $this->wcpfc_pro_get_product_list( $count, [], '', true ) );
					} elseif ( 'variableproduct' === $condition ) {
						$html .= wp_json_encode( $this->wcpfc_pro_get_varible_product_list( $count, [], '', true ) );
					} elseif ( 'category' === $condition ) {
						$html .= wp_json_encode( $this->wcpfc_pro_get_category_list( $count, [], true ) );
					} elseif ( 'tag' === $condition ) {
						$html .= wp_json_encode( $this->wcpfc_pro_get_tag_list( $count, [], true ) );
					} elseif ( in_array( $condition, $att_taxonomy, true ) ) {
                        $html .= wp_json_encode( $this->wcpfc_pro_get_att_term_list__premium_only( $count, $condition, [], true ) );
                    } elseif ( 'product_qty' === $condition ) {
						$html .= 'input';
					} elseif ( 'user' === $condition ) {
						$html .= wp_json_encode( $this->wcpfc_pro_get_user_list( $count, [], true ) );
					} elseif ( 'user_role' === $condition ) {
						$html .= wp_json_encode( $this->wcpfc_pro_get_user_role_list__premium_only( $count, [], true ) );
					} elseif ( 'cart_total' === $condition ) {
						$html .= 'input';
					} elseif ( 'cart_totalafter' === $condition ) {
						$html .= 'input';
					} elseif ( 'cart_specificproduct' === $condition ) {
						$html .= 'input';
					} elseif ( 'quantity' === $condition ) {
						$html .= 'input';
					} elseif ( 'weight' === $condition ) {
						$html .= 'input';
					} elseif ( 'coupon' === $condition ) {
						$html .= wp_json_encode( $this->wcpfc_pro_get_coupon_list__premium_only( $count, [], true ) );
					} elseif ( 'shipping_class' === $condition ) {
						$html .= wp_json_encode( $this->wcpfc_pro_get_advance_flat_rate_class__premium_only( $count, [], true ) );
					} elseif ( 'payment' === $condition ) {
						$html .= wp_json_encode( $this->wcpfc_pro_get_payment_methods__premium_only( $count, [], true ) );
					} elseif ( 'shipping_method' === $condition ) {
						$html .= wp_json_encode( $this->wcpfc_pro_get_active_shipping_methods__premium_only( $count, [], true ) );
					}
				}
			} else {
				if ( 'country' === $condition ) {
					$html .= wp_json_encode( $this->wcpfc_pro_get_country_list( $count, [], true ) );
				} elseif ( 'city' === $condition ) {
					$html .= 'textarea';
				} elseif ( 'product' === $condition ) {
					$html .= wp_json_encode( $this->wcpfc_pro_get_product_list( $count, [], '', true ) );
				} elseif ( 'variableproduct' === $condition ) {
					$html .= wp_json_encode( $this->wcpfc_pro_get_varible_product_list( $count, [], '', true ) );
				} elseif ( 'category' === $condition ) {
					$html .= wp_json_encode( $this->wcpfc_pro_get_category_list( $count, [], true ) );
				} elseif ( 'tag' === $condition ) {
					$html .= wp_json_encode( $this->wcpfc_pro_get_tag_list( $count, [], true ) );
				} elseif ( 'product_qty' === $condition ) {
					$html .= 'input';
				} elseif ( 'user' === $condition ) {
					$html .= wp_json_encode( $this->wcpfc_pro_get_user_list( $count, [], true ) );
				} elseif ( 'cart_total' === $condition ) {
					$html .= 'input';
				} elseif ( 'quantity' === $condition ) {
					$html .= 'input';
				}
			}
		}
		echo wp_kses( $html, Woocommerce_Conditional_Product_Fees_For_Checkout_Pro::allowed_html_tags() );
		wp_die(); // this is required to terminate immediately and return a proper response
	}
	/**
	 * Function for select country list
	 *
	 * @param string $count
	 * @param array  $selected
	 * @param bool   $json
	 *
	 * @return string or array $html
	 * @since 1.0.0
	 *
	 */
	public function wcpfc_pro_get_country_list( $count = '', $selected = array(), $json = false ) {
		$countries_obj = new WC_Countries();
		$getCountries  = $countries_obj->__get( 'countries' );
		if ( $json ) {
			return $this->wcpfc_pro_convert_array_to_json( $getCountries );
		}
		$html = '<select name="fees[product_fees_conditions_values][value_' . esc_attr( $count ) . '][]" class="wcpfc_select product_fees_conditions_values multiselect2 product_fees_conditions_values_country" multiple="multiple">';
		if ( ! empty( $getCountries ) ) {
			foreach ( $getCountries as $code => $country ) {
				$selectedVal = is_array( $selected ) && ! empty( $selected ) && in_array( $code, $selected, true ) ? 'selected=selected' : '';
				$html        .= '<option value="' . esc_attr( $code ) . '" ' . esc_attr( $selectedVal ) . '>' . esc_html( $country ) . '</option>';
			}
		}
		$html .= '</select>';
		return $html;
	}
	/**
	 * Function for select state list
	 *
	 * @param string $count
	 * @param array  $selected
	 * @param bool   $json
	 *
	 * @return string or array $html
	 * @since 1.0.0
	 *
	 */
	public function wcpfc_pro_get_states_list__premium_only( $count = '', $selected = array(), $json = false ) {
		$countries     = WC()->countries->get_allowed_countries();
		$filter_states = [];
		$html          = '<select name="fees[product_fees_conditions_values][value_' . esc_attr( $count ) . '][]" class="wcpfc_select product_fees_conditions_values multiselect2 product_fees_conditions_values_state" multiple="multiple">';
		foreach ( $countries as $key => $val ) {
			$states = WC()->countries->get_states( $key );
			if ( ! empty( $states ) ) {
				foreach ( $states as $state_key => $state_value ) {
					$selectedVal                              = is_array( $selected ) && ! empty( $selected ) && in_array( esc_attr( $key . ':' . $state_key ), $selected, true ) ? 'selected=selected' : '';
					$html                                     .= '<option value="' . esc_attr( $key . ':' . $state_key ) . '" ' . $selectedVal . '>' . esc_html( $val . ' -> ' . $state_value ) . '</option>';
					$filter_states[ $key . ':' . $state_key ] = $val . ' -> ' . $state_value;
				}
			}
		}
		$html .= '</select>';
		if ( $json ) {
			return $this->wcpfc_pro_convert_array_to_json( $filter_states );
		}
		return $html;
	}
	/**
	 * Function for select category list
	 *
	 * @param string $count
	 * @param array  $selected
	 * @param string $action
	 * @param bool   $json
	 *
	 * @return string or array $html
	 * @since 1.0.0
	 *
	 */
	public function wcpfc_pro_get_product_list( $count = '', $selected = array(), $action = '', $json = false ) {
		global $sitepress;
		$default_lang = $this->wcpfc_pro_get_default_langugae_with_sitpress();
		$post_in      = '';
		if ( 'edit' === $action ) {
			$post_in        = $selected;
			$posts_per_page = - 1;
		} else {
			$post_in        = '';
			$posts_per_page = 10;
		}
		$product_args     = array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'orderby'        => 'ID',
			'order'          => 'ASC',
			'post__in'       => $post_in,
			'posts_per_page' => $posts_per_page,
		);
		$get_all_products = new WP_Query( $product_args );
		$html             = '<select id="product-filter-' . esc_attr( $count ) . '" rel-id="' . esc_attr( $count ) . '" name="fees[product_fees_conditions_values][value_' . esc_attr( $count ) . '][]" class="wcpfc_select product_fees_conditions_values multiselect2 product_fees_conditions_values_product" multiple="multiple">';
		if ( isset( $get_all_products->posts ) && ! empty( $get_all_products->posts ) ) {
			foreach ( $get_all_products->posts as $get_all_product ) {
				$_product = wc_get_product( $get_all_product->ID );
				if ( $_product->is_type( 'simple' ) ) {
					if ( wcpffc_fs()->is__premium_only() ) {
						if ( wcpffc_fs()->can_use_premium_code() ) {	
							if ( ! empty( $sitepress ) ) {
								$new_product_id = apply_filters( 'wpml_object_id', $get_all_product->ID, 'product', true, $default_lang );
							} else {
								$new_product_id = $get_all_product->ID;
							}
							$selected    = array_map( 'intval', $selected );
							$selectedVal = is_array( $selected ) && ! empty( $selected ) && in_array( $new_product_id, $selected, true ) ? 'selected=selected' : '';
							if ( $selectedVal !== '' ) {
								$html .= '<option value="' . esc_attr( $new_product_id ) . '" ' . esc_attr( $selectedVal ) . '>' . '#' . esc_html( $new_product_id ) . ' - ' . esc_html( get_the_title( $new_product_id ) ) . '</option>';
							}
						} else {
							if ( ! empty( $sitepress ) ) {
								$new_product_id = apply_filters( 'wpml_object_id', $get_all_product->ID, 'product', true, $default_lang );
							} else {
								$new_product_id = $get_all_product->ID;
							}
							$selected    = array_map( 'intval', $selected );
							$selectedVal = is_array( $selected ) && ! empty( $selected ) && in_array( $new_product_id, $selected, true ) ? 'selected=selected' : '';
							if ( $selectedVal !== '' ) {
								$html .= '<option value="' . esc_attr( $new_product_id ) . '" ' . esc_attr( $selectedVal ) . '>' . '#' . esc_html( $new_product_id ) . ' - ' . esc_html( get_the_title( $new_product_id ) ) . '</option>';
							}
						}
					} else {	
						if ( ! empty( $sitepress ) ) {
							$new_product_id = apply_filters( 'wpml_object_id', $get_all_product->ID, 'product', true, $default_lang );
						} else {
							$new_product_id = $get_all_product->ID;
						}
						$selected    = array_map( 'intval', $selected );
						$selectedVal = is_array( $selected ) && ! empty( $selected ) && in_array( $new_product_id, $selected, true ) ? 'selected=selected' : '';
						if ( $selectedVal !== '' ) {
							$html .= '<option value="' . esc_attr( $new_product_id ) . '" ' . esc_attr( $selectedVal ) . '>' . '#' . esc_html( $new_product_id ) . ' - ' . esc_html( get_the_title( $new_product_id ) ) . '</option>';
						}
					}
				}
			}
		}
		$html .= '</select>';
		if ( $json ) {
			return [];
		}
		return $html;
	}
	/**
	 * Function for select product variable list
	 *
	 * @param string $count
	 * @param array  $selected
	 * @param string $action
	 * @param bool   $json
	 *
	 * @return string or array $html
	 * @since 1.0.0
	 *
	 */
	public function wcpfc_pro_get_varible_product_list( $count = '', $selected = array(), $action = '', $json = false ) {
		global $sitepress;
		$default_lang     = $this->wcpfc_pro_get_default_langugae_with_sitpress();
        if ( 'edit' === $action ) {
			$post_in        = $selected;
			$get_varible_product_list_count = -1;
		} else {
			$post_in        = '';
			$get_varible_product_list_count = 10;
		}
		$product_args     = array(
			'post_type'      => 'product_variation',
			'post_status'    => 'publish',
			'orderby'        => 'ID',
			'order'          => 'ASC',
			'posts_per_page' => $get_varible_product_list_count,
            'post__in'       => $post_in,
		);
		$get_all_products = new WP_Query( $product_args );
		$html             = '<select id="var-product-filter-' . esc_attr( $count ) . '" rel-id="' . esc_attr( $count ) . '" name="fees[product_fees_conditions_values][value_' . esc_attr( $count ) . '][]" class="wcpfc_select product_fees_conditions_values multiselect2 product_fees_conditions_values_var_product" multiple="multiple">';
		if ( isset( $get_all_products->posts ) && ! empty( $get_all_products->posts ) ) {
			foreach ( $get_all_products->posts as $get_all_product ) {
				$_product = wc_get_product( $get_all_product->ID );
                if ( ! empty( $sitepress ) ) {
                    $new_product_id = apply_filters( 'wpml_object_id', $get_all_product->ID, 'product', true, $default_lang );
                } else {
                    $new_product_id = $get_all_product->ID;
                }
                $selected    = array_map( 'intval', $selected );
                $selectedVal = is_array( $selected ) && ! empty( $selected ) && in_array( $new_product_id, $selected, true ) ? 'selected=selected' : '';
                if ( '' !== $selectedVal ) {
                    $html .= '<option value="' . esc_attr( $new_product_id ) . '" ' . esc_attr( $selectedVal ) . '>' . '#' . esc_html( $new_product_id ) . ' - ' . esc_html( get_the_title( $new_product_id ) ) . '</option>';
                }
			}
		}
		$html .= '</select>';
		if ( $json ) {
			return [];
		}
		return $html;
	}
	/**
	 * Function for select cat list
	 *
	 * @param string $count
	 * @param array  $selected
	 * @param bool   $json
	 *
	 * @return string or array $html
	 * @since 1.0.0
	 *
	 */
	public function wcpfc_pro_get_category_list( $count = '', $selected = array(), $json = false ) {
		global $sitepress;
		$default_lang       = $this->wcpfc_pro_get_default_langugae_with_sitpress();
		$filter_categories  = [];
		$args               = array(
			'taxonomy'     => 'product_cat',
			'orderby'      => 'name',
			'hierarchical' => true,
			'hide_empty'   => false,
		);
		$get_all_categories = get_terms( 'product_cat', $args );
		$html               = '<select rel-id="' . esc_attr( $count ) . '" name="fees[product_fees_conditions_values][value_' . esc_attr( $count ) . '][]" class="wcpfc_select product_fees_conditions_values multiselect2" multiple="multiple">';
		if ( isset( $get_all_categories ) && ! empty( $get_all_categories ) ) {
			foreach ( $get_all_categories as $get_all_category ) {
				if ( $get_all_category ) {
					if ( ! empty( $sitepress ) ) {
						$new_cat_id = apply_filters( 'wpml_object_id', $get_all_category->term_id, 'product_cat', true, $default_lang );
					} else {
						$new_cat_id = $get_all_category->term_id;
					}
					$selected        = array_map( 'intval', $selected );
					$selectedVal     = is_array( $selected ) && ! empty( $selected ) && in_array( $new_cat_id, $selected, true ) ? 'selected=selected' : '';
					$category        = get_term_by( 'id', $new_cat_id, 'product_cat' );
					$parent_category = get_term_by( 'id', $category->parent, 'product_cat' );
					if ( $category->parent > 0 ) {
						$html                                    .= '<option value=' . esc_attr( $category->term_id ) . ' ' . esc_attr( $selectedVal ) . '>' . '#' . esc_html( $parent_category->name ) . '->' . esc_html( $category->name ) . '</option>';
						$filter_categories[ $category->term_id ] = '#' . $parent_category->name . '->' . $category->name;
					} else {
						$html                                    .= '<option value=' . esc_attr( $category->term_id ) . ' ' . esc_attr( $selectedVal ) . '>' . esc_html( $category->name ) . '</option>';
						$filter_categories[ $category->term_id ] = $category->name;
					}
				}
			}
		}
		$html .= '</select>';
		if ( $json ) {
			return $this->wcpfc_pro_convert_array_to_json( $filter_categories );
		}
		return $html;
	}
	/**
	 * Function for select tag list
	 *
	 * @param string $count
	 * @param array  $selected
	 * @param bool   $json
	 *
	 * @return string or array $html
	 * @since 1.0.0
	 *
	 */
	public function wcpfc_pro_get_tag_list( $count = '', $selected = array(), $json = false ) {
		global $sitepress;
		$default_lang = $this->wcpfc_pro_get_default_langugae_with_sitpress();
		$filter_tags  = [];
		$args         = array(
			'taxonomy'     => 'product_cat',
			'orderby'      => 'name',
			'hierarchical' => true,
			'hide_empty'   => false,
		);
		$get_all_tags = get_terms( 'product_tag', $args );
		$html         = '<select rel-id="' . esc_attr( $count ) . '" name="fees[product_fees_conditions_values][value_' . esc_attr( $count ) . '][]" class="wcpfc_select product_fees_conditions_values multiselect2" multiple="multiple">';
		if ( isset( $get_all_tags ) && ! empty( $get_all_tags ) ) {
			foreach ( $get_all_tags as $get_all_tag ) {
				if ( $get_all_tag ) {
					if ( ! empty( $sitepress ) ) {
						$new_tag_id = apply_filters( 'wpml_object_id', $get_all_tag->term_id, 'product_tag', true, $default_lang );
					} else {
						$new_tag_id = $get_all_tag->term_id;
					}
					$selected                     = array_map( 'intval', $selected );
					$selectedVal                  = is_array( $selected ) && ! empty( $selected ) && in_array( $new_tag_id, $selected, true ) ? 'selected=selected' : '';
					$tag                          = get_term_by( 'id', $new_tag_id, 'product_tag' );
					$html                         .= '<option value="' . esc_attr( $tag->term_id ) . '" ' . esc_attr( $selectedVal ) . '>' . esc_html( $tag->name ) . '</option>';
					$filter_tags[ $tag->term_id ] = $tag->name;
				}
			}
		}
		$html .= '</select>';
		if ( $json ) {
			return $this->wcpfc_pro_convert_array_to_json( $filter_tags );
		}
		return $html;
	}
    /**
	 * Get attribute list in Shipping Method Rules
	 *
	 * @param string $count
	 * @param string $condition
	 * @param array  $selected
	 *
	 * @return string $html
	 * @since  3.9.0
	 *
	 */
	public function wcpfc_pro_get_att_term_list__premium_only( $count = '', $condition = '', $selected = array(), $json = false ) {
		$att_terms         = get_terms( array(
			'taxonomy'   => $condition,
			'parent'     => 0,
			'hide_empty' => false,
		) );
		$filter_attributes = [];
		$html              = '<select rel-id="' . $count . '" name="fees[product_fees_conditions_values][value_' . esc_attr( $count ) . '][]" class="wcpfc_select product_fees_conditions_values multiselect2 product_fees_conditions_values_att_term" multiple="multiple">';
		if ( ! empty( $att_terms ) ) {
			foreach ( $att_terms as $term ) {
				$term_name                       = $term->name;
				$term_slug                       = $term->slug;
				$selectedVal                     = is_array( $selected ) && ! empty( $selected ) && in_array( $term_slug, $selected, true ) ? 'selected=selected' : '';
				$html                            .= '<option value="' . $term_slug . '" ' . $selectedVal . '>' . $term_name . '</option>';
				$filter_attributes[ $term_slug ] = $term_name;
			}
		}
		$html .= '</select>';
		if ( $json ) {
			return $this->wcpfc_pro_convert_array_to_json( $filter_attributes );
		}
		return $html;
	}
	/**
	 * Function for select user list
	 *
	 * @param string $count
	 * @param array  $selected
	 * @param bool   $json
	 *
	 * @return string or array $html
	 * @since 1.0.0
	 *
	 */
	public function wcpfc_pro_get_user_list( $count = '', $selected = array(), $json = false ) {
		$filter_users  = [];
		$get_all_users = get_users();
		$html          = '<select rel-id="' . esc_attr( $count ) . '" name="fees[product_fees_conditions_values][value_' . esc_attr( $count ) . '][]" class="wcpfc_select product_fees_conditions_values multiselect2" multiple="multiple">';
		if ( isset( $get_all_users ) && ! empty( $get_all_users ) ) {
			foreach ( $get_all_users as $get_all_user ) {
				$selected                                = array_map( 'intval', $selected );
				$selectedVal                             = is_array( $selected ) && ! empty( $selected ) && in_array( (int) $get_all_user->data->ID, $selected, true ) ? 'selected=selected' : '';
				$html                                    .= '<option value="' . esc_attr( $get_all_user->data->ID ) . '" ' . esc_attr( $selectedVal ) . '>' . esc_html( $get_all_user->data->user_login ) . '</option>';
				$filter_users[ $get_all_user->data->ID ] = $get_all_user->data->user_login;
			}
		}
		$html .= '</select>';
		if ( $json ) {
			return $this->wcpfc_pro_convert_array_to_json( $filter_users );
		}
		return $html;
	}
	/**
	 * Function for select user role list
	 *
	 * @param string $count
	 * @param array  $selected
	 * @param bool   $json
	 *
	 * @return string or array $html
	 * @since 1.0.0
	 *
	 */
	public function wcpfc_pro_get_user_role_list__premium_only( $count = '', $selected = array(), $json = false ) {
		$filter_user_roles = [];
		global $wp_roles;
		$html = '<select rel-id="' . esc_attr( $count ) . '" name="fees[product_fees_conditions_values][value_' . esc_attr( $count ) . '][]" class="wcpfc_select product_fees_conditions_values multiselect2" multiple="multiple">';
		if ( isset( $wp_roles->roles ) && ! empty( $wp_roles->roles ) ) {
			$defaultSel                 = ! empty( $selected ) && in_array( 'guest', $selected, true ) ? 'selected=selected' : '';
			$html                       .= '<option value="guest" ' . esc_attr( $defaultSel ) . '>' . esc_html__( 'Guest', 'woocommerce-conditional-product-fees-for-checkout' ) . '</option>';
			$filter_user_roles['guest'] = esc_html__( 'Guest', 'woocommerce-conditional-product-fees-for-checkout' );
			foreach ( $wp_roles->roles as $user_role_key => $get_all_role ) {
				$selectedVal                         = is_array( $selected ) && ! empty( $selected ) && in_array( $user_role_key, $selected, true ) ? 'selected=selected' : '';
				$html                                .= '<option value="' . esc_attr( $user_role_key ) . '" ' . esc_attr( $selectedVal ) . '>' . esc_html( $get_all_role['name'] ) . '</option>';
				$filter_user_roles[ $user_role_key ] = $get_all_role['name'];
			}
		}
		$html .= '</select>';
		if ( $json ) {
			return $this->wcpfc_pro_convert_array_to_json( $filter_user_roles );
		}
		return $html;
	}
	/**
	 * Function for select coupon list
	 *
	 * @param string $count
	 * @param array  $selected
	 * @param bool   $json
	 *
	 * @return string or array $html
	 * @since 1.0.0
	 *
	 */
	public function wcpfc_pro_get_coupon_list__premium_only( $count = '', $selected = array(), $json = false ) {
		$filter_coupon_list = [];
		$get_all_coupon     = new WP_Query( array(
			'post_type'      => 'shop_coupon',
			'post_status'    => 'publish',
			'posts_per_page' => - 1,
		) );
		
		if ( isset( $get_all_coupon->posts ) && ! empty( $get_all_coupon->posts ) ) {
			
			$selected = array_map( 'intval', $selected );
			
			$html = '<select rel-id="' . esc_attr( $count ) . '" name="fees[product_fees_conditions_values][value_' . esc_attr( $count ) . '][]" class="wcpfc_select product_fees_conditions_values multiselect2" multiple="multiple">';
			
			//Select all coupon
			$selectedAllVal = is_array( $selected ) && ! empty( $selected ) && in_array( -1, $selected, true ) ? 'selected=selected' : '';
			$html .= '<option value="-1" ' . esc_attr( $selectedAllVal ) . '>' . esc_html__( 'Select All', 'woocommerce-conditional-product-fees-for-checkout' ) . '</option>';
			$filter_coupon_list[ -1 ] = esc_html__( 'Select All', 'woocommerce-conditional-product-fees-for-checkout' );
			
			//Select specific coupon
			foreach ( $get_all_coupon->posts as $get_all_coupon ) {
				$selectedVal = is_array( $selected ) && ! empty( $selected ) && in_array( $get_all_coupon->ID, $selected, true ) ? 'selected=selected' : '';
				$html .= '<option value="' . esc_attr( $get_all_coupon->ID ) . '" ' . esc_attr( $selectedVal ) . '>' . esc_html( $get_all_coupon->post_title ) . '</option>';
				$filter_coupon_list[ $get_all_coupon->ID ] = $get_all_coupon->post_title;
			}

			$html .= '</select>';
		}
		if ( $json ) {
			return $this->wcpfc_pro_convert_array_to_json( $filter_coupon_list );
		}
		return $html;
	}
	/**
	 * Get shipping class list
	 *
	 * @param array $selected
	 *
	 * @return string $html
	 * @since  1.0.0
	 *
	 * @uses   WC_Shipping::get_shipping_classes()
	 *
	 */
	public function wcpfc_pro_get_class_options__premium_only( $selected = array(), $json = false ) {
		$shipping_classes           = WC()->shipping->get_shipping_classes();
		$filter_shipping_class_list = [];
		$html                       = '';
		if ( isset( $shipping_classes ) && ! empty( $shipping_classes ) ) {
			foreach ( $shipping_classes as $shipping_classes_key ) {
				$selectedVal                                               = ! empty( $selected ) && in_array( $shipping_classes_key->slug, $selected, true ) ? 'selected=selected' : '';
				$html                                                      .= '<option value="' . esc_attr( $shipping_classes_key->slug ) . '" ' . esc_attr( $selectedVal ) . '>' . esc_html( $shipping_classes_key->name ) . '</option>';
				$filter_shipping_class_list[ $shipping_classes_key->slug ] = $shipping_classes_key->name;
			}
		}
		if ( true === $json ) {
			return wp_json_encode( $this->wcpfc_pro_convert_array_to_json( $filter_shipping_class_list ) );
		} else {
			return $html;
		}
	}
	/**
	 * Function for get shipping class list
	 *
	 * @param string $count
	 * @param array  $selected
	 * @param bool   $json
	 *
	 * @return string or array $html
	 * @since 1.0.0
	 *
	 */
	public function wcpfc_pro_get_advance_flat_rate_class__premium_only( $count = '', $selected = array(), $json = false ) {
		$filter_rate_class = [];
		$shipping_classes  = WC()->shipping->get_shipping_classes();
		$html              = '<select rel-id="' . esc_attr( $count ) . '" name="fees[product_fees_conditions_values][value_' . esc_attr( $count ) . '][]" class="wcpfc_select product_fees_conditions_values multiselect2" multiple="multiple">';
		if ( isset( $shipping_classes ) && ! empty( $shipping_classes ) ) {
			foreach ( $shipping_classes as $shipping_classes_key ) {
				if ( $shipping_classes_key ) {
					$shipping_classes_old = get_term_by( 'slug', $shipping_classes_key->slug, 'product_shipping_class' );
					if ( $shipping_classes_old ) {
						$selected                                            = array_map( 'intval', $selected );
						$selectedVal                                         = ! empty( $selected ) && in_array( $shipping_classes_old->term_id, $selected, true ) ? 'selected=selected' : '';
						$html                                                .= '<option value="' . esc_attr( $shipping_classes_old->term_id ) . '" ' . esc_attr( $selectedVal ) . '>' . esc_html( $shipping_classes_key->name ) . '</option>';
						$filter_rate_class[ $shipping_classes_old->term_id ] = $shipping_classes_key->name;
					}
				}
			}
		}
		$html .= '</select>';
		if ( $json ) {
			return $this->wcpfc_pro_convert_array_to_json( $filter_rate_class );
		}
		return $html;
	}
	/**
	 * Function for get payment method list
	 *
	 * @param string $count
	 * @param array  $selected
	 * @param bool   $json
	 *
	 * @return string or array $html
	 * @since 1.0.0
	 *
	 */
	public function wcpfc_pro_get_payment_methods__premium_only( $count = '', $selected = array(), $json = false ) {
		$filter_payment_methods     = [];
		$available_payment_gateways = WC()->payment_gateways->payment_gateways();
		$html                       = '<select name="fees[product_fees_conditions_values][value_' . esc_attr( $count ) . '][]" class="wcpfc_select product_fees_conditions_values multiselect2" multiple="multiple">';
		if ( ! empty( $available_payment_gateways ) ) {
			foreach ( $available_payment_gateways as $available_gateways_key => $available_gateways_val ) {
                if( "pre_install_woocommerce_payments_promotion" === $available_gateways_val->id ){
                    continue;
                }
				$selectedVal                                           = is_array( $selected ) && ! empty( $selected ) && in_array( $available_gateways_key, $selected, true ) ? 'selected=selected' : '';
				$html                                                  .= '<option value="' . esc_attr( $available_gateways_val->id ) . '" ' . esc_attr( $selectedVal ) . '>' . esc_html( $available_gateways_val->title ) . '</option>';
				$filter_payment_methods[ $available_gateways_val->id ] = $available_gateways_val->title;
			}
		}
		$html .= '</select>';
		if ( $json ) {
			return $this->wcpfc_pro_convert_array_to_json( $filter_payment_methods );
		}
		return $html;
	}
	/**
	 * Function for get active shipping method list
	 *
	 * @param string $count
	 * @param array  $selected
	 * @param bool   $json
	 *
	 * @return string or array $html
	 * @since 1.0.0
	 *
	 */
	public function wcpfc_pro_get_active_shipping_methods__premium_only( $count = '', $selected = array(), $json = false ) {
		$active_methods   = array();
		$final_shipping_methods = array();

		//Tree Table Rate Shipping global setting plugin
		if ( class_exists('TrsVendors_DgmWpPluginBootstrapGuard') ){
			$unique_name = new Trs\Woocommerce\ShippingMethod();
			$ttr_config  = get_option( 'woocommerce_'.$unique_name->id.'_settings' );
			if ( isset( $ttr_config ) && is_array( $ttr_config ) ) {
				if ( 'yes' === $ttr_config['enabled'] ) {
					$default_ttr_title = $unique_name->title;

						$ttr_method_rule = json_decode($ttr_config['rule']);
						if ( count($ttr_method_rule->children) > 0 ){
							
							$wcRateIdsCounters = array();
							
							foreach( $ttr_method_rule->children as $ttr_method_child ){
								
								$ttr_method_child_title = $ttr_method_child->meta->title ? $ttr_method_child->meta->title : ($ttr_method_child->meta->label ? $ttr_method_child->meta->label : $default_ttr_title);
								$method_name = $default_ttr_title . ' > ' . $ttr_method_child_title;

								$ttr_method_hash_title = $ttr_method_child->meta->title ? $ttr_method_child->meta->title : $default_ttr_title;
				
								$idParts = array();

								$hash = substr(md5($ttr_method_hash_title), 0, 8);
								$idParts[] = $hash;

								$slug = strtolower($ttr_method_hash_title);
								$slug = preg_replace('/[^a-z0-9]+/', '_', $slug);
								$slug = preg_replace('/_+/', '_', $slug);
								$slug = trim($slug, '_');
								if ($slug !== '') {
									$idParts[] = $slug;
								}

								$id = join('_', $idParts);

								$ttr_count = isset($wcRateIdsCounters[$id]) ? $wcRateIdsCounters[$id]++ : ($wcRateIdsCounters[$id]=0);
								if ( $ttr_count > 0 ) {
									$id .= '_'.($ttr_count+1);
								}

								$method_id = $unique_name->id . ':' . $id;

								$method_args           = array(
									'id'           => $unique_name->id,
									'method_title' => $ttr_method_hash_title,
									'title'        => $ttr_method_hash_title,
									'tax_status'   => ('yes' === $ttr_config['enabled']) ? 'taxable' : '',
									'full_title'   => esc_html( $method_name ),
								);
								
								$active_methods[ $method_id ] = $method_args;
							}
						}
				}
			}
			
		}

		//Weight Based Shipping global setting plugin
		if ( class_exists( 'WbsVendors_DgmWpPluginBootstrapGuard' ) ) {
			$unique_name = new \Wbs\Plugin( wp_normalize_path(WP_PLUGIN_DIR.'/weight-based-shipping-for-woocommerce/plugin.php') );
			$wbs_config  = get_option( 'wbs_config' );
			if ( isset( $wbs_config ) && is_array( $wbs_config ) ) {
				if ( true === $wbs_config['enabled'] ) {
					foreach ( $wbs_config['rules'] as $wbs_value ) {
						if ( ! empty( $wbs_value ) ) {
							foreach ( $wbs_value as $wbs_meta_value ) {
								if ( ! empty( $wbs_meta_value['title'] ) ) {
									$idParts   = array();
									$hash      = substr( md5( $wbs_meta_value['title'] ), 0, 8 );
									$idParts[] = $hash;
									$slug      = strtolower( $wbs_meta_value['title'] );
									$slug      = preg_replace( '/[^a-z0-9]+/', '_', $slug );
									$slug      = preg_replace( '/_+/', '_', $slug );
									$slug      = trim( $slug, '_' );
									if ( $slug !== '' ) {
										$idParts[] = $slug;
									}
									$id                                      = implode( '_', $idParts );
									$unique_shipping_id                      = $unique_name::ID . ':' . $id;
									$method_args           = array(
										'id'           => $unique_name::ID,
										'method_title' => $wbs_meta_value['title'],
										'title'        => $wbs_meta_value['title'],
										'tax_status'   => ($wbs_meta_value['taxable']) ? 'taxable' : '',
										'full_title'   => esc_html( $wbs_meta_value['title'] ),
									);
									$active_methods[ $unique_shipping_id ] = $method_args;
								}
							}
						}
					}
				}
			}
		}

		//Advanced Flat Rate plugin by thedotstore
		if ( wcpffc_fs()->is__premium_only() && wcpffc_fs()->can_use_premium_code() ) {
			if ( class_exists( 'Advanced_Flat_Rate_Shipping_For_WooCommerce_Pro_Admin' ) ) {
				$adrsfwp          = new Advanced_Flat_Rate_Shipping_For_WooCommerce_Pro_Admin( '', '' );
				$get_all_shipping = $adrsfwp::afrsm_pro_get_shipping_method( 'not_list' );
				$plugins_unique_id = 'advanced_flat_rate_shipping';
			}
		} else {
			/* Free */
			if ( class_exists( 'Advanced_Flat_Rate_Shipping_For_WooCommerce_Free_Admin' ) ) {
				$adrsfwp          = new Advanced_Flat_Rate_Shipping_For_WooCommerce_Free_Admin( '', '' );
				$get_all_shipping = $adrsfwp::afrsm_get_shipping_method( 'not_list' );
				$plugins_unique_id = 'advanced_flat_rate_shipping';
			}
		}
		if ( ! empty( $get_all_shipping ) ) {
			foreach ( $get_all_shipping as $get_all_shipping_data ) {
				$unique_shipping_id = $plugins_unique_id . ':' . $get_all_shipping_data->ID;
				$sm_cost            = get_post_meta( $get_all_shipping_data->ID, 'sm_product_cost', true );
				if ( ! empty( $sm_cost ) || '0' !== $sm_cost ) {
					$method_args           = array(
						'id'           => $plugins_unique_id,
						'method_title' => $get_all_shipping_data->post_title,
						'title'        => $get_all_shipping_data->post_title,
						'tax_status'   => ('yes' === get_post_meta( $get_all_shipping_data->ID, 'sm_select_taxable', true )) ? 'taxable' : '',
						'full_title'   => esc_html( $get_all_shipping_data->post_title ),
					);
					$active_methods[ $unique_shipping_id ] = $method_args;
				}
			}
		}

		$delivery_zones    = WC_Shipping_Zones::get_zones();
		foreach ( $delivery_zones as $the_zone ) {
			$shipping_methods =  !empty($the_zone['shipping_methods']) ?  $the_zone['shipping_methods'] : array();
			if( !empty($shipping_methods) ){
				foreach ( $shipping_methods as $id => $shipping_method ) {

					if( !isset( $shipping_method->enabled ) || 'yes' !== $shipping_method->enabled ){
						continue;
					}

					if ( 'jem_table_rate' !== $shipping_method->id && 'tree_table_rate' !== $shipping_method->id && 'wbs' !== $shipping_method->id ) {
						$method_args           = array(
							'id'           => $shipping_method->id,
							'method_title' => $shipping_method->method_title,
							'title'        => $shipping_method->title,
							'tax_status'   => $shipping_method->tax_status,
							'full_title'   => esc_html( $the_zone['zone_name'] . ' - ' . $shipping_method->title ),
						);
						$method_id = $shipping_method->id . ':' . $id;
						$active_methods[ $method_id ] = $method_args;
					}

					//Table Rate Shipping for WooCommerce by JEM plugins
					if ( class_exists('JEMTR_Table_Rate_Shipping_Method') && 'jem_table_rate' === $shipping_method->id ) {
						if ( 'yes' === $shipping_method->enabled && !empty($shipping_method->instance_id) ) {
							$jemtr_methods = get_option( $shipping_method->id.'_shipping_methods_' . $shipping_method->instance_id );
							if( ! empty( $jemtr_methods ) ){	
								foreach( $jemtr_methods as $jemtr_method ){
									if( 'yes' === $jemtr_method['method_enabled'] ) {
										$method_name = $the_zone['zone_name'] . ' - ' . $shipping_method->method_title . ' > ' . $jemtr_method['method_title'];
										$method_id = $shipping_method->id . '_' . $shipping_method->instance_id . '_' . sanitize_title($jemtr_method['method_title']);
										$method_args           = array(
											'id'           => $shipping_method->id,
											'method_title' => $jemtr_method['method_title'],
											'title'        => $jemtr_method['method_title'],
											'tax_status'   => $jemtr_method['method_tax_status'],
											'full_title'   => esc_html( $method_name ),
										);
										$active_methods[ $method_id ] = $method_args;
									}
								}
							}
						}
					}

					//Tree Table Rate Shipping method-wise setting
					if ( class_exists('TrsVendors_DgmWpPluginBootstrapGuard') && 'tree_table_rate' === $shipping_method->id ) {
						$ttr_method = get_option( 'woocommerce_' . $shipping_method->id . '_' . $shipping_method->instance_id . '_settings' );

						$default_ttr_title = $shipping_method->title;
						
						$ttr_method_rule = json_decode($ttr_method['rule']);
						if ( count($ttr_method_rule->children) > 0 ){
							
							$wcRateIdsCounters = array();
							foreach( $ttr_method_rule->children as $ttr_method_child ){
								
								$ttr_method_child_title = $ttr_method_child->meta->title ? $ttr_method_child->meta->title : ($ttr_method_child->meta->label ? $ttr_method_child->meta->label : $default_ttr_title);
								$method_name = $the_zone['zone_name'] . ' - ' . ($ttr_method['label'] ? $ttr_method['label'] : $default_ttr_title) . ' > ' . $ttr_method_child_title;

								$ttr_method_hash_title = $ttr_method_child->meta->title ? $ttr_method_child->meta->title : ($ttr_method['label'] ? $ttr_method['label'] : $default_ttr_title);
				
								$idParts = array();

								$hash = substr(md5($ttr_method_hash_title), 0, 8);
								$idParts[] = $hash;

								$slug = strtolower($ttr_method_hash_title);
								$slug = preg_replace('/[^a-z0-9]+/', '_', $slug);
								$slug = preg_replace('/_+/', '_', $slug);
								$slug = trim($slug, '_');
								if ($slug !== '') {
									$idParts[] = $slug;
								}

								$id = join('_', $idParts);

								$ttr_count = isset($wcRateIdsCounters[$id]) ? $wcRateIdsCounters[$id]++ : ($wcRateIdsCounters[$id]=0);
								if ( $ttr_count > 0 ) {
									$id .= '_'.($ttr_count+1);
								}

								$method_id = $shipping_method->id . ':' . $shipping_method->instance_id . ':' . $id;

								$method_args           = array(
									'id'           => $shipping_method->id,
									'method_title' => $ttr_method['label'],
									'title'        => $ttr_method['label'],
									'tax_status'   => $ttr_method['tax_status'],
									'full_title'   => esc_html( $method_name ),
								);
								
								$active_methods[ $method_id ] = $method_args;
							}
						}
						
					}

					//Weight Based Shipping method-wise setting
					if ( class_exists( 'WbsVendors_DgmWpPluginBootstrapGuard' ) && 'wbs' === $shipping_method->id ) {
						$wbs_method  = get_option( $shipping_method->id . '_' . $shipping_method->instance_id . '_config' );

						$default_wbs_title = $shipping_method->title;

						$wbs_method_rules = $wbs_method['rules'];
						if ( count( $wbs_method_rules ) > 0 && $wbs_method['enabled']) {
							
							$wcRateIdsCounters = array();
							$wbs_count = 0;
							foreach ( $wbs_method_rules as $wbs_value ) {
								$wbs_method_child_title = $wbs_value['meta']['title'] ? $wbs_value['meta']['title'] : $default_wbs_title;
								if ( $wbs_value['meta']['enabled'] ) {
									$idParts   = array();
									$hash      = substr( md5( $wbs_method_child_title ), 0, 8 );
									$idParts[] = $hash;
									$slug      = strtolower( $wbs_method_child_title );
									$slug      = preg_replace( '/[^a-z0-9]+/', '_', $slug );
									$slug      = preg_replace( '/_+/', '_', $slug );
									$slug      = trim( $slug, '_' );
									if ( $slug !== '' ) {
										$idParts[] = $slug;
									}
									$id = implode( '_', $idParts );

									$wbs_count = isset($wcRateIdsCounters[$id]) ? $wcRateIdsCounters[$id]++ : ($wcRateIdsCounters[$id]=0);
									if ( $wbs_count > 0) {
										$id .= '_'.($wbs_count+1);
									}

									$unique_shipping_id = $shipping_method->id . ':' . $shipping_method->instance_id . ':' . $id;

									$method_args           = array(
										'id'           => $shipping_method->id,
										'method_title' => $wbs_method_child_title,
										'title'        => $wbs_method_child_title,
										'tax_status'   => ($wbs_value['meta']['taxable']) ? 'taxable' : '',
										'full_title'   => esc_html( $wbs_method_child_title ),
									);
									$active_methods[ $unique_shipping_id ] = $method_args;
								}
							}
						}
					}

				}
			}
		}

		$html = '<select name="fees[product_fees_conditions_values][value_' . esc_attr( $count ) . '][]" class="wcpfc_select product_fees_conditions_values multiselect2" multiple="multiple">';
		if ( ! empty( $active_methods ) ) {
			foreach ( $active_methods as $method_key => $method_val ) {
				$selectedVal                           = is_array( $selected ) && ! empty( $selected ) && in_array( $method_key, $selected, true ) ? 'selected=selected' : '';
				$html                                  .= '<option value="' . esc_attr( $method_key ) . '" ' . esc_attr( $selectedVal ) . '>' . esc_html( $method_val['full_title'] ) . '</option>';
				$final_shipping_methods[ $method_key ] = $method_val['full_title'];
			}
		}
		if ( $json ) {
			return $this->wcpfc_pro_convert_array_to_json( $final_shipping_methods );
		}
		$html .= '</select>';
		return $html;
	}
	/**
	 * Function for get zone list
	 *
	 * @param string $count
	 * @param array  $selected
	 * @param bool   $json
	 *
	 * @return string or array $html
	 * @since 1.0.0
	 *
	 */
	public function wcpfc_pro_get_zones_list__premium_only( $count = '', $selected = array(), $json = false ) {
		$filter_zone = [];
		$raw_zones   = WC_Shipping_Zones::get_zones();
		$html        = '<select rel-id="' . esc_attr( $count ) . '" name="fees[product_fees_conditions_values][value_' . esc_attr( $count ) . '][]" class="wcpfc_select product_fees_conditions_values multiselect2" multiple="multiple">';
		if ( isset( $raw_zones ) && ! empty( $raw_zones ) ) {
			foreach ( $raw_zones as $zone ) {
				$selected                        = array_map( 'intval', $selected );
				$zone['zone_id']                 = (int) $zone['zone_id'];
				$selectedVal                     = is_array( $selected ) && ! empty( $selected ) && in_array( $zone['zone_id'], $selected, true ) ? 'selected=selected' : '';
				$html                            .= '<option value="' . esc_attr( $zone['zone_id'] ) . '" ' . esc_attr( $selectedVal ) . '>' . esc_html( $zone['zone_name'] ) . '</option>';
				$filter_zone[ $zone['zone_id'] ] = $zone['zone_name'];
			}
		}
		if ( $json ) {
			return $this->wcpfc_pro_convert_array_to_json( $filter_zone );
		}
		$html .= '</select>';
		return $html;
	}
	/**
	 * Function for multiple delete fees
	 *
	 * @since 1.0.0
	 */
	public function wcpfc_pro_wc_multiple_delete_conditional_fee() {
		check_ajax_referer( 'dsm_nonce', 'nonce' );
		$result      = 0;
		$get_allVals = filter_input( INPUT_GET, 'allVals', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY );
		$allVals     = ! empty( $get_allVals ) ? array_map( 'sanitize_text_field', wp_unslash( $get_allVals ) ) : array();
		if ( ! empty( $allVals ) ) {
			foreach ( $allVals as $val ) {
				wp_delete_post( $val );
				$result = 1;
			}
		}
		if ( 1 === $result ) {
			$html = esc_html__( 'Selected fees rule has been deleted successfully.', 'woocommerce-conditional-product-fees-for-checkout' );
			delete_transient( 'get_top_ten_fees' );
			delete_transient( 'get_all_fees' );
			delete_transient( 'get_all_dashboard_fees' );
		} else {
			$html = esc_html__( 'Something went wrong', 'woocommerce-conditional-product-fees-for-checkout' );
		}
		echo esc_html( $html );
		wp_die();
	}
	/**
	 * Function for multiple delete fees
	 *
	 * @since 1.0.0
	 */
	public function wcpfc_reset_fee_cache() {
		check_ajax_referer( 'dsm_nonce', 'nonce' );

		$html = esc_html__( 'Somethng went wrong!', 'woocommerce-conditional-product-fees-for-checkout' );
        
        delete_transient( 'get_all_fees' );

		if( delete_transient( 'get_top_ten_fees' )  
			&& delete_transient( 'get_all_dashboard_fees' ) 
			&& delete_transient( 'get_total_revenue' )
			&& delete_transient( 'get_total_yearly_revenue' )
			&& delete_transient( 'get_total_last_month_revenue' )
			&& delete_transient( 'get_total_this_month_revenue' )
			&& delete_transient( 'get_total_yesterday_revenue' )
			&& delete_transient( 'get_total_today_revenue' )
		) {
			$html = esc_html__( 'Fees data has been updated successfully.', 'woocommerce-conditional-product-fees-for-checkout' );
		}
		
		echo esc_html( $html );
		wp_die();
	}
	/**
	 * Function for multiple disable fees
	 *
	 * @since 1.0.0
	 */
	public function wcpfc_pro_multiple_disable_conditional_fee() {
		check_ajax_referer( 'disable_fees_nonce', 'nonce' );
		$result        = 0;
		$get_allVals   = filter_input( INPUT_GET, 'allVals', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY );
		$get_do_action = filter_input( INPUT_GET, 'do_action', FILTER_SANITIZE_STRING );
		$allVals       = ! empty( $get_allVals ) ? array_map( 'sanitize_text_field', wp_unslash( $get_allVals ) ) : array();
		$do_action     = isset( $get_do_action ) ? sanitize_text_field( $get_do_action ) : '';
		if ( ! empty( $allVals ) ) {
			foreach ( $allVals as $val ) {
				if ( $do_action === 'disable-conditional-fee' ) {
					$post_args = array(
						'ID'          => $val,
						'post_status' => 'draft',
						'post_type'   => self::wcpfc_post_type,
					);
					wp_update_post( $post_args );
					update_post_meta( $val, 'fee_settings_status', 'off' );
				} else if ( $do_action === 'enable-conditional-fee' ) {
					$post_args = array(
						'ID'          => $val,
						'post_status' => 'publish',
						'post_type'   => self::wcpfc_post_type,
					);
					wp_update_post( $post_args );
					update_post_meta( $val, 'fee_settings_status', 'on' );
				}
				$result = 1;
			}
		}
		if ( 1 === $result ) {
			$html = esc_html__( "Fees status has been changed successfully.", 'woocommerce-conditional-product-fees-for-checkout' );
		} else {
			$html = esc_html__( "Something went wrong", 'woocommerce-conditional-product-fees-for-checkout' );
		}
		echo esc_html( $html );
		wp_die();
	}
	/**
	 * Function for export all fee with revenue
	 *
	 * @since 3.7.0
	 */
	public function wcpfc_export_all_fees_revenue__premium_only() {
        WP_Filesystem();
        global $wp_filesystem;
		global $sitepress;
		$default_lang = $this->wcpfc_pro_get_default_langugae_with_sitpress();

		check_ajax_referer( 'dashboard_nonce', 'nonce' );

		$get_all_fees_args  = array(
			'post_type'      	=> self::wcpfc_post_type,
			'posts_per_page' 	=> -1,
			'post_status'    	=> 'publish',
			'suppress_filters'  => false,
			'meta_key'          => '_wcpfc_fee_revenue',
			'orderby'           => 'meta_value_num',
			'order'             => 'DESC'
		);
		$get_all_fees_query = new WP_Query( $get_all_fees_args );
		$get_all_fees       = $get_all_fees_query->get_posts();
		$get_all_fees_count = $get_all_fees_query->found_posts;
		$fees_array         = array();
		if ( $get_all_fees_count > 0 ) {
			
			$filename = 'export_fees_revenue_'.time().'.csv';
			header('Content-Type: text/csv');
			header('Content-Disposition: attachment; filename='.$filename);
			$file_path = wp_get_upload_dir()['basedir'].'/wcpfc-export/';
			if( !file_exists($file_path) ){
				wp_mkdir_p($file_path);
			} 
			array_map( 'unlink', array_filter((array) glob($file_path."*.csv") ) );
			$file_path = wp_get_upload_dir()['basedir'].'/wcpfc-export/'.$filename;
			$download_path = wp_get_upload_dir()['baseurl'].'/wcpfc-export/'.$filename;

            // Add this because our porjectdemo return non-SSL upload directory URL
			if ( is_ssl() ) {
		        $download_path = str_replace( 'http://', 'https://', $download_path );
            }
            
            $header_array = array('No', 'Fee Name', 'Revenue');
            $line = implode(",", $header_array)."\n";

			$fee_counter = 1;
			foreach ( $get_all_fees as $fees ) {
				if ( ! empty( $sitepress ) ) {
					$fee_id = apply_filters( 'wpml_object_id', $fees->ID, 'product', true, $default_lang );
				} else {
					$fee_id = $fees->ID;
				}
				$fee_name = get_the_title($fee_id);
				$fee_revenue = get_post_meta($fee_id, '_wcpfc_fee_revenue', true) ? get_post_meta($fee_id, '_wcpfc_fee_revenue', true) : 0;
				$fee_revenue = number_format($fee_revenue, 2);
                
                $fees_array = array($fee_counter, $fee_name, $fee_revenue);
                $line .= implode(",", $fees_array)."\n";
                
				$fee_counter++;
			}
            $wp_filesystem->put_contents( $file_path, $line, FS_CHMOD_FILE );

			$return = array( 'success' => true, 'message' => esc_html__('Export Done!', 'woocommerce-conditional-product-fees-for-checkout'), 'file' => $download_path, 'filename' => $filename );
		} else {
			$return = array( 'success' => false, 'message' => esc_html__('No data to export! please setup fees then export.', 'woocommerce-conditional-product-fees-for-checkout') );
		}

		wp_send_json($return);
	}
	/**
	 * Function for top ten fee with revenue
	 *
	 * @since 3.7.0
	 */
	public function wcpfc_top_ten_fees_revenue__premium_only() {
		global $sitepress;
		$default_lang = $this->wcpfc_pro_get_default_langugae_with_sitpress();

		check_ajax_referer( 'dashboard_nonce', 'nonce' );

		$get_all_fees = get_transient( 'get_top_ten_fees' );
		if ( false === $get_all_fees ) {
			$fees_args    = array(
				'post_type'        => self::wcpfc_post_type,
				'post_status'      => 'publish',
				'posts_per_page'   => 10,
				'suppress_filters' => false,
				'meta_key'         => '_wcpfc_fee_revenue',
				'orderby'          => 'meta_value_num',
				'order'            => 'DESC'
			);
			$get_all_fees_query = new WP_Query( $fees_args );
			$get_all_fees       = $get_all_fees_query->get_posts();
			set_transient( 'get_top_ten_fees', $get_all_fees, 15 * MINUTE_IN_SECONDS);
		}

		$get_all_fees_count = count($get_all_fees);
		$fees_array_list    = array();
		$fees_array_chart   = array();
		$rbgColorArr = $feeNameArr = $feeRevenueArr = array();
		if ( $get_all_fees_count > 0 ) {
			$fee_counter = 1;
			$currency_symbol = get_woocommerce_currency_symbol() ? get_woocommerce_currency_symbol() : '$';
			foreach ( $get_all_fees as $fees ) {
				if ( ! empty( $sitepress ) ) {
					$fee_id = apply_filters( 'wpml_object_id', $fees->ID, 'product', true, $default_lang );
				} else {
					$fee_id = $fees->ID;
				}
				if ( FALSE !== get_post_status( $fee_id ) ) {
					$fee_name = get_the_title($fee_id);
					$fee_revenue = get_post_meta($fee_id, '_wcpfc_fee_revenue', true) ? get_post_meta($fee_id, '_wcpfc_fee_revenue', true) : 0;
					$fee_revenue = number_format($fee_revenue, 2);
					
					array_push($fees_array_list, array($fee_counter, $fee_name, $currency_symbol.$fee_revenue));
					
					$rbgColor = $this->colorGenerator($fee_id);
					array_push($rbgColorArr, $rbgColor);
					
					array_push($feeNameArr, $fee_name);

					array_push($feeRevenueArr, $fee_revenue);

					$fee_counter++;
				}
			}
			array_push($fees_array_chart, $rbgColorArr, $feeNameArr, $feeRevenueArr);
			$return = array( 'success' => true, 'message' => esc_html__('Data fetched!', 'woocommerce-conditional-product-fees-for-checkout'), 'fees_array_list' => $fees_array_list, 'fees_array_chart' => $fees_array_chart, 'currency_symbol' => $currency_symbol );
		} else {
			$return = array( 'success' => false, 'message' => esc_html__('No fee Found! please setup fee to see report.', 'woocommerce-conditional-product-fees-for-checkout') );
		}

		wp_send_json($return);
	}
	/**
	 * Function for reset transient after fee delete
	 *
	 * @since 3.7.0
	 */
	public function wcpfc_clear_fee_cache($post_id) {
		if ( self::wcpfc_post_type === get_post_type($post_id) ) { 
			delete_transient( 'get_top_ten_fees' );
			delete_transient( 'get_all_fees' );
			delete_transient( 'get_all_dashboard_fees' );
		}
	}
	/**
	 * Function for date wisefee with revenue filter
	 *
	 * @since 3.7.0
	 */
	public function wcpfc_date_wise_fee_revenue__premium_only(){
		
		check_ajax_referer( 'dashboard_nonce', 'nonce' );

		global $sitepress;
		$default_lang = $this->wcpfc_pro_get_default_langugae_with_sitpress();
		
		$start_date  = ( !empty($_POST['start_date']) && isset($_POST['start_date']) ) ? sanitize_text_field($_POST['start_date']) : 'all';
		$end_date	 = ( !empty($_POST['end_date']) && isset($_POST['end_date']) ) ? sanitize_text_field($_POST['end_date']) : 'all';
		$fee_array = array();
		$currency_symbol = get_woocommerce_currency_symbol() ? get_woocommerce_currency_symbol() : '$';
		$update_fees = false;
		
		if( "all" !== $start_date && "all" !== $end_date ) {
			$fee_array = $this->get_fee_data_from_date_range( $start_date, $end_date, '' );
		} else {
			$fee_array = get_transient( 'get_all_dashboard_fees' );
			if ( false === $fee_array ) {
				$fee_array = $this->get_fee_data_from_date_range('','','all');
				set_transient( 'get_all_dashboard_fees', $fee_array, 15 * MINUTE_IN_SECONDS);
			}
			$update_fees = true;
		}

		$label = array();
		$revenue = array();
		$bgColor = array();
		if( !empty($fee_array) ){
			foreach( $fee_array as $fee_data_k => $fee_data_v ){
				if ( FALSE !== get_post_status( $fee_data_k ) && "publish" === get_post_status( $fee_data_k ) ) {
					$label[]   = get_the_title($fee_data_k);
					$revenue[] = $fee_data_v;
					$rbgColor  = $this->colorGenerator($fee_data_k);
					$bgColor[] = $rbgColor;
					if($update_fees){
						update_post_meta($fee_data_k, '_wcpfc_fee_revenue', $fee_data_v);
					}
				}
			}
		}

		$return = array( 'success' => true, 'message' => esc_html__('Data fetched!', 'woocommerce-conditional-product-fees-for-checkout'), 'label' => $label, 'revenue' => $revenue,'backgroundColor' => $bgColor, 'currency_symbol' => $currency_symbol );

		wp_send_json($return);
	}
	/**
	 * Function for date wise fee with revenue
	 *
	 * @since 3.7.0
	 */
	public function get_fee_data_from_date_range( $start_date, $end_date, $all = '' ){

        $default_lang = $this->wcpfc_pro_get_default_langugae_with_sitpress();

		if( '' === $all && (empty($start_date) || empty($end_date)) ){
			return 0;
		}
		global $sitepress;
		$filter_arr = array(
			"limit" => -1,
			"orderby" => "date",
			"return" => "ids",
			'status' => array('wc-processing', 'wc-completed'),
		);
		if( empty($all) ){
			$filter_arr["date_created"] = $start_date."...".$end_date;
		}

		$orders = wc_get_orders( $filter_arr );
		$fee_array = array();
		if( !empty($orders) ){
			foreach( $orders as $order_id ){
				$order = wc_get_order($order_id);
				$order_fees = $order->get_meta('_wcpfc_fee_summary');
				if( !empty($order_fees) ){
					foreach( $order_fees as $order_fee ){
						$fee_revenue = 0;
						if ( ! empty( $sitepress ) ) {
							$fee_id = apply_filters( 'wpml_object_id', $order_fee->id, 'product', true, $default_lang );
						} else {
							$fee_id = $order_fee->id;
						}
						$fee_id = ( !empty($fee_id) ) ? $fee_id : 0;
						if( $fee_id > 0 ){
							$fee_amount = !empty($order_fee->total) ? $order_fee->total : 0;
							if( !empty($order_fee->taxable) && $order_fee->taxable ){
								$fee_amount += ($order_fee->tax > 0) ? $order_fee->tax : 0;
							}
							$fee_revenue += $fee_amount;
							if( $fee_revenue > 0 && array_key_exists($fee_id, $fee_array) ){
								$fee_array[$fee_id] += $fee_revenue;
							} else {
								$fee_array[$fee_id] = $fee_revenue;
							}
						}
					}
				} else {
					if( !empty($order->get_fees()) ){
						foreach ($order->get_fees() as $fee_id => $fee) {
							$fee_revenue = 0;
							$fee_post = get_page_by_title( $fee['name'], OBJECT, 'wc_conditional_fee'); // phpcs:ignore
							$fee_id = !empty($fee_post) ? $fee_post->ID : 0;
							if ( ! empty( $sitepress ) ) {
								$fee_id = apply_filters( 'wpml_object_id', $fee_id, 'product', true, $default_lang );
							}
							//$fee_id 0 will consider as other custom fees.
							if( $fee['line_total'] > 0 ){
								$fee_revenue += $fee['line_total'];
							}
							if( $fee['line_tax'] > 0 ){
								$fee_revenue += $fee['line_tax'];
							}
							
							if( $fee_revenue >= 0 && array_key_exists($fee_id, $fee_array) ){
								$fee_array[$fee_id] += $fee_revenue;
							} else {
								$fee_array[$fee_id] = $fee_revenue;
							}
						}
					}
				}
			}
		}
		return $fee_array;
	}
	/**
	 * Function color generator in RGB from random number
	 *
	 * @since 3.7.0
	 */
	public function colorGenerator( $num = 10 ) {
		$hash = md5('color' . $num); // modify 'color' to get a different palette
		return 'rgb('.hexdec(substr($hash, 0, 2)) .', '. hexdec(substr($hash, 2, 2)) .', '. hexdec(substr($hash, 4, 2)).')'; 
	}
	/**
	 * Redirect page after plugin activation
	 *
	 * @uses  wcpfc_pro_register_post_type
	 *
	 * @since 1.0.0
	 */
	public function wcpfc_pro_welcome_conditional_fee_screen_do_activation_redirect() {
		$this->wcpfc_pro_register_post_type();
		// if no activation redirect
		if ( ! get_transient( '_welcome_screen_wcpfc_pro_mode_activation_redirect_data' ) ) {
			return;
		}
		// Delete the redirect transient
		delete_transient( '_welcome_screen_wcpfc_pro_mode_activation_redirect_data' );
		// if activating from network, or bulk
		$activate_multi = filter_input( INPUT_GET, 'activate-multi', FILTER_SANITIZE_SPECIAL_CHARS );
		if ( is_network_admin() || isset( $activate_multi ) ) {
			return;
		}
		// Redirect to extra cost welcome  page
		wp_safe_redirect( add_query_arg( array( 'page' => 'wcpfc-pro-list' ), admin_url( 'admin.php' ) ) );
		exit;
	}
	/**
	 * Register post type
	 *
	 * @since    1.0.0
	 */
	public function wcpfc_pro_register_post_type() {
		register_post_type( self::wcpfc_post_type, array(
			'labels' => array(
				'name'          => __( 'Advance Conditional Fees', 'woocommerce-conditional-product-fees-for-checkout' ),
				'singular_name' => __( 'Advance Conditional Fees', 'woocommerce-conditional-product-fees-for-checkout' ),
			),
		) );
	}
	/**
	 * Remove submenu from admin section
	 *
	 * @since 1.0.0
	 */
	public function wcpfc_pro_remove_admin_submenus() {
		remove_submenu_page( 'dots_store', 'wcpfc-pro-information' );
		remove_submenu_page( 'dots_store', 'wcpfc-pro-add-new' );
		remove_submenu_page( 'dots_store', 'wcpfc-pro-edit-fee' );
		remove_submenu_page( 'dots_store', 'wcpfc-pro-get-started' );
		if ( wcpffc_fs()->is__premium_only() ) {
			if ( wcpffc_fs()->can_use_premium_code() ) {
				remove_submenu_page( 'dots_store', 'wcpfc-pro-dashboard' );
				remove_submenu_page( 'dots_store', 'wcpfc-pro-import-export' );
			} else {
				remove_submenu_page( 'dots_store', 'wcpfc-premium' );
			}
		} else {
			remove_submenu_page( 'dots_store', 'wcpfc-premium' );
		}
	}
	/**
	 * When create fees based on product then all product will display using ajax
	 *
	 * @since 1.0.0
	 *
	 */
	public function wcpfc_pro_product_fees_conditions_values_product_ajax() {
		global $sitepress;
		$default_lang         = $this->wcpfc_pro_get_default_langugae_with_sitpress();
		$json                 = true;
		$filter_product_list  = [];
		$request_value        = filter_input( INPUT_GET, 'value', FILTER_SANITIZE_STRING );
		$posts_per_page       = filter_input( INPUT_GET, 'posts_per_page', FILTER_SANITIZE_NUMBER_INT );
		$_page                = filter_input( INPUT_GET, '_page', FILTER_SANITIZE_NUMBER_INT );
		$post_value           = isset( $request_value ) ? sanitize_text_field( $request_value ) : '';
		$baselang_product_ids = array();
		function wcpfc_posts_where( $where, $wp_query ) {
			global $wpdb;
			$search_term = $wp_query->get( 'search_pro_title' );
			if ( isset( $search_term ) ) {
				$search_term_like = $wpdb->esc_like( $search_term );
				$where            .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $search_term_like ) . '%\'';
			}
			return $where;
		}
		$product_args = array(
			'post_type'        => 'product',
			'posts_per_page'   => $posts_per_page,
            'offset'           => ($_page - 1) * $posts_per_page,
			'search_pro_title' => $post_value,
			'post_status'      => array( 'publish', 'private' ),
			'orderby'          => 'title',
			'order'            => 'ASC',
		);
		add_filter( 'posts_where', 'wcpfc_posts_where', 10, 2 );
		$wp_query = new WP_Query( $product_args );
		remove_filter( 'posts_where', 'wcpfc_posts_where', 10, 2 );
		$get_all_products = $wp_query->posts;
		if ( isset( $get_all_products ) && ! empty( $get_all_products ) ) {
			foreach ( $get_all_products as $get_all_product ) {
				$_product = wc_get_product( $get_all_product->ID );
				if ( $_product->is_type( 'simple' ) ) {	
                    if ( ! empty( $sitepress ) ) {
                        $defaultlang_product_id = apply_filters( 'wpml_object_id', $get_all_product->ID, 'product', true, $default_lang );
                    } else {
                        $defaultlang_product_id = $get_all_product->ID;
                    }
                    $baselang_product_ids[] = $defaultlang_product_id;
				}
			}
		}
		$html = '';
		if ( isset( $baselang_product_ids ) && ! empty( $baselang_product_ids ) ) {
			foreach ( $baselang_product_ids as $baselang_product_id ) {
				$html                  .= '<option value="' . $baselang_product_id . '">' . '#' . $baselang_product_id . ' - ' . get_the_title( $baselang_product_id ) . '</option>';
				$filter_product_list[] = array( $baselang_product_id, '#' . $baselang_product_id . ' - ' . get_the_title( $baselang_product_id ) );
			}
		}
		if ( $json ) {
			echo wp_json_encode( $filter_product_list );
			wp_die();
		}
		echo wp_kses( $html, Woocommerce_Conditional_Product_Fees_For_Checkout_Pro::allowed_html_tags() );
		wp_die();
	}
	/**
	 * When create fees based on advance pricing rule and add rule based onm product qty then all
	 * product will display using ajax
	 *
	 * @since 1.0.0
	 *
	 */
	public function wcpfc_pro_simple_and_variation_product_list_ajax() {
		global $sitepress;
		$default_lang                   = $this->wcpfc_pro_get_default_langugae_with_sitpress();
		$json                           = true;
		$filter_product_list            = [];
		$request_value                  = filter_input( INPUT_GET, 'value', FILTER_SANITIZE_STRING );
		$post_value                     = isset( $request_value ) ? sanitize_text_field( $request_value ) : '';
		$baselang_simple_product_ids    = array();
		$baselang_variation_product_ids = array();
		function wcpfc_posts_where( $where, $wp_query ) {
			global $wpdb;
			$search_term = $wp_query->get( 'search_pro_title' );
			if ( ! empty( $search_term ) ) {
				$search_term_like = $wpdb->esc_like( $search_term );
				$where            .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $search_term_like ) . '%\'';
			}
			return $where;
		}
		$product_args = array(
			'post_type'        => 'product',
			'posts_per_page'   => -1,
			'search_pro_title' => $post_value,
			'post_status'      => 'publish',
			'orderby'          => 'title',
			'order'            => 'ASC',
		);
		add_filter( 'posts_where', 'wcpfc_posts_where', 10, 2 );
		$get_wp_query = new WP_Query( $product_args );
		remove_filter( 'posts_where', 'wcpfc_posts_where', 10, 2 );
		$get_all_products = $get_wp_query->posts;
		if ( isset( $get_all_products ) && ! empty( $get_all_products ) ) {
			foreach ( $get_all_products as $get_all_product ) {
				$_product = wc_get_product( $get_all_product->ID );
				if ( $_product->is_type( 'variable' ) ) {
					$variations = $_product->get_available_variations();
					foreach ( $variations as $value ) {
						if ( ! empty( $sitepress ) ) {
							$defaultlang_variation_product_id = apply_filters( 'wpml_object_id', $value['variation_id'], 'product', true, $default_lang );
						} else {
							$defaultlang_variation_product_id = $value['variation_id'];
						}
						$baselang_variation_product_ids[] = $defaultlang_variation_product_id;
					}
				}
				if ( $_product->is_type( 'simple' ) ) {
					if ( ! empty( $sitepress ) ) {
						$defaultlang_simple_product_id = apply_filters( 'wpml_object_id', $get_all_product->ID, 'product', true, $default_lang );
					} else {
						$defaultlang_simple_product_id = $get_all_product->ID;
					}
					$baselang_simple_product_ids[] = $defaultlang_simple_product_id;
				}
			}
		}
		$baselang_product_ids = array_merge( $baselang_variation_product_ids, $baselang_simple_product_ids );
		$html                 = '';
		if ( isset( $baselang_product_ids ) && ! empty( $baselang_product_ids ) ) {
			foreach ( $baselang_product_ids as $baselang_product_id ) {
				$html                  .= '<option value="' . $baselang_product_id . '">' . '#' . $baselang_product_id . ' - ' . get_the_title( $baselang_product_id ) . '</option>';
				$filter_product_list[] = array( $baselang_product_id, '#' . $baselang_product_id . ' - ' . get_the_title( $baselang_product_id ) );
			}
		}
		if ( $json ) {
			echo wp_json_encode( $filter_product_list );
			wp_die();
		}
		echo wp_kses( $html, Woocommerce_Conditional_Product_Fees_For_Checkout_Pro::allowed_html_tags() );;
		wp_die();
	}
	/**
	 * Add link to plugin section
	 *
	 * @param mixed $links
	 *
	 * @return mixed $links
	 *
	 * @since 1.0.0
	 *
	 */
	function wcpfc_pro_product_fees_conditions_setting_link( $links ) {
		$links[] = '<a href="' .
		           admin_url( 'admin.php?page=wcpfc-pro-get-started' ) .
		           '">' . __( 'Settings', 'woocommerce-conditional-product-fees-for-checkout' ) . '</a>';
		return $links;
	}
	/**
	 * Sorting fess in list section
	 *
	 * @since 1.0.0
	 */
	function wcpfc_pro_conditional_fee_sorting() {

        check_ajax_referer( 'sorting_conditional_fee_action', 'sorting_conditional_fee' );

        global $sitepress, $wpdb;
        
        if ( ! empty( $sitepress ) ) {
			$default_lang = $sitepress->get_default_language();
		} else {
			$get_site_language = get_bloginfo( 'language' );
			if ( false !== strpos( $get_site_language, '-' ) ) {
				$get_site_language_explode = explode( '-', $get_site_language );
				$default_lang              = $get_site_language_explode[0];
			} else {
				$default_lang = $get_site_language;
			}
		}
        $post_type 			= self::wcpfc_post_type;
        $getPaged      		= filter_input( INPUT_POST, 'paged', FILTER_SANITIZE_NUMBER_INT);
		$getListingArray	= filter_input( INPUT_POST, 'listing', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY );
		
        $paged     			= !empty( $getPaged ) ? $getPaged : 1;
		$listinbgArray     	= !empty( $getListingArray ) ? array_map( 'intval', wp_unslash( $getListingArray ) ) : array();

        $results = new WP_Query( 
            array( 
                'post_type' => $post_type, 
                'post_status' => array('publish', 'draft'),
                'fields' => 'ids',
                'orderby' => array( 
                    'menu_order' =>'ASC', 
                    'post_date' => 'DESC'
                ),
                'posts_per_page' => -1
            )
        );

        //Create the list of ID's
		$objects_ids = array();            
		foreach($results->posts as $result) {
			$objects_ids[] = (int)$result; 
		}
        
        //Here we switch order
		$per_page = get_option( 'chk_fees_per_page' ) ? get_option( 'chk_fees_per_page' ) : 10;
		$edit_start_at = $paged * $per_page - $per_page;
		$index = 0;
		for( $i = $edit_start_at; $i < ($edit_start_at + $per_page); $i++ ) {

			if( !isset($objects_ids[$i]) )
				break;
				
			$objects_ids[$i] = (int)$listinbgArray[$index];
			$index++;
		}

        //Update the menu_order within database
		foreach( $objects_ids as $menu_order => $id ) {
			$data = array( 'menu_order' => $menu_order, 'ID' => $id);
            wp_update_post( $data );
			clean_post_cache( $id );
		}
        
        wp_send_json_success( array('message' => esc_html__( 'Fee rules has been updated.', 'woocommerce-conditional-product-fees-for-checkout' ) ) );
	}
	/**
	 * Ajax response of product wc product variable
	 *
	 * @since 1.0.0
	 */
	public function wcpfc_pro_product_fees_conditions_varible_values_product_ajax() {
		global $sitepress;
		$default_lang                   = $this->wcpfc_pro_get_default_langugae_with_sitpress();
		$json                           = true;
		$filter_variable_product_list   = [];
		$request_value                  = filter_input( INPUT_GET, 'value', FILTER_SANITIZE_STRING );
		$_page                          = filter_input( INPUT_GET, '_page', FILTER_SANITIZE_NUMBER_INT );
		$posts_per_page                 = filter_input( INPUT_GET, 'posts_per_page', FILTER_SANITIZE_NUMBER_INT );
		$post_value                     = isset( $request_value ) ? sanitize_text_field( $request_value ) : '';
		$baselang_product_ids           = array();
		function wcpfc_posts_wheres( $where, $wp_query ) {
			global $wpdb;
			$search_term = $wp_query->get( 'search_pro_title' );
			if ( isset( $search_term ) ) {
				$search_term_like = $wpdb->esc_like( $search_term );
				$where            .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $search_term_like ) . '%\'';
			}
			return $where;
		}
		$product_args = array(
			'post_type'        => 'product_variation',
			'posts_per_page'   => $posts_per_page,
            'offset'           => ($_page - 1) * $posts_per_page,
			'search_pro_title' => $post_value,
			'post_status'      => array( 'publish', 'private' ),
			'orderby'          => 'title',
			'order'            => 'ASC',
		);
		add_filter( 'posts_where', 'wcpfc_posts_wheres', 10, 2 );
		$get_all_products = new WP_Query( $product_args );
		remove_filter( 'posts_where', 'wcpfc_posts_wheres', 10, 2 );

		if ( ! empty( $get_all_products ) ) {
			foreach ( $get_all_products->posts as $get_all_product ) {
                if ( ! empty( $sitepress ) ) {
                    $defaultlang_product_id = apply_filters( 'wpml_object_id', $get_all_product->ID, 'product', true, $default_lang );
                } else {
                    $defaultlang_product_id = $get_all_product->ID;
                }
                $baselang_product_ids[] = $defaultlang_product_id;
			}
		}
		$html = '';
		if ( isset( $baselang_product_ids ) && ! empty( $baselang_product_ids ) ) {
			foreach ( $baselang_product_ids as $baselang_product_id ) {
				$html                           .= '<option value="' . $baselang_product_id . '">' . '#' . $baselang_product_id . ' - ' . get_the_title( $baselang_product_id ) . '</option>';
				$filter_variable_product_list[] = array( $baselang_product_id, '#' . $baselang_product_id . ' - ' . get_the_title( $baselang_product_id ) );
			}
		}
		if ( $json ) {
			echo wp_json_encode( $filter_variable_product_list );
			wp_die();
		}
		echo wp_kses( $html, Woocommerce_Conditional_Product_Fees_For_Checkout_Pro::allowed_html_tags() );
		wp_die();
	}
	/**
	 * Admin footer review
	 *
	 * @since 1.0.0
	 */
	public function wcpfc_pro_admin_footer_review() {
		$url = '';
		if ( wcpffc_fs()->is__premium_only() ) {
			if ( wcpffc_fs()->can_use_premium_code() ) {
				$url = esc_url( 'https://www.thedotstore.com/woocommerce-conditional-product-fees-checkout/#tab-reviews' );
			}
		} else {
			$url = esc_url( 'https://wordpress.org/plugins/woo-conditional-product-fees-for-checkout/#reviews' );
		}
		$html = sprintf(
			'%s<strong>%s</strong>%s<a href=%s target="_blank">%s</a>', esc_html__( 'If you like ', 'woocommerce-conditional-product-fees-for-checkout' ), esc_html__( 'Installing WooCommerce Extra Fees Plugin ', 'woocommerce-conditional-product-fees-for-checkout' ), esc_html__( 'plugin, please leave us &#9733;&#9733;&#9733;&#9733;&#9733; ratings on ', 'woocommerce-conditional-product-fees-for-checkout' ), $url, esc_html__( 'DotStore', 'woocommerce-conditional-product-fees-for-checkout' )
		);
		echo wp_kses_post( $html );
	}
	/**
	 * Convert array to json
	 *
	 * @param array $arr
	 *
	 * @return array $filter_data
	 * @since 1.0.0
	 *
	 */
	public function wcpfc_pro_convert_array_to_json( $arr ) {
		$filter_data = [];
		foreach ( $arr as $key => $value ) {
			$option                        = [];
			$option['name']                = $value;
			$option['attributes']['value'] = $key;
			$filter_data[]                 = $option;
		}
		return $filter_data;
	}
	/**
	 * Get product list in advance pricing rules section
	 *
	 * @param string $count
	 * @param array  $selected
	 *
	 * @return mixed $html
	 * @since 1.0.0
	 *
	 */
	public function wcpfc_pro_get_product_options( $count = '', $selected = array() ) {
		global $sitepress;
		$default_lang                   = $this->wcpfc_pro_get_default_langugae_with_sitpress();
        $all_selected_product_ids = array();
		if ( ! empty( $selected ) && is_array( $selected ) ) {
			foreach ( $selected as $product_id ) {
				$_product = wc_get_product( $product_id );

				if ( 'product_variation' === $_product->post_type ) {
					$all_selected_product_ids[] = $_product->get_parent_id(); //parent_id;
				} else {
					$all_selected_product_ids[] = $product_id;
				}
			}
		}
        $all_selected_product_count = 900;
		$get_all_products               = new WP_Query( array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => $all_selected_product_count,
			'post__in'       => $all_selected_product_ids,
		) );
		$baselang_variation_product_ids = array();
		$defaultlang_simple_product_ids = array();
		$html                           = '';
		if ( isset( $get_all_products->posts ) && ! empty( $get_all_products->posts ) ) {
			foreach ( $get_all_products->posts as $get_all_product ) {
				$_product = wc_get_product( $get_all_product->ID );
				if ( $_product->is_type( 'variable' ) ) {
					$variations = $_product->get_available_variations();
					foreach ( $variations as $value ) {
						if ( ! empty( $sitepress ) ) {
							$defaultlang_variation_product_id = apply_filters( 'wpml_object_id', $value['variation_id'], 'product', true, $default_lang );
						} else {
							$defaultlang_variation_product_id = $value['variation_id'];
						}
						$baselang_variation_product_ids[] = $defaultlang_variation_product_id;
					}
				}
				if ( $_product->is_type( 'simple' ) ) {
					if ( ! empty( $sitepress ) ) {
						$defaultlang_simple_product_id = apply_filters( 'wpml_object_id', $get_all_product->ID, 'product', true, $default_lang );
					} else {
						$defaultlang_simple_product_id = $get_all_product->ID;
					}
					$defaultlang_simple_product_ids[] = $defaultlang_simple_product_id;
				}
			}
		}
		$baselang_product_ids = array_merge( $baselang_variation_product_ids, $defaultlang_simple_product_ids );
		if ( isset( $baselang_product_ids ) && ! empty( $baselang_product_ids ) ) {
			foreach ( $baselang_product_ids as $baselang_product_id ) {
				$selected    = array_map( 'intval', $selected );
				$selectedVal = is_array( $selected ) && ! empty( $selected ) && in_array( $baselang_product_id, $selected, true ) ? 'selected=selected' : '';
				if ( '' !== $selectedVal ) {
					$html .= '<option value="' . $baselang_product_id . '" ' . $selectedVal . '>' . '#' . $baselang_product_id . ' - ' . get_the_title( $baselang_product_id ) . '</option>';
				}
			}
		}
		return $html;
	}
	/**
	 * Get category list in advance pricing rules section
	 *
	 * @param array $selected
	 *
	 * @return mixed $html
	 * @since 1.0.0
	 *
	 */
	public function wcpfc_pro_get_category_options__premium_only( $selected = array(), $json = false ) {
		global $sitepress;
		$default_lang         = $this->wcpfc_pro_get_default_langugae_with_sitpress();
		$filter_category_list = [];
		$args                 = array(
			'taxonomy'     => 'product_cat',
			'orderby'      => 'name',
			'hierarchical' => true,
			'hide_empty'   => false,
		);
		$get_all_categories   = get_terms( 'product_cat', $args );
		$html                 = '';
		if ( isset( $get_all_categories ) && ! empty( $get_all_categories ) ) {
			foreach ( $get_all_categories as $get_all_category ) {
				if ( $get_all_category ) {
					if ( ! empty( $sitepress ) ) {
						$new_cat_id = apply_filters( 'wpml_object_id', $get_all_category->term_id, 'product_cat', true, $default_lang );
					} else {
						$new_cat_id = $get_all_category->term_id;
					}
					$category        = get_term_by( 'id', $new_cat_id, 'product_cat' );
					$parent_category = get_term_by( 'id', $category->parent, 'product_cat' );
					if ( ! empty( $selected ) ) {
						$selected    = array_map( 'intval', $selected );
						$selectedVal = is_array( $selected ) && ! empty( $selected ) && in_array( $new_cat_id, $selected, true ) ? 'selected=selected' : '';
						if ( $category->parent > 0 ) {
							$html .= '<option value=' . $category->term_id . ' ' . $selectedVal . '>' . '' . $parent_category->name . '->' . $category->name . '</option>';
						} else {
							$html .= '<option value=' . $category->term_id . ' ' . $selectedVal . '>' . $category->name . '</option>';
						}
					} else {
						if ( $category->parent > 0 ) {
							$filter_category_list[ $category->term_id ] = $parent_category->name . '->' . $category->name;
						} else {
							$filter_category_list[ $category->term_id ] = $category->name;
						}
					}
				}
			}
		}
		if ( true === $json ) {
			return wp_json_encode( $this->wcpfc_pro_convert_array_to_json( $filter_category_list ) );
		} else {
			return $html;
		}
	}
	
	/**
	 * Change fees status in list section
	 *
	 * @since 1.0.0
	 */
	public function wcpfc_pro_change_status_from_list_section() {
		$get_current_fees_id = filter_input( INPUT_GET, 'current_fees_id', FILTER_SANITIZE_NUMBER_INT );
		$get_current_value   = filter_input( INPUT_GET, 'current_value', FILTER_SANITIZE_STRING );
		if ( ! ( isset( $get_current_fees_id ) ) ) {
			echo '<strong>' . esc_html__( 'Something went wrong', 'woocommerce-conditional-product-fees-for-checkout' ) . '</strong>';
			wp_die();
		}
		$post_id       = isset( $get_current_fees_id ) ? absint( $get_current_fees_id ) : '';
		$current_value = isset( $get_current_value ) ? sanitize_text_field( $get_current_value ) : '';
		if ( 'true' === $current_value ) {
			$post_args   = array(
				'ID'          => $post_id,
				'post_status' => 'publish',
				'post_type'   => self::wcpfc_post_type,
			);
			$post_update = wp_update_post( $post_args );
			update_post_meta( $post_id, 'fee_settings_status', 'on' );
		} else {
			$post_args   = array(
				'ID'          => $post_id,
				'post_status' => 'draft',
				'post_type'   => self::wcpfc_post_type,
			);
			$post_update = wp_update_post( $post_args );
			update_post_meta( $post_id, 'fee_settings_status', 'off' );
		}
		if ( ! empty( $post_update ) ) {
			echo esc_html__( 'Fees status has been changed successfully.', 'woocommerce-conditional-product-fees-for-checkout' );
			delete_transient( 'get_top_ten_fees' );
			delete_transient( 'get_all_fees' );
			delete_transient( 'get_all_dashboard_fees' );
		} else {
			echo esc_html__( 'Something went wrong', 'woocommerce-conditional-product-fees-for-checkout' );
		}
		wp_die();
	}
	/**
	 * Change advance pricing rule's status
	 *
	 * @since 1.0.0
	 */
	public function wcpfc_pro_change_status_of_advance_pricing_rules__premium_only() {
		/* Check for post request */
		$get_current_fees_id = filter_input( INPUT_GET, 'current_fees_id', FILTER_SANITIZE_NUMBER_INT );
		$get_current_value   = filter_input( INPUT_GET, 'current_value', FILTER_SANITIZE_STRING );
		if ( ! ( isset( $get_current_fees_id ) ) ) {
			echo '<strong>' . esc_html__( 'Something went wrong', 'woocommerce-conditional-product-fees-for-checkout' ) . '</strong>';
			wp_die();
		}
		$post_id       = isset( $get_current_fees_id ) ? absint( $get_current_fees_id ) : '';
		$current_value = isset( $get_current_value ) ? sanitize_text_field( $get_current_value ) : '';
		if ( 'true' === $current_value ) {
			update_post_meta( $post_id, 'ap_rule_status', 'off' );
			echo esc_html( "true" );
		}
		wp_die();
	}
	/**
	 * Save master settings data
	 *
	 * @since 1.0.0
	 */
	public function wcpfc_pro_save_master_settings() {
		$get_chk_enable_logging  		 = filter_input( INPUT_GET, 'chk_enable_logging', FILTER_SANITIZE_STRING );
		$chk_enable_coupon_fee   		 = filter_input( INPUT_GET, 'chk_enable_coupon_fee', FILTER_SANITIZE_STRING );
		$chk_enable_custom_fun   		 = filter_input( INPUT_GET, 'chk_enable_custom_fun', FILTER_SANITIZE_STRING );
		$chk_enable_all_fee_tax  		 = filter_input( INPUT_GET, 'chk_enable_all_fee_tax', FILTER_SANITIZE_STRING );
		$chk_enable_all_fee_tooltip 	 = filter_input( INPUT_GET, 'chk_enable_all_fee_tooltip', FILTER_SANITIZE_STRING );
		$chk_enable_all_fee_tooltip_text = filter_input( INPUT_GET, 'chk_enable_all_fee_tooltip_text', FILTER_SANITIZE_STRING );
		$chk_fees_per_page       		 = filter_input( INPUT_GET, 'chk_fees_per_page', FILTER_SANITIZE_STRING );

		if ( isset( $get_chk_enable_logging ) && ! empty( $get_chk_enable_logging ) ) {
			update_option( 'chk_enable_logging', $get_chk_enable_logging );
		}
		if ( isset( $chk_enable_coupon_fee ) && ! empty( $chk_enable_coupon_fee ) ) {
			update_option( 'chk_enable_coupon_fee', $chk_enable_coupon_fee );
		}
		if ( isset( $chk_enable_custom_fun ) && ! empty( $chk_enable_custom_fun ) ) {
			update_option( 'chk_enable_custom_fun', $chk_enable_custom_fun );
		}
		if ( isset( $chk_enable_all_fee_tax ) && ! empty( $chk_enable_all_fee_tax ) ) {
			update_option( 'chk_enable_all_fee_tax', $chk_enable_all_fee_tax );
		}
		if ( isset( $chk_enable_all_fee_tooltip ) && ! empty( $chk_enable_all_fee_tooltip ) ) {
			update_option( 'chk_enable_all_fee_tooltip', $chk_enable_all_fee_tooltip );
		}
		if ( isset( $chk_enable_all_fee_tooltip_text ) && ! empty( $chk_enable_all_fee_tooltip_text ) ) {
			$chk_enable_all_fee_tooltip_text = substr(sanitize_text_field( $chk_enable_all_fee_tooltip_text ), 0, 25);
			update_option( 'chk_enable_all_fee_tooltip_text', $chk_enable_all_fee_tooltip_text );
		}
		if ( isset( $chk_fees_per_page ) && ! empty( $chk_fees_per_page ) ) {
			update_option( 'chk_fees_per_page', $chk_fees_per_page );
		}
		wp_die();
	}
	/**
	 * Save fees order in fees list section
	 *
	 * @since 1.0.0
	 */
	public function wcpfc_pro_sm_sort_order() {
		$get_smOrderArray = filter_input( INPUT_GET, 'smOrderArray', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY );
		$smOrderArray     = ! empty( $get_smOrderArray ) ? array_map( 'sanitize_text_field', wp_unslash( $get_smOrderArray ) ) : '';
		if ( isset( $smOrderArray ) && ! empty( $smOrderArray ) ) {
			update_option( 'sm_sortable_order', $smOrderArray );
			delete_transient( 'get_all_fees' );
		}
		wp_die();
	}
	/**
	 * Get default site language
	 *
	 * @return string $default_lang
	 *
	 * @since  1.0.0
	 *
	 */
	public function wcpfc_pro_get_default_langugae_with_sitpress() {
		global $sitepress;
		if ( ! empty( $sitepress ) ) {
			$default_lang = $sitepress->get_current_language();
		} else {
			$default_lang = $this->wcpfc_pro_get_current_site_language();
		}
		return $default_lang;
	}
	/**
	 * Get current site langugae
	 *
	 * @return string $default_lang
	 * @since 1.0.0
	 *
	 */
	public function wcpfc_pro_get_current_site_language() {
		$get_site_language = get_bloginfo( "language" );
		if ( false !== strpos( $get_site_language, '-' ) ) {
			$get_site_language_explode = explode( '-', $get_site_language );
			$default_lang              = $get_site_language_explode[0];
		} else {
			$default_lang = $get_site_language;
		}
		return $default_lang;
	}
	/**
	 * Fetch slug based on id
	 *
	 * @since    3.6.1
	 */
	public function wcpfc_pro_fetch_slug( $id_array, $condition ) {
		$return_array = array();
		if ( ! empty( $id_array ) ) {
			foreach ( $id_array as $key => $ids ) {
				if ( 'product' === $condition || 'variableproduct' === $condition || 'cpp' === $condition ) {
					$get_posts = get_post( $ids );
					if ( ! empty( $get_posts ) ) {
						$return_array[] = $get_posts->post_name;
					}
				} elseif ( 'category' === $condition || 'cpc' === $condition ) {
					$term           = get_term( $ids, 'product_cat' );
					if ( $term ) {
						$return_array[] = $term->slug;
					}
				} elseif ( 'tag' === $condition ) {
					$tag            = get_term( $ids, 'product_tag' );
					if ( $tag ) {
						$return_array[] = $tag->slug;
					}
				} elseif ( 'shipping_class' === $condition ) {
					$shipping_class                        = get_term( $key, 'product_shipping_class' );
					if ( $shipping_class ) {
						$return_array[ $shipping_class->slug ] = $ids;
					}
				} elseif ( 'cpsc' === $condition ) {
					$return_array[] = $ids;
				} elseif ( 'cpp' === $condition ) {
					$cpp_posts = get_post( $ids );
					if ( ! empty( $cpp_posts ) ) {
						$return_array[] = $cpp_posts->post_name;
					}
				} else {
					$return_array[] = $ids;
				}
			}
		}
		return $return_array;
	}
	/**
	 * Fetch id based on slug
	 *
	 * @since    3.6.1
	 */
	public function wcpfc_pro_fetch_id( $slug_array, $condition ) {
		$return_array = array();
		if ( ! empty( $slug_array ) ) {
			foreach ( $slug_array as $key => $slugs ) {
				if ( 'product' === $condition ) {
					$post           = get_page_by_path( $slugs, OBJECT, 'product' ); // phpcs:ignore
					$id             = $post->ID;
					$return_array[] = $id;
				} elseif ( 'variableproduct' === $condition ) {
					$args           = array(
						'post_type'  	   => 'product_variation',
						'fields'    	   => 'ids',
						'name'      	   => $slugs
					);
					$variable_posts = new WP_Query( $args );
					if ( ! empty( $variable_posts->posts ) ) {
						foreach ( $variable_posts->posts as $val ) {
							$return_array[] = $val;
						}
					}
				} elseif ( 'category' === $condition || 'cpc' === $condition ) {
					$term           = get_term_by( 'slug', $slugs, 'product_cat' );
					if ( $term ) {
						$return_array[] = $term->term_id;
					}
				} elseif ( 'tag' === $condition ) {
					$term_tag       = get_term_by( 'slug', $slugs, 'product_tag' );
					if ( $term_tag ) {
						$return_array[] = $term_tag->term_id;
					}
				} elseif ( 'shipping_class' === $condition || 'cpsc' === $condition ) {
					$term_tag                           = get_term_by( 'slug', $key, 'product_shipping_class' );
					if ( $term_tag ) {
						$return_array[ $term_tag->term_id ] = $slugs;
					}
				} elseif ( 'cpp' === $condition ) {
					$args           = array(
						'post_type' 	   => array( 'product_variation', 'product' ),
                        'fields'    	   => 'ids',
						'name'         	   => $slugs,
					);
					$variable_posts = new WP_Query( $args );
					if ( ! empty( $variable_posts->posts ) ) {
						foreach ( $variable_posts->posts as $val ) {
							$return_array[] = $val;
						}
					}
				} else {
					$return_array[] = $slugs;
				}
			}
		}
		return $return_array;
	}

    /**
	 * Fetch translated IDs based on based language IDs.
	 *
	 * @since    3.9.2
     * @author   SJ
	 */
	public function wcpfc_wpml_translated_id( $slug_array, $condition, $language_code ) {
        global $sitepress;
		$return_array = array();
		if ( ! empty( $slug_array ) ) {
			foreach ( $slug_array as $key => $slugs ) {
				if ( 'product' === $condition ) {
                    $id = $slugs;
					if ( ! empty( $sitepress ) ) {
                        $id = apply_filters( 'wpml_object_id', $slugs, 'product', false, $language_code );
                    }
					$return_array[] = $id;
				} elseif ( 'variableproduct' === $condition ) {
					$id = $slugs;
					if ( ! empty( $sitepress ) ) {
                        $id = apply_filters( 'wpml_object_id', $slugs, 'product_variation', false, $language_code );
                    }
					$return_array[] = $id;
				} elseif ( 'category' === $condition || 'cpc' === $condition ) {
					$id = $slugs;
					if ( ! empty( $sitepress ) ) {
                        $id = apply_filters( 'wpml_object_id', $slugs, 'product_cat', false, $language_code );
                    }
					$return_array[] = $id;
				} elseif ( 'tag' === $condition ) {
					$id = $slugs;
					if ( ! empty( $sitepress ) ) {
                        $id = apply_filters( 'wpml_object_id', $slugs, 'product_tag', false, $language_code );
                    }
					$return_array[] = $id;
				} elseif ( 'shipping_class' === $condition ) {
					$id = $slugs;
					if ( ! empty( $sitepress ) ) {
                        $id = apply_filters( 'wpml_object_id', $slugs, 'product_shipping_class', false, $language_code );
                    }
					$return_array[] = $id;
				} elseif ( 'ap_shipping_class' === $condition ) {
                    $term_tag = get_term_by( 'slug', $slugs, 'product_shipping_class' );
                    $id = $term_tag->term_id;
					if ( ! empty( $sitepress ) ) {
                        $id = apply_filters( 'wpml_object_id', $id, 'product_shipping_class', false, $language_code );
                    }
                    $term_tag = get_term_by( 'term_id', $id, 'product_shipping_class' );
					$return_array[] = !empty($term_tag) && isset($term_tag->slug) && !empty($term_tag->slug) ? $term_tag->slug : '';
				} elseif ( strpos( $condition, 'pa_' ) === 0 ){
                    $term_tag = get_term_by( 'slug', $slugs, $condition );
                    $id = $term_tag->term_id;
					if ( ! empty( $sitepress ) ) {
                        $id = apply_filters( 'wpml_object_id', $id, $condition, false, $language_code );
                    }
                    $term_tag = get_term_by( 'term_id', $id, $condition );
					$return_array[] = !empty($term_tag) && isset($term_tag->slug) && !empty($term_tag->slug) ? $term_tag->slug : '';
                } else {
					$return_array[] = $slugs;
				}
			}
		}
		return $return_array;
	}
    
	/**
	 * Export Fees
	 *
	 * @since 3.1
	 *
	 */
	public function wcpfc_pro_import_export_fees__premium_only( $cli_args = array() ) {
        WP_Filesystem();
        global $wp_filesystem;

		$export_action = filter_input( INPUT_POST, 'wcpfc_export_action', FILTER_SANITIZE_STRING );
		$import_action = filter_input( INPUT_POST, 'wcpfc_import_action', FILTER_SANITIZE_STRING );
		if ( ! empty( $export_action ) || 'export_settings' === $export_action || ( !empty($cli_args) && 'export' === $cli_args['cli_type'] ) ) {
			$get_all_fees_args  = array(
				'post_type'      => self::wcpfc_post_type,
				'order'          => 'DESC',
				'posts_per_page' => -1,
				'orderby'        => 'ID',
                'post_status'    => array( 'publish', 'draft' )
			);
			$get_all_fees_query = new WP_Query( $get_all_fees_args );
			$get_all_fees       = $get_all_fees_query->get_posts();
			$get_all_fees_count = $get_all_fees_query->found_posts;
			$fees_data          = array();
			if ( $get_all_fees_count > 0 ) {
				foreach ( $get_all_fees as $fees ) {
					$request_post_id                        = $fees->ID;
					$fee_title                              = __( get_the_title( $request_post_id ), 'woocommerce-conditional-product-fees-for-checkout' );
					$getFeesCost                            = __( get_post_meta( $request_post_id, 'fee_settings_product_cost', true ), 'woocommerce-conditional-product-fees-for-checkout' );
					$getFeesType                            = __( get_post_meta( $request_post_id, 'fee_settings_select_fee_type', true ), 'woocommerce-conditional-product-fees-for-checkout' );
					$wcpfc_tooltip_desc                     = __( get_post_meta( $request_post_id, 'fee_settings_tooltip_desc', true ), 'woocommerce-conditional-product-fees-for-checkout' );
					$getFeesStartDate                       = get_post_meta( $request_post_id, 'fee_settings_start_date', true );
					$getFeesEndDate                         = get_post_meta( $request_post_id, 'fee_settings_end_date', true );
					$getFeesTaxable                         = __( get_post_meta( $request_post_id, 'fee_settings_select_taxable', true ), 'woocommerce-conditional-product-fees-for-checkout' );
					$getFeesOptional                        = __( get_post_meta( $request_post_id, 'fee_settings_select_optional', true ), 'woocommerce-conditional-product-fees-for-checkout' );
					$getFeesOptionalType                    = __( get_post_meta( $request_post_id, 'fee_settings_optional_type', true ), 'woocommerce-conditional-product-fees-for-checkout' );
					$getFeesOptionalDetails                 = __( get_post_meta( $request_post_id, 'fee_settings_optional_description', true ), 'woocommerce-conditional-product-fees-for-checkout' );
					$default_optional_checked               = get_post_meta( $request_post_id, 'default_optional_checked', true );
					$first_order_for_user 					= get_post_meta( $request_post_id, 'first_order_for_user', true);
					$fee_settings_recurring					= get_post_meta( $request_post_id, 'fee_settings_recurring', true);
					$fee_show_on_checkout_only				= get_post_meta( $request_post_id, 'fee_show_on_checkout_only', true);
					$fees_on_cart_total						= get_post_meta( $request_post_id, 'fees_on_cart_total', true);
					$ds_time_from							= get_post_meta( $request_post_id, 'ds_time_from', true);
					$ds_time_to								= get_post_meta( $request_post_id, 'ds_time_to', true);
					$ds_select_day_of_week					= get_post_meta( $request_post_id, 'ds_select_day_of_week', true);
					$fee_revenue 							= get_post_meta( $request_post_id, '_wcpfc_fee_revenue', true) ? get_post_meta( $request_post_id, '_wcpfc_fee_revenue', true) : 0;
					$getFeesStatus                          = get_post_status( $request_post_id );
					$productFeesArray                       = get_post_meta( $request_post_id, 'product_fees_metabox', true );
					$getFeesPerQtyFlag                      = get_post_meta( $request_post_id, 'fee_chk_qty_price', true );
					$getFeesPerQty                          = get_post_meta( $request_post_id, 'fee_per_qty', true );
					$extraProductCost                       = get_post_meta( $request_post_id, 'extra_product_cost', true );
					$ap_rule_status                         = get_post_meta( $request_post_id, 'ap_rule_status', true );
					$cost_on_product_status                 = get_post_meta( $request_post_id, 'cost_on_product_status', true );
					$cost_on_product_weight_status          = get_post_meta( $request_post_id, 'cost_on_product_weight_status', true );
					$cost_on_product_subtotal_status        = get_post_meta( $request_post_id, 'cost_on_product_subtotal_status', true );
					$cost_on_category_status                = get_post_meta( $request_post_id, 'cost_on_category_status', true );
					$cost_on_category_weight_status         = get_post_meta( $request_post_id, 'cost_on_category_weight_status', true );
					$cost_on_category_subtotal_status       = get_post_meta( $request_post_id, 'cost_on_category_subtotal_status', true );
					$cost_on_total_cart_qty_status          = get_post_meta( $request_post_id, 'cost_on_total_cart_qty_status', true );
					$cost_on_total_cart_weight_status       = get_post_meta( $request_post_id, 'cost_on_total_cart_weight_status', true );
					$cost_on_total_cart_subtotal_status     = get_post_meta( $request_post_id, 'cost_on_total_cart_subtotal_status', true );
					$cost_on_shipping_class_subtotal_status = get_post_meta( $request_post_id, 'cost_on_shipping_class_subtotal_status', true );
					$sm_metabox_ap_product                  = get_post_meta( $request_post_id, 'sm_metabox_ap_product', true );
					$sm_metabox_ap_product_subtotal         = get_post_meta( $request_post_id, 'sm_metabox_ap_product_subtotal', true );
					$sm_metabox_ap_product_weight           = get_post_meta( $request_post_id, 'sm_metabox_ap_product_weight', true );
					$sm_metabox_ap_category                 = get_post_meta( $request_post_id, 'sm_metabox_ap_category', true );
					$sm_metabox_ap_category_subtotal        = get_post_meta( $request_post_id, 'sm_metabox_ap_category_subtotal', true );
					$sm_metabox_ap_category_weight          = get_post_meta( $request_post_id, 'sm_metabox_ap_category_weight', true );
					$sm_metabox_ap_total_cart_qty           = get_post_meta( $request_post_id, 'sm_metabox_ap_total_cart_qty', true );
					$sm_metabox_ap_total_cart_weight        = get_post_meta( $request_post_id, 'sm_metabox_ap_total_cart_weight', true );
					$sm_metabox_ap_total_cart_subtotal      = get_post_meta( $request_post_id, 'sm_metabox_ap_total_cart_subtotal', true );
					$sm_metabox_ap_shipping_class_subtotal  = get_post_meta( $request_post_id, 'sm_metabox_ap_shipping_class_subtotal', true );
					$cost_rule_match                        = get_post_meta( $request_post_id, 'cost_rule_match', true );
					$sm_metabox_customize                   = array();
					if ( ! empty( $productFeesArray ) ) {
						foreach ( $productFeesArray as $key => $val ) {
							if ( 'product' === $val['product_fees_conditions_condition'] || 'variableproduct' === $val['product_fees_conditions_condition'] || 'category' === $val['product_fees_conditions_condition'] || 'tag' === $val['product_fees_conditions_condition'] ) {
								$product_fees_conditions_values = $this->wcpfc_pro_fetch_slug( $val['product_fees_conditions_values'], $val['product_fees_conditions_condition'] );
								$sm_metabox_customize[ $key ]   = array(
									'product_fees_conditions_condition' => $val['product_fees_conditions_condition'],
									'product_fees_conditions_is'        => $val['product_fees_conditions_is'],
									'product_fees_conditions_values'    => $product_fees_conditions_values,
								);
							} else {
								$sm_metabox_customize[ $key ] = array(
									'product_fees_conditions_condition' => $val['product_fees_conditions_condition'],
									'product_fees_conditions_is'        => $val['product_fees_conditions_is'],
									'product_fees_conditions_values'    => $val['product_fees_conditions_values'],
								);
							}
						}
					}
					$sm_metabox_ap_product_customize = array();
					if ( ! empty( $sm_metabox_ap_product ) ) {
						foreach ( $sm_metabox_ap_product as $key => $val ) {
							$ap_fees_products_values                 = $this->wcpfc_pro_fetch_slug( $val['ap_fees_products'], 'cpp' );
							$sm_metabox_ap_product_customize[ $key ] = array(
								'ap_fees_products'         	=> $ap_fees_products_values,
								'ap_fees_ap_prd_min_qty'   	=> $val['ap_fees_ap_prd_min_qty'],
								'ap_fees_ap_prd_max_qty'   	=> $val['ap_fees_ap_prd_max_qty'],
								'ap_fees_ap_price_product' 	=> $val['ap_fees_ap_price_product'],
								'ap_fees_ap_per_product' 	=> isset($val['ap_fees_ap_per_product']) && !empty($val['ap_fees_ap_per_product']) && strpos($val['ap_fees_ap_price_product'], '%') ? $val['ap_fees_ap_per_product'] : 'no',
							);
						}
					}
					$sm_metabox_ap_product_subtotal_customize = array();
					if ( ! empty( $sm_metabox_ap_product_subtotal ) ) {
						foreach ( $sm_metabox_ap_product_subtotal as $key => $val ) {
							$ap_fees_product_subtotal_values                  = $this->wcpfc_pro_fetch_slug( $val['ap_fees_product_subtotal'], 'cpp' );
							$sm_metabox_ap_product_subtotal_customize[ $key ] = array(
								'ap_fees_product_subtotal'                 => $ap_fees_product_subtotal_values,
								'ap_fees_ap_product_subtotal_min_subtotal' => $val['ap_fees_ap_product_subtotal_min_subtotal'],
								'ap_fees_ap_product_subtotal_max_subtotal' => $val['ap_fees_ap_product_subtotal_max_subtotal'],
								'ap_fees_ap_price_product_subtotal'        => $val['ap_fees_ap_price_product_subtotal'],
							);
						}
					}
					$sm_metabox_ap_product_weight_customize = array();
					if ( ! empty( $sm_metabox_ap_product_weight ) ) {
						foreach ( $sm_metabox_ap_product_weight as $key => $val ) {
							$ap_fees_product_weight_values                  = $this->wcpfc_pro_fetch_slug( $val['ap_fees_product_weight'], 'cpp' );
							$sm_metabox_ap_product_weight_customize[ $key ] = array(
								'ap_fees_product_weight'            => $ap_fees_product_weight_values,
								'ap_fees_ap_product_weight_min_qty' => $val['ap_fees_ap_product_weight_min_qty'],
								'ap_fees_ap_product_weight_max_qty' => $val['ap_fees_ap_product_weight_max_qty'],
								'ap_fees_ap_price_product_weight'   => $val['ap_fees_ap_price_product_weight'],
							);
						}
					}
					$sm_metabox_ap_category_customize = array();
					if ( ! empty( $sm_metabox_ap_category ) ) {
						foreach ( $sm_metabox_ap_category as $key => $val ) {
							$ap_fees_category_values                  = $this->wcpfc_pro_fetch_slug( $val['ap_fees_categories'], 'cpc' );
							$sm_metabox_ap_category_customize[ $key ] = array(
								'ap_fees_categories'        => $ap_fees_category_values,
								'ap_fees_ap_cat_min_qty'    => $val['ap_fees_ap_cat_min_qty'],
								'ap_fees_ap_cat_max_qty'    => $val['ap_fees_ap_cat_max_qty'],
								'ap_fees_ap_price_category' => $val['ap_fees_ap_price_category'],
							);
						}
					}
					$sm_metabox_ap_category_subtotal_customize = array();
					if ( ! empty( $sm_metabox_ap_category_subtotal ) ) {
						foreach ( $sm_metabox_ap_category_subtotal as $key => $val ) {
							$ap_fees_category_subtotal_values                  = $this->wcpfc_pro_fetch_slug( $val['ap_fees_category_subtotal'], 'cpc' );
							$sm_metabox_ap_category_subtotal_customize[ $key ] = array(
								'ap_fees_category_subtotal'                 => $ap_fees_category_subtotal_values,
								'ap_fees_ap_category_subtotal_min_subtotal' => $val['ap_fees_ap_category_subtotal_min_subtotal'],
								'ap_fees_ap_category_subtotal_max_subtotal' => $val['ap_fees_ap_category_subtotal_max_subtotal'],
								'ap_fees_ap_price_category_subtotal'        => $val['ap_fees_ap_price_category_subtotal'],
							);
						}
					}
					$sm_metabox_ap_category_weight_customize = array();
					if ( ! empty( $sm_metabox_ap_category_weight ) ) {
						foreach ( $sm_metabox_ap_category_weight as $key => $val ) {
							$ap_fees_category_weight_values                  = $this->wcpfc_pro_fetch_slug( $val['ap_fees_categories_weight'], 'cpc' );
							$sm_metabox_ap_category_weight_customize[ $key ] = array(
								'ap_fees_categories_weight'          => $ap_fees_category_weight_values,
								'ap_fees_ap_category_weight_min_qty' => $val['ap_fees_ap_category_weight_min_qty'],
								'ap_fees_ap_category_weight_max_qty' => $val['ap_fees_ap_category_weight_max_qty'],
								'ap_fees_ap_price_category_weight'   => $val['ap_fees_ap_price_category_weight'],
							);
						}
					}
					$sm_metabox_ap_total_cart_qty_customize = array();
					if ( ! empty( $sm_metabox_ap_total_cart_qty ) ) {
						foreach ( $sm_metabox_ap_total_cart_qty as $key => $val ) {
							$ap_fees_total_cart_qty_values                  = $this->wcpfc_pro_fetch_slug( $val['ap_fees_total_cart_qty'], '' );
							$sm_metabox_ap_total_cart_qty_customize[ $key ] = array(
								'ap_fees_total_cart_qty'            => $ap_fees_total_cart_qty_values,
								'ap_fees_ap_total_cart_qty_min_qty' => $val['ap_fees_ap_total_cart_qty_min_qty'],
								'ap_fees_ap_total_cart_qty_max_qty' => $val['ap_fees_ap_total_cart_qty_max_qty'],
								'ap_fees_ap_price_total_cart_qty'   => $val['ap_fees_ap_price_total_cart_qty'],
							);
						}
					}
					$sm_metabox_ap_total_cart_weight_customize = array();
					if ( ! empty( $sm_metabox_ap_total_cart_weight ) ) {
						foreach ( $sm_metabox_ap_total_cart_weight as $key => $val ) {
							$ap_fees_total_cart_weight_values                  = $this->wcpfc_pro_fetch_slug( $val['ap_fees_total_cart_weight'], '' );
							$sm_metabox_ap_total_cart_weight_customize[ $key ] = array(
								'ap_fees_total_cart_weight'               => $ap_fees_total_cart_weight_values,
								'ap_fees_ap_total_cart_weight_min_weight' => $val['ap_fees_ap_total_cart_weight_min_weight'],
								'ap_fees_ap_total_cart_weight_max_weight' => $val['ap_fees_ap_total_cart_weight_max_weight'],
								'ap_fees_ap_price_total_cart_weight'      => $val['ap_fees_ap_price_total_cart_weight'],
							);
						}
					}
					$sm_metabox_ap_total_cart_subtotal_customize = array();
					if ( ! empty( $sm_metabox_ap_total_cart_subtotal ) ) {
						foreach ( $sm_metabox_ap_total_cart_subtotal as $key => $val ) {
							$ap_fees_total_cart_subtotal_values                  = $this->wcpfc_pro_fetch_slug( $val['ap_fees_total_cart_subtotal'], '' );
							$sm_metabox_ap_total_cart_subtotal_customize[ $key ] = array(
								'ap_fees_total_cart_subtotal'                 => $ap_fees_total_cart_subtotal_values,
								'ap_fees_ap_total_cart_subtotal_min_subtotal' => $val['ap_fees_ap_total_cart_subtotal_min_subtotal'],
								'ap_fees_ap_total_cart_subtotal_max_subtotal' => $val['ap_fees_ap_total_cart_subtotal_max_subtotal'],
								'ap_fees_ap_price_total_cart_subtotal'        => $val['ap_fees_ap_price_total_cart_subtotal'],
							);
						}
					}
					$sm_metabox_ap_shipping_class_subtotal_customize = array();
					if ( ! empty( $sm_metabox_ap_shipping_class_subtotal ) ) {
						foreach ( $sm_metabox_ap_shipping_class_subtotal as $key => $val ) {
							$ap_fees_shipping_class_subtotal_values                  = $this->wcpfc_pro_fetch_slug( $val['ap_fees_shipping_class_subtotals'], 'cpsc' );
							$sm_metabox_ap_shipping_class_subtotal_customize[ $key ] = array(
								'ap_fees_shipping_class_subtotals'                => $ap_fees_shipping_class_subtotal_values,
								'ap_fees_ap_shipping_class_subtotal_min_subtotal' => $val['ap_fees_ap_shipping_class_subtotal_min_subtotal'],
								'ap_fees_ap_shipping_class_subtotal_max_subtotal' => $val['ap_fees_ap_shipping_class_subtotal_max_subtotal'],
								'ap_fees_ap_price_shipping_class_subtotal'        => $val['ap_fees_ap_price_shipping_class_subtotal'],
							);
						}
					}
					$fees_data[ $request_post_id ] = array(
						'fee_title'                              => $fee_title,
						'fee_settings_product_cost'              => $getFeesCost,
						'fee_settings_select_fee_type'           => $getFeesType,
						'fee_settings_tooltip_desc'              => $wcpfc_tooltip_desc,
						'fee_settings_start_date'                => $getFeesStartDate,
						'fee_settings_end_date'                  => $getFeesEndDate,
						'fee_settings_select_taxable'            => $getFeesTaxable,
						'fee_settings_select_optional'           => $getFeesOptional,
                        'fee_settings_optional_type'             => $getFeesOptionalType,
                        'fee_settings_optional_description'      => $getFeesOptionalDetails,
						'default_optional_checked'				 => $default_optional_checked,
						'first_order_for_user' 				 	 => $first_order_for_user,
						'fee_settings_recurring'			 	 => $fee_settings_recurring,
						'fee_show_on_checkout_only'			 	 => $fee_show_on_checkout_only,
						'fees_on_cart_total'			 	 	 => $fees_on_cart_total,
						'ds_time_from'			 	 	 		 => $ds_time_from,
						'ds_time_to'			 	 	 		 => $ds_time_to,
						'ds_select_day_of_week'		 	 		 => $ds_select_day_of_week,
						'fee_revenue'						 	 => $fee_revenue,
						'status'                                 => $getFeesStatus,
						'product_fees_metabox'                   => $sm_metabox_customize,
						'fee_chk_qty_price'                      => $getFeesPerQtyFlag,
						'fee_per_qty'                            => $getFeesPerQty,
						'extra_product_cost'                     => $extraProductCost,
						'ap_rule_status'                         => $ap_rule_status,
						'cost_on_product_status'                 => $cost_on_product_status,
						'cost_on_product_weight_status'          => $cost_on_product_weight_status,
						'cost_on_product_subtotal_status'        => $cost_on_product_subtotal_status,
						'cost_on_category_status'                => $cost_on_category_status,
						'cost_on_category_weight_status'         => $cost_on_category_weight_status,
						'cost_on_category_subtotal_status'       => $cost_on_category_subtotal_status,
						'cost_on_total_cart_qty_status'          => $cost_on_total_cart_qty_status,
						'cost_on_total_cart_weight_status'       => $cost_on_total_cart_weight_status,
						'cost_on_total_cart_subtotal_status'     => $cost_on_total_cart_subtotal_status,
						'cost_on_shipping_class_subtotal_status' => $cost_on_shipping_class_subtotal_status,
						'sm_metabox_ap_product'                  => $sm_metabox_ap_product_customize,
						'sm_metabox_ap_product_subtotal'         => $sm_metabox_ap_product_subtotal_customize,
						'sm_metabox_ap_product_weight'           => $sm_metabox_ap_product_weight_customize,
						'sm_metabox_ap_category'                 => $sm_metabox_ap_category_customize,
						'sm_metabox_ap_category_subtotal'        => $sm_metabox_ap_category_subtotal_customize,
						'sm_metabox_ap_category_weight'          => $sm_metabox_ap_category_weight_customize,
						'sm_metabox_ap_total_cart_qty'           => $sm_metabox_ap_total_cart_qty_customize,
						'sm_metabox_ap_total_cart_weight'        => $sm_metabox_ap_total_cart_weight_customize,
						'sm_metabox_ap_total_cart_subtotal'      => $sm_metabox_ap_total_cart_subtotal_customize,
						'sm_metabox_ap_shipping_class_subtotal'  => $sm_metabox_ap_shipping_class_subtotal_customize,
						'cost_rule_match'                        => $cost_rule_match,
					);
				}
			}

            if( empty($cli_args ) ) {
                $wcpfc_export_action_nonce = filter_input( INPUT_POST, 'wcpfc_export_action_nonce', FILTER_SANITIZE_STRING );
                if ( ! wp_verify_nonce( $wcpfc_export_action_nonce, 'wcpfc_export_save_action_nonce' ) ) {
                    return;
                }
                ignore_user_abort( true );
                nocache_headers();
                header( 'Content-Type: application/json; charset=utf-8' );
                header( 'Content-Disposition: attachment; filename=wcpfc-settings-export-' . gmdate( 'm-d-Y' ) . '.json' );
                header( "Expires: 0" );
                echo wp_json_encode( $fees_data );
            } else {
                
                $file_name = 'wcpfc_cli_export_'.time().'.json';

                $path_data = wp_get_upload_dir();
                $save_path = $path_data['basedir'].'/wcpfc_cli/';
                $download_path = $path_data['baseurl'].'/wcpfc_cli/';

                //Create new directory for plugin JSON files store
                if( ! file_exists($save_path) ){
                    wp_mkdir_p($save_path);    
                }

                //Remove all previous files
                $files = glob("$save_path/*.json");
                foreach ($files as $csv_file) {
                    wp_delete_file($csv_file);
                }

                $json_data = wp_json_encode( $fees_data );

                //Save new data to JSON file
                // file_put_contents( $save_path.$file_name, $json_data );
                $wp_filesystem->put_contents( $save_path.$file_name, $json_data );

                return array( 'message' => esc_html__( 'Data has been Exported!', 'woocommerce-conditional-product-fees-for-checkout' ), 'download_path' => $download_path.$file_name );
            }
			exit;
		}
		if ( ! empty( $import_action ) || 'import_settings' === $import_action || ( !empty($cli_args) && 'import' === $cli_args['cli_type'] ) ) {
            if( empty($cli_args ) ) {
                $wcpfc_import_action_nonce = filter_input( INPUT_POST, 'wcpfc_import_action_nonce', FILTER_SANITIZE_STRING );
                if ( ! wp_verify_nonce( $wcpfc_import_action_nonce, 'wcpfc_import_action_nonce' ) ) {
                    return;
                }
                $file_import_file_args      = array(
                    'import_file' => array(
                        'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                        'flags'  => FILTER_FORCE_ARRAY,
                    ),
                );
                $attached_import_files__arr = filter_var_array( $_FILES, $file_import_file_args );
                $attached_import_files__arr_explode = explode( '.', $attached_import_files__arr['import_file']['name'] );
                $extension                          = end( $attached_import_files__arr_explode );
                if ( $extension !== 'json' ) {
                    wp_die( esc_html__( 'Please upload a valid .json file', 'woocommerce-conditional-product-fees-for-checkout' ) );
                }
                $import_file = $attached_import_files__arr['import_file']['tmp_name'];
                if ( empty( $import_file ) ) {
                    wp_die( esc_html__( 'Please upload a file to import', 'woocommerce-conditional-product-fees-for-checkout' ) );
                }
                $fees_data = $wp_filesystem->get_contents( $import_file );
            } else {
                $fees_data = file_get_contents( $cli_args['file'] );
            }
			if ( ! empty( $fees_data ) ) {
				$fees_data_decode = json_decode( $fees_data, true );
				foreach ( $fees_data_decode as $fees_id => $fees_val ) {
					$fee_post    = array(
						'post_title'  => $fees_val['fee_title'],
						'post_status' => $fees_val['status'],
						'post_type'   => self::wcpfc_post_type,
						'import_id'	  => $fees_id,
					);
					$fount_post = post_exists( $fees_val['fee_title'], '', '', self::wcpfc_post_type );
					if( $fount_post > 0 && !empty($fount_post) ){
						$fee_post['ID'] = $fount_post;
						$get_post_id = wp_update_post( $fee_post );
					} else {
						$get_post_id = wp_insert_post( $fee_post );
					}
					if ( '' !== $get_post_id && 0 !== $get_post_id ) {
						if ( $get_post_id > 0 ) {
							$sm_metabox_customize = array();
							if ( ! empty( $fees_val['product_fees_metabox'] ) ) {
								foreach ( $fees_val['product_fees_metabox'] as $key => $val ) {
									if ( 'product' === $val['product_fees_conditions_condition'] || 'variableproduct' === $val['product_fees_conditions_condition'] || 'category' === $val['product_fees_conditions_condition'] || 'tag' === $val['product_fees_conditions_condition'] ) {
										$product_fees_conditions_values = $this->wcpfc_pro_fetch_id( $val['product_fees_conditions_values'], $val['product_fees_conditions_condition'] );
										$sm_metabox_customize[ $key ]   = array(
											'product_fees_conditions_condition' => $val['product_fees_conditions_condition'],
											'product_fees_conditions_is'        => $val['product_fees_conditions_is'],
											'product_fees_conditions_values'    => $product_fees_conditions_values,
										);
									} else {
										$sm_metabox_customize[ $key ] = array(
											'product_fees_conditions_condition' => $val['product_fees_conditions_condition'],
											'product_fees_conditions_is'        => $val['product_fees_conditions_is'],
											'product_fees_conditions_values'    => $val['product_fees_conditions_values'],
										);
									}
								}
							}
							$sm_metabox_product_customize = array();
							if ( ! empty( $fees_val['sm_metabox_ap_product'] ) ) {
								foreach ( $fees_val['sm_metabox_ap_product'] as $key => $val ) {
									$ap_fees_products_values              = $this->wcpfc_pro_fetch_id( $val['ap_fees_products'], 'cpp' );
									$sm_metabox_product_customize[ $key ] = array(
										'ap_fees_products'         	=> $ap_fees_products_values,
										'ap_fees_ap_prd_min_qty'   	=> $val['ap_fees_ap_prd_min_qty'],
										'ap_fees_ap_prd_max_qty'   	=> $val['ap_fees_ap_prd_max_qty'],
										'ap_fees_ap_price_product' 	=> $val['ap_fees_ap_price_product'],
										'ap_fees_ap_per_product' 	=> isset($val['ap_fees_ap_per_product']) && !empty($val['ap_fees_ap_per_product']) && strpos($val['ap_fees_ap_price_product'], '%') ? $val['ap_fees_ap_per_product'] : 'no',
									);
								}
							}
							$sm_metabox_ap_product_subtotal_customize = array();
							if ( ! empty( $fees_val['sm_metabox_ap_product_subtotal'] ) ) {
								foreach ( $fees_val['sm_metabox_ap_product_subtotal'] as $key => $val ) {
									$ap_fees_products_subtotal_values                 = $this->wcpfc_pro_fetch_id( $val['ap_fees_product_subtotal'], 'cpp' );
									$sm_metabox_ap_product_subtotal_customize[ $key ] = array(
										'ap_fees_product_subtotal'                 => $ap_fees_products_subtotal_values,
										'ap_fees_ap_product_subtotal_min_subtotal' => $val['ap_fees_ap_product_subtotal_min_subtotal'],
										'ap_fees_ap_product_subtotal_max_subtotal' => $val['ap_fees_ap_product_subtotal_max_subtotal'],
										'ap_fees_ap_price_product_subtotal'        => $val['ap_fees_ap_price_product_subtotal'],
									);
								}
							}
							$sm_metabox_ap_product_weight_customize = array();
							if ( ! empty( $fees_val['sm_metabox_ap_product_weight'] ) ) {
								foreach ( $fees_val['sm_metabox_ap_product_weight'] as $key => $val ) {
									$ap_fees_products_weight_values                 = $this->wcpfc_pro_fetch_id( $val['ap_fees_product_weight'], 'cpp' );
									$sm_metabox_ap_product_weight_customize[ $key ] = array(
										'ap_fees_product_weight'            => $ap_fees_products_weight_values,
										'ap_fees_ap_product_weight_min_qty' => $val['ap_fees_ap_product_weight_min_qty'],
										'ap_fees_ap_product_weight_max_qty' => $val['ap_fees_ap_product_weight_max_qty'],
										'ap_fees_ap_price_product_weight'   => $val['ap_fees_ap_price_product_weight'],
									);
								}
							}
							$sm_metabox_ap_category_customize = array();
							if ( ! empty( $fees_val['sm_metabox_ap_category'] ) ) {
								foreach ( $fees_val['sm_metabox_ap_category'] as $key => $val ) {
									$ap_fees_category_values                  = $this->wcpfc_pro_fetch_id( $val['ap_fees_categories'], 'cpc' );
									$sm_metabox_ap_category_customize[ $key ] = array(
										'ap_fees_categories'        => $ap_fees_category_values,
										'ap_fees_ap_cat_min_qty'    => $val['ap_fees_ap_cat_min_qty'],
										'ap_fees_ap_cat_max_qty'    => $val['ap_fees_ap_cat_max_qty'],
										'ap_fees_ap_price_category' => $val['ap_fees_ap_price_category'],
									);
								}
							}
							$sm_metabox_ap_category_subtotal_customize = array();
							if ( ! empty( $fees_val['sm_metabox_ap_category_subtotal'] ) ) {
								foreach ( $fees_val['sm_metabox_ap_category_subtotal'] as $key => $val ) {
									$ap_fees_ap_category_subtotal_values               = $this->wcpfc_pro_fetch_id( $val['ap_fees_category_subtotal'], 'cpc' );
									$sm_metabox_ap_category_subtotal_customize[ $key ] = array(
										'ap_fees_category_subtotal'                 => $ap_fees_ap_category_subtotal_values,
										'ap_fees_ap_category_subtotal_min_subtotal' => $val['ap_fees_ap_category_subtotal_min_subtotal'],
										'ap_fees_ap_category_subtotal_max_subtotal' => $val['ap_fees_ap_category_subtotal_max_subtotal'],
										'ap_fees_ap_price_category_subtotal'        => $val['ap_fees_ap_price_category_subtotal'],
									);
								}
							}
							$sm_metabox_ap_category_weight_customize = array();
							if ( ! empty( $fees_val['sm_metabox_ap_category_weight'] ) ) {
								foreach ( $fees_val['sm_metabox_ap_category_weight'] as $key => $val ) {
									$ap_fees_ap_category_weight_values               = $this->wcpfc_pro_fetch_id( $val['ap_fees_categories_weight'], 'cpc' );
									$sm_metabox_ap_category_weight_customize[ $key ] = array(
										'ap_fees_categories_weight'          => $ap_fees_ap_category_weight_values,
										'ap_fees_ap_category_weight_min_qty' => $val['ap_fees_ap_category_weight_min_qty'],
										'ap_fees_ap_category_weight_max_qty' => $val['ap_fees_ap_category_weight_max_qty'],
										'ap_fees_ap_price_category_weight'   => $val['ap_fees_ap_price_category_weight'],
									);
								}
							}
							$sm_metabox_ap_total_cart_qty_customize = array();
							if ( ! empty( $fees_val['sm_metabox_ap_total_cart_qty'] ) ) {
								foreach ( $fees_val['sm_metabox_ap_total_cart_qty'] as $key => $val ) {
									$ap_fees_ap_total_cart_qty_values               = $this->wcpfc_pro_fetch_id( $val['ap_fees_total_cart_qty'], '' );
									$sm_metabox_ap_total_cart_qty_customize[ $key ] = array(
										'ap_fees_total_cart_qty'            => $ap_fees_ap_total_cart_qty_values,
										'ap_fees_ap_total_cart_qty_min_qty' => $val['ap_fees_ap_total_cart_qty_min_qty'],
										'ap_fees_ap_total_cart_qty_max_qty' => $val['ap_fees_ap_total_cart_qty_max_qty'],
										'ap_fees_ap_price_total_cart_qty'   => $val['ap_fees_ap_price_total_cart_qty'],
									);
								}
							}
							$sm_metabox_ap_total_cart_weight_customize = array();
							if ( ! empty( $fees_val['sm_metabox_ap_total_cart_weight'] ) ) {
								foreach ( $fees_val['sm_metabox_ap_total_cart_weight'] as $key => $val ) {
									$ap_fees_ap_total_cart_weight_values               = $this->wcpfc_pro_fetch_id( $val['ap_fees_total_cart_weight'], '' );
									$sm_metabox_ap_total_cart_weight_customize[ $key ] = array(
										'ap_fees_total_cart_weight'               => $ap_fees_ap_total_cart_weight_values,
										'ap_fees_ap_total_cart_weight_min_weight' => $val['ap_fees_ap_total_cart_weight_min_weight'],
										'ap_fees_ap_total_cart_weight_max_weight' => $val['ap_fees_ap_total_cart_weight_max_weight'],
										'ap_fees_ap_price_total_cart_weight'      => $val['ap_fees_ap_price_total_cart_weight'],
									);
								}
							}
							$sm_metabox_ap_total_cart_subtotal_customize = array();
							if ( ! empty( $fees_val['sm_metabox_ap_total_cart_subtotal'] ) ) {
								foreach ( $fees_val['sm_metabox_ap_total_cart_subtotal'] as $key => $val ) {
									$ap_fees_ap_total_cart_subtotal_values               = $this->wcpfc_pro_fetch_id( $val['ap_fees_total_cart_subtotal'], '' );
									$sm_metabox_ap_total_cart_subtotal_customize[ $key ] = array(
										'ap_fees_total_cart_subtotal'                 => $ap_fees_ap_total_cart_subtotal_values,
										'ap_fees_ap_total_cart_subtotal_min_subtotal' => $val['ap_fees_ap_total_cart_subtotal_min_subtotal'],
										'ap_fees_ap_total_cart_subtotal_max_subtotal' => $val['ap_fees_ap_total_cart_subtotal_max_subtotal'],
										'ap_fees_ap_price_total_cart_subtotal'        => $val['ap_fees_ap_price_total_cart_subtotal'],
									);
								}
							}
							$sm_metabox_ap_shipping_class_subtotal_customize = array();
							if ( ! empty( $fees_val['sm_metabox_ap_shipping_class_subtotal'] ) ) {
								foreach ( $fees_val['sm_metabox_ap_shipping_class_subtotal'] as $key => $val ) {
									$ap_fees_ap_shipping_class_subtotal_values               = $this->wcpfc_pro_fetch_id( $val['ap_fees_shipping_class_subtotals'], 'cpsc' );
									$sm_metabox_ap_shipping_class_subtotal_customize[ $key ] = array(
										'ap_fees_shipping_class_subtotals'                => $ap_fees_ap_shipping_class_subtotal_values,
										'ap_fees_ap_shipping_class_subtotal_min_subtotal' => $val['ap_fees_ap_shipping_class_subtotal_min_subtotal'],
										'ap_fees_ap_shipping_class_subtotal_max_subtotal' => $val['ap_fees_ap_shipping_class_subtotal_max_subtotal'],
										'ap_fees_ap_price_shipping_class_subtotal'        => $val['ap_fees_ap_price_shipping_class_subtotal'],
									);
								}
							}
							update_post_meta( $get_post_id, 'fee_settings_product_cost', $fees_val['fee_settings_product_cost'] );
							update_post_meta( $get_post_id, 'fee_settings_select_fee_type', $fees_val['fee_settings_select_fee_type'] );
							update_post_meta( $get_post_id, 'fee_settings_tooltip_desc', $fees_val['fee_settings_tooltip_desc'] );
							update_post_meta( $get_post_id, 'fee_settings_start_date', $fees_val['fee_settings_start_date'] );
							update_post_meta( $get_post_id, 'fee_settings_end_date', $fees_val['fee_settings_end_date'] );
							update_post_meta( $get_post_id, 'fee_settings_select_taxable', $fees_val['fee_settings_select_taxable'] );
							update_post_meta( $get_post_id, 'fee_settings_select_optional', $fees_val['fee_settings_select_optional'] );
							update_post_meta( $get_post_id, 'fee_settings_optional_type', $fees_val['fee_settings_optional_type'] );
							update_post_meta( $get_post_id, 'fee_settings_optional_description', $fees_val['fee_settings_optional_description'] );
							update_post_meta( $get_post_id, 'default_optional_checked', $fees_val['default_optional_checked'] );
							update_post_meta( $get_post_id, 'first_order_for_user', $fees_val['first_order_for_user'] );
							update_post_meta( $get_post_id, 'fee_settings_recurring', $fees_val['fee_settings_recurring'] );
							update_post_meta( $get_post_id, 'fee_show_on_checkout_only', $fees_val['fee_show_on_checkout_only'] );
							update_post_meta( $get_post_id, 'fees_on_cart_total', $fees_val['fees_on_cart_total'] );
							update_post_meta( $get_post_id, 'ds_time_from', $fees_val['ds_time_from'] );
							update_post_meta( $get_post_id, 'ds_time_to', $fees_val['ds_time_to'] );
							update_post_meta( $get_post_id, 'ds_select_day_of_week', $fees_val['ds_select_day_of_week'] );
							update_post_meta( $get_post_id, '_wcpfc_fee_revenue', $fees_val['fee_revenue'] );
							update_post_meta( $get_post_id, 'fee_settings_status', $fees_val['status'] );
							update_post_meta( $get_post_id, 'product_fees_metabox', $sm_metabox_customize );
							update_post_meta( $get_post_id, 'fee_chk_qty_price', $fees_val['fee_chk_qty_price'] );
							update_post_meta( $get_post_id, 'fee_per_qty', $fees_val['fee_per_qty'] );
							update_post_meta( $get_post_id, 'extra_product_cost', $fees_val['extra_product_cost'] );
							update_post_meta( $get_post_id, 'ap_rule_status', $fees_val['ap_rule_status'] );
							update_post_meta( $get_post_id, 'cost_on_product_status', $fees_val['cost_on_product_status'] );
							update_post_meta( $get_post_id, 'cost_on_product_weight_status', $fees_val['cost_on_product_weight_status'] );
							update_post_meta( $get_post_id, 'cost_on_product_subtotal_status', $fees_val['cost_on_product_subtotal_status'] );
							update_post_meta( $get_post_id, 'cost_on_category_status', $fees_val['cost_on_category_status'] );
							update_post_meta( $get_post_id, 'cost_on_category_weight_status', $fees_val['cost_on_category_weight_status'] );
							update_post_meta( $get_post_id, 'cost_on_category_subtotal_status', $fees_val['cost_on_category_subtotal_status'] );
							update_post_meta( $get_post_id, 'cost_on_total_cart_qty_status', $fees_val['cost_on_total_cart_qty_status'] );
							update_post_meta( $get_post_id, 'cost_on_total_cart_weight_status', $fees_val['cost_on_total_cart_weight_status'] );
							update_post_meta( $get_post_id, 'cost_on_total_cart_subtotal_status', $fees_val['cost_on_total_cart_subtotal_status'] );
							update_post_meta( $get_post_id, 'cost_on_shipping_class_subtotal_status', $fees_val['cost_on_shipping_class_subtotal_status'] );
							update_post_meta( $get_post_id, 'sm_metabox_ap_product', $sm_metabox_product_customize );
							update_post_meta( $get_post_id, 'sm_metabox_ap_product_subtotal', $sm_metabox_ap_product_subtotal_customize );
							update_post_meta( $get_post_id, 'sm_metabox_ap_product_weight', $sm_metabox_ap_product_weight_customize );
							update_post_meta( $get_post_id, 'sm_metabox_ap_category', $sm_metabox_ap_category_customize );
							update_post_meta( $get_post_id, 'sm_metabox_ap_category_subtotal', $sm_metabox_ap_category_subtotal_customize );
							update_post_meta( $get_post_id, 'sm_metabox_ap_category_weight', $sm_metabox_ap_category_weight_customize );
							update_post_meta( $get_post_id, 'sm_metabox_ap_total_cart_qty', $sm_metabox_ap_total_cart_qty_customize );
							update_post_meta( $get_post_id, 'sm_metabox_ap_total_cart_weight', $sm_metabox_ap_total_cart_weight_customize );
							update_post_meta( $get_post_id, 'sm_metabox_ap_total_cart_subtotal', $sm_metabox_ap_total_cart_subtotal_customize );
							update_post_meta( $get_post_id, 'sm_metabox_ap_shipping_class_subtotal', $sm_metabox_ap_shipping_class_subtotal_customize );
							update_post_meta( $get_post_id, 'cost_rule_match', $fees_val['cost_rule_match'] );
						}
					}
				}
			}
            if( empty($cli_args ) ) {
                wp_safe_redirect( add_query_arg( array(
                    'page'   => 'wcpfc-pro-import-export',
                    'status' => 'success',
                ), admin_url( 'admin.php' ) ) );
                exit;
            } else {
                return esc_html__( 'Data has been Imported!', 'woocommerce-conditional-product-fees-for-checkout' );
            }
		}
	}
	/**
	 * Plugins URL
	 *
	 * @since     3.1
	 */
	public function wcpfc_pro_plugins_url( $id, $page, $tab, $action, $nonce ) {
		$query_args = array();
		if ( '' !== $page ) {
			$query_args['page'] = $page;
		}
		if ( '' !== $tab ) {
			$query_args['tab'] = $tab;
		}
		if ( '' !== $action ) {
			$query_args['action'] = $action;
		}
		if ( '' !== $id ) {
			$query_args['id'] = $id;
		}
		if ( '' !== $nonce ) {
			$query_args['_wpnonce'] = wp_create_nonce( 'wcpfcnonce' );
		}
		return esc_url( add_query_arg( $query_args, admin_url( 'admin.php' ) ) );
	}
	/**
	 * Create a menu for plugin.
	 *
	 * @param string $current current page.
	 *
	 * @since     3.1
	 */
	public function wcpfc_pro_menus( $current = 'wcpfc-pro-list' ) {
		$wcpfc_action  = filter_input( INPUT_GET, 'action', FILTER_SANITIZE_STRING );
		$wcpfc_wpnonce = filter_input( INPUT_GET, '_wpnonce', FILTER_SANITIZE_STRING );
		$wpfp_menus = array(
			'main_menu' => array(
				'pro_menu'  => array(
					'wcpfc-pro-dashboard' => array(
						'menu_title' => __( 'Dashboard', 'woocommerce-conditional-product-fees-for-checkout' ),
						'menu_slug'  => 'wcpfc-pro-dashboard',
						'menu_url'   => $this->wcpfc_pro_plugins_url( '', 'wcpfc-pro-dashboard', '', '', '' ),
					),
					'wcpfc-pro-list'          => array(
						'menu_title' => __( 'Manage Product Fees', 'woocommerce-conditional-product-fees-for-checkout' ),
						'menu_slug'  => 'wcpfc-pro-list',
						'menu_url'   => $this->wcpfc_pro_plugins_url( '', 'wcpfc-pro-list', '', '', '' ),
					),
					'wcpfc-pro-import-export' => array(
						'menu_title' => __( 'Import / Export', 'woocommerce-conditional-product-fees-for-checkout' ),
						'menu_slug'  => 'wcpfc-pro-import-export',
						'menu_url'   => $this->wcpfc_pro_plugins_url( '', 'wcpfc-pro-import-export', '', '', '' ),
					),
					'wcpfc-pro-get-started'   => array(
						'menu_title' => __( 'About Plugin', 'woocommerce-conditional-product-fees-for-checkout' ),
						'menu_slug'  => 'wcpfc-pro-get-started',
						'menu_url'   => $this->wcpfc_pro_plugins_url( '', 'wcpfc-pro-get-started', '', '', '' ),
						'sub_menu'   => array(
							'wcpfc-pro-get-started' => array(
								'menu_title' => __( 'Getting Started', 'woocommerce-conditional-product-fees-for-checkout' ),
								'menu_slug'  => 'wcpfc-pro-get-started',
								'menu_url'   => $this->wcpfc_pro_plugins_url( '', 'wcpfc-pro-get-started', '', '', '' ),
							),
							'wcpfc-pro-information' => array(
								'menu_title' => __( 'Quick info', 'woocommerce-conditional-product-fees-for-checkout' ),
								'menu_slug'  => 'wcpfc-pro-information',
								'menu_url'   => $this->wcpfc_pro_plugins_url( '', 'wcpfc-pro-information', '', '', '' ),
							),
						),
					),
					'dotstore'                => array(
						'menu_title' => __( 'Dotstore', 'woocommerce-conditional-product-fees-for-checkout' ),
						'menu_slug'  => 'dotstore',
						'menu_url'   => 'javascript:void(0)',
						'sub_menu'   => array(
							'woocommerce-plugins' => array(
								'menu_title' => __( 'WooCommerce Plugins', 'woocommerce-conditional-product-fees-for-checkout' ),
								'menu_slug'  => 'woocommerce-plugins',
								'menu_url'   => esc_url( 'https://www.thedotstore.com/woocommerce-plugins/' ),
							),
							'wordpress-plugins'   => array(
								'menu_title' => __( 'Wordpress Plugins', 'woocommerce-conditional-product-fees-for-checkout' ),
								'menu_slug'  => 'wordpress-plugins',
								'menu_url'   => esc_url( 'https://www.thedotstore.com/wordpress-plugins/' ),
							),
							'contact-support'     => array(
								'menu_title' => __( 'Contact Support', 'woocommerce-conditional-product-fees-for-checkout' ),
								'menu_slug'  => 'contact-support',
								'menu_url'   => esc_url( 'https://www.thedotstore.com/support/' ),
							),
						),
					),
				),
				'free_menu' => array(
					'wcpfc-pro-list'        => array(
						'menu_title' => __( 'Manage Product Fees', 'woocommerce-conditional-product-fees-for-checkout' ),
						'menu_slug'  => 'wcpfc-pro-list',
						'menu_url'   => $this->wcpfc_pro_plugins_url( '', 'wcpfc-pro-list', '', '', '' ),
					),
					'wcpfc-pro-get-started' => array(
						'menu_title' => __( 'About Plugin', 'woocommerce-conditional-product-fees-for-checkout' ),
						'menu_slug'  => 'wcpfc-pro-get-started',
						'menu_url'   => $this->wcpfc_pro_plugins_url( '', 'wcpfc-pro-get-started', '', '', '' ),
						'sub_menu'   => array(
							'wcpfc-pro-get-started' => array(
								'menu_title' => __( 'Getting Started', 'woocommerce-conditional-product-fees-for-checkout' ),
								'menu_slug'  => 'wcpfc-pro-get-started',
								'menu_url'   => $this->wcpfc_pro_plugins_url( '', 'wcpfc-pro-get-started', '', '', '' ),
							),
							'wcpfc-pro-information' => array(
								'menu_title' => __( 'Quick info', 'woocommerce-conditional-product-fees-for-checkout' ),
								'menu_slug'  => 'wcpfc-pro-information',
								'menu_url'   => $this->wcpfc_pro_plugins_url( '', 'wcpfc-pro-information', '', '', '' ),
							),
						),
					),
					'wcpfc-premium'         => array(
						'menu_title' => __( 'Premium Version', 'woocommerce-conditional-product-fees-for-checkout' ),
						'menu_slug'  => 'wcpfc-premium',
						'menu_url'   => $this->wcpfc_pro_plugins_url( '', 'wcpfc-premium', '', '', '' ),
					),
					'dotstore'              => array(
						'menu_title' => __( 'Dotstore', 'woocommerce-conditional-product-fees-for-checkout' ),
						'menu_slug'  => 'dotstore',
						'menu_url'   => 'javascript:void(0)',
						'sub_menu'   => array(
							'woocommerce-plugins' => array(
								'menu_title' => __( 'WooCommerce Plugins', 'woocommerce-conditional-product-fees-for-checkout' ),
								'menu_slug'  => 'woocommerce-plugins',
								'menu_url'   => esc_url( 'https://www.thedotstore.com/woocommerce-plugins/' ),
							),
							'wordpress-plugins'   => array(
								'menu_title' => __( 'Wordpress Plugins', 'woocommerce-conditional-product-fees-for-checkout' ),
								'menu_slug'  => 'wordpress-plugins',
								'menu_url'   => esc_url( 'https://www.thedotstore.com/wordpress-plugins/' ),
							),
							'contact-support'     => array(
								'menu_title' => __( 'Contact Support', 'woocommerce-conditional-product-fees-for-checkout' ),
								'menu_slug'  => 'contact-support',
								'menu_url'   => esc_url( 'https://www.thedotstore.com/support/' ),
							),
						),
					),
				),
			),
		);
		?>
		<div class="dots-menu-main">
			<nav>
				<ul>
					<?php
					$main_current = $current;
					$sub_current  = $current;
					foreach ( $wpfp_menus['main_menu'] as $main_menu_slug => $main_wpfp_menu ) {
						if ( wcpffc_fs()->is__premium_only() ) {
							if ( wcpffc_fs()->can_use_premium_code() ) {
								if ( 'pro_menu' === $main_menu_slug ) {
									foreach ( $main_wpfp_menu as $menu_slug => $wpfp_menu ) {
										if ( 'wcpfc-pro-information' === $main_current ) {
											$main_current = 'wcpfc-pro-get-started';
										}
										$class = ( $menu_slug === $main_current ) ? 'active' : '';
										?>
										<li>
											<a class="dotstore_plugin <?php echo esc_attr( $class ); ?>"
											   href="<?php echo esc_url( $wpfp_menu['menu_url'] ); ?>">
												<?php esc_html_e( $wpfp_menu['menu_title'], 'woocommerce-conditional-product-fees-for-checkout' ); ?>
											</a>
											<?php if ( isset( $wpfp_menu['sub_menu'] ) && ! empty( $wpfp_menu['sub_menu'] ) ) { ?>
												<ul class="sub-menu">
													<?php
													foreach ( $wpfp_menu['sub_menu'] as $sub_menu_slug => $wpfp_sub_menu ) {
														$sub_class = ( $sub_menu_slug === $sub_current ) ? 'active' : '';
														?>

														<li>
															<a class="dotstore_plugin <?php echo esc_attr( $sub_class ); ?>"
															   href="<?php echo esc_url( $wpfp_sub_menu['menu_url'] ); ?>">
																<?php esc_html_e( $wpfp_sub_menu['menu_title'], 'woocommerce-conditional-product-fees-for-checkout' ); ?>
															</a>
														</li>
													<?php } ?>
												</ul>
											<?php } ?>
										</li>
										<?php
									}
								}
							} else {
								if ( 'free_menu' === $main_menu_slug ) {
									foreach ( $main_wpfp_menu as $menu_slug => $wpfp_menu ) {
										if ( 'wcpfc-pro-information' === $main_current ) {
											$main_current = 'wcpfc-pro-get-started';
										}
										$class = ( $menu_slug === $main_current ) ? 'active' : '';
										?>
										<li>
											<a class="dotstore_plugin <?php echo esc_attr( $class ); ?>"
											   href="<?php echo esc_url( $wpfp_menu['menu_url'] ); ?>">
												<?php esc_html_e( $wpfp_menu['menu_title'], 'woocommerce-conditional-product-fees-for-checkout' ); ?>
											</a>
											<?php if ( isset( $wpfp_menu['sub_menu'] ) && ! empty( $wpfp_menu['sub_menu'] ) ) { ?>
												<ul class="sub-menu">
													<?php
													foreach ( $wpfp_menu['sub_menu'] as $sub_menu_slug => $wpfp_sub_menu ) {
														$sub_class = ( $sub_menu_slug === $sub_current ) ? 'active' : '';
														?>

														<li>
															<a class="dotstore_plugin <?php echo esc_attr( $sub_class ); ?>"
															   href="<?php echo esc_url( $wpfp_sub_menu['menu_url'] ); ?>">
																<?php esc_html_e( $wpfp_sub_menu['menu_title'], 'woocommerce-conditional-product-fees-for-checkout' ); ?>
															</a>
														</li>
													<?php } ?>
												</ul>
											<?php } ?>
										</li>
										<?php
									}
								}
							}
						} else {
							if ( 'free_menu' === $main_menu_slug ) {
								foreach ( $main_wpfp_menu as $menu_slug => $wpfp_menu ) {
									if ( 'wcpfc-pro-information' === $main_current ) {
										$main_current = 'wcpfc-pro-get-started';
									}
									$class = ( $menu_slug === $main_current ) ? 'active' : '';
									?>
									<li>
										<a class="dotstore_plugin <?php echo esc_attr( $class ); ?>"
										   href="<?php echo esc_url( $wpfp_menu['menu_url'] ); ?>">
											<?php esc_html_e( $wpfp_menu['menu_title'], 'woocommerce-conditional-product-fees-for-checkout' ); ?>
										</a>
										<?php if ( isset( $wpfp_menu['sub_menu'] ) && ! empty( $wpfp_menu['sub_menu'] ) ) { ?>
											<ul class="sub-menu">
												<?php
												foreach ( $wpfp_menu['sub_menu'] as $sub_menu_slug => $wpfp_sub_menu ) {
													$sub_class = ( $sub_menu_slug === $sub_current ) ? 'active' : '';
													?>

													<li>
														<a class="dotstore_plugin <?php echo esc_attr( $sub_class ); ?>"
														   href="<?php echo esc_url( $wpfp_sub_menu['menu_url'] ); ?>">
															<?php esc_html_e( $wpfp_sub_menu['menu_title'], 'woocommerce-conditional-product-fees-for-checkout' ); ?>
														</a>
													</li>
												<?php } ?>
											</ul>
										<?php } ?>
									</li>
									<?php
								}
							}
						}
					}
					?>
				</ul>
			</nav>
		</div>
		<?php
	}
	
	/**
	 * One time migration process for old fees merge
	 *
	 * @param string $current current page.
	 *
	 * @since 3.1
	 */
	public function wcpfc_migration_old_fee__premium_only(){

		global $sitepress;
		check_ajax_referer( 'dsm_nonce', 'nonce' );
        $default_lang = $this->wcpfc_pro_get_default_langugae_with_sitpress();
		
		$offset = isset($_POST['offset']) && !empty($_POST['offset']) ? intval($_POST['offset']) : 0;

		$filter_arr = array(
			"limit" => -1,
			"orderby" => "date",
			"return" => "ids",
			"status" => array('wc-processing', 'wc-completed')
		);
		$order_arr = wc_get_orders( $filter_arr );
		
		$order_chuck = array_chunk($order_arr,20);
		$total_chunk = count($order_chuck);
		$orders = $order_chuck[$offset];

		$old_fee_amount = isset($_POST['total_revenue']) && !empty($_POST['total_revenue']) ? floatval($_POST['total_revenue'] ) : 0;
		if( $old_fee_amount === false ){
			$total_revenue = 0;
		} else {
			$total_revenue += $old_fee_amount;
		}

		$fee_array = array();
		if( !empty($orders) && $total_chunk >= $offset ){
			foreach( $orders as $order_id ){
				$order = wc_get_order($order_id);
				$order_fees = $order->get_meta('_wcpfc_fee_summary');
				if( !empty($order_fees) ){
					foreach( $order_fees as $order_fee ){
						$fee_revenue = 0;
						if ( ! empty( $sitepress ) ) {
							$fee_id = apply_filters( 'wpml_object_id', $order_fee->id, 'product', true, $default_lang );
						} else {
							$fee_id = $order_fee->id;
						}
						$fee_id = ( !empty($fee_id) ) ? $fee_id : 0;
						if( $fee_id > 0 ){
							$fee_amount = ( !empty($order_fee->total) && $order_fee->total> 0 ) ? $order_fee->total : 0;
							if( !empty($order_fee->taxable) && $order_fee->taxable ){
								$fee_amount += ($order_fee->tax > 0) ? $order_fee->tax : 0;
							}
							$fee_revenue += $fee_amount;
							if( $fee_revenue > 0 && array_key_exists($fee_id, $fee_array) ){
								$fee_array[$fee_id] += $fee_revenue;
							} else {
								$fee_array[$fee_id] = $fee_revenue;
							}
						}
					}
				} else {
					if( !empty($order->get_fees()) ){
						foreach ($order->get_fees() as $fee_id => $fee) {
							$fee_revenue = 0;
							$fee_post = get_page_by_title( $fee['name'], OBJECT, 'wc_conditional_fee'); // phpcs:ignore
							$fee_id = !empty($fee_post) ? $fee_post->ID : 0;
							if ( ! empty( $sitepress ) ) {
								$fee_id = apply_filters( 'wpml_object_id', $fee_id, 'product', true, $default_lang );
							}
							//$fee_id 0 will consider as other custom fees.
							if( $fee['line_total'] > 0 ){
								$fee_revenue += $fee['line_total'];
							}
							if( $fee['line_tax'] > 0 ){
								$fee_revenue += $fee['line_tax'];
							}
							
							if( $fee_revenue >= 0 && array_key_exists($fee_id, $fee_array) ){
								$fee_array[$fee_id] += $fee_revenue;
							} else {
								$fee_array[$fee_id] = $fee_revenue;
							}
						}
					}
				}
			}
			foreach ($fee_array as $list_of_fee_total ) {
				$total_revenue += $list_of_fee_total;
			}
			update_option('total_old_revenue_amount', $total_revenue, false);
			$offset++;
		} else {
			
			set_transient('get_total_revenue', $total_revenue, 15 * MINUTE_IN_SECONDS);
			update_option('total_old_revenue_flag', true, true);
			update_option('total_old_revenue_flag_date', gmdate("Y-m-d"), true);
			wp_send_json( array( 'recusrsive' => false, 'total_revenue' => $total_revenue, 'fee_array' => $fee_array ) );
		}
		wp_send_json( array( 'recusrsive' => true, 'offset' => $offset, 'total_chunk' => $total_chunk, 'fee_array' => $fee_array, 'total_revenue' => $total_revenue ) );
	}
    /**
	 * Display message in admin side
	 *
	 * @param string $message
	 * @param string $tab
	 *
	 * @return bool
	 * @since 1.0.0
	 *
	 */
	public function wcpfc_updated_message( $message, $validation_msg ) {
		if ( empty( $message ) ) {
			return false;
		}
    
        if ( 'created' === $message ) {
            $updated_message = esc_html__( "Fee rule has been created.", 'woocommerce-conditional-product-fees-for-checkout' );
        } elseif ( 'saved' === $message ) {
            $updated_message = esc_html__( "Fee rule has been updated.", 'woocommerce-conditional-product-fees-for-checkout' );
        } elseif ( 'deleted' === $message ) {
            $updated_message = esc_html__( "Fee rule has been deleted.", 'woocommerce-conditional-product-fees-for-checkout' );
        } elseif ( 'duplicated' === $message ) {
            $updated_message = esc_html__( "Fee rule has been duplicated.", 'woocommerce-conditional-product-fees-for-checkout' );
        } elseif ( 'disabled' === $message ) {
            $updated_message = esc_html__( "Fee rule has been disabled.", 'woocommerce-conditional-product-fees-for-checkout' );
        } elseif ( 'enabled' === $message ) {
            $updated_message = esc_html__( "Fee rule has been enabled.", 'woocommerce-conditional-product-fees-for-checkout' );
        }
        if ( 'failed' === $message ) {
            $failed_messsage = esc_html__( "There was an error with saving data.", 'woocommerce-conditional-product-fees-for-checkout' );
        } elseif ( 'nonce_check' === $message ) {
            $failed_messsage = esc_html__( "There was an error with security check.", 'woocommerce-conditional-product-fees-for-checkout' );
        }
        if ( 'validated' === $message ) {
            $validated_messsage = esc_html( $validation_msg );
        } elseif ( 'exist' === $message ) {
            $validated_messsage = esc_html__( "The fee rule title already exists. Please create a different title.", 'woocommerce-conditional-product-fees-for-checkout' );
        }
		
		if ( ! empty( $updated_message ) ) {
			echo sprintf( '<div id="message" class="notice notice-success is-dismissible"><p>%s</p></div>', esc_html( $updated_message ) );
			return false;
		}
		if ( ! empty( $failed_messsage ) ) {
			echo sprintf( '<div id="message" class="notice notice-error is-dismissible"><p>%s</p></div>', esc_html( $failed_messsage ) );
			return false;
		}
		if ( ! empty( $validated_messsage ) ) {
			echo sprintf( '<div id="message" class="notice notice-error is-dismissible"><p>%s</p></div>', esc_html( $validated_messsage ) );
			return false;
		}
	}

    /**
     * This function will return our plugin edit base language post link (not wordpress edit post link which cause "not allow to edit" error)
     * 
     * @param string $link
	 * @param int    $post_id
	 * @param string $lang
	 * @param int    $trid
	 *
	 * @return string
	 * @since    3.9.2
     * @author   SJ
     * 
     */
    public function wcpfc_wpml_translation_plugin_link( $link, $post_id, $lang, $trid ){

        if( !is_admin() ){
            return $link;
        }
        
        global $wpml_tm_translation_status, $wpml_post_translations, $sitepress;

        $post_translations  = $sitepress->post_translations();
        $status             = $wpml_tm_translation_status->filter_translation_status( null, $trid, $lang ); //status 10 means edit translated post
        $correct_id         = $wpml_post_translations->element_id_in( $post_id, $lang );
        $source_lang        = $post_translations->get_source_lang_code( $correct_id );
        
        if( self::wcpfc_post_type === get_post_type($post_id) && empty($source_lang) ){
            if( !in_array( $status, array( 0, 2 ), true ) && $status && $correct_id ) {
                $edit_method_url = add_query_arg( array(
                    'page'   => 'wcpfc-pro-list',
                    'action' => 'edit',
                    'id'   => $correct_id,
                    'lang' => $lang
                ), admin_url( 'admin.php' ) );
                $link         = wp_nonce_url( $edit_method_url, 'edit_' . $correct_id, '_wpnonce' );
            } 
        }

        return $link;
    }

    /**
     * This function will reset transient after create translated post
     * 
	 * @param int       $new_post_id
	 * @param array     $data_fields
	 * @param object    $job
	 *
	 * @return string
	 * @since    3.9.2
     * @author   SJ
     * 
     */
    public function wcpfc_wpml_transiention_action( $new_post_id, $data_fields, $job ){
        $base_post_id = !empty($job->original_doc_id) && isset($job->original_doc_id) ? $job->original_doc_id : 0;
        if( self::wcpfc_post_type === get_post_type( $new_post_id ) ){
            if( $base_post_id > 0 ){

                //Conditional Fee Rule Translated IDs of values
                $wppfc_wmpl_metabox_customize = array();
                $productFeesArray = get_post_meta( $base_post_id, 'product_fees_metabox', true );
                if ( ! empty( $productFeesArray ) ) {
                    foreach ( $productFeesArray as $key => $condition_array ) {
                        if ( 'product' === $condition_array['product_fees_conditions_condition'] 
                        || 'variableproduct' === $condition_array['product_fees_conditions_condition'] 
                        || 'category' === $condition_array['product_fees_conditions_condition'] 
                        || 'tag' === $condition_array['product_fees_conditions_condition'] 
                        || 'shipping_class' === $condition_array['product_fees_conditions_condition'] 
                        || strpos($condition_array['product_fees_conditions_condition'], 'pa_') === 0 ) {
                            $product_fees_conditions_values = $this->wcpfc_wpml_translated_id( $condition_array['product_fees_conditions_values'], $condition_array['product_fees_conditions_condition'], $job->language_code );
                            $wppfc_wmpl_metabox_customize[$key] = array(
                                'product_fees_conditions_condition' => $condition_array['product_fees_conditions_condition'],
                                'product_fees_conditions_is'        => $condition_array['product_fees_conditions_is'],
                                'product_fees_conditions_values'    => $product_fees_conditions_values,
                            );
                        } else {
                            $wppfc_wmpl_metabox_customize[$key] = array(
                                'product_fees_conditions_condition' => $condition_array['product_fees_conditions_condition'],
                                'product_fees_conditions_is'        => $condition_array['product_fees_conditions_is'],
                                'product_fees_conditions_values'    => $condition_array['product_fees_conditions_values'],
                            );
                        }
                    }
                    update_post_meta( $new_post_id, 'product_fees_metabox', $wppfc_wmpl_metabox_customize );
                }

                //Advanced Fee Price Rules translated Ids of Products value
                $wppfc_wmpl_ap_product_customize = array();
                $wppfc_wmpl_ap_product = get_post_meta( $base_post_id, 'sm_metabox_ap_product', true );
                if ( ! empty( $wppfc_wmpl_ap_product ) ) {
                    foreach ( $wppfc_wmpl_ap_product as $key => $val ) {
                        $ap_fees_products_values = $this->wcpfc_wpml_translated_id( $val['ap_fees_products'], 'product', $job->language_code );
                        $wppfc_wmpl_ap_product_customize[ $key ] = array(
                            'ap_fees_products'         	=> $ap_fees_products_values,
                            'ap_fees_ap_prd_min_qty'   	=> $val['ap_fees_ap_prd_min_qty'],
                            'ap_fees_ap_prd_max_qty'   	=> $val['ap_fees_ap_prd_max_qty'],
                            'ap_fees_ap_price_product' 	=> $val['ap_fees_ap_price_product'],
                            'ap_fees_ap_per_product' 	=> isset($val['ap_fees_ap_per_product']) && !empty($val['ap_fees_ap_per_product']) && strpos($val['ap_fees_ap_price_product'], '%') ? $val['ap_fees_ap_per_product'] : 'no',
                        );
                    }
                    update_post_meta( $new_post_id, 'sm_metabox_ap_product', $wppfc_wmpl_ap_product_customize );
                }

                //Advanced Fee Price Rules translated IDs of Product Subtotal
                $wppfc_wmpl_ap_product_subtotal_customize = array();
                $wppfc_wmpl_ap_product_subtotal = get_post_meta( $base_post_id, 'sm_metabox_ap_product_subtotal', true );
                if ( ! empty( $wppfc_wmpl_ap_product_subtotal ) ) {
                    foreach ( $wppfc_wmpl_ap_product_subtotal as $key => $val ) {
                        $ap_fees_product_subtotal_values = $this->wcpfc_wpml_translated_id( $val['ap_fees_product_subtotal'], 'product', $job->language_code );
                        $wppfc_wmpl_ap_product_subtotal_customize[ $key ] = array(
                            'ap_fees_product_subtotal'                 => $ap_fees_product_subtotal_values,
                            'ap_fees_ap_product_subtotal_min_subtotal' => $val['ap_fees_ap_product_subtotal_min_subtotal'],
                            'ap_fees_ap_product_subtotal_max_subtotal' => $val['ap_fees_ap_product_subtotal_max_subtotal'],
                            'ap_fees_ap_price_product_subtotal'        => $val['ap_fees_ap_price_product_subtotal'],
                        );
                    }
                    update_post_meta( $new_post_id, 'sm_metabox_ap_product_subtotal', $wppfc_wmpl_ap_product_subtotal_customize );
                }

                //Advanced Fee Price Rules translated IDs of Product Weight
                $wppfc_wmpl_ap_product_weight_customize = array();
                $wppfc_wmpl_ap_product_weight = get_post_meta( $base_post_id, 'sm_metabox_ap_product_weight', true );
                if ( ! empty( $wppfc_wmpl_ap_product_weight ) ) {
                    foreach ( $wppfc_wmpl_ap_product_weight as $key => $val ) {
                        $ap_fees_products_weight_values                 = $this->wcpfc_wpml_translated_id( $val['ap_fees_product_weight'], 'product', $job->language_code );
                        $wppfc_wmpl_ap_product_weight_customize[ $key ] = array(
                            'ap_fees_product_weight'            => $ap_fees_products_weight_values,
                            'ap_fees_ap_product_weight_min_qty' => $val['ap_fees_ap_product_weight_min_qty'],
                            'ap_fees_ap_product_weight_max_qty' => $val['ap_fees_ap_product_weight_max_qty'],
                            'ap_fees_ap_price_product_weight'   => $val['ap_fees_ap_price_product_weight'],
                        );
                    }
                    update_post_meta( $new_post_id, 'sm_metabox_ap_product_weight', $wppfc_wmpl_ap_product_weight_customize );
                }

                //Advanced Fee Price Rules translated IDs of Category
                $wppfc_wmpl_ap_category_customize = array();
                $wppfc_wmpl_ap_fees_categories = get_post_meta( $base_post_id, 'sm_metabox_ap_category', true );
                if ( ! empty( $wppfc_wmpl_ap_fees_categories ) ) {
                    foreach ( $wppfc_wmpl_ap_fees_categories as $key => $val ) {
                        $ap_fees_category_values                  = $this->wcpfc_wpml_translated_id( $val['ap_fees_categories'], 'category', $job->language_code );
                        $wppfc_wmpl_ap_category_customize[ $key ] = array(
                            'ap_fees_categories'        => $ap_fees_category_values,
                            'ap_fees_ap_cat_min_qty'    => $val['ap_fees_ap_cat_min_qty'],
                            'ap_fees_ap_cat_max_qty'    => $val['ap_fees_ap_cat_max_qty'],
                            'ap_fees_ap_price_category' => $val['ap_fees_ap_price_category'],
                        );
                    }
                    update_post_meta( $new_post_id, 'sm_metabox_ap_category', $wppfc_wmpl_ap_category_customize );
                }

                //Advanced Fee Price Rules translated IDs of Category Subtotal
                $wppfc_wmpl_ap_category_subtotal_customize = array();
                $wppfc_wmpl_ap_category_subtotal = get_post_meta( $base_post_id, 'sm_metabox_ap_category_subtotal', true );
                if ( ! empty( $wppfc_wmpl_ap_category_subtotal ) ) {
                    foreach ( $wppfc_wmpl_ap_category_subtotal as $key => $val ) {
                        $ap_fees_ap_category_subtotal_values               = $this->wcpfc_wpml_translated_id( $val['ap_fees_category_subtotal'], 'category', $job->language_code );
                        $wppfc_wmpl_ap_category_subtotal_customize[ $key ] = array(
                            'ap_fees_category_subtotal'                 => $ap_fees_ap_category_subtotal_values,
                            'ap_fees_ap_category_subtotal_min_subtotal' => $val['ap_fees_ap_category_subtotal_min_subtotal'],
                            'ap_fees_ap_category_subtotal_max_subtotal' => $val['ap_fees_ap_category_subtotal_max_subtotal'],
                            'ap_fees_ap_price_category_subtotal'        => $val['ap_fees_ap_price_category_subtotal'],
                        );
                    }
                    update_post_meta( $new_post_id, 'sm_metabox_ap_category_subtotal', $wppfc_wmpl_ap_category_subtotal_customize );
                }

                //Advanced Fee Rules translated IDs of Category Weight
                $wppfc_wmpl_ap_category_weight_customize = array();
                $wppfc_wmpl_ap_category_weight = get_post_meta( $base_post_id, 'sm_metabox_ap_category_weight', true );
                if ( ! empty( $wppfc_wmpl_ap_category_weight ) ) {
                    foreach ( $wppfc_wmpl_ap_category_weight as $key => $val ) {
                        $ap_fees_ap_category_weight_values               = $this->wcpfc_wpml_translated_id( $val['ap_fees_categories_weight'], 'category', $job->language_code );
                        $wppfc_wmpl_ap_category_weight_customize[ $key ] = array(
                            'ap_fees_categories_weight'          => $ap_fees_ap_category_weight_values,
                            'ap_fees_ap_category_weight_min_qty' => $val['ap_fees_ap_category_weight_min_qty'],
                            'ap_fees_ap_category_weight_max_qty' => $val['ap_fees_ap_category_weight_max_qty'],
                            'ap_fees_ap_price_category_weight'   => $val['ap_fees_ap_price_category_weight'],
                        );
                    }
                    update_post_meta( $new_post_id, 'sm_metabox_ap_category_weight', $wppfc_wmpl_ap_category_weight_customize );
                }

                //Advanced Fee Rules translated IDs of Shipping Class Subtotal
                $sm_metabox_ap_shipping_class_subtotal_customize = array();
                $wppfc_wmpl_ap_shipping_class_subtotal = get_post_meta( $base_post_id, 'sm_metabox_ap_shipping_class_subtotal', true );
                if ( ! empty( $wppfc_wmpl_ap_shipping_class_subtotal ) ) {
                    foreach ( $wppfc_wmpl_ap_shipping_class_subtotal as $key => $val ) {
                        $ap_fees_ap_shipping_class_subtotal_values               = $this->wcpfc_wpml_translated_id( $val['ap_fees_shipping_class_subtotals'], 'ap_shipping_class', $job->language_code );
                        $sm_metabox_ap_shipping_class_subtotal_customize[ $key ] = array(
                            'ap_fees_shipping_class_subtotals'                => $ap_fees_ap_shipping_class_subtotal_values,
                            'ap_fees_ap_shipping_class_subtotal_min_subtotal' => $val['ap_fees_ap_shipping_class_subtotal_min_subtotal'],
                            'ap_fees_ap_shipping_class_subtotal_max_subtotal' => $val['ap_fees_ap_shipping_class_subtotal_max_subtotal'],
                            'ap_fees_ap_price_shipping_class_subtotal'        => $val['ap_fees_ap_price_shipping_class_subtotal'],
                        );
                    }
                    update_post_meta( $new_post_id, 'sm_metabox_ap_shipping_class_subtotal', $sm_metabox_ap_shipping_class_subtotal_customize );
                }
            }

            delete_transient( 'get_all_fees' );
        }
    }

    /**
     * This function will add our custom post type fee traslatable link on admin language switcher
     * 
	 * @param array     $languages_links
	 *
	 * @return array
	 * @since    3.9.2
     * @author   SJ
     * 
     */
    public function wcpfc_admin_language_switcher_items( $languages_links ){ 
        
        global $sitepress;
        $get_wpnonce                = filter_input( INPUT_GET, '_wpnonce', FILTER_SANITIZE_STRING );
        $get_retrieved_nonce        = isset( $get_wpnonce ) ? sanitize_text_field( wp_unslash( $get_wpnonce ) ) : '';
        $post_id = isset($_GET['id']) && !empty($_GET['id']) ? intval($_GET['id']) : 0;
        if( $post_id > 0 && self::wcpfc_post_type === get_post_type( $post_id ) && wp_verify_nonce( $get_retrieved_nonce, 'edit_' . $post_id ) ){
            $post    = get_post( $post_id );
            $post_language = $sitepress->get_language_for_element( $post_id, 'post_' . get_post_type( $post_id ) );
            $trid         = $sitepress->get_element_trid( $post_id, 'post_' . $post->post_type );
            $translations = $sitepress->get_element_translations( $trid, 'post_' . $post->post_type, true );

            $active_languages   = $sitepress->get_active_languages();
            $current_language   = $sitepress->get_current_language();
            foreach ( $active_languages as $lang ) {
                if( $lang !== $current_language) {
                    if ( isset( $_SERVER['QUERY_STRING'] ) ) {
                        parse_str( sanitize_text_field( $_SERVER['QUERY_STRING']), $query_vars );
                        unset( $query_vars['lang'], $query_vars['admin_bar'] );
                    } else {
                        $query_vars = array();
                    }
                    if ( isset( $translations[ $lang['code'] ] ) && isset( $translations[ $lang['code'] ]->element_id ) ) {
                        $query_vars['id'] = $translations[ $lang['code'] ]->element_id;
                        unset( $query_vars['source_lang'] );
                    }
                    $query_vars['lang'] = $lang['code'];
                    $query_vars['admin_bar'] = 1;
                    $edit_method_url = add_query_arg( $query_vars, admin_url( 'admin.php' ) );
                    $link            = wp_nonce_url( $edit_method_url, 'edit_' . $query_vars['id'], '_wpnonce' );
                    $languages_links[$lang['code']]['url'] = $link; 
                    //Here we can not open WPML advanced popup as they used "post" as post_id parameter and we use "id" as post_id that not satisfy by WPML notice condition
                    //here is condition: WPML_TM_Post_Edit_Notices::display_notices hook not append
                    
                }
            }
        }
        return $languages_links;
    }
}
