<?php

/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

define('HELLO_ELEMENTOR_VERSION', '2.8.1');

if (!isset($content_width)) {
	$content_width = 800; // Pixels.
}

if (!function_exists('hello_elementor_setup')) {
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function hello_elementor_setup()
	{
		if (is_admin()) {
			hello_maybe_update_theme_version_in_db();
		}

		if (apply_filters('hello_elementor_register_menus', true)) {
			register_nav_menus(['menu-1' => esc_html__('Header', 'hello-elementor')]);
			register_nav_menus(['menu-2' => esc_html__('Footer', 'hello-elementor')]);
		}

		if (apply_filters('hello_elementor_post_type_support', true)) {
			add_post_type_support('page', 'excerpt');
		}

		if (apply_filters('hello_elementor_add_theme_support', true)) {
			add_theme_support('post-thumbnails');
			add_theme_support('automatic-feed-links');
			add_theme_support('title-tag');
			add_theme_support(
				'html5',
				[
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
					'script',
					'style',
				]
			);
			add_theme_support(
				'custom-logo',
				[
					'height'      => 100,
					'width'       => 350,
					'flex-height' => true,
					'flex-width'  => true,
				]
			);

			/*
			 * Editor Style.
			 */
			add_editor_style('classic-editor.css');

			/*
			 * Gutenberg wide images.
			 */
			add_theme_support('align-wide');

			/*
			 * WooCommerce.
			 */
			if (apply_filters('hello_elementor_add_woocommerce_support', true)) {
				// WooCommerce in general.
				add_theme_support('woocommerce');
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support('wc-product-gallery-zoom');
				// lightbox.
				add_theme_support('wc-product-gallery-lightbox');
				// swipe.
				add_theme_support('wc-product-gallery-slider');
			}
		}
	}
}
add_action('after_setup_theme', 'hello_elementor_setup');

function hello_maybe_update_theme_version_in_db()
{
	$theme_version_option_name = 'hello_theme_version';
	// The theme version saved in the database.
	$hello_theme_db_version = get_option($theme_version_option_name);

	// If the 'hello_theme_version' option does not exist in the DB, or the version needs to be updated, do the update.
	if (!$hello_theme_db_version || version_compare($hello_theme_db_version, HELLO_ELEMENTOR_VERSION, '<')) {
		update_option($theme_version_option_name, HELLO_ELEMENTOR_VERSION);
	}
}

