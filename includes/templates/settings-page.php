<?php
/**
 * The template for the settings page of the CL Simplest SMTP plugin.
 *
 * @package CL\Simplest_SMTP
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Code is Poetry, but you are not an poet ;)' );
}

$options = get_option( 'cl_simplest_smtp_options' );

if ( ! is_array( $options ) ) {
	$options = array(
		'host'   => '',
		'auth'   => false,
		'port'   => '',
		'user'   => '',
		'pass'   => '',
		'secure' => '',
		'from'   => '',
		'name'   => '',
	);
}

?>
<div class="cl-smtp-settings-page cl-airmail-border">
	<h2><?php esc_html_e( 'SMTP settings', 'cl-simplest-smtp' ); ?>:</h2>

	<form method="post" action="options.php">
		<?php settings_fields( 'cl_simplest_smtp_options_group' ); ?>
		<table class="form-table">
			<tr>
				<th>
					<?php esc_html_e( 'Host', 'cl-simplest-smtp' ); ?>:
				</th>
				<td>
					<input type="text" name="cl_simplest_smtp_options[host]" value="<?php echo esc_attr( $options['host'] ); ?>" placeholder="smtp.test.null" required class="regular-text" />
				</td>
			</tr>
			<tr>
				<th>
					<?php esc_html_e( 'Secure connection type', 'cl-simplest-smtp' ); ?>:
				</th>
				<td>
					<select name="cl_simplest_smtp_options[secure]">
						<option value="ssl" <?php selected( $options['secure'], 'ssl' ); ?>><?php esc_html_e( 'SSL', 'cl-simplest-smtp' ); ?></option>
						<option value="tls" <?php selected( $options['secure'], 'tls' ); ?>><?php esc_html_e( 'TLS', 'cl-simplest-smtp' ); ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th>
					<?php esc_html_e( 'Port', 'cl-simplest-smtp' ); ?>:
				</th>
				<td>
					<input type="number" name="cl_simplest_smtp_options[port]" value="<?php echo esc_attr( $options['port'] ); ?>" class="regular-text" placeholder="465" required autocomplete="off" />
				</td>
			</tr>
			<tr>
				<th>
					<?php esc_html_e( 'Authenticate connection', 'cl-simplest-smtp' ); ?>:
				</th>
				<td>
					<select name="cl_simplest_smtp_options[auth]">
						<option value="1" <?php selected( $options['auth'], true ); ?>><?php esc_html_e( 'Yes', 'cl-simplest-smtp' ); ?></option>
						<option value="0" <?php selected( $options['auth'], false ); ?>><?php esc_html_e( 'No', 'cl-simplest-smtp' ); ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th>
					<?php esc_html_e( 'SMTP User', 'cl-simplest-smtp' ); ?>:
				</th>
				<td>
					<input type="text" name="cl_simplest_smtp_options[user]" value="<?php echo esc_attr( $options['user'] ); ?>" class="regular-text" placeholder="smptuser@fakedomain.null" autocomplete="off" />
				</td>
			</tr>
			<tr>
				<th>
					<?php esc_html_e( 'SMTP Pass', 'cl-simplest-smtp' ); ?>:
				</th>
				<td>
					<input type="password" name="cl_simplest_smtp_options[pass]" value="<?php echo esc_attr( $options['pass'] ); ?>" class="regular-text" placeholder="youruserfakepass" autocomplete="off" />
				</td>
			</tr>
			<tr>
				<th>
					<?php esc_html_e( 'From Email', 'cl-simplest-smtp' ); ?>:
				</th>
				<td>
					<input type="email" name="cl_simplest_smtp_options[from]" value="<?php echo esc_attr( $options['from'] ); ?>" class="regular-text" placeholder="manolito@guorpresser.null" autocomplete="off" />
				</td>
			</tr>
			<tr>
				<th>
					<?php esc_html_e( 'From Name', 'cl-simplest-smtp' ); ?>:
				</th>
				<td>
					<input type="text" name="cl_simplest_smtp_options[name]" value="<?php echo esc_attr( $options['name'] ); ?>" class="regular-text" placeholder="Manolito Guorpresser" autocomplete="off" />
				</td>
			</tr>
		</table>
		<?php submit_button( __( 'Save SMTP data', 'cl-simplest-smtp' ) ); ?>
	</form>
</div>
