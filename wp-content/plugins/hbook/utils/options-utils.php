<?php
class HbOptionsUtils {

	private $utils;

	public function __construct( $utils = false ) {
		if ( $utils ) {
			$this->utils = $utils;
			$this->currencies = $utils->currencies_code_name();
		} else {
			$this->currencies = array();
		}
	}

	public function get_payment_settings() {
		return array(
			'payment_settings' => array(
				'label' => esc_html__( 'Booking payment settings', 'hbook-admin' ),
				'options' => array(
					'hb_resa_payment_multiple_choice' => array(
						'label' => esc_html__( 'Customers can choose between different payment options:', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'no'
					),
					'hb_resa_payment' => array(
						'label' => esc_html__( 'Booking payment:', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'offline' => esc_html__( 'Customers do not have to pay online to book an accommodation (payment on arrival or offline - e.g. bank wire)', 'hbook-admin' ),
							'store_credit_card' => esc_html__( 'Customers have to leave their credit card details to book an accommodation (this option is available only with Stripe)', 'hbook-admin' ),
							'deposit' => esc_html__( 'Customers have to pay a deposit online to book an accommodation', 'hbook-admin' ),
							'full' => esc_html__( 'Customers have to pay the full stay price online to book an accommodation', 'hbook-admin' )
						),
						'default' => 'offline',
						'wrapper-class' => 'hb-resa-payment-choice-multiple'
					),
					'hb_resa_payment_offline' => array(
						'label' => esc_html__( 'Customers can pay on arrival or offline - e.g.bank wire:', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'yes',
						'wrapper-class' => 'hb-resa-payment-choice-single'
					),
					'hb_resa_payment_store_credit_card' => array(
						'label' => esc_html__( 'Customers can leave their credit card details for a later charge (this option is available only with Stripe):', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'no',
						'wrapper-class' => 'hb-resa-payment-choice-single'
					),
					'hb_resa_payment_deposit' => array(
						'label' => esc_html__( 'Customers can pay an online deposit:', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'no',
						'wrapper-class' => 'hb-resa-payment-choice-single'
					),
					'hb_resa_payment_full' => array(
						'label' => esc_html__( 'Customers can pay the full amount online:', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'no',
						'wrapper-class' => 'hb-resa-payment-choice-single'
					),
				)
			),

			'security_bond_settings' => array(
				'label' => esc_html__( 'Security bond settings', 'hbook-admin' ),
				'desc' => esc_html__( 'A security bond is a sum of money which is held during the length of the stay to cover the cost of any damages or loss caused by the customer.', 'hbook-admin' ),
				'options' => array(
					'hb_security_bond' => array(
						'label' => esc_html__( 'Security bond:', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'no',
						'wrapper-class' => 'hb-security-bond-choice',
					),
					'hb_security_bond_online_payment' => array(
						'label' => esc_html__( 'Security bond has to be paid:', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'no',
						'wrapper-class' => 'hb-security-bond-options hb-security-bond-payment',
					),
					'hb_security_bond_amount' => array(
						'label' => esc_html__( 'Security bond amount:', 'hbook-admin' ),
						'type' => 'text',
						'class' => 'hb-small-field',
						'wrapper-class' => 'hb-security-bond-options',
					),
				)
			),

			'deposit_settings' => array(
				'label' => esc_html__( 'Deposit settings', 'hbook-admin' ),
				'desc' => esc_html__( 'A deposit corresponds to the part of the total price of the stay that is payed in advance by the customer to secure the booking.', 'hbook-admin' ),
				'options' => array(
					'hb_deposit_type' => array(
						'label' => esc_html__( 'Deposit type:', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'none' => esc_html__( 'None', 'hbook-admin' ),
							'percentage' => esc_html__( 'Percentage', 'hbook-admin' ),
							'nb_night' => esc_html__( 'Number of nights', 'hbook-admin' ),
							'fixed' => esc_html__( 'Fixed', 'hbook-admin' ),
						),
						'default' => 'none',
						'wrapper-class' => 'hb-deposit-choice',
					),
					'hb_deposit_amount' => array(
						'label' => esc_html__( 'Deposit amount:', 'hbook-admin' ),
						'type' => 'text',
						'class' => 'hb-small-field',
						'wrapper-class' => 'hb-deposit-options hb-deposit-amount',
					),
					'hb_deposit_bond' => array(
						'label' => esc_html__( 'Security bond must be paid along with deposit:', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'no',
						'wrapper-class' => 'hb-deposit-bond',
					),
				)
			),

			'price_settings' => array(
				'label' => esc_html__( 'Price settings', 'hbook-admin' ),
				'options' => array(
					'hb_currency' => array(
						'label' => esc_html__( 'Payment currency:', 'hbook-admin' ),
						'type' => 'select',
						'choice' => $this->currencies,
						'default' => 'USD'
					),
					'hb_currency_position' => array(
						'label' => esc_html__( 'Currency symbol position:', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'before' => esc_html__( 'Before price', 'hbook-admin' ),
							'after' => esc_html__( 'After price', 'hbook-admin' ),
						),
						'default' => 'before'
					),
					'hb_price_precision' => array(
						'label' => esc_html__( 'Price precision:', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'two_decimals' => esc_html__( 'Two decimals' ,'hbook-admin' ),
							'no_decimals' => esc_html__( 'No decimals' ,'hbook-admin' ),
						),
						'default' => 'two_decimals'
					),
				)
			)
		);
	}

	public function get_appearance_settings() {
		return array(
			'general_appearance_settings' => array(
				'label' => esc_html__( 'General settings', 'hbook-admin' ),
				'options' => array(
					'hb_page_padding_top' => array(
						'label' => esc_html__( 'Page padding top:', 'hbook-admin' ),
						'type' => 'text',
						'class' => 'hb-small-field',
						'default' => '10',
					),
					'hb_search_form_max_width' => array(
						'label' => esc_html__( 'Search form maximum width:', 'hbook-admin' ),
						'caption' => esc_html__( 'Leave blank for no maximum.', 'hbook-admin' ),
						'type' => 'text',
						'class' => 'hb-small-field',
						'default' => '',
					),
					'hb_accom_selection_form_max_width' => array(
						'label' => esc_html__( 'Accommodation selection form maximum width:', 'hbook-admin' ),
						'caption' => esc_html__( 'Leave blank for no maximum.', 'hbook-admin' ),
						'type' => 'text',
						'class' => 'hb-small-field',
						'default' => '800',
					),
					'hb_details_form_max_width' => array(
						'label' => esc_html__( 'Details form maximum width:', 'hbook-admin' ),
						'caption' => esc_html__( 'Leave blank for no maximum.', 'hbook-admin' ),
						'type' => 'text',
						'class' => 'hb-small-field',
						'default' => '800',
					),
					'hb_forms_position' => array(
						'label' => esc_html__( 'Forms position:', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'left' => esc_html__( 'Left', 'hbook-admin' ),
							'center' => esc_html__( 'Center', 'hbook-admin' ),
						),
						'default' => 'center'
					),
					'hb_horizontal_form_min_width' => array(
						'label' => esc_html__( 'Minimum width required for displaying a horizontal search form:', 'hbook-admin' ),
						'caption' => esc_html__( 'If the available space is less than the minimum width the form will be displayed vertically.', 'hbook-admin' ),
						'type' => 'text',
						'class' => 'hb-small-field',
						'default' => '500',
					),
					'hb_details_form_stack_width' => array(
						'label' => esc_html__( 'Minimum width required for displaying columns in the details form:', 'hbook-admin' ),
						'caption' => esc_html__( 'If the available space is less than the minimum width the columns will be stacked.', 'hbook-admin' ),
						'type' => 'text',
						'class' => 'hb-small-field',
						'default' => '500',
					),
				)
			),

			'buttons_appearance' => array(
				'label' => esc_html__( 'Buttons appearance', 'hbook-admin' ),
				'options' => array(
					'hb_buttons_style' => array(
						'label' => esc_html__( 'Buttons style:', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'theme' => esc_html__( 'Use theme styles', 'hbook-admin' ),
							'custom' => esc_html__( 'Custom', 'hbook-admin' ),
						),
						'default' => 'theme'
					),
					'hb_buttons_css_options' => array(),
				)
			),

			'inputs_selects_appearance' => array(
				'label' => esc_html__( 'Inputs and selects appearance', 'hbook-admin' ),
				'options' => array(
					'hb_inputs_selects_style' => array(
						'label' => esc_html__( 'Inputs and selects style:', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'theme' => esc_html__( 'Use theme styles', 'hbook-admin' ),
							'custom' => esc_html__( 'Custom', 'hbook-admin' ),
						),
						'default' => 'theme'
					),
					'hb_inputs_selects_css_options' => array(),
				)
			),

			'tables_appearance' => array(
				'label' => esc_html__( 'Rates tables appearance', 'hbook-admin' ),
				'options' => array(
					'hb_tables_style' => array(
						'label' => esc_html__( 'Rates tables style:', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'theme' => esc_html__( 'Use theme styles', 'hbook-admin' ),
							'plugin' => esc_html__( 'Use plugin styles', 'hbook-admin' ),
						),
						'default' => 'theme'
					),
				)
			),

			'calendar_colors' => array(
				'label' => esc_html__( 'Calendars appearance', 'hbook-admin' ),
				'options' => array(
					'hb_calendar_colors' => array(),
					'hb_calendar_shadows' => array(
						'label' => esc_html__( 'Add a shadow to calendars:', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'yes'
					),
				)
			),

			'custom_css_appearance_settings' => array(
				'label' => esc_html__( 'Custom CSS', 'hbook-admin' ),
				'options' => array(

					'hb_custom_css_frontend' => array(
						'label' => esc_html__( 'Custom CSS for the front-end pages:', 'hbook-admin' ),
						'type' => 'textarea',
					),
					'hb_custom_css_backend' => array(
						'label' => esc_html__( 'Custom CSS for the admin pages:', 'hbook-admin' ),
						'type' => 'textarea',
					),

				)
			)
		);
	}

	public function get_misc_settings() {
		return array(
			'confirmation_settings' => array(
				'label' => esc_html__( 'Confirmation settings', 'hbook-admin' ),
				'options' => array(
					'hb_resa_unpaid_has_confirmation' => array(
						'label' => esc_html__( 'Unpaid reservations have to be confirmed before dates are blocked out:', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'no'
					),
					'hb_resa_paid_has_confirmation' => array(
						'label' => esc_html__( 'Paid reservations have to be confirmed before dates are blocked out:', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'no'
					),
				)
			),

			'admin_resa' => array(
				'label' => esc_html__( 'Settings for reservations created from admin', 'hbook-admin' ),
				'options' => array(
					'hb_resa_admin_status' => array(
						'label' => esc_html__( 'Status of reservation', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'confirmed' => esc_html__( 'Confirmed', 'hbook-admin' ),
							'new' => esc_html__( 'New', 'hbook-admin' ),
						),
						'default' => 'confirmed'
					),
				)
			),

			'website_resa' => array(
				'label' => esc_html__( 'Settings for reservations received from website', 'hbook-admin' ),
				'options' => array(
					'hb_resa_website_status' => array(
						'label' => esc_html__( 'Status of reservation', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'confirmed' => esc_html__( 'Confirmed', 'hbook-admin' ),
							'new' => esc_html__( 'New', 'hbook-admin' ),
						),
						'default' => 'new'
					),
				)
			),

			'opening_dates' => array(
				'label' => esc_html__( 'Opening dates', 'hbook-admin' ),
				'options' => array(
					'hb_min_date_days' => array(
						'label' => esc_html__( 'Minimum selectable date for a reservation:', 'hbook-admin' ),
						'caption' => wp_kses( __( 'Enter a number of <u>days</u> from current date...', 'hbook-admin' ), array( 'u' => array() ) ),
						'type' => 'text',
						'class' => 'hb-small-field',
					),
					'hb_min_date_fixed' => array(
						'caption' => esc_html__( '...or enter a fixed date (yyyy-mm-dd format)', 'hbook-admin' ),
						'type' => 'text',
						'class' => 'hb-small-field',
					),
					'hb_max_date_months' => array(
						'label' => esc_html__( 'Maximum selectable date for a reservation:', 'hbook-admin' ),
						'caption' => wp_kses( __( 'Enter the maximum number of <u>months</u> ahead...', 'hbook-admin' ), array( 'u' => array() ) ),
						'type' => 'text',
						'class' => 'hb-small-field',
						'default' => '12'
					),
					'hb_max_date_fixed' => array(
						'caption' => esc_html__( '...or enter a fixed date (yyyy-mm-dd format)', 'hbook-admin' ),
						'type' => 'text',
						'class' => 'hb-small-field',
					),
				),
			),

			'date_settings' => array(
				'label' => esc_html__( 'Date settings', 'hbook-admin' ),
				'options' => array(
					'hb_front_end_date_settings' => array()
				)
			),

			'terms' => array(
				'label' => esc_html__( 'Terms and conditions, Privacy policy', 'hbook-admin' ),
				'options' => array(
					'hb_display_terms_and_cond' => array(
						'label' => esc_html__( 'Display a terms and conditions checkbox:', 'hbook-admin' ),
						'caption' => sprintf( esc_html__( 'You can change the text of the terms and conditions checkbox on the %s Text page%s.', 'hbook-admin' ), '<a href="' . admin_url( 'admin.php?page=hb_text#hb-text-section-book-now-area' ) . '">', '</a>' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'no'
					),
					'hb_display_privacy_policy' => array(
						'label' => esc_html__( 'Display a privacy policy checkbox:', 'hbook-admin' ),
						'caption' => sprintf( esc_html__( 'You can change the text of the privacy policy checkbox on the %s Text page%s.', 'hbook-admin' ), '<a href="' . admin_url( 'admin.php?page=hb_text#hb-text-section-book-now-area' ) . '">', '</a>' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'no'
					),
				),
			),

			'misc' => array(
				'label' => esc_html__( 'Misc', 'hbook-admin' ),
				'options' => array(
					'hb_accommodation_slug' => array(
						'label' => esc_html__( 'Accommodation url slug:', 'hbook-admin' ),
						'caption' => esc_html__( 'The url slug can not be blank. If you leave this field empty the slug will be set to "hb_accommodation".', 'hbook-admin' ),
						'type' => 'text',
						'default' => 'hb_accommodation',
					),
					'hb_uninstall_delete_all' => array(
						'label' => esc_html__( 'Delete all stored information on uninstall:', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'no'
					),
					'hb_ajax_timeout' => array(
						'label' => esc_html__( 'Delay before a timeout error occurs (in ms) :', 'hbook-admin' ),
						'type' => 'text',
						'default' => '40000',
						'class' => 'hb-small-field',
					),
					'hb_admin_ajax_timeout' => array(
						'label' => esc_html__( 'Delay before a timeout error occurs (for admin pages - in ms) :', 'hbook-admin' ),
						'type' => 'text',
						'default' => '20000',
						'class' => 'hb-small-field',
					),
				)
			)
		);
	}

	public function get_ical_settings() {
		return array(
			'ical_settings' => array(
				'label' => esc_html__( 'Settings for iCal synchronization', 'hbook-admin' ),
				'options' => array(
					'hb_ical_notification_option' => array(
						'label' => esc_html__( 'Show notification messages in Reservations page?', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'yes'
					),
					'hb_ical_import_resa_status' => array(
						'label' => esc_html__( 'Status of the reservation imported from an external calendar:', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'new' => esc_html__( 'New', 'hbook-admin' ),
							'confirmed' => esc_html__( 'Confirmed', 'hbook-admin' ),
						),
						'default' => 'new'
					),
					'hb_ical_update_resa_dates' => array(
						'label' => esc_html__( 'Update the dates of a reservation when it has been modified in the external calendar? ', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'no'
					),
					'hb_ical_update_status_resa' => array(
						'label' => esc_html__( 'Update the status of a reservation when it has been cancelled in the external calendar? ', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'no'
					),
					'hb_ical_export_cancelled_resa' => array(
						'label' => esc_html__( 'Include reservations with status Cancelled in the export?', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'yes'
					),
					'hb_ical_export_blocked_dates' => array(
						'label' => esc_html__( 'Include blocked dates in the export?', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'yes'
					),
					'hb_ical_frequency' => array(
						'label' => esc_html__( 'HBook synchronization frequency (in seconds)', 'hbook-admin' ),
						'type' => 'text',
						'default' => '3660',
						'caption' => esc_html__( 'You need to deactivate and reactivate HBook after modifying this setting.', 'hbook-admin' ),
					),
					'hb_ical_summary' => array(
						'label' => esc_html__( 'Summary of reservation in the export', 'hbook-admin' ),
						'type' => 'text',
						'default' => 'HBook reservation - [customer_first_name] [customer_last_name] - Resa id: [resa_id]'
					),
					'hb_ical_description' => array(
						'label' => esc_html__( 'Description of reservation in the export', 'hbook-admin' ),
						'type' => 'textarea',
						'default' => 'NAME: [customer_first_name] [customer_last_name]' . "\r\n" .
									'EMAIL: [customer_email]',
						'caption' => esc_html__( 'You can use the following variables in the "Summary" field and the "Description" field:', 'hbook-admin' ) .
									'<br/>' .
									$this->utils->get_ical_email_available_vars()
					),
				),
			),
		);
	}

	public function get_search_form_options() {
		return array(
			'search_form_options' => array(
				'options' => array(
					'hb_maximum_adults' => array(
						'label' => esc_html__( 'Maximum adults number', 'hbook-admin' ),
						'type' => 'text',
						'class' => 'hb-small-field',
						'default' => '5'
					),
					'hb_maximum_children' => array(
						'label' => esc_html__( 'Maximum children number', 'hbook-admin' ),
						'type' => 'text',
						'class' => 'hb-small-field',
						'default' => '5'
					),
					'hb_display_adults_field' => array(
						'label' => esc_html__( 'Display an Adults field?', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'yes'
					),
					'hb_display_children_field' => array(
						'label' => esc_html__( 'Display a Children field?', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'yes'
					),
					'hb_search_form_placeholder' => array(
						'label' => esc_html__( 'Display placeholders instead of labels?', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'no'
					),
				)
			)
		);
	}

	public function get_accom_selection_options() {
		return array(
			'accom_selection_options' => array(
				'options' => array(
					'hb_title_accom_link' => array(
						'label' => esc_html__( 'Link title towards accommodation pages?', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'no'
					),
					'hb_thumb_display' => array(
						'label' => esc_html__( 'Display an accommodation thumbnail?', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'yes'
					),
					'hb_thumb_accom_link' => array(
						'label' => esc_html__( 'Link thumbnail towards accommodation pages?', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'no'
					),
					'hb_search_accom_thumb_width' => array(
						'label' => esc_html__( 'Thumbnail width (in px)', 'hbook-admin' ),
						'type' => 'text',
						'default' => '100',
						'class' => 'hb-small-field',
					),
					'hb_search_accom_thumb_height' => array(
						'label' => esc_html__( 'Thumbnail height (in px)', 'hbook-admin' ),
						'type' => 'text',
						'default' => '100',
						'class' => 'hb-small-field',
					),
					'hb_button_accom_link' => array(
						'label' => esc_html__( 'Display a button that links towards accommodation pages?', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'no'
					),
					'hb_display_price' => array(
						'label' => esc_html__( 'Display price?', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'yes'
					),
					'hb_display_price_breakdown' => array(
						'label' => esc_html__( 'Display price breakdown?', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'yes'
					),
					'hb_price_breakdown_default_state' => array(
						'label' => esc_html__( 'Price breakdown default state', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'opened' => esc_html__( 'Opened', 'hbook-admin' ),
							'closed' => esc_html__( 'Closed', 'hbook-admin' ),
						),
						'default' => 'closed'
					),
					'hb_display_detailed_accom_price' => array(
						'label' => esc_html__( 'Display detailed accommodation price?', 'hbook-admin' ),
						'type' => 'radio',
						'choice' => array(
							'yes' => esc_html__( 'Yes', 'hbook-admin' ),
							'no' => esc_html__( 'No', 'hbook-admin' ),
						),
						'default' => 'yes'
					),
				)
			)
		);
	}

	public function init_options() {
		$options = array_merge(
			$this->get_misc_settings(),
			$this->get_ical_settings(),
			$this->get_payment_settings(),
			$this->get_appearance_settings(),
			$this->get_search_form_options(),
			$this->get_accom_selection_options()
		);
		foreach ( $options as $section ) {
			foreach ( $section['options'] as $id => $option ) {
				if ( ( get_option( $id ) === false ) && ( isset( $option['default'] ) ) ) {
					add_option( $id, $option['default'] );
				}
			}
		}
		if ( ( get_option( 'hb_stripe_mode' ) === false ) ) {
			update_option( 'hb_stripe_mode', 'test' );
		}
		if ( ( get_option( 'hb_paypal_mode' ) === false ) ) {
			update_option( 'hb_paypal_mode', 'sandbox' );
		}
		if ( ( get_option( 'hb_curl_set_timeout' ) === false ) ) {
			update_option( 'hb_curl_set_timeout', 'no' );
		}
		if ( ( get_option( 'hb_curl_set_ssl_version' ) === false ) ) {
			update_option( 'hb_curl_set_ssl_version', 'no' );
		}
		if ( get_option( 'hb_store_credit_card' ) === false ) {
			update_option( 'hb_store_credit_card', 'no' );
		}
		if ( get_option( 'hb_store_credit_card' ) === false ) {
			update_option( 'hb_store_credit_card', 'no' );
		}
		if ( get_option( 'hb_ical_exclude_one_day_reservations' ) === false ) {
			update_option( 'hb_ical_exclude_one_day_reservations', 'no' );
		}
		if ( get_option( 'hb_ical_advanced_notice' ) === false ) {
			update_option( 'hb_ical_advanced_notice', 0 );
		}
		if ( get_option( 'hb_ical_import_booking_window' ) === false ) {
			update_option( 'hb_ical_import_booking_window', 0 );
		}
		if ( get_option( 'hb_paypal_icons' ) === false ) {
			update_option( 'hb_paypal_icons', '["paypal"]' );
		}
		if ( get_option( 'hb_stripe_powered_by' ) === false ) {
			update_option( 'hb_stripe_powered_by', 'no' );
		}
	}

	public function delete_options() {
		$options = array_merge(
			$this->get_misc_settings(),
			$this->get_ical_settings(),
			$this->get_payment_settings(),
			$this->get_appearance_settings(),
			$this->get_search_form_options(),
			$this->get_accom_selection_options()
		);
		foreach ( $options as $section ) {
			foreach ( $section['options'] as $id => $option ) {
				delete_option( $id );
			}
		}

		$non_standard_options = array(
			'hb_notify_admin',
			'hb_admin_email_subject',
			'hb_admin_message_type',
			'hb_admin_email_message',
			'hb_ack_email',
			'hb_ack_email_subject',
			'hb_ack_message_type',
			'hb_ack_email_message',
			'hb_confirm_email',
			'hb_confirm_email_subject',
			'hb_confirm_message_type',
			'hb_confirm_email_message',
			'hb_admin_email',
			'hb_ack_email_from',
			'hb_confirm_email_from',
			'hb_admin_email_from',
			'hb_flush_rewrite',
			'hb_paypal_sandbox',
			'hb_paypal_api_user',
			'hb_paypal_api_psw',
			'hb_paypal_api_signature',

			'hb_stripe_active',
			'hb_paypal_active',
			'hb_stripe_test_secret_key',
			'hb_stripe_test_publishable_key',
			'hb_stripe_live_secret_key',
			'hb_stripe_live_publishable_key',
			'hb_paypal_api_sandbox_user',
			'hb_paypal_api_sandbox_psw',
			'hb_paypal_api_sandbox_signature',
			'hb_paypal_api_live_user',
			'hb_paypal_api_live_psw',
			'hb_paypal_api_live_signature',
			'hb_paypal_mode',
			'hb_stripe_mode',

			'hb_valid_purchase_code',
			'hb_purchase_code_error',
			'hb_purchase_code',
			'hb_last_synced',

			'hb_form_style',

			'hb_store_credit_card',

			'hb_curl_set_timeout',
			'hb_curl_set_ssl_version',
		);

		foreach ( $non_standard_options as $option_id ) {
			delete_option( $option_id );
		}
	}

	public function get_options_list( $options_name ) {
		$get_option_name_function = 'get_' . $options_name;
		$options_to_get = $this->$get_option_name_function();
		$options_list = array();
		foreach ( $options_to_get as $section ) {
			foreach ( $section['options'] as $id => $option ) {
				$options_list[] = $id;
			}
		}
		return $options_list;
	}

	public function display_section_title( $title ) {
	?>

		<hr/>
		<h3><?php echo( esc_html( $title ) ); ?></h3>

	<?php
	}

	public function display_section_desc( $desc ) {
	?>

		<small><?php echo( wp_kses_post( $desc ) ); ?></small>

	<?php
	}

	public function display_text_option( $id, $option ) {
		$class = '';
		$caption_class = '';
		$wrapper_class = '';
		if ( isset( $option['class'] ) ) {
			$class = $option['class'];
		}
		if ( isset( $option['wrapper-class'] ) ) {
			$wrapper_class = $option['wrapper-class'];
		}
		?>

		<p class="<?php echo( esc_attr( $wrapper_class ) ); ?>">
			<?php
			if ( isset( $option['label'] ) ) {
			?>
			<label for="<?php echo( esc_attr( $id ) ); ?>"><?php echo( esc_html( $option['label'] ) ); ?></label><br/>
			<?php
			} else {
				$caption_class = "hb-no-label";
			}
			?>
			<?php
			if ( isset( $option['caption'] ) ) {
			?>
			<small class="<?php echo( esc_attr( $caption_class ) ); ?>"><?php echo( wp_kses_post( $option['caption'] ) ); ?></small><br/>
			<?php
			}
			?>
			<input
				type="text"
				id="<?php echo( esc_attr( $id ) ); ?>"
				name="<?php echo( esc_attr( $id ) ); ?>"
				class="<?php echo( esc_attr( $class ) ); ?>"
				size="50"
				value="<?php echo( esc_attr( get_option( $id ) ) ); ?>"
			/>
		</p>
	<?php
	}

	public function display_textarea_option( $id, $option ) {
		$wrapper_class = '';
		if ( isset( $option['wrapper-class'] ) ) {
			$wrapper_class = $option['wrapper-class'];
		}
		?>

		<p class="<?php echo( esc_attr( $wrapper_class ) ); ?>">
			<label for="<?php echo( esc_attr( $id ) ); ?>"><?php echo( esc_html( $option['label'] ) ); ?></label><br/>
			<textarea id="<?php echo( esc_attr( $id ) ); ?>" name="<?php echo( esc_attr( $id ) ); ?>" rows="8" class="widefat"><?php echo( esc_textarea( get_option( $id ) ) ); ?></textarea><br/>
			<?php if ( isset( $option['caption'] ) && $option['caption'] != '' ) { ?>
			<small class="hb-textarea-caption"><?php echo( wp_kses_post( $option['caption'] ) ); ?></small>
			<?php } ?>
		</p>
	<?php
	}

	public function display_radio_option( $id, $option ) {
		$wrapper_class = '';
		if ( isset( $option['wrapper-class'] ) ) {
			$wrapper_class = $option['wrapper-class'];
		}
		?>

		<p class="<?php echo( esc_attr( $wrapper_class ) ); ?>">
			<label><?php echo( esc_html( $option['label'] ) ); ?></label><br/>
			<?php
			if ( isset( $option['caption'] ) ) {
			?>
			<small><?php echo( wp_kses_post( $option['caption'] ) ); ?></small><br/>
			<?php
			}
			foreach ( $option['choice'] as $choice_id => $choice_label ) {
			?>
			<input type="radio" id="<?php echo( esc_attr( $id . '_' . $choice_id ) ); ?>" name="<?php echo( esc_attr( $id ) ); ?>" value="<?php echo( esc_attr( $choice_id ) ); ?>" <?php echo( get_option( $id ) == $choice_id ? 'checked' : '' ); ?> />
			<label for="<?php echo( esc_attr( $id . '_' . $choice_id ) ); ?>"><?php echo( esc_html( $choice_label ) ); ?></label>&nbsp;&nbsp;
				<?php
				if ( count ( $option['choice'] ) > 2 ) {
					echo( '<br/>' );
				}
			}
			?>
		</p>
	<?php
	}

	public function display_checkbox_option( $id, $option ) {
		$wrapper_class = '';
		if ( isset( $option['wrapper-class'] ) ) {
			$wrapper_class = $option['wrapper-class'];
		}
		$saved_choices = json_decode( get_option( $id ), true );
		if ( ! is_array( $saved_choices ) ) {
			$saved_choices = array();
		}
		?>

		<p class="<?php echo( esc_attr( $wrapper_class ) ); ?>">
			<label><?php echo( esc_html( $option['label'] ) ); ?></label><br/>
			<?php
			if ( isset( $option['caption'] ) ) {
			?>
			<small><?php echo( wp_kses_post( $option['caption'] ) ); ?></small><br/>
			<?php
			}
			foreach ( $option['choice'] as $choice_id => $choice_label ) {
			?>
			<input
				type="checkbox"
				id="<?php echo( esc_attr( $id . '_' . $choice_id ) ); ?>"
				name="<?php echo( esc_attr( $id ) ); ?>[]"
				value="<?php echo( esc_attr( $choice_id ) ); ?>"
				<?php echo( in_array( $choice_id, $saved_choices ) ? 'checked' : '' ); ?>
			/>
			<label for="<?php echo( esc_attr( $id . '_' . $choice_id ) ); ?>"><?php echo( esc_html( $choice_label ) ); ?></label>&nbsp;&nbsp;
				<?php
				if ( count ( $option['choice'] ) > 2 ) {
					echo( '<br/>' );
				}
			}
			?>
		</p>
	<?php
	}

	public function display_select_option( $id, $option ) {
		$wrapper_class = '';
		if ( isset( $option['wrapper-class'] ) ) {
			$wrapper_class = $option['wrapper-class'];
		}
		?>

		<p class="<?php echo( esc_attr( $wrapper_class ) ); ?>">
			<label for="<?php echo( esc_attr( $id ) ); ?>"><?php echo( esc_html( $option['label'] ) ); ?></label><br/>
			<?php $current_choice = get_option( $id ); ?>
			<select id="<?php echo( esc_attr( $id ) ); ?>" name="<?php echo( esc_attr( $id ) ); ?>">
				<?php foreach ( $option['choice'] as $choice_id => $choice_label ) { ?>
					<option value="<?php echo( esc_attr( $choice_id ) ); ?>" <?php if ( $choice_id == $current_choice ) { echo( 'selected' ); } ?>><?php echo( esc_html( $choice_label ) ); ?></option>
				<?php } ?>
			</select>
		</p>
	<?php
	}

	public function display_save_options_section() {
	?>
		<div class="hb-options-save-wrapper">

			<span class="hb-ajaxing">
				<span class="spinner"></span>
				<span><?php esc_html_e( 'Saving...', 'hbook-admin' ); ?></span>
			</span>

			<span class="hb-saved"></span>

			<p>
				<a href="#" class="hb-options-save button-primary"><?php esc_html_e( 'Save changes', 'hbook-admin' ); ?></a>
			</p>

		</div>
	<?php
	}

}