<?php
/**
 * Dashboard template structure
 *
 * @package    Woocommerce_Conditional_Product_Fees_For_Checkout_Pro
 * @subpackage Woocommerce_Conditional_Product_Fees_For_Checkout_Pro/admin/partials
 * @author     Multidots <inquiry@multidots.in>
 * @link       https://www.multidots.com
 * @since      3.7.0
 */

if (! defined('ABSPATH') ) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'header/plugin-header.php';

global $sitepress;

/**
 * Get current site langugae
 *
 * @return string  $default_lang
 * @since  3.7.0
 */
function Wcpfc_Pro_Get_Current_Site_language()
{
    $get_site_language = get_bloginfo("language");
    if (false !== strpos($get_site_language, '-') ) {
        $get_site_language_explode = explode('-', $get_site_language);
        $default_lang              = $get_site_language_explode[0];
    } else {
        $default_lang = $get_site_language;
    }
    return $default_lang;
}

if (! empty($sitepress) ) {
    $default_lang = $sitepress->get_current_language();
} else {
    $default_lang = Wcpfc_Pro_Get_Current_Site_language();
}

$currency_symbol = get_woocommerce_currency_symbol() ? get_woocommerce_currency_symbol() : '$';

$plugin_name = 'woocommerce-conditional-product-fees-for-checkout';
$version     = WCPFC_PRO_PLUGIN_VERSION;
$plugin_admin = new Woocommerce_Conditional_Product_Fees_For_Checkout_Pro_Admin($plugin_name, $version);

// Total Revenue
$total_revenue = get_transient('get_total_revenue');
$first_time_flag = get_option('total_old_revenue_flag');
if (false === $total_revenue && $first_time_flag) {

    $edate = gmdate("Y-m-d");
    $sdate = get_option('total_old_revenue_flag_date'); 
    $old_fee_amount = get_option('total_old_revenue_amount');

    $list_of_fees_total = $plugin_admin->get_fee_data_from_date_range( $sdate, $edate, '' );
    $total_revenue = $old_fee_amount ? $old_fee_amount : 0;
    
    foreach ($list_of_fees_total as $list_of_fee_total ) {
        $total_revenue += $list_of_fee_total;
    }

    $total_revenue = floatval(preg_replace('/[^\d.]/', '', $total_revenue));
    set_transient('get_total_revenue', $total_revenue, 15 * MINUTE_IN_SECONDS);
}

// Total yearly revenue
$total_yearly_revenue = get_transient('get_total_yearly_revenue');
if (false === $total_yearly_revenue ) {
    
    $start_date = gmdate("Y-m-d", strtotime("first day of January this year"));
    $end_date   = gmdate("Y-m-d", strtotime("today"));

    $list_of_fees_total = $plugin_admin->get_fee_data_from_date_range($start_date, $end_date);
    $total_yearly_revenue = 0;
    
    foreach ($list_of_fees_total as $list_of_fee_total ) {
        $total_yearly_revenue += $list_of_fee_total;
    }
    
    $total_yearly_revenue = number_format($total_yearly_revenue, 2);

    $total_yearly_revenue = floatval(preg_replace('/[^\d.]/', '', $total_yearly_revenue));
    set_transient('get_total_yearly_revenue', $total_yearly_revenue, 15 * MINUTE_IN_SECONDS);
}

// Total last month revenue
$total_last_month_revenue = get_transient('get_total_last_month_revenue');
if (false === $total_last_month_revenue ) {
    
    $start_date = gmdate("Y-m-d", strtotime("first day of previous month"));
    $end_date   = gmdate("Y-m-d", strtotime("last day of previous month"));
    
    $list_of_fees_total = $plugin_admin->get_fee_data_from_date_range($start_date, $end_date);
    $total_last_month_revenue = 0;
    
    foreach ($list_of_fees_total as $list_of_fee_total ) {
        $total_last_month_revenue += $list_of_fee_total;
    }
    
    $total_last_month_revenue = number_format($total_last_month_revenue, 2);
    
    $total_last_month_revenue = floatval(preg_replace('/[^\d.]/', '', $total_last_month_revenue));
    set_transient('get_total_last_month_revenue', $total_last_month_revenue, 15 * MINUTE_IN_SECONDS);
}

// Total this month revenue
$total_this_month_revenue = get_transient('get_total_this_month_revenue');
if (false === $total_this_month_revenue ) {
    
    $start_date = gmdate("Y-m-d", strtotime("first day of this month"));
    $end_date   = gmdate("Y-m-d", strtotime("last day of this month"));
    
    $list_of_fees_total = $plugin_admin->get_fee_data_from_date_range($start_date, $end_date);
    $total_this_month_revenue = 0;
    
    foreach ($list_of_fees_total as $list_of_fee_total ) {
        $total_this_month_revenue += $list_of_fee_total;
    }
    
    $total_this_month_revenue = number_format($total_this_month_revenue, 2);
    
    $total_this_month_revenue = floatval(preg_replace('/[^\d.]/', '', $total_this_month_revenue));
    set_transient('get_total_this_month_revenue', $total_this_month_revenue, 5 * MINUTE_IN_SECONDS);
}

