<?php
class HbStripe extends HbPaymentGateway {

	private $stripe_key;

	public function __construct( $hbdb, $version ) {
		$this->id = 'stripe';
		$this->name = 'Stripe';
		$this->has_redirection = 'no';
		$this->version = $version;
		$this->hbdb = $hbdb;

		if ( get_option( 'hb_stripe_mode') == 'test' ) {
			$this->stripe_key = trim( get_option( 'hb_stripe_test_secret_key' ) );
		} else {
			$this->stripe_key = trim( get_option( 'hb_stripe_live_secret_key' ) );
		}

		add_filter( 'hbook_payment_gateways', array( $this, 'add_stripe_gateway_class' ) );
	}

	public function add_stripe_gateway_class( $hbook_gateways ) {
		$hbook_gateways[] = $this;
		return $hbook_gateways;
	}

	public function get_payment_method_label() {
		$output = $this->hbdb->get_string( 'stripe_payment_method_label' );
		$output .= $this->get_credit_cards_icons( 'hb-stripe-payment-gateway-img' );
		return apply_filters( 'hb_stripe_payment_method_label', $output );
	}

	public function admin_fields() {
		return array(
			'label' => esc_html__( 'Stripe settings', 'hbook-admin' ),
			'options' => array(

				'hb_stripe_mode' => array(
					'label' => esc_html__( 'Stripe mode:', 'hbook-admin' ),
					'type' => 'radio',
					'choice' => array(
						'live' => esc_html__( 'Live', 'hbook-admin' ),
						'test' => esc_html__( 'Test', 'hbook-admin' ),
					),
					'default' => 'live'
				),
				'hb_stripe_test_secret_key' => array(
					'label' => esc_html__( 'Test Secret Key:', 'hbook-admin' ),
					'type' => 'text',
					'wrapper-class' => 'hb-stripe-mode-test',
				),
				'hb_stripe_test_publishable_key' => array(
					'label' => esc_html__( 'Test Publishable Key:', 'hbook-admin' ),
					'type' => 'text',
					'wrapper-class' => 'hb-stripe-mode-test'
				),
				'hb_stripe_live_secret_key' => array(
					'label' => esc_html__( 'Live Secret Key:', 'hbook-admin' ),
					'type' => 'text',
					'wrapper-class' => 'hb-stripe-mode-live',
				),
				'hb_stripe_live_publishable_key' => array(
					'label' => esc_html__( 'Live Publishable Key:', 'hbook-admin' ),
					'type' => 'text',
					'wrapper-class' => 'hb-stripe-mode-live',
				),
				'hb_store_credit_card' => array(
					'label' => esc_html__( 'Store credit card:', 'hbook-admin' ),
					'type' => 'radio',
					'choice' => array(
						'yes' => esc_html__( 'Yes', 'hbook-admin' ),
						'no' => esc_html__( 'No', 'hbook-admin' ),
					),
					'default' => 'no'
				),
				'hb_stripe_powered_by' => array(
					'label' => esc_html__( 'Display a "Powered by Stripe" icon:', 'hbook-admin' ),
					'type' => 'radio',
					'choice' => array(
						'yes' => esc_html__( 'Yes', 'hbook-admin' ),
						'no' => esc_html__( 'No', 'hbook-admin' ),
					),
					'default' => 'no'
				),

			)
		);
	}

	public function admin_js_scripts() {
		return array(
			array(
				'id' => 'hb-stripe-admin',
				'url' => plugin_dir_url( __FILE__ ) . 'stripe-admin.js',
				'version' => $this->version
			),
		);
	}

	public function js_scripts() {
		return array(
			array(
				'id' => 'stripejs',
				'url' => 'https://js.stripe.com/v2/',
				'version' => null
			),
			array(
				'id' => 'hbook-stripe-validation',
				'url' => plugin_dir_url( __FILE__ ) . 'jquery.payment.min.js',
				'version' => $this->version
			),
			array(
				'id' => 'hbook-stripe',
				'url' => plugin_dir_url( __FILE__ ) . 'stripe.js',
				'version' => $this->version
			),
		);
	}

	public function js_data() {
		if ( get_option( 'hb_stripe_mode') == 'test' ) {
			$this->stripe_key = get_option( 'hb_stripe_test_publishable_key' );
		} else {
			$this->stripe_key = get_option( 'hb_stripe_live_publishable_key' );
		}
		return array(
			'hb_stripe_key' => $this->stripe_key,
		);
	}