if (!function_exists('hello_elementor_scripts_styles')) {
	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	function hello_elementor_scripts_styles()
	{
		$min_suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		if (apply_filters('hello_elementor_enqueue_style', true)) {
			wp_enqueue_style(
				'hello-elementor',
				get_template_directory_uri() . '/style' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if (apply_filters('hello_elementor_enqueue_theme_style', true)) {
			wp_enqueue_style(
				'hello-elementor-theme-style',
				get_template_directory_uri() . '/theme' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}
	}
}
add_action('wp_enqueue_scripts', 'hello_elementor_scripts_styles');

if (!function_exists('hello_elementor_register_elementor_locations')) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function hello_elementor_register_elementor_locations($elementor_theme_manager)
	{
		if (apply_filters('hello_elementor_register_elementor_locations', true)) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action('elementor/theme/register_locations', 'hello_elementor_register_elementor_locations');

if (!function_exists('hello_elementor_content_width')) {
	/**
	 * Set default content width.
	 *
	 * @return void
	 */
	function hello_elementor_content_width()
	{
		$GLOBALS['content_width'] = apply_filters('hello_elementor_content_width', 800);
	}
}
add_action('after_setup_theme', 'hello_elementor_content_width', 0);

if (is_admin()) {
	require get_template_directory() . '/includes/admin-functions.php';
}

/**
 * If Elementor is installed and active, we can load the Elementor-specific Settings & Features
 */

// Allow active/inactive via the Experiments
require get_template_directory() . '/includes/elementor-functions.php';

/**
 * Include customizer registration functions
 */
function hello_register_customizer_functions()
{
	if (is_customize_preview()) {
		require get_template_directory() . '/includes/customizer-functions.php';
	}
}
add_action('init', 'hello_register_customizer_functions');

if (!function_exists('hello_elementor_check_hide_title')) {
	/**
	 * Check hide title.
	 *
	 * @param bool $val default value.
	 *
	 * @return bool
	 */
	function hello_elementor_check_hide_title($val)
	{
		if (defined('ELEMENTOR_VERSION')) {
			$current_doc = Elementor\Plugin::instance()->documents->get(get_the_ID());
			if ($current_doc && 'yes' === $current_doc->get_settings('hide_title')) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter('hello_elementor_page_title', 'hello_elementor_check_hide_title');

if (!function_exists('hello_elementor_add_description_meta_tag')) {
	/**
	 * Add description meta tag with excerpt text.
	 *
	 * @return void
	 */
	function hello_elementor_add_description_meta_tag()
	{
		$post = get_queried_object();

		if (is_singular() && !empty($post->post_excerpt)) {
			echo '<meta name="description" content="' . esc_attr(wp_strip_all_tags($post->post_excerpt)) . '">' . "\n";
		}
	}
}
add_action('wp_head', 'hello_elementor_add_description_meta_tag');

/**
 * BC:
 * In v2.7.0 the theme removed the `hello_elementor_body_open()` from `header.php` replacing it with `wp_body_open()`.
 * The following code prevents fatal errors in child themes that still use this function.
 */
if (!function_exists('hello_elementor_body_open')) {
	function hello_elementor_body_open()
	{
		wp_body_open();
	}
}


function my_styles()
{
	/*
	* Hàm get_stylesheet_uri() sẽ trả về giá trị dẫn đến file style.css của theme
	* Nếu sử dụng child theme, thì file custom-style.css này vẫn load ra từ theme chính
	*/

	wp_enqueue_script('my-javascript.js', get_theme_file_uri('/assets/js/my-javascript.js'), array(), '1.0', true);

	wp_register_style('custom-style', get_template_directory_uri() . '/assets/css/myStyle.css', 'all');
	wp_enqueue_style('custom-style');
	wp_register_style('custom-responsive', get_template_directory_uri() . '/assets/css/myResponsive.css', 'all');
	wp_enqueue_style('custom-responsive');
}
add_action('wp_enqueue_scripts', 'my_styles');

// chèn widget
if (function_exists("register_sidebar")) {
	register_sidebar();
}

function wpshare247_widgets_init()
{
	// Thêm SB phải
	register_sidebar(array(
		'name'          => __('Sidebar phải', 'text_domain'),
		'id'            => 'sidebar-right',
		'description'   => __('Thêm các widget *[Phải] vào đây', 'text_domain'),
		'before_widget' => '<section id="%1$s" class="widget sb-right %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));

	// Thêm các SB tiếp theo
}
add_action('widgets_init', 'wpshare247_widgets_init');


// add button back to top 
if (!function_exists('ptt_add_back_to_top')) {
	function ptt_add_back_to_top()
	{
		echo '<button onclick="topFunction()" id="back-to-top" title="Go to top"><i class="fas fa-arrow-circle-up"></i></button>';
	}
	add_filter('wp_footer', 'ptt_add_back_to_top', 99);
}


// get breadcumb
function custom_content_after_body_open_tag()
{
?>
	<div class="get-breadcumb">
		<div class="get-breadcumb-content">
			<i class="fas fa-home"></i>
			<?php echo do_shortcode('[wpseo_breadcrumb]') ?>
		</div>
	</div>
<?php
}
add_action('wp_body_open', 'custom_content_after_body_open_tag');


// add custom field in product details page

// add field
add_action('woocommerce_product_options_general_product_data', 'devvn_woocommerce_product_options_general_product_data');
function devvn_woocommerce_product_options_general_product_data()
{
	global $post, $thepostid, $product_object;

?>
	<div class="options_group devvn_custom_field">
		<?php
		woocommerce_wp_textarea_input(
			array(
				'id'        => 'custom_textarea',
				'value'     => $product_object->get_meta('custom_textarea', true),
				'label'     => __('Đối tượng sử dụng', 'hebe'),
				'style'     => 'height: 100px;',
			)
		);
		?>
	</div>
<?php
}

// save field
add_action('woocommerce_admin_process_product_object', 'add_field_woocommerce_admin_process_product');
function add_field_woocommerce_admin_process_product($product)
{
	$product->update_meta_data('custom_textarea', isset($_POST['custom_textarea']) ? sanitize_textarea_field($_POST['custom_textarea']) : '');
}

// display field
function object_of_use()
{
	global $product;
	if (!empty($product->get_meta('custom_textarea'))) {

           echo  "<h5><b>Đối tượng sử dụng</b></h5>";
	   echo  "<p class='content-user'>" . $product->get_meta('custom_textarea') . "</p>";
	}
}
add_action('woocommerce_share', 'object_of_use');


// add action readmore in content product
add_action('wp_footer', 'readmore_content');
function readmore_content()
{
?>
	<style>
		.single-product div#tab-description {
			overflow: hidden;
			position: relative;
			padding-bottom: 25px;
		}

		.fix_height {
			max-height: 600px;
			overflow: hidden;
			position: relative;
		}

		.single-product .tab-panels div#tab-description.panel:not(.active) {
			height: 0 !important;
		}

		.readmore-content {
			text-align: center;
			cursor: pointer;
			position: absolute;
			z-index: 10;
			bottom: 0;
			width: 100%;
			background: #fff;
		}

		.readmore-content:before {
			height: 55px;
			margin-top: -45px;
			content: "";
			background: -moz-linear-gradient(top, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 100%);
			background: -webkit-linear-gradient(top, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 100%);
			background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 100%);
			filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff00', endColorstr='#ffffff', GradientType=0);
			display: block;
		}

		.readmore-content a {
			color: #318A00;
			display: block;
		}

		.readmore-content a:after {
			content: '';
			width: 0;
			right: 0;
			border-top: 6px solid #318A00;
			border-left: 6px solid transparent;
			border-right: 6px solid transparent;
			display: inline-block;
			vertical-align: middle;
			margin: -2px 0 0 5px;
		}

		.readmore-content_less a:after {
			border-top: 0;
			border-left: 6px solid transparent;
			border-right: 6px solid transparent;
			border-bottom: 6px solid #318A00;
		}

		.readmore-content_less:before {
			display: none;
		}
	</style>
	<script>
		(function($) {
			$(window).on('load', function() {
				if ($('.single-product div#tab-description').length > 0) {
					let wrap = $('.single-product div#tab-description');
					let current_height = wrap.height();
					let your_height = 800;
					if (current_height > your_height) {
						wrap.addClass('fix_height');
						wrap.append(function() {
							return '<div class="readmore-content readmore-content_more"><a title="Xem thêm" href="javascript:void(0);">Xem thêm</a></div>';
						});
						wrap.append(function() {
							return '<div class="readmore-content readmore-content_less" style="display: none;"><a title="Xem thêm" href="javascript:void(0);">Thu gọn</a></div>';
						});
						$('body').on('click', '.readmore-content_more', function() {
							wrap.removeClass('fix_height');
							$('body .readmore-content_more').hide();
							$('body .readmore-content_less').show();
						});
						$('body').on('click', '.readmore-content_less', function() {
							wrap.addClass('fix_height');
							$('body .readmore-content_less').hide();
							$('body .readmore-content_more').show();
						});
					}
				}
			});
		})(jQuery);
	</script>
<?php
}


/**
 * Reorder product data tabs
 */

$url  = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
if (strpos($url, '/san-pham')) {
	add_filter('woocommerce_product_tabs', 'wcpm_reorder_product_tabs', 98);
	function wcpm_reorder_product_tabs($tabs)
	{
                $tabs['thong-tin-chung']['priority'] = 5;	
		$tabs['thanh-phan']['priority'] = 10;	
		$tabs['cong-dung']['priority'] = 15;				
		$tabs['description']['priority'] = 20;			

		return $tabs;
	}
}