=== Extra Fees Plugin for WooCommerce ===
Contributors: dots,kakshak,dency,jariwalasagar
Tags: cart fee, category, e-commerce, Extra Charge, woocommerce extra cost, extra fee, minimum order,surcharge,woocommerce extra fee, woocommerce additional fees,woocommerce checkout plugin,woocommerce conditional shipping fees,woocommerce conditional, woocommerce shipping classes fees, woocommerce fees, woocommerce add shipping method fees, woocommerce extra cost, woocommerce additional cost, Woocommerce advanced fees
Requires at least: 5.0
Tested up to: 6.1.1
WC tested up to: 7.3.0
Requires PHP: 7.2
Stable tag: 3.9.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Here is a short description of the plugin.  This should be no more than 150 characters.  No markup here.

== Description ==

This is the long description.  No limit, and you can use Markdown (as well as in the following sections).

For backwards compatibility, if this section is missing, the full length of the short description will be used, and
Markdown parsed.

A few notes about the sections above:

*   "Contributors" is a comma separated list of wp.org/wp-plugins.org usernames
*   "Tags" is a comma separated list of tags that apply to the plugin
*   "Requires at least" is the lowest version that the plugin will work on
*   "Tested up to" is the highest version that you've *successfully used to test the plugin*. Note that it might work on
higher versions... this is just the highest one you've verified.
*   Stable tag should indicate the Subversion "tag" of the latest stable version, or "trunk," if you use `/trunk/` for
stable.

    Note that the `readme.txt` of the stable tag is the one that is considered the defining one for the plugin, so
if the `/trunk/readme.txt` file says that the stable tag is `4.3`, then it is `/tags/4.3/readme.txt` that'll be used
for displaying information about the plugin.  In this situation, the only thing considered from the trunk `readme.txt`
is the stable tag pointer.  Thus, if you develop in trunk, you can update the trunk `readme.txt` to reflect changes in
your in-development version, without having that information incorrectly disclosed about the current stable version
that lacks those changes -- as long as the trunk's `readme.txt` points to the correct stable tag.

    If no stable tag is provided, it is assumed that trunk is stable, but you should specify "trunk" if that's where
you put the stable version, in order to eliminate any doubt.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `woocommerce-conditional-product-fees-for-checkout.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php do_action('plugin_name_hook'); ?>` in your templates

== Frequently Asked Questions ==

= A question that someone might have =

An answer to that question.

= What about foo bar? =

Answer to foo bar dilemma.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==
= 3.9.2.1 - 31-01-2023 =
* Fixed - Apply per additional quantity not calculate for variable products

= 3.9.2 - 24-01-2023 =
* New - Introduce WP-CLI commands check list here
* New - Ability for user to select optional fees as checkbox/dropdown at checkout
* New - Allows the admin to add a detailed note for optional fees
* Fixed - Shipping Class same as a parent doesn't apply extra fee rule for variations
* Fixed - Add validation to prevent the same fee title
* Fixed - Coupon with "Select all" option with conditions "not equal" not working
* Fixed - Minor bugs fixes
* Enhancement - WPML translation compatibility
* Update – Compatible with WooCommerce 7.3.x
* Update – Compatible with WordPress 6.1.x

= 3.9.1 - 08-11-2022 =
* Fix - Miner bug fixes
* Update – Compatible with WooCommerce 7.1.0
* Update – Compatible with WordPress 6.1

= 3.9.0 - 18-10-2022 =
* New - Add attribute specific fee feature
* Enhancement – Update UI changes
* Enhancement – Minor bug fixes 
* Enhancement - Add variation ID in the search rule section
* Enhancement - Include category and tag which are added in the private product
* Fix - Recursive fee not work
* Update – Compatible with WooCommerce 7.0.0
* Update – Compatible with WordPress 6.0.2

= 3.8.4 - 30-08-2022 =
* Update – Compatible with WooCommerce 6.8.2
* Update – Compatible with WordPress 6.0.1
* Update - Compatible with PHP 8.0.0
* Enhancement - Compatible with YITH product bundle plugin
* Enhancement - Once products are private no categories or tags are listed in the rules.
* Enhancement - Cart contains variable product > no #id with a variation title issue
* Enhancement - Security enhancement
* Fixed - Optional fee not added on order after placing an order
* Fixed - Display two extra fees once the WooCommerce AvaTax plugin is activated
* Fixed - Minor bugs

