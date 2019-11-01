<?php
class HbFrontEndAjaxActions {

	private $hbdb;
	private $utils;

	public function __construct( $hbdb, $utils ) {
		$this->hbdb = $hbdb;
		$this->utils = $utils;
	}

	public function hb_get_available_accom() {
		require_once $this->utils->plugin_directory . '/front-end/booking-form/available-accom.php';
		require_once $this->utils->plugin_directory . '/utils/resa-options.php';
		require_once $this->utils->plugin_directory . '/utils/price-calc.php';
		$price_calc = new HbPriceCalc( $this->hbdb, $this->utils );
		$options_form = new HbOptionsForm( $this->hbdb, $this->utils );
		$strings = $this->hbdb->get_strings();
		$available_accom = new HbAvailableAccom( $this->hbdb, $this->utils, $strings, $price_calc, $options_form );
		$search_request = array(
			'check_in' => $_POST['check_in'],
			'check_out' => $_POST['check_out'],
			'adults' => $_POST['adults'],
			'children' => $_POST['children'],
			'page_accom_id' => $_POST['page_accom_id'],
			'current_page_id' => $_POST['current_page_id'],
			'exists_main_booking_form' => $_POST['exists_main_booking_form'],
			'force_display_thumb' => $_POST['force_display_thumb'],
			'force_display_desc' => $_POST['force_display_desc'],
		);
		$response = $available_accom->get_available_accom( $search_request );
		echo( json_encode( $response ) );
		die;
	}

