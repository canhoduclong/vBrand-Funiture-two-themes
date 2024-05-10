<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woo.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="toolbox-right">
	<div class="toolbox-sort">
		<div class="select-custom">
			<form class="woocommerce-ordering" method="get">
				<select name="orderby" class="orderby form-control" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>">
					<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
						<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
					<?php endforeach; ?>
				</select>
				<input type="hidden" name="paged" value="1" />
				<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
			</form>
		</div>
	</div>
	<div class="toolbox-layout">
		<a href="#" class="btn-layout active">
			<svg width="16" height="10">
				<rect x="0" y="0" width="4" height="4"></rect>
				<rect x="6" y="0" width="10" height="4"></rect>
				<rect x="0" y="6" width="4" height="4"></rect>
				<rect x="6" y="6" width="10" height="4"></rect>
			</svg>
		</a>

		<a href="#" class="btn-layout">
			<svg width="10" height="10">
				<rect x="0" y="0" width="4" height="4"></rect>
				<rect x="6" y="0" width="4" height="4"></rect>
				<rect x="0" y="6" width="4" height="4"></rect>
				<rect x="6" y="6" width="4" height="4"></rect>
			</svg>
		</a>

		<a href="#" class="btn-layout">
			<svg width="16" height="10">
				<rect x="0" y="0" width="4" height="4"></rect>
				<rect x="6" y="0" width="4" height="4"></rect>
				<rect x="12" y="0" width="4" height="4"></rect>
				<rect x="0" y="6" width="4" height="4"></rect>
				<rect x="6" y="6" width="4" height="4"></rect>
				<rect x="12" y="6" width="4" height="4"></rect>
			</svg>
		</a>

		<a href="#" class="btn-layout">
			<svg width="22" height="10">
				<rect x="0" y="0" width="4" height="4"></rect>
				<rect x="6" y="0" width="4" height="4"></rect>
				<rect x="12" y="0" width="4" height="4"></rect>
				<rect x="18" y="0" width="4" height="4"></rect>
				<rect x="0" y="6" width="4" height="4"></rect>
				<rect x="6" y="6" width="4" height="4"></rect>
				<rect x="12" y="6" width="4" height="4"></rect>
				<rect x="18" y="6" width="4" height="4"></rect>
			</svg>
		</a>
	</div>
</div>


