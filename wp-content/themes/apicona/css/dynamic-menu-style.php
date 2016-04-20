<?php
$breakpoint = '1200';
if( isset($apicona['menu_breakpoint']) && isset($apicona['menu_breakpoint_custom']) ){
 if( $apicona['menu_breakpoint']=='custom' ){
  $breakpoint = $apicona['menu_breakpoint_custom'];
 } else {
  $breakpoint = $apicona['menu_breakpoint'];
 }
}
?>

/**
 * Responsive Menu
 * ----------------------------------------------------------------------------
 */


@media (min-width: <?php echo $breakpoint; ?>px) {
 
 	.kwayy-header-style-1 ul.nav-menu li ul, 
    .kwayy-header-style-1 div.nav-menu > ul .children,
    .kwayy-header-style-2 ul.nav-menu li ul, 
    .kwayy-header-style-2 div.nav-menu > ul .children{
        top: <?php echo $headerHeight+30; ?>px;
    }
    ul.nav-menu li:hover > ul, 
    ul.nav-menu ul li:hover > ul, 
    div.nav-menu > ul li:hover > ul, 
    div.nav-menu > ul ul li:hover > ul{
        top: <?php echo $headerHeight; ?>px;
    } 
 
    .kwayy-header-style-1 ul.nav-menu > li > a, 
    .kwayy-header-style-1 div.nav-menu > ul > li > a,
    .kwayy-header-style-1 #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal > li.mega-menu-item > a,
    
    .kwayy-header-style-2 ul.nav-menu > li > a, 
    .kwayy-header-style-2 div.nav-menu > ul > li > a,
    .kwayy-header-style-2 #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal > li.mega-menu-item > a    {
        height: <?php echo $headerHeight; ?>px;
        line-height: <?php echo $headerHeight; ?>px !important;
    } 
    
    .kwayy-header-style-1 .is-sticky ul.nav-menu > li > a, 
    .kwayy-header-style-1 .is-sticky div.nav-menu > ul > li > a,
    .kwayy-header-style-1 .is-sticky #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal > li.mega-menu-item > a,
    
    .kwayy-header-style-2 .is-sticky ul.nav-menu > li > a, 
    .kwayy-header-style-2 .is-sticky div.nav-menu > ul > li > a,
    .kwayy-header-style-2 .is-sticky #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal > li.mega-menu-item > a {
        height: <?php echo $headerHeightSticky; ?>px !important;
        line-height: <?php echo $headerHeightSticky; ?>px !important;
    }       
    .is-sticky ul.nav-menu > li > a:before,
    .is-sticky div.nav-menu > ul > li > a:before,
    .is-sticky .main-navigation .mega-menu-wrap ul.mega-menu > li.mega-menu-item > a:before{
        top: <?php echo ceil($headerHeightSticky/2)+30; ?>px;
    }
    .is-sticky ul.nav-menu > li:hover > a:before,
    .is-sticky div.nav-menu > ul > li:hover > a:before,
    .is-sticky .main-navigation .mega-menu-wrap ul.mega-menu > li.mega-menu-item:hover > a:before{
        top: <?php echo ceil($headerHeightSticky/2)+10; ?>px;
    }    
    .is-sticky .headercontent .headerlogo img{
         max-height: <?php echo $logoMaxHeightSticky; ?>px;
    }
    
    
}
 

