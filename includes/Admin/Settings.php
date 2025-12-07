<?php

namespace LLMSTxt\Admin;

/**
 * Handles the Admin UI and Settings Page.
 */
class Settings {

	/**
	 * The ID of this plugin.
	 *
	 * @var string
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @var string
	 */
	private $version;
	
	/**
	 * Sanitizer instance.
	 * 
	 * @var Sanitizer
	 */
	private $sanitizer;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string    $plugin_name The name of this plugin.
	 * @param string    $version     The version of this plugin.
	 * @param Sanitizer $sanitizer   The sanitizer instance.
	 */
	public function __construct( $plugin_name, $version, $sanitizer ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->sanitizer   = $sanitizer;
	}

	/**
	 * Register the admin menu.
	 */
	public function register_admin_page() {
		add_options_page(
			__( 'LLMS.txt Manager', 'llms-txt-generator' ),
			__( 'LLMS.txt', 'llms-txt-generator' ),
			'manage_options',
			'llms-txt-settings',
			array( $this, 'render_admin_page' )
		);
	}

	/**
	 * Register the settings and reference the Sanitizer.
	 */
	public function register_settings() {
		register_setting(
			'llms_txt_group',
			'llms_txt_content',
			array(
				'type'              => 'string',
				'sanitize_callback' => array( $this->sanitizer, 'sanitize_content' ),
				'default'           => '',
				'capability'        => 'manage_options', // Explicit capability check.
			)
		);
	}

	/**
	 * Render the settings page.
	 */
	public function render_admin_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'LLMS.txt Generator', 'llms-txt-generator' ); ?></h1>
			<form action="options.php" method="post">
				<?php
				settings_fields( 'llms_txt_group' );
				
				$content = get_option( 'llms_txt_content', '' );
				?>
				<table class="form-table" role="presentation">
					<tbody>
						<tr>
							<th scope="row">
								<label for="llms_txt_content"><?php esc_html_e( 'Content', 'llms-txt-generator' ); ?></label>
							</th>
							<td>
								<textarea 
									name="llms_txt_content" 
									id="llms_txt_content" 
									rows="15" 
									cols="50" 
									class="large-text code"
									placeholder="<?php esc_attr_e( 'Enter your llms.txt content here...', 'llms-txt-generator' ); ?>"
								><?php echo esc_textarea( $content ); ?></textarea>
								<p class="description">
									<?php esc_html_e( 'Enter the raw text content for your llms.txt file. HTML tags will be automatically stripped.', 'llms-txt-generator' ); ?>
									<br>
									<a href="<?php echo esc_url( home_url( '/llms.txt' ) ); ?>" target="_blank"><?php esc_html_e( 'View current llms.txt', 'llms-txt-generator' ); ?></a>
								</p>
							</td>
						</tr>
					</tbody>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}
}
