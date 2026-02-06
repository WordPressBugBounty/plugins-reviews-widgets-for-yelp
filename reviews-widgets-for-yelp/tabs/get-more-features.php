<?php
defined('ABSPATH') or die('No script kiddies please!');
?>
<h1 class="ti-header-title"><?php echo esc_html(__('Get more Features', 'reviews-widgets-for-yelp')); ?></h1>
<div class="ti-box">
<div class="ti-box-header"><?php echo esc_html(__('Skyrocket Your Sales with Customer Reviews', 'reviews-widgets-for-yelp')); ?></div>
<p class="ti-bold">
<?php
/* translators: %s: user number (800.000) */
echo esc_html(sprintf(__('%s+ WordPress websites use Trustindex to embed reviews fast and easily.', 'reviews-widgets-for-yelp'), '800.000'));
?><br />
<?php echo esc_html(__('Increase SEO, trust and sales using customer reviews.', 'reviews-widgets-for-yelp')); ?>
</p>
<div class="ti-section-title"><?php echo esc_html(__('Top Features', 'reviews-widgets-for-yelp')); ?></div>
<ul class="ti-check-list">
<li><?php echo esc_html(__('Display unlimited number of reviews', 'reviews-widgets-for-yelp')); ?></li>
<li><?php echo esc_html(__('Create unlimited number of widgets', 'reviews-widgets-for-yelp')); ?></li>
<li><?php echo esc_html(__('Display reviews with photos', 'reviews-widgets-for-yelp')); ?></li>
<li><?php
/* translators: %d: platform number */
echo esc_html(sprintf(__('%d review platforms', 'reviews-widgets-for-yelp'), 137));
?></li>
<li><?php echo esc_html(__('Mix reviews from different platforms', 'reviews-widgets-for-yelp')); ?></li>
<li><?php echo esc_html(__('Get more reviews', 'reviews-widgets-for-yelp')); ?></li>
<li><?php echo esc_html(__('Manage all reviews in one place', 'reviews-widgets-for-yelp')); ?></li>
<li><?php echo esc_html(__('Automatically update with NEW reviews', 'reviews-widgets-for-yelp')); ?></li>
</ul>
<?php echo wp_kses_post($pluginManagerInstance->getProFeatureButton('wp-yelp-3')); ?>
<div class="ti-special-offer">
<img src="<?php echo esc_url($pluginManagerInstance->get_plugin_file_url('static/img/special_30.jpg')); ?>">
<p><?php echo esc_html(str_replace('%%', '%', __('Now we offer you a 30%% discount off for your first subscription! Create your free account and benefit from the onboarding discount now!', 'reviews-widgets-for-yelp'))); ?></p>
<div class="clear"></div>
</div>
</div>
