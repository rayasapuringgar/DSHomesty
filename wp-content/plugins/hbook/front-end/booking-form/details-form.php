<?php

class HbDetailsForm {

	private $hbdb;
	private $utils;
	private $hb_strings;
	private $form_fields;
	private $global_fees;

	public function __construct( $hbdb, $utils, $hb_strings, $form_fields, $global_fees ) {
		$this->hbdb = $hbdb;
		$this->utils = $utils;
		$this->hb_strings = $hb_strings;
		$this->form_fields = $form_fields;
		$this->global_fees = $global_fees;
	}

	public function get_details_form_mark_up( $resa, $booking_form_num ) {
		return
			'<form class="hb-booking-details-form">' .
				$this->get_details_fields( $resa ) .
				$this->get_coupon_area() .
				$this->get_resa_summary() .
				$this->get_hidden_fields( $booking_form_num ) .
				$this->get_policies_area() .
				$this->get_payment_fields() .
				$this->get_confirm_area() .
			'</form><!-- end .hb-booking-details-form -->';
	}

	public function get_details_fields( $resa ) {
		$fields = $this->hbdb->get_form_fields( 'booking' );
		$output = '';
		$nb_columns = 0;
		$current_columns_wrapper = 0;
		$column_num = 0;
		foreach ( $fields as $field ) {
			$output = apply_filters( 'hb_details_form_markup_before_field', $output, $field );
			if ( $field['displayed'] == 'yes' ) {
				if ( $field['column_width'] == 'half' ) {
					$nb_columns = 2;
				} else if ( $field['column_width'] == 'third' ) {
					$nb_columns = 3;
				} else {
					$nb_columns = 0;
				}
				if ( $nb_columns ) {
					if ( $column_num && ( $current_columns_wrapper != $nb_columns ) ) {
						$column_num = 0;
						$current_columns_wrapper = 0;
						$output .= '</div><!-- end .hb-clearfix -->';
					}
					if ( ! $column_num ) {
						$column_num = 1;
						$current_columns_wrapper = $nb_columns;
						$output .= '<div class="hb-clearfix">';
					} else {
						$column_num++;
					}
				} else if ( $column_num != 0 ) {
					$column_num = 0;
					$nb_columns = 0;
					$current_columns_wrapper = 0;
					$output .= '</div><!-- end .hb-clearfix -->';
				}

				$output .= $this->form_fields->get_field_mark_up( $field, $resa );

				if ( $current_columns_wrapper && ( $current_columns_wrapper == $column_num ) ) {
					$column_num = 0;
					$nb_columns = 0;
					$current_columns_wrapper = 0;
					$output .= '</div><!-- end .hb-clearfix -->';
				}
			}
			$output = apply_filters( 'hb_details_form_markup_after_field', $output, $field );
		}
		if ( $current_columns_wrapper ) {
			$output .= '</div><!-- end .hb-clearfix -->';
		}
		$output = '<div class="hb-details-fields">' . $output . '</div>';
		$output = apply_filters( 'hb_details_form_markup', $output );
		return $output;
	}

	private function get_coupon_area() {
		$output = '<span class="hb-coupon-amount">0</span>';
		if ( $this->hbdb->site_has_coupons() ) {
			$output .= '<div class="hb-coupons-area">';
			$output .= '<h3 class="hb-title hb-title-coupons">' . $this->hb_strings['coupons_section_title'] . '</h3>';
			$output .= '<span class="hb-coupon-type">&nbsp;</span>';
			$output .= '<input type="hidden" name="hb-pre-validated-coupon-id" class="hb-pre-validated-coupon-id" />';
			$output .= '<p>' . $this->hb_strings['coupons_text'] . '</p>';
			$output .= '<p class="hb-clearfix">';
			$output .= '<input type="text" class="hb-coupon-code" name="hb-coupon-code" />';
			$output .= '<input type="submit" class="hb-apply-coupon" value="' . $this->hb_strings['coupons_button'] . '" />';
			$output .= '<span class="hb-processing-coupon"></span>';
			$output .= '</p>';
			$output .= '<p class="hb-coupon-msg">&nbsp;</p>';
			$output .= '<p class="hb-coupon-error">&nbsp;</p>';
			$output .= '</div>';
		}
		return $output;
	}

