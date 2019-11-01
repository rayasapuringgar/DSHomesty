<!-- Section Rooms Detail -->
    <div class="section">
        <div class="wrapper-inner">
            <div class="widget-rooms-detail">
                <div class="widget-inner">

					<?php
						$grandium_features_list		= 	rwmb_meta( 'grandium_features_list');
						$grandium_name				= 	rwmb_meta( 'grandium_name');
						$grandium_label				= 	rwmb_meta( 'grandium_label');
						$grandium_rate				= 	rwmb_meta( 'grandium_rate');
						$grandium_currency			= 	rwmb_meta( 'grandium_currency');
						$grandium_price				= 	rwmb_meta( 'grandium_price');
						$grandium_sale_price		= 	rwmb_meta( 'grandium_sale_price');
                        $grandium_room_images		=   rwmb_meta( 'grandium_rooms_images' );
						$grandium_room_shortcode	=   rwmb_meta( 'grandium_room_shortcode' );
						$grandium_room_shortcode_v	=   rwmb_meta( 'grandium_room_shortcode_v' );
						$grandium_features_list_v	=   rwmb_meta( 'grandium_features_list_v' );
						$grandium_room_price_v		=   rwmb_meta( 'grandium_room_price_v' );

						$grandium_thumb 			= get_post_thumbnail_id();
						$grandium_img_url 			= wp_get_attachment_url( $grandium_thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
                        if( function_exists('aq_resize') ) {
    						$grandium_image = aq_resize( $grandium_img_url, 1200, 700, true,true,true ); //resize & crop the image
                        } else {
    						$grandium_image = $grandium_img_url;
                        }

						$grandium_thumb_popup 		= get_post_thumbnail_id();
						$grandium_img_url_popup 	= wp_get_attachment_url( $grandium_thumb_popup,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
                        if( function_exists('aq_resize') ) {
    						$grandium_image_popup = aq_resize( $grandium_img_url_popup, 1200, 700, true,true,true ); //resize & crop the image
                        } else {
    						$grandium_image_popup = $grandium_img_url_popup;
                        }

						$grandium_thumb_small 		= get_post_thumbnail_id();
						$grandium_img_url_small 	= wp_get_attachment_url( $grandium_thumb_small,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
						$grandium_image_small 		= aq_resize( $grandium_img_url_small, 1200, 700, true,true,true ); //resize & crop the image
					?>

                    <div class="row">
                        <div class="col-md-8">

						<?php if( $grandium_image ) :  ?>
                            <!-- Room Slider -->
                            <div class="room-slider">

								<?php if( $grandium_room_price_v !='h' ) :  ?>
									<div class="room-price">

										<?php echo esc_html( $grandium_currency ) ?>

										<?php if( $grandium_sale_price ) { ?>
											<span class="single-price"><?php echo esc_html( $grandium_sale_price ); ?></span>
										<?php }  ?>
										<?php if( $grandium_price ) { ?>
											<span class="single-sale"><?php echo esc_html( $grandium_price ); ?></span>
										<?php }  ?>

										<small><?php echo esc_html( $grandium_label ) ?></small>
									 </div>
								 <?php endif; ?>

								<?php if( $grandium_image ) :  ?>
									<div class="owl-carousel owl-theme owl-type1">

										<a href="<?php echo esc_url( $grandium_image ) ?>" data-background="<?php echo esc_url( $grandium_image ) ?>" title="<?php echo esc_attr( $get_the_title ) ?>" class="grandium-popup-gallery"></a>
										<?php foreach ( $grandium_room_images as $image ) { ?>
										   <a href="<?php	echo esc_url( $image['full_url'] ); ?>" data-background="<?php	echo esc_url( $image['full_url'] ); ?>" alt="<?php	echo esc_attr($image['alt']); ?>" class="grandium-popup-gallery"></a>
										<?php } ?>

									</div>
								<?php endif; ?>


                            </div>
                            <!-- Room Slider End -->
                            <!-- Room Thumbnails -->
                            <div class="room-thumbnails">
                                <div class="owl-carousel">

									<?php if( $grandium_image ) :  ?>
										<a href="#" data-background="<?php echo esc_url( $grandium_image ) ?>" alt="<?php echo esc_attr( $get_the_title ) ?>"></a>
									<?php endif; ?>

                                   <?php foreach ( $grandium_room_images as $image ) { ?>
									   <a href="#" data-background="<?php	echo esc_url( $image['full_url'] ); ?>" alt="<?php	echo esc_attr($image['alt']); ?>"></a>
									<?php } ?>

                                </div>
                            </div>
                            <!-- Room Thumbnails End -->
							<?php endif;
              $grandium_rooms_main_title  = ot_get_option( 'grandium_rooms_mtitle');
              $grandium_rooms_ltitleone   = ot_get_option( 'grandium_rooms_ltitleone');
              $grandium_rooms_lstitleone  = ot_get_option( 'grandium_rooms_lstitleone');
              $grandium_rooms_ltitletwo   = ot_get_option( 'grandium_rooms_ltitletwo');
              $grandium_rooms_lstitletwo  = ot_get_option( 'grandium_rooms_lstitletwo');

               ?>

                        <!-- Room Description -->
                        <div class="room-desc">
                          <?php if($grandium_rooms_main_title !== ''){ ?>
                            <h5><?php echo esc_html($grandium_rooms_main_title) ?></h5>
                          <?php }else{?>
                            <h5><?php esc_html_e( 'ROOM DETAILS' , 'grandium' ); ?></h5>
                          <?php }?>

			                  <?php the_content( ); ?>
                        </div>
                        <!-- Room Description End -->


                      </div>
                      <div class="col-md-4">

							<?php if( $grandium_room_shortcode_v !='h' ) :  ?>
								<!-- Room Booking -->
								<div class="room-booking">

                  <?php if($grandium_rooms_ltitleone !== ''){ ?>
                    <h5><?php echo esc_html($grandium_rooms_ltitleone) ?></h5>
                  <?php }else{?>
                    <h5><?php esc_html_e( 'BOOKING' , 'grandium' ); ?></h5>
                  <?php }?>

                  <?php if($grandium_rooms_lstitleone !== ''){ ?>
                    <h2><?php echo esc_html($grandium_rooms_lstitleone) ?></h2>
                  <?php }else{?>
                    <h2><?php esc_html_e( 'Book a Room' , 'grandium' ); ?></h2>
                  <?php }?>

									<div class="data-form">
										<?php  echo do_shortcode( rwmb_meta( 'grandium_room_shortcode' ) ); ?>
									</div>
								</div>
								<!-- Room Booking End -->
							<?php endif; ?>

							<?php if( $grandium_features_list_v !='h' ) :  ?>
								<!-- Room Features -->
								<div class="room-features">

                  <?php if($grandium_rooms_ltitletwo !== ''){ ?>
                    <h5><?php echo esc_html($grandium_rooms_ltitletwo) ?></h5>
                  <?php }else{?>
                    <h5><?php esc_html_e( 'FEATURES' , 'grandium' ); ?></h5>
                  <?php }?>

                  <?php if($grandium_rooms_lstitletwo !== ''){ ?>
                    <h2><?php echo esc_html($grandium_rooms_lstitletwo) ?></h2>
                  <?php }else{?>
                    <h2><?php esc_html_e( 'Room Features' , 'grandium' ); ?></h2>
                  <?php }?>

									<ul>
										<?php foreach ( $grandium_features_list as $item ) { ?>
													<li><i class="fa fa-check"></i> <?php echo esc_html( $item ); ?> </li>
											<?php } ?>

									</ul>
								</div>
								<!-- Room Features End -->
							<?php endif; ?>

							<?php if ( is_active_sidebar( 'grandium_widgetize_single_room' ) ) { ?>
								<div class="room-features">
									<?php dynamic_sidebar( 'grandium_widgetize_single_room' ); ?>
								</div>
							<?php } ?>

                        </div>
                    </div>

                </div>
            </div>
        </div>
	</div>
    <!-- Section Rooms Detail End -->