	public function payment_form() {
		$month_options = '';
		for ( $i = 1; $i <= 12; $i++ ) {
			$month_options .= '<option>' . sprintf( '%02d', $i ) . '</option>';
		}
		$year_options = '';
		$current_year = date( 'y' );
		for ( $i = 0; $i <= 20; $i++ ) {
			$year = $current_year + $i;
			$year_options .= '<option>' . $year . '</option>';
		}
		$output = '';
		$stripe_text_before_form = $this->hbdb->get_string( 'stripe_text_before_form' );
		if ( $stripe_text_before_form ) {
			$output .= '<p class="hb-stripe-payment-form-txt-top">' . $stripe_text_before_form . '</p>';
		}
		$output .= '<p>';
		$output .= '<label for="stripe-card-number">';
		$output .= $this->hbdb->get_string( 'stripe_card_number' );
		$output .= '</label>';
		$output .= '<input id="stripe-card-number" ';
		$output .= 'class="hb-detail-field hb-stripe-card-number" ';
		$output .= 'type="text" data-stripe="number" />';
		$output .= '</p>';
		$output .= '<div class="hb-clearfix">';
		$output .= '<label for="stripe-expiration-month">';
		$output .=  $this->hbdb->get_string( 'stripe_expiration' );
		$output .= '</label>';
		$output .= '<select id="stripe-expiration-month" ';
		$output .= 'class="hb-stripe-expiration-month hb-stripe-expiration" ';
		$output .= 'data-stripe="exp_month">' . $month_options . '</select>';
		$output .= '<span class="hb-stripe-expiration-separator">&nbsp;/&nbsp;</span>';
		$output .= '<select id="stripe-expiration-year" ';
		$output .= 'class="hb-stripe-expiration-year hb-stripe-expiration" ';
		$output .= 'data-stripe="exp_year">' . $year_options . '</select>';
		$output .= '</div>';
		$output .= '<br/>';
		$output .= '<p>';
		$output .= '<label for="stripe-cvc">';
		$output .= $this->hbdb->get_string( 'stripe_cvc' );
		$output .= '</label>';
		$output .= '<input id="stripe-cvc" class="hb-stripe-cvc" ';
		$output .= 'size="4" type="text" data-stripe="cvc" />';
		$output .= '</p>';
		$output .= '<p class="hb-stripe-error">&nbsp;</p>';
		$stripe_text_bottom_form = $this->hbdb->get_string( 'stripe_text_bottom_form' );
		if ( $stripe_text_bottom_form ) {
			$output .= '<p class="hb-stripe-payment-form-txt-bottom"><small>';
			$output .= '<img class="hb-padlock-img" src="' . plugin_dir_url( __FILE__ ) . '../img/padlock.png" alt="" />';
			$output .= '<span>' . $stripe_text_bottom_form . '</span>';
			$output .= '<br/>';
			if ( get_option( 'hb_stripe_powered_by' ) == 'yes' ) {
				$output .= '<img class="hb-powered-by-stripe-img" src="' . plugin_dir_url( __FILE__ ) . '../img/powered_by_stripe.png" alt="" />';
			}
			$output .= $this->get_credit_cards_icons( 'hb-stripe-bottom-text-form-img' );
			$output .= '</small></p>';
		}
		return apply_filters( 'hb_stripe_payment_form', $output );
	}

