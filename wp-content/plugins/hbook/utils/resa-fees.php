<?php
class HbResaFees {


	private $hbdb;
	private $utils;


	public function __construct( $hbdb, $utils ) {
		$this->hbdb = $hbdb;
		$this->utils = $utils;
	}


	public function get_fees_markup_frontend() {
		return $this->get_fees_markup( 'front-end' );
	}


	public function get_fees_markup_admin() {
		return $this->get_fees_markup( 'back-end' );
	}


	private function get_fees_markup( $markup_for ) {
		$output = '';
		$fees = $this->hbdb->get_final_fees();
		foreach ( $fees as $fee ) {
			$fee_display_name = '';
			if ( $markup_for == 'front-end' ) {
				$fee_display_name = $this->hbdb->get_string( 'fee_' . $fee['id'] );
			}
			if ( ! $fee_display_name ) {
				$fee_display_name = $fee['name'];
			}
			if (
				( $fee['apply_to_type'] == 'global-percentage' ) ||
				( $fee['apply_to_type'] == 'accom-percentage' ) ||
				( $fee['apply_to_type'] == 'extra-percentage' )
			) {
				$fee_display_name .=' (' . $fee['amount'] . '%)';
			}
			$fee_display_name .= ' :';
			$fee_class = 'hb-fee';
			if ( $fee['apply_to_type'] == 'global-percentage' ) {
				$fee_class .= ' hb-fee-percentage';
			} else if ( $fee['apply_to_type'] == 'accom-percentage' ) {
				$fee_class .= ' hb-fee-accom-percentage';
			} else if ( $fee['apply_to_type'] == 'extras-percentage' ) {
				$fee_class .= ' hb-fee-extras-percentage';
			}
			$output .= '<div class="' . $fee_class . '" data-price="' . $fee['amount'] . '">' . $fee_display_name . ' ' . $this->utils->price_placeholder() . '</div>';
		}
		if ( $output ) {
			$output = '<br/>' . $output;
		}
		return $output;
	}

}