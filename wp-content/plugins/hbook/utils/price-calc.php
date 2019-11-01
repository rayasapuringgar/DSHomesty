<?php
class HbPriceCalc {

	private $rates;
	private $rates_nights;
	private $hbdb;
	private $utils;

	public function __construct( $hbdb, $utils ) {

		$this->hbdb = $hbdb;
		$this->utils = $utils;

		$types = array( 'accom', 'extra_adults', 'extra_children' );
		$rules = $this->hbdb->get_all_rate_booking_rules();
		$rules_ids = array( 0 );
		foreach ( $rules as $rule_id => $rule ) {
			$rules_ids[] = $rule_id;
		}
		$accom_ids = $this->hbdb->get_all_accom_ids();
		$seasons = $this->hbdb->get_all( 'seasons' );
		$seasons_ids = array();
		foreach ( $seasons as $season ) {
			$seasons_ids[] = $season['id'];
		}
		$this->rates = array();
		foreach( $types as $type ) {
			foreach ( $rules_ids as $rule_id ) {
				foreach ( $accom_ids as $accom_id ) {
					foreach ( $seasons_ids as $season_id ) {
						$this->rates[ $type ][ $rule_id ][ $accom_id ][ $season_id ] = array();
					}
				}
			}
		}
		$db_rates = $hbdb->get_all_rates();
		foreach ( $db_rates as $rate ) {
			if ( $rate['rules'] == NULL ) {
				$rules = array( 0 );
			} else {
				$rules = explode( ',', $rate['rules'] );
			}
			if ( $rate['accom'] != NULL && $rate['seasons'] != NULL ) {
				$accom = explode( ',', $rate['accom'] );
				$seasons = explode( ',', $rate['seasons'] );
				foreach ( $rules as $rule_id ) {
					foreach ( $accom as $accom_id ) {
						foreach ( $seasons as $season_id ) {
							$this->rates[ $rate['type'] ][ $rule_id ][ $accom_id ][ $season_id ][] = array(
								'nb_nights' => $rate['nights'],
								'amount' => $rate['amount']
							);
						}
					}
				}
			}
		}
	}

