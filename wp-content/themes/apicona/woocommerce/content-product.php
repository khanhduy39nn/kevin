<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop, $apicona;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
$woocommerce_column = ( isset($apicona['woocommerce-column']) && trim($apicona['woocommerce-column'])!='' ) ? trim($apicona['woocommerce-column']) : 3 ;
$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', $woocommerce_column );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
/*if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';*/
	
switch( $woocommerce_loop['columns'] ){
	case '2':
		$classes[] = 'col-xs-12 col-sm-6 col-md-6 col-lg-6';
		break;
	case '3':
	default:
		$classes[] = 'col-xs-12 col-sm-6 col-md-4 col-lg-4';
		break;
	case '4':
		$classes[] = 'col-xs-12 col-sm-6 col-md-3 col-lg-3';
		break;
	
}
	
?>
<li <?php post_class( $classes ); ?>>
  <div class="productbox">
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<div class="productimagebox">
		
		<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' );
		?>
		
    </div><!-- .productimagebox -->
      
	<div class="productcontent">
		<a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>

		<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
		?>
	</div><!-- .productcontent -->

	

	<?php

		/**
		 * woocommerce_after_shop_loop_item hook
		 *
		 * @hooked woocommerce_template_loop_add_to_cart - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item' ); 

	?>
    
    
  </div><!-- .productbox -->
</li>
