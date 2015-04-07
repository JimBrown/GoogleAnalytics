<?php
/**
 * google_analytics -- Places the tracking registation code for google analytics in a photo gallery.
 * This code was modeled after the google_maps plugin by Dustin Brewer (mankind) and Stephen Billard (sbillard)
 *
 * Plugin Option 'analyticsId' is used to supply the site Google Analytics Web Property ID.
 * Plugin Option 'admintracking' is used to enable Google Analytics tracking for admin users.
 *        If selected then the Google Analytics tracking code in inserted for admin users.
 *
 */

$plugin_is_filter = 5 | THEME_PLUGIN;
$plugin_description = gettext("Support for providing Google Analytics tracking");
$option_interface = "google_analyticsOptions";

zp_register_filter('theme_head', 'printGoogleAnalyticsHeader');

/**
 * insert the google analytics tracking code
 *
 */
function printGoogleAnalyticsHeader() {
	$analyticskey = getOption('analyticsId');
	if (!empty($analyticskey) && ((zp_loggedin() && getOption('admintracking')) || !zp_loggedin())) {
		?>
		<script type="text/javascript">
    /* Google Analytics */
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', '<?php echo $analyticskey ?>', 'auto');
		ga('send', 'pageview');

		</script>
		<?php
	}
}
/**
 * Plugin option handling class
 *
 */
class google_analyticsOptions {

	function google_analyticsOptions() {
		setOptionDefault('analyticsId', 'UA-xxxxxx-x');
		setOptionDefault('admintracking', 0);
	}

	function getOptionsSupported() {
		return array(  gettext('Google Analytics Web Property ID') => array(
									'order' => 0,
									'key' => 'analyticsId',
									'type' => OPTION_TYPE_TEXTBOX,
									'desc' => gettext("If you're going to be using Google Analytics,").' <a	href="http://www.google.com/analytics/" target="_blank"> '.gettext("get a Web Property ID</a> and enter it here.")
						),
						gettext('Enable Admin tracking') => array (
									'order' => 1,
									'key' => 'admintracking',
									'type' => OPTION_TYPE_CHECKBOX,
									'desc' => gettext('Controls if you want Google Analytics tracking for users logged in as admin. Default is not selected.')
						),
		);
	}

	function handleOption($option, $currentValue) {}
}
?>