	public function get_price( $accom_id, $str_check_in, $str_check_out, $adults, $children, &$price_breakdown = NULL ) {

		$price_info = array(
			'accom' => array(
				'number' => 1,
				'label' => $this->hbdb->get_string( 'price_breakdown_accom_price' ),
			),
			'extra_adults' => array(
				'number' => 0,
				'label' => ''
			),
			'extra_children' => array(
				'number' => 0,
				'label' => ''
			)
		);

		$nb_nights = $this->utils->get_number_of_nights( $str_check_in, $str_check_out );

		$accom_occupancy = get_post_meta( $accom_id, 'accom_occupancy', true );
		$accom_max_occupancy = get_post_meta( $accom_id, 'accom_max_occupancy', true );
		if ( $adults > $accom_occupancy ) {
			$price_info['extra_adults']['number'] = $adults - $accom_occupancy;
			$price_info['extra_children']['number'] = $children;
		} elseif ( $adults + $children > $accom_occupancy ) {
			$price_info['extra_children']['number'] = $adults + $children - $accom_occupancy;
		}

		if ( $price_info['extra_adults']['number'] > 1 ) {
			$price_info['extra_adults']['label'] = str_replace( '%nb_adults', '%d', $this->hbdb->get_string( 'price_breakdown_extra_adults_several' ) );
			$price_info['extra_adults']['alt_label'] = str_replace( '%nb_adults', '%d', $this->hbdb->get_string( 'price_breakdown_adults_several' ) );
		} else {
			$price_info['extra_adults']['label'] = $this->hbdb->get_string( 'price_breakdown_extra_adult_one' );
			$price_info['extra_adults']['alt_label'] = $this->hbdb->get_string( 'price_breakdown_adult_one' );
		}

		if ( $price_info['extra_children']['number'] > 1 ) {
			$price_info['extra_children']['label'] = str_replace( '%nb_children', '%d', $this->hbdb->get_string( 'price_breakdown_extra_children_several' ) );
			$price_info['extra_children']['alt_label'] = str_replace( '%nb_children', '%d', $this->hbdb->get_string( 'price_breakdown_children_several' ) );
		} else {
			$price_info['extra_children']['label'] = $this->hbdb->get_string( 'price_breakdown_extra_child_one' );
			$price_info['extra_children']['alt_label'] = $this->hbdb->get_string( 'price_breakdown_child_one' );
		}

		$nights = array();
		$current_night = date( 'Y-m-d', strtotime( $str_check_in ) );
		while ( strtotime( $str_check_out ) > strtotime( $current_night ) ) {
			$nights[] = $current_night;
			$current_night = date( 'Y-m-d', strtotime( $current_night . ' + 1 day' ) );
		}

		$rule_ids = array();
		$rules = $this->hbdb->get_rate_booking_rules();
		if ( $rules ) {
			$check_in_day = $this->utils->get_day_num( $str_check_in );
			$check_out_day = $this->utils->get_day_num( $str_check_out );
			foreach ( $rules as $rule ) {
				$allowed_check_in_days = explode( ',', $rule['check_in_days'] );
				$allowed_check_out_days = explode( ',', $rule['check_out_days'] );
				if (
					( in_array( $check_in_day, $allowed_check_in_days ) ) &&
					( in_array( $check_out_day, $allowed_check_out_days ) ) &&
					( $nb_nights >= $rule['minimum_stay'] ) &&
					( $nb_nights <= $rule['maximum_stay'] )
				) {
					$rule_ids[] = $rule['id'];
				}
			}
		}

		$price = 0;
		$accom_price = 0;
		$price_breakdown = '';

		foreach ( $price_info as $type => $p ) {

			if ( $p['number'] > 0 ) {
				$price_before = $price;
				$result = $this->get_price_per_type( $type, $p['number'], $rule_ids, $accom_id, $nights, $str_check_out, $price );
				if ( $type == 'accom' ) {
					$accom_price = $price;
				}
				if ( ! is_array( $result ) ) {
					return array( 'success' => false, 'error' => $result );
				} else {
					if ( count( $result ) > 0 ) {
						$price_breakdown .= '<span class="hb-price-breakdown-' . $type . '">';
						$price_breakdown .= '<span class="hb-price-breakdown-title">';
						if ( $accom_price > 0 ) {
							$price_breakdown .= sprintf( $p['label'], $p['number'] );
						} else {
							$price_breakdown .= sprintf( $p['alt_label'], $p['number'] );
						}
						$price_breakdown .= ' ' . $this->utils->price_with_symbol( $price - $price_before );
						$price_breakdown .= '</span>';
						if ( get_option( 'hb_display_detailed_accom_price' ) != 'no' ) {
							foreach ( $result as $r ) {
								$number_of_nights = $this->utils->get_number_of_nights( $r['start_date'], $r['end_date'] );
								$sub_price = $number_of_nights * $r['price'] * $p['number'];
								if ( $p['number'] > 1 ) {
									$sub_number = ' ' . $p['number'] . ' x ';
								} else {
									$sub_number = '';
								}
								$price_breakdown_dates = $this->hbdb->get_string( 'price_breakdown_dates' );
								$price_breakdown_dates = str_replace( '%from_date', '<span class="hb-format-date">' . $r['start_date'] . '</span>', $price_breakdown_dates );
								$price_breakdown_dates = str_replace( '%to_date', '<span class="hb-format-date">' . $r['end_date'] . '</span>', $price_breakdown_dates );
								if ( $r['multiple_nights_rate'] && $number_of_nights % $r['multiple_nights_rate']['nb_nights'] == 0  ) {
									$stay_length = $number_of_nights / $r['multiple_nights_rate']['nb_nights'];
									$sub_sub_price = $r['multiple_nights_rate']['rate'];
									$stay_str = $this->hbdb->get_string( 'price_breakdown_multiple_nights' );
									$stay_str = str_replace( '%nb_nights', $r['multiple_nights_rate']['nb_nights'], $stay_str );
								} else {
									$stay_length = $number_of_nights;
									$sub_sub_price = $r['price'];
									if ( $stay_length == 1 ) {
										$stay_str = $this->hbdb->get_string( 'price_breakdown_night_one' );
									} else {
										$stay_str = $this->hbdb->get_string( 'price_breakdown_nights_several' );
									}
								}
								$price_breakdown .=
										'<span class="hb-price-breakdown-section">' .
										$price_breakdown_dates .
										' ' .
										$stay_length . ' ' . $stay_str .
										' x ' .
										$sub_number .
										$this->utils->price_with_symbol( $sub_sub_price ) .
										' = ' .
										$this->utils->price_with_symbol( $sub_price ) .
										'</span>';
							}
						}
						$price_breakdown .= '</span>';
					}
				}
			}
		}

		$discount_ids = array();
		$discounts = $this->hbdb->get_discounts_rules( $accom_id );
		if ( $discounts ) {
			$check_in_day = $this->utils->get_day_num( $str_check_in );
			$check_out_day = $this->utils->get_day_num( $str_check_out );
			$str_checkout_for_discounts = date( 'Y-m-d', strtotime( $str_check_out . ' - 1 day' ) );
			foreach ( $discounts as $discount ) {
				$allowed_check_in_days = explode( ',', $discount['check_in_days'] );
				$allowed_check_out_days = explode( ',', $discount['check_out_days'] );
				if ( ( in_array( $check_in_day, $allowed_check_in_days ) ) &&
					( in_array( $check_out_day, $allowed_check_out_days ) ) &&
					( $nb_nights >= $discount['minimum_stay'] ) &&
					( $nb_nights <= $discount['maximum_stay'] )
				) {
					$discount_ids[] = $discount['id'];
				}
			}
		}

		$total_discount_amount = 0;
		$nb_discount = 0;
		foreach ( $discount_ids as $discount_id ) {
			$discount_info = $this->hbdb->get_discount_info( $discount_id, $accom_id, $this->hbdb->get_season( $str_check_in ) );
			if ( $discount_info ) {
				if ( $discount_info['amount_type'] == 'fixed' ) {
					$discount_amount = $discount_info['amount'];
				} else {
					$discount_percent_value = 0;
					$nb_nights_for_discount = 0;
					$current_night = date( 'Y-m-d', strtotime( $str_check_in ) );
					while ( strtotime( $str_check_out ) > strtotime( $current_night ) ) {
						$discount_info_percent = $this->hbdb->get_discount_info( $discount_id, $accom_id, $this->hbdb->get_season( $current_night ) );
						if ( $discount_info_percent && $discount_info_percent['amount_type'] == 'percent' ) {
							$discount_percent_value += $discount_info_percent['amount'];
						}
						$current_night = date( 'Y-m-d', strtotime( $current_night . ' + 1 day' ) );
						$nb_nights_for_discount++;
					}
					$discount_percent_value = round( $discount_percent_value / $nb_nights_for_discount, 2 );
					$discount_amount = round( $discount_percent_value * $price / 100, 2 );
				}
				$nb_discount++;
				$total_discount_amount += $discount_amount;
			}
		}

		if ( $total_discount_amount ) {
			$price_breakdown .=
				'<span class="hb-price-breakdown-discount">' .
					'<span class="hb-price-breakdown-title">' .
					$this->hbdb->get_string( 'price_breakdown_discount' ) . ' ' .
					$this->utils->price_with_symbol( $total_discount_amount ) .
					'</span>' .
					'<span class="hb-price-breakdown-section">' .
					$this->hbdb->get_string( 'price_breakdown_before_discount' ) . ' ' .
					$this->utils->price_with_symbol( $price ) .
					'</span>' .
					'<span class="hb-price-breakdown-section">' .
					$this->hbdb->get_string( 'price_breakdown_discount' ) . ' ';
			if ( $nb_discount == 1 && $discount_info['amount_type'] == 'percent' ) {
				$price_breakdown .=
					$discount_percent_value .
					'% x ' .
					$this->utils->price_with_symbol( $price ) .
					' = ';
			}
			$price_breakdown .=
					$this->utils->price_with_symbol( $total_discount_amount ) .
					'</span>' .
					'<span class="hb-price-breakdown-section">' .
					$this->hbdb->get_string( 'price_breakdown_after_discount' ) . ' ' .
					$this->utils->price_with_symbol( $price - $total_discount_amount ) .
					'</span>' .
				'</span>';

			$price = $price - $total_discount_amount;
		}

		$fees = $this->hbdb->get_accom_fees( $accom_id );
		if ( $fees ) {
			$price_before_fee = $price;
			$fee_breakdown = '';
			$this->apply_fees( $fees, $nb_nights, $adults, $children, $price, $fee_breakdown );
			$price_breakdown .=
				'<span class="hb-price-breakdown-fees">' .
					'<span class="hb-price-breakdown-title">' .
					$this->hbdb->get_string( 'price_breakdown_fees' ) . ' ' .
					$this->utils->price_with_symbol( $price - $price_before_fee ) .
					'</span>';
			$price_breakdown .= $fee_breakdown;
			$price_breakdown .=
				'</span>';
		}

		if ( get_option( 'hb_price_precision' ) == 'no_decimals' ) {
			$price = round( $price );
		}

		return array( 'success' => true, 'value' => $price );
	}

