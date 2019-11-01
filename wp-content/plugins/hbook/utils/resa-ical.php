<?php
class HbResaIcal {

	private $hbdb;
	private $utils;

	public function __construct( $hbdb, $utils ) {
		$this->hbdb = $hbdb;
		$this->utils = $utils;
	}

	public function ics_to_array( $ics_file ) {
		$ics_resas = array();
		$file = str_replace( "\n ", '', $ics_file );
		$ics_data = explode( 'BEGIN:', $file );
		foreach ( $ics_data as $i => $data ) {
			$ics_meta[$i] = explode( "\n", $data );
			foreach ( $ics_meta as $j => $meta ) {
				foreach ( $meta as $k => $info ) {
					if ( $info ) {
						if ( $j != 0 && $k == 0 ) {
							$ics_resas[ $j ]['BEGIN'] = trim( $info );
						} else {
							$cal_meta = explode( ':', $info, 2 );
							if ( strpos( $cal_meta[0], 'PRODID' ) !== false ) {
								$cal_meta[0] = 'PRODID';
							}
							if ( strpos( $cal_meta[0], 'DTEND' ) !== false ) {
								$cal_meta[0] = 'DTEND';
							}
							if ( strpos( $cal_meta[0], 'DTSTART' ) !== false ) {
								$cal_meta[0] = 'DTSTART';
							}
							if ( strpos( $cal_meta[0], 'DESCRIPTION' ) !== false ) {
								if ( strpos( $cal_meta[1], 'CHECKIN' ) !== false ) {
									$ics_resas[ $j ][$cal_meta[0]] = array();
									if ( false !== strpos( $cal_meta[1], '\n' ) ) {
										$resa_desc = explode( '\n', $cal_meta[1] );
										foreach ( $resa_desc as $l => $desc ) {
											if ( $desc != '' ) {
												$desc_info = explode( ':', $desc );
												if ( count( $desc_info ) == 2 ) {
													$ics_resas[ $j ][ $cal_meta[0] ][ $desc_info[0] ] = trim( $desc_info[1] );
												}
											}
										}
									}
								}
							} else {
								$ics_resas[ $j ][ $cal_meta[0] ] = trim( $cal_meta[1] );
							}
						}
					}
				}
			}
		}
		return $ics_resas;
	}

	public function export_ical() {
		if ( isset( $_GET['accom_id'] ) ) {
			$accom_id = intval( $_GET['accom_id'] );
		} else {
			return;
		}
		if ( isset( $_GET['accom_num'] ) ) {
			$accom_num = intval( $_GET['accom_num'] );
		} else {
			return;
		}
		$accom_post = get_post( $accom_id );
		$accom_name = $accom_post->post_name;
		$accom_num_name = $this->hbdb->get_accom_num_name_by_accom_num( $accom_id, $accom_num );
		$filename = 'hbook-' . $accom_name . '-' . $accom_num_name . '-calendar.ics';
		header( 'Content-type: text/calendar; charset=utf-8' );
		header( 'Content-Disposition: inline; filename=' . $filename );
		$this->create_ical( $accom_id, $accom_num );
	}