	public function process_payment( $resa_info, $customer_info, $amount_to_pay ) {
		$customer_email = '';
		$customer_first_name = '';
		$customer_last_name = '';
		if ( isset( $customer_info['email'] ) ) {
			$customer_email = $customer_info['email'];
		}
		if ( isset( $customer_info['first_name'] ) ) {
			$customer_first_name = $customer_info['first_name'];
		}
		if ( isset( $customer_info['last_name'] ) ) {
			$customer_last_name = $customer_info['last_name'];
		}

		$customer_description = $customer_first_name . ' ' . $customer_last_name;

		if ( $amount_to_pay == 0 || get_option( 'hb_store_credit_card' ) == 'yes' ) {
			$post_args = array(
				'source' => $_POST['hb-stripe-token'],
				'description' => $customer_description,
				'email' => $customer_email
			);
			$response = $this->remote_post_to_stripe( 'https://api.stripe.com/v1/customers', $post_args );
			if ( ! $response['success'] ) {
				return $response;
			}
			$info = json_decode( $response['info'], true );
			$customer_payment_id = $info['id'];
			$customer_updated = $this->hbdb->update_customer_payment_id( $customer_info['id'], $customer_payment_id );
			if ( $customer_updated === false ) {
				return array(
					'success' => false,
					'error_msg' => 'Could not update customer payment id'
				);
			}
		}

		if ( $amount_to_pay == 0 ) {
			return array(
				'success' => true,
			);
		}

		$payment_description = $customer_email;
		if ( $customer_first_name || $customer_last_name ) {
			$payment_description .= ' (' . $customer_first_name . ' ' . $customer_last_name . ')';
		}
		if ( $payment_description ) {
			$payment_description .= ' - ';
		}
		$payment_description .= get_the_title( $resa_info['accom_id'] );
		$payment_description .= ' (' . $resa_info['check_in'] . ' - ' . $resa_info['check_out'] . ')';

		$post_args = array(
			'amount' => $amount_to_pay,
			'currency' => $resa_info['currency'],
			'description' => $payment_description,
			'receipt_email' => $customer_email,
		);

		if ( get_option( 'hb_store_credit_card' ) == 'yes' ) {
			$post_args['customer'] = $customer_payment_id;
		} else {
			$post_args['source'] = $_POST['hb-stripe-token'];
		}
		$response = $this->remote_post_to_stripe( 'https://api.stripe.com/v1/charges', $post_args );
		if ( $response['success'] ) {
			$response['info'] = json_decode( $response['info'], true );
			$response['payment_info'] = json_encode( array(
				'stripe_charges' => array( array(
					'id' => $response['info']['id'],
					'amount' => $amount_to_pay,
				) )
			) );
		}
		return $response;
	}

	public function remote_post_to_stripe( $url, $post_args ) {
		if ( isset( $post_args['amount'] ) ) {
			$zero_decimal_currencies = array( 'BIF', 'CLP', 'DJF', 'GNF', 'JPY', 'KMF', 'KRW', 'MGA', 'PYG', 'RWF', 'VND', 'VUV', 'XAF', 'XOF', 'XPF' );
			if ( ! in_array( $post_args['currency'], $zero_decimal_currencies ) ) {
				$post_args['amount'] = $post_args['amount'] * 100;
			}
		}
		if ( $url == 'https://api.stripe.com/v1/refunds' ) {
			unset( $post_args['currency'] );
		}
		$post_args = array(
			'headers' => array( 'Authorization' => 'Bearer ' . $this->stripe_key ),
			'body' => $post_args
		);
		$response = $this->hb_remote_post( $url, $post_args );

		if ( is_wp_error( $response ) ) {
			return array( 'success' => false, 'error_msg' => 'WP error: ' . $response->get_error_message() );
		} else if ( $response['response']['code'] == 200 ) {
			return array(
				'success' => true,
				'info' => $response['body']
			);
		} else {
			$response = json_decode( $response['body'], true );
			if ( isset( $response['error']['code'] ) ) {
				$invalid_card_codes = array( 'invalid_number', 'invalid_expiry_month', 'invalid_expiry_year', 'invalid_cvc', 'incorrect_cvc' );
				if ( in_array( $response['error']['code'], $invalid_card_codes ) ) {
					$error_msg = $this->hbdb->get_string( 'stripe_invalid_card' );
				} else {
					$error_msg = str_replace( '%error_msg', $response['error']['message'], $this->hbdb->get_string( 'stripe_processing_error' ) );
				}
			} else {
				$error_msg = str_replace( '%error_msg', $response['error']['message'], $this->hbdb->get_string( 'stripe_processing_error' ) );
			}
			return array(
				'success' => false,
				'error_msg' => $error_msg
			);
		}
	}

	private function get_credit_cards_icons( $css_class ) {
		$output = '';
		$icons = apply_filters( 'hb_stripe_credit_cards_icons', array( 'mastercard', 'visa', 'americanexpress' ) );
		foreach ( $icons as $icon ) {
			$output .= ' ';
			$output .= '<img class="' . $css_class . '-' . $icon . '" ';
			$output .= 'src="' . plugin_dir_url( __FILE__ ) . '../img/' . $icon . '.png" alt="" />';
		}
		return $output;
	}

}