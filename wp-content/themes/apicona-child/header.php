<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Apicona
 * @since Apicona 1.0
 */
global $apicona;
$stickyHeaderClass = ($apicona['stickyheader']=='y') ? 'masthead-header-stickyOnScroll' : '' ; // Check if sticky header enabled

$search_title = ( isset($apicona['search_title']) && trim($apicona['search_title'])!='' ) ? trim($apicona['search_title']) : "Just type and press 'enter'" ;
$search_input = ( isset($apicona['search_input']) && trim($apicona['search_input'])!='' ) ? trim($apicona['search_input']) : "WRITE SEARCH WORD..." ;
$search_close = ( isset($apicona['search_close']) && trim($apicona['search_close'])!='' ) ? trim($apicona['search_close']) : "Close search" ;
$logoseo      = ( isset($apicona['logoseo']) && trim($apicona['logoseo'])!='' ) ? trim($apicona['logoseo']) : "h1homeonly" ;

// Logo tag for SEO
$logotag = 'h1';
if( $logoseo=='h1homeonly' && !is_front_page() ){
	$logotag = 'span';
}



$stickyLogo = 'no';
if( isset($apicona['logoimg_sticky']["url"]) && trim($apicona['logoimg_sticky']["url"])!='' ){
	$stickyLogo = 'yes';
}


/*
 * This will override the default "skin color" set in the page directly.
 */
if( is_page() ){
	global $post;
	global $apicona;
	$skincolor = trim( get_post_meta( $post->ID, '_kwayy_page_customize_skincolor', true ) );
	if($skincolor!=''){
		$apicona['skincolor']=$skincolor;
	}
}




?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="msvalidate.01" content="82CCECA330300D30DD4A0B66A5A2E43D" />

<meta name="p:domain_verify" content="31c19d103307edbed494b0d7534e1838"/>
<meta name="keywords" content="Răng sứ, rang su, Chỉnh nha, chinh nha, Tẩy trắng răng, tay trang rang, Răng giả tháo lắp, rang gia thao lap">

<meta name="DC.title" content="Nha khoa tốt nhất HCM" />
<meta name="geo.region" content="VN-SG" />
<meta name="geo.placename" content="Ho Chi Minh City" />
<meta name="geo.position" content="10.763983;106.660614" />
<meta name="ICBM" content="10.763983, 106.660614" />
<link rel="schema.DC" href="http://purl.org/dc/elements/1.1/">
	<meta name="DC.title" content="Nha khoa thẩm mỹ uy tín- Tẩy trắng răng, Implant">
	<meta name="DC.identifier" content="http://nhakhoaapple.com">
	<meta name="DC.description" content="Nha khoa Apple là trung tâm Nha khoa thẩm mỹ hàng đầu tại Tp.HCM.....Implants, răng sứ,điều trị hôi miệng liên hệ để được bác sĩ tư vấn 08.38533443 - 0903 666 090.">
	<meta name="DC.subject" content="tẩy trắng răng, điều trị implants, răng giả tháo lắp, răng sứ, chữa tủy, nhổ răng tiểu phẫu, viêm nứu nha chu">
	<meta name="DC.language" scheme="ISO639-1" content="vi">
	<meta name="DC.creator" content="http://nhakhoaapple.com">
	<meta name="DC.contributor" content="Trần Quân Thụy">
	<meta name="DC.publisher" content="Trần Quân Thụy">
	<meta name="DC.license" content="http://nhakhoaapple.com">
	<meta name="DC.type" scheme="DCMITYPE" content="http://purl.org/dc/dcmitype/Service">
	<meta name="DC.type" scheme="DCMITYPE" content="http://purl.org/dc/dcmitype/Software">
	<link rel="schema.DCTERMS" href="http://purl.org/dc/terms/" />
	<meta name="DCTERMS.created" scheme="ISO8601" content="2015-7-18">



<meta name="viewport" content="width=device-width, initial-scale=1">
<title>
<?php wp_title( '|', true, 'right' ); ?>
</title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
/* Custom HTML code */
if( isset($apicona['customhtml_bodystart']) && trim($apicona['customhtml_bodystart'])!='' ){
	echo $apicona['customhtml_bodystart'];
}
?>