	public function create_ical( $accom_id, $accom_num ) {
		$reservations = $this->hbdb->get_future_resa_by_accom_num( $accom_id, $accom_num );
		$blocked_dates = $this->hbdb->get_future_blocked_dates_by_accom_num( $accom_id, $accom_num );
		$accom_post = get_post( $accom_id );
		$accom_name = $accom_post->post_name;
		$blog_name = get_bloginfo();
		$prod_id = '-//' . $blog_name . '//HBook-' . $accom_name . '-' . $accom_num . '// EN' . "\r\n";
		$dtstamp = date( 'Ymd\THis\Z', time() ) . "\r\n";
		?>
BEGIN:VCALENDAR
METHOD:PUBLISH
PRODID:<?php echo ( $prod_id ); ?>
CALSCALE:GREGORIAN
VERSION:2.0
<?php
		foreach ( $reservations as $reservation ) {
			if ( ( ( get_option( 'hb_ical_export_cancelled_resa' ) == 'no' ) && ( $reservation['status'] == 'cancelled' ) ) || 'processing' == $reservation['status'] ) {
				continue;
			}
			$check_in = str_replace( '-', '', $reservation['check_in'] ) . "\r\n";
			$check_out = str_replace( '-', '', $reservation['check_out'] ) . "\r\n";
			$uid = $reservation['uid'] . "\r\n";
			$customer_name = '';
			$customer_email = '';
			if ( $reservation['customer_id'] ) {
				$customer_info = $this->hbdb->get_customer_info( $reservation['customer_id'] );
				if ( isset( $customer_info['first_name'] ) ) {
					$customer_name = $customer_info['first_name'] . ' ';
				}
				if ( isset( $customer_info['last_name'] ) ) {
					$customer_name .= $customer_info['last_name'];
				}
				if ( isset( $customer_info['email'] ) ) {
					$customer_email = $customer_info['email'];
				}
			}
			$description = $this->utils->replace_resa_vars_with_value( $reservation['id'], false, get_option( 'hb_ical_description' ) );
			$description = $this->utils->replace_customer_vars_with_value( $reservation['customer_id'], $description );
			$description = $this->format_property( $description ) . "\r\n";
			$summary = $this->utils->replace_resa_vars_with_value( $reservation['id'], false, get_option( 'hb_ical_summary' ) );
			$summary = $this->utils->replace_customer_vars_with_value( $reservation['customer_id'], $summary );
			$summary = $this->format_property( $summary ) . "\r\n";
			if ( $reservation['status'] == 'cancelled' ) {
				$status = 'CANCELLED' . "\r\n";
			} else {
				$status = 'CONFIRMED' . "\r\n";
			}
			$created = date( 'Ymd\THis\Z', strtotime( $reservation['received_on'] ) ). "\r\n";
			if ( $reservation['updated_on'] > $created ) {
				$last_modified = date( 'Ymd\THis\Z', strtotime( $reservation['updated_on'] ) ) .  "\r\n";
			} else {
				$last_modified = false;
			}
			$this->create_event( $check_out, $check_in, $dtstamp, $uid, $description, $summary, $status, $created, $last_modified );
		}
		if ( get_option( 'hb_ical_export_blocked_dates' ) == 'yes' ) {
			foreach ( $blocked_dates as $blocked_date ) {
				$check_out = str_replace( '-', '', $blocked_date['to_date'] ) . "\r\n";
				$check_in = str_replace( '-', '', $blocked_date['from_date'] ) . "\r\n";
				$uid = $blocked_date['uid'] . "\r\n";
				if ( $blocked_date['comment'] ) {
					$description = $blocked_date['comment'] . "\r\n";
				} else {
					$description = esc_html__( 'Accommodation blocked', 'hbook-admin' ) . "\r\n";
				}
				$summary = esc_html__( 'Accommodation blocked', 'hbook-admin' ) . "\r\n";
				$status = 'CONFIRMED' .  "\r\n";
				$created = false;
				$last_modified = false;
				$this->create_event( $check_out, $check_in, $dtstamp, $uid, $description, $summary, $status, $created, $last_modified );
			}
		}
		?>
END:VCALENDAR
<?php
	}

	private function create_event( $check_out, $check_in, $dtstamp, $uid, $description, $summary, $status, $created, $last_modified ) {
		?>
BEGIN:VEVENT
DTEND;VALUE=DATE:<?php echo( $check_out );?>
DTSTART;VALUE=DATE:<?php echo( $check_in );?>
DTSTAMP:<?php echo( $dtstamp );?>
UID:<?php echo( $uid );?>
DESCRIPTION:<?php echo( $description );?>
SUMMARY:<?php echo( $summary ); ?>
STATUS:<?php echo( $status );
if ( $created ) {?>
CREATED:<?php echo( $created );
}
if ( $last_modified ) {?>
LAST-MODIFIED:<?php echo( $last_modified );
}?>
END:VEVENT
<?php
	}