	private function get_price_per_type( $type, $multi, $rule_ids, $accom_id, $nights, $str_check_out, &$price ) {
		$list_of_price = array();
		$current_night_price = -1;
		$current_count_nights = -1;
		$multiple_nights_rate = false;
		$night_groups = array();

		$previous_season_id = 0;
		$current_night_group = array();
		foreach ( $nights as $night ) {
			$season_id = $this->hbdb->get_season( $night );
			if ( $season_id === false ) {
				return str_replace( '%night', $night, $this->hbdb->get_string( 'error_season_not_defined' ) );
			}
			if ( empty( $current_night_group ) || ( $previous_season_id == $season_id ) ) {
				$current_night_group[] = $night;
			} else {
				$night_groups[] = array(
					'season_id' => $previous_season_id,
					'nights' => $current_night_group
				);
				$current_night_group = array( $night );
			}
			$previous_season_id = $season_id;
		}
		$night_groups[] = array(
			'season_id' => $previous_season_id,
			'nights' => $current_night_group
		);

		foreach ( $night_groups as $night_group ) {
			$season_id = $night_group['season_id'];
			$nights = $night_group['nights'];

			$rates = array();
			foreach ( $rule_ids as $rule_id ) {
				$rates = $this->rates[ $type ][ $rule_id ][ $accom_id ][ $season_id ];
				if ( $rates ) {
					break;
				}
			}
			if ( ! $rates ) {
				$rates = $this->rates[ $type ][0][ $accom_id ][ $season_id ];
			}
			if ( ! $rates && ( $type == 'extra_adults' || $type == 'extra_children' ) ) {
				$current_night_price = -1;
				if ( ( count( $list_of_price ) > 0 ) && ( ! $list_of_price[ count( $list_of_price ) - 1 ]['end_date'] ) ) {
					$list_of_price[ count( $list_of_price ) - 1 ]['end_date'] = $nights[0];
				}
				continue;
			}
			if ( ! $rates ) {
				$season = $this->hbdb->get_single( 'seasons', $season_id );
				$error_message = str_replace( '%season_name', '<b>' . $season['name'] . '</b>', $this->hbdb->get_string( 'error_rate_not_defined' ) );
				$error_message = str_replace( '%accom_name', '<b>' . get_the_title( $accom_id ) . '</b>', $error_message );
				return $error_message;
			}

			$rate_nb_nights_value = array();
			foreach ( $rates as $rate ) {
				$rate_nb_nights_value[ $rate['nb_nights'] ] = $rate['amount'];
			}
			$available_rate_nb_nights = array_keys( $rate_nb_nights_value );
			sort( $available_rate_nb_nights );

			$night_sub_groups = array();
			$available_rate_nb_nights_pointer = count( $available_rate_nb_nights ) - 1;
			$rate_nb_nights = $available_rate_nb_nights[ $available_rate_nb_nights_pointer ];
			$new_night_sub_group = array();
			do {
				if ( count( $nights ) >= $rate_nb_nights ) {
					for ( $i = 0; $i < $rate_nb_nights; $i++ ) {
						$new_night_sub_group[] = array_shift( $nights );
					}
					$night_sub_groups[] = $new_night_sub_group;
					$new_night_sub_group = array();
				} else {
					$available_rate_nb_nights_pointer--;
					if ( $available_rate_nb_nights_pointer < 0 ) {
						$night_sub_groups[] = $nights;
						$nights = array();
					} else {
						$rate_nb_nights = $available_rate_nb_nights[ $available_rate_nb_nights_pointer ];
					}
				}
			} while ( count( $nights ) > 0 );

			foreach ( $night_sub_groups as $nights ) {
				$is_multiple_nights_rate = false;
				if ( isset( $rate_nb_nights_value[ count( $nights ) ] ) ) {
					if ( count( $nights ) > 1 ) {
						$is_multiple_nights_rate = true;
					}
					$rate_amount = $rate_nb_nights_value[ count( $nights ) ];
					$rate_nb_nights = count( $nights );
					$night_price = $rate_amount / $rate_nb_nights;
					$price += $rate_amount * $multi;
				} else {
					$rate_nb_nights = $available_rate_nb_nights[0];
					$rate_amount = $rate_nb_nights_value[ $rate_nb_nights ];
					$night_price = $rate_amount / $rate_nb_nights;
					$price += $night_price * count( $nights ) * $multi;
				}

				if ( $night_price != $current_night_price || count( $nights ) != $current_count_nights ) {
					if ( $is_multiple_nights_rate ) {
						$multiple_nights_rate = array(
							'nb_nights' => $rate_nb_nights,
							'rate' => $rate_amount
						);
					} else {
						$multiple_nights_rate = false;
					}
					if ( ( count( $list_of_price ) > 0 ) && ( ! $list_of_price[ count( $list_of_price ) - 1 ]['end_date'] ) ) {
						$list_of_price[ count( $list_of_price ) - 1 ]['end_date'] = $nights[0];
					}
					$new_price = array(
						'start_date' => $nights[0],
						'end_date' => '',
						'price' => $night_price,
						'multiple_nights_rate' => $multiple_nights_rate
					);
					if ( $new_price['price'] != 0 ) {
						$list_of_price[] = $new_price;
					}
					$current_night_price = $night_price;
					$current_count_nights = count( $nights );
				}
			}
		}

		if ( ( count( $list_of_price ) > 0 ) && ( ! $list_of_price[ count( $list_of_price ) - 1 ]['end_date'] ) ) {
			$list_of_price[ count( $list_of_price ) - 1 ]['end_date'] = date( 'Y-m-d', strtotime( $str_check_out ) );
		}
		return $list_of_price;
	}

