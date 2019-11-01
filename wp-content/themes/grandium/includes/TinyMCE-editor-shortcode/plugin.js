tinymce.PluginManager.add('ninethemeShortcodes', function(ed, url) {

    // Add a button that opens a window
    ed.addButton('ninetheme_button', {
        type: 'splitbutton',
        text: '',
        icon: 'settings',
        tooltip: 'Ninetheme Shortcodes',        
        menu:   [
                    {
                        text: 'Default Calendar',
                        onclick: function() {
                            ed.insertContent('[booked-calendar]');
                        }
                    },
                    {
                        text: 'List Calendar',
                        onclick: function() {
                            ed.insertContent('[booked-calendar style="list"]');
                        }
                    },
                    {
                        text: 'Time Calendar',
                        onclick: function() {
                            ed.insertContent('[booked-calendar year="2016" month="3" day="15"]');
                        }
                    },
                    {
                        text: 'Specific  Calendar',
                        onclick: function() {
                            ed.insertContent('[booked-calendar calendar="2"]');
                        }
                    },
                    {
                        text: 'Small  Calendar',
                        onclick: function() {
                            ed.insertContent('[booked-calendar size="small"]');
                        }
                    },
                    {
                        text: 'Members Only Calendar',
                        onclick: function() {
                            ed.insertContent('[booked-calendar members-only="true"]');
                        }
                    },
                    {
                        text: 'Booked Profile',
                        onclick: function() {
                            ed.insertContent('[booked-profile]');
                        }
                    },
                    {
                        text: 'Booked Login',
                        onclick: function() {
                            ed.insertContent('[booked-login]');
                        }
                    },
                    {
                        text: 'Booked Appointments',
                        onclick: function() {
                            ed.insertContent('[booked-appointments]');
                        }
                    },
                    {
                        text: 'HBOOK Hotel Booking Form',
                        onclick: function() {
                            ed.insertContent('[hb_booking_form]');
                        }
                    },
                ],
    });

});