	private function format_property( $property_value ) {
		$property_value = str_replace( array( "\r\n", "\n", "\r" ), '\n', $property_value );
		$property_value = explode( '\n', $property_value );
		foreach ( $property_value as $i => $line ) {
			if ( strlen( $line ) > 70 ) {
				$line = substr( $line, 0, 70 ) . '\n' . substr( $line, 70 );
				$line = $this->format_property( $line );
			}
			$property_value[ $i ] = $line;
		}
		$property_value = implode( '\n', $property_value );
		return $property_value;
	}

	public function update_calendars() {
		$calendars = $this->hbdb->get_ical_sync();
		if ( $calendars ) {
			$accom_ids = $this->hbdb->get_all_accom_ids();
			foreach ( $calendars as $calendar ) {
				if ( in_array( $calendar['accom_id'], $accom_ids ) ) {
					$db_calendar_id = $calendar['calendar_id'];
					/*
					if ( get_option( 'hb_ical_do_not_force_ssl_version' ) != 'yes' ) {
						add_action( 'http_api_curl', array( $this->utils, 'set_http_api_curl_ssl_version' ) );
					}
					*/
					$response = wp_remote_post( $calendar['synchro_url'], array( 'method' => 'GET' ) );
					/*
					if ( get_option( 'hb_ical_do_not_force_ssl_version' ) != 'yes' ) {
						remove_action( 'http_api_curl', array( $this->utils, 'set_http_api_curl_ssl_version' ) );
					}
					*/
					if ( is_wp_error( $response ) ) {
						$error_exists = $this->hbdb->exist_invalid_url_sync_error( $db_calendar_id );
						if ( ! $error_exists ) {
							$this->hbdb->add_ical_sync_error( 'invalid_url', $calendar['synchro_url'], '', $calendar['calendar_name'],  $calendar['accom_id'], $calendar['accom_num'], '','', current_time( 'mysql', 1 ) );
						}
					} else {
						$events_not_imported = '';
						$resa_modified = '';
						$calendar_name = $calendar['calendar_name'];
						$synchro_id = $calendar['synchro_id'];
						// function run twice to be able to deal with cancelled reservations and modified dates
						// (if with overlapping dates, the first run will free the dates (reservation cancelled while the second run will modify the reservation dates)
						$this->process_ical_file( $response['body'], $calendar_name, $calendar['accom_id'], $calendar['accom_num'], $db_calendar_id, $synchro_id );
						$results = $this->process_ical_file( $response['body'], $calendar_name, $calendar['accom_id'], $calendar['accom_num'], $db_calendar_id, $synchro_id );

						if ( $results[ $db_calendar_id ] ) {
							if ( array_key_exists( 'events_not_imported', $results[ $db_calendar_id ] ) ) {
								$events_not_imported = $results[ $db_calendar_id ]['events_not_imported'];
								foreach ( $events_not_imported as $event_not_imported => $details ) {
									$error_exists = $this->hbdb->get_ical_sync_error_by_uid( $details['uid'] );
									if ( ! $error_exists ) {
										$this->hbdb->add_ical_sync_error( 'event not imported', $calendar['synchro_url'], $details['uid'], $calendar_name, $details['accom_id'], $details['accom_num'], $details['check_in'], $details['check_out'], current_time( 'mysql', 1 ) );
									}
								}
							}
							if ( array_key_exists( 'resa_modified', $results[ $db_calendar_id ] ) ) {
								$resa_modified = $results[ $db_calendar_id ]['resa_modified'];
								foreach ( $resa_modified as $resa => $uid ) {
									$error_exists = $this->hbdb->get_ical_sync_error_by_uid( $uid );
									if ( ! $error_exists ) {
										$resa_details = $this->hbdb->get_resa_by_uid( $uid );
										$this->hbdb->add_ical_sync_error( 'resa_modified', $calendar['synchro_url'], $uid, $calendar_name, $resa_details['accom_id'], $resa_details['accom_num'], $resa_details['check_in'], $resa_details['check_out'], current_time( 'mysql', 1 ) );
									}
								}
							}
						}
					}
				}
			}
		}
		update_option( 'hb_last_synced', current_time( 'mysql', 1 ) );
	}