	private function get_payment_fields() {
		$output = '';
		$display_payment_title = false;
		$payment_type = '';
		$payment_type_text = '';
		$payment_type_explanation = '';
		$amount_types = array( 'full_amount', 'deposit_amount', 'full_minus_deposit_amount' );
		if ( get_option( 'hb_resa_payment_multiple_choice' ) == 'yes' ) {
			$display_payment_title = true;
			$payment_choice_text = '<p class="hb-payment-type-multiple-choice">';
			$payment_choice_text .= '<b>' . $this->hb_strings['payment_type'] . '</b><br/>';
			$payment_types = apply_filters( 'hb_payment_types', array( 'offline', 'store_credit_card', 'deposit', 'full' ) );
			foreach ( $payment_types as $payment_type ) {
				if ( get_option( 'hb_resa_payment_' . $payment_type ) == 'yes' ) {
					$payment_choice_text .= '<input type="radio" id="hb-payment-type-' . $payment_type . '" name="hb-payment-type" value="' . $payment_type . '" />';
					$payment_choice_text .= ' <label for="hb-payment-type-' . $payment_type . '">' . $this->hb_strings[ 'payment_type_' . $payment_type ] . '</label><br/>';
					$explanation = '';
					if ( isset( $this->hb_strings[ 'payment_type_explanation_' . $payment_type ] ) && $this->hb_strings[ 'payment_type_explanation_' . $payment_type ] ) {
						$explanation = $this->hb_strings[ 'payment_type_explanation_' . $payment_type ];
						foreach ( $amount_types as $amount_type ) {
							$price_placeholder = '<span class="hb-payment-type-explanation-' . $amount_type . '">' . $this->utils->price_placeholder() . '</span>';
							$explanation = str_replace( '%' . $amount_type, $price_placeholder, $explanation );
						}
						$explanation = '<p class="hb-payment-type-explanation hb-payment-type-explanation-' . $payment_type . '">' . $explanation . '</p>';
					}
					$payment_type_explanation .= $explanation;
				}
			}
			$payment_choice_text .= '<input class="hb-payment-type-null-price" type="radio" name="hb-payment-type" value="offline" />';
			$payment_choice_text .= '</p>';
		} else {
			$payment_type = get_option( 'hb_resa_payment' );
			$payment_choice_text = '<input class="hb-payment-type-hidden" type="radio" name="hb-payment-type" value="' . $payment_type . '" />';
			if ( $payment_type != 'offline' ) {
				$payment_choice_text .= '<input class="hb-payment-type-null-price" type="radio" name="hb-payment-type" value="offline" />';
			}
			if ( $payment_type == 'deposit' || $payment_type == 'full' ) {
				$display_payment_title = true;
			}
			if ( isset( $this->hb_strings['payment_type_explanation_' . $payment_type ] ) && $this->hb_strings['payment_type_explanation_' . $payment_type ] ) {
				$explanation = $this->hb_strings[ 'payment_type_explanation_' . $payment_type ];
				foreach ( $amount_types as $amount_type ) {
					$price_placeholder = '<span class="hb-payment-type-explanation-' . $amount_type . '">' . $this->utils->price_placeholder() . '</span>';
					$explanation = str_replace( '%' . $amount_type, $price_placeholder, $explanation );
				}
				$payment_type_explanation = '<p class="hb-payment-type-explanation hb-payment-type-explanation-' . $payment_type . '">' . $explanation . '</p>';
			}
		}
		$output .= $payment_choice_text;
		$output .= $payment_type_explanation;

		$output .= '<div class="hb-payment-method-wrapper">';

		$payment_gateways = $this->utils->get_active_payment_gateways();
		$payment_gateways_text = esc_html__( 'There is no active payment gateways. Please activate at least one payment gateway in HBook settings (Hbook > Payment).', 'hbook-admin' );
		if ( count( $payment_gateways ) == 1 ) {
			$payment_gateways_text = '<input class="hb-payment-method-hidden" type="radio" name="hb-payment-gateway" value="' . $payment_gateways[0]->id . '" data-has-redirection="' . $payment_gateways[0]->has_redirection . '" />';
		} else if ( count( $payment_gateways ) > 1 ) {
			$payment_gateways_text = '<p class="hb-payment-method"><b>' . $this->hb_strings['payment_method'] . '</b><br/>';
			foreach ( $payment_gateways as $gateway ) {
				$payment_gateways_text .= '<input type="radio" id="hb-payment-gateway-' . $gateway->id . '" name="hb-payment-gateway" value="' . $gateway->id . '" data-has-redirection="' . $gateway->has_redirection . '" />';
				$payment_gateways_text .= ' <label class="hb-payment-gateway-label-' . $gateway->id . '" for="hb-payment-gateway-' . $gateway->id . '">' . $gateway->get_payment_method_label() . '</label><br/>';
			}
			$payment_gateways_text .= '</p>';
		}
		$output .= $payment_gateways_text;

		$payment_forms = '';
		$bottom_areas = '';
		foreach ( $payment_gateways as $gateway ) {
			if ( $gateway->payment_form() ) {
				$payment_forms .= '<div class="hb-payment-form hb-payment-form-' . $gateway->id . '">' . $gateway->payment_form() . '</div>';
			}
			if ( $gateway->bottom_area() ) {
				$bottom_areas .= '<div class="hb-bottom-area-content-' . $gateway->id . '">' . $gateway->bottom_area() . '</div>';
			}
		}
		$output .= $payment_forms;
		$output .= '<div class="hb-bottom-area-content">' . $bottom_areas . '</div>';

		$output .= '</div>';

		$output .= '<input type="hidden" name="hb-payment-flag" class="hb-payment-flag" />';

		if ( $display_payment_title ) {
			$payment_section_title = $this->hb_strings['payment_section_title'];
			if ( $payment_section_title ) {
				$output = '<h3 class="hb-title hb-title-payment">' . $payment_section_title . '</h3>' . $output;
			}
		}

		$output = '<div class="hb-payment-info-wrapper">' . $output . '</div>';
		return $output;
	}

