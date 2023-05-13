<?php
/**
 * If this file is called directly, abort.
 * 
 * @category SidebarTemplate
 * @package  ConditionalProductFeesForCheckout
 * @author   theDotstore <support@thedotstore.com>
 * @license  GPL-2.0+ (http://www.gnu.org/licenses/gpl-2.0.txt)
 * @link     https://www.thedotstore.com/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$image_url = WCPFC_PRO_PLUGIN_URL . 'admin/images/right_click.png';
?>
</div>
    <div class="dots-settings-right-side">
        <div class="dots-seperator">
            <button class="toggleSidebar" title="toogle sidebar">
                <span class="dashicons dashicons-arrow-right-alt2"></span>
            </button>
        </div>
        <div class="dotstore_plugin_sidebar">
            <?php
            $review_url = '';
            $plugin_at  = '';
            if ( wcpffc_fs()->is__premium_only() ) {
                if ( wcpffc_fs()->can_use_premium_code() ) {
                    $review_url = 'https://www.thedotstore.com/woocommerce-extra-fees-plugin/#tab-reviews';
                    $changelog_url = 'https://www.thedotstore.com/flat-rate-shipping-plugin-for-woocommerce#tab-update-log';
                    $plugin_at  = 'theDotstore';
                } else {
                    $review_url = 'https://wordpress.org/plugins/woo-conditional-product-fees-for-checkout/#reviews';
                    $changelog_url = 'https://wordpress.org/plugins/woo-conditional-product-fees-for-checkout/#developers';
                    $plugin_at  = 'WP.org';    
                }
            } else {
                $review_url = 'https://wordpress.org/plugins/woo-conditional-product-fees-for-checkout/#reviews';
                $changelog_url = 'https://wordpress.org/plugins/woo-conditional-product-fees-for-checkout/#developers';
                $plugin_at  = 'WP.org';
            }
            ?>
            <div class="dotstore-sidebar-section">
                <div class="content_box">
                    <h3><?php esc_html_e('Like This Plugin?', 'woocommerce-conditional-product-fees-for-checkout'); ?></h3>
                    <div class="et-star-rating">
                        <input type="radio" id="5-stars" name="rating" value="5" />
                        <label for="5-stars" class="star"></label>
                        <input type="radio" id="4-stars" name="rating" value="4" />
                        <label for="4-stars" class="star"></label>
                        <input type="radio" id="3-stars" name="rating" value="3" />
                        <label for="3-stars" class="star"></label>
                        <input type="radio" id="2-stars" name="rating" value="2" />
                        <label for="2-stars" class="star"></label>
                        <input type="radio" id="1-star" name="rating" value="1" />
                        <label for="1-star" class="star"></label>
                        <input type="hidden" id="et-review-url" value="<?php echo esc_url($review_url);?>">
                    </div>
                    <p><?php esc_html_e('Your Review is very important to us as it helps us to grow more.', 'woocommerce-conditional-product-fees-for-checkout'); ?></p>
                </div>
            </div>
            <div class="dotstore-sidebar-section">
                <div class="dotstore-important-link-heading">
                    <span class="dashicons dashicons-star-filled"></span>
                    <span class="heading-text"><?php esc_html_e('Suggest A Feature', 'woocommerce-conditional-product-fees-for-checkout'); ?></span>
                </div>
                <div class="dotstore-important-link-content">
                    <p><?php esc_html_e('Let us know how we can improve the plugin experience.', 'woocommerce-conditional-product-fees-for-checkout'); ?></p>
                    <p><?php esc_html_e('Do you have any feedback &amp; feature requests?', 'woocommerce-conditional-product-fees-for-checkout'); ?></p>
                    <a target="_blank" href="<?php echo esc_url('https://www.thedotstore.com/suggest-a-feature'); ?>"><?php esc_html_e('Submit Request', 'woocommerce-conditional-product-fees-for-checkout'); ?> »</a>
                </div>
            </div>
            <div class="dotstore-sidebar-section">
                <div class="dotstore-important-link-heading">
                    <span class="dashicons dashicons-editor-kitchensink"></span>
                    <span class="heading-text"><?php esc_html_e('Changelog', 'woocommerce-conditional-product-fees-for-checkout'); ?></span>
                </div>
                <div class="dotstore-important-link-content">
                    <p><?php esc_html_e('We improvise our products on a regular basis to deliver the best results to customer satisfaction.', 'woocommerce-conditional-product-fees-for-checkout'); ?></p>
                    <a target="_blank" href="<?php echo esc_url($changelog_url); ?>"><?php esc_html_e('Visit Here', 'woocommerce-conditional-product-fees-for-checkout'); ?> »</a>
                </div>
            </div>
            <div class="dotstore-sidebar-section">
                <div class="dotstore-important-link-heading">
                    <span class="dashicons dashicons-sos"></span>
                    <span class="heading-text"><?php esc_html_e('Five Star Support', 'woocommerce-conditional-product-fees-for-checkout'); ?></span>
                </div>
                <div class="dotstore-important-link-content">
                    <p><?php esc_html_e('Got a question? Get in touch with theDotstore developers. We are happy to help!', 'woocommerce-conditional-product-fees-for-checkout'); ?></p>
                    <a target="_blank" href="<?php echo esc_url('https://www.thedotstore.com/support/'); ?>"><?php esc_html_e('Submit a Ticket', 'woocommerce-conditional-product-fees-for-checkout'); ?> »</a>
                </div>
            </div>
            <div class="dotstore-sidebar-section">
                <div class="dotstore-important-link-heading">
                    <span class="dashicons dashicons-media-document"></span>
                    <span class="heading-text"><?php esc_html_e('Plugin documentation', 'woocommerce-conditional-product-fees-for-checkout'); ?></span>
                </div>
                <div class="dotstore-important-link-content">
                    <p><?php esc_html_e('Please check our documentation for any type of help regarding this plugin.', 'woocommerce-conditional-product-fees-for-checkout'); ?></p>
                    <a target="_blank" href="<?php echo esc_url('https://docs.thedotstore.com/category/191-premium-plugin-settings'); ?>"><?php esc_html_e('Checkout documentation', 'woocommerce-conditional-product-fees-for-checkout'); ?> »</a>
                </div>
            </div>

            <div class="dotstore-important-link dotstore-sidebar-section">
                <div class="dotstore-important-link-heading">
                    <span class="dashicons dashicons-plugins-checked"></span>
                    <span class="heading-text"><?php esc_html_e('Our Popular Plugins', 'woocommerce-conditional-product-fees-for-checkout'); ?></span>
                </div>
                <div class="video-detail important-link">
                    <ul>
                        <li>
                            <img class="sidebar_plugin_icone" src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/popular-plugins/Advanced-Flat-Rate-Shipping-Method.png' ); ?>" alt="<?php esc_attr_e( 'Flat Rate Shipping Plugin For WooCommerce', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
                            <a target="_blank" href="<?php echo esc_url( "https://www.thedotstore.com/flat-rate-shipping-plugin-for-woocommerce/" ); ?>">
                                <?php esc_html_e( 'Flat Rate Shipping Plugin For WooCommerce', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
                            </a>
                        </li>
                        <li>
                            <img class="sidebar_plugin_icone" src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/popular-plugins/plugn-login-128.png' ); ?>" alt="<?php esc_attr_e( 'Hide Shipping Method For WooCommerce', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
                            <a target="_blank" href="<?php echo esc_url( "https://www.thedotstore.com/hide-shipping-method-for-woocommerce/" ); ?>">
                                <?php esc_html_e( 'Hide Shipping Method For WooCommerce', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
                            </a>
                        </li>
                        <li>
                            <img class="sidebar_plugin_icone" src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/popular-plugins/WooCommerce Conditional Discount Rules For Checkout.png' ); ?>" alt="<?php esc_attr_e( 'Conditional Discount Rules For WooCommerce Checkout', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
                            <a target="_blank" href="<?php echo esc_url( "https://www.thedotstore.com/woocommerce-conditional-discount-rules-for-checkout/" ); ?>">
                                <?php esc_html_e( 'Conditional Discount Rules For WooCommerce Checkout', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
                            </a>
                        </li>
                        <li>
                            <img class="sidebar_plugin_icone" src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/popular-plugins/WooCommerce-Blocker-Prevent-Fake-Orders.png' ); ?>" alt="<?php esc_attr_e( 'WooCommerce Blocker – Prevent Fake Orders', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
                            <a target="_blank" href="<?php echo esc_url( "https://www.thedotstore.com/woocommerce-anti-fraud" ); ?>">
                                <?php esc_html_e( 'WooCommerce Anti-Fraud', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
                            </a>
                        </li>
                        <li>
                            <img class="sidebar_plugin_icone" src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/popular-plugins/Advanced-Product-Size-Charts-for-WooCommerce.png' ); ?>" alt="<?php esc_attr_e( 'Product Size Charts Plugin For WooCommerce', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
                            <a target="_blank" href="<?php echo esc_url( "https://www.thedotstore.com/woocommerce-advanced-product-size-charts/" ); ?>">
                                <?php esc_html_e( 'Product Size Charts Plugin For WooCommerce', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
                            </a>
                        </li>
                        <li>
                            <img class="sidebar_plugin_icone" src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/popular-plugins/wcbm-logo.png' ); ?>" alt="<?php esc_attr_e( 'WooCommerce Category Banner Management', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
                            <a target="_blank" href="<?php echo esc_url( "https://www.thedotstore.com/product/woocommerce-category-banner-management/" ); ?>">
                                <?php esc_html_e( 'WooCommerce Category Banner Management', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
                            </a>
                        </li>
                        <li>
                            <img class="sidebar_plugin_icone" src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/popular-plugins/woo-product-att-logo.png' ); ?>" alt="<?php esc_attr_e( 'Product Attachment For WooCommerce', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
                            <a target="_blank" href="<?php echo esc_url( "https://www.thedotstore.com/woocommerce-product-attachment/" ); ?>">
                                <?php esc_html_e( 'Product Attachment For WooCommerce', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="view-button">
                    <a class="button button-primary button-large" target="_blank" href="<?php echo esc_url('https://www.thedotstore.com/plugins'); ?>"><?php esc_html_e('VIEW ALL', 'woocommerce-conditional-product-fees-for-checkout'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>