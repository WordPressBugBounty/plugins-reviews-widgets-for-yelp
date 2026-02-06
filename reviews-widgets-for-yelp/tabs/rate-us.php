<?php
defined('ABSPATH') or die('No script kiddies please!');
wp_enqueue_script('trustindex-js', 'https://cdn.trustindex.io/loader.js', [], true, true);
?>
<h1 class="ti-header-title"><?php echo esc_html(__('Rate Us', 'reviews-widgets-for-yelp')); ?></h1>
<div class="ti-box">
<div class="ti-box-header"><?php echo esc_html(__('Do you like our free plugin?', 'reviews-widgets-for-yelp')); ?></div>
<p>
<?php echo esc_html(__("We've spent a lot of time developing this software. If you use the free version, you can still support us by leaving a review!", 'reviews-widgets-for-yelp')); ?><br />
<?php echo esc_html(__('Thank you in advance!', 'reviews-widgets-for-yelp')); ?>
</p>
<a class="ti-btn" href="https://wordpress.org/support/plugin/<?php echo esc_attr($pluginManagerInstance->get_plugin_slug()); ?>/reviews/?rate=5#new-post" target="_blank"><?php echo esc_html(__('Click here to rate us!', 'reviews-widgets-for-yelp')); ?></a>
<div class="ti-box-footer">
<div data-src='https://cdn.trustindex.io/loader.js?<?php echo '9f6bbb588d356219ce50754535'; ?>'></div>
</div>
</div>