	private function get_resa_summary() {
		$change_link = '<small><a href="#">' . $this->hb_strings['summary_change'] . '</a></small>';
		$change_search = '<span class="hb-summary-change-search"> - ' . $change_link . '</span>';
		$change_accom = '<span class="hb-summary-change-accom"> - ' . $change_link . '</span>';
		$output = '
			<div class="hb-resa-summary">
				<h3 class="hb-title hb-resa-summary-title">' . $this->hb_strings['summary_title'] . '</h3>
				<div class="hb-resa-payment-msg">' . $this->hb_strings['thanks_message_payment_done_1'] . '</div>
				<p class="hb-resa-done-msg">' . str_replace( '%customer_email', '<span class="hb-resa-done-email"></span>', $this->hb_strings['thanks_message_1'] ) . '</p>
				<div class="hb-resa-summary-content">
					<div>' . $this->hb_strings['chosen_check_in'] . ' <span class="hb-summary-check-in"></span>' . $change_search . '</div>
					<div>' . $this->hb_strings['chosen_check_out'] . ' <span class="hb-summary-check-out"></span>' . $change_search . '</div>
					<div>' . $this->hb_strings['number_of_nights'] . ' <span class="hb-summary-nights"></span></div>';
		if ( get_option( 'hb_display_adults_field' ) == 'yes' ) {
			$output .= '
					<div>' . $this->hb_strings['chosen_adults'] . ' <span class="hb-summary-adults"></span>' . $change_search . '</div>';
		}
		if ( get_option( 'hb_display_children_field' ) == 'yes' ) {
			$output .= '
					<div>' . $this->hb_strings['chosen_children'] . ' <span class="hb-summary-children"></span>' . $change_search . '</div>';
		}
		$bond_text ='';
		if ( get_option( 'hb_security_bond' ) == 'yes' ) {
			$bond_text .= '<br/>';
			$bond_amount = $this->utils->price_with_symbol( get_option( 'hb_security_bond_amount' ) );
			$bond_text .= '<div class="hb-summary-bond">' . $this->hb_strings['summary_security_bond'] . ' ' . $bond_amount . '</div>';
			$bond_explanation = $this->hb_strings['summary_security_bond_explanation'];
			if ( $bond_explanation ) {
				$bond_text .= '<div>' . $bond_explanation . '</div>';
			}
		}
		$deposit_text = '';
		if ( get_option( 'hb_deposit_type' ) != 'none' ) {
			$deposit_text .= '<br/><div class="hb-summary-deposit">';
			$deposit_text .= $this->hb_strings['summary_deposit'] . ' ';
			$deposit_text .= $this->utils->price_placeholder();
			$deposit_text .= '</div>';
		}
		$coupon_text = '<div class="hb-summary-coupon-amount">' . $this->hb_strings['summary_coupon_amount']. ' ' . $this->utils->price_placeholder() . '</div>';
		$output .= '<div class="hb-summary-accom-wrap">' . $this->hb_strings['summary_accommodation'] . ' <span class="hb-summary-accom"></span>' . $change_accom . '</div>';
		if ( get_option( 'hb_display_price' ) != 'no' ) {
			$output .= '
				<div class="hb-summary-accom-price"><br/>' . $this->hb_strings['summary_accom_price'] . ' ' . $this->utils->price_placeholder() . '</div>
					<div class="hb-summary-options-price">' . $this->hb_strings['summary_options_price'] . ' <span class="hb-price-placeholder-minus">-</span>' . $this->utils->price_placeholder() . '</div>' .
					$coupon_text .
					$this->global_fees->get_fees_markup_frontend() .
					$deposit_text .
					'<br/><div class="hb-summary-total-price">' . $this->hb_strings['summary_price'] . ' ' . $this->utils->price_placeholder() . '</div>' .
					$bond_text;
		}
		$output .= '
				</div>
				<p class="hb-resa-done-msg">' . $this->hb_strings['thanks_message_2'] . '</p>
				<div class="hb-resa-payment-msg">' . $this->hb_strings['thanks_message_payment_done_2'] . '</div>
			</div><!-- end .hb-resa-summary -->';
		$output = apply_filters( 'hb_resa_summary_markup', $output );
		$output = apply_filters( 'hb_resa_summary_no_external_payment_markup', $output );
		return $output;
	}