= 3.8.3 - 12-04-2022 =
* Fixed - Increase site load time while using tooltip
* Fixed - Cost field as percentage now accepts the decimal number
* Enhancement - Premium plugin activate then the free plugin will automatically deactivate
* Update - Tooltip description now limited to 25 characters only
* Update – Compatible with WooCommerce 6.4.1
* Update – Compatible with WordPress 5.9.3

= 3.8.2 - 04-03-2022 =
* Fixed – Minor bugs
* Enhancement - Security of plugin
* Update – Compatible with WooCommerce 6.2.1
* Update – Compatible with WordPress 5.9.1

= 3.8.1 - 25-01-2022 =
* New - Product Specific percentage-based fees in "Advanced Fees Price Rules - Cost on product" section
* Enhancement - Now user can choose all coupons with "Select All" option
* Update - Compatible with <a href="https://wordpress.org/plugins/flexible-shipping/" target="_blank">Table Rate Shipping Method for WooCommerce by Flexible Shipping</a>
* Update - Compatible with <a href="https://wordpress.org/plugins/wc-vendors/" target="_blank">WC Vendors Marketplace</a>
* Update - Compatible with <a href="https://wordpress.org/plugins/woo-extra-flat-rate/" target="_blank">Flat Rate Shipping Plugin For WooCommerce</a>
* Update - Compatible with <a href="https://wordpress.org/plugins/weight-based-shipping-for-woocommerce/" target="_blank">WooCommerce Weight Based Shipping</a>
* Update - Compatible with <a href="https://wordpress.org/plugins/woocommerce-easy-table-rate-shipping/" target="_blank">Table Rate Shipping for WooCommerce</a>
* Update - Compatible with <a href="https://wordpress.org/plugins/woocommerce-apg-weight-and-postcodestatecountry-shipping/" target="_blank">WC – APG Weight Shipping</a>
* Update - Compatible with <a href="https://tablerateshipping.com" target="_blank">Tree Table Rate Shipping</a>
* Update – Compatible with WooCommerce 6.1.1
* Update – Compatible with WordPress 5.9
* Fixed – Minor bugs

= 3.8 - 28-12-2021 =
* Enhancement - Before dashboard introduce fees can calculate on dashboard
* New - Fee can only show up on checkout setting
* New - Sort fee by name, fee's amount on listing
* New - Allow to add wild cards as parameters in price textbox
* New - Allow to make minimum and maximum fee shortcode in price textbox
* New - Allow to add time-specific extra fees
* New - Allow to apply percent fees on cart total amount
* New - Allow day specific extra fees
* Update – Compatible with WooCommerce 6.0.0
* Update – Compatible with WordPress 5.8.2
* Fixed – Minor bugs

= 3.7.1 - 08-10-2021 =
* Fixed - Minor bug fixed related to undefined function is_cart()
* Fixed - Minor bug fixed related to per product quantity with category option

= 3.7.0 - 07-10-2021 =
* New – Dashboard with chart for fees' revenue
* New – Option for specific product subtotal with price limit
* New – Option for city specific fee display
* New – Added taxable option for all fees' merge
* New – Tooltip option for all fees' merge
* New – Option to enable fee for first order of user
* New – Option for default apply optional fee on checkout
* Enhancement – enabled general conditional fee rule for optional fee
* Update – Compatible with WooCommerce 5.7.x
* Update – Compatible with WordPress 5.8.x
* Fixed  – Minor bugs

= 3.6.6 - 07-09-2021 =
* Enhancement – Fixed minor issue related to add filter('wcpfc_tax_class') for default tax class to merge fee option
* Enhancement – UI enhancement
* Enhancement – Compatible with WooCommerce Product Bundles
* Enhancement – Compatible with YITH WooCommerce Product Bundles
* Fixed - Minor bug
* Update – Compatible with WooCommerce 5.6.x
* Update – Compatible with WordPress 5.8.x

