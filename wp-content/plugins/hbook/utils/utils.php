<?php
class HbUtils {

	private $hbdb;
	private $currencies;
	public $plugin_version;
	public $plugin_directory;

	public function __construct( $hbdb, $plugin_version ) {
		$this->hbdb = $hbdb;
		$this->plugin_directory = dirname( plugin_dir_path( __FILE__ ) );
		$this->plugin_url = dirname( plugin_dir_url( __FILE__ ) );
		require_once $this->plugin_directory . '/utils/currencies.php';
		$currencies = new HbCurrencies();
		$this->currencies = $currencies->currencies_list();
		$this->plugin_version = $plugin_version;
	}

	public function get_number_of_nights( $str_check_in, $str_check_out ) {
		$second_interval = strtotime( $str_check_out ) - strtotime( $str_check_in );
		$nb_nights = round( $second_interval / ( 3600 * 24 ) );
		return $nb_nights;
	}

	public function get_day_num( $str_date ) {
		$day = date( 'w', strtotime( $str_date ) );
		if ( $day == 0 ) {
			return 6;
		} else {
			return $day - 1;
		}
	}

	public function nb_accom() {
		$accom = $this->hbdb->get_all_accom_ids();
		return count( $accom );
	}

	public function get_currency_symbol( $currency = '' ) {
		if ( $currency == '' ) {
			$currency = get_option( 'hb_currency', 'USD' );
		}
		return $this->currencies[ $currency ]['symbol'];
	}

	public function currency_symbol_js() {
		?>
		<script type="text/javascript">
		/* <![CDATA[ */
		var hb_currency_symbol = '<?php echo( $this->get_currency_symbol() ); ?>';
		/* ]]> */
		</script>
		<?php
	}

	public function currencies_code_name() {
		$currencies_code_name = array();
		foreach ( $this->currencies as $currency_code => $currency ) {
			if ( $currency_code != 'XXXX' ) {
				$currencies_code_name[ $currency_code ] = $currency['name'];
			}
		}
		return $currencies_code_name;
	}

	public function days_full_name() {
		$days = esc_html__( 'Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday', 'hbook-admin' );
		$days = explode( ',', $days );
		return $days;
	}

	public function days_short_name() {
		$days = esc_html__( 'Mon,Tue,Wed,Thu,Fri,Sat,Sun', 'hbook-admin' );
		$days = explode( ',', $days );
		return $days;
	}

	public function round_price( $price ) {
		if ( get_option( 'hb_price_precision' ) != 'no_decimals' ) {
			return round( $price, 2 );
		} else {
			return round( $price );
		}
	}

	public function price_with_symbol( $price ) {
		if ( ! is_numeric( $price ) ) {
			return esc_html__( 'Error: price should be a numerical value.', 'hbook-admin' );
		}
		$negative_price_symbol = '';
		if ( $price < 0 ) {
			$negative_price_symbol = '-';
			$price = abs( $price );
		}
		if ( version_compare( PHP_VERSION, '5.4', '<' ) ) {
			global $wp_locale;
			$saved_thousands_sep = $wp_locale->number_format['thousands_sep'];
			if ( strlen( $saved_thousands_sep ) == 2 ) {
				$wp_locale->number_format['thousands_sep'] = ' ';
			}
		}
		if ( get_option( 'hb_price_precision' ) != 'no_decimals' ) {
			$price = number_format_i18n( $price, 2 );
		} else {
			if ( $price == round( $price ) ) {
				$price = number_format_i18n( round( $price ), 0 );
			} else {
				$price = number_format_i18n( $price, 2 );
			}
		}
		if ( version_compare( PHP_VERSION, '5.4', '<' ) ) {
			$wp_locale->number_format['thousands_sep'] = $saved_thousands_sep;
		}
		if ( get_option( 'hb_currency_position' ) == 'after' ) {
			return $negative_price_symbol . $price . ' ' . $this->get_currency_symbol();
		} else {
			return $negative_price_symbol . $this->get_currency_symbol() . $price;
		}
	}

	public function price_placeholder() {
		if ( get_option( 'hb_currency_position' ) == 'after' ) {
			return '<span class="hb-price-placeholder"></span> ' . $this->get_currency_symbol();
		} else {
			return $this->get_currency_symbol() . '<span class="hb-price-placeholder"></span>';
		}
	}

	public function price_with_currency_letters( $price ) {
		if ( get_option( 'hb_price_precision' ) != 'no_decimals' ) {
			$price = number_format_i18n( $price, 2 );
		} else {
			if ( $price == round( $price ) ) {
				$price = round( $price );
			} else {
				$price = number_format_i18n( $price, 2 );
			}
		}
		if ( get_option( 'hb_currency_position' ) == 'after' ) {
			return $price . ' ' . get_option( 'hb_currency', 'USD' );
		} else {
			return get_option( 'hb_currency', 'USD' ) . ' ' . $price;
		}
	}

	public function validate_date_and_people( $str_check_in, $str_check_out, $adults, $children ) {
		if ( ! is_numeric( $adults ) || ! is_numeric( $children ) ) {
			return array(
				'success' => false,
				'error_msg' => 'not num'
			);
		}
		if ( ( $str_check_in == '' ) || ( $str_check_out == '' ) ) {
			return array(
				'success' => false,
				'error_msg' => 'invalid dates'
			);
		}
		$check_in = date_create( $str_check_in );
		$check_out = date_create( $str_check_out );
		if ( ! $check_in || ! $check_out || ( $this->get_number_of_nights( $str_check_in, $str_check_out ) < 1 ) ) {
			return array(
				'success' => false,
				'error_msg' => 'invalid dates'
			);
		}
		return array(
			'success' => true
		);
	}

	public function load_jquery() {
		wp_enqueue_script( 'jquery' );
	}

	public function load_front_end_script( $script ) {
		switch ( $script ) {
			case 'utils' :
				$this->hb_enqueue_script( 'hb-front-end-utils-script', '/front-end/js/utils.js' );
				break;
			case 'availability' :
				$this->hb_enqueue_script( 'hb-availability-script', '/front-end/js/availability.js' );
				break;
			case 'rates' :
				$this->hb_enqueue_script( 'hb-rates-script', '/front-end/js/rates.js' );
				break;
			case 'validate-form' :
				$this->hb_enqueue_script( 'hb-validate-form', '/front-end/js/jquery.form-validator.min.js' );
				break;
			case 'booking-form' :
				$this->hb_enqueue_script( 'hb-front-end-booking-form-script', '/front-end/js/booking-form.js' );
				break;
		}

	}

	public function load_datepicker() {
		static $datepicker_loaded;
		if ( ! $datepicker_loaded ) {
			wp_enqueue_script( 'hb-datepicker-required-lib', $this->plugin_url . '/utils/jq-datepick/js/jquery.plugin.min.js', array(), $this->plugin_version, true );
			wp_enqueue_script( 'hb-datepicker-script', $this->plugin_url . '/utils/jq-datepick/js/jquery.datepick.min.js', array(), $this->plugin_version, true );
			wp_enqueue_script( 'hb-datepicker-launch', $this->plugin_url . '/utils/jq-datepick/js/hb-datepick.js', array(), $this->plugin_version, true );

			wp_enqueue_style( 'hb-datepicker-style', $this->plugin_url . '/utils/jq-datepick/css/hb-datepick.css', array(), $this->plugin_version );

			wp_localize_script( 'hb-datepicker-script', 'hb_max_date', $this->get_max_date() );
			wp_localize_script( 'hb-datepicker-script', 'hb_min_date', $this->get_min_date() );

			$locale = $this->get_hb_known_locale();
			require_once $this->plugin_directory . '/utils/date-localization.php';
			$date_locale_info = new HbDateLocalization();

			wp_localize_script( 'hb-datepicker-script', 'hb_months_name', $date_locale_info->locale[ $locale ]['month_names'] );
			wp_localize_script( 'hb-datepicker-script', 'hb_day_names', $date_locale_info->locale[ $locale ]['day_names'] );
			wp_localize_script( 'hb-datepicker-script', 'hb_day_names_min', $date_locale_info->locale[ $locale ]['day_names_min'] );

			if ( is_admin() ) {
				wp_enqueue_style( 'hb-datepicker-admin-style', $this->plugin_url . '/utils/jq-datepick/css/hb-datepick-admin.css', array(), $this->plugin_version );
				$date_format = 'yyyy-mm-dd';
				$first_day = '1';
			} else {
				$date_settings = json_decode( get_option( 'hb_front_end_date_settings' ), true );
				if ( isset( $date_settings[ get_locale() ] ) ) {
					$date_format = $date_settings[ get_locale() ]['date_format'];
					$first_day = $date_settings[ get_locale() ]['first_day'];
				} else {
					$date_format = $date_locale_info->locale[ $locale ]['date_format'];
					$first_day = $date_locale_info->locale[ $locale ]['first_day'];
				}
			}
			wp_localize_script( 'hb-datepicker-script', 'hb_date_format', $date_format );
			wp_localize_script( 'hb-datepicker-script', 'hb_first_day', $first_day );
			wp_localize_script( 'hb-datepicker-script', 'hb_is_rtl', $date_locale_info->locale[ $locale ]['is_rtl'] );

			$datepicker_loaded = true;
		}
	}

	public function hb_enqueue_script( $handle, $src ) {
		if ( get_option( 'hbook_status' ) == 'dev' ) {
			$version = filemtime( $this->plugin_directory . $src );
		} else {
			$version = $this->plugin_version;
		}
		wp_enqueue_script( $handle, $this->plugin_url . $src, array(), $version, true );
	}

	public function hb_admin_enqueue_script( $handle, $src ) {
		if ( get_option( 'hbook_status' ) == 'dev' ) {
			$version = filemtime( $this->plugin_directory . $src );
		} else {
			$version = $this->plugin_version;
		}
		wp_enqueue_script( $handle, $this->plugin_url . $src, array(), $version, false );
	}

	public function hb_enqueue_style( $handle, $src ) {
		if ( get_option( 'hbook_status' ) == 'dev' ) {
			$version = filemtime( $this->plugin_directory . $src );
		} else {
			$version = $this->plugin_version;
		}
		wp_enqueue_style( $handle, $this->plugin_url . $src, array(), $version );
	}


	public function get_hb_known_locale( $locale = '' ) {
		$known_locale = array(
			'af', 'am', 'ar_DZ', 'ar_EG', 'ar', 'az', 'bg', 'bs', 'ca', 'cs', 'da', 'de_CH', 'de', 'el', 'en_AU', 'en_GB', 'en_NZ', 'eo', 'es_AR', 'es_PE', 'es', 'et', 'eu', 'fa', 'fi', 'fo', 'fr_CH', 'fr', 'gl', 'gu', 'he', 'hi_IN', 'hi', 'hr', 'hu', 'hy', 'id', 'is', 'it', 'ja', 'ka', 'km', 'ko', 'lt', 'lv', 'me_ME', 'me', 'mk', 'ml', 'ms', 'mt', 'nl_BE', 'nl', 'no', 'pl', 'pt_BR', 'pt', 'rm', 'ro', 'ru', 'sk', 'sl', 'sq', 'sr_SR', 'sr', 'sv', 'ta', 'th', 'tr', 'tt', 'uk', 'ur', 'vi', 'zh_CN', 'zh_HK', 'zh_TW'
		);
		if ( ! $locale ) {
			$locale = get_locale();
		}
		if ( ! in_array( $locale, $known_locale ) ) {
			$locale = substr( $locale, 0, 2 );
			if ( ! in_array( $locale, $known_locale ) ) {
				$locale = 'en_US';
			}
		}
		return $locale;
	}

	public function get_status_days( $accom_id, $minimum_stay = false ) {
		$future_resa = $this->hbdb->get_future_resa_dates( $accom_id );
		$taken_days_candidates = array();
		foreach ( $future_resa as $resa ) {
			if ( strtotime( $resa['check_in'] ) < strtotime( '-1 day' ) ) {
				$current_date = date( 'Y-m-d', strtotime( '-1 day' ) );
			} else {
				$current_date = $current_date = $resa['check_in'];
			}
			$end_date = $resa['check_out'];
			while ( strtotime( $current_date ) < strtotime( $end_date ) ) {
				if ( ! in_array( $current_date, $taken_days_candidates ) ) {
					$taken_days_candidates[] = $current_date;
				}
				$current_date = date( 'Y-m-d', strtotime( $current_date . ' + 1 day' ) );
			}
		}

		$future_blocked_dates = $this->hbdb->get_future_blocked_dates( $accom_id );
		foreach ( $future_blocked_dates as $blocked_dates ) {
			if ( strtotime( $blocked_dates['from_date'] ) < strtotime( '-1 day' ) ) {
				$current_date = date( 'Y-m-d', strtotime( '-1 day' ) );
			} else {
				$current_date = $blocked_dates['from_date'];
			}
			$end_date = $blocked_dates['to_date'];
			while ( strtotime( $current_date ) < strtotime( $end_date ) ) {
				if ( ! in_array( $current_date, $taken_days_candidates ) ) {
					$taken_days_candidates[] = $current_date;
				}
				$current_date = date( 'Y-m-d', strtotime( $current_date . ' + 1 day' ) );
			}
		}

		$taken_days = array();
		$all_accom_ids = $this->hbdb->get_all_accom_ids();
		for ( $i = 0; $i < count( $taken_days_candidates ); $i++ ) {
			if ( $accom_id == 'all' ) {
				$taken_day = true;
				foreach ( $all_accom_ids as $tested_accom_id ) {
					if ( $this->hbdb->is_available_accom( $tested_accom_id, $taken_days_candidates[ $i ], date( 'Y-m-d', strtotime( $taken_days_candidates[ $i ] . ' + 1 day' ) ) ) ) {
						$taken_day = false;
						break;
					}
				}
				if ( $taken_day && ! in_array( $taken_days_candidates[ $i ], $taken_days ) ) {
					$taken_days[] = $taken_days_candidates[ $i ];
				}
			} else {
				if (
					! $this->hbdb->is_available_accom(
						$accom_id,
						$taken_days_candidates[ $i ],
						date( 'Y-m-d', strtotime( $taken_days_candidates[ $i ] . ' + 1 day' ) )
					) &&
					! in_array( $taken_days_candidates[ $i ], $taken_days )
				) {
					$taken_days[] = $taken_days_candidates[ $i ];
				}
			}
		}

		if ( $accom_id == 'all' && $minimum_stay !== 0 ) {
			$minimum_stay = 1;
			$booking_rules = $this->hbdb->get_all_accom_booking_rules();
			foreach ( $booking_rules as $rule ) {
				if ( $rule['type'] == 'minimum_stay' && $rule['all_seasons'] && ( $rule['minimum_stay'] > $minimum_stay ) ) {
					$minimum_stay = $rule['minimum_stay'];
				}
			}
		} else if ( ! $minimum_stay ) {
			$minimum_stay = 1;
		}
		$status_days = array();
		for ( $i = 0; $i < count( $taken_days ); $i++ ) {
			if ( in_array( date( 'Y-m-d', strtotime( $taken_days[ $i ] . ' - 1 day' ) ), $taken_days ) ) {
				$status_days[ $taken_days[ $i ] ] = 'hb-day-fully-taken';
			} else {
				$status_days[ $taken_days[ $i ] ] = 'hb-day-taken-start';
				for ( $j = 1; $j < $minimum_stay; $j++ ) {
					$unavailable_check_in_date = date( 'Y-m-d', strtotime( $taken_days[ $i ] . ' - ' . $j . ' day' ) );
					if ( isset( $status_days[ $unavailable_check_in_date ] ) ) {
						$status_days[ $unavailable_check_in_date ] .= ' hb-day-no-check-in-min-stay';
					} else {
						$status_days[ $unavailable_check_in_date ] = 'hb-day-no-check-in-min-stay';
					}
				}
			}
			$day_taken_end_candidate = date( 'Y-m-d', strtotime( $taken_days[ $i ] . ' + 1 day' ) );
			if ( ! in_array( $day_taken_end_candidate, $taken_days ) ) {
				if ( isset( $status_days[ $day_taken_end_candidate ] ) ) {
					$status_days[ $day_taken_end_candidate ] .= ' hb-day-taken-end';
				} else {
					$status_days[ $day_taken_end_candidate ] = 'hb-day-taken-end';
				}
			}
		}

		$max_date = $this->get_max_date();
		if ( $max_date ) {
			for ( $i = 0; $i < $minimum_stay; $i++ ) {
				$unavailable_check_in_date = date( 'Y-m-d', strtotime( $max_date . ' - ' . $i . ' day' ) );
				if ( isset( $status_days[ $unavailable_check_in_date ] ) ) {
					$status_days[ $unavailable_check_in_date ] .= 'hb-day-no-check-in-min-stay';
				} else {
					$status_days[ $unavailable_check_in_date ] = 'hb-day-no-check-in-min-stay';
				}
			}
		}
		return $status_days;
	}