	private function get_hidden_fields( $booking_form_num ) {
		$output = '
			<input type="hidden" class="hb-details-check-in" name="hb-details-check-in" />
			<input type="hidden" class="hb-details-check-out" name="hb-details-check-out" />
			<input type="hidden" class="hb-details-adults" name="hb-details-adults" />
			<input type="hidden" class="hb-details-children" name="hb-details-children" />
			<input type="hidden" class="hb-details-accom-id" name="hb-details-accom-id" />
			<input type="hidden" name="hb-details-booking-form-num" value="' . $booking_form_num . '"/>';
		return $output;
	}

	private function get_policies_area() {
		$policies = '';
		if ( get_option( 'hb_display_terms_and_cond' ) == 'yes' ) {
			$policies .=
				'<p>' .
					'<input type="checkbox" id="terms-and-cond" name="hb_terms_and_cond" />' .
					'<label for="terms-and-cond" class="hb-terms-and-cond"> ' . $this->hb_strings['terms_and_cond_text'] . '</label>' .
				'</p>';
		}
		if ( get_option( 'hb_display_privacy_policy' ) == 'yes' ) {
			$policies .=
				'<p>' .
					'<input type="checkbox" id="privacy-policy" name="hb_privacy_policy" />' .
					'<label for="privacy-policy" class="hb-privacy-policy"> ' . $this->hb_strings['privacy_policy_text'] . '</label>' .
				'</p>';
		}
		if ( $policies && ( $this->hb_strings['terms_and_cond_title'] ) ) {
			$policies =
				'<h3 class="hb-title hb-title-terms">' . $this->hb_strings['terms_and_cond_title'] . '</h3>' .
				$policies;
		}
		$output = '<div class="hb-policies-area">';
		$output .= $policies;
		$output .= '<p class="hb-policies-error"></p>';
		$output .= '</div>';
		return apply_filters( 'hb_policies_area_markup', $output );
	}

	private function get_confirm_area() {
		$txt_before_book_now_button = '';
		if ( $this->hb_strings['txt_before_book_now_button'] ) {
			$txt_before_book_now_button = '<p>' . $this->hb_strings['txt_before_book_now_button'] . '</p>';
		}
		$output =
		'<div class="hb-confirm-area">' .
			'<p class="hb-saving-resa">' . $this->hb_strings['processing'] . '</p>' .
			$txt_before_book_now_button .
			'<p class="hb-confirm-error"></p>' .
			'<p class="hb-confirm-button"><input type="submit" value="' . $this->hb_strings['book_now_button'] . '" /></p>' .
		'</div>' .
		'<p class="hb-bottom-area">&nbsp;</p>' .
		'<input type="hidden" name="action" value="hb_save_details" />';
		$output = apply_filters( 'hb_confirm_area_markup', $output );
		return $output;
	}

}