<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$allowed_tooltip_html = wp_kses_allowed_html( 'post' )['span'];
?>
<div class="wcpfc-mastersettings">
			<div class="mastersettings-title">
				<h2><?php esc_html_e( 'Master Settings', 'woocommerce-conditional-product-fees-for-checkout' ); ?></h2>
			</div>
			<?php
			$chk_enable_logging     	 	 = get_option( 'chk_enable_logging' );
			$chk_enable_coupon_fee  		 = get_option( 'chk_enable_coupon_fee' );
			$chk_enable_custom_fun  		 = get_option( 'chk_enable_custom_fun' );
			$chk_enable_all_fee_tax 		 = get_option( 'chk_enable_all_fee_tax' );
			$chk_enable_all_fee_tooltip 	 = get_option( 'chk_enable_all_fee_tooltip' );
			$chk_enable_all_fee_tooltip_text = get_option( 'chk_enable_all_fee_tooltip_text' );
			$chk_fees_per_page      		 = get_option( 'chk_fees_per_page' );

			$chk_enable_logging_checked    	 = ( ( ! empty( $chk_enable_logging ) && 'on' === $chk_enable_logging ) || empty( $chk_enable_logging ) ) ? 'checked' : '';
			$chk_enable_coupon_fee_checked 	 = ( ( ! empty( $chk_enable_coupon_fee ) && 'on' === $chk_enable_coupon_fee ) ) ? 'checked' : '';
			$chk_enable_custom_fun_checked 	 = ( ( ! empty( $chk_enable_custom_fun ) && 'on' === $chk_enable_custom_fun ) ) ? 'checked' : '';
			$chk_enable_all_fee_tax		   	 = ( ( ! empty( $chk_enable_all_fee_tax ) && 'on' === $chk_enable_all_fee_tax ) ) ? 'checked' : '';
			$chk_enable_all_fee_tooltip		 = ( ( ! empty( $chk_enable_all_fee_tooltip ) && 'on' === $chk_enable_all_fee_tooltip ) ) ? 'checked' : '';
			$chk_enable_all_fee_tooltip_text = ( ! empty( $chk_enable_all_fee_tooltip_text ) ) ? $chk_enable_all_fee_tooltip_text : '';
			

			?>
			<table class="table-mastersettings table-outer" cellpadding="0" cellspacing="0">
				<tbody>
                    <tr valign="top" id="enable_logging">
                        <td class="table-whattodo"><?php esc_html_e( 'Enable Logging', 'woocommerce-conditional-product-fees-for-checkout' ); ?></td>
                        <td>
                            <input type="checkbox" name="chk_enable_logging" id="chk_enable_logging" value="on" <?php echo esc_attr( $chk_enable_logging_checked ); ?>>
                        </td>
                    </tr>
                    <tr valign="top" id="enable_coupon_fee">
                        <td class="table-whattodo"><?php esc_html_e( 'Remove fees once a 100% discount applies.', 'woocommerce-conditional-product-fees-for-checkout' ); ?></td>
                        <td>
                            <input type="checkbox" name="chk_enable_coupon_fee" id="chk_enable_coupon_fee" value="on" <?php echo esc_attr( $chk_enable_coupon_fee_checked ); ?>>
                        </td>
                    </tr>
                    <tr valign="top" id="enable_custom_fun">
                        <td class="table-whattodo">
                            <?php esc_html_e( 'Display all fees in one label', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
                            <?php echo wp_kses( wc_help_tip( esc_html__( 'This option will merge all fees into one fee', 'woocommerce-conditional-product-fees-for-checkout' ) ), array( 'span' => $allowed_tooltip_html ) ); ?>
                        </td>
                        <td>
                            <input type="checkbox" name="chk_enable_custom_fun" id="chk_enable_custom_fun" value="on" <?php echo esc_attr( $chk_enable_custom_fun_checked ); ?>>
                        </td>
                    </tr>
                    <tr valign="top" id="enable_all_fee_tax" style="display:none">
                        <td class="table-whattodo">
                            <?php esc_html_e( 'Merge all fee with taxable', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
                            <?php echo wp_kses( wc_help_tip( esc_html__( 'This option will make this one merge fee calculate as taxable', 'woocommerce-conditional-product-fees-for-checkout' ) ), array( 'span' => $allowed_tooltip_html ) ); ?>
                        </td>
                        <td>
                            <input type="checkbox" name="chk_enable_all_fee_tax" id="chk_enable_all_fee_tax" value="on" <?php echo esc_attr( $chk_enable_all_fee_tax ); ?>>
                        </td>
                    </tr>
                    <tr valign="top" id="enable_all_fee_tooltip" style="display:none">
                        <td class="table-whattodo">
                            <?php esc_html_e( 'Merge all fee tooltip', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
                            <?php echo wp_kses( wc_help_tip( esc_html__( 'This option will add tooltip to merge fee label', 'woocommerce-conditional-product-fees-for-checkout' ) ), array( 'span' => $allowed_tooltip_html ) ); ?>
                        </td>
                        <td>
                            <input type="checkbox" name="chk_enable_all_fee_tooltip" id="chk_enable_all_fee_tooltip" value="on" <?php echo esc_attr( $chk_enable_all_fee_tooltip ); ?>>
                        </td>
                    </tr>
                    <tr valign="top" id="enable_all_fee_tooltip_text" style="display:none">
                        <td class="table-whattodo">
                            <?php esc_html_e( 'Merge all fee tooltip text', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
                            <?php echo wp_kses( wc_help_tip( esc_html__( 'This option will change tooltip content', 'woocommerce-conditional-product-fees-for-checkout' ) ), array( 'span' => $allowed_tooltip_html ) ); ?>
                        </td>
                        <td>
                            <input type="text" name="chk_enable_all_fee_tooltip_text" id="chk_enable_all_fee_tooltip_text" value="<?php echo esc_attr( $chk_enable_all_fee_tooltip_text ); ?>" />
                        </td>
                    </tr>
                    <tr valign="top" id="fees_count_per_page">
                        <td class="table-whattodo"><?php esc_html_e( 'Number of fees per page', 'woocommerce-conditional-product-fees-for-checkout' ); ?></td>
                        <td>
                            <input type="number" min="1" step="1" placeholder="10" name="chk_fees_per_page" id="chk_fees_per_page" value="<?php echo esc_attr( $chk_fees_per_page ); ?>" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <span class="button-primary" id="save_master_settings" name="save_master_settings">
                                <?php esc_html_e( 'Save Master Settings', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
                            </span>
                        </td>
                    </tr>
				</tbody>
			</table>
		</div>