	public function format_date( $unformatted_date ) {
		$date_settings = json_decode( get_option( 'hb_front_end_date_settings' ), true );
		$locale = get_locale();
		if ( isset( $date_settings[ $locale ]['date_format'] ) ) {
			$date_format = $date_settings[ $locale ]['date_format'];
		} else {
			require_once $this->plugin_directory . '/utils/date-localization.php';
			$date_locale_info = new HbDateLocalization();
			$date_format = $date_locale_info->locale[ $this->get_hb_known_locale( $locale ) ]['date_format'];
		}
		$php_date_format = 'Y-m-d';
		$delimiters = array( '/', '.', '-' );
		foreach ( $delimiters as $delimiter ) {
			if ( strpos( $date_format, $delimiter ) ) {
				$date_format_elements = explode( $delimiter, $date_format );
				$php_date_format_elements = array();
				foreach ( $date_format_elements as $element ) {
					switch ( $element ) {
						case 'yyyy': $php_date_format_elements[] = 'Y'; break;
						case 'mm': $php_date_format_elements[] = 'm'; break;
						case 'dd': $php_date_format_elements[] = 'd'; break;
					}
					$php_date_format = implode( $delimiter, $php_date_format_elements );
				}
				break;
			}
		}
		return date( $php_date_format, strtotime( $unformatted_date ) );
	}

	private $email_locale;

	public function email_filter_locale() {
		return $this->email_locale;
	}

	public function send_email( $action, $resa_id ) {
		$resa = $this->hbdb->get_single( 'resa', $resa_id );

		$this->email_locale = $resa['lang'];
		remove_all_filters( 'locale' );
		add_filter( 'locale', array( $this, 'email_filter_locale' ) );

		if ( $this->is_site_multi_lang() ) {
			$email_templates_resa_lang = $this->hbdb->get_email_templates( $action, $resa['lang'] );
			$email_templates_all_lang = $this->hbdb->get_email_templates( $action, 'all' );
			$email_tmpls = array_merge( $email_templates_resa_lang, $email_templates_all_lang );
		} else {
			$email_tmpls = $this->hbdb->get_email_templates( $action, 'any' );
		}

		$emails_vars = array( 'to_address', 'reply_to_address', 'from_address', 'subject', 'message' );

		foreach ( $email_tmpls as $email_tmpl ) {
			if ( $email_tmpl['format'] == 'HTML' ) {
				$is_html_email = true;
			} else {
				$is_html_email = false;
			}

			foreach ( $emails_vars as $email_var ) {
				$$email_var = $this->replace_resa_vars_with_value( $resa_id, $is_html_email, $email_tmpl[ $email_var ] );
				$$email_var = $this->replace_customer_vars_with_value( $resa['customer_id'], $$email_var );
			}

			if ( $to_address == '' ) {
				$to_address = get_option( 'admin_email' );
			}

			$header = array();
			if ( $is_html_email ) {
				$header[] = 'Content-type: text/html';
			}

			if ( ! $from_address ) {
				$sitename = strtolower( $_SERVER['SERVER_NAME'] );
				if ( substr( $sitename, 0, 4 ) == 'www.' ) {
					$sitename = substr( $sitename, 4 );
				}
				$from_address = get_option( 'blogname' ) . ' <no-reply@' . $sitename . '>';
			}
			$header[] = 'From: ' . $from_address;

			if ( $reply_to_address ) {
				$header[] = 'Reply-To: ' . $reply_to_address;
			}

			try {
				wp_mail( $to_address, $subject, $message, $header );
			} catch( phpmailerException $e ) {
			}

		}
		remove_filter( 'locale', array( $this, 'email_filter_locale' ) );
	}

	public function send_not_automatic_email() {
		$resa_id = intval( $_POST['resa_id'] );
		$resa = $this->hbdb->get_single( 'resa', $resa_id );
		$customer = $this->hbdb->get_single( 'customers', $resa['customer_id'] );

		$is_html_email = false;
		$to_address = '';
		$from_address = '';
		$reply_to_address = '';

		if ( $_POST['email_template'] ) {
			$this->email_locale = $resa['lang'];
			remove_all_filters( 'locale' );
			add_filter( 'locale', array( $this, 'email_filter_locale' ) );
			$email_tmpl = $this->hbdb->get_single( 'email_templates', $_POST['email_template'] );
			if ( $email_tmpl['format'] == 'HTML' ) {
				$is_html_email = true;
			}
			$to_address = $this->replace_resa_vars_with_value( $resa_id, $is_html_email, $email_tmpl['to_address'] );
			$to_address = $this->replace_customer_vars_with_value( $resa['customer_id'], $to_address );
			$from_address = $this->replace_resa_vars_with_value( $resa_id, $is_html_email, $email_tmpl['from_address'] );
			$from_address = $this->replace_customer_vars_with_value( $resa['customer_id'], $from_address );
			$reply_to_address = $this->replace_resa_vars_with_value( $resa_id, $is_html_email, $email_tmpl['reply_to_address'] );
			$reply_to_address = $this->replace_customer_vars_with_value( $resa['customer_id'], $reply_to_address );
		}

		$subject = $this->replace_resa_vars_with_value( $resa_id, $is_html_email, stripslashes( $_POST['email_subject'] ) );
		$subject = $this->replace_customer_vars_with_value( $resa['customer_id'], $subject );

		$message = $this->replace_resa_vars_with_value( $resa_id, $is_html_email, stripslashes( $_POST['email_message'] ) );
		$message = $this->replace_customer_vars_with_value( $resa['customer_id'], $message );

		remove_filter( 'locale', array( $this, 'email_filter_locale' ) );

		if ( ! $to_address ) {
			$to_address = $customer['email'];
		}

		$header = array();
		if ( $is_html_email ) {
			$header[] = 'Content-type: text/html';
		}

		if ( ! $from_address ) {
			$sitename = strtolower( $_SERVER['SERVER_NAME'] );
			if ( substr( $sitename, 0, 4 ) == 'www.' ) {
				$sitename = substr( $sitename, 4 );
			}
			$from_address = get_option( 'blogname' ) . ' <no-reply@' . $sitename . '>';
		}
		$header[] = 'From: ' . $from_address;

		if ( $reply_to_address ) {
			$header[] = 'Reply-To: ' . $reply_to_address;
		}

		return wp_mail( $to_address, $subject, $message, $header );
	}

	public function replace_resa_vars_with_value( $resa_id, $is_html, $text ) {
		$resa = $this->hbdb->get_single( 'resa', $resa_id );

		$resa_info = array( 'id', 'adults', 'children', 'admin_comment' );
		foreach ( $resa_info as $info ) {
			$text = str_replace( '[resa_' . $info . ']', $resa[ $info ], $text );
		}

		$text = str_replace( '[resa_received_on]', $this->get_blog_datetime( $resa['received_on'] ), $text );
		$text = str_replace( '[resa_check_in]', $this->format_date( $resa['check_in'] ), $text );
		$text = str_replace( '[resa_check_out]', $this->format_date( $resa['check_out'] ), $text );
		$text = str_replace( '[resa_number_of_nights]', $this->get_number_of_nights( $resa['check_in'], $resa['check_out'] ), $text );

		$accom_name = get_the_title( $this->get_translated_post_id_by_locale( $resa['accom_id'], get_locale() ) );
		$text = str_replace( '[resa_accommodation]', $accom_name, $text );
		if ( $resa['accom_num'] ) {
			$text = str_replace( '[resa_accommodation_num]', $this->hbdb->get_accom_num_name_by_accom_num( $resa['accom_id'], $resa['accom_num'] ), $text );
		} else {
			$text = str_replace( '[resa_accommodation_num]', '', $text );
		}

		$bond = floatval( get_option( 'hb_security_bond_amount' ) );
		if ( $is_html ) {
			$text = str_replace( '[resa_paid]', $this->price_with_symbol( $resa['paid'] ), $text );
			$text = str_replace( '[resa_price]', $this->price_with_symbol( $resa['price'] ), $text );
			$text = str_replace( '[resa_deposit]', $this->price_with_symbol( $resa['deposit'] ), $text );
			$text = str_replace( '[resa_price_minus_deposit]', $this->price_with_symbol( $resa['price'] - $resa['deposit'] ), $text );
			$text = str_replace( '[resa_remaining_balance]', $this->price_with_symbol( $resa['price'] - $resa['paid'] ), $text );
			$text = str_replace( '[resa_price_including_bond]', $this->price_with_symbol( $resa['price'] + $bond ), $text );
			$text = str_replace( '[resa_deposit_including_bond]', $this->price_with_symbol( $resa['deposit'] + $bond ), $text );
			$text = str_replace( '[resa_remaining_balance_including_bond]', $this->price_with_symbol( $resa['price'] + $bond - $resa['paid'] ), $text );
			$text = str_replace( '[resa_bond]', $this->price_with_symbol( $bond ), $text );
			$resa_extras = $this->resa_options_markup( $resa );
			if ( $resa_extras ) {
				$resa_extras = $this->hbdb->get_string( 'chosen_options' ) . '<br/>' . $resa_extras;
			}
			$text = str_replace( '[resa_options]', $resa_extras, $text ); // Backward compatibility
			$text = str_replace( '[resa_extras]', $resa_extras, $text );
		} else {
			$text = str_replace( '[resa_paid]', $this->price_with_currency_letters( $resa['paid'] ), $text );
			$text = str_replace( '[resa_price]', $this->price_with_currency_letters( $resa['price'] ), $text );
			$text = str_replace( '[resa_deposit]', $this->price_with_currency_letters( $resa['deposit'] ), $text );
			$text = str_replace( '[resa_price_minus_deposit]', $this->price_with_currency_letters( $resa['price'] - $resa['deposit'] ), $text );
			$text = str_replace( '[resa_remaining_balance]', $this->price_with_currency_letters( $resa['price'] - $resa['paid'] ), $text );
			$text = str_replace( '[resa_price_including_bond]', $this->price_with_currency_letters( $resa['price'] + $bond ), $text );
			$text = str_replace( '[resa_deposit_including_bond]', $this->price_with_currency_letters( $resa['deposit'] + $bond ), $text );
			$text = str_replace( '[resa_remaining_balance_including_bond]', $this->price_with_currency_letters( $resa['price'] + $bond - $resa['paid'] ), $text );
			$text = str_replace( '[resa_bond]', $this->price_with_currency_letters( $bond ), $text );
			$resa_extras = $this->resa_options_text( $resa );
			if ( $resa_extras ) {
				$resa_extras = $this->hbdb->get_string( 'chosen_options' ) . "\n" . $resa_extras;
			}
			$text = str_replace( '[resa_options]', $resa_extras, $text ); // Backward compatibility
			$text = str_replace( '[resa_extras]', $resa_extras, $text );
		}

		$resa_additional_info = json_decode( $resa['additional_info'], true );
		if ( is_array( $resa_additional_info ) ) {
			$resa_additional_info_fields = $this->hbdb->get_additional_booking_info_form_fields();
			foreach ( $resa_additional_info_fields as $field ) {
				$resa_additional_info_for_field = '';
				if ( isset( $resa_additional_info[ $field['id'] ] ) ) {
					$resa_additional_info_for_field = $resa_additional_info[ $field['id'] ];
				}
				$text = str_replace( '[resa_' . $field['id'] . ']', $resa_additional_info_for_field, $text );
			}
		}

		return $text;
	}

	public function replace_customer_vars_with_value( $customer_id, $text ) {
		$customer = $this->hbdb->get_single( 'customers', $customer_id );
		if ( $customer ) {
			$text = str_replace( '[customer_id]', $customer['id'], $text );
			$customer_info = json_decode( $customer['info'], true );
			if ( is_array( $customer_info ) ) {
				$customer_fields = $this->hbdb->get_customer_form_fields();
				foreach ( $customer_fields as $field ) {
					$customer_info_for_field = '';
					if ( isset( $customer_info[ $field['id'] ] ) ) {
						$customer_info_for_field = $customer_info[ $field['id'] ];
					}
					$text = str_replace( '[customer_' . $field['id'] . ']', $customer_info_for_field, $text );
					$text = str_replace( '[' . $field['id'] . ']', $customer_info_for_field, $text );
				}
			}
		}
		return $text;
	}

