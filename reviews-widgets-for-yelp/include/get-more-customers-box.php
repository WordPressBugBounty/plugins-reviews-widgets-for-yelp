<?php
defined('ABSPATH') or die('No script kiddies please!');
?>
<h1 class="ti-header-title ti-mt-2"><?php echo esc_html(__('Want to get more customers?', 'reviews-widgets-for-yelp')); ?></h1>
<div class="ti-box">
<div class="ti-box-header"><?php echo esc_html(__('Increase SEO, trust and sales using customer reviews.', 'reviews-widgets-for-yelp')); ?></div>
<?php echo wp_kses_post($pluginManagerInstance->getProFeatureButton($tiCampaign1)); ?>
<ul class="ti-seo-list">
<li>
<strong><?php echo esc_html(__('Display unlimited number of reviews', 'reviews-widgets-for-yelp')); ?></strong><br />
<?php echo esc_html(__('You can test Trustindex with 10 reviews in the free version. Upgrade to Business to display ALL the reviews received. Be the undisputed customer choice in your industry!', 'reviews-widgets-for-yelp')); ?>
</li>
<li>
<strong><?php echo esc_html(__('Create unlimited number of widgets', 'reviews-widgets-for-yelp')); ?></strong><br />
<?php echo esc_html(__('Use the widgets matching your page the best to build trust.', 'reviews-widgets-for-yelp')); ?>
</li>
<li>
<strong><?php echo esc_html(__('Display reviews with photos', 'reviews-widgets-for-yelp')); ?></strong><br />
<?php echo esc_html(__('Boost engagement by displaying customer photos in an interactive popup slider, bringing real experiences to life.', 'reviews-widgets-for-yelp')); ?>
</li>
<li>
<strong><?php
/* translators: %d: number */
echo esc_html(sprintf(__("%d review platforms", 'reviews-widgets-for-yelp'), 137));
?></strong><br />
<?php
/* translators: %s: platform list */
echo esc_html(sprintf(__("Add more reviews to your widget from %s, etc. to enjoy more trust, and to keep customers on your site.", 'reviews-widgets-for-yelp'), 'Google, Facebook, Yelp, Amazon, Tripadvisor, Booking.com, Airbnb, Hotels.com, Capterra, Foursquare, Opentable'));
?><br />
<img src="<?php echo esc_url($pluginManagerInstance->get_plugin_file_url('static/img/platforms.png')); ?>" alt="" style="margin-top: 5px" />
</li>
<li>
<strong><?php echo esc_html(__('Mix Reviews', 'reviews-widgets-for-yelp')); ?></strong><br />
<?php echo esc_html(__('You can mix your reviews from different platforms and display them in 1 review widget.', 'reviews-widgets-for-yelp')); ?>
</li>
<li>
<strong><?php echo esc_html(__('Get more reviews', 'reviews-widgets-for-yelp')); ?></strong><br />
<?php echo esc_html(__('Use our Review Invitation System to collect hundreds of new reviews. Become impossible to resist!', 'reviews-widgets-for-yelp')); ?>
</li>
<li>
<strong><?php echo esc_html(__('Manage all reviews in one place', 'reviews-widgets-for-yelp')); ?></strong><br />
<?php echo esc_html(__('Turn on email alert to ALL new reviews, so that you can manage them quickly.', 'reviews-widgets-for-yelp')); ?>
</li>
<li>
<strong><?php echo esc_html(__('Automatically update with NEW reviews', 'reviews-widgets-for-yelp')); ?></strong><br />
<?php echo esc_html(__('Wordpress cannot update reviews, but Trustindex can! As soon as you get a new review, Trustindex Business can automatically add it to your website. Customers love fresh reviews!', 'reviews-widgets-for-yelp')); ?>
</li>
</ul>
<?php echo wp_kses_post($pluginManagerInstance->getProFeatureButton($tiCampaign2)); ?>
<div class="ti-special-offer">
<img src="<?php echo esc_url($pluginManagerInstance->get_plugin_file_url('static/img/special_30.jpg')); ?>">
<p><?php echo esc_html(str_replace('%%', '%', __('Now we offer you a 30%% discount off for your first subscription! Create your free account and benefit from the onboarding discount now!', 'reviews-widgets-for-yelp'))); ?></p>
<div class="clear"></div>
</div>
</div>
