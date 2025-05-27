<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
die;
}
require_once plugin_dir_path( __FILE__ ) . 'trustindex-plugin.class.php';
$trustindex_pm_yelp = new TrustindexPlugin_yelp("yelp", __FILE__, "12.7.5", "Widgets for Yelp Reviews", "Yelp");
$trustindex_pm_yelp->uninstall();
?>