// Total yesterday revenue
$total_yesterday_revenue = get_transient('get_total_yesterday_revenue');
if (false === $total_yesterday_revenue ) {
    
    $start_date = $end_date = gmdate("Y-m-d", strtotime("-1 days"));
    
    $list_of_fees_total = $plugin_admin->get_fee_data_from_date_range($start_date, $end_date);
    $total_yesterday_revenue = 0;
    
    foreach ($list_of_fees_total as $list_of_fee_total ) {
        $total_yesterday_revenue += $list_of_fee_total;
    }
    
    $total_yesterday_revenue = number_format($total_yesterday_revenue, 2);
    
    $total_yesterday_revenue = floatval(preg_replace('/[^\d.]/', '', $total_yesterday_revenue));
    set_transient('get_total_yesterday_revenue', $total_yesterday_revenue, 15 * MINUTE_IN_SECONDS);
}

$total_today_revenue = get_transient('get_total_today_revenue');
if (false === $total_today_revenue ) {
    
    $start_date = $end_date = gmdate("Y-m-d", strtotime("today"));
    
    $list_of_fees_total = $plugin_admin->get_fee_data_from_date_range($start_date, $end_date);
    $total_today_revenue = 0;

    foreach ($list_of_fees_total as $list_of_fee_total ) {
        $total_today_revenue += $list_of_fee_total;
    }
    
    $total_today_revenue = number_format($total_today_revenue, 2);
    
    $total_today_revenue = floatval(preg_replace('/[^\d.]/', '', $total_today_revenue));
    set_transient('get_total_today_revenue', $total_today_revenue, 5 * MINUTE_IN_SECONDS);
}
?>
<div class="wcpfc-section-full">
    <div class="wcpfc-grid-layout">
        <?php if(!$first_time_flag) { ?>
        <div class="wcpfc-card wcpfc-main-chart" style="grid-column: span 12 / auto;">
            <div class="content">
                <div class="wcpfc-mini-chart">
                    <div class="header">
                        <div class="title"><?php esc_html_e( 'Migration Progress (Do not refresh the page until this process complete.)', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
                        <span>(<span class="progress_count">0</span>%)</span>
                    </div>
                    </div>
                    <div class="content">
                        <div class="progressbar">
                            <div class="progress"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <p style="grid-column: span 10 / auto;" class="wcpfc-section-note">
            <?php echo sprintf( wp_kses_post( '%1$sNote: %2$sEvery 15 minutes report data will updated.', 'woocommerce-conditional-product-fees-for-checkout' ), '<strong>', '</strong>' ); ?>
        </p>
        <button class="primary button reset-cache" style="grid-column: span 2 / auto;"><?php esc_html_e( 'Refresh Data', 'woocommerce-conditional-product-fees-for-checkout' ); ?></button>
        <div class="wcpfc-card wcpfc-main-chart" style="grid-column: span 2 / auto;">
            <div class="content">
                <div class="wcpfc-mini-chart">
                    <div class="header">
                        <div class="title"><?php esc_html_e( 'Total revenue', 'woocommerce-conditional-product-fees-for-checkout' ); ?></div>
                    </div>
                    <div class="content">
                        <div class="amount"><?php echo esc_html($currency_symbol.number_format(round($total_revenue))); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wcpfc-card wcpfc-main-chart" style="grid-column: span 2 / auto;">
            <div class="content">
                <div class="wcpfc-mini-chart">
                    <div class="header">
                        <div class="title"><?php esc_html_e( 'This year revenue', 'woocommerce-conditional-product-fees-for-checkout' ); ?></div>
                    </div>
                    <div class="content">
                        <div class="amount"><?php echo esc_html($currency_symbol.number_format(round($total_yearly_revenue))); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wcpfc-card wcpfc-main-chart" style="grid-column: span 2 / auto;">
            <div class="content">
                <div class="wcpfc-mini-chart">
                    <div class="header">
                        <div class="title"><?php esc_html_e( 'Last month revenue', 'woocommerce-conditional-product-fees-for-checkout' ); ?></div>
                    </div>
                    <div class="content">
                        <div class="amount"><?php echo esc_html($currency_symbol.number_format(round($total_last_month_revenue))); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wcpfc-card wcpfc-main-chart" style="grid-column: span 2 / auto;">
            <div class="content">
                <div class="wcpfc-mini-chart">
                    <div class="header">
                        <div class="title"><?php esc_html_e( 'This month revenue', 'woocommerce-conditional-product-fees-for-checkout' ); ?></div>
                    </div>
                    <div class="content">
                        <div class="amount"><?php echo esc_html($currency_symbol.number_format(round($total_this_month_revenue))); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wcpfc-card wcpfc-main-chart" style="grid-column: span 2 / auto;">
            <div class="content">
                <div class="wcpfc-mini-chart">
                    <div class="header">
                        <div class="title"><?php esc_html_e( 'Yesterday revenue', 'woocommerce-conditional-product-fees-for-checkout' ); ?></div>
                    </div>
                    <div class="content">
                        <div class="amount"><?php echo esc_html($currency_symbol.number_format(round($total_yesterday_revenue))); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wcpfc-card wcpfc-main-chart" style="grid-column: span 2 / auto;">
            <div class="content">
                <div class="wcpfc-mini-chart">
                    <div class="header">
                        <div class="title"><?php esc_html_e( 'Today revenue', 'woocommerce-conditional-product-fees-for-checkout' ); ?></div>
                    </div>
                    <div class="content">
                        <div class="amount"><?php echo esc_html($currency_symbol.number_format(round($total_today_revenue))); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wcpfc-filter-fee wcpfc-main-chart" style="grid-column: span 12 / auto;">
            <div class="wcpfc-period-selector">
                <div class="wcpfc-datepicker">
                    <span class="dashicons dashicons-calendar-alt"></span>
                    <input type="text" id="wcpfc-custom-from" name="wcpfc-custom-from" autocomplete="off" />
                    <span class="dashicons dashicons-arrow-right-alt"></span>
                    <input type="text" id="wcpfc-custom-to" name="wcpfc-custom-to" autocomplete="off" />
                </div>
                <div class="wcpfc-filter-specific">
                    <button class="primary button" data-start="<?php echo esc_attr(gmdate("Y-m-d", strtotime("today"))); ?>" data-end="<?php echo esc_attr(gmdate("Y-m-d", strtotime("today"))); ?>"><?php esc_html_e( 'Day', 'woocommerce-conditional-product-fees-for-checkout' ); ?></button>
                    <button class="primary button" data-start="<?php echo esc_attr(gmdate("Y-m-d", strtotime("-7 day"))); ?>" data-end="<?php echo esc_attr(gmdate("Y-m-d", strtotime("today"))); ?>"><?php esc_html_e( 'Week', 'woocommerce-conditional-product-fees-for-checkout' ); ?></button>
                    <button class="primary button" data-start="<?php echo esc_attr(gmdate("Y-m-d", strtotime("-30 day"))); ?>" data-end="<?php echo esc_attr(gmdate("Y-m-d", strtotime("today"))); ?>"><?php esc_html_e( 'Month', 'woocommerce-conditional-product-fees-for-checkout' ); ?></button>
                    <button class="primary button" data-start="<?php echo esc_attr(gmdate("Y-m-d", strtotime("-365 day"))); ?>" data-end="<?php echo esc_attr(gmdate("Y-m-d", strtotime("today"))); ?>"><?php esc_html_e( 'Year', 'woocommerce-conditional-product-fees-for-checkout' ); ?></button>
                    <button class="primary button all-data" data-start="<?php echo esc_attr('all') ?>" data-end="<?php echo esc_attr('all') ?>"><?php esc_html_e( 'All Time', 'woocommerce-conditional-product-fees-for-checkout' ); ?></button>
                </div>
            </div>
            <canvas id="myChart"></canvas>
        </div>
        <div class="wcpfc-top-ten wcpfc-main-chart" style="grid-column: span 6 / auto;">
            <div class="content">
                <div class="wcpfc-table-title">
                    <span class="wcpfc-title"><?php esc_html_e( 'Revenue Breakdown', 'woocommerce-conditional-product-fees-for-checkout' ); ?></span>
                    <button class="button primary export-all-fees"><?php esc_html_e( 'Export CSV', 'woocommerce-conditional-product-fees-for-checkout' ); ?></button>
                </div>
                <div class="wcpfc-table">
                    <div class="wcpfc-table-header">
                        <div class="wcpfc-table-label"><?php esc_html_e( 'No', 'woocommerce-conditional-product-fees-for-checkout' ); ?>.</div>
                        <div class="wcpfc-table-label"><?php esc_html_e( 'Fee Name', 'woocommerce-conditional-product-fees-for-checkout' ); ?></div>
                        <div class="wcpfc-table-label"><?php esc_html_e( 'Revenue', 'woocommerce-conditional-product-fees-for-checkout' ); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wcpfc-top-ten wcpfc-main-chart" style="grid-column: span 6 / auto;">
            <div class="content">
                <div class="wcpfc-chart-title">
                    <span class="wcpfc-chart-title-text"><?php esc_html_e( 'Top 10 Fees', 'woocommerce-conditional-product-fees-for-checkout' ); ?></span>
                </div>
                <div class="topFeeChart-wrap">
                    <canvas id="topFeeChart"></canvas>
                </div>
                <div class="wcpfc-chart-legend">
                </div>
            </div>
        </div>
    </div>
</div>
