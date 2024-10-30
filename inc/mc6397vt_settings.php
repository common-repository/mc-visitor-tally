<?php

// Settings Page: MC Visitor Tally
class mcvisitortally_Settings_Page {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'wph_create_settings' ) );
		add_action( 'admin_init', array( $this, 'wph_setup_sections' ) );
		add_action( 'admin_init', array( $this, 'wph_setup_fields' ) );
	}

	public function wph_create_settings() {
		$page_title = 'MC Visitor Tally';
		$menu_title = 'MC Visitor Tally';
		$capability = 'manage_options';
		$slug = 'mcvisitortally';
		$callback = array($this, 'wph_settings_content');
		add_options_page($page_title, $menu_title, $capability, $slug, $callback);
	}

	public function wph_settings_content() { ?>
		<div class="wrap">
		 <img src="<?php echo plugin_dir_url( __DIR__ ) . 'assets/MC-VT-Head.jpg'; ?>">
			<h1>MC Visitor Tally Settings</h1>
			<h3>Add tallies to website pages with the shortcode [mcvt-visitor-tally] or the widget "MC Visitor Tally".</h3>

			<?php settings_errors(); ?>
			<form method="POST" action="options.php">
				<?php
					settings_fields( 'mcvisitortally' );
					do_settings_sections( 'mcvisitortally' );
					submit_button();

	echo "<span style = 'font-size: 14px'>";
	echo "Note: Dates change on this plugin at midnight, based on the time zone you have set in your website.<br>
	This website is set for the time zone: ";
	$mc6397vt_timeZone = ( get_option( 'timezone_string' ) );
	echo "<strong>$mc6397vt_timeZone</strong>.<br>" ;
	echo "When this page loaded, your website time was ";
	echo "<strong>" . current_time( 'g:i A')  . '</strong><br>';
	echo "To re-set the time zone for this website, go to you website's General Settings and adjust the Timezone.";
	echo "</span>";

				?>
			</form>
		</div> <?php
	}

	public function wph_setup_sections() {
		add_settings_section( 'mcvisitortally_section', '', array(), 'mcvisitortally' );
	}

	public function wph_setup_fields() {
		$fields = array(

			array(
				'label' => 'Show Month-to-Month comparisons on the Admin Dashboard Widget?',
				'id' => 'mc6397vt_showmonths',
				'type' => 'select',
				'section' => 'mcvisitortally_section',
				'options' => array(
					'Yes' => 'Yes',
					'No' => 'No',
				),
				'desc' => 'Do you want to include month-to-month visitor numbers on your dashboard widget?<br>You can turn off this feature. Your basic Admin Dashboard Widget will remain on the dashboard.',
				'placeholder' => 'Yes',
			),

			array(
				'label' => 'Onlne Tables: Stripes? Borders?',
				'id' => 'mc6397vt_table_type',
				'type' => 'select',
				'section' => 'mcvisitortally_section',
				'options' => array(
					'table-borderless' => 'Plain, No Borders',
					'table-bordered' => 'Plain, with Borders',
					'table-striped' => 'Alternating Stripes, no Borders',
					'table-striped table-bordered' => 'Alternating Stripes with Borders',

				),
				'desc' => 'Do you want the tables plain or striped? With borders or without?.<br/>Note: Themes interpret tables differently. Experiment with this to find what works best for you.',
				'placeholder' => 'Plain, No Borders',
			),

			array(
				'label' => 'Online Tables: Background Color',
				'id' => 'mc6397vt_table_color',
				'type' => 'select',
				'section' => 'mcvisitortally_section',
				'options' => array(
					'' => 'Neutral (Matches Website)',
					'table-primary' => 'Blue',
					'table-info' => 'Blue (lighter)',
					'table-secondary' => 'Gray',
					'table-active' => 'Gray (lighter)',
					'table-success' => 'Green',
					'table-warning' => 'Orange',
					'table-danger' => 'Red',
					'table-light' => 'Near White',
					'table-dark' => 'Near Black',
				),
				'desc' => 'Neutral is , matching the website page. Background colors work on most themes.',
				'placeholder' => 'Neutral',
			),

			array(
				'label' => 'Online Tables: Responsive? Size?',
				'id' => 'mc6397vt_table_resp',
				'type' => 'select',
				'section' => 'mcvisitortally_section',
				'options' => array(
					'table-sm' => 'Not Responsive, Compact Size',
					'' => 'Not Responsive, Normal Size',
					'table-responsive table-sm' => 'Responsive, Compact Size',
					'table-responsive' => 'Responsive, Normal Size',
					'table-responsive table-lg' => 'Responsive, Larger Size',
				),
				'desc' => 'This may determine whether the table fits the space or just what it needs. <br/> Again, your theme or page builder may interpret bootstrap tables to meet its own needs.',
				'placeholder' => 'Not Responsive, Compact Size',
			),

			array(
				'label' => 'Show year-to-date numbers on the website tallies?',
				'id' => 'mc6397vt_showyear',
				'type' => 'select',
				'section' => 'mcvisitortally_section',
				'options' => array(
					'Yes' => 'Yes',
					'No' => 'No',
				),
				'desc' => 'If using the shortcode and/or widget, do you want website users to see visitor numbers for the current year?<br>You may want to turn it off until a new year starts if you intalled this plugin mid-year.',
				'placeholder' => 'Yes',
			),

			array(
				'label' => 'Delete the database table and options when the plugin is deleted?',
				'id' => 'mc6397vt_deleteTable',
				'type' => 'select',
				'section' => 'mcvisitortally_section',
				'options' => array(
					'Yes' => 'Yes',
					'No' => 'No',
				),
				'desc' => 'Usually, the plugins database table and saved options are deleted when the plugin is deleted.<br> If you intend to re-install this plugin soon, you may select "No" to save the visitor data.',
				'placeholder' => 'Yes',
			),
		);
		foreach( $fields as $field ){
			add_settings_field( $field['id'], $field['label'], array( $this, 'wph_field_callback' ), 'mcvisitortally', $field['section'], $field );
			register_setting( 'mcvisitortally', $field['id'] );
		}
	}

	public function wph_field_callback( $field ) {
		$value = get_option( $field['id'] );
		$placeholder = '';
		if ( isset($field['placeholder']) ) {
			$placeholder = $field['placeholder'];
		}
		switch ( $field['type'] ) {
				case 'select':
				case 'multiselect':
					if( ! empty ( $field['options'] ) && is_array( $field['options'] ) ) {
						$attr = '';
						$options = '';
						foreach( $field['options'] as $key => $label ) {
							$options.= sprintf('<option value="%s" %s>%s</option>',
								$key,
								selected($value, $key, false),
								$label
							);
						}
						if( $field['type'] === 'multiselect' ){
							$attr = ' multiple="multiple" ';
						}
						printf( '<select name="%1$s" id="%1$s" %2$s>%3$s</select>',
							$field['id'],
							$attr,
							$options
						);
					}
					break;
			default:
				printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />',
					$field['id'],
					$field['type'],
					$placeholder,
					$value
				);
		}
		if( isset($field['desc']) ) {
			if( $desc = $field['desc'] ) {
				printf( '<p class="description">%s </p>', $desc );
			}
		}
	}
}
new mcvisitortally_Settings_Page();
