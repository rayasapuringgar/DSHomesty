<?php
class HbResaCoupon {

	private $hbdb;
	private $utils;
	private $coupon;

	public function __construct( $hbdb, $utils, $coupon ) {
		$this->hbdb = $hbdb;
		$this->utils = $utils;
		$this->coupon = $coupon;
	}

	public function is_valid( $accom_id, $check_in, $check_out ) {
		return
			$this->is_valid_accom( $accom_id ) &&
			$this->is_valid_season( $check_in, $check_out ) &&
			$this->is_valid_rule( $check_in, $check_out );
	}

	private function is_valid_accom( $accom_id ) {
		return
			$this->coupon['all_accom'] ||
			( $this->coupon['accom'] && in_array( $accom_id, explode( ',', $this->coupon['accom'] ) ) );
	}

	private function is_valid_season( $check_in, $check_out ) {
		if ( $this->coupon['all_seasons'] ) {
			return true;
		}
		if ( ! $this->coupon['seasons'] ) {
			return false;
		}
		$coupon_seasons = explode( ',', $this->coupon['seasons'] );
		$current_night = date( 'Y-m-d', strtotime( $check_in ) );
		while ( strtotime( $check_out ) > strtotime( $current_night ) ) {
			$season_id = $this->hbdb->get_season( $current_night );
			if ( ! in_array( $season_id, $coupon_seasons ) ) {
				return false;
			}
			$current_night = date( 'Y-m-d', strtotime( $current_night . ' + 1 day' ) );
		}
		return true;
	}

	private function is_valid_rule( $check_in, $check_out ) {
		if ( ! $this->coupon['rule'] ) {
			return true;
		} else {
			$rule = $this->hbdb->get_rule_by_id( $this->coupon['rule'] );
			$check_in_day = $this->utils->get_day_num( $check_in );
			$check_out_day = $this->utils->get_day_num( $check_out );
			$allowed_check_in_days = explode( ',', $rule['check_in_days'] );
			$allowed_check_out_days = explode( ',', $rule['check_out_days'] );
			$nb_nights = $this->utils->get_number_of_nights( $check_in, $check_out );
			if (
				in_array( $check_in_day, $allowed_check_in_days ) &&
				in_array( $check_out_day, $allowed_check_out_days ) &&
				$nb_nights >= $rule['minimum_stay'] &&
				$nb_nights <= $rule['maximum_stay']
			) {
				return true;
			} else{
				return false;
			}
		}
	}
}