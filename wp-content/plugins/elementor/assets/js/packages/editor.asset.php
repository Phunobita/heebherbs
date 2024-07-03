<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * This file is generated by Webpack, do not edit it directly.
 */
return [
	'handle' => 'elementor-packages-editor',
	'src' => plugins_url( '/', __FILE__ ) . 'editor{{MIN_SUFFIX}}.js',
	'i18n' => [
		'domain' => 'elementor',
		'replace_requested_file' => false,
	],
	'type' => 'app',
	'deps' => [
		'elementor-packages-editor-documents',
		'elementor-packages-editor-v1-adapters',
		'elementor-packages-locations',
		'elementor-packages-store',
		'elementor-packages-ui',
		'react',
		'react-dom',
		'wp-i18n',
	],
];