@media (max-width: <?php echo $breakpoint; ?>px){


 /**
 *  Header Section
 * ----------------------------------------------------------------------------
 */
	
    .headerlogo,
    .search_box, 
    .thememount-header-cart-link-wrapper{
        height: <?php echo $headerHeight; ?>px;
        line-height: <?php echo $headerHeight; ?>px !important;
    }    
    #stickable-header-sticky-wrapper{
		height:auto !important;
	}	
	.masthead-header-stickyOnScroll{
		position: relative !important;
	}	
	.header-inner {
		height:auto;		
	}
	.sticky-wrapper .header-inner{
		top:0px;
	}	
	.header-inner .navbar {
		width:auto
	}
        
    .tm-header-invert .k_flying_searchform span,
    .tm-header-invert .menu-toggle {
        left: 0px;
        right: inherit;
    }
    .tm-header-invert #navbar.k_searchbutton #site-navigation .mega-menu-wrap .mega-menu-toggle,
    .tm-header-invert #navbar.k_searchbutton .menu-toggle{
    	left: 49px;
        right: inherit;
    }    
    .tm-header-invert .k_searchbutton .menu-main-menu-container, 
    .tm-header-invert #navbar.k_searchbutton #site-navigation .mega-menu-wrap {
        margin-right: 0px;
        margin-left: 0px;
    }
    .k_searchbutton .menu-main-menu-container, 
    #navbar.k_searchbutton #site-navigation .mega-menu-wrap {
   		margin-right: 0px;
    }


    /**
    *  Navigation  Text color
    * ----------------------------------------------------------------------------
    */ 
    
    /* when  header dark */	
	.header-text-color-white ul.nav-menu > li:hover > a, 	
	.header-text-color-white ul.nav-menu li li:hover > a, 	
	.header-text-color-white div.nav-menu > ul > li:hover > a, 	
	.header-text-color-white div.nav-menu > ul li li:hover > a,	
	.header-text-color-white ul.nav-menu li li a	{		
		color: rgba(255, 255, 255, 0.95);
	}	
	.header-text-color-white ul.nav-menu li, 
	.header-text-color-white  div.nav-menu > ul li {
		border-bottom: 1px solid rgba(255, 255, 255, 0.08);
	}	
    
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu a:hover,
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu li:hover > a,
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu li.current-menu-item a,
    #navbar #site-navigation .mega-menu-wrap .mega-menu-flyout .mega-sub-menu li.mega-current-menu-item a,
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu a:hover,   
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu > li.mega-current-menu-parent:hover > a,
    ul.nav-menu li li a:hover, 
    ul.nav-menu li li:hover > a, 
    ul.nav-menu li li.current-menu-item > a, 
    div.nav-menu > ul li li a:hover, 
    div.nav-menu > ul li li:hover > a, 
    div.nav-menu > ul li li.current-menu-item > a{
        color: <?php echo $apicona['skincolor']; ?>;
    }
    .header-text-color-white ul.nav-menu > li:hover > a,
    .header-text-color-white ul.nav-menu > li.current-menu-item:hover > a,
    .header-text-color-white .toggled-on ul.nav-menu li li a:hover,
    .header-text-color-white .toggled-on div.nav-menu > ul li li a:hover,
    .header-text-color-dark .toggled-on ul.nav-menu li li a:hover,
    .header-text-color-dark .toggled-on div.nav-menu > ul li li a:hover,
    .header-text-color-dark  .toggled-on ul.nav-menu > li > a:hover,
    .header-text-color-white  .toggled-on ul.nav-menu > li > a:hover,
    ul.nav-menu > li:hover > a,
    div.nav-menu > ul > li:hover > a{
        color: <?php echo $apicona['skincolor']; ?>;
    }
    
    .header-text-color-white .toggled-on .nav-menu, 
    .header-text-color-white .toggled-on .nav-menu > ul {
        background-color: <?php echo $apicona['headerbgcolor']; ?>;
    }

    
    /**
    *  Navigation 
    * ----------------------------------------------------------------------------
    */ 
    .menu-toggle {
        display: block;
        text-align: center;			
        cursor: pointer;        
        margin: 0px;
        position: absolute;
        top: 0px;
        right: 0;
        padding-right: 0px;
    }
    .kwayy-header-style-1 .menu-toggle,
    .kwayy-header-style-2 .menu-toggle {
    	top: <?php echo ceil($headerHeight/2) - 15; ?>px;
    }
        	
    .menu-toggle > span{
        display:none;
    }	
    ul.nav-menu, div.nav-menu > ul {
        float: none;
        overflow: hidden;
        max-height: 0px;
        position: absolute;
        left: 0px;
        z-index: 9999;
    }
    .kwayy-header-style-3 .menu-toggle {
        position:relative;
    }
	
    /*Responsive Menu*/	
    ul.nav-menu > li > a, 
    div.nav-menu > ul > li > a{
        padding:0px;
    }
    .toggled-on  .menu-main-navigation-container{
        padding-bottom:20px;
    }
    .toggled-on .nav-menu, 
    .toggled-on .nav-menu > ul, 
    .Headerlogo, .navbar  {
        width: 100%;
    }	
    .toggled-on  ul.nav-menu, 
    .Headerlogo, 
    .navbar{
        float:none
    }		
    .toggled-on .nav-menu li > ul {
        border-top:none;
        background-color: transparent;		
        float: none;
        margin-left: 20px;
        position: relative;
        left: auto;
        top: auto;
        visibility: visible;		
        opacity: 1;	
        -webkit-box-shadow: none;
        box-shadow: none;	
    }
    ul.nav-menu li ul li a, 
    div.nav-menu > ul li ul li a,
    ul.nav-menu li li.current-menu-item a{
        border:none;
    }
    .nav-menu li > ul a,
    ul.nav-menu > li.current-menu-item > a, 
    div.nav-menu > ul > li.current-menu-item > a{	
        width: auto;
    }
    .toggled-on .nav-menu li:hover > a, 
    .toggled-on .nav-menu .children a {
        background-color: transparent;	
    }
    .toggled-on .nav-menu .sub-menu .sub-menu{
        left:0px;
    }	
    .toggled-on .nav-menu .sub-menu .sub-menu, 
    .toggled-on div.nav-menu > ul .children  .children{
        top:0px;
    }	
    .toggled-on .nav-menu > li.menu-item-has-childrenmenu-without-color.menu-with-icon {
        position:relative;
    }	
    .righticon{
        position:absolute;
        right:0px;
        z-index:9999;
        top:17px;
    }
    .righticon i{
        font-size:20px;
        cursor:pointer;
    }
    .header-text-color-white .righticon i{
        color: rgba(255, 255, 255, 0.80);
    }
    .header-text-color-dark .righticon i{
        color: rgba(0, 0, 0, 0.80);
    }		
    ul.nav-menu, 
    div.nav-menu > ul {
        float:none;
        overflow: hidden;
        max-height: 0px;
    }	
    .toggled-on .nav-menu, 
    .toggled-on .nav-menu > ul {	
        margin-left: 0;		
        background:#fff;	
        margin-left: 0;
        padding: 15px;
        margin:0px;		
        max-height: 500px;
        overflow: auto;
        padding-top:0px;
        padding-bottom:0px;
        box-shadow: rgba(0, 0, 0, 0.129412) 3px 3px 15px;	
    }	
    ul.nav-menu .sub-menu,
    div.nav-menu > ul ul.children,
    ul.nav-menu li > ul,
    ul.nav-menu li:hover > ul,		
    div.nav-menu > ul li:hover > ul{
        overflow: hidden;
        max-height: 0px;
        -webkit-transition: max-height 0.25s ease-out;
        -moz-transition: max-height 0.25s ease-out;
        -ms-transition: max-height 0.25s ease-out;
        -o-transition: max-height 0.25s ease-out;
        transition: max-height 0.25s ease-out;
    }	
    ul.nav-menu .sub-menu.open,
    ul.nav-menu .sub-menu.open li > ul,
    div.nav-menu > ul .children.open,
    div.nav-menu > ul .children.open li > ul{
        max-height: 1000px;
    }		
    .righticon{
        display:block;
    }	
    .navbar {		
        min-height: 0px;
        margin-bottom: 0px;
    }
    ul.nav-menu > li,
    div.nav-menu > ul > li {
        position: relative;
        display: block;
        float:none;
    }	
    ul.nav-menu  li,
    div.nav-menu > ul li  {
        font-size: 15px;
        line-height: 15px;
        padding-top: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.14);		
        margin: 0;
    }	
    ul.nav-menu  li li:last-child,
    div.nav-menu > ul li li:last-child{
        border-bottom: none;	
    } 	
    ul.nav-menu > li a,
    div.nav-menu > ul > li a {
        padding-top: 5px;
        padding-bottom: 5px;
        display:inline-block;
    }	
    ul.nav-menu li:hover > ul,
    div.nav-menu > ul li:hover > ul{
        top:0px;
    }	
    ul.nav-menu > li.menu-item-has-children > a:after,
    div.nav-menu > ul > li.menu-item-has-children > a:after,
    ul.nav-menu li ul li.menu-item-has-children > a:after, 
    div.nav-menu > ul li ul li.menu-item-has-children > a:after{
        display:none;
    }	
    .toggled-on ul.nav-menu > li:hover > a, 	
    .toggled-on ul.nav-menu li li:hover > a, 
    
    .toggled-on div.nav-menu > ul > li:hover > a, 	
    .toggled-on div.nav-menu > ul li li:hover > a,
    
    .toggled-on ul.nav-menu li li.current-menu-item > a	{
        background-color:transparent;		
    }	
    .toggled-on ul.nav-menu li li:hover a{
        border:none;
    }	
    .nav-menu .sub-menu .sub-menu, 
    div.nav-menu > ul .children .children{
        border:none;
    }
    /* when  header white */		
    ul.nav-menu li, 
    div.nav-menu > ul li{
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    }	
    /* when header white */
    .header-text-color-dark ul.nav-menu > li:hover > a{
        color: rgba(0, 0, 0, 0.72) ;
    }	
    .tm-header-invert #navbar {
   		float: none;
    }    
    /*kwayy-header-style-2*/	
    .kwayy-header-style-2 #stickable-header  .headerlogo{
        position:relative;
    }
    .kwayy-header-style-2 #stickable-header ul.nav-menu, 
    .kwayy-header-style-2 #stickable-header div.nav-menu > ul{
        position:absolute;
        z-index:1001;
        text-align:left;
    }
    .kwayy-header-style-2 #stickable-header ul.nav-menu > li, 
    .kwayy-header-style-2 #stickable-header div.nav-menu > ul > li{
        display:block;
    }	
    .kwayy-header-style-2 #stickable-header ul.nav-menu > li:nth-child(3), 
    .kwayy-header-style-2 #stickable-header div.nav-menu > ul > li:nth-child(3){
        margin-right:0px;
    }	
    /*kwayy-header-style-3*/	
    .kwayy-header-style-3 .menu-toggle{
        padding:0px;
        height: 55px;
        line-height: 55px !important;
    }	
    .kwayy-header-style-3 #stickable-header ul.nav-menu > li, 
    .kwayy-header-style-3 #stickable-header div.nav-menu > ul > li {			
        text-align: left;
    }	
    .kwayy-header-style-3 #stickable-header .toggled-on ul.nav-menu > li,
    .kwayy-header-style-3 #stickable-header .toggled-on div.nav-menu > ul > li{
        display:block;
    }	
    .toggled-on ul.nav-menu > li > a, 
    .toggled-on div.nav-menu > ul > li > a {		
        height: auto;
        line-height: 20px !important;
    }	
    .toggled-on ul.nav-menu > li:hover > ul, 
    .toggled-on div.nav-menu > ul > li:hover > ul{
        top:0px;
    }	
    .toggled-on  ul.nav-menu ul a, 
    .toggled-on  div.nav-menu ul ul a{
        padding-left:0px;
    }	
    ul.nav-menu > li > a:before{
        display:none;
    }	
    .kwayy-header-style-2 #stickable-header ul.nav-menu > li:first-child, 
    .kwayy-header-style-2 #stickable-header div.nav-menu > ul > li:first-child,
    .kwayy-header-style-2 #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal > li:first-child{
        margin-left: 0px;
    }
    .header-text-color-white #navbar #site-navigation .mega-menu-wrap .mega-menu-toggle:after {
        color: #FFFCFC;
    }
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal,
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal > li.mega-menu-flyout ul.mega-sub-menu {		
        width: 100%;
        float: none;
    }
    #navbar {
        float: none;
    }	
    #navbar #site-navigation .mega-menu-wrap  .mega-menu-toggle{
        display: block;
        position: absolute;      
        right: 0px;
        width: 30px;
    }	
    .tm-header-invert #navbar #site-navigation .mega-menu-wrap  .mega-menu-toggle {  
        left: 0px;    
    }
 	    
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal li.mega-menu-item > a:before{
        display:none;
    }	
    .main-navigation .mega-menu-wrap ul.mega-menu > li.mega-menu-item > a,
    .is-sticky .main-navigation .mega-menu-wrap ul.mega-menu > li.mega-menu-item > a{
        height: 45px !important;
        line-height: 45px !important;
    }
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu {	
        -webkit-box-shadow: none;
        box-shadow: none;
    }
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal > li.mega-menu-megamenu > ul.mega-sub-menu > li.mega-menu-item{
        float:none;
        width:100%;
    }	
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu a,
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu > li.mega-menu-item > h4.mega-block-title{
        border-right:none;
    }
    .header-text-color-white #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu a,
    .header-text-color-white #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu > li.mega-menu-item > h4.mega-block-title{
        color:#fff;
    }		
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal > li.mega-menu-item  {
        border-bottom: 1px solid #e1e1e1;
    }	
    .header-text-color-white #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal > li.mega-menu-item,
    .header-text-color-white #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu a,
    .header-text-color-white #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu a:hover,	
    .header-text-color-white #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu a:hover, 
    .header-text-color-white #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu li:hover > a{
        border-bottom: 1px solid rgba(255, 255, 255, 0.17);
    }
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu a{
        padding-left:0px !important;
        padding-right:0px !important;
    }	
    .main-navigation .mega-menu-wrap ul.mega-menu > li.mega-menu-item > a{
        margin-left:0px !important;
    }
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu{
        padding-left:15px;		
    }	
    .header-text-color-white #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu,
    .header-text-color-white #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu a{
        background: none;
    }
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu a:hover{
        background-color:transparent;
    }
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu a:hover{
        border-bottom: 1px solid #e1e1e1;
        border-right: none;
    }	
    #navbar #site-navigation .mega-menu-wrap .mega-menu-toggle:after{
        background:none;
        color:#2d2d2d;
    }	
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal > li.mega-menu-item-has-children > a:after {	
        position: absolute;
        right: 0;
    }
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal li.mega-menu-flyout li.mega-menu-item-has-children > a:after {		
        content: '\f107';
    }	
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu a:hover, 
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu li:hover > a,
    #navbar #site-navigation .mega-menu-wrap .mega-menu-flyout .mega-sub-menu li.mega-current-menu-item > a{
        background-color:transparent;
    }	
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu a:hover,
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu li:hover > a,
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu li.current-menu-item a,
    #navbar #site-navigation .mega-menu-wrap .mega-menu-flyout .mega-sub-menu li.mega-current-menu-item a{
        border-bottom: 1px solid #e1e1e1;
        border-right: 1px solid #e1e1e1;
    }	
    .main-navigation .mega-menu-wrap ul.mega-menu > li.mega-menu-item > a {
        margin-right: 0px !important;	
    }	
    .kwayy-header-style-2 #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal > li.mega-logo-after-this,
    .kwayy-header-style-2 #stickable-header ul.nav-menu > li.logo-after-this,
    .kwayy-header-style-2 #stickable-header div.nav-menu > ul > li.logo-after-this{
        margin-right: 0px !important;
    }	
    /*	.kwayy-header-style-3 #navbar .main-navigation {
        position: inherit;
    }	*/
    .kwayy-header-style-3 #navbar #site-navigation .mega-menu-wrap .mega-menu-toggle {
        display: inline-block;
        float:none;
        position:inherit;
        margin-top: 7px;
        top: 0px;
    }
    .kwayy-header-style-3 #navbar #site-navigation .mega-menu-wrap{
        text-align:center;
    }
    .kwayy-header-style-3 #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal{
        width:auto;
        padding-left:15px;
        padding-right:15px;
    } 
    #navbar.k_searchbutton #site-navigation .mega-menu-wrap .mega-menu-toggle{
        right: 28px;
    }	
    .kwayy-header-style-3 #navbar.k_searchbutton #site-navigation .mega-menu-wrap{
        margin-right:0px;
    }
    .kwayy-header-style-3 .k_searchbutton .k_flying_searchform span {
        right: 50%;		
        margin-right: -30px;
    }
    .k_searchbutton .menu-toggle {
        right: 37px;		
    }	
    .kwayy-header-style-3 .k_searchbutton .menu-toggle i {	
        margin-left: -42px;
    }	
    .kwayy-header-style-3 .k_searchbutton .menu-toggle{
        right: 0px;	
    }	
    
    .mega-sub-menu{
        display:none !important;
    }
    .mega-sub-menu.open, #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal li .mega-sub-menu .mega-sub-menu{
        display:block !important;
    }
    
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal > li.mega-menu-item{
        position:relative;
    }	
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal > li .righticon {
        top: 7px;
    }
    .main-navigation .mega-menu-wrap ul.mega-menu > li.mega-menu-item > a{
        padding-left:0px !important;
    }
    #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal li.mega-menu-item > a:after {
        display: none;
    }
    
    .nav-menu .last .sub-menu{
		left:0px;
	}
	.nav-menu .lastsecond .sub-menu .sub-menu, 
	.nav-menu .last .sub-menu .sub-menu{
		left: auto;
	}
    
    
}