	public function ical_parse( $file, $accom_num, $accom_id, $calendar_name ) {
		$results = $this->process_ical_file( $file, $calendar_name, $accom_id, $accom_num, '', '' );
		$results_keys = array_keys( $results );
		$calendar_id = reset( $results_keys );
		$synchro_id = $results[ $calendar_id ]['synchro_id'];
		$nb_resa_added = $results[ $calendar_id ]['resa_added'];
		if ( array_key_exists( 'events_not_imported', $results[ $calendar_id ] ) ) {
			$nb_events_not_imported = count( $results[ $calendar_id ]['events_not_imported'] );
		} else {
			$nb_events_not_imported = 0;
		}
		$parse['calendar_id'] = $calendar_id;
		$parse['synchro_id'] = $synchro_id;

		if ( ( $nb_resa_added == 0 ) && ( $nb_events_not_imported == 0 ) && ( count( $results[ $calendar_id ]['past_events'] ) == 0 ) ) {
			$parse['success'] = false;
			?>
			<div class="error">
				<p><?php esc_html_e( 'No reservation could be imported. Please check that your file contain a calendar with events.', 'hbook-admin' ); ?></p>
			</div>
			<?php
		} else {
			$parse['success'] = true;
			?>
			<div class="hb-ical-notification updated">
				<p><?php printf( esc_html__( 'Your calendar has been imported: %1$s reservation(s) have been added.', 'hbook-admin' ), '<b>' . $nb_resa_added . '</b>' ); ?></p>
				<?php
				if ( $nb_events_not_imported > 0 ) {
					$accom_num_name = $this->hbdb->get_accom_num_name_by_accom_num( $accom_id, $accom_num );
					?>
					<p><?php printf( esc_html__( 'The following reservation(s) could not be imported as the accommodation %1$s (%2$s) is not available:', 'hbook-admin' ), '<b>' . get_the_title( $accom_id ) . '</b>', $accom_num_name ); ?>
						<ul>
							<?php
							for ( $i = 0; $i < $nb_events_not_imported; $i++ ) { ?>
								<li><?php printf( esc_html__( 'A reservation with check-in on %1$s and check-out on %2$s', 'hbook-admin' ), $results[ $calendar_id ]['events_not_imported'][$i]['check_in'], $results[ $calendar_id ]['events_not_imported'][$i]['check_out'] ); ?></li>
							<?php
							}
							?>
						</ul>
					</p>
					<?php
				}
				?>
			</div>
			<?php
		}
		return $parse;
	}

