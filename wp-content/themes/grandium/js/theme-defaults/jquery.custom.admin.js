/*-----------------------------------------------------------------------------------

 	Custom JS - All back-end jQuery
 
-----------------------------------------------------------------------------------*/
 
jQuery(document).ready(function() {


	// A few overrides to the rwmb metaboxes.

	jQuery('.rwmb-text').addClass('widefat');
	jQuery('.rwmb-oembed').css('width', '80%');
	jQuery('.rwmb-textarea').removeClass('large-text').addClass('widefat');
	jQuery('.rwmb-delete-file').click(function(e) {
		e.preventDefault();
		jQuery(this).parent().parent().slideUp(600);
	});

	// Show metaboxes according to the current post format.



/*----------------------------------------------------------------------------------*/
/*	Gallery Options
/*----------------------------------------------------------------------------------*/

	var galleryOptions = jQuery('#gallery-settings');
	var galleryTrigger = jQuery('#post-format-gallery');
	
	galleryOptions.css('display', 'none');


/*----------------------------------------------------------------------------------*/
/*	Quote Options
/*----------------------------------------------------------------------------------*/

	var quoteOptions = jQuery('#quote-settings');
	var quoteTrigger = jQuery('#post-format-quote');
	
	quoteOptions.css('display', 'none');

/*----------------------------------------------------------------------------------*/
/*	Image Options
/*----------------------------------------------------------------------------------*/

	var imageOptions = jQuery('#image-settings');
	var imageTrigger = jQuery('#post-format-image');
	
	imageOptions.css('display', 'none');


/*----------------------------------------------------------------------------------*/
/*	Link Options
/*----------------------------------------------------------------------------------*/

	var linkOptions = jQuery('#link-settings');
	var linkTrigger = jQuery('#post-format-link');
	
	linkOptions.css('display', 'none');

/*----------------------------------------------------------------------------------*/
/*	Status Options
/*----------------------------------------------------------------------------------*/

	var statusOptions = jQuery('#status-settings');
	var statusTrigger = jQuery('#post-format-status');
	
	statusOptions.css('display', 'none');
	
/*----------------------------------------------------------------------------------*/
/*	Audio Options
/*----------------------------------------------------------------------------------*/

	var audioOptions = jQuery('#audio-settings');
	var audioTrigger = jQuery('#post-format-audio');
	
	audioOptions.css('display', 'none');
	
/*----------------------------------------------------------------------------------*/
/*	Video Options
/*----------------------------------------------------------------------------------*/

	var videoOptions = jQuery('#video-settings');
	var videoTrigger = jQuery('#post-format-video');
	
	videoOptions.css('display', 'none');

/*----------------------------------------------------------------------------------*/
/*	The Brain
/*----------------------------------------------------------------------------------*/

	var group = jQuery('#post-formats-select input');

	
	group.change( function() {

		if (jQuery(this).val() == 'gallery') {
			galleryOptions.css('display', 'block');
			ninethemeHideAll(galleryOptions);
			
		} else if(jQuery(this).val() == 'quote') {
			quoteOptions.css('display', 'block');
			ninethemeHideAll(quoteOptions);
			
		} else if(jQuery(this).val() == 'link') {
			linkOptions.css('display', 'block');
			ninethemeHideAll(linkOptions);

		} else if(jQuery(this).val() == 'status') {
			statusOptions.css('display', 'block');
			ninethemeHideAll(statusOptions);
			
		} else if(jQuery(this).val() == 'audio') {
			audioOptions.css('display', 'block');
			ninethemeHideAll(audioOptions);
			
		} else if(jQuery(this).val() == 'video') {
			videoOptions.css('display', 'block');
			ninethemeHideAll(videoOptions);
			
		} else if(jQuery(this).val() == 'image') {
			imageOptions.css('display', 'block');
			ninethemeHideAll(imageOptions);
			
		} else {
			quoteOptions.css('display', 'none');
			videoOptions.css('display', 'none');
			linkOptions.css('display', 'none');
			statusOptions.css('display', 'none');
			audioOptions.css('display', 'none');
			imageOptions.css('display', 'none');
		}
		
	});

	if(galleryTrigger.is(':checked'))
		galleryOptions.css('display', 'block');
	
	if(quoteTrigger.is(':checked'))
		quoteOptions.css('display', 'block');
		
	if(linkTrigger.is(':checked'))
		linkOptions.css('display', 'block');

	if(statusTrigger.is(':checked'))
		statusOptions.css('display', 'block');
		
	if(audioTrigger.is(':checked'))
		audioOptions.css('display', 'block');
		
	if(videoTrigger.is(':checked'))
		videoOptions.css('display', 'block');
		
	if(imageTrigger.is(':checked'))
		imageOptions.css('display', 'block');
		
	function ninethemeHideAll(notThisOne) {
		videoOptions.css('display', 'none');
		galleryOptions.css('display', 'none');
		quoteOptions.css('display', 'none');
		linkOptions.css('display', 'none');
		statusOptions.css('display', 'none');
		audioOptions.css('display', 'none');
		imageOptions.css('display', 'none');
		notThisOne.css('display', 'block');
	}
	

});