	public function replace_fields_var_with_value( $vars, $values, $text ) {
		foreach ( $vars as $var ) {
			$value = '';
			if ( isset ( $values[ 'hb_' . $var ] ) ) {
				if ( is_array( $values[ 'hb_' . $var ] ) ) {
					$value =  strip_tags( stripslashes( implode( ', ', $values[ 'hb_' . $var ] ) ) );
				} else {
					$value =  strip_tags( stripslashes( $values[ 'hb_' . $var ] ) );
				}
			}
			$text = str_replace( '[' . $var . ']', $value, $text );
		}
		return $text;
	}

	public function get_ical_email_available_vars() {
		$vars = array(
			'[resa_id]', '[resa_check_in]', '[resa_check_out]', '[resa_number_of_nights]', '[resa_accommodation]',
			'[resa_accommodation_num]', '[resa_adults]', '[resa_children]', '[resa_admin_comment]', '[resa_extras]',
			'[resa_price]', '[resa_deposit]', '[resa_price_minus_deposit]', '[resa_paid]', '[resa_remaining_balance]', '[resa_bond]',
			'[resa_price_including_bond]', '[resa_deposit_including_bond]', '[resa_remaining_balance_including_bond]',
			'[resa_received_on]'
		);

		$resa_additional_fields = $this->hbdb->get_additional_booking_info_form_fields();
		foreach ( $resa_additional_fields as $field ) {
			$vars[] = '[resa_' . $field['id'] . ']';
		}

		$vars[] = '[customer_id]';
		$customer_fields = $this->hbdb->get_customer_form_fields();
		foreach ( $customer_fields as $field ) {
			$vars[] = '[customer_' . $field['id'] . ']';
		}

		$vars = implode( ' &nbsp;-&nbsp; ', $vars );
		return $vars;
	}

	public function calculate_options_price( $adults, $children, $nb_nights, $options ) {

		$tmp_options = array();
		foreach ( $options as $option ) {
			if ( $option['choice_type'] == 'single' ) {
				$tmp_options[ 'option_' . $option['id'] ] = $option;
			} else{
				foreach( $option['choices'] as $option_choice ) {
					$tmp_options[ 'option_choice_' . $option_choice['id'] ] = array_merge( $option, $option_choice );
				}
			}
		}
		$options = $tmp_options;

		$extras_fees_rate = 1;
		$extras_fees_percentages = $this->hbdb->get_extras_fees_percentages();
		foreach ( $extras_fees_percentages as $extras_fee_percentage ) {
			$extras_fees_rate += $extras_fee_percentage / 100;
		}

		$price_options = array();
		foreach ( $options as $option_id => $option ) {
			if ( $option['apply_to_type'] == 'quantity' || $option['apply_to_type'] == 'per-accom' ) {
				$price_options[ $option_id ] = $this->round_price( $option['amount'] * $extras_fees_rate );
			} else if ( $option['apply_to_type'] == 'quantity-per-day' ) {
				$price_options[ $option_id ] = $this->round_price( $option['amount'] * $nb_nights * $extras_fees_rate );
			} else if ( $option['apply_to_type'] == 'per-person' ) {
				$price_options[ $option_id ] = $this->round_price( ( $option['amount'] * $adults + $option['amount_children'] * $children ) * $extras_fees_rate );
			} else if ( $option['apply_to_type'] == 'per-accom-per-day' ) {
				$price_options[ $option_id ] = $this->round_price( $option['amount'] * $nb_nights * $extras_fees_rate );
			} else if ( $option['apply_to_type'] == 'per-person-per-day' ) {
				$price_options[ $option_id ] = $this->round_price( ( $option['amount'] * $adults + $option['amount_children'] * $children ) * $nb_nights * $extras_fees_rate );
			}
		}

		return $price_options;
	}

	public function resa_non_editable_info_markup( $resa ) {
		$options_text = $this->resa_options_markup_admin( $resa );
		if ( $options_text ) {
			$options_text = '<b><u>' . esc_html__( 'Extra services:', 'hbook-admin' ) . '</u></b><br/>' . $options_text;
		}

		$payment_gateway = '';
		if ( $resa['payment_gateway'] ) {
			$payment_gateway = '<b><u>' . esc_html__( 'Payment method:', 'hbook-admin' ) . '</u></b><br/>';
			$payment_gateway .= $resa['payment_gateway'] . '<br/>';
		}

		$coupon = '';
		if ( $resa['coupon'] ) {
			$coupon = '<b><u>' . esc_html__( 'Coupon:', 'hbook-admin' ) . '</u></b><br/>';
			$coupon .= $resa['coupon'] . '<br/>';
		}

		$origin = '';
		if ( $resa['origin'] && $resa['origin'] != 'website' ) {
			$origin = '<b><u>' . esc_html__( 'Reservation origin:', 'hbook-admin' ) . '</u></b><br/>';
			$origin .= $resa['origin'] . '<br/>';
		}

		$resa_info = $options_text . $payment_gateway . $coupon . $origin;

		return $resa_info;
	}

	private function resa_options_markup_admin( $resa ) {
		return $this->resa_options_generic( $resa, true, true );
	}

	private function resa_options_markup( $resa ) {
		return $this->resa_options_generic( $resa, true, false );
	}

	private function resa_options_text( $resa ) {
		return $this->resa_options_generic( $resa, false, false );
	}

	private function resa_options_generic( $resa, $is_markup, $is_admin ) {
		$chosen_options = array();
		if ( $resa['options'] ) {
			$chosen_options = json_decode( $resa['options'], true );
		}
		if ( count( $chosen_options ) == 0 ) {
			return '';
		}
		$options_text = '';
		$tmp_options = array();
		$options = $this->hbdb->get_all_options_with_choices();
		foreach ( $options as $option ) {
			$tmp_options[ $option['id'] ] = $option;
		}
		$options = $tmp_options;
		$options_choices = $this->hbdb->get_all( 'options_choices' );
		$choice_name = array();
		foreach ( $options_choices as $choice ) {
			$choice_name[ $choice['id'] ] = $choice['name'];
		}
		$bold_begin = '';
		$bold_end = '';
		$line_break = "\n";
		if ( $is_markup ) {
			if ( $is_admin ) {
				$bold_begin = '<b>';
				$bold_end = '</b>';
			}
			$line_break = '<br/>';
		}
		foreach ( $chosen_options as $option_id => $option_value ) {
			if ( isset( $options[ $option_id ] ) ) {
				$option_name = $this->hbdb->get_string( 'option_' . $option_id );
				if ( $is_admin || ! $option_name ) {
					$option_name = $options[ $option_id ]['name'];
				}
				$new_option_text = '';
				if ( $options[ $option_id ]['apply_to_type'] == 'quantity' || $options[ $option_id ]['apply_to_type'] == 'quantity-per-day' ) {
					$option_choice_name = '';
					if ( $option_value != 0 ) {
						$new_option_text = '- ' . $bold_begin . $option_name . ': ' . $bold_end . $option_value . $line_break;
					}
				} else if ( $options[ $option_id ]['choice_type'] == 'single' ) {
					$option_choice_name = '';
					$new_option_text = '- ' . $bold_begin . $option_name . $bold_end . $line_break;
				} else if ( $options[ $option_id ]['choice_type'] == 'multiple' ) {
					$option_choice_name = $this->hbdb->get_string( 'option_choice_' . $option_value );
					if ( $is_admin || ! $option_choice_name ) {
						if ( isset( $choice_name[ $option_value ] ) ) {
							$option_choice_name = $choice_name[ $option_value ];
						} else {
							$option_choice_name = '';
						}
					}
					$new_option_text = '- ' . $bold_begin . $option_name . ': ' . $bold_end . $option_choice_name . $line_break;
				}
				if ( ! $is_admin ) {
					$new_option_text = apply_filters( 'hb_resa_extra_formatting', $new_option_text, $option_name, $option_value, $option_choice_name );
				}
				$options_text .= $new_option_text;
			}
		}
		return $options_text;
	}

	public function resa_max_refundable( $payment_info ) {
		$payment_info = json_decode( $payment_info, true );
		if ( ! $payment_info || ! isset( $payment_info['stripe_charges'] ) ) {
			return 0;
		}
		$stripe_charges = $payment_info['stripe_charges'];
		$max_refundable = 0;
		foreach ( $stripe_charges as $charge ) {
			$max_refundable += $charge['amount'];
		}
		return $max_refundable;
	}

	public function get_min_date() {
		$min_date = get_option( 'hb_min_date_fixed' );
		if ( ! $min_date ) {
			$nb_days = intval( get_option( 'hb_min_date_days' ) );
			if ( $nb_days ) {
				$tmp_date = new DateTime();
				$tmp_date->modify( "+{$nb_days} day" );
				$min_date = $tmp_date->format( 'Y-m-d' );
			} else {
				$min_date = '0';
			}
		}
		return $min_date;
	}

	public function get_max_date() {
		$max_date = get_option( 'hb_max_date_fixed' );
		if ( ! $max_date ) {
			$nb_months = intval( get_option( 'hb_max_date_months' ) );
			if ( $nb_months ) {
				$tmp_date = new DateTime();
				$tmp_date->modify( "+{$nb_months} month" );
				$max_date = $tmp_date->format( 'Y-m-t' );
			} else {
				$max_date = '0';
			}
		}
		return $max_date;
	}

	public function get_default_lang_post_id( $accom_id ) {
		if ( function_exists( 'pll_get_post' ) ) {
			$accom_id = pll_get_post( $accom_id, pll_default_language() );
		} else if ( function_exists( 'icl_object_id' ) ) {
			global $sitepress;
			$default_lang = $sitepress->get_locale( $sitepress->get_default_language() );
			$default_lang = substr( $default_lang, 0, 2 );
			$accom_id = icl_object_id( $accom_id, 'hb_accommodation', true, $default_lang );
		}
		return $accom_id;
	}

	private function get_translated_post_id( $accom_id ) {
		if ( function_exists( 'icl_object_id' ) && ! function_exists( 'pll_get_post' ) ) {
			$accom_id = icl_object_id( $accom_id, 'hb_accommodation', true );
		} else if ( function_exists( 'pll_get_post' ) ) {
			$trans_id = pll_get_post( $accom_id );
			if ( $trans_id ) {
				$accom_id = $trans_id;
			}
		}
		return $accom_id;
	}

	private function get_translated_post_id_by_locale( $accom_id, $current_locale ) {
		if ( function_exists( 'pll_get_post' ) ) {
			$locales = pll_languages_list( array( 'fields' => 'locale' ) );
			$slugs = pll_languages_list( array( 'fields' => 'slug' ) );
			$locale_slugs = array();
			foreach ( $locales as $i => $locale ) {
				$locale_slugs[ $locale ] = $slugs[ $i ];
			}
			$accom_id = pll_get_post( $accom_id, $locale_slugs[ $current_locale ] );
		} else if ( function_exists( 'icl_object_id' ) ) {
			$wpml_langs = icl_get_languages();
			$locale_slugs = array();
			foreach ( $wpml_langs as $lang_id => $wpml_lang ) {
				$locale_slugs[ $wpml_lang['default_locale'] ] = $wpml_lang[ 'code' ];
			}
			$accom_id = icl_object_id( $accom_id, 'hb_accommodation', true, $locale_slugs[ $current_locale ] );
		} else if ( function_exists( 'qtranxf_getLanguage' ) ) {
			global $q_config;
			$locale_slugs = array();
			foreach ( $q_config['locale'] as $lang_code => $locale ) {
				if ( $locale == $current_locale ) {
					global $wpdb;
					$raw_title = $wpdb->get_var( $wpdb->prepare( "SELECT post_title FROM $wpdb->posts WHERE ID = %d", $accom_id ) );
					$re = "/\\[:" . $lang_code . "](.*)\\[:/U";
					if ( preg_match( $re, $raw_title, $matches ) ) {
						return $matches[1];
					}
				}
			}
		}
		return $accom_id;
	}

	public function get_accom_title( $accom_id ) {
		return get_the_title( $this->get_translated_post_id( $accom_id  ) );
	}

	public function get_accom_link( $accom_id ) {
		$accom_default_page = get_post_meta( $accom_id, 'accom_default_page', true );
		if ( $accom_default_page == 'no' ) {
			$accom_id = get_post_meta( $accom_id, 'accom_linked_page', true );
		}
		return get_permalink( $this->get_translated_post_id( $accom_id  ) );
	}

	public function get_accom_search_desc( $accom_id ) {
		return do_shortcode( get_post_meta( $this->get_translated_post_id( $accom_id  ), 'accom_search_result_desc', true ) );
	}

	public function get_accom_list_desc( $accom_id ) {
		return do_shortcode( get_post_meta( $this->get_translated_post_id( $accom_id  ), 'accom_list_desc', true ) );
	}

	public function get_thumb_mark_up( $accom_id, $width, $height, $class = '' ) {
		$thumb_id = get_post_thumbnail_id( $accom_id );
		$thumb_array = wp_get_attachment_image_src( $thumb_id, 'full' );
		$thumb_url = $thumb_array[0];
		if ( ! $thumb_url ) {
			return '';
		} else {
			$thumb_alt = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
			$retina_scale_factor = apply_filters( 'hb_retina_scale_factor', 1 );
			return '<img src="' . $this->aq_resize( $thumb_url, $width * $retina_scale_factor, $height * $retina_scale_factor, true  ) . '" class="' . $class . '" width="' . $width . '" height="' . $height . '" alt="' . $thumb_alt . '" />';
		}
	}