	public function hb_save_details() {
		$response['success'] = true;
		$accom_num = $this->hbdb->get_first_available_accom_num( $_POST['hb-details-accom-id'], $_POST['hb-details-check-in'], $_POST['hb-details-check-out'] );
		if ( ! $accom_num ) {
			$response['success'] = false;
			$response['error_msg'] = $this->hbdb->get_string( 'accom_no_longer_available' );
		} else {
			$customer_info = $this->utils->get_posted_customer_info();
			$customer_email = '';
			if ( isset( $_POST[ 'hb_email' ] ) ) {
				$customer_email = stripslashes( strip_tags( $_POST[ 'hb_email' ] ) );
			}

			$customer_id = $this->hbdb->get_customer_id( $customer_email );
			if ( $customer_id ) {
				$customer_id = $this->hbdb->update_customer_on_resa_creation( $customer_id, $customer_email, $customer_info );
			} else {
				$customer_id = $this->hbdb->create_customer( $customer_email, $customer_info );
			}

			if ( ! $customer_id ) {
				$response['success'] = false;
				$response['error_msg'] = 'Error (could not create customer).';
			} else {
				$customer_info['id'] = $customer_id;

				require_once $this->utils->plugin_directory . '/utils/price-calc.php';
				$price_calc = new HbPriceCalc( $this->hbdb, $this->utils );
				$price = $price_calc->get_price( $_POST['hb-details-accom-id'], $_POST['hb-details-check-in'], $_POST['hb-details-check-out'], $_POST['hb-details-adults'], $_POST['hb-details-children'] );
				if ( ! $price['success'] ) {
					$response['success'] = false;
					$response['error_msg'] = 'Error (could not calculate price).';
				} else {
					$accom_price = $price['value'];
					$options = $this->hbdb->get_options_with_choices( $_POST['hb-details-accom-id'] );
					$adults = intval( $_POST['hb-details-adults'] );
					$children = intval( $_POST['hb-details-children'] );
					$nb_nights = $this->utils->get_number_of_nights( $_POST['hb-details-check-in'], $_POST['hb-details-check-out'] );
					$price_options = $this->utils->calculate_options_price( $adults, $children, $nb_nights, $options );
					$options_total_price = 0;
					$chosen_options = array();
					foreach ( $options as $option ) {
						if ( $option['apply_to_type'] == 'quantity' || $option['apply_to_type'] == 'quantity-per-day' ) {
							$quantity = intval( $_POST[ 'hb_option_' . $option['id'] ] );
							$chosen_options[ $option['id'] ] = $quantity;
							$options_total_price += $quantity * $price_options[ 'option_' . $option['id'] ];
						} else if ( $option['choice_type'] == 'single' ) {
							if ( isset( $_POST[ 'hb_option_' . $option['id'] ] ) ) {
								$chosen_options[ $option['id'] ] = 'chosen';
								$options_total_price += $price_options[ 'option_' . $option['id'] ];
							}
						} else {
							foreach ( $option['choices'] as $choice ) {
								if ( $_POST[ 'hb_option_' . $option['id'] ] == $choice['id'] ) {
									$chosen_options[ $option['id'] ] = $choice['id'];
									$options_total_price += $price_options[ 'option_choice_' . $choice['id'] ];
								}
							}
						}
					}
					$chosen_options = json_encode( $chosen_options );

					$price = $options_total_price + $accom_price;

					$validated_coupon_code = '';
					$coupon_id = '';
					if ( isset( $_POST['hb-pre-validated-coupon-id'] ) ) {
						$coupon_id = $_POST['hb-pre-validated-coupon-id'];
					}
					if ( $coupon_id ) {
						require_once $this->utils->plugin_directory . '/utils/resa-coupon.php';
						$coupon_info = $this->hbdb->get_coupon_info( $coupon_id );
						$coupon = new HbResaCoupon( $this->hbdb, $this->utils, $coupon_info );
						if ( $coupon->is_valid( $_POST['hb-details-accom-id'], $_POST['hb-details-check-in'], $_POST['hb-details-check-out'] ) ) {
							if ( $coupon_info['amount_type'] == 'percent' ) {
								$coupon_amount = $price * $coupon_info['amount'] / 100;
							} else {
								$coupon_amount = $coupon_info['amount'];
							}
							$price -= $coupon_amount;
							$validated_coupon_code = $coupon_info['code'];
						}
					}

					$fees = $this->hbdb->get_final_fees();
					$fees_amount = 0;
					foreach ( $fees as $fee ) {
						if ( $fee['apply_to_type'] == 'accom-percentage' ) {
							$fees_amount += $fee['amount'] * $accom_price / 100;
						} else if ( $fee['apply_to_type'] == 'extras-percentage' ) {
							$fees_amount += $fee['amount'] * $options_total_price / 100;
						} else if ( $fee['apply_to_type'] == 'global-percentage' ) {
							$fees_amount += $fee['amount'] * $price / 100;
						} else if ( $fee['apply_to_type'] == 'global-fixed' ) {
							$fees_amount += $fee['amount'];
						}
					}

					$price += $fees_amount;

					$deposit = 0;
					if ( get_option( 'hb_deposit_type' ) == 'nb_night' ) {
						$deposit = ( $price / $nb_nights ) * get_option( 'hb_deposit_amount' );
					} else if ( get_option( 'hb_deposit_type' ) == 'fixed' ) {
						$deposit = get_option( 'hb_deposit_amount' );
					} else if ( get_option( 'hb_deposit_type' ) == 'percentage' ) {
						$deposit = $price * get_option( 'hb_deposit_amount' ) / 100;
					}
					if ( $deposit > $price ) {
						$deposit = $price;
					}

					$security_bond = 0;
					$security_bond_deposit = 0;
					if ( get_option( 'hb_security_bond_online_payment' ) == 'yes' ) {
						$security_bond = get_option( 'hb_security_bond_amount' );
						if ( get_option( 'hb_deposit_bond' ) == 'yes' ) {
							$security_bond_deposit = get_option( 'hb_security_bond_amount' );
						}
					}

					$currency_to_round = array( 'HUF', 'JPY', 'TWD' );
					if ( in_array( get_option( 'hb_currency' ), $currency_to_round ) || ( get_option( 'hb_price_precision' ) == 'no_decimals' ) ) {
						$price = round( $price );
						$deposit = round( $deposit );
					} else {
						$price = round( $price, 2 );
						$deposit = round( $deposit, 2 );
					}

					if ( $_POST['hb-payment-type'] == 'store_credit_card' && ( get_option( 'hb_resa_payment_store_credit_card' ) == 'yes' || get_option( 'hb_resa_payment' ) == 'store_credit_card' ) ) {
						$amount_to_pay = 0;
						$payment_type = 'store_credit_card';
					} else if ( $_POST['hb-payment-type'] == 'deposit' && ( get_option( 'hb_resa_payment_deposit' ) == 'yes' || get_option( 'hb_resa_payment' ) == 'deposit' ) ) {
						$amount_to_pay = $deposit + $security_bond_deposit;
						$payment_type = 'deposit';
					} else if ( $_POST['hb-payment-type'] == 'full' && ( get_option( 'hb_resa_payment_full' ) == 'yes' || get_option( 'hb_resa_payment' ) == 'full' ) ) {
						$amount_to_pay = $price + $security_bond;
						$payment_type = 'full';
					} else {
						$amount_to_pay = $price + $security_bond;
						$payment_type = 'offline';
					}

					$resa_info = array(
						'booking_form_num' => $_POST['hb-details-booking-form-num'],
						'accom_id' => $_POST['hb-details-accom-id'],
						'accom_num' => $accom_num,
						'check_in' => $_POST['hb-details-check-in'],
						'check_out' => $_POST['hb-details-check-out'],
						'adults' => $_POST['hb-details-adults'],
						'children' => $_POST['hb-details-children'],
						'price' => $price,
						'deposit' => $deposit,
						'payment_type' => $payment_type,
						'paid' => 0,
						'currency' => get_option( 'hb_currency' ),
						'customer_id' => $customer_id,
						'additional_info' => $this->utils->get_posted_additional_booking_info(),
						'options' => $chosen_options,
						'coupon' => $validated_coupon_code,
						'payment_token' => '',
						'origin' => 'website',
					);

					if ( $_POST['hb-payment-flag'] == 'yes' ) {
						$payment_gateway = $this->utils->get_payment_gateway( $_POST['hb-payment-gateway'] );
						if ( $payment_gateway ) {
							$resa_info['payment_gateway'] = $payment_gateway->name;
							$response = $payment_gateway->process_payment( $resa_info, $customer_info, $amount_to_pay );
						} else {
							$response['success'] = false;
							$response['error_msg'] = 'Error. Could not find payment gateway.';
						}
						if ( ! $response['success'] ) {
							echo( json_encode( $response ) );
							die;
						}
						if ( isset( $response['payment_info'] ) ) {
							$resa_info['payment_info'] = $response['payment_info'];
						}
						if ( $payment_gateway->has_redirection == 'no' ) {
							if ( get_option( 'hb_resa_paid_has_confirmation' ) == 'no' ) {
								$status = get_option( 'hb_resa_website_status' );
							} else {
								$status = 'pending';
								$accom_num = 0;
							}
							$resa_info['paid'] = $amount_to_pay;
						} else {
							$status = 'waiting_payment';
							$resa_info['payment_token'] = $response['payment_token'];
							$resa_info['amount_to_pay'] = $amount_to_pay;
						}
					} else {
						$resa_info['payment_gateway'] = '';
						if ( get_option( 'hb_resa_unpaid_has_confirmation' ) == 'no' ) {
							$status = get_option( 'hb_resa_website_status' );
						} else {
							$status = 'pending';
							$accom_num = 0;
						}
					}

					$resa_info['accom_num'] = $accom_num;
					$resa_info['status'] = $status;

					$resa_id = $this->hbdb->create_resa( $resa_info );
					if ( ! $resa_id && ! $resa_info['paid'] ) {
						$response['success'] = false;
						$response['error_msg'] = 'Error (could not create reservation).';
					} else {
						if ( $status == 'waiting_payment' ) {
							$response['resa_id'] = $resa_id;
						} else {
							if ( ( $status == 'new' ) || ( $status == 'confirmed' ) ) {
								$this->hbdb->block_linked_accom( $resa_info['accom_id'], $resa_info['check_in'], $resa_info['check_out'], $resa_id );
							}
							$this->utils->send_email( 'new_resa', $resa_id );
						}
					}
				}
			}
		}
		echo( json_encode( $response ) );
		die;
	}

