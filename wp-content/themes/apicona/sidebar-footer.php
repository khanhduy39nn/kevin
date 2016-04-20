<?php
/**
 * The sidebar containing the footer widget area
 *
 * If no active widgets in this sidebar, hide it completely.
 *
 * @package WordPress
 * @subpackage Apicona
 * @since Apicona 1.0
 */

 
 global $apicona;


//$footer_col = ( isset($apicona['footer_column_layout']) && trim($apicona['footer_column_layout'])!='' ) ? trim($apicona['footer_column_layout']) : '3_3_3_3' ;

$footer_col = '3_3_3_3';
if( isset($apicona['footer_column_layout']) && trim($apicona['footer_column_layout'])!='' ){
	$footer_col = trim($apicona['footer_column_layout']);
}

$footer_col = explode('_', $footer_col);


if( is_array($footer_col) && count($footer_col)>0 ){
	?>

	<div id="secondary" class="sidebar-container" role="complementary">
	
	<?php
	$x = 1;
	foreach($footer_col as $col){
		
		// Widget position
		$sidebar = 'fourth';
		switch($x){
			case 1 :
				$sidebar = 'first';
				break;
			case 2 :
				$sidebar = 'second';
				break;
			case 3 :
				$sidebar = 'third';
				break;
			case 4 :
				$sidebar = 'fourth';
				break;
			
		}
		
		// ROW width class
		$row_class = 'col-xs-12 col-sm-12 col-md-'.$col.' col-lg-'.$col;
		
		
		if ( is_active_sidebar( $sidebar.'-footer-widget-area' ) ) : ?>
		
		<div class="widget-area <?php echo $row_class; ?>">
			<?php dynamic_sidebar( $sidebar.'-footer-widget-area' ); ?>
		</div><!-- .widget-area -->
		
		<?php endif;
		
		$x++;
	} // Foreach
}

?>


</div><!-- #secondary -->