	private function process_ical_file( $ical_data, $calendar_name, $accom_id, $accom_num, $db_calendar_id, $synchro_id ) {

		$calendar_arrays = $this->ics_to_array( $ical_data );
		$count = 0;
		$past_events = 0;
		$results = array();
		$non_reliable_uid_calendar = false;
		$airbnb_calendar = false;
		$uid_list = array();
		foreach ( $calendar_arrays as $calendar_array ) {
			$admin_comment = '';
			$status = get_option( 'hb_ical_import_resa_status' );
			if ( $calendar_array['BEGIN'] == 'VCALENDAR') {
				if ( strpos( $calendar_array['PRODID'] ,'TripAdvisor' ) || strpos( $calendar_array['PRODID'] ,'Travanto' ) ) {
					$non_reliable_uid_calendar = true;
				}
				if ( strpos( $calendar_array['PRODID'] ,'Airbnb' ) ) {
					$airbnb_calendar = true;
				}
				$calendar_id = $calendar_array['PRODID'];
				if ( $db_calendar_id ) {
					if ( $calendar_id != $db_calendar_id ) {
						$results[ $calendar_id ]['type'][] = 'invalid_signature';
						$results[ $calendar_id ]['invalid_signature'] = true;
						break;
					} else {
						$results[ $calendar_id ]['invalid_signature'] = false;
					}
				} else {
					$results[ $calendar_id ] = array();
				}
				if ( ! $synchro_id ) {
					$synchro_id = uniqid( '', true );
					$results[ $calendar_id ]['synchro_id'] = $synchro_id;
				}
			} else if ( $calendar_array['BEGIN'] == 'VEVENT') {
				if ( false === strpos( $calendar_array['SUMMARY'],'PENDING' ) && isset( $calendar_array['DTEND'] ) && isset( $calendar_array['DTSTART'] ) ) {
					$dtend = substr( $calendar_array['DTEND'], 0, 8 );
					if ( strtotime( $dtend ) >= strtotime ( 'today' ) ) {
						$dtstart = substr( $calendar_array['DTSTART'], 0, 8 );
						$check_out = date( 'Y-m-d', strtotime( $dtend ) );
						$check_in = date( 'Y-m-d', strtotime( $dtstart ) );

						if ( strtotime( $dtend ) > strtotime( $dtstart ) ) {

							$existing_resa = '';
							$uid = '';
							if ( isset( $calendar_array['UID'] ) && ! $non_reliable_uid_calendar ) {
								$uid = $calendar_array['UID'];
							} else if ( isset( $calendar_array['SUMMARY'] ) && $non_reliable_uid_calendar ) {
								$uid = $calendar_array['SUMMARY'];
							}

							if ( isset( $calendar_array['SUMMARY'] ) && $airbnb_calendar ) {
								$airbnb_summary = $calendar_array['SUMMARY'];
								$existing_resa = $this->hbdb->get_resa_by_uid_by_accom_num( $airbnb_summary, $accom_id, $accom_num );
							}

							if ( $existing_resa ) {
								$uid = $airbnb_summary;
							} else {
								$existing_resa = $this->hbdb->get_resa_by_uid_by_accom_num( $uid, $accom_id, $accom_num );
							}

							$uid_list[] = $uid;

							if ( $existing_resa ) {

								if ( 'cancelled' == $existing_resa['status'] ) {
									if ( isset( $calendar_array['STATUS'] ) && strpos( $calendar_array['STATUS'],'CANCELLED' ) ) {
										return;
									} else {
										$id = $this->hbdb->get_resa_id_by_uid( $uid );
										$this->hbdb->update_resa_status( $id, $status );
									}
								}

								if ( $check_in != $existing_resa['check_in'] || $check_out != $existing_resa['check_out'] ) {

									$need_updating = true;
									if ( isset( $calendar_array['LAST_MODIFIED'] ) ) {
										$last_modified_unix = strtotime( $calendar_array['LAST-MODIFIED'] );
										$updated_on_unix = strtotime( $existing_resa['updated_on'] );
										if ( $updated_on_unix >= $last_modified_unix ) {
											$need_updating = false;
										}
									}
									if ( $need_updating && ( get_option( 'hb_ical_update_resa_dates' ) === "yes"  ) ) {
										$can_update = $this->utils->can_update_resa_dates( $existing_resa['id'], $check_in, $check_out );
										if ( $can_update ) {
											$this->hbdb->update_resa_dates( $existing_resa['id'], $check_in, $check_out );
										} else {
											$results[ $calendar_id ]['resa_modified'][] = $uid;
										}
									} else {
										$results[ $calendar_id ]['resa_modified'][] = $uid;
									}
								}

							} else {
								//Exclude 1 night reservation - fix for AirBnb
								if (
									( get_option( 'hb_ical_exclude_one_day_reservations' ) == 'yes' ) &&
									( strtotime( $dtend ) <= strtotime( $dtstart . ' + 1 day' ) )
								) {
									continue;
								}

								//External advanced notice
								if ( get_option( 'hb_ical_advanced_notice' ) >= 1 ) {
									$advanced_notice = 'today + ' . get_option( 'hb_ical_advanced_notice' ) . ' day';
									if ( strtotime( $dtstart ) < strtotime( $advanced_notice ) ) {
										continue;
									}
								}

								//External booking window
								if ( get_option( 'hb_ical_import_booking_window' ) ) {
									$booking_window = '+ ' . get_option( 'hb_ical_import_booking_window' ) . ' months';
									if ( strtotime( $dtstart ) > strtotime( $booking_window ) ) {
										continue;
									}
								}

								$is_available = $this->hbdb->is_available_accom_num( $accom_id, $accom_num, $check_in, $check_out );
								if ( ! $is_available ) {
									$results[ $calendar_id ]['events_not_imported'][] = array(
										'accom_id'	=> $accom_id,
										'accom_num'	=> $accom_num,
										'check_in'	=> $check_in,
										'check_out' => $check_out,
										'uid' => $uid,
									);
								} else {
									$customer_id = 0;
									if ( isset( $calendar_array['SUMMARY'] ) ) {
										if ( $calendar_array['SUMMARY'] != 'Not available' && $calendar_array['SUMMARY'] != 'unavailable'	) {
											$admin_comment = $admin_comment . esc_html__( 'Summary: ', 'hbook-admin' ) . $calendar_array['SUMMARY'] . "\n";
										}
									}
									if ( isset( $calendar_array['DESCRIPTION'] ) ) {
										if ( isset( $calendar_array['DESCRIPTION']['PHONE'] ) ) {
											$admin_comment = $admin_comment . esc_html__( 'Phone: ', 'hbook-admin' ) . $calendar_array['DESCRIPTION']['PHONE'] . "\n";
										}
										if ( isset( $calendar_array['DESCRIPTION']['EMAIL'] ) && strpos( $calendar_array['DESCRIPTION']['EMAIL'], '@' ) ) {
											$customer_email = $calendar_array['DESCRIPTION']['EMAIL'];
											$customer_id = $this->hbdb->get_customer_id( $customer_email );
											if ( ! $customer_id ) {
												$customer_id = $this->hbdb->create_customer( $customer_email, array() );
											}
											$admin_comment = $admin_comment . esc_html__( 'Email: ', 'hbook-admin' ) . $customer_email . "\n";
										}
									}

									if ( isset( $calendar_array['LAST-MODIFIED'] ) ) {
										$last_modified = date( 'Y-m-d H:i:s', strtotime( $calendar_array['LAST-MODIFIED'] ) );
									} else {
										$last_modified = current_time( 'mysql', 1 );
									}

									$resa_info = array(
										'uid' => $uid,
										'check_in' => $check_in,
										'check_out' => $check_out,
										'status' => $status,
										'accom_id' => $accom_id,
										'accom_num' => $accom_num,
										'customer_id' => $customer_id,
										'updated_on' => $last_modified,
										'admin_comment' => $admin_comment,
										'origin' => $calendar_name,
										'synchro_id' => $synchro_id,
									);

									$resa_id = $this->hbdb->create_resa( $resa_info );
									if ( $resa_id ) {
										$this->hbdb->block_linked_accom( $resa_info['accom_id'], $resa_info['check_in'], $resa_info['check_out'], $resa_id );
										$count++;
									}
								}
							}
						}
					} else {
						$past_events++;
					}
				}
			}
		}
		if ( $synchro_id && ( get_option( 'hb_ical_update_status_resa' ) == 'yes' ) ) {
			$db_uid_list = $this->hbdb->get_uids_by_synchro_id( $synchro_id );
			$uid_diff = array_diff( $db_uid_list, $uid_list );
			if ( $uid_diff ) {
				foreach ( $uid_diff as $uid ) {
					if ( $uid != 'Not available' ) {
						$id = $this->hbdb->get_resa_id_by_uid( $uid );
						$this->hbdb->update_resa_status( $id, 'cancelled' );
					}
				}
			}
		}
		$results[ $calendar_id ]['resa_added'] = $count;
		$results[ $calendar_id ]['past_events'] = $past_events;
		return $results;
	}

}