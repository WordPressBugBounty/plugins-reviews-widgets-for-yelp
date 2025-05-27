<?php
/*
Plugin Name: Widgets for Yelp Reviews
Plugin Title: Widgets for Yelp Reviews Plugin
Plugin URI: https://wordpress.org/plugins/reviews-widgets-for-yelp/
Description: Embed Yelp reviews fast and easily into your WordPress site. Increase SEO, trust and sales using Yelp reviews.
Tags: yelp reviews, reviews, yelp, ratings, widget
Author: Trustindex.io <support@trustindex.io>
Author URI: https://www.trustindex.io/
Contributors: trustindex
License: GPLv2 or later
Version: 12.7.5
Requires at least: 6.2
Requires PHP: 7.0
Text Domain: reviews-widgets-for-yelp
Domain Path: /languages
Donate link: https://www.trustindex.io/prices/
*/
/*
Copyright 2019 Trustindex Kft (email: support@trustindex.io)
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
require_once plugin_dir_path(__FILE__) . 'include' . DIRECTORY_SEPARATOR . 'cache-plugin-filters.php';
require_once plugin_dir_path(__FILE__) . 'trustindex-plugin.class.php';
$trustindex_pm_yelp = new TrustindexPlugin_yelp("yelp", __FILE__, "12.7.5", "Widgets for Yelp Reviews", "Yelp");
$pluginManager = 'TrustindexPlugin_yelp';
$pluginManagerInstance = $trustindex_pm_yelp;
add_action('admin_init', function() { ob_start(); });
register_activation_hook(__FILE__, [ $pluginManagerInstance, 'activate' ]);
register_deactivation_hook(__FILE__, [ $pluginManagerInstance, 'deactivate' ]);
add_action('plugins_loaded', [ $pluginManagerInstance, 'load' ]);
add_action('wp_insert_site', function($site) use($pluginManagerInstance) {
switch_to_blog($site->blog_id);
$tiReviewsTableName = $pluginManagerInstance->get_tablename('reviews');
include $pluginManagerInstance->get_plugin_dir() . 'include' . DIRECTORY_SEPARATOR . 'schema.php';
foreach (array_keys($ti_db_schema) as $tableName) {
if (!$pluginManagerInstance->is_table_exists($tableName)) {
dbDelta(trim($ti_db_schema[ $tableName ]));
}
}
restore_current_blog();
});
add_action('admin_menu', [ $pluginManagerInstance, 'add_setting_menu' ], 10);
add_filter('plugin_action_links', [ $pluginManagerInstance, 'add_plugin_action_links' ], 10, 2);
add_filter('plugin_row_meta', [ $pluginManagerInstance, 'add_plugin_meta_links' ], 10, 2);
if (!function_exists('register_block_type')) {
add_action('widgets_init', [ $pluginManagerInstance, 'init_widget' ]);
add_action('widgets_init', [ $pluginManagerInstance, 'register_widget' ]);
}
add_action('init', function() {
wp_register_script('trustindex-loader-js', 'https://cdn.trustindex.io/loader.js', [], null, [
'strategy' => 'async',
'in_footer' => true,
]);
});
add_action('init', [ $pluginManagerInstance, 'init_shortcode' ]);
add_action('elementor/controls/controls_registered', function($controlsManager) {
require_once(__DIR__ . '/include/elementor-widgets.php');
$controlsManager->register_control('choose', new \Elementor\Control_Choose2());
});
add_action('elementor/widgets/widgets_registered', function ($widgetsManager) use ($pluginManagerInstance) {
require_once(__DIR__ . '/include/elementor-widgets.php');
$widgetsManager->register(new \Elementor\TrustrindexElementorWidget_Yelp([], [$pluginManagerInstance]));
});
add_action('init', [ $pluginManagerInstance, 'register_tinymce_features' ]);
add_action('wp_ajax_list_trustindex_widgets', [ $pluginManagerInstance, 'list_trustindex_widgets_ajax' ]);
add_action('admin_enqueue_scripts', [ $pluginManagerInstance, 'trustindex_add_scripts' ]);
add_action('rest_api_init', [ $pluginManagerInstance, 'init_restapi' ]);
if (class_exists('Woocommerce') && !class_exists('TrustindexCollectorPlugin') && !function_exists('ti_woocommerce_notice')) {
function ti_woocommerce_notice() {
global $pluginManager;
if (!current_user_can($pluginManager::$permissionNeeded)) {
return;
}
$wcNotification = get_option('trustindex-wc-notification', time() - 1);
if ($wcNotification == 'hide' || (int)$wcNotification > time()) {
return;
}
?>
<div class="notice notice-warning is-dismissible" style="margin: 5px 0 15px">
<p><strong><?php echo sprintf(__("Download our new <a href='%s' target='_blank'>%s</a> plugin and get features for free!", 'trustindex-plugin'), 'https://wordpress.org/plugins/customer-reviews-collector-for-woocommerce/', 'Customer Reviews Collector for WooCommerce'); ?></strong></p>
<ul style="list-style-type: disc; margin-left: 10px; padding-left: 15px">
<li><?php echo __('Send unlimited review invitations for free', 'trustindex-plugin'); ?></li>
<li><?php echo __('E-mail templates are fully customizable', 'trustindex-plugin'); ?></li>
<li><?php echo __('Collect reviews on 100+ review platforms (Google, Facebook, Yelp, etc.)', 'trustindex-plugin'); ?></li>
</ul>
<p>
<a href="<?php echo admin_url("admin.php?page=reviews-widgets-for-yelp/settings.php&wc_notification=open"); ?>" target="_blank" class="trustindex-rateus" style="text-decoration: none">
<button class="button button-primary"><?php echo __('Download plugin', 'trustindex-plugin'); ?></button>
</a>
<a href="<?php echo admin_url("admin.php?page=reviews-widgets-for-yelp/settings.php&wc_notification=hide"); ?>" class="trustindex-rateus" style="text-decoration: none">
<button class="button button-secondary"><?php echo __('Do not remind me again', 'trustindex-plugin'); ?></button>
</a>
</p>
</div>
<?php
}
add_action('admin_notices', 'ti_woocommerce_notice');
}


add_action('wp_ajax_nopriv_'. $pluginManagerInstance->getWebhookAction(), function() use ($pluginManagerInstance) {
$token = isset($_POST['token']) ? sanitize_text_field($_POST['token']) : "";
if (isset($_POST['test']) && $token === get_option($pluginManagerInstance->get_option_name('review-download-token'))) {
echo $token;
exit;
}
$ourToken = $pluginManagerInstance->is_review_download_in_progress();
if (!$ourToken) {
$ourToken = get_option($pluginManagerInstance->get_option_name('review-download-token'));
}
try {
if (!$token || $ourToken !== $token) {
throw new Exception('Token invalid');
}
if (!$pluginManagerInstance->is_noreg_linked() || !$pluginManagerInstance->is_table_exists('reviews')) {
throw new Exception('Platform not connected');
}
$name = 'Unknown source';
if (isset($_POST['error']) && $_POST['error']) {
update_option($pluginManagerInstance->get_option_name('review-download-inprogress'), 'error', false);
}
else {
if (isset($_POST['details'])) {
$pluginManagerInstance->save_details($_POST['details']);
$pluginManagerInstance->save_reviews(isset($_POST['reviews']) ? $_POST['reviews'] : []);
}
delete_option($pluginManagerInstance->get_option_name('review-download-inprogress'));
delete_option($pluginManagerInstance->get_option_name('review-manual-download'));
}
update_option($pluginManagerInstance->get_option_name('download-timestamp'), time() + (86400 * 10), false);
$pluginManagerInstance->setNotificationParam('review-download-available', 'do-check', true);
$isConnecting = get_option($pluginManagerInstance->get_option_name('review-download-is-connecting'));
if (!$isConnecting && !$pluginManagerInstance->getNotificationParam('review-download-finished', 'hidden')) {
$pluginManagerInstance->setNotificationParam('review-download-finished', 'active', true);
}
delete_option($pluginManagerInstance->get_option_name('review-download-is-connecting'));
if (!$pluginManagerInstance->getNotificationParam('review-download-available', 'hidden')) {
$pluginManagerInstance->setNotificationParam('review-download-available', 'do-check', true);
$pluginManagerInstance->setNotificationParam('review-download-available', 'active', false);
}
if (!$isConnecting) {
$pluginManagerInstance->sendNotificationEmail('review-download-finished');
}
echo $ourToken;
}
catch(Exception $e) {
echo 'Error in WP: '. $e->getMessage();
}
exit;
});
add_action('admin_notices', function() use ($pluginManager, $pluginManagerInstance) {
if (!current_user_can($pluginManager::$permissionNeeded)) {
return;
}
foreach ($pluginManagerInstance->getNotificationOptions() as $type => $options) {
if (!$pluginManagerInstance->isNotificationActive($type)) {
continue;
}
echo '<div class="notice notice-'. esc_attr($options['type']) .' '. ($options['is-closeable'] ? 'is-dismissible' : '') .' trustindex-notification-row '. $options['extra-class'].'" data-close-url="'. admin_url('admin.php?page='. $pluginManagerInstance->get_plugin_slug() .'/settings.php&notification='. $type .'&action=close') .'">';
if ($type === 'rate-us') {
echo '<div class="trustindex-star-row">&starf;&starf;&starf;&starf;&starf;</div>';
}
echo '<p>'. wp_kses_post($options['text']) .'<p>';
if ($type === 'rate-us') {
echo '
<a href="'. esc_url(admin_url('admin.php?page='. $pluginManagerInstance->get_plugin_slug() .'/settings.php&notification='. $type .'&action=open')) .'" class="ti-close-notification" target="_blank">
<button class="button ti-button-primary button-primary">'. esc_html(__('Write a review', 'trustindex-plugin')) .'</button>
</a>
<a href="'. esc_url(admin_url('admin.php?page='. $pluginManagerInstance->get_plugin_slug() .'/settings.php&notification='. $type .'&action=later')) .'" class="ti-remind-later">
'. esc_html(__('Maybe later', 'trustindex-plugin')) .'
</a>
<a href="'. esc_url(admin_url('admin.php?page='. $pluginManagerInstance->get_plugin_slug() .'/settings.php&notification='. $type .'&action=hide')) .'" class="ti-hide-notification" style="float: right; margin-top: 14px">
'. esc_html(__('Do not remind me again', 'trustindex-plugin')) .'
</a>
';
}
else {
echo '
<a href="'. esc_url(admin_url('admin.php?page='. $pluginManagerInstance->get_plugin_slug() .'/settings.php&notification='. $type .'&action=open')) .'">
<button class="button button-primary">'. esc_html($options['button-text']) .'</button>
</a>';
if ($options['remind-later-button']) {
echo '
<a href="'. esc_url(admin_url('admin.php?page='. $pluginManagerInstance->get_plugin_slug() .'/settings.php&notification='. $type .'&action=later')) .'" class="ti-remind-later" style="margin-left: 5px">
'. esc_html(__('Remind me later', 'trustindex-plugin')) .'
</a>';
}
}
echo '
</p>
</div>';
}
});
unset($pluginManagerInstance);
?>
