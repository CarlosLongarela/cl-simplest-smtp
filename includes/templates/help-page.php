<?php
/**
 * The template for the help page of the CL Simplest SMTP plugin.
 *
 * @package CL\Simplest_SMTP
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Code is Poetry, but you are not an poet ;)' );
}
?>

<div id="cl-smtp-help-page" class="cl-smtp-help-page cl-airmail-border">
	<details>
		<summary><h2> <?php esc_html_e( 'This plugin adds any options to my database?', 'cl-simplest-smtp' ); ?></h2></summary>
		<div class="cl-details-content">
			<p>
				<?php esc_html_e( 'If you configure the plugin with constants in your wp-config.php file (see next question), this plugin does not add any data to your database. This is the fastest option because the mail does not need to check data from your database.', 'cl-simplest-smtp' ); ?>
			</p>
		</div>
	</details>

	<details>
		<summary><h2> <?php esc_html_e( 'Configure plugin with constants.', 'cl-simplest-smtp' ); ?></h2></summary>
		<div class="cl-details-content">
			<p>
				<?php esc_html_e( 'Configure plugin with constants is the fastest option and also avoids database queries.', 'cl-simplest-smtp' ); ?>
			</p>

			<p>
				<?php
				// translators: %1: <code>, %2: </code>
				printf( esc_html__( 'We must set these constants in our %swp-config.php%s file:', 'cl-simplest-smtp' ), '<code>', '</code>' ); ?>
			</p>

			<pre><code>
				define( 'CL_SIMPLEST_SMTP_HOST', 'your-smtp-host' ); // SMTP server
				define( 'CL_SIMPLEST_SMTP_AUTH', true ); // enable SMTP authentication
				define( 'CL_SIMPLEST_SMTP_PORT', 587 ); // set the SMTP port
				define( 'CL_SIMPLEST_SMTP_USER', 'your-smtp@user' ); // SMTP account username
				define( 'CL_SIMPLEST_SMTP_PASS', 'your-smtp-password' ); // SMTP account password
				define( 'CL_SIMPLEST_SMTP_SECURE', 'tls' ); // To use STARTTLS: 'tls'; To use SSL: 'ssl';
				define( 'CL_SIMPLEST_SMTP_FROM', 'your-smtp-sender@email' ); // SMTP from email
				define( 'CL_SIMPLEST_SMTP_NAME', 'Your Sender Name' ); // SMTP from name
			</code></pre>

			<p>
				<?php esc_html_e( 'This option is the optimal for security.', 'cl-simplest-smtp' ); ?>
			</p>
		</div>
	</details>

	<details>
		<summary><h2> <?php esc_html_e( 'This plugin will slow down my WordPress?', 'cl-simplest-smtp' ); ?></h2></summary>

		<div class="cl-details-content">
			<p>
				<?php esc_html_e( 'No. This plugin is very lightweight and only adds one CSS file if you are in the WordPress SMTP options page <code>/wp-admin/options-general.php?page=cl-simplest-smtp</code> and does not add anything to any other pages or on the frontend.', 'cl-simplest-smtp' ); ?>
			</p>

			<p>
				<?php
				// translators: %s: <code>, %s: </code>
				printf( esc_html__( 'Only adds one database option (first FAQ) with an array of 8 short values and nothing if you configure it with constants in your %swp-config.php%s file (the best option for speed and security).', 'cl-simplest-smtp' ), '<code>', '</code>' ); ?>
			</p>
		</div>
	</details>

	<details>
		<summary><h2> <?php esc_html_e( 'Can I hide the "Invite me to a coffe" button?', 'cl-simplest-smtp' ); ?></h2></summary>

		<div class="cl-details-content">
			<p>
				<?php
				// translators: %s: <code>, %s: </code>, %s: <code>, %s: </code>, %s: <code>, %s: </code>
				printf( esc_html__( 'Yes, of course. You must to define the constant %sCL_SIMPLEST_SMTP_HIDE_DONATE%s as %strue%s in your %swp-config.php%s file and the button will fly out ;)', 'cl-simplest-smtp' ), '<code>', '</code>', '<code>', '</code>', '<code>', '</code>' ); ?>
			</p>

			<p>
				<code>
					define( 'CL_SIMPLEST_SMTP_HIDE_DONATE', true );
				</code>
			</p>

			<p>
				<?php
				// translators: %s: <a>, %s: </a>
				printf( esc_html__( 'But you can invite me to that coffee at any time from %shttps://www.paypal.com/donate/?hosted_button_id=V6U6ZLFHNE6N4%s', 'cl-simplest-smtp' ), '<a href="https://www.paypal.com/donate/?hosted_button_id=V6U6ZLFHNE6N4" target="_blank">', '</a>' ); ?>
			</p>
		</div>
	</details>

	<details>
		<summary><h2> <?php esc_html_e( 'How can I tell you about a bug, ask for a functionality or contribute to the plugin?', 'cl-simplest-smtp' ); ?></h2></summary>

		<div class="cl-details-content">
			<p>
				<?php
				// translators: %s: <a>, %s: </a>
				printf( esc_html__( 'The plugin development of this plugin is managed in this GitHub repository %shttps://github.com/CarlosLongarela/cl-simplest-smtp%s', 'cl-simplest-smtp' ), '<a href="https://github.com/CarlosLongarela/cl-simplest-smtp" target="_blank">', '</a>' ); ?>
			</p>

			<p>
				<?php
				// translators: %s: <a>, %s: </a>
				printf( esc_html__( 'You can send us issues, requests or any comments to %shttps://github.com/CarlosLongarela/cl-simplest-smtp/issues%s or create a pull request to contribute with any new bug fix, functionality or any other code change.', 'cl-simplest-smtp' ), '<a href="https://github.com/CarlosLongarela/cl-simplest-smtp/issues" target="_blank">', '</a>' ); ?>
			</p>
		</div>
	</details>

</div>