	private function apply_fees( $fees, $nb_nights, $adults, $children, &$price, &$price_breakdown ) {
		$price_before_fee = $price;
		if ( $nb_nights == 1 ) {
			$nb_nights_str = $this->hbdb->get_string( 'price_breakdown_night_one' );
		} else {
			$nb_nights_str = $this->hbdb->get_string( 'price_breakdown_nights_several' );
		}
		if ( $adults == 1 ) {
			$adults_str = $this->hbdb->get_string( 'fee_details_adult_one' );
		} else {
			$adults_str = $this->hbdb->get_string( 'fee_details_adults_several' );
		}
		if ( $children == 1 ) {
			$children_str = $this->hbdb->get_string( 'fee_details_child_one' );
		} else {
			$children_str = $this->hbdb->get_string( 'fee_details_children_several' );
		}
		$adults_children = $adults + $children;
		if ( ! $children ) {
			$adults_children_str = $adults_str;
		} else {
			$adults_children_str = $this->hbdb->get_string( 'fee_details_persons' );
		}
		foreach ( $fees as $fee ) {
			$fee_name = $this->hbdb->get_string( 'fee_' . $fee['id'] );
			if ( ! $fee_name ) {
				$fee_name = $fee['name'] . ':';
			}
			$fee_name .= ' ';
			$price_breakdown .= '<span class="hb-price-breakdown-section">' . $fee_name;
			switch ( $fee['apply_to_type'] ) {

				case 'per-person' :
					$fee_value = $fee['amount'] * $adults + $fee['amount_children'] * $children;
					$price += $fee_value;
					$price_breakdown .=
						$adults . ' ' . $adults_str .
						' x ' .
						$this->utils->price_with_symbol( $fee['amount'] );
					if ( $children != 0 ) {
						$price_breakdown .=
						' + ' .
						$children . ' ' . $children_str .
						' x ' .
						$this->utils->price_with_symbol( $fee['amount_children'] );
					}
					$price_breakdown .=
						' = ' .
						$this->utils->price_with_symbol( $fee_value ) .
						'</span>';
				break;

				case 'per-accom' :
					$price += $fee['amount'];
					$price_breakdown .=  $this->utils->price_with_symbol( $fee['amount'] );
				break;

				case 'per-person-per-day' :
					$fee_value = $fee['amount'] * $adults * $nb_nights + $fee['amount_children'] * $children * $nb_nights;
					$price += $fee_value;
					$price_breakdown .=
						$nb_nights . ' ' . $nb_nights_str .
						' x ' .
						$adults . ' ' . $adults_str .
						' x ' .
						$this->utils->price_with_symbol( $fee['amount'] );
					if ( $children != 0 ) {
						$price_breakdown .=
						' + ' .
						$nb_nights . ' ' . $nb_nights_str .
						' x ' .
						$children . ' ' . $children_str .
						' x ' .
						$this->utils->price_with_symbol( $fee['amount_children'] );
					}
					$price_breakdown .=
						' = ' .
						$this->utils->price_with_symbol( $fee_value ) .
						'</span>';
				break;

				case 'per-accom-per-day' :
					$fee_value = $fee['amount'] * $nb_nights;
					$price += $fee_value;
					$price_breakdown .=
						$nb_nights . ' ' . $nb_nights_str .
						' x ' .
						$this->utils->price_with_symbol( $fee['amount'] ) .
						' = ' .
						$this->utils->price_with_symbol( $fee_value ) .
						'</span>';
				break;

				case 'accom-percentage' :
				case 'global-percentage' :
					if ( $fee['accom_price_per_person_per_night'] ) {
						$accom_price_per_person = $price_before_fee / ( $adults + $children );
						$accom_price_pppn = $accom_price_per_person / $nb_nights;
						$fee_value = $accom_price_pppn * $fee['amount'] / 100;
						if ( ( $fee['minimum_amount'] > 0 ) && ( $fee_value < $fee['minimum_amount'] ) ) {
							$fee_value = $fee['minimum_amount'];
							$price_breakdown .= $this->utils->price_with_symbol( $fee_value );
						} else if ( ( $fee['maximum_amount'] > 0 ) && ( $fee_value > $fee['maximum_amount'] ) ) {
							$fee_value = $fee['maximum_amount'];
							$price_breakdown .= $this->utils->price_with_symbol( $fee_value );
						} else {
							$price_breakdown .=
								$fee['amount'] .
								'% x ' .
								$this->utils->price_with_symbol( $accom_price_pppn ) .
								' = ' .
								$this->utils->price_with_symbol( $fee_value );
						}
						if ( $fee['multiply_per'] ) {
							$multiply_per = explode( ',', $fee['multiply_per'] );
							foreach ( $multiply_per as $multiplier ) {
								$fee_value *= $$multiplier;
								$multiplier_str = $multiplier . '_str';
								$price_breakdown .=
									' x ' .
									$$multiplier . ' ' . $$multiplier_str;
							}
							$price_breakdown .=
								' = ' .
								$this->utils->price_with_symbol( $fee_value );
						}
						$price += $fee_value;
						$price_breakdown .= '</span>';
					} else {
						$fee_value = round( $price_before_fee * ( $fee['amount'] / 100 ), 2 );
						$price += $fee_value;
						$price_breakdown .=
							$fee['amount'] .
							'% x ' .
							$this->utils->price_with_symbol( $price_before_fee ) .
							' = ' .
							$this->utils->price_with_symbol( $fee_value ) .
							'</span>';
					}
				break;

			}
		}
	}

}