<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package grandium
 */
/* HEADER ------------------------------------------- */
function grandium_custom_styling() { ?>
<?php	 if ( function_exists( 'ot_get_option' ) ) : ?>
	<style>

	<?php if( current_user_can('administrator')): ?>
		nav.affix{ top: 32px;}
		@media (max-width: 767px){
			nav.affix { top: 0px;}
		}
	<?php endif; ?>

	<?php if( is_customize_preview('administrator')): ?>
		nav.affix{ top: 0px;}
	<?php endif; ?>

	<?php if( current_user_can('editor')): ?>
		nav.affix { top: 32px;}
		@media (max-width: 767px) {
			nav.affix { top: 47px;}
		}
	<?php endif; ?>

	<?php if ( ot_get_option( 'grandium_theme_color_one' ) !='' ): ?>


		h5,
		.btn-link,
		.btn-link:hover,
		.btn-link:active,
		.btn-link:active:focus,
		.btn-link:focus,
		.widget-pager ul li:hover a,
		.widget-breadcrumb ul li:last-child a,
		.widget-breadcrumb ul li:hover a,
		.widget-google-map .map-title .fa,
		.widget-team-carousel .team-item .item-desc h3,
		.widget-team-carousel .team-item .item-desc ul li a:hover,
		.widget-features-carousel .features-item:hover .item-inner h5,
		.widget-filter-top ul li:hover a,
		.widget-gallery-grid .gallery-item a:after,
		.widget-gallery-carousel .widget-carousel .owl-nav [class*='owl-'],
		.widget-gallery-carousel .widget-carousel .owl-nav [class*='owl-']:hover,
		.widget-rooms-carousel .rooms-item .item-desc h2 a:hover,
		.widget-rooms-carousel .rooms-item .item-desc h3,
		.widget-rooms-carousel .rooms-item .item-desc .fa-star-1:before,
		.widget-rooms-carousel .rooms-item .item-desc .fa-star-2:before,
		.widget-rooms-carousel .rooms-item .item-desc .fa-star-3:before,
		.widget-rooms-carousel .rooms-item .item-desc .fa-star-4:before,
		.widget-rooms-carousel .rooms-item .item-desc .fa-star-5:before,
		.widget-rooms-list .rooms-item .item-desc h2 a:hover,
		.widget-rooms-list .rooms-item .item-desc .desc-features ul li .fa,
		.widget-rooms-list .rooms-item .item-price .price-inner .fa-star,
		.widget-rooms-list .rooms-item .item-price .price-inner .fa-star-1:before,
		.widget-rooms-list .rooms-item .item-price .price-inner .fa-star-2:before,
		.widget-rooms-list .rooms-item .item-price .price-inner .fa-star-3:before,
		.widget-rooms-list .rooms-item .item-price .price-inner .fa-star-4:before,
		.widget-rooms-list .rooms-item .item-price .price-inner .fa-star-5:before,
		.widget-rooms-detail .room-features ul li .fa,
		.widget-booking-form .booking-detail .detail-room .room-desc h3 a:hover,
		.widget-booking-form .booking-detail .detail-room .room-desc h4,
		.widget-booking-form .booking-detail .detail-info ul li.total p,
		.widget-booking-form .booking-help h3 .fa,
		.widget-blog-carousel .blog-item .item-desc h3 a:hover,
		.widget-blog-list .blog-item .item-desc h2 a:hover,
		.widget-blog-list .blog-item .item-desc h5 a,
		.widget-blog-sidebar .sidebar-categories ul li a:hover,
		.widget-blog-sidebar .sidebar-events ul li a:hover,
		.widget-blog-sidebar .sidebar-recent ul li a:hover,
		.widget-blog-sidebar .sidebar-archive ul li a:hover,
		.widget-blog-single .single-detail .detail-head a,
		.widget-blog-single .single-comments .comments-list .comment .comment-info .comment-reply a,
		.widget-contact-info a:hover,
		.widget-contact-review .review-item .item-inner a:hover,
		.site-header .header-bottom .header-nav ul li:hover > a,
		.site-footer .footer-bottom .footer-nav ul li a:hover,
		.widget-breadcrumb ul li,
		.recentcomments
		{color : <?php echo esc_attr( ot_get_option( 'grandium_theme_color_one' ) ); ?>;}

		.btn,
		.owl-carousel.owl-type1 .owl-nav [class*="owl-"]:hover,
		.owl-carousel.owl-type1 .owl-dots .owl-dot.active span,
		.owl-carousel.owl-type1 .owl-dots .owl-dot:hover span,
		.widget-pager ul li.active a,
		.widget-pager ul li.active:hover a,
		.widget-newsletter button,
		.widget-slider .widget-carousel .owl-dots .owl-dot.active span,
		.widget-slider .widget-carousel .owl-dots .owl-dot:hover span,
		.widget-offers-grid .offers-item .item-inner .item-desc .btn-link:before,
		.widget-filter-top ul li.active a,
		.widget-filter-top ul li.active:hover a,
		.widget-rooms-detail .room-slider .room-price,
		.widget-blog-carousel .blog-item .item-date,
		.widget-blog-sidebar .sidebar-events ul li span b,
		.widget-blog-sidebar .sidebar-tags ul li a:hover,
		.widget-blog-single .single-detail .detail-tags ul li a:hover,
		.site-header .header-bottom .header-nav > ul > li.sub:before,
		.site-header .header-bottom .header-toggle,
		.widget-social-icons ul li:hover a
		{background-color : <?php echo esc_attr( ot_get_option( 'grandium_theme_color_one' ) ); ?>;}

		.widget-offers-grid .offers-item .item-inner .item-photo:before
		{ border-color             : transparent transparent #d77b5d transparent; }

		.widget-gallery-grid .gallery-item:hover a:before
		{  border-bottom-color     : <?php echo esc_attr( ot_get_option( 'grandium_theme_color_one' ) ); ?>; }

		.widget-gallery-grid .gallery-item:hover a:before,
		.widget-rooms-detail .room-features ul li .fa
		{  border                  : 1px solid <?php echo esc_attr( ot_get_option( 'grandium_theme_color_one' ) ); ?>; }

		.navbar-nav > li > a:hover,
		.navbar-nav > li > a:focus,
		.navbar-nav > .active > a{color: <?php echo esc_attr( ot_get_option( 'grandium_theme_color_one' ) ); ?>; }

		a:hover, a:focus{color: <?php echo esc_attr( ot_get_option( 'grandium_theme_color_one' ) ); ?>; }
		.section-title:after{background-color: <?php echo esc_attr( ot_get_option( 'grandium_theme_color_one' ) ); ?>; }
		.col-showcase h3:after{background: <?php echo esc_attr( ot_get_option( 'grandium_theme_color_one' ) ); ?>; }
		span.breadcrumb-current{color: <?php echo esc_attr( ot_get_option( 'grandium_theme_color_one' ) ); ?>; }
		.widget-title:after{background: <?php echo esc_attr( ot_get_option( 'grandium_theme_color_one' ) ); ?>; }
		.widget ul li a{color: <?php echo esc_attr( ot_get_option( 'grandium_theme_color_one' ) ); ?>; }
		.widget a{color: <?php echo esc_attr( ot_get_option( 'grandium_theme_color_one' ) ); ?>; }
		#widget-area #searchform input#searchsubmit{background: <?php echo esc_attr( ot_get_option( 'grandium_theme_color_one' ) ); ?>; }
		#share-buttons i:hover{background-color: <?php echo esc_attr( ot_get_option( 'grandium_theme_color_one' ) ); ?>; }
		.entry-title a:hover{color: <?php echo esc_attr( ot_get_option( 'grandium_theme_color_one' ) ); ?>; }
		.entry-meta a:hover{color: <?php echo esc_attr( ot_get_option( 'grandium_theme_color_one' ) ); ?>; }
	<?php endif; ?>


	<?php if ( ot_get_option( 'grandium_header_bg' ) !='' ): ?>
	.site-header{background-color: <?php echo esc_attr( ot_get_option( 'grandium_header_bg' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_navitem' ) !='' ): ?>
    .site-header .header-bottom .header-nav ul li a,.site-header .header-top a,.site-header .header-top .header-lang ul li a{color: <?php echo esc_attr( ot_get_option( 'grandium_navitem' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_top_sz' ) !='' ): ?>
   .header-contact ul li a i{font-size: <?php echo esc_attr( ot_get_option( 'grandium_top_sz' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_navitemhover' ) !='' ): ?>
   .site-header .header-bottom .header-nav ul li a:hover{color: <?php echo esc_attr( ot_get_option( 'grandium_navitemhover' ) ); ?>; }
    <?php endif; ?>
		<?php if ( ot_get_option( 'grandium_nav_menu_ifs' ) !=0 ): ?>
			.site-header .header-bottom .header-nav ul li a,.site-header .header-top a,.site-header .header-top .header-lang ul li a{font-size: <?php echo esc_attr( ot_get_option( 'grandium_nav_menu_ifs' ) ); ?>px; }
			<?php endif; ?>
		<?php if ( ot_get_option( 'grandium_d_header_bg' ) !='' ): ?>
			.site-header .header-bottom .header-nav > ul > li.sub ul li a{background-color: <?php echo esc_attr( ot_get_option( 'grandium_d_header_bg' ) ); ?>!important; }
		<?php endif; ?>
		<?php if ( ot_get_option( 'grandium_d_navitem' ) !='' ): ?>
			.site-header .header-bottom .header-nav ul li .sub li a,.site-header .header-top .header-lang ul li .sub li a{color: <?php echo esc_attr( ot_get_option( 'grandium_d_navitem' ) ); ?>; }
		<?php endif; ?>

		<?php if ( ot_get_option( 'grandium_d_navitemhover' ) !='' ): ?>
			.site-header .header-bottom .header-nav ul li .sub li a:hover{color: <?php echo esc_attr( ot_get_option( 'grandium_d_navitemhover' ) ); ?>; }
		<?php endif; ?>

		<?php if ( ot_get_option( 'grandium_sticky_header_bg' ) !='' ): ?>
			.site-header.sticky-header.fixed {background-color: <?php echo esc_attr( ot_get_option( 'grandium_sticky_header_bg' ) ); ?>; }
		<?php endif; ?>

		<?php if ( ot_get_option( 'grandium_sticky_navitem' ) !='' ): ?>
			.site-header.sticky-header.fixed .header-bottom .header-nav ul li a{color: <?php echo esc_attr( ot_get_option( 'grandium_sticky_navitem' ) ); ?>; }
		<?php endif; ?>

		<?php if ( ot_get_option( 'grandium_sticky_navitemhover' ) !='' ): ?>
			.site-header.sticky-header.fixed .header-bottom .header-nav ul li a:hover{color: <?php echo esc_attr( ot_get_option( 'grandium_sticky_navitemhover' ) ); ?>; }
			.site-header .header-bottom .header-nav>ul>li.sub:before{background-color: <?php echo esc_attr( ot_get_option( 'grandium_sticky_navitemhover' ) ); ?>; }
		<?php endif; ?>



	<?php if ( ot_get_option( 'grandium_sidebarwidgetareabgcolor' ) !='' ): ?>
    #widget-area{background-color: <?php echo esc_attr( ot_get_option( 'grandium_sidebarwidgetareabgcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_sidebarwidgettitlecolor' ) !='' ): ?>
    .widget-title{font-weight:bold;color: <?php echo esc_attr( ot_get_option( 'grandium_sidebarwidgettitlecolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_sidebarwidgetgeneralcolor' ) !='' ): ?>
    .widget ul{color: <?php echo esc_attr( ot_get_option( 'grandium_sidebarwidgetgeneralcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_sidebarlinkcolor' ) !='' ): ?>
    .widget ul li a{text-decoration:none;color: <?php echo esc_attr( ot_get_option( 'grandium_sidebarlinkcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_sidebarlinkhovercolor' ) !='' ): ?>
    .widget ul li a:hover{color: <?php echo esc_attr( ot_get_option( 'grandium_sidebarlinkhovercolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_sidebarsearchsubmittextcolor' ) !='' ): ?>
    #widget-area #searchform input#searchsubmit{color:<?php echo esc_attr( ot_get_option( 'grandium_sidebarsearchsubmittextcolor' ) ); ?>;}
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_sidebarsearchsubmitbgcolor' ) !='' ): ?>
	#widget-area #searchform input#searchsubmit{background-color: <?php echo esc_attr( ot_get_option( 'grandium_sidebarsearchsubmitbgcolor' ) ); ?>; }
    <?php endif; ?>

	<?php if ( ot_get_option( 'grandium_logowidth' ) !='' ): ?>
    .site-header .header-bottom .header-logo img{width:<?php echo esc_attr( ot_get_option( 'grandium_logowidth' ) ); ?>px; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_logoheight' ) !='' ): ?>
    .site-header .header-bottom .header-logo img{height:<?php echo esc_attr( ot_get_option( 'grandium_logoheight' ) ); ?>px; }
    <?php endif; ?>


	<?php if ( ot_get_option( 'grandium_otherpageheadbg' ) !='' ): ?>
    .widget-background {background: transparent url( <?php echo esc_attr( ot_get_option( 'grandium_otherpageheadbg' ) ); ?>)no-repeat  center top / cover!important; }
    <?php endif; ?>

	<?php if ( ot_get_option( 'grandium_blogheaderbgheight' ) !='' ): ?>
    .widget-page-title{height: <?php echo esc_attr( ot_get_option( 'grandium_blogheaderbgheight' ) ); ?>vh !important; }
    <?php endif; ?>

	<?php if ( ot_get_option( 'grandium_blogheaderpaddingtop' ) !='' ): ?>
		.widget-page-title {
			padding-top: <?php echo esc_attr( ot_get_option( 'grandium_blogheaderpaddingtop' ) ); ?>px !important;
			padding-bottom: <?php echo esc_attr( ot_get_option( 'grandium_blogheaderpaddingbottom' ) ); ?>px !important;
		}
    <?php endif; ?>

	<?php if ( ot_get_option( 'grandium_blogheadingcolor' ) !='' ): ?>
    .widget-page-title h5{color: <?php echo esc_attr( ot_get_option( 'grandium_blogheadingcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogsubtitlecolor' ) !='' ): ?>
    .widget-page-title h1, .widget-page-title p{color: <?php echo esc_attr( ot_get_option( 'grandium_blogsubtitlecolor' ) ); ?>; }
    <?php endif; ?>



	<?php if ( ot_get_option( 'grandium_frontpageheadbg' ) !='' ): ?>
   .widget-background{background: transparent url( <?php echo esc_attr( ot_get_option( 'grandium_frontpageheadbg' ) ); ?>)no-repeat scroll center top / cover; }
    <?php endif; ?>

	<?php if ( ot_get_option('grandium_mask_c_page_header') == 'off') : ?>
	.custom-page-header {background-image: none !important;  }
	<?php endif; ?>

	.custom-page-header.masked:after {
	background-color: <?php echo esc_attr( ot_get_option( 'grandium_blogheaderbgcolor' ) ); ?> !important;
	}


	<?php if ( ot_get_option( 'grandium_frontpage_header_heading_color' ) !='' ): ?>
    .masthead.rel-1 h1{color: <?php echo esc_attr( ot_get_option( 'grandium_frontpage_header_heading_color' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_frontpage_header_headingstrong_color' ) !='' ): ?>
    .masthead.rel-1 h1 strong{color: <?php echo esc_attr( ot_get_option( 'grandium_frontpage_header_headingstrong_color' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_frontpage_header_slogan_color' ) !='' ): ?>
    .masthead.rel-1 p.text-muted{color: <?php echo esc_attr( ot_get_option( 'grandium_frontpage_header_slogan_color' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_frontpage_header_buttonbg_color' ) !='' ): ?>
    .masthead.rel-1 a.btn {background-color: <?php echo esc_attr( ot_get_option( 'grandium_frontpage_header_buttonbg_color' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_frontpage_header_buttonbg_hover_color' ) !='' ): ?>
    .masthead.rel-1 a.btn:hover {background-color: <?php echo esc_attr( ot_get_option( 'grandium_frontpage_header_buttonbg_hover_color' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_frontpage_header_button_title_color' ) !='' ): ?>
    .masthead.rel-1 a.btn:hover {color: <?php echo esc_attr( ot_get_option( 'grandium_frontpage_header_button_title_color' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_frontpage_header_button_title_hover_color' ) !='' ): ?>
    .masthead.rel-1 a.btn:hover {color: <?php echo esc_attr( ot_get_option( 'grandium_frontpage_header_button_title_hover_color' ) ); ?>; }
    <?php endif; ?>


	<?php if ( ot_get_option( 'grandium_singlepageheadbg' ) !='' ): ?>
    .single .widget-background {background: transparent url( <?php echo esc_attr( ot_get_option( 'grandium_singlepageheadbg' ) ); ?>)no-repeat  center top / cover!important; }
    <?php endif; ?>

		<?php if ( ot_get_option( 'grandium_single_room_bg' ) !='' ): ?>
		.single.single-rooms .widget-background{background: transparent url( <?php echo esc_attr( ot_get_option( 'grandium_single_room_bg' ) ); ?>)no-repeat  center top / cover!important; }
			<?php endif; ?>
	<?php if ( ot_get_option( 'grandium_singleheaderbgcolor' ) !='' ): ?>
    .single .widget-page-title{background-color: <?php echo esc_attr( ot_get_option( 'grandium_singleheaderbgcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_singleheadingcolor' ) !='' ): ?>
    .single .widget-page-title h1{color: <?php echo esc_attr( ot_get_option( 'grandium_singleheadingcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_single_heading_fontsize' ) !='' ): ?>
    .single .widget-page-title h1{font-size: <?php echo esc_attr( ot_get_option( 'grandium_single_heading_fontsize' ) ); ?>px; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_singleheaderbgheight' ) !='' ): ?>
    .single .widget-page-title{height: <?php echo esc_attr( ot_get_option( 'grandium_singleheaderbgheight' ) ); ?>vh !important; }
    <?php endif; ?>

	<?php if (( ot_get_option( 'grandium_singleheaderpaddingtop' ) !='' )||( ot_get_option( 'grandium_singleheaderpaddingbottom' ) !='' )): ?>
    @media (min-width: 768px){
		.single .widget-page-title {
			padding-top: <?php echo esc_attr( ot_get_option( 'grandium_singleheaderpaddingtop' ) ); ?>px !important;
			padding-bottom: <?php echo esc_attr( ot_get_option( 'grandium_singleheaderpaddingbottom' ) ); ?>px !important;
		}
	}
    <?php endif; ?>



	<?php if ( ot_get_option( 'grandium_archivepageheadbg' ) !='' ): ?>
    .archive .widget-background {background: transparent url( <?php echo esc_attr( ot_get_option( 'grandium_archivepageheadbg' ) ); ?>)no-repeat  center top / cover!important; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_archiveheaderbgcolor' ) !='' ): ?>
    .archive .widget-page-title{background-color: <?php echo esc_attr( ot_get_option( 'grandium_archiveheaderbgcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_archiveheadingcolor' ) !='' ): ?>
    .archive .widget-page-title h1{color: <?php echo esc_attr( ot_get_option( 'grandium_archiveheadingcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_archive_heading_fontsize' ) !='' ): ?>
    .archive .widget-page-title h1{font-size: <?php echo esc_attr( ot_get_option( 'grandium_archive_heading_fontsize' ) ); ?>px; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_archiveheaderparagraphcolor' ) !='' ): ?>
    .archive .widget-page-title p{color: <?php echo esc_attr( ot_get_option( 'grandium_archiveheaderparagraphcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_archiveheaderbgheight' ) !='' ): ?>
    .archive .widget-page-title{height: <?php echo esc_attr( ot_get_option( 'grandium_archiveheaderbgheight' ) ); ?>vh !important; }
    <?php endif; ?>
	<?php if (( ot_get_option( 'grandium_archiveheaderpaddingtop' ) !='' )||( ot_get_option( 'grandium_archiveheaderpaddingbottom' ) !='' )): ?>
    @media (min-width: 768px){
    .archive .widget-page-title {padding-top: <?php echo esc_attr( ot_get_option( 'grandium_archiveheaderpaddingtop' ) ); ?>px !important;
	padding-bottom: <?php echo esc_attr( ot_get_option( 'grandium_archiveheaderpaddingbottom' ) ); ?>px !important; } }
	<?php endif; ?>

	<?php if ( ot_get_option( 'grandium_errorpageheadbg' ) !='' ): ?>
    .error404 .widget-background {background: transparent url( <?php echo esc_attr( ot_get_option( 'grandium_errorpageheadbg' ) ); ?>)no-repeat  center top / cover!important; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_errorheaderbgcolor' ) !='' ): ?>
    .error404 .widget-page-title{background-color: <?php echo esc_attr( ot_get_option( 'grandium_errorheaderbgcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_errorheadingcolor' ) !='' ): ?>
    .error404 .widget-page-title h1{color: <?php echo esc_attr( ot_get_option( 'grandium_errorheadingcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_error_heading_fontsize' ) !='' ): ?>
    .error404 .widget-page-title h1{font-size: <?php echo esc_attr( ot_get_option( 'grandium_error_heading_fontsize' ) ); ?>px; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_errorheaderparagraphcolor' ) !='' ): ?>
    .error404 .widget-page-title p{color: <?php echo esc_attr( ot_get_option( 'grandium_errorheaderparagraphcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_errorheaderbgheight' ) !='' ): ?>
    .error404 .widget-page-title{height: <?php echo esc_attr( ot_get_option( 'grandium_errorheaderbgheight' ) ); ?>vh !important; }
    <?php endif; ?>
	<?php if (( ot_get_option( 'grandium_errorheaderpaddingtop' ) !='' )||( ot_get_option( 'grandium_errorheaderpaddingbottom' ) !='' )): ?>
    @media (min-width: 768px){
    .error404 .widget-page-title {padding-top: <?php echo esc_attr( ot_get_option( 'grandium_errorheaderpaddingtop' ) ); ?>px !important;
	padding-bottom: <?php echo esc_attr( ot_get_option( 'grandium_errorheaderpaddingbottom' ) ); ?>px !important; } }
	<?php endif; ?>

	<?php if ( ot_get_option( 'grandium_searchpageheadbg' ) !='' ): ?>
    .search .widget-background {background: transparent url( <?php echo esc_attr( ot_get_option( 'grandium_searchpageheadbg' ) ); ?>)no-repeat scroll center top / cover!important; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_searchheaderbgcolor' ) !='' ): ?>
    .search .widget-page-title{background-color: <?php echo esc_attr( ot_get_option( 'grandium_searchheaderbgcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_searchheadingcolor' ) !='' ): ?>
    .search .widget-page-title h1{color: <?php echo esc_attr( ot_get_option( 'grandium_searchheadingcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_search_heading_fontsize' ) !='' ): ?>
    .search .widget-page-title h1{font-size: <?php echo esc_attr( ot_get_option( 'grandium_search_heading_fontsize' ) ); ?>px; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_searchheaderparagraphcolor' ) !='' ): ?>
    .search .widget-page-title p{color: <?php echo esc_attr( ot_get_option( 'grandium_searchheaderparagraphcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_searchheaderbgheight' ) !='' ): ?>
    .search .widget-page-title{height: <?php echo esc_attr( ot_get_option( 'grandium_searchheaderbgheight' ) ); ?>vh !important; }
    <?php endif; ?>
	<?php if (( ot_get_option( 'grandium_searchheaderpaddingtop' ) !='' )||( ot_get_option( 'grandium_searchheaderpaddingbottom' ) !='' )): ?>
    @media (min-width: 768px){
    .search .widget-page-title {padding-top: <?php echo esc_attr( ot_get_option( 'grandium_searchheaderpaddingtop' ) ); ?>px !important;
	padding-bottom: <?php echo esc_attr( ot_get_option( 'grandium_searchheaderpaddingbottom' ) ); ?>px !important; } }
	<?php endif; ?>

	<?php if ( ot_get_option( 'grandium_blogbreadcrubmscolor' ) !='' ): ?>
    a.breadcrumb-item{color: <?php echo esc_attr( ot_get_option( 'grandium_blogbreadcrubmscolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogbreadcrubmshovercolor' ) !='' ): ?>
    a.breadcrumb-item:hover{color: <?php echo esc_attr( ot_get_option( 'grandium_blogbreadcrubmshovercolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogbreadcrubmscurrentcolor' ) !='' ): ?>
    span.breadcrumb-current{color: <?php echo esc_attr( ot_get_option( 'grandium_blogbreadcrubmscurrentcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogbreadcrubmsfontsize' ) !='' ): ?>
    .lead-breadcrubms{font-size: <?php echo esc_attr( ot_get_option( 'grandium_blogbreadcrubmsfontsize' ) ); ?>px; }
    <?php endif; ?>

	<?php if ( ot_get_option( 'grandium_blogposttitlecolor' ) !='' ): ?>
    .entry-title a{color: <?php echo esc_attr( ot_get_option( 'grandium_blogposttitlecolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogposttitlhoverecolor' ) !='' ): ?>
    .entry-title a:hover{color: <?php echo esc_attr( ot_get_option( 'grandium_blogposttitlhoverecolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogmetacolor' ) !='' ): ?>
    .entry-meta li{color: <?php echo esc_attr( ot_get_option( 'grandium_blogmetacolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogmetalinktextcolor' ) !='' ): ?>
    .entry-meta li a{color: <?php echo esc_attr( ot_get_option( 'grandium_blogmetalinktextcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogmetalinkhovercolor' ) !='' ): ?>
    .entry-meta li a:hover{color: <?php echo esc_attr( ot_get_option( 'grandium_blogmetalinkhovercolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogmetalinktextbgcolor' ) !='' ): ?>
    .entry-meta li a{background-color: <?php echo esc_attr( ot_get_option( 'grandium_blogmetalinktextbgcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogmetalinktextbghovercolor' ) !='' ): ?>
    .entry-meta li a:hover{background-color: <?php echo esc_attr( ot_get_option( 'grandium_blogmetalinktextbghovercolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogpostparagraphcolor' ) !='' ): ?>
    .entry-content p{color: <?php echo esc_attr( ot_get_option( 'grandium_blogpostparagraphcolor' ) ); ?>; }
	<?php else : ?>
	.entry-content p{color:#000;}
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogpostbuttonbgcolor' ) !='' ): ?>
    a.margin_30{background-color:<?php echo esc_attr( ot_get_option( 'grandium_blogpostbuttonbgcolor' ) ); ?>;}
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogpostbuttonbghovercolor' ) !='' ): ?>
    a.margin_30:hover{background-color:<?php echo esc_attr( ot_get_option( 'grandium_blogpostbuttonbghovercolor' ) ); ?>;}
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogpostbuttontitlecolor' ) !='' ): ?>
    a.margin_30{color:<?php echo esc_attr( ot_get_option( 'grandium_blogpostbuttontitlecolor' ) ); ?>;}
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogpostbuttontitlehovercolor' ) !='' ): ?>
    a.margin_30:hover{color:<?php echo esc_attr( ot_get_option( 'grandium_blogpostbuttontitlehovercolor' ) ); ?>;}
    <?php endif; ?>


	<?php if ( ot_get_option( 'grandium_blogsharebgcolor' ) !='' ): ?>
    #share-buttons i{ background-color: <?php echo esc_attr( ot_get_option( 'grandium_blogsharebgcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogsharebghovercolor' ) !='' ): ?>
    #share-buttons i:hover{ background-color: <?php echo esc_attr( ot_get_option( 'grandium_blogsharebghovercolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogsharecolor' ) !='' ): ?>
    #share-buttons i{ color: <?php echo esc_attr( ot_get_option( 'grandium_blogsharecolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogsharehovercolor' ) !='' ): ?>
    #share-buttons i:hover{ color: <?php echo esc_attr( ot_get_option( 'grandium_blogsharehovercolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogmetalinktextcolor' ) !='' ): ?>
    p.logged-in-as a{color: <?php echo esc_attr( ot_get_option( 'grandium_blogmetalinktextcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogmetalinkhovercolor' ) !='' ): ?>
    p.logged-in-as a:hover{color: <?php echo esc_attr( ot_get_option( 'grandium_blogmetalinkhovercolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogmetalinktextbgcolor' ) !='' ): ?>
    p.logged-in-as a{background-color: <?php echo esc_attr( ot_get_option( 'grandium_blogmetalinktextbgcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogmetalinktextbghovercolor' ) !='' ): ?>
    p.logged-in-as a:hover{background-color: <?php echo esc_attr( ot_get_option( 'grandium_blogmetalinktextbghovercolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogmetalinktextcolor' ) !='' ): ?>
    a.comment-edit-link,a.comment-reply-link{color: <?php echo esc_attr( ot_get_option( 'grandium_blogmetalinktextcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogmetalinkhovercolor' ) !='' ): ?>
    a.comment-edit-link:hover,a.comment-reply-link:hover{color: <?php echo esc_attr( ot_get_option( 'grandium_blogmetalinkhovercolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogmetalinktextbgcolor' ) !='' ): ?>
    a.comment-edit-link,a.comment-reply-link{background-color: <?php echo esc_attr( ot_get_option( 'grandium_blogmetalinktextbgcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogmetalinktextbghovercolor' ) !='' ): ?>
    a.comment-edit-link:hover,a.comment-reply-link:hover{background-color: <?php echo esc_attr( ot_get_option( 'grandium_blogmetalinktextbghovercolor' ) ); ?>; }
    <?php endif; ?>

	<?php if ( ot_get_option( 'grandium_blogcommentformsubmitcolor' ) !='' ): ?>
    .comment-form .submit{color: <?php echo esc_attr( ot_get_option( 'grandium_blogcommentformsubmitcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogcommentformsubmithovercolor' ) !='' ): ?>
    .comment-form .submit:hover{color: <?php echo esc_attr( ot_get_option( 'grandium_blogcommentformsubmithovercolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogcommentformsubmitbgcolor' ) !='' ): ?>
    .comment-form .submit{background-color: <?php echo esc_attr( ot_get_option( 'grandium_blogcommentformsubmitbgcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_blogcommentformsubmitbghovercolor' ) !='' ): ?>
    .comment-form .submit:hover{background-color: <?php echo esc_attr( ot_get_option( 'grandium_blogcommentformsubmitbghovercolor' ) ); ?>; }
    <?php endif; ?>


	<?php if ( ot_get_option( 'grandium_pagertitlecolor' ) !='' ): ?>
    .pager li a{color: <?php echo esc_attr( ot_get_option( 'grandium_pagertitlecolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_pagertitlehovercolor' ) !='' ): ?>
    .pager li a:hover{color: <?php echo esc_attr( ot_get_option( 'grandium_pagertitlehovercolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_pagerbgcolor' ) !='' ): ?>
    .pager li a{background-color: <?php echo esc_attr( ot_get_option( 'grandium_pagerbgcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_pagerbghovercolor' ) !='' ): ?>
    .pager li a:hover{background-color: <?php echo esc_attr( ot_get_option( 'grandium_pagerbghovercolor' ) ); ?>; }
    <?php endif; ?>


	<?php if ( ot_get_option( 'grandium_footerbgcolor' ) !='' ): ?>
      body .site-footer .footer-bottom{background-color: <?php echo esc_attr( ot_get_option( 'grandium_footerbgcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_footer_color' ) !='' ): ?>
	  body .site-footer .footer-bottom{color: <?php echo esc_attr( ot_get_option( 'grandium_footer_color' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_footersocialcolor' ) !='' ): ?>
    .widget-social-icons ul li a{color: <?php echo esc_attr( ot_get_option( 'grandium_footersocialcolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_footersocialhovercolor' ) !='' ): ?>
    .widget-social-icons ul li a:hover{color: <?php echo esc_attr( ot_get_option( 'grandium_footersocialhovercolor' ) ); ?>; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_social_fontsize' ) !='' ): ?>
    .widget-social-icons ul li a{font-size: <?php echo esc_attr( ot_get_option( 'grandium_social_fontsize' ) ); ?>px; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_social_margin_left' ) !='' ): ?>
    .widget-social-icons ul li a{margin-left: <?php echo esc_attr( ot_get_option( 'grandium_social_margin_left' ) ); ?>px; }
    <?php endif; ?>
	<?php if ( ot_get_option( 'grandium_social_opacity' ) !='' ): ?>
    .widget-social-icons ul li a{opacity: <?php echo esc_attr( ot_get_option( 'grandium_social_opacity' ) ); ?>; }
    <?php endif; ?>

	<?php
	    // tipigrof
	    $grandium_tipigrof = ot_get_option( 'grandium_tipigrof', array() );
	    if ( !empty(array_filter($grandium_tipigrof)) ) {
	        echo 'body{';
	        if ( !empty($grandium_tipigrof['font-color']) )     { echo 'color:'.esc_attr( $grandium_tipigrof['font-color'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof['font-family']) )    { echo 'font-family:"'.esc_attr( $grandium_tipigrof['font-family'] ).'"!important;'; }
	        if ( !empty($grandium_tipigrof['font-size']) )      { echo 'font-size:'.esc_attr( $grandium_tipigrof['font-size'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof['font-style']) )     { echo 'font-style:'.esc_attr( $grandium_tipigrof['font-style'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof['font-variant']) )   { echo 'font-variant:'.esc_attr( $grandium_tipigrof['font-variant'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof['font-weight']) )    { echo 'font-weight:'.esc_attr( $grandium_tipigrof['font-weight'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof['letter-spacing']) ) { echo 'letter-spacing:'.esc_attr( $grandium_tipigrof['letter-spacing'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof['line-height']))     { echo 'line-height:'.esc_attr( $grandium_tipigrof['line-height'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof['text-decoration'])) { echo 'text-decoration:'.esc_attr($grandium_tipigrof['text-decoration']).'!important;'; }
	        if ( !empty($grandium_tipigrof['text-transform']))  { echo 'text-transform:'.esc_attr($grandium_tipigrof['text-transform']).'!important;'; }
	        echo '}';
	    }
	    $grandium_tipigrofa = ot_get_option( 'grandium_tipigrofa', array() );
	    if ( !empty(array_filter($grandium_tipigrofa)) ) {
	        echo 'body a{';
	        if ( !empty($grandium_tipigrofa['font-color']) )     { echo 'color:'.esc_attr( $grandium_tipigrofa['font-color'] ).';'; }
	        if ( !empty($grandium_tipigrofa['font-family']) )    { echo 'font-family:"'.esc_attr( $grandium_tipigrofa['font-family'] ).'"!important;'; }
	        if ( !empty($grandium_tipigrofa['font-size']) )      { echo 'font-size:'.esc_attr( $grandium_tipigrofa['font-size'] ).'!important;'; }
	        if ( !empty($grandium_tipigrofa['font-style']) )     { echo 'font-style:'.esc_attr( $grandium_tipigrofa['font-style'] ).'!important;'; }
	        if ( !empty($grandium_tipigrofa['font-variant']) )   { echo 'font-variant:'.esc_attr( $grandium_tipigrofa['font-variant'] ).'!important;'; }
	        if ( !empty($grandium_tipigrofa['font-weight']) )    { echo 'font-weight:'.esc_attr( $grandium_tipigrofa['font-weight'] ).'!important;'; }
	        if ( !empty($grandium_tipigrofa['letter-spacing']) ) { echo 'letter-spacing:'.esc_attr( $grandium_tipigrofa['letter-spacing'] ).'!important;'; }
	        if ( !empty($grandium_tipigrofa['line-height']))     { echo 'line-height:'.esc_attr( $grandium_tipigrofa['line-height'] ).'!important;'; }
	        if ( !empty($grandium_tipigrofa['text-decoration'])) { echo 'text-decoration:'.esc_attr($grandium_tipigrofa['text-decoration']).'!important;'; }
	        if ( !empty($grandium_tipigrofa['text-transform']))  { echo 'text-transform:'.esc_attr($grandium_tipigrofa['text-transform']).'!important;'; }
	        echo '}';
	    }

	    $grandium_tipigrof1 = ot_get_option( 'grandium_tipigrof1', array() );
	    if ( !empty(array_filter($grandium_tipigrof1)) ) {
	        echo 'h1{';
	        if ( !empty($grandium_tipigrof1['font-color']) )     { echo 'color:'.esc_attr( $grandium_tipigrof1['font-color'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof1['font-family']) )    { echo 'font-family:"'.esc_attr( $grandium_tipigrof1['font-family'] ).'"!important;'; }
	        if ( !empty($grandium_tipigrof1['font-size']) )      { echo 'font-size:'.esc_attr( $grandium_tipigrof1['font-size'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof1['font-style']) )     { echo 'font-style:'.esc_attr( $grandium_tipigrof1['font-style'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof1['font-variant']) )   { echo 'font-variant:'.esc_attr( $grandium_tipigrof1['font-variant'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof1['font-weight']) )    { echo 'font-weight:'.esc_attr( $grandium_tipigrof1['font-weight'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof1['letter-spacing']) ) { echo 'letter-spacing:'.esc_attr( $grandium_tipigrof1['letter-spacing'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof1['line-height']))     { echo 'line-height:'.esc_attr( $grandium_tipigrof1['line-height'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof1['text-decoration'])) { echo 'text-decoration:'.esc_attr($grandium_tipigrof1['text-decoration']).'!important;'; }
	        if ( !empty($grandium_tipigrof1['text-transform']))  { echo 'text-transform:'.esc_attr($grandium_tipigrof1['text-transform']).'!important;'; }
	        echo '}';
	    }

	    $grandium_tipigrof2 = ot_get_option( 'grandium_tipigrof2', array() );
	    if ( !empty(array_filter($grandium_tipigrof2)) ) {
	        echo 'h2{';
	        if ( !empty($grandium_tipigrof2['font-color']) )     { echo 'color:'.esc_attr( $grandium_tipigrof2['font-color'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof2['font-family']) )    { echo 'font-family:"'.esc_attr( $grandium_tipigrof2['font-family'] ).'"!important;'; }
	        if ( !empty($grandium_tipigrof2['font-size']) )      { echo 'font-size:'.esc_attr( $grandium_tipigrof2['font-size'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof2['font-style']) )     { echo 'font-style:'.esc_attr( $grandium_tipigrof2['font-style'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof2['font-variant']) )   { echo 'font-variant:'.esc_attr( $grandium_tipigrof2['font-variant'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof2['font-weight']) )    { echo 'font-weight:'.esc_attr( $grandium_tipigrof2['font-weight'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof2['letter-spacing']) ) { echo 'letter-spacing:'.esc_attr( $grandium_tipigrof2['letter-spacing'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof2['line-height']))     { echo 'line-height:'.esc_attr( $grandium_tipigrof2['line-height'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof2['text-decoration'])) { echo 'text-decoration:'.esc_attr($grandium_tipigrof2['text-decoration']).'!important;'; }
	        if ( !empty($grandium_tipigrof2['text-transform']))  { echo 'text-transform:'.esc_attr($grandium_tipigrof2['text-transform']).'!important;'; }
	        echo '}';
	    }

	    $grandium_tipigrof3 = ot_get_option( 'grandium_tipigrof3', array() );
	    if ( !empty(array_filter($grandium_tipigrof3)) ) {
	        echo 'h3{';
	        if ( !empty($grandium_tipigrof3['font-color']) )     { echo 'color:'.esc_attr( $grandium_tipigrof3['font-color'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof3['font-family']) )    { echo 'font-family:"'.esc_attr( $grandium_tipigrof3['font-family'] ).'"!important;'; }
	        if ( !empty($grandium_tipigrof3['font-size']) )      { echo 'font-size:'.esc_attr( $grandium_tipigrof3['font-size'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof3['font-style']) )     { echo 'font-style:'.esc_attr( $grandium_tipigrof3['font-style'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof3['font-variant']) )   { echo 'font-variant:'.esc_attr( $grandium_tipigrof3['font-variant'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof3['font-weight']) )    { echo 'font-weight:'.esc_attr( $grandium_tipigrof3['font-weight'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof3['letter-spacing']) ) { echo 'letter-spacing:'.esc_attr( $grandium_tipigrof3['letter-spacing'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof3['line-height']))     { echo 'line-height:'.esc_attr( $grandium_tipigrof3['line-height'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof3['text-decoration'])) { echo 'text-decoration:'.esc_attr($grandium_tipigrof3['text-decoration']).'!important;'; }
	        if ( !empty($grandium_tipigrof3['text-transform']))  { echo 'text-transform:'.esc_attr($grandium_tipigrof3['text-transform']).'!important;'; }
	        echo '}';
	    }

	    $grandium_tipigrof4 = ot_get_option( 'grandium_tipigrof4', array() );
	    if ( !empty(array_filter($grandium_tipigrof4)) ) {
	        echo 'h4{';
	        if ( !empty($grandium_tipigrof4['font-color']) )     { echo 'color:'.esc_attr( $grandium_tipigrof4['font-color'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof4['font-family']) )    { echo 'font-family:"'.esc_attr( $grandium_tipigrof4['font-family'] ).'"!important;'; }
	        if ( !empty($grandium_tipigrof4['font-size']) )      { echo 'font-size:'.esc_attr( $grandium_tipigrof4['font-size'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof4['font-style']) )     { echo 'font-style:'.esc_attr( $grandium_tipigrof4['font-style'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof4['font-variant']) )   { echo 'font-variant:'.esc_attr( $grandium_tipigrof4['font-variant'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof4['font-weight']) )    { echo 'font-weight:'.esc_attr( $grandium_tipigrof4['font-weight'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof4['letter-spacing']) ) { echo 'letter-spacing:'.esc_attr( $grandium_tipigrof4['letter-spacing'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof4['line-height']))     { echo 'line-height:'.esc_attr( $grandium_tipigrof4['line-height'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof4['text-decoration'])) { echo 'text-decoration:'.esc_attr($grandium_tipigrof4['text-decoration']).'!important;'; }
	        if ( !empty($grandium_tipigrof4['text-transform']))  { echo 'text-transform:'.esc_attr($grandium_tipigrof4['text-transform']).'!important;'; }
	        echo '}';
	    }

	    $grandium_tipigrof5 = ot_get_option( 'grandium_tipigrof5', array() );
	    if ( !empty(array_filter($grandium_tipigrof5)) ) {
	        echo 'h5{';
	        if ( !empty($grandium_tipigrof5['font-color']) )     { echo 'color:'.esc_attr( $grandium_tipigrof5['font-color'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof5['font-family']) )    { echo 'font-family:"'.esc_attr( $grandium_tipigrof5['font-family'] ).'"!important;'; }
	        if ( !empty($grandium_tipigrof5['font-size']) )      { echo 'font-size:'.esc_attr( $grandium_tipigrof5['font-size'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof5['font-style']) )     { echo 'font-style:'.esc_attr( $grandium_tipigrof5['font-style'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof5['font-variant']) )   { echo 'font-variant:'.esc_attr( $grandium_tipigrof5['font-variant'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof5['font-weight']) )    { echo 'font-weight:'.esc_attr( $grandium_tipigrof5['font-weight'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof5['letter-spacing']) ) { echo 'letter-spacing:'.esc_attr( $grandium_tipigrof5['letter-spacing'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof5['line-height']))     { echo 'line-height:'.esc_attr( $grandium_tipigrof5['line-height'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof5['text-decoration'])) { echo 'text-decoration:'.esc_attr($grandium_tipigrof5['text-decoration']).'!important;'; }
	        if ( !empty($grandium_tipigrof5['text-transform']))  { echo 'text-transform:'.esc_attr($grandium_tipigrof5['text-transform']).'!important;'; }
	        echo '}';
	    }

	    $grandium_tipigrof6 = ot_get_option( 'grandium_tipigrof6', array() );
	    if ( !empty(array_filter($grandium_tipigrof6)) ) {
	        echo 'h6{';
	        if ( !empty($grandium_tipigrof6['font-color']) )     { echo 'color:'.esc_attr( $grandium_tipigrof6['font-color'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof6['font-family']) )    { echo 'font-family:"'.esc_attr( $grandium_tipigrof6['font-family'] ).'"!important;'; }
	        if ( !empty($grandium_tipigrof6['font-size']) )      { echo 'font-size:'.esc_attr( $grandium_tipigrof6['font-size'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof6['font-style']) )     { echo 'font-style:'.esc_attr( $grandium_tipigrof6['font-style'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof6['font-variant']) )   { echo 'font-variant:'.esc_attr( $grandium_tipigrof6['font-variant'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof6['font-weight']) )    { echo 'font-weight:'.esc_attr( $grandium_tipigrof6['font-weight'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof6['letter-spacing']) ) { echo 'letter-spacing:'.esc_attr( $grandium_tipigrof6['letter-spacing'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof6['line-height']))     { echo 'line-height:'.esc_attr( $grandium_tipigrof6['line-height'] ).'!important;'; }
	        if ( !empty($grandium_tipigrof6['text-decoration'])) { echo 'text-decoration:'.esc_attr($grandium_tipigrof6['text-decoration']).'!important;'; }
	        if ( !empty($grandium_tipigrof6['text-transform']))  { echo 'text-transform:'.esc_attr($grandium_tipigrof6['text-transform']).'!important;'; }
	        echo '}';
	    }

	?>

   .loaded {
		overflow-x: hidden;
	}

	<?php if ( ot_get_option('grandium_social_section') == 'off') : ?>
	.site-footer .footer-top:before {content: inherit;}
	<?php endif; ?>
	<?php if (esc_attr( ot_get_option( 'woo_column' ) =='3' )) : ?>
	.woocommerce ul.products li.product, .woocommerce-page ul.products li.product {
    float: left;
    margin: 0 1.8% 2.992em 0;
    padding: 0;
    position: relative;
    width: 31.05%;
	}
	<?php endif; ?>

	<?php if (esc_attr( ot_get_option( 'woo_column' ) =='2' )) : ?>
	.woocommerce ul.products li.product, .woocommerce-page ul.products li.product {
    float: left;
    margin: 0 1.8% 2.992em 0;
    padding: 0;
    position: relative;
    width: 48.05%;
	}
	<?php endif; ?>
	<?php if(ot_get_option('additionalcss')) { echo  ot_get_option( 'additionalcss' ) ; } ?>

	</style>

	<?php if ( ot_get_option( 'additionaljs' ) !='' ): ?>
	<script type="text/javascript">
	<?php if(ot_get_option('additionaljs')) { echo  ot_get_option( 'additionaljs' ) ; } ?>
	</script>
	<?php endif; ?>

<?php endif; ?>
<?php }
add_action('wp_head','grandium_custom_styling');

/**
 * Adds a apple touch link to the page head
 */
function grandium_appleTouchLink(){
        // list of directories to check for icons
        $directories = array(
                rtrim(get_stylesheet_directory(), '/') . '/'      =>  rtrim(get_stylesheet_directory_uri(), '/') . '/',                // theme directory
                rtrim(ABSPATH, '/') . '/'       => rtrim(site_url(), '/') . '/' // web root
        );

        /**
         * Add references to any existing IOS icons
         */
        $iconName = 'apple-touch-icon%s%s.png';      // the icon name convention
        $iconSizes = array(                          // available icon sizes
                '',
                '76x76',
                '120x120',
                '152x152',
                '167x167',
                '180x180'
        );

        foreach($iconSizes as $size){
                $hasSize = $size != ''; // check whether we actually have a size defined or if it is empty (default)

                $files = array(
                        'apple-touch-icon'              => sprintf($iconName, $hasSize ? '-' . $size : '', ''),
                        'apple-touch-icon-precomposed'  => sprintf($iconName, $hasSize ? '-' . $size : '', '-precomposed')
                );

                foreach($directories as $dir => $url){
                        foreach($files as $rel => $file){
                                if(file_exists($dir . $file)){
                                        // we have an icon file
                                        echo '<link rel="' . $rel . '"' . ($hasSize ? ' sizes="' . $size . '"' : '') . ' href="' . $url . $file . '">' . "\n";
                                        break 2;        // break out of the file and directories loop
                                }
                        }
                }
        }
}
// add apple icon link call
add_action( 'wp_head', 'grandium_appleTouchLink');
