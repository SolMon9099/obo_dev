<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$plugin_name        = WCPFC_PRO_PLUGIN_NAME;
$plugin_version     = WCPFC_PRO_PLUGIN_VERSION;
$wcpfc_admin_object = new Woocommerce_Conditional_Product_Fees_For_Checkout_Pro_Admin( '', '' );
if ( wcpffc_fs()->is__premium_only() ) {
        if ( wcpffc_fs()->can_use_premium_code() ) {
            $version_label = 'Pro Version';
        }else{
            $version_label = 'Free Version';
        }
    }else{
        $version_label = 'Free Version';
    }
?>
<div id="dotsstoremain">
	<div class="all-pad">
        <hr class="wp-header-end" />
		<header class="dots-header">
			<div class="dots-plugin-details">
                <div class="dots-header-left">
                    <div class="dots-logo-main">
                        <div class="logo-image">
                            <img src="<?php echo esc_url( WCPFC_PRO_PLUGIN_URL . 'admin/images/wc-conditional-product-fees.png' ); ?>">
                        </div>
                        <div class="plugin-version">
                            <span><?php esc_html_e($version_label, 'woocommerce-conditional-product-fees-for-checkout'); ?> <?php echo esc_html($plugin_version); ?></span>
                        </div>
                    </div>
                    <div class="plugin-name">
                        <div class="title"><?php esc_html_e($plugin_name, 'woocommerce-conditional-product-fees-for-checkout'); ?></div>
						<div class="desc"><?php esc_html_e('Offers you an option to set up extra fees based on the multiple conditional rules with simple and easy configuration.', 'woocommerce-conditional-product-fees-for-checkout'); ?></div>
                    </div>
                </div>
                <div class="dots-header-right">
                    

                    <div class="button-group">
                        <div class="button-dots">
                            <span class="support_dotstore_image">
                                <a target="_blank" href="<?php echo esc_url('http://www.thedotstore.com/support/'); ?>">
                                    <span class="dashicons dashicons-sos"></span>
                                    <strong><?php esc_html_e('Quick Support', 'woocommerce-conditional-product-fees-for-checkout') ?></strong>
                                </a>
                            </span>
                        </div>

                        <div class="button-dots">
                            <span class="support_dotstore_image">
                                <a target="_blank" href="<?php echo esc_url('https://docs.thedotstore.com/category/191-premium-plugin-settings'); ?>">
                                    <span class="dashicons dashicons-media-text"></span>
                                    <strong><?php esc_html_e('Documentation', 'woocommerce-conditional-product-fees-for-checkout') ?></strong>
                                </a>
                            </span>
                        </div>

                        <?php
                        if ( wcpffc_fs()->is__premium_only() ) {
                            if ( wcpffc_fs()->can_use_premium_code() ) { ?>
                                <div class="button-dots">
                                    <span class="support_dotstore_image">
                                        <a target="_blank" href="<?php echo esc_url(wcpffc_fs()->get_account_url()); ?>">
                                            <span class="dashicons dashicons-admin-users"></span>
                                            <strong><?php esc_html_e('My Account', 'woocommerce-conditional-product-fees-for-checkout') ?></strong>
                                        </a>
                                    </span>
                                </div>
                                <?php
                            }else{ ?>
                                <div class="button-dots">
                                    <span class="support_dotstore_image">
                                        <a target="_blank" href="<?php echo esc_url(wcpffc_fs()->get_upgrade_url()); ?>">
                                            <span class="dashicons dashicons-upload"></span>
                                            <strong><?php esc_html_e('Upgrade To Pro', 'woocommerce-conditional-product-fees-for-checkout') ?></strong>
                                        </a>
                                    </span>
                                </div> 
                            <?php 
                            } 
                        }else{ ?>
                            <div class="button-dots">
                                <span class="support_dotstore_image">
                                    <a target="_blank" href="<?php echo esc_url(wcpffc_fs()->get_upgrade_url()); ?>">
                                        <span class="dashicons dashicons-upload"></span>
                                        <strong><?php esc_html_e('Upgrade To Pro', 'woocommerce-conditional-product-fees-for-checkout') ?></strong>
                                    </a>
                                </span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
			
			<?php
			$current_page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING );
			$wcpfc_admin_object->wcpfc_pro_menus( $current_page );
			?>
		</header>
        <?php if( 'wcpfc-pro-dashboard' !== $current_page ){ ?>  
        <div class="dots-settings-inner-main">
            <div class="dots-settings-left-side">
            <?php $message = filter_input( INPUT_GET, 'message', FILTER_SANITIZE_STRING );
            if ( isset( $message ) && ! empty( $message ) ) {
                $wcpfc_admin_object->wcpfc_updated_message( $message, "" );
            } ?>
        <?php } ?>