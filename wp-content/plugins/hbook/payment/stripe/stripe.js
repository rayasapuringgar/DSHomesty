var hb_current_processed_form,
	hb_stripe_callback_func;

jQuery( '.hb-stripe-card-number' ).payment( 'formatCardNumber' );

function hb_stripe_payment_process( $form, callback_func ) {
	$form.find( '.hb-stripe-error' ).hide();
	if ( ! jQuery.payment.validateCardNumber( $form.find( '.hb-stripe-card-number' ).val() ) ) {
		$form.find( '.hb-stripe-error' ).html( hb_text.stripe_invalid_card_number ).slideDown();
		return false;
	}
	if ( ! jQuery.payment.validateCardExpiry( $form.find( 'select.hb-stripe-expiration-month' ).val(),  $form.find( 'select.hb-stripe-expiration-year' ).val() ) ) {
		$form.find( '.hb-stripe-error' ).html( hb_text.stripe_invalid_expiration ).slideDown();
		return false;
	}
	hb_current_processed_form = $form;
	hb_stripe_callback_func = callback_func;
	$form.addClass( 'submitted' );
	$form.find( 'input[type="submit"]' ).blur().prop( 'disabled', true );
	$form.find( '.hb-saving-resa' ).slideDown();
	$form.find( '.hb-confirm-error' ).slideUp();
	try {
		Stripe.setPublishableKey( hb_stripe_key );
		Stripe.card.createToken( $form, hb_stripe_response_handler );
		return true;
	} catch ( e ) {
		alert( e.message );
		return false;
	}
}

function hb_stripe_response_handler( status, response ) {
	$form = hb_current_processed_form;
	if ( response.error ) {
		$form.removeClass( 'submitted' );
		$form.find( 'input[type="submit"]' ).prop( 'disabled', false );
		$form.find( '.hb-saving-resa' ).slideUp();
		$form.find( '.hb-stripe-error' ).html( hb_text.stripe_invalid_card ).slideDown();
	} else {
		$form.append( jQuery( '<input type="hidden" name="hb-stripe-token" value="' + response.id + '"/>' ) );
		hb_stripe_callback_func( $form );
	}
}