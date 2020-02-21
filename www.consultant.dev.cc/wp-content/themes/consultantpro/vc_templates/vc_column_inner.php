<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $width
 * @var $css
 * @var $offset
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column
 */
$responsive_classes = array('desctop_mt', 'desctop_mb', 'tablets_mt', 'tablets_mb', 'mobile_mt', 'mobile_mb', 'desctop_pt', 'desctop_pb', 'tablets_pt', 'tablets_pb', 'mobile_pt', 'mobile_pb');

$resp_classes = '';
foreach ( $responsive_classes as $value ) {
	if( isset( $atts[$value] ) && $atts[$value] != 'none' ) {
		$resp_classes .= ' ' . $atts[$value];
	}
}


$el_class = $width = $css = $offset = $enable_ovarlay=$color_ovarlay='';
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$width = wpb_translateColumnWidthToSpan( $width );
$width = vc_column_offset_class_merge( $offset, $width );

$css_classes = array(
	$this->getExtraClass( $el_class ),
	'wpb_column',
	'vc_column_container',
	$width,
);

if (vc_shortcode_custom_css_has_property( $css, array('border', 'background') )) {
	$css_classes[]='vc_col-has-fill';
}

if(!empty($resp_align)) {
	$resp_align='text-md-'.$resp_align;
} else {
	$resp_align='';
}

$wrapper_attributes = array();

$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . ' "';

$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';
$output .= '<div class="vc_column-inner ' . esc_attr( trim( vc_shortcode_custom_css_class( $css ) ) ) .' '. $resp_classes .  '">';
if (! empty($enable_ovarlay)) {
	$output .= '<span class="enable_overlay '.$width_overlay.'" style="background-color:'.$color_ovarlay.'"></span>';
}
$output .= '<div class="wpb_wrapper text-'.$align.' '.$resp_align.'">';
$output .= wpb_js_remove_wpautop( $content );
$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo  $output;