	public function hb_verify_coupon() {
		$response = array();
		$response['success'] = false;
		$response['msg'] = $this->hbdb->get_string( 'invalid_coupon' );
		$coupon_ids = $this->hbdb->get_coupon_ids_by_code( $_POST['coupon_code'] );
		if ( $coupon_ids ) {
			require_once $this->utils->plugin_directory . '/utils/resa-coupon.php';
			foreach ( $coupon_ids as $coupon_id ) {
				$coupon_info = $this->hbdb->get_coupon_info( $coupon_id );
				$coupon = new HbResaCoupon( $this->hbdb, $this->utils, $coupon_info );
				if ( $coupon->is_valid( $_POST['accom_id'], $_POST['check_in'], $_POST['check_out'] ) ) {
					$coupon_amount = $coupon_info['amount'];
					if ( $coupon_info['amount_type'] == 'percent' ) {
						if ( floor( $coupon_amount ) == $coupon_amount ) {
							$coupon_amount = number_format( $coupon_amount );
						}
						$coupon_amount_text = $coupon_amount . '%';
					} else {
						$coupon_amount_text = 	$this->utils->price_with_symbol( $coupon_amount );
					}
					$response['success'] = true;
					$response['msg'] = str_replace( '%amount', $coupon_amount_text, $this->hbdb->get_string( 'valid_coupon' ) );
					$response['coupon_id'] = $coupon_id;
					$response['coupon_amount'] = $coupon_amount;
					$response['coupon_type'] = $coupon_info['amount_type'];
					$response['coupon_amount_text'] = $coupon_amount_text;
					break;
				}
			}
		}
		echo( json_encode( $response ) );
		die;
	}
}