= 3.6.5 - 17-08-2021 =
* Fixed - Once multiple optional fee available then only showcase the first fee price
* Compatible with WooCommerce 5.6.x
* Compatible with WordPress 5.8.x

= 3.6.4 - 28-04-2021 =
* Fixed - Same variation with multiple option not working with per product additional fee
* New   - Per weight charges
* New   - UPS compatible with filter

= 3.6.3 - 28-04-2021 =
* Fixed - Compatible with Loco Translation
* Fixed - Pagination navigation issue
* Fixed - Minor bug fixed
* Compatible with WooCommerce 5.2.x
* Compatible with WordPress 5.7.x

= 3.6.2 - 28-01-2021 =
* Compatible with WooCommerce 5.0.x
* Compatible with WordPress 5.6.x
* New: Added product specific quantity rules

= 3.6.1 - 28-01-2021 =
* Compatible with WooCommerce 4.9.x
* Compatible with WordPress 5.6.x

= 3.6 - 12-03-2020 =
* Fixed - Advanced Fees Price Rules with Cost on Product Subtotal not allow to save in admin.
* Fixed - Font awesome CSS confliction on front side. 
* Fixed - Additional quantity price for variable product wrong calculation
* Fixed - User based role not working for guest user.  

= 3.5.3 - 25-11-2020 =
* Fixed - Minor bug fixed

= 3.5 =
* Fixed - Once zone != operator selected then fees display without postcode entered.
* Fixed - Once edit the fee no variable products searching
* New - Optional fee

= 3.4 - 28-04-2020 =
* New - Global settings - Display all fee in one label.
* Compatible with WooCommerce 4.0.x
* Compatible with WordPress 5.4.x

= 3.3 - 18-03-2020 =
* Fixed - Once multiple postcodes added only last postcode works.
* New: Added master settings to hide all the fees once 100% discount applies.

= 3.2 = 17-12-2019
* Fixed - minor bug fixing

= 3.1 = 21-11-2019
* New - AND/OR rule in General Shipping Rule
* New - AND/OR rule in Particular advance shipping rule
* New - Advance shipping cost based on Category subtotal
* New - Advance shipping cost based on Product subtotal
* New - Advance shipping cost based on Shipping class subtotal
* New - Import Export shipping method with json file
* New - Deactivate plugin automatically when deactivate WooCommerce
* New - Freemius for both plugin free and pro
* Fixed - Validation for Max qty/weight/subtotal in admin side 
* Fixed - Advance Pricing Rules is not working when you set normal condition fee rule as Cart SubTotal ( before discount ) and Cart SubTotal ( after discount )
* Fixed - New fees order not properly
* Fixed - Zone with Postcode range not working.
* Fixed - Multiple product qty count for multiple category with same product
* Compatible with WordPress 5.3.x and WooCommerce 3.8.x

= 1.5.2 = 17-09-2019
* Compatible with WPML

= 1.5.1 =
* Fixed - Zone issue

= 1.5 =
* VIP minimum - Included with all version.
* Compatible with WooCommerce 3.7.x

= 1.0 =
* A change since the previous version.
* Another change.

= 0.5 =
* List versions from most recent at top to oldest at bottom.

== Upgrade Notice ==

= 1.0 =
Upgrade notices describe the reason a user should upgrade.  No more than 300 characters.

= 0.5 =
This version fixes a security related bug.  Upgrade immediately.

== Arbitrary section ==

You may provide arbitrary sections, in the same format as the ones above.  This may be of use for extremely complicated
plugins where more information needs to be conveyed that doesn't fit into the categories of "description" or
"installation."  Arbitrary sections will be shown below the built-in sections outlined above.

== A brief Markdown Example ==

Ordered list:

1. Some feature
1. Another feature
1. Something else about the plugin

Unordered list:

* something
* something else
* third thing

Here's a link to [WordPress](http://wordpress.org/ "Your favorite software") and one to [Markdown's Syntax Documentation][markdown syntax].
Titles are optional, naturally.

[markdown syntax]: http://daringfireball.net/projects/markdown/syntax
            "Markdown is what the parser uses to process much of the readme file"

Markdown uses email style notation for blockquotes and I've been told:
> Asterisks for *emphasis*. Double it up  for **strong**.

`<?php code(); // goes in backticks ?>`