	public function get_langs() {
		$langs = array();
		if ( function_exists( 'icl_get_languages' ) && ! function_exists( 'pll_languages_list' ) ) {
			$wpml_langs = icl_get_languages( 'skip_missing=0&orderby=code' );
			foreach ( $wpml_langs as $lang_id => $wpml_lang ) {
				$langs[ $wpml_lang['default_locale'] ] = $wpml_lang[ 'native_name' ];
			}
		} else if ( function_exists( 'pll_languages_list' ) ) {
			$locales = pll_languages_list( array( 'fields' => 'locale' ) );
			$names = pll_languages_list( array( 'fields' => 'name' ) );
			foreach ( $locales as $i => $locale ) {
				$langs[ $locale ] = $names[ $i ];
			}
		} else if ( function_exists( 'qtranxf_getLanguage' ) ) {
			global $q_config;
			foreach ( $q_config['enabled_languages'] as $q_lang ) {
				$langs[ $q_config['locale'][ $q_lang ] ] = $q_config['language_name'][ $q_lang ];
			}
		} else {
			if ( get_locale() != 'en_US' ) {
				require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );
				$translations = wp_get_available_translations();
				$langs[ get_locale() ] = $translations[ get_locale() ]['native_name'];
			}
		}
		if ( ! array_key_exists( 'en_US', $langs ) ) {
			$langs = array_merge( array( 'en_US' => 'English' ), $langs );
		}
		$langs = apply_filters( 'hb_language_list', $langs );
		return $langs;
	}

	public function is_site_multi_lang() {
		$langs = array();
		$langs = apply_filters( 'hb_language_list', $langs );
		if ( $langs ||
			function_exists( 'pll_languages_list' ) ||
			function_exists( 'icl_get_languages' ) ||
			function_exists( 'qtranxf_getLanguage' )
		) {
			return true;
		} else {
			return false;
		}
	}

	public function get_payment_gateways() {
		$gateways = array();
		return apply_filters( 'hbook_payment_gateways', $gateways );
	}

	public function get_active_payment_gateways() {
		$gateways = $this->get_payment_gateways();
		$active_gateways = array();
		foreach ( $gateways as $gateway ) {
			if ( get_option( 'hb_' . $gateway->id . '_active' ) == 'yes' ) {
				$active_gateways[] = $gateway;
			}
		}
		return $active_gateways;
	}

	public function get_payment_gateway( $gateway_id ) {
		$gateways = $this->get_payment_gateways();
		foreach ( $gateways as $gateway ) {
			if ( $gateway->id == $gateway_id ) {
				return $gateway;
			}
		}
		return false;
	}

	public function admin_custom_css() {
		if ( get_option( 'hb_custom_css_backend' ) ) {
			echo( '<style type="text/css">' . wp_strip_all_tags( get_option( 'hb_custom_css_backend' ) ) . '</style>' );
		}
	}

	public function frontend_basic_css() {
		if ( $this->load_css() ) {
			$this->hb_enqueue_style( 'hb-front-end-style', '/front-end/css/hbook.css' );
			if ( is_rtl() ) {
				wp_enqueue_style( 'hb-front-end-style-rtl', $this->plugin_url . '/front-end/css/hbook-rtl.css', array(), $this->plugin_version );
			}
			if ( get_option( 'hb_buttons_style' ) == 'custom' ) {
				wp_enqueue_style( 'hb-front-end-buttons', $this->plugin_url . '/front-end/css/hbook-buttons.css', array(), $this->plugin_version );
			}
			if ( get_option( 'hb_inputs_selects_style' ) == 'custom' ) {
				wp_enqueue_style( 'hb-front-end-inputs-selects', $this->plugin_url . '/front-end/css/hbook-inputs-selects.css', array(), $this->plugin_version );
			}
			if ( get_option( 'hb_tables_style' ) == 'plugin' ) {
				?>

				<style type="text/css">
				.hb-rates-table {
					border-collapse: collapse;
					table-layout: fixed;
					width: 100%;
					word-wrap: break-word;
				}
				.hb-rates-table th,
				.hb-rates-table td {
					border: 1px solid #ddd;
					padding: 10px;
					text-align: center;
				}
				</style>

				<?php
			}
			if ( get_option( 'hb_price_breakdown_default_state' ) == 'opened' ) {
				?>

				<style type="text/css">
				.hb-accom .hb-price-breakdown {
					display: block;
				}
				.hb-accom .hb-price-bd-show-text {
					display: none;
				}
				.hb-accom .hb-price-bd-hide-text {
					display: inline;
				}
				</style>

				<?php
			}
			$search_form_max_width = intval( get_option( 'hb_search_form_max_width' ) );
			$accom_selection_form_max_width = intval( get_option( 'hb_accom_selection_form_max_width' ) );
			$details_form_max_width = intval( get_option( 'hb_details_form_max_width' ) );
			$forms_position = get_option( 'hb_forms_position' );
			if ( $search_form_max_width ) {
			?>
				<style type="text/css">.hb-booking-search-form { max-width: <?php echo( $search_form_max_width ); ?>px; }</style>
			<?php
			}
			if ( $accom_selection_form_max_width ) {
			?>
				<style type="text/css">.hb-accom-list { max-width: <?php echo( $accom_selection_form_max_width ); ?>px; }</style>
			<?php
			}
			if ( $details_form_max_width ) {
			?>
				<style type="text/css">.hb-booking-details-form { max-width: <?php echo( $details_form_max_width ); ?>px; }</style>
			<?php
			}
			if ( $forms_position == 'center' ) {
			?>
				<style type="text/css">.hb-booking-search-form, .hb-accom-list, .hb-booking-details-form { margin: 0 auto; }</style>
			<?php
			}
		}
	}

	public function frontend_calendar_css() {
		if ( $this->load_css() ) {
			$calendar_color_css_rules = $this->calendar_color_css_rules();
			$calendar_color_values = json_decode( get_option( 'hb_calendar_colors' ), true );
			$css_rules = '';
			foreach ( $calendar_color_css_rules as $rule_id => $rule ) {
				if ( isset( $calendar_color_values[ $rule_id ] ) ) {
					$color_value = $calendar_color_values[ $rule_id ];
				} else {
					$color_value = $rule['default'];
				}
				$css_rules .= $rule['selector'] . ' { ' . $rule['property'] . ': ' . $color_value . '; }';
			}
			if ( get_option( 'hb_calendar_shadows' ) != 'no' ) {
				$css_rules .= '.hb-datepick-popup-wrapper { box-shadow: 0 0 30px rgba(0,0,0,0.33), 0 0 3px rgba(0,0,0,0.2); }';
				$css_rules .= '.hb-availability-calendar .hb-datepick-wrapper { box-shadow: 0 0 4px rgba(0,0,0,0.5); }';
			}
			echo( '<style type="text/css">' . $css_rules . '</style>' );
		}
	}

	public function frontend_buttons_css() {
		if ( get_option( 'hb_buttons_style' ) == 'custom' && $this->load_css() ) {
			$buttons_css_rules = $this->buttons_css_rules();
			$buttons_css_options = json_decode( get_option( 'hb_buttons_css_options' ), true );
			$css_rules = '';
			foreach ( $buttons_css_rules as $rule_id => $rule ) {
				if ( $rule_id != 'bg_hover' ) {
					if ( isset( $buttons_css_options[ $rule_id ] ) ) {
						$rule_value = $buttons_css_options[ $rule_id ];
					} else {
						$rule_value = $rule['default'];
					}
					foreach ( $rule['property'] as $rule_property ) {
						$css_rules .= $rule_property . ' :' . $rule_value;
						if ( $rule['type'] == 'number' ) {
							$css_rules .= 'px';
						}
						$css_rules .= ' !important; ';
					}
				}
			}
			$css_rules = '.hbook-wrapper input[type="submit"] { ' . $css_rules . '} ';
			if ( isset( $buttons_css_options['bg_hover'] ) ) {
				$rule_value = $buttons_css_options['bg_hover'];
			} else {
				$rule_value = $buttons_css_rules['bg_hover']['default'];
			}
			$css_rules .= '.hbook-wrapper input[type="submit"]:hover { background: ' . $rule_value . ' !important; }';
			echo( '<style type="text/css">' . $css_rules . '</style>' );
		}
	}

	public function frontend_inputs_selects_css() {
		if ( get_option( 'hb_inputs_selects_style' ) == 'custom' && $this->load_css() ) {
			$inputs_selects_css_rules = $this->inputs_selects_css_rules();
			$inputs_selects_css_options = json_decode( get_option( 'hb_inputs_selects_css_options' ), true );
			$css_rules = '';
			foreach ( $inputs_selects_css_rules as $rule_id => $rule ) {
				if ( $rule_id != 'border_color_active' ) {
					if ( isset( $inputs_selects_css_options[ $rule_id ] ) ) {
						$rule_value = $inputs_selects_css_options[ $rule_id ];
					} else {
						$rule_value = $rule['default'];
					}
					foreach ( $rule['property'] as $rule_property ) {
						$css_rules .= $rule_property . ' :' . $rule_value;
						if ( $rule['type'] == 'number' ) {
							$css_rules .= 'px';
						}
						$css_rules .= ' !important; ';
					}
				}
			}
			$css_selector = array( '.hbook-wrapper input[type="text"]', '.hbook-wrapper input[type="number"]', '.hbook-wrapper select', '.hbook-wrapper textarea' );
			$css_selector_txt = implode( ', ', $css_selector );
			$css_rules = $css_selector_txt . '{ ' . $css_rules . '} ';
			if ( isset( $inputs_selects_css_options['border_color_active'] ) ) {
				$rule_value = $inputs_selects_css_options['border_color_active'];
			} else {
				$rule_value = $inputs_selects_css_rules['border_color_active']['default'];
			}
			$css_selector = preg_replace( '/$/', ':focus', $css_selector );
			$css_selector_txt = implode( ', ', $css_selector );
			$css_rules .= $css_selector_txt . ' { border-color: ' . $rule_value . ' !important; }';
			echo( '<style type="text/css">' . $css_rules . '</style>' );
		}
	}

	public function frontend_custom_css() {
		if ( get_option( 'hb_custom_css_frontend' ) && $this->load_css() ) {
			echo( '<style type="text/css">' . wp_strip_all_tags( get_option( 'hb_custom_css_frontend' ) ) . '</style>' );
		}
	}

	public function load_css() {
		return apply_filters( 'hbook_load_css', true );
	}

	public function buttons_css_rules() {
		return array(
			'bg' => array(
				'name' => esc_html__( 'Background color:', 'hbook-admin' ),
				'type' => 'color',
				'property' => array( 'background' ),
				'default' => '#2da1ca'
			),
			'bg_hover' => array(
				'name' => esc_html__( 'Background color on hover:', 'hbook-admin' ),
				'type' => 'color',
				'property' => array( 'background' ),
				'default' => '#277895',
				'action' => 'hover'
			),
			'color' => array(
				'name' => esc_html__( 'Text color:', 'hbook-admin' ),
				'type' => 'choice',
				'property' => array( 'color' ),
				'choices' => array(
					'#fff' => esc_html__( 'White', 'hbook-admin' ),
					'#333' => esc_html__( 'Black', 'hbook-admin' ),
				),
				'default' => '#fff'
			),
			'radius' => array(
				'name' => esc_html__( 'Border radius:', 'hbook-admin' ),
				'type' => 'number',
				'property' => array( 'border-radius' ),
				'default' => '4'
			),
			'side_padding' => array(
				'name' => esc_html__( 'Side padding:', 'hbook-admin' ),
				'type' => 'number',
				'property' => array( 'padding-left', 'padding-right' ),
				'default' => '20'
			),
			'height_padding' => array(
				'name' => esc_html__( 'Height padding:', 'hbook-admin' ),
				'property' => array( 'padding-top', 'padding-bottom' ),
				'type' => 'number',
				'default' => '17'
			),
		);
	}

	public function inputs_selects_css_rules() {
		return array(
			'border_color' => array(
				'name' => esc_html__( 'Borders color:', 'hbook-admin' ),
				'type' => 'color',
				'property' => array( 'border-color' ),
				'default' => '#999999'
			),
			'border_color_active' => array(
				'name' => esc_html__( 'Borders color when active:', 'hbook-admin' ),
				'type' => 'color',
				'property' => array( 'border-color' ),
				'default' => '#277895'
			),
			'borders_width' => array(
				'name' => esc_html__( 'Borders width:', 'hbook-admin' ),
				'type' => 'number',
				'property' => array( 'border-width' ),
				'default' => '1'
			),
			'borders_radius' => array(
				'name' => esc_html__( 'Borders radius:', 'hbook-admin' ),
				'type' => 'number',
				'property' => array( 'border-radius' ),
				'default' => '4'
			),
			'height' => array(
				'name' => esc_html__( 'Height:', 'hbook-admin' ),
				'type' => 'number',
				'property' => array( 'height' ),
				'default' => '50'
			),
			'side_padding' => array(
				'name' => esc_html__( 'Side padding:', 'hbook-admin' ),
				'type' => 'number',
				'property' => array( 'padding-left', 'padding-right' ),
				'default' => '10'
			),
			'height_padding' => array(
				'name' => esc_html__( 'Height padding:', 'hbook-admin' ),
				'property' => array( 'padding-top', 'padding-bottom' ),
				'type' => 'number',
				'default' => '10'
			),
		);
	}

	public function calendar_color_css_rules() {
		return array(
			'cal-bg' => array(
				'name' => esc_html__( 'Calendar background:', 'hbook-admin' ),
				'selector' => '.hb-datepick-popup-wrapper, .hb-datepick-wrapper',
				'property' => 'background',
				'default' => '#ffffff'
			),
			'available-day-bg' => array(
				'name' => esc_html__( 'Available day background:', 'hbook-admin' ),
				'selector' => '.hb-day-available, .hb-day-taken-start, .hb-day-taken-end, .hb-avail-caption-available',
				'property' => 'background',
				'default' => '#ffffff'
			),
			'not-selectable-day-bg' => array(
				'name' => esc_html__( 'Not selectable day background:', 'hbook-admin' ),
				'selector' => '.hb-dp-day-past, .hb-dp-day-closed, .hb-dp-day-not-selectable, ' .
								'.hb-dp-day-past.hb-day-taken-start:before, .hb-dp-day-past.hb-day-taken-end:before, .hb-dp-day-past.hb-day-fully-taken,' .
								'.hb-dp-day-closed.hb-day-taken-start:before, .hb-dp-day-closed.hb-day-taken-end:before, .hb-dp-day-closed.hb-day-fully-taken',
				'property' => 'background',
				'default' => '#dddddd'
			),
			'not-selectable-day-text' => array(
				'name' => esc_html__( 'Not selectable day number:', 'hbook-admin' ),
				'selector' => '.hb-dp-day-past, .hb-dp-day-closed, .hb-dp-day-not-selectable, .hb-dp-day-no-check-in',
				'property' => 'color',
				'default' => '#888888'
			),
			'selected-day-bg' => array(
				'name' => esc_html__( 'Selected day background:', 'hbook-admin' ),
				'selector' => '.hb-dp-day-check-in, .hb-dp-day-check-out',
				'property' => 'background',
				'default' => '#ccf7cc'
			),
			'occupied-day-bg' => array(
				'name' => esc_html__( 'Occupied day background:', 'hbook-admin' ),
				'selector' => '.hb-day-taken-start:before, .hb-day-taken-end:before, .hb-day-fully-taken, .hb-avail-caption-occupied',
				'property' => 'background',
				'default' => '#f7d7dc'
			),
			'cmd-buttons-bg' => array(
				'name' => esc_html__( 'Buttons background:', 'hbook-admin' ),
				'selector' => '.hb-dp-cmd-wrapper a, .hb-dp-cmd-close',
				'property' => 'background',
				'default' => '#333333'
			),
			'cmd-buttons-bg-hover' => array(
				'name' => esc_html__( 'Buttons background on hover:', 'hbook-admin' ),
				'selector' => '.hb-dp-cmd-wrapper a:hover, .hb-dp-cmd-close:hover',
				'property' => 'background',
				'default' => '#6f6f6f'
			),
			'cmd-buttons-disabled-bg' => array(
				'name' => esc_html__( 'Disabled buttons background:', 'hbook-admin' ),
				'selector' => '.hb-dp-cmd-wrapper a.hb-dp-disabled',
				'property' => 'background',
				'default' => '#aaaaaa'
			),
			'cmd-button-arrows' => array(
				'name' => esc_html__( 'Button arrows:', 'hbook-admin' ),
				'selector' => '.hb-dp-cmd-wrapper a, .hb-dp-cmd-wrapper a:hover, .hb-dp-cmd-close, .hb-dp-cmd-close:hover',
				'property' => 'color',
				'default' => '#ffffff'
			),
			'cal-borders' => array(
				'name' => esc_html__( 'Calendar inner borders:', 'hbook-admin' ),
				'selector' => '.hb-dp-multi .hb-dp-month:not(.first), .hb-dp-month-row + .hb-dp-month-row, .hb-datepick-legend',
				'property' => 'border-color',
				'default' => '#cccccc'
			),
		);
	}

	public function can_update_resa_dates( $resa_id, $new_check_in, $new_check_out ) {
		$resa = $this->hbdb->get_resa_by_id( $resa_id );
		$new_check_in_time = strtotime( $new_check_in );
		$new_check_out_time = strtotime( $new_check_out );
		$check_in_time = strtotime( $resa['check_in'] );
		$check_out_time = strtotime( $resa['check_out'] );
		$can_update_resa = false;
		$check_availability_check_in = '';
		$check_availability_check_out = '';
		$double_check_availability = false;

		if ( $new_check_out_time <= $check_in_time || $new_check_in_time >= $check_out_time ) {
			$check_availability_check_in = $new_check_in;
			$check_availability_check_out = $new_check_out;
		} else {
			if ( $new_check_in_time >= $check_in_time ) {
				if ( $new_check_out_time <= $check_out_time ) {
					$can_update_resa = true;
				} else {
					$check_availability_check_in = $resa['check_out'];
					$check_availability_check_out = $new_check_out;
				}
			} else {
				$check_availability_check_in = $new_check_in;
				$check_availability_check_out = $resa['check_in'];
				if ( $new_check_out_time > $check_out_time ) {
					$double_check_availability = true;
				}
			}
		}

		if ( $check_availability_check_in ) {
			if ( $resa['accom_num'] ) {
				if ( $this->hbdb->is_available_accom_num( $resa['accom_id'], $resa['accom_num'], $check_availability_check_in, $check_availability_check_out ) ) {
					$can_update_resa = true;
				}
			} else {
				if ( $this->hbdb->is_available_accom( $resa['accom_id'], $check_availability_check_in, $check_availability_check_out ) ) {
					$can_update_resa = true;
				}
			}
		}

		if ( $double_check_availability ) {
			$check_availability_check_in = $resa['check_out'];
			$check_availability_check_out = $new_check_out;
			if ( $resa['accom_num'] ) {
				if ( ! $this->hbdb->is_available_accom_num( $resa['accom_id'], $resa['accom_num'], $check_availability_check_in, $check_availability_check_out ) ) {
					$can_update_resa = false;
				}
			} else {
				if ( ! $this->hbdb->is_available_accom( $resa['accom_id'], $check_availability_check_in, $check_availability_check_out ) ) {
					$can_update_resa = false;
				}
			}
		}

		return $can_update_resa;
	}

	public function get_search_form_txt() {
		return array(
			'default_form_title' => esc_html__( 'Default form title', 'hbook-admin' ),
			'accom_page_form_title' => esc_html__( 'Form title on accommodation page', 'hbook-admin' ),
			'check_in' => esc_html__( 'Check-in date', 'hbook-admin' ),
			'check_out' => esc_html__( 'Check-out date', 'hbook-admin' ),
			'adults' => esc_html__( 'Adults number', 'hbook-admin' ),
			'children' => esc_html__( 'Children number', 'hbook-admin' ),
			'chosen_check_in' => esc_html__( 'Chosen check-in date', 'hbook-admin' ),
			'chosen_check_out' => esc_html__( 'Chosen check-out date', 'hbook-admin' ),
			'chosen_adults' => esc_html__( 'Chosen adults number', 'hbook-admin' ),
			'chosen_children' => esc_html__( 'Chosen children number', 'hbook-admin' ),
			'search_button' => esc_html__( 'Search button', 'hbook-admin' ),
			'change_search_button' => esc_html__( 'Change search button', 'hbook-admin' ),
		);
	}

	public function get_accom_selection_txt() {
		return array(
			'one_type_of_accommodation_found' => esc_html__( 'One type of accommodation found', 'hbook-admin' ),
			'several_types_of_accommodation_found' => esc_html__( 'Several types of accommodation found', 'hbook-admin' ),
			'select_accom_title' => esc_html__( 'Accommodation selection title', 'hbook-admin' ),
			'accom_available_at_chosen_dates' => esc_html__( 'The accommodation is available at the chosen dates', 'hbook-admin' ),
			'price_for_1_night' => esc_html__( 'Price for 1 night', 'hbook-admin' ),
			'price_for_several_nights' => esc_html__( 'Price for several nights', 'hbook-admin' ),
			'view_price_breakdown' => esc_html__( 'View price breakdown link', 'hbook-admin' ),
			'hide_price_breakdown' => esc_html__( 'Hide price breakdown link', 'hbook-admin' ),
			'price_breakdown_nights_several' => esc_html__( 'Nights (several - in price breakdown)', 'hbook-admin' ),
			'price_breakdown_night_one' => esc_html__( 'Night (one - in price breakdown)', 'hbook-admin' ),
			'price_breakdown_multiple_nights' => esc_html__( 'Multiple nights (in price breakdown)', 'hbook-admin' ),
			'price_breakdown_accom_price' => esc_html__( 'Accommodation price (in price breakdown)', 'hbook-admin' ),
			'price_breakdown_extra_adults_several' => esc_html__( 'Extra adults (several - in price breakdown)', 'hbook-admin' ),
			'price_breakdown_extra_adult_one' => esc_html__( 'Extra adult (one - in price breakdown)', 'hbook-admin' ),
			'price_breakdown_adults_several' => esc_html__( 'Adults (several - in price breakdown)', 'hbook-admin' ),
			'price_breakdown_adult_one' => esc_html__( 'Adult (one - in price breakdown)', 'hbook-admin' ),
			'price_breakdown_extra_children_several' => esc_html__( 'Extra children (several - in price breakdown)', 'hbook-admin' ),
			'price_breakdown_extra_child_one' => esc_html__( 'Extra child (one - in price breakdown)', 'hbook-admin' ),
			'price_breakdown_children_several' => esc_html__( 'Children (several - in price breakdown)', 'hbook-admin' ),
			'price_breakdown_child_one' => esc_html__( 'Child (one - in price breakdown)', 'hbook-admin' ),
			'price_breakdown_dates' => esc_html__( 'Dates (in price breakdown)', 'hbook-admin' ),
			'price_breakdown_discount' => esc_html__( 'Discount (in price breakdown)', 'hbook-admin' ),
			'price_breakdown_before_discount' => esc_html__( 'Price before discount (in price breakdown)', 'hbook-admin' ),
			'price_breakdown_after_discount' => esc_html__( 'Price after discount (in price breakdown)', 'hbook-admin' ),
			'fee_details_adults_several' => esc_html__( 'Adults (several - in fee details)', 'hbook-admin' ),
			'fee_details_adult_one' => esc_html__( 'Adult (one - in fee details)', 'hbook-admin' ),
			'fee_details_children_several' => esc_html__( 'Children (several - in fee details)', 'hbook-admin' ),
			'fee_details_child_one' => esc_html__( 'Child (one - in fee details)', 'hbook-admin' ),
			'fee_details_persons' => esc_html__( 'Persons (in fee details)', 'hbook-admin' ),
			'select_accom_button' => esc_html__( 'Select accommodation button', 'hbook-admin' ),
			'accom_book_now_button' => esc_html__( 'Book now button', 'hbook-admin' ),
			'view_accom_button' => esc_html__( 'View accommodation button', 'hbook-admin' ),
			'selected_accom' => esc_html__( 'Selected accommodation', 'hbook-admin' ),
			'price_breakdown_fees' => esc_html__( 'Fees (in price breakdown)', 'hbook-admin' ),
		);
	}

	public function get_options_selection_txt() {
		return array(
			'select_options_title' => esc_html__( 'Extra services selection title', 'hbook-admin' ),
			'chosen_options' => esc_html__( 'Chosen extra services title', 'hbook-admin' ),
			'price_option' => esc_html__( 'Extra price and maximum', 'hbook-admin' ),
			'free_option' => esc_html__( 'Free extra', 'hbook-admin' ),
			'each_option' => esc_html__( 'Each (in extra price and maximum)', 'hbook-admin' ),
			'max_option' => esc_html__( 'Maximum (in extra price and maximum)', 'hbook-admin' ),
			'total_options_price' => esc_html__( 'Total extra services price', 'hbook-admin' ),
		);
	}

	public function get_coupons_txt() {
		return array(
			'coupons_section_title' => esc_html__( 'Title', 'hbook-admin' ),
			'coupons_text' => esc_html__( 'Message', 'hbook-admin' ),
			'coupons_button' => esc_html__( 'Apply coupon button', 'hbook-admin' ),
			'valid_coupon' => esc_html__( 'Valid coupon message', 'hbook-admin' ),
			'invalid_coupon' => esc_html__( 'Invalid coupon message', 'hbook-admin' ),
			'no_coupon' => esc_html__( 'No coupon message', 'hbook-admin' ),
		);
	}

	public function get_summary_txt() {
		return array(
			'summary_title' => esc_html__( 'Title', 'hbook-admin' ),
			'number_of_nights' => esc_html__( 'Number of nights', 'hbook-admin' ),
			'summary_change' => esc_html__( 'Change', 'hbook-admin' ),
			'thanks_message_1' => esc_html__( 'Thanks message (1)', 'hbook-admin' ),
			'thanks_message_2' => esc_html__( 'Thanks message (2)', 'hbook-admin' ),
			'summary_accommodation' => esc_html__( 'Accommodation', 'hbook-admin' ),
			'summary_accom_price' => esc_html__( 'Accommodation price', 'hbook-admin' ),
			'summary_options_price' => esc_html__( 'Options price', 'hbook-admin' ),
			'summary_coupon_amount' => esc_html__( 'Coupon discount amount', 'hbook-admin' ),
			'summary_price' => esc_html__( 'Total price', 'hbook-admin' ),
			'summary_deposit' => esc_html__( 'Deposit', 'hbook-admin' ),
			'summary_security_bond' => esc_html__( 'Security bond', 'hbook-admin' ),
			'summary_security_bond_explanation' => esc_html__( 'Security bond explanation', 'hbook-admin' ),
			'thanks_message_payment_done_1' => esc_html__( 'Thanks message - payment done (1)', 'hbook-admin' ),
			'thanks_message_payment_done_2' => esc_html__( 'Thanks message - payment done (2)', 'hbook-admin' ),
		);
	}

	public function get_payment_type_choice() {
		return array(
			'payment_section_title' => esc_html__( 'Payment section title', 'hbook-admin' ),
			'payment_type' => esc_html__( 'Select payment type', 'hbook-admin' ),
			'payment_type_offline' => esc_html__( 'Payment type offline', 'hbook-admin' ),
			'payment_type_store_credit_card' => esc_html__( 'Payment type store credit card', 'hbook-admin' ),
			'payment_type_deposit' => esc_html__( 'Payment type deposit', 'hbook-admin' ),
			'payment_type_full' => esc_html__( 'Payment type full', 'hbook-admin' ),
			'payment_type_explanation_offline' => esc_html__( 'Explanation text for offline payment', 'hbook-admin' ),
			'payment_type_explanation_store_credit_card' => esc_html__( 'Explanation text for stored credit card', 'hbook-admin' ),
			'payment_type_explanation_deposit' => esc_html__( 'Explanation text for deposit payment', 'hbook-admin' ),
			'payment_type_explanation_full' => esc_html__( 'Explanation text for full payment', 'hbook-admin' ),
			'payment_method' => esc_html__( 'Select payment method', 'hbook-admin' ),
		);
	}

	public function get_stripe_txt() {
		return array(
			'stripe_payment_method_label' => esc_html__( 'Payment method label', 'hbook-admin' ),
			'stripe_text_before_form' => esc_html__( 'Text before form', 'hbook-admin' ),
			'stripe_card_number' => esc_html__( 'Card number', 'hbook-admin' ),
			'stripe_expiration' => esc_html__( 'Expiration date', 'hbook-admin' ),
			'stripe_cvc' => esc_html__( 'CVC', 'hbook-admin' ),
			'stripe_invalid_card_number' => esc_html__( 'Invalid card number', 'hbook-admin' ),
			'stripe_invalid_expiration' => esc_html__( 'Invalid expiration date', 'hbook-admin' ),
			'stripe_invalid_card' => esc_html__( 'Invalid card', 'hbook-admin' ),
			'stripe_processing_error' => esc_html__( 'Processing error', 'hbook-admin' ),
			'stripe_text_bottom_form' => esc_html__( 'Text at the bottom of the form', 'hbook-admin' ),
		);
	}

	public function get_paypal_txt() {
		return array(
			'paypal_payment_method_label' => esc_html__( 'Payment method label', 'hbook-admin' ),
			'paypal_text_before_form' => esc_html__( 'Explanation text', 'hbook-admin' ),
			'paypal_bottom_text_line_1' => esc_html__( 'Bottom text line 1', 'hbook-admin' ),
			'paypal_bottom_text_line_2' => esc_html__( 'Bottom text line 2', 'hbook-admin' ),
		);
	}

	public function get_external_payment_desc_txt() {
		return array(
			'external_payment_txt_desc' => 'Description',
			'external_payment_txt_deposit' => '%deposit_txt',
			'external_payment_txt_one_night' => '%nights_txt (one)',
			'external_payment_txt_several_nights' => '%nights_txt (several)',
			'external_payment_txt_one_adult' => '%adults_txt (one)',
			'external_payment_txt_several_adults' => '%adults_txt (several)',
			'external_payment_txt_one_child' => '%children_txt (one)',
			'external_payment_txt_several_children' => '%children_txt (several)',
		);
	}

	public function get_search_form_msg() {
		return array(
			'searching' => esc_html__( 'Searching', 'hbook-admin' ),
			'no_check_in_date' => esc_html__( 'No check-in date', 'hbook-admin' ),
			'no_check_out_date' => esc_html__( 'No check-out date', 'hbook-admin' ),
			'no_check_in_out_date' => esc_html__( 'No check-in date and no check-out date', 'hbook-admin' ),
			'no_adults' => esc_html__( 'No adults number', 'hbook-admin' ),
			'no_children' => esc_html__( 'No children number', 'hbook-admin' ),
			'no_adults_children' => esc_html__( 'No adults and children number', 'hbook-admin' ),
			'invalid_check_in_date' => esc_html__( 'Invalid check-in date', 'hbook-admin' ),
			'invalid_check_out_date' => esc_html__( 'Invalid check-out date', 'hbook-admin' ),
			'invalid_check_in_out_date' => esc_html__( 'Invalid check-in date and invalid check-out date', 'hbook-admin' ),
			'check_in_date_past' => esc_html__( 'Check-in date in the past', 'hbook-admin' ),
			'check_in_date_before_date' => esc_html__( 'Check-in date before specific date', 'hbook-admin' ),
			'check_out_date_after_date' => esc_html__( 'Check-out date after specific date', 'hbook-admin' ),
			'check_out_before_check_in' => esc_html__( 'Check-out date before check-in date', 'hbook-admin' ),
			'check_in_day_not_allowed' => esc_html__( 'Check-in date on a not allowed day', 'hbook-admin' ),
			'check_in_day_not_allowed_seasonal' => esc_html__( 'Check-in date on a not allowed day (seasonal)', 'hbook-admin' ),
			'check_out_day_not_allowed' => esc_html__( 'Check-out date on a not allowed day', 'hbook-admin' ),
			'check_out_day_not_allowed_seasonal' => esc_html__( 'Check-out date on a not allowed day (seasonal)', 'hbook-admin' ),
			'minimum_stay' => esc_html__( 'Minimum stay policy', 'hbook-admin' ),
			'minimum_stay_seasonal' => esc_html__( 'Minimum stay policy (seasonal)', 'hbook-admin' ),
			'maximum_stay' => esc_html__( 'Maximum stay policy', 'hbook-admin' ),
			'maximum_stay_seasonal' => esc_html__( 'Maximum stay policy (seasonal)', 'hbook-admin' ),
			'check_out_day_not_allowed_for_check_in_day' => esc_html__( 'Check-out date on a not allowed day for specific check-in day (conditional rule)', 'hbook-admin' ),
			'check_out_day_not_allowed_for_check_in_day_seasonal' => esc_html__( 'Check-out date on a not allowed day for specific check-in day (conditional rule - seasonal)', 'hbook-admin' ),
			'minimum_stay_for_check_in_day' => esc_html__( 'Minimum stay for specific check-in day (conditional rule)', 'hbook-admin' ),
			'minimum_stay_for_check_in_day_seasonal' => esc_html__( 'Minimum stay for specific check-in day (conditional rule - seasonal)', 'hbook-admin' ),
			'maximum_stay_for_check_in_day' => esc_html__( 'Maximum stay for specific check-in day (conditional rule)', 'hbook-admin' ),
			'maximum_stay_for_check_in_day_seasonal' => esc_html__( 'Maximum stay for specific check-in day (conditional rule - seasonal)', 'hbook-admin' ),
			'accom_can_not_suit_nb_people' => esc_html__( 'The accommodation can not suit the number of people', 'hbook-admin' ),
			'no_accom_can_suit_nb_people' => esc_html__( 'No accommodation can suit the number of people', 'hbook-admin' ),
			'view_accom_for_persons' => esc_html__( 'Link to all accommodation which suit the number of people', 'hbook-admin' ),
			'accom_can_not_suit_one_person' => esc_html__( 'The accommodation can not suit one person', 'hbook-admin' ),
			'no_accom_can_suit_one_person' => esc_html__( 'No accommodation can suit one person', 'hbook-admin' ),
			'view_accom_for_one_person' => esc_html__( 'Link to all accommodation which suit one person', 'hbook-admin' ),
			'no_accom_at_chosen_dates' => esc_html__( 'No accommodation available at the chosen dates', 'hbook-admin' ),
			'accom_not_available_at_chosen_dates' => esc_html__( 'The accommodation is not available at the chosen dates', 'hbook-admin' ),
			'view_accom_at_chosen_date' => esc_html__( 'Link to all accommodation available at the chosen dates', 'hbook-admin' ),
		);
	}

	public function get_book_now_area_txt() {
		return array(
			'terms_and_cond_title' => esc_html__( 'Policies title', 'hbook-admin' ),
			'terms_and_cond_text' => esc_html__( 'Terms and conditions text', 'hbook-admin' ),
			'terms_and_cond_error' => esc_html__( 'Terms and conditions error', 'hbook-admin' ),
			'privacy_policy_text' => esc_html__( 'Privacy policy text', 'hbook-admin' ),
			'privacy_policy_error' => esc_html__( 'Privacy policy error', 'hbook-admin' ),
			'txt_before_book_now_button' => esc_html__( 'Text before "Book now" button', 'hbook-admin' ),
			'book_now_button' => esc_html__( '"Book now" button', 'hbook-admin' ),
		);
	}

	public function get_details_form_msg() {
		return array(
			'accom_no_longer_available' => esc_html__( 'Selected accommodation no longer available', 'hbook-admin' ),
			'processing' => esc_html__( 'Processing', 'hbook-admin' ),
		);
	}

	public function get_error_form_msg() {
		return array(
			'required_field' => esc_html__( 'Required field', 'hbook-admin' ),
			'invalid_email' => esc_html__( 'Invalid email', 'hbook-admin' ),
			'invalid_number' => esc_html__( 'Invalid number', 'hbook-admin' ),
			'connection_error' => esc_html__( 'Connection error', 'hbook-admin' ),
			'timeout_error' => esc_html__( 'Timeout error', 'hbook-admin' ),
			'error_season_not_defined' => esc_html__( 'Season not defined error', 'hbook-admin' ),
			'error_rate_not_defined' => esc_html__( 'Rate not defined error', 'hbook-admin' ),
		);
	}

	public function get_cal_legend_txt() {
		return array(
			'legend_occupied' => esc_html__( 'Occupied', 'hbook-admin' ),

			'legend_past' => esc_html__( 'Past', 'hbook-admin' ),
			'legend_closed' => esc_html__( 'Closed', 'hbook-admin' ),
			'legend_available' => esc_html__( 'Available', 'hbook-admin' ),
			'legend_before_check_in' => esc_html__( 'Before check-in day', 'hbook-admin' ),
			'legend_no_check_in' => esc_html__( 'Not available for check-in', 'hbook-admin' ),
			'legend_no_check_out' => esc_html__( 'Not available for check-out', 'hbook-admin' ),
			'legend_check_in_only' => esc_html__( 'Available for check-in only', 'hbook-admin' ),
			'legend_check_out_only' => esc_html__( 'Available for check-out only', 'hbook-admin' ),
			'legend_no_check_out_min_stay' => esc_html__( 'Not available for check-out (due to minimum-stay requirement)', 'hbook-admin' ),
			'legend_no_check_out_max_stay' => esc_html__( 'Not available for check-out (due to maximum-stay requirement)', 'hbook-admin' ),
			'legend_check_in' => esc_html__( 'Chosen check-in day', 'hbook-admin' ),
			'legend_check_out' => esc_html__( 'Chosen check-out day', 'hbook-admin' ),
			'legend_select_check_in' => esc_html__( 'Select a check-in date', 'hbook-admin'),
			'legend_select_check_out' => esc_html__( 'Select a check-out date', 'hbook-admin'),
		);
	}

	public function get_rates_table_txt() {
		return array(
			'table_rates_season' => esc_html__( 'Season', 'hbook-admin' ),
			'table_rates_from' => esc_html__( 'From', 'hbook-admin' ),
			'table_rates_to' => esc_html__( 'To', 'hbook-admin' ),
			'table_rates_nights' => esc_html__( 'Nights', 'hbook-admin' ),
			'table_rates_price' => esc_html__( 'Price', 'hbook-admin' ),
			'table_rates_per_night' => esc_html__( 'Per night', 'hbook-admin' ),
			'table_rates_all_nights' => esc_html__( 'All nights', 'hbook-admin' ),
			'table_rates_for_night_stay' => esc_html__( 'For x-night stay', 'hbook-admin' ),
		);
	}

	public function get_accom_list_txt() {
		return array(
			'accom_starting_price' => esc_html__( 'Price starting at', 'hbook-admin' ),
			'accom_starting_price_duration_unit' => esc_html__( 'Starting price duration unit', 'hbook-admin' ),
		);
	}

	public function get_txt_variables() {
		return array(
			'accom_available_at_chosen_dates' => array( '%accom_name' ),
			'accom_can_not_suit_nb_people' => array( '%accom_name', '%persons_nb' ),
			'accom_can_not_suit_one_person' => array( '%accom_name' ),
			'accom_not_available_at_chosen_dates' => array( '%accom_name' ),
			'accom_page_form_title' => array( '%accom_name' ),
			'accom_starting_price' => array( '%price' ),
			'check_in_date_before_date' => array( '%date' ),
			'check_out_date_after_date' => array( '%date' ),
			'no_accom_can_suit_nb_people' => array( '%persons_nb' ),
			'external_payment_txt_desc' => array( '%accom_name', '%deposit_txt', '%nights_txt', '%check_in_date', '%check_out_date', '%adults_txt', '%children_txt' ),
			'external_payment_txt_several_adults' => array( '%nb_adults' ),
			'external_payment_txt_several_children' => array( '%nb_children' ),
			'external_payment_txt_several_nights' => array( '%nb_nights'),
			'price_breakdown_adults_several' => array( '%nb_adults' ),
			'price_breakdown_children_several' => array( '%nb_children' ),
			'price_breakdown_dates' => array( '%from_date', '%to_date' ),
			'price_breakdown_extra_adults_several' => array( '%nb_adults' ),
			'price_breakdown_extra_children_several' => array( '%nb_children' ),
			'price_breakdown_multiple_nights' => array( '%nb_nights' ),
			'price_for_several_nights' => array( '%nb_nights' ),
			'selected_accom' => array( '%accom_name' ),
			'several_types_of_accommodation_found' => array( '%nb_types' ),
			'thanks_message_1' => array( '%customer_email' ),
			'view_accom_for_persons' => array( '%persons_nb' ),
			'check_in_day_not_allowed' => array( '%check_in_days' ),
			'check_out_day_not_allowed' => array( '%check_out_days' ),
			'minimum_stay' => array( '%nb_nights' ),
			'maximum_stay' => array( '%nb_nights' ),
			'check_out_day_not_allowed_for_check_in_day' => array( '%check_in_day', '%check_out_days' ),
			'minimum_stay_for_check_in_day' => array( '%nb_nights', '%check_in_day' ),
			'maximum_stay_for_check_in_day' => array( '%nb_nights', '%check_in_day' ),
			'table_rates_for_night_stay' => array( '%nb_nights' ),
			'price_option' => array( '%price', '%each', '%max' ),
			'free_option' => array( '%max' ),
			'max_option' => array( '%max_value' ),
			'legend_no_check_in_min_stay' => array( '%nb_nights' ),
			'legend_no_check_out_min_stay' => array( '%nb_nights' ),
			'legend_no_check_out_max_stay' => array( '%nb_nights' ),
			'error_season_not_defined' => array( '%night' ),
			'error_rate_not_defined' => array( '%accom_name', '%season_name' ),
			'stripe_processing_error' => array( '%error_msg' ),
			'valid_coupon' => array( '%amount' ),
			'payment_type_explanation_offline' => array( '%full_amount', '%deposit_amount', '%full_minus_deposit_amount' ),
			'payment_type_explanation_store_credit_card' => array( '%full_amount', '%deposit_amount', '%full_minus_deposit_amount' ),
			'payment_type_explanation_deposit' => array( '%full_amount', '%deposit_amount', '%full_minus_deposit_amount' ),
			'payment_type_explanation_full' => array( '%full_amount' ),
		);
	}

	public function get_string_list() {
		return array_merge(
			$this->get_search_form_txt(),
			$this->get_search_form_msg(),
			$this->get_accom_selection_txt(),
			$this->get_options_selection_txt(),
			$this->hbdb->get_fee_names(),
			$this->hbdb->get_option_names(),
			$this->hbdb->get_form_labels( 'booking' ),
			$this->get_book_now_area_txt(),
			$this->get_details_form_msg(),
			$this->get_coupons_txt(),
			$this->get_summary_txt(),
			$this->get_payment_type_choice(),
			$this->get_paypal_txt(),
			$this->get_external_payment_desc_txt(),
			$this->get_stripe_txt(),
			$this->get_error_form_msg(),
			$this->get_cal_legend_txt(),
			$this->get_rates_table_txt(),
			$this->hbdb->get_season_names(),
			$this->get_accom_list_txt()
		);
	}

	public function export_lang_file() {
		if ( isset( $_POST['hb-import-export-action'] ) && ( $_POST['hb-import-export-action'] == 'export-lang' ) && wp_verify_nonce( $_POST['hb_import_export'], 'hb_import_export' ) && current_user_can( 'manage_options' ) ) {
			header( 'Content-Description: File Transfer' );
			header( 'Content-Disposition: attachment; filename=hbook-' . $_POST['hb-locale-export'] . '.txt' );
			header( 'Content-Type: text; charset=' . get_option( 'blog_charset' ) );
			$strings = $this->get_string_list();
			$strings_value = $this->hbdb->get_all_strings();
			foreach ( $strings as $string_id => $string_desc ) {
				if ( isset( $strings_value[ $string_id ]['en_US'] ) ) {
					echo( 'msgctxt "' . $strings_value[ $string_id ]['en_US'] . '"' . "\n" );
				}
				echo( 'msgid "' . $string_id . '"' . "\n" );
				if ( isset( $strings_value[ $string_id ][ $_POST['hb-locale-export'] ] ) ) {
					echo( 'msgstr "' . $strings_value[ $string_id ][ $_POST['hb-locale-export'] ] . '"' . "\n" );
				} else {
					echo( 'msgstr ""' . "\n" );
				}
				echo( "\n" );
			}
			die;
		}
	}

	public function export_resa() {

		if (
			isset( $_POST['hb-import-export-action'] ) &&
			( $_POST['hb-import-export-action'] == 'export-resa' ) &&
			wp_verify_nonce( $_POST['hb_import_export'], 'hb_import_export' ) &&
			( current_user_can( 'manage_options' ) || current_user_can( 'manage_resa' ) )
		) {
			header( 'Content-Description: File Transfer' );
			header( 'Content-Disposition: attachment; filename=hbook-reservations.csv' );
			header( 'Content-Type: text; charset=' . get_option( 'blog_charset' ) );
			echo( chr(0xEF) . chr(0xBB) . chr(0xBF) );

			$data_to_export = array_merge( $this->get_exportable_resa_fields(), $this->get_exportable_additional_info_fields(), $this->get_exportable_extra_services_fields(), $this->get_exportable_customer_fields() );
			$data_to_export_ids = $_POST['hb-resa-data-export'];
			$data_to_export_name = array();

			foreach ( $data_to_export_ids as $data_id ) {
				$data_to_export_name[] = $data_to_export[ $data_id ];
			}
			$header = implode( '","', $data_to_export_name );
			$header = '"' . $header . '"';
			echo( $header . "\n" );

			$accom = $this->hbdb->get_all_accom();
			$accom_tmp = array();
			foreach( $accom as $accom_id => $accom_name ) {
				$accom_num_name = $this->hbdb->get_accom_num_name( $accom_id );
				$accom_tmp[ $accom_id ] = array(
					'name' => $accom_name,
					'num_name' => $accom_num_name
				);
			}
			$accom = $accom_tmp;

			$extras = $this->hbdb->get_all( 'options' );
			$tmp_extras = array();
			foreach ( $extras as $ex ) {
				$tmp_extras[ $ex['id'] ] = $ex;
			}
			$extras = $tmp_extras;

			$extra_choices = $this->hbdb->get_all( 'options_choices' );
			$extra_name = array();
			foreach ( $extra_choices as $choice ) {
				$extra_name[ $choice['id'] ] = $choice['name'];
			}

			if ( $_POST['hb-export-resa-selection'] == 'all' ) {
				$resa = $this->hbdb->get_all_resa_by_date();
			} else {
				if ( $_POST['hb-export-resa-selection'] == 'received-date' ) {
					$from_date = $_POST['hb-export-resa-selection-received-date-from'];
					$to_date = $_POST['hb-export-resa-selection-received-date-to'];
					$date_type = 'received_on';
				} else if ( $_POST['hb-export-resa-selection'] == 'check-in-date' ) {
					$from_date = $_POST['hb-export-resa-selection-check-in-date-from'];
					$to_date = $_POST['hb-export-resa-selection-check-in-date-to'];
					$date_type = 'check_in';
				} else if ( $_POST['hb-export-resa-selection'] == 'check-out-date' ) {
					$from_date = $_POST['hb-export-resa-selection-check-out-date-from'];
					$to_date = $_POST['hb-export-resa-selection-check-out-date-to'];
					$date_type = 'check_out';
				}
				if ( ! $from_date ) {
					$from_date = '2000-01-01';
				}
				if ( ! $to_date ) {
					$to_date = '2100-01-01';
				} else {
					$to_date .= ' 23:59:59';
				}
				$resa = $this->hbdb->get_resa_between_dates( $date_type, $from_date, $to_date );
			}

			foreach ( $resa as $resa_key => $resa_data ) {
				$resa[ $resa_key ]['resa_id'] = $resa_data['id'];

				if ( isset( $accom[ $resa_data['accom_id'] ] ) ) {
					$resa[ $resa_key ]['accom_type'] = $accom[ $resa_data['accom_id'] ]['name'];
					if ( isset( $accom[ $resa_data['accom_id'] ]['num_name'][ $resa_data['accom_num'] ] ) ) {
						$resa[ $resa_key ]['accom_num'] = $accom[ $resa_data['accom_id'] ]['num_name'][ $resa_data['accom_num'] ];
					} else {
						$resa[ $resa_key ]['accom_num'] = '';
					}
				} else {
					$resa[ $resa_key ]['accom_type'] = '';
				}

				$customer_info = array();
				$customer = $this->hbdb->get_single( 'customers', $resa[ $resa_key ]['customer_id'] );
				if ( $customer ) {
					$customer_info = array(
						'customer_id' => $customer['id']
					);
					$customer_info_json = json_decode( $customer['info'], true );
					if ( is_array( $customer_info_json ) ) {
						foreach ( $customer_info_json as $info_id => $info_value ) {
							$customer_info[ $info_id ] = $info_value;
						}
					}
				}

				$optional_info = array();
				if ( isset( $resa_data['optional_info'] ) ) {
					$optional_info_json = json_decode( $resa_data['optional_info'], true );
					if ( is_array( $optional_info_json ) ) {
						foreach ( $optional_info_json as $op ) {
							$optional_info[ $op['info_id'] ] = $op['info_value'];
						}
					}
				}

				$resa_extra_services = array();
				if ( $resa_data['options'] ) {
					$resa_extra_services = json_decode( $resa_data['options'], true );
				}
				$extra_services = array();
				if ( is_array( $resa_extra_services ) ) {
					foreach ( $resa_extra_services as $resa_extra_id => $resa_extra ) {
						if ( isset( $extras[ $resa_extra_id ] ) ) {
							if (
								$extras[ $resa_extra_id ]['apply_to_type'] == 'quantity' ||
								$extras[ $resa_extra_id ]['apply_to_type'] == 'quantity-per-day'
							) {
								$extra_services[ 'extra_' . $resa_extra_id ] = $resa_extra;
							} else if ( $extras[ $resa_extra_id ]['choice_type'] == 'single' ) {
								$extra_services[ 'extra_' . $resa_extra_id ] = 'X';
							} else if (
								$extras[ $resa_extra_id ]['choice_type'] == 'multiple'  &&
								isset( $extra_name[ $resa_extra ] )
							) {
								$extra_services[ 'extra_' . $resa_extra_id ] = $extra_name[ $resa_extra ];
							}
						}
					}
				}

				$resa_additional_info = array();
				if ( $resa_data['additional_info'] ) {
					$resa_additional_info = json_decode( $resa_data['additional_info'], true );
				}
				$additional_info = array();
				if ( is_array( $resa_additional_info ) ) {
					$additional_info = $resa_additional_info;
				}

				$resa[ $resa_key ] = array_merge( $resa[ $resa_key ], $extra_services, $optional_info, $customer_info, $additional_info );
			}

			foreach ( $resa as $resa_data ) {
				$row = array();
				foreach ( $data_to_export_ids as $data_id ) {
					if ( isset( $resa_data[ $data_id ] ) ) {
						$row[] = $resa_data[ $data_id ];
					} else {
						$row[] = '';
					}
				}
				$row = implode( '","', $row );
				$row = '"' . $row . '"' . "\n";
				echo( $row );
			}

			die;
		}
	}

	public function export_customers() {
		if (
			isset( $_POST['hb-import-export-action'] ) &&
			( $_POST['hb-import-export-action'] == 'export-customers' ) &&
			wp_verify_nonce( $_POST['hb_import_export'], 'hb_import_export' ) &&
			current_user_can( 'manage_options' )
		) {
			header( 'Content-Description: File Transfer' );
			header( 'Content-Disposition: attachment; filename=hbook-customers.csv' );
			header( 'Content-Type: text; charset=' . get_option( 'blog_charset' ) );
			echo( chr(0xEF) . chr(0xBB) . chr(0xBF) );

			$data_to_export = $this->get_exportable_customer_fields( 'customers' );
			$data_to_export_ids = $_POST['hb-customers-data-export'];
			$data_to_export_name = array();

			foreach ( $data_to_export_ids as $data_id ) {
				$data_to_export_name[] = $data_to_export[ $data_id ];
			}
			$header = implode( '","', $data_to_export_name );
			$header = '"' . $header . '"';
			echo( $header . "\n" );

			$customers = $this->hbdb->get_all( 'customers' );
			foreach ( $customers as $customer ) {
				$customer_info = array(
					'id' => $customer['id']
				);
				$customer_info_json = json_decode( $customer['info'], true );
				if ( is_array( $customer_info_json ) ) {
					foreach ( $customer_info_json as $info_id => $info_value ) {
						$customer_info[ $info_id ] = $info_value;
					}
				}

				$row = array();
				foreach ( $data_to_export_ids as $data_id ) {
					if ( isset( $customer_info[ $data_id ] ) ) {
						$row[] = $customer_info[ $data_id ];
					} else {
						$row[] = '';
					}
				}
				$row = implode( '","', $row );
				$row = '"' . $row . '"' . "\n";
				echo( $row );
			}
			die;
		}
	}

	public function get_exportable_resa_fields() {
		return array(
			'resa_id' => esc_html__( 'Num', 'hbook-admin' ),
			'check_in' => esc_html__( 'Check-in', 'hbook-admin' ),
			'check_out' => esc_html__( 'Check-out', 'hbook-admin' ),
			'accom_type' => esc_html__( 'Accommodation type', 'hbook-admin' ),
			'accom_num' => esc_html__( 'Accommodation number', 'hbook-admin' ),
			'adults' => esc_html__( 'Adults', 'hbook-admin' ),
			'children' => esc_html__( 'Children', 'hbook-admin' ),
			'price' => esc_html__( 'Price', 'hbook-admin' ),
			'paid' => esc_html__( 'Amount paid', 'hbook-admin'),
			'currency' => esc_html__( 'Currency', 'hbook-admin'),
			'status' => esc_html__( 'Status', 'hbook-admin'),
			'admin_comment' => esc_html__( 'Comment', 'hbook-admin'),
			'received_on' => esc_html__( 'Received on', 'hbook-admin'),
		);
	}

	public function get_exportable_additional_info_fields() {
		$exportable_fields = array();
		$fields = $this->hbdb->get_additional_booking_info_form_fields();
		foreach ( $fields as $field ) {
			$exportable_fields[ $field['id'] ] = $field['name'];
		}
		return $exportable_fields;
	}

	public function get_exportable_customer_fields( $for = 'resa' ) {
		if ( $for == 'resa' ) {
			$exportable_fields = array(
				'customer_id' => esc_html__( 'Id', 'hbook-admin' )
			);
		} else {
			$exportable_fields = array(
				'id' => esc_html__( 'Id', 'hbook-admin' )
			);
		}
		$fields = $this->hbdb->get_customer_form_fields();
		foreach ( $fields as $field ) {
			$exportable_fields[ $field['id'] ] = $field['name'];
		}
		return $exportable_fields;
	}

	public function get_exportable_extra_services_fields() {
		$extras = $this->hbdb->get_all( 'options' );
		$exportable_extra = array();
		foreach ( $extras as $extra ) {
			$exportable_extra[ 'extra_' . $extra['id'] ] = $extra['name'];
		}
		return $exportable_extra;
	}

	public function get_posted_customer_info() {
		$customer_info = array();
		$customer_fields = $this->hbdb->get_customer_form_fields();
		foreach ( $customer_fields as $field ) {
			if ( $field['type'] == 'checkbox' ) {
				if ( isset( $_POST[ 'hb_' . $field['id'] ] ) ) {
					$info_value = implode( ', ', $_POST[ 'hb_' . $field['id'] ] );
				} else {
					$info_value = '';
				}
			} else {
				$info_value = $_POST[ 'hb_' . $field['id'] ];
			}
			$info_value = stripslashes( strip_tags( $info_value ) );
			if ( $info_value != '' ) {
				$customer_info[ $field['id'] ] = $info_value;
			}
		}
		return $customer_info;
	}

	public function get_posted_additional_booking_info() {
		$additional_info = array();
		$additional_fields = $this->hbdb->get_additional_booking_info_form_fields();
		foreach ( $additional_fields as $field ) {
			if ( isset( $_POST[ 'hb_' . $field['id'] ] ) ) {
				if ( $field['type'] == 'checkbox' ) {
					$info_value = implode( ', ', $_POST[ 'hb_' . $field['id'] ] );
				} else {
					$info_value = $_POST[ 'hb_' . $field['id'] ];
				}
			} else {
				$info_value = '';
			}
			$info_value = stripslashes( strip_tags( $info_value ) );
			if ( $info_value != '' ) {
				$additional_info[ $field['id'] ] = $info_value;
			}
		}
		return $additional_info;
	}

	public function check_plugin() {
		$body_args = array(
			'purchase_code' => get_option( 'hb_purchase_code' ),
		);
		$response = wp_remote_post( 'http://hotelwp.com/scripts/verify-purchase.php', array( 'body' => $body_args ) );
		if ( ! is_wp_error( $response ) && $response['body'] == 'invalid' ) {
			update_option( 'hb_valid_purchase_code', 'no' );
		}

		$gateway_list = $this->get_payment_gateways();
		foreach ( $gateway_list as $gateway => $data ) {
			if ( ( 'paypal' != $data->id ) && ( 'stripe' != $data->id ) ) {
				$purchase_code_option = 'hb_' . $data->id . '_purchase_code';
				$valid_purchase_code_option = 'hb_' . $data->id . 'valid_purchase_code';
				$body_args = array(
					'purchase_code' => get_option( $purchase_code_option ),
				);
				$response = wp_remote_post( 'https://hotelwp.com/scripts/verify-website-addons-purchase.php', array( 'body' => $body_args ) );
				if ( ! is_wp_error( $response ) && $response['body'] == 'invalid' ) {
					update_option( $valid_purchase_code_option, 'no' );
				}
			}
		}
	}

	public function set_http_api_curl_ssl_version( &$handle ) {
		curl_setopt( $handle, CURLOPT_SSLVERSION, 6 );
	}

	public function get_blog_datetime( $datetime ) {
		$tzstring = get_option( 'timezone_string' );
		$offset = get_option( 'gmt_offset' );
		if ( empty( $tzstring ) && 0 != $offset && floor( $offset ) == $offset ) {
			$offset_st = $offset > 0 ? "-$offset" : '+' . absint( $offset );
			$tzstring  = 'Etc/GMT' . $offset_st;
		}
		if ( empty( $tzstring ) ) {
			$tzstring = 'UTC';
		}

		$dt = new DateTime( $datetime, new DateTimeZone( 'UTC' ) );
		$dt->setTimezone( new DateTimeZone( $tzstring ) );
		return $dt->format('Y-m-d H:i:s');
	}

	public function verify_addon_purchase_code ( $new_purchase_code, $product ) {
		$old_purchase_code_option = 'hb_' . $product . '_purchase_code';
		$valid_purchase_code_option = 'hb_' . $product . '_valid_purchase_code';
		$error_option = 'hb_' . $product . '_purchase_code_error';
		$error_text_option = 'hb_' . $product . '_purchase_code_error_text';

		$old_purchase_code = get_option( $old_purchase_code_option );
		update_option( $old_purchase_code_option, $new_purchase_code );
		if ( isset( $_POST['hb-forced-licence-validation'] ) && $_POST['hb-forced-licence-validation'] == 'hb-forced' ) {
			update_option( $valid_purchase_code_option, 'yes' );
			return;
		}
		if ( isset( $_POST['hb-licence-validation-code'] ) ) {
			if ( $_POST['hb-licence-validation-code'] == md5( $new_purchase_code . '-' . site_url() ) ) {
				update_option( $valid_purchase_code_option, 'yes' );
			} else {
				update_option( $error_option, 'wrong-validation-code' );
				update_option( $valid_purchase_code_option, 'error' );
			}
			return;
		}

		$body_args = array(
			'hb_addon_purchase_code' => $new_purchase_code,
			'hb_addon_old_purchase_code' => $old_purchase_code,
			'site_url' => site_url(),
		);
		$response = wp_remote_post( 'https://hotelwp.com/scripts/verify-website-addons-purchase.php', array( 'body' => $body_args ) );
		$error = '';
		if ( is_wp_error( $response ) ) {
			$error = $response->get_error_message();
		} else {
			$valid_response = array( 'yes', 'no', 'already', 'removed' );
			if ( in_array( $response['body'], $valid_response ) ) {
				update_option( $valid_purchase_code_option, $response['body'] );
			} else if ( $response['body'] == 'invalid' ) {
				update_option( $valid_purchase_code_option, 'no' );
			} else {
				$error = strip_tags( $response['body'] );
				if ( ! $error ) {
					$error = 'HBook Addon - Unknown error.';
				}
			}
		}
		if ( $error ) {
			update_option( $error_option, 'no-online-validation' );
			update_option( $error_text_option, $error );
			update_option( $valid_purchase_code_option, 'error' );
		}
	}

	public function verify_purchase_code( $new_purchase_code ) {
		$old_purchase_code = get_option( 'hb_purchase_code' );
		update_option( 'hb_purchase_code', $new_purchase_code );
		if ( isset( $_POST['hb-forced-licence-validation'] ) && $_POST['hb-forced-licence-validation'] == 'hb-forced' ) {
			update_option( 'hb_valid_purchase_code', 'yes' );
			return;
		}
		if ( isset( $_POST['hb-licence-validation-code'] ) ) {
			if ( $_POST['hb-licence-validation-code'] == md5( $new_purchase_code . '-' . site_url() ) ) {
				update_option( 'hb_valid_purchase_code', 'yes' );
			} else {
				update_option( 'hb_purchase_code_error', 'wrong-validation-code' );
				update_option( 'hb_valid_purchase_code', 'error' );
			}
			return;
		}

		$body_args = array(
			'purchase_code' => $new_purchase_code,
			'old_purchase_code' => $old_purchase_code,
			'site_url' => site_url(),
		);
		$response = wp_remote_post( 'https://hotelwp.com/scripts/verify-purchase.php', array( 'body' => $body_args ) );
		$error = '';
		if ( is_wp_error( $response ) ) {
			$error = $response->get_error_message();
		} else {
			$valid_response = array( 'yes', 'no', 'already', 'removed' );
			if ( in_array( $response['body'], $valid_response ) ) {
				update_option( 'hb_valid_purchase_code', $response['body'] );
			} else if ( $response['body'] == 'invalid' ) {
				update_option( 'hb_valid_purchase_code', 'no' );
			} else {
				$error = strip_tags( $response['body'] );
				if ( ! $error ) {
					$error = 'HBook - Unknown error.';
				}
			}
		}
		if ( $error ) {
			update_option( 'hb_purchase_code_error', 'no-online-validation' );
			update_option( 'hb_purchase_code_error_text', $error );
			update_option( 'hb_valid_purchase_code', 'error' );
		}
	}

	public function get_hbook_pages() {
		if ( get_option( 'hb_valid_purchase_code' ) == 'yes' || strpos( site_url(), '127.0.0.1' ) || strpos( site_url(), 'localhost' ) ) {
			return array(
				array(
					'id' => 'hb_reservations',
					'name' => esc_html__( 'Reservations', 'hbook-admin' ),
					'icon' => 'dashicons-calendar-alt',
				),
				array(
					'id' => 'hb_accommodation',
					'name' => esc_html__( 'Accommodation', 'hbook-admin' ),
					'icon' => 'dashicons-admin-home',
				),
				array(
					'id' => 'hb_seasons',
					'name' => esc_html__( 'Seasons', 'hbook-admin' ),
					'icon' => 'dashicons-calendar',
				),
				array(
					'id' => 'hb_rules',
					'name' => esc_html__( 'Booking rules', 'hbook-admin' ),
					'icon' => 'dashicons-admin-network',
				),
				array(
					'id' => 'hb_rates',
					'name' => esc_html__( 'Rates', 'hbook-admin' ),
					'icon' => 'dashicons-tag',
				),
				array(
					'id' => 'hb_options',
					'name' => esc_html__( 'Extra services', 'hbook-admin' ),
					'icon' => 'dashicons-forms',
				),
				array(
					'id' => 'hb_fees',
					'name' => esc_html__( 'Fees', 'hbook-admin' ),
					'icon' => 'dashicons-money',
				),
				array(
					'id' => 'hb_forms',
					'name' => esc_html__( 'Forms', 'hbook-admin' ),
					'icon' => 'dashicons-admin-page',
				),
				array(
					'id' => 'hb_payment',
					'name' => esc_html__( 'Payment', 'hbook-admin' ),
					'icon' => 'dashicons-vault',
				),
				array(
					'id' => 'hb_ical',
					'name' => esc_html__( 'Ical sync', 'hbook-admin' ),
					'icon' => 'dashicons-update',
				),
				array(
					'id' => 'hb_emails',
					'name' => esc_html__( 'Emails', 'hbook-admin' ),
					'icon' => 'dashicons-email-alt',
				),
				array(
					'id' => 'hb_customers',
					'name' => esc_html__( 'Customers', 'hbook-admin' ),
					'icon' => 'dashicons-groups',
				),
				array(
					'id' => 'hb_appearance',
					'name' => esc_html__( 'Appearance', 'hbook-admin' ),
					'icon' => 'dashicons-admin-appearance',
				),
				array(
					'id' => 'hb_text',
					'name' => esc_html__( 'Text', 'hbook-admin' ),
					'icon' => 'dashicons-editor-paste-text',
				),
				array(
					'id' => 'hb_langfiles',
					'name' => esc_html__( 'Languages', 'hbook-admin' ),
					'icon' => 'dashicons-translation',
				),
				array(
					'id' => 'hb_misc',
					'name' => esc_html__( 'Misc', 'hbook-admin' ),
					'icon' => 'dashicons-admin-generic',
				),
				array(
					'id' => 'hb_licence',
					'name' => esc_html__( 'Licence', 'hbook-admin' ),
					'icon' => 'dashicons-welcome-write-blog',
				),
				array(
					'id' => 'hb_help',
					'name' => esc_html__( 'Help', 'hbook-admin' ),
					'icon' => 'dashicons-sos',
				),
			);
		} else {
			return array(
				array(
					'id' => 'hb_licence',
					'name' => esc_html__( 'Licence', 'hbook-admin' ),
					'icon' => 'dashicons-welcome-write-blog',
				),
				array(
					'id' => 'hb_help',
					'name' => esc_html__( 'Help', 'hbook-admin' ),
					'icon' => 'dashicons-sos',
				),
			);
		}
	}

	/**
	* Title         : Aqua Resizer
	* Description   : Resizes WordPress images on the fly
	* Version       : 1.1.7
	* Author        : Syamil MJ
	* Author URI    : http://aquagraphite.com
	* License       : WTFPL - http://sam.zoy.org/wtfpl/
	* Documentation : https://github.com/sy4mil/Aqua-Resizer/
	*
	* @param string  $url    - (required) must be uploaded using wp media uploader
	* @param int     $width  - (required)
	* @param int     $height - (optional)
	* @param bool    $crop   - (optional) default to soft crop
	* @param bool    $single - (optional) returns an array if false
	* @uses  wp_upload_dir()
	* @uses  image_resize_dimensions() | image_resize()
	* @uses  wp_get_image_editor()
	*
	* @return str|array
	*/

	public function aq_resize( $url, $width = null, $height = null, $crop = null, $single = true, $upscale = true ) {

		// Validate inputs.
		if ( ! $url || ( ! $width && ! $height ) ) return 'wrong inputs';

		// Caipt'n, ready to hook.
		if ( true === $upscale ) add_filter( 'image_resize_dimensions', array( $this, 'aq_upscale' ), 10, 6 );

		// Define upload path & dir.
		$upload_info = wp_upload_dir();
		$upload_dir = $upload_info['basedir'];
		$upload_url = $upload_info['baseurl'];

		$http_prefix = "http://";
		$https_prefix = "https://";
		$relative_prefix = "//"; // The protocol-relative URL

		/* if the $url scheme differs from $upload_url scheme, make them match
		if the schemes differe, images don't show up. */
		if(!strncmp($url,$https_prefix,strlen($https_prefix))){ //if url begins with https:// make $upload_url begin with https:// as well
			$upload_url = str_replace($http_prefix,$https_prefix,$upload_url);
		}
		elseif(!strncmp($url,$http_prefix,strlen($http_prefix))){ //if url begins with http:// make $upload_url begin with http:// as well
			$upload_url = str_replace($https_prefix,$http_prefix,$upload_url);
		}
		elseif(!strncmp($url,$relative_prefix,strlen($relative_prefix))){ //if url begins with // make $upload_url begin with // as well
			$upload_url = str_replace(array( 0 => "$http_prefix", 1 => "$https_prefix"),$relative_prefix,$upload_url);
		}

		// Check if $img_url is local.
		if ( false === strpos( $url, $upload_url ) ) return 'not local: url is $url and upload url is $upload_url';

		// Define path of image.
		$rel_path = str_replace( $upload_url, '', $url );
		$img_path = $upload_dir . $rel_path;

		// Check if img path exists.
		if ( ! file_exists( $img_path ) ) return 'image not found';

		// Check if it is an image.
		if ( ! getimagesize( $img_path ) ) return 'not an image';

		// Get image info.
		$info = pathinfo( $img_path );
		$ext = $info['extension'];
		list( $orig_w, $orig_h ) = getimagesize( $img_path );

		// Get image size after cropping.
		$dims = image_resize_dimensions( $orig_w, $orig_h, $width, $height, $crop );
		$dst_w = $dims[4];
		$dst_h = $dims[5];

		// Return the original image only if it exactly fits the needed measures.
		if ( ! $dims && ( ( ( null === $height && $orig_w == $width ) xor ( null === $width && $orig_h == $height ) ) xor ( $height == $orig_h && $width == $orig_w ) ) ) {
			$img_url = $url;
			$dst_w = $orig_w;
			$dst_h = $orig_h;
		} else {
			// Use this to check if cropped image already exists, so we can return that instead.
			$suffix = "{$dst_w}x{$dst_h}";
			$dst_rel_path = str_replace( '.' . $ext, '', $rel_path );
			$destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";

			if ( ! $dims || ( true == $crop && false == $upscale && ( $dst_w < $width || $dst_h < $height ) ) ) {
				// Can't resize, so return false saying that the action to do could not be processed as planned.
				//var_dump( $dims );
				$img_url = $url;
				//return 'can not resize';
			}
			// Else check if cache exists.
			elseif ( file_exists( $destfilename ) && getimagesize( $destfilename ) ) {
				$img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
			}
			// Else, we resize the image and return the new resized image url.
			else {

				// Note: This pre-3.5 fallback check will edited out in subsequent version.
				if ( function_exists( 'wp_get_image_editor' ) ) {

					$editor = wp_get_image_editor( $img_path );

					if ( is_wp_error( $editor ) || is_wp_error( $editor->resize( $width, $height, $crop ) ) )
						return 'wp error 1';

					$resized_file = $editor->save();

					if ( ! is_wp_error( $resized_file ) ) {
						$resized_rel_path = str_replace( $upload_dir, '', $resized_file['path'] );
						$img_url = $upload_url . $resized_rel_path;
					} else {
						return 'wp error 2 ' . $resized_file->get_error_message();
					}

				} else {

					return 'wp 3.5 required';

				}

			}
		}

		// Okay, leave the ship.
		if ( true === $upscale ) remove_filter( 'image_resize_dimensions', array( $this, 'aq_upscale' ) );

		// Return the output.
		if ( $single ) {
			// str return.
			if ( $img_url == '' ) {
				$img_url = 'nothing';
			}
			$image = $img_url;
		} else {
			// array return.
			$image = array (
				0 => $img_url,
				1 => $dst_w,
				2 => $dst_h
			);
		}

		return $image;
	}

	public function aq_upscale( $default, $orig_w, $orig_h, $dest_w, $dest_h, $crop ) {
		if ( ! $crop ) return null; // Let the wordpress default function handle this.

		// Here is the point we allow to use larger image size than the original one.
		$aspect_ratio = $orig_w / $orig_h;
		$new_w = $dest_w;
		$new_h = $dest_h;

		if ( ! $new_w ) {
			$new_w = intval( $new_h * $aspect_ratio );
		}

		if ( ! $new_h ) {
			$new_h = intval( $new_w / $aspect_ratio );
		}

		$size_ratio = max( $new_w / $orig_w, $new_h / $orig_h );

		$crop_w = round( $new_w / $size_ratio );
		$crop_h = round( $new_h / $size_ratio );

		$s_x = floor( ( $orig_w - $crop_w ) / 2 );
		$s_y = floor( ( $orig_h - $crop_h ) / 2 );

		return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
	}

}