<?php
class HbAdminPageLangfiles extends HbAdminPage {

	private $langs;

	public function __construct( $page_id, $hbdb, $utils, $options_utils ) {
		$this->langs = $utils->get_langs();
		$this->data = array(
			'hb_text' => array(
				'select_language' => esc_html__( 'Select a language.', 'hbook-admin' ),
				'choose_file' => esc_html__( 'Choose a file to import.', 'hbook-admin' ),
			)
		);
		parent::__construct( $page_id, $hbdb, $utils, $options_utils );
	}

	public function display() {
	?>

	<div class="wrap">

		<h2><?php esc_html_e( 'Languages (Import / Export language files)', 'hbook-admin' ); ?></h2>
		<?php $this->display_right_menu(); ?>

		<?php
		if (
			isset( $_POST['hb-import-export-action'] ) &&
			( $_POST['hb-import-export-action'] == 'import-lang' ) &&
			wp_verify_nonce( $_POST['hb_import_export'], 'hb_import_export' ) &&
			current_user_can( 'manage_options' )
		) {
			$import_file = $_FILES['hb-import-lang-file']['tmp_name'];
			$file_content = file_get_contents( $import_file );
			$re_id = "/msgid\\s*\"(.*)\"/";
			$re_str = "/msgstr\\s*\"(.*)\"/";
			preg_match_all( $re_id, $file_content, $matches_id );
			preg_match_all( $re_str, $file_content, $matches_str );
			$ids = $matches_id[1];
			$strings = $matches_str[1];
			if (
				( count( $ids ) == 0 ) ||
				( count( $ids ) != count( $strings ) ) ||
				! ( in_array( 'default_form_title', $ids ) )
			) {
			?>
				<div class="error">
					<p><?php esc_html_e( 'The language file is not valid.', 'hbook-admin' ); ?></p>
				</div>
			<?php
			} else {
				$strings_to_db = array();
				$nb_valid_ids = 0;
				$valid_ids = array_keys( $this->utils->get_string_list() );
				for ( $i = 0; $i < count( $ids ); $i++ ) {
					if ( in_array( $ids[ $i ], $valid_ids ) ) {
						$new_string = array(
							'id' => $ids[ $i ],
							'value' => $strings[ $i ],
							'locale' => $_POST['hb-import-lang-code']
						);
						$strings_to_db[] = $new_string;
						$nb_valid_ids++;
					}
				}
				$this->hbdb->update_strings( $strings_to_db );
			?>
				<div class="updated">
					<p><?php printf( esc_html__( 'The import was successful (%d strings have been imported).', 'hbook-admin' ), $nb_valid_ids ); ?></p>
				</div>
			<?php
			}
		}
		?>

		<hr/>

		<h3><?php esc_html_e( 'Import a file', 'hbook-admin' ); ?></h3>
		<form id="hb-import-file-form" method="post" enctype="multipart/form-data">
			<p>
				<label><?php esc_html_e( 'Language', 'hbook-admin' ); ?></label><br/>
				<?php
				$select_lang_options = '<option value=""></option>';
				foreach ( $this->langs as $locale => $lang_name ) {
					$select_lang_options .= '<option value="' . $locale . '">' . $lang_name . ' (' . $locale . ')</option>';
				}
				$select_lang = '<select id="hb-import-lang-code" name="hb-import-lang-code">' . $select_lang_options . '</select>';
				$allowed_html = array(
					'select' => array(
						'id' => array(),
						'name' => array()
					),
					'option' => array(
						'value' => array()
					)
				);
				echo( wp_kses( $select_lang, $allowed_html ) );
				?>
			</p>
			<p>
				<input id="hb-import-lang-file" type="file" name="hb-import-lang-file" />
			</p>
			<p>
				<input id="hb-import-lang-submit" type="submit" class="button-primary" value="<?php esc_attr_e( 'Import', 'hbook-admin' ); ?>" />
			</p>
			<input type="hidden" name="hb-import-export-action" value="import-lang" />
			<?php wp_nonce_field( 'hb_import_export', 'hb_import_export' ); ?>
		</form>

		<hr/>

		<h3><?php esc_html_e( 'Export a file', 'hbook-admin' ); ?></h3>
		<p>
			<?php
			foreach ( $this->langs as $locale => $lang_name ) {
			?>
			<a href="#" class="hb-export-lang-file" data-locale="<?php echo( esc_attr( $locale ) ); ?>"><?php echo( wp_kses_post( $lang_name . ' (' . $locale . ')' ) ); ?></a>
			<br/>
			<?php
			}
			?>
		</p>

		<form id="hb-export-lang-form" method="POST">
			<input type="hidden" name="hb-import-export-action" value="export-lang" />
			<input id="hb-locale-export" type="hidden" name="hb-locale-export" />
			<?php wp_nonce_field( 'hb_import_export', 'hb_import_export' ); ?>
		</form>

	</div><!-- end .wrap -->

	<?php
	}
}