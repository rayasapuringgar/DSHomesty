jQuery( document ).ready( function( $ ) {

	var Field = function( standard, id, name, displayed, required, type, choices, form_name, data_about, column_width ) {
		var self = this;
		this.standard = standard;
		this.form_name = form_name;
		this.id = ko.observable( id );
		this.name = ko.observable( name );
		this.type = ko.observable( type );
		this.column_width = ko.observable( column_width );
		this.displayed_yes_input_id = ko.computed( function() {
			return this.id() + '_displayed_yes';
		}, this );
		this.displayed_no_input_id = ko.computed( function() {
			return this.id() + '_displayed_no';
		}, this );
		this.required_yes_input_id = ko.computed( function() {
			return this.id() + '_required_yes';
		}, this );
		this.required_no_input_id = ko.computed( function() {
			return this.id() + '_required_no';
		}, this );
		this.data_about_customer_input_id = ko.computed( function() {
			return this.id() + '_data_about_customer';
		}, this );
		this.data_about_booking_input_id = ko.computed( function() {
			return this.id() + '_data_about_booking';
		}, this );
		this.displayed = ko.observable( displayed );
		this.required = ko.observable( required );
		this.data_about = ko.observable( data_about );
		this.choices = ko.observableArray();
		for ( var i = 0; i < choices.length; i++ ) {
			this.choices.push( choices[i] );
		}
		this.editing_name = ko.observable( false );

		this.add_choice = function() {
			var id = get_unique_choice_id( 'new_choice' );
			if ( id ) {
				form_saved = false;
				self.choices.unshift( new Choice( id, hb_text.new_choice ) );
			} else {
				alert( 'Too many new choices. Please start renaming choices.' );
			}
		}

		this.remove_choice = function( choice ) {
			if ( confirm( hb_text.confirm_delete_choice.replace( '%choice_name', choice.name() ) ) ) {
				self.choices.remove( choice );
				form_saved = false;
			}
		}

		this.edit_choice_name = function( choice ) {
			choice.editing_choice( true );
			form_saved = false;
		}

		this.stop_edit_choice_name = function( choice ) {
			choice.editing_choice( false );
			$( '.hb-input-choice-name' ).blur();
			var new_id = get_unique_choice_id( choice.name() );
			if ( new_id ) {
				choice.id( new_id );
			}
			form_saved = false;
		}

		function get_unique_choice_id( name ) {
			return get_unique_id( name, self.choices() );
		}

	}

	var Choice = function( id, name ) {
		this.id = ko.observable( id );
		this.name = ko.observable( name );

		this.editing_choice = ko.observable( false );
	}

	var FieldsViewModel = function() {
		var self = this;

		var observable_fields = [];
		for ( var i = 0; i < hb_fields.length; i++ ) {
			var observable_choices = [];
			for ( var j = 0; j < hb_fields[i].choices.length; j++ ) {
				observable_choices.push( new Choice( hb_fields[i].choices[j].id, hb_fields[i].choices[j].name ) );
			}
			observable_fields.push( new Field( hb_fields[i].standard, hb_fields[i].id, hb_fields[i].name, hb_fields[i].displayed, hb_fields[i].required, hb_fields[i].type, observable_choices, hb_fields[i].form_name, hb_fields[i].data_about, hb_fields[i].column_width ) );
		}
		self.fields = ko.observableArray( observable_fields );

		function new_field( id ) {
			var standard = 'no',
				id = id,
				name = hb_text.new_field,
				form_name = hb_form_name,
				data_about = '',
				column_width = '',
				displayed = 'yes',
				required = 'no',
				type = 'text',
				choices = [];

			if ( form_name != 'contact' ) {
				data_about = 'customer';
			}

			return new Field( standard, id, name, displayed, required, type, choices, form_name, data_about, column_width );
		}

		this.add_field_top = function() {
			$( '#hb-form-add-field-top' ).blur();
			var id = get_unique_field_id( 'new_field' );
			if ( id ) {
				form_saved = false;
				self.fields.unshift( new_field( id ) );
				$( '.hb-form-fields-container .hb-form-field' ).first().hide().slideDown();
			} else {
				alert( 'Too many new fields. Please start renaming fields.' );
			}
		}

		this.add_field_bottom = function() {
			$( '#hb-form-add-field-bottom' ).blur();
			var id = get_unique_field_id( 'new_field' );
			if ( id ) {
				form_saved = false;
				self.fields.push( new_field( id ) );
				$( '.hb-form-fields-container .hb-form-field' ).last().hide().slideDown();
			} else {
				alert( 'Too many new fields. Please start renaming fields.' );
			}
		}

		this.remove_field = function( field ) {
			var confirm_text,
				no_info_fields = [ 'column_break', 'title', 'sub_title', 'explanation', 'separator' ],
				no_name_fields = [ 'column_break', 'separator' ];

			if ( no_name_fields.indexOf( field.type() ) > -1 ) {
				confirm_text = hb_text.confirm_delete_field_no_name;
			} else {
				confirm_text = hb_text.confirm_delete_field.replace( '%field_name', field.name() );
			}
			if ( no_info_fields.indexOf( field.type() ) == -1 ) {
				confirm_text += ' ' + hb_text.confirm_info;
			}
			if ( confirm( confirm_text ) ) {
				form_saved = false;
				$( '#' + field.id() ).slideUp( function() {
					self.fields.remove( field );
				});
			}
		}

		this.edit_field_name = function( field ) {
			field.editing_name( true );
			form_saved = false;
		}

		this.stop_edit_field_name = function( field ) {
			field.editing_name( false );
			$( '.hb-input-field-name' ).blur();
			var new_id = get_unique_field_id( field.name() );
			if ( new_id ) {
				field.id( new_id );
			}
			form_saved = false;
		}

		function get_unique_field_id( name ) {
			return get_unique_id( name, self.fields() );
		}

		this.variables_list = ko.computed( function() {
			var fields = self.fields(),
				ids = [],
				j = 0;
			for ( var i = 0; i < fields.length; i++ ) {
				if ( fields[i].form_name == hb_form_name && fields[i].displayed() == 'yes' ) {
					if ( j % 3 == 0 ) {
						ids.push( '<br/>[' + fields[i].id() + ']' );
					} else {
						ids.push( '[' + fields[i].id() + ']' );
					}
					j++;
				}
			}
			return hb_text.variables_intro + ids.join( '&nbsp;&nbsp;-&nbsp;&nbsp;' );
		});

	}

	function get_unique_id( name, stack ) {
		var id_already_taken,
			id_candidate_max_length = 45,
			id_candidate = name.toLowerCase().replace( /\s/g, '_' ).replace( /[^a-z0-9_]+/g, '' ).substring( 0, id_candidate_max_length );
		if ( hb_form_name == 'contact' ) {
			id_candidate = 'contact_' + id_candidate;
		}
		for ( var i = 0; i < stack.length; i++ ) {
			if ( stack[i].id() == id_candidate ) {
				id_already_taken = true;
			}
		}
		if ( ! id_already_taken ) {
			return id_candidate;
		}
		for ( var id_num = 2; id_num < 100; id_num++ ) {
			id_already_taken = false;
			for ( var i = 0; i < stack.length; i++ ) {
				if ( stack[i].id() == id_candidate + '_' + id_num ) {
					id_already_taken = true;
				}
			}
			if ( ! id_already_taken ) {
				id_candidate += '_' + id_num;
				return id_candidate;
			}
		}
		return false;
	}

	ko.bindingHandlers.slideVisible = {
		init: function( element, valueAccessor ) {
			if ( valueAccessor()() == 'no' ) {
				$( element ).hide();
			}
		},
		update: function(element, valueAccessor) {
			if ( valueAccessor()() == 'no' ) {
				$( element ).slideUp();
			} else {
				$( element ).slideDown();
			}
		}
	};

	ko.bindingHandlers.sortable.options = { distance: 5 };

	var viewModel = new FieldsViewModel();

	ko.applyBindings( viewModel );

	//$( '.hb-form-fields-container .hb-form-field' ).show();

	$( '.hb-saved' ).html( hb_text.form_saved );

	$( '.hb-options-save' ).click( function() {
		$( this ).blur();
		var $save_section = $( this ).parent().parent();
		$save_section.find( '.hb-ajaxing' ).css( 'display', 'inline' );

		var data = {
			'nonce': $( '#hb_nonce_update_db' ).val(),
			'hb_fields': ko.toJSON( viewModel )
		}
		if ( hb_form_name == 'contact' ) {
			data['action'] = 'hb_update_contact';
			data['hb_contact_email'] = $( '#hb_contact_email' ).val();
			data['hb_contact_from'] = $( '#hb_contact_from' ).val();
			data['hb_contact_subject'] = $( '#hb_contact_subject' ).val();
			var contact_message_type = $( '[name="hb_contact_message_type"]:checked' ).val();
			if ( ! contact_message_type ) {
				contact_message_type = '';
			}
			data['hb_contact_message_type'] = contact_message_type;
			data['hb_contact_message'] = $( '#hb_contact_message' ).val();
		} else { // hb_form_name == 'booking'
			data['action'] = 'hb_update_forms';
			data['hb_maximum_adults'] = $( '#hb_maximum_adults' ).val();
			data['hb_maximum_children'] = $( '#hb_maximum_children' ).val();
			data['hb_display_adults_field'] = $( '[name="hb_display_adults_field"]:checked' ).val();
			data['hb_display_children_field'] = $( '[name="hb_display_children_field"]:checked' ).val();
			data['hb_search_form_placeholder'] = $( '[name="hb_search_form_placeholder"]:checked' ).val();
			data['hb_title_accom_link'] = $( '[name="hb_title_accom_link"]:checked' ).val();
			data['hb_thumb_display'] = $( '[name="hb_thumb_display"]:checked' ).val();
			data['hb_thumb_accom_link'] = $( '[name="hb_thumb_accom_link"]:checked' ).val();
			data['hb_search_accom_thumb_width'] = $( '#hb_search_accom_thumb_width' ).val();
			data['hb_search_accom_thumb_height'] = $( '#hb_search_accom_thumb_height' ).val();
			data['hb_button_accom_link'] = $( '[name="hb_button_accom_link"]:checked' ).val();
			data['hb_display_price'] = $( '[name="hb_display_price"]:checked' ).val();
			data['hb_display_price_breakdown'] = $( '[name="hb_display_price_breakdown"]:checked' ).val();
			data['hb_price_breakdown_default_state'] = $( '[name="hb_price_breakdown_default_state"]:checked' ).val();
			data['hb_display_detailed_accom_price'] = $( '[name="hb_display_detailed_accom_price"]:checked' ).val();
		}

		$.ajax({
			url: ajaxurl,
			type: 'POST',
			timeout: hb_ajax_settings.timeout,
			data: data,
			success: function( ajax_return ) {
				$save_section.find( '.hb-ajaxing' ).css( 'display', 'none' );
				if ( ajax_return.trim() != 'settings saved' ) {
					alert( ajax_return );
				} else {
					form_saved = true;
					$save_section.find( '.hb-saved' ).show();
					setTimeout( function() {
						$save_section.find( '.hb-saved ' ).fadeOut();
					}, 4000 );
				}
			},
			error: function( jqXHR, textStatus, errorThrown ) {
				$save_section.find( '.hb-ajaxing' ).css( 'display', 'none' );
				alert( 'Connection error: ' + textStatus + ' (' + errorThrown + ')' );
			}
		});

		return false;
	});

	var form_saved = true;

	if ( hb_form_name == 'booking' ) {
		$( '#hb-admin-forms-options' ).on( 'change', 'input, select', function() {
			form_saved = false;
		});
	}

	window.onbeforeunload = function() {
		if ( ! form_saved ) {
			return hb_text.unsaved_warning;
		}
	}

});