<div class="main-holder animsition">
<div id="page" class="hfeed site">
<header id="masthead" class="site-header  header-text-color-<?php echo $apicona['header_text_color']; ?>" role="banner">
  <div class="headerblock">
	<?php kwayy_floatingbar(); ?>
	<?php kwayy_topbar(); ?>
    <div id="stickable-header" class="header-inner <?php echo $stickyHeaderClass; ?>">
      <div class="container">
        <div class="headercontent">
          <div class="headerlogo kwayy-logotype-<?php echo $apicona['logotype']; ?> tm-stickylogo-<?php echo $stickyLogo; ?>">
				<<?php echo $logotag; ?> class="site-title">
					<a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">

						<?php if( $apicona['logotype'] == 'image' ){ ?>
							<?php /* ?>
							<?php if( $kwayy_retina_logo=='on' ){ ?>
								<img class="kwayy-logo-img retina" src="<?php echo $apicona['logoimg_retina']["url"]; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" width="<?php echo round(($apicona['logoimg']["width"])/2); ?>" height="<?php echo round(($apicona['logoimg']["height"])/2); ?>">
							<?php } else { ?>
								<img class="kwayy-logo-img standard" src="<?php echo $apicona['logoimg']["url"]; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" width="<?php echo $apicona['logoimg']["width"]; ?>" height="<?php echo $apicona['logoimg']["height"]; ?>">
							<?php }; ?>
							<?php */ ?>

							<img class="kwayy-logo-img standardlogo" src="<?php echo $apicona['logoimg']["url"]; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" width="<?php echo $apicona['logoimg']["width"]; ?>" height="<?php echo $apicona['logoimg']["height"]; ?>">

							<?php if( isset($apicona['logoimg_sticky']["url"]) && trim($apicona['logoimg_sticky']["url"])!='' ): ?>
							<img class="kwayy-logo-img stickylogo" src="<?php echo $apicona['logoimg_sticky']["url"]; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" width="<?php echo $apicona['logoimg_sticky']["width"]; ?>" height="<?php echo $apicona['logoimg_sticky']["height"]; ?>">
						    <?php endif; ?>

						<?php } else { ?>

							<?php if( trim($apicona['logotext'])!='' ){ echo $apicona['logotext']; } else { bloginfo( 'name' ); }?>

						<?php } ?>

					</a>
				</<?php echo $logotag; ?>>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>

                <div class="search-page">
                    <form method="get" id="flying_searchform" action="<?php echo home_url(); ?>">
                        <input type="text" class="field searchform-s" name="s" id="searchval" placeholder="<?php _e($search_input, 'apicona' ); ?>">
                        <i class="kwicon-fa-search icon-search-form"></i>
                    </form>

                </div>

        </div>

		  <?php
		  $navbarClass = '';
		  if( isset($apicona['header_search']) &&  $apicona['header_search']=='1'){
			$navbarClass = ' class="k_searchbutton"';
		  }
		  ?>



          <div id="navbar"<?php echo $navbarClass; ?>>
            <nav id="site-navigation" class="navigation main-navigation" role="navigation">
              <h3 class="menu-toggle">
                <?php _e( '<span>Toggle menu</span><i class="kwicon-fa-navicon"></i>', 'apicona' ); ?>
              </h3>
              <a class="screen-reader-text skip-link" href="#content" title="<?php esc_attr_e( 'Skip to content', 'apicona' ); ?>">
              <?php _e( 'Skip to content', 'apicona' ); ?>
              </a>
              <?php
					   //if ( has_nav_menu( 'primary' ) ){
						//wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' , 'walker' => new kwayy_custom_menus_walker ) );
					   //} else {
						wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu', 'container_class' => 'menu-main-menu-container nav-menu-wrapper' ) );
					   //}
      			 ?>
              <?php /*?><?php get_search_form(); ?><?php */?>


			  <?php if( isset($apicona['header_search']) &&  $apicona['header_search']=='1'): ?>
              <div class="k_flying_searchform"> <span class="k_searchlink"><a href="javascript:void(0);"><i class="kwicon-fa-search"></i></a></span>
                <div class="k_flying_searchform_wrapper">
                  <form method="get" id="flying_searchform" action="<?php echo home_url(); ?>">
                    <div class="w-search-form-h">
                      <div class="w-search-form-row">
                        <div class="w-search-label">
                          <label for="s"> <?php _e($search_title, 'apicona'); ?></label>
                        </div>
                        <div class="w-search-input">
                          <input type="text" class="field searchform-s" name="s" id="searchval" placeholder="<?php _e($search_input, 'apicona' ); ?>">
                        </div>
                        <a class="w-search-close" href="javascript:void(0)" title="<?php _e($search_close, 'apicona' ); ?>"></a> </div>
                    </div>
                    <div class="sform-close-icon"><i class="icon-remove"></i></div>
                  </form>
                </div>
              </div><!-- .k_flying_searchform -->
              <?php endif; ?>

            </nav>
            <!-- #site-navigation -->
          </div>
          <!-- #navbar -->
        </div>
        <!-- .row -->
      </div>
    </div>
  </div>
  <?php kwayy_header_titlebar(); ?>
  <?php kwayy_header_slider(); ?>


</header>
<!-- #masthead -->



<div id="main" class="site-main">
