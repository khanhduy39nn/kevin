<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $woocommerce_loop, $apicona;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
$woocommerce_column = ( isset($apicona['woocommerce-column']) && trim($apicona['woocommerce-column'])!='' ) ? trim($apicona['woocommerce-column']) : 3 ;
$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', $woocommerce_column );

// Increase loop count
$woocommerce_loop['loop']++;


// Extra post classes
$classes = array();
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
<li class="product-category product <?php echo implode(' ',$classes); ?>">

	<?php do_action( 'woocommerce_before_subcategory', $category ); ?>

	<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">

		<?php
			/**
			 * woocommerce_before_subcategory_title hook
			 *
			 * @hooked woocommerce_subcategory_thumbnail - 10
			 */
			do_action( 'woocommerce_before_subcategory_title', $category );
		?>

		<h3>
			<?php
				echo $category->name;

				if ( $category->count > 0 )
					echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count">(' . $category->count . ')</mark>', $category );
			?>
		</h3>

		<?php
			/**
			 * woocommerce_after_subcategory_title hook
			 */
			do_action( 'woocommerce_after_subcategory_title', $category );
		?>

	</a>

	<?php do_action( 'woocommerce_after_subcategory', $category ); ?>

</li>
