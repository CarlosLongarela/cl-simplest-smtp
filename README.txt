=== CL Simplest SMTP ===
Contributors: carloslongarela
Tags: system, debug, mail, smtp
Donate link: https://www.paypal.me/CarlosLongarela
Requires at least: 5.0
Tested up to: 6.7.1
Requires PHP: 7.4
Stable tag: 1.0.5
License: GPL2+
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Send mails throught SMTP server. Simplest option to send mail when hosting or server do not permits send mail or is missconfigured.

== Description ==
![WordPress Plugin Downloads](https://img.shields.io/wordpress/plugin/dt/cl-simplest-smtp.svg)
Send mails throught SMTP server. Simplest option to send mail when hosting or server do not permits send mail or is missconfigured.
We also could to check the SMTP options and check the native PHP mail.

== Installation ==
1 - CL Simplest SMTP can be installed directly through your WordPress Plugins dashboard.
2 - Click "Add New" and Search for "CL Simplest SMTP"
3 - Install and Activate

== Frequently Asked Questions ==
### This plugin adds any options to my database?
If you configure the plugin with constants in your `wp-config.php` file (see next FAQ), this plugin does not add any data to your database. This is the fastest option because the mail does not need to check data from your database.

If you configure the options from the WordPress admin panel, the plugin will save only one array of options in your database with all the SMTP parameters. The options saved in your database (`wp_options` table) is `cl_simplest_smtp_options`.

### Configure plugin with constants.
Configure plugin with constants is the fastest option and also avoids database queries.

We must set these constants in our `wp-config.php` file:

`define( 'CL_SIMPLEST_SMTP_HOST', 'your-smtp-host' );` // SMTP server
`define( 'CL_SIMPLEST_SMTP_AUTH', true );` // enable SMTP authentication
`define( 'CL_SIMPLEST_SMTP_PORT', 587 );` // set the SMTP port
`define( 'CL_SIMPLEST_SMTP_USER', 'your-smtp@user' );` // SMTP account username
`define( 'CL_SIMPLEST_SMTP_PASS', 'your-smtp-password' );` // SMTP account password
`define( 'CL_SIMPLEST_SMTP_SECURE', 'tls' );` // To use STARTTLS: 'tls'; To use SSL: 'ssl';
`define( 'CL_SIMPLEST_SMTP_FROM', 'your-smtp-sender@email' );` // SMTP from email
`define( 'CL_SIMPLEST_SMTP_NAME', 'Your Sender Name' );` // SMTP from name

This option is the optimal for security.

### This plugin will slow down my WordPress?
No. This plugin is very lightweight and only adds one CSS file if you are in the WordPress SMTP options page `/wp-admin/options-general.php?page=cl-simplest-smtp` and does not add anything to any other pages or on the frontend.

Only adds one database option (first FAQ) with an array of 8 short values and nothing if you configure it with constants in your `wp-config.php` file (the best option for speed and security).

### Can I hide the "Invite me to a coffe" button?
Yes, of course. You must to define the constant `CL_SIMPLEST_SMTP_HIDE_DONATE` as `true`in your `wp-config.php` file and the button will fly out ;)

`define( 'CL_SIMPLEST_SMTP_HIDE_DONATE', true );`

But you can invite me to that coffee at any time from https://www.paypal.com/donate/?hosted_button_id=V6U6ZLFHNE6N4

### How can I tell you about a bug, ask for a functionality or contribute to the plugin?
The plugin development of this plugin is managed in this GitHub repository https://github.com/CarlosLongarela/cl-simplest-smtp

You can send us issues, requests or any comments to https://github.com/CarlosLongarela/cl-simplest-smtp/issues or create a pull request to contribute with any new bug fix, functionality or any other code change.

== Upgrade Notice ==
Upgrade plugin from WordPress public repository or uploading the plugin zip file from WordPress admin panel -> Plugins -> Add new plugin.

== Screenshots ==
1. SMTP save options
2. SMTP config file options

== Changelog ==
= 1.0.5 - 2025-01-17 =
* Improved: Changed selectors to option fields on the test mailing page.

= 1.0.4b - 2025-01-04 =
* Improved: New screenshot on WordPress website and added two new FAQs

= 1.0.4 - 2025-01-04 =
* Improved: Added airmail envelope border appearance to settings.
* Improved: Delete options from the database on plugin uninstall.
* Improved: Show error messages when sending fails in the Check Mail option.
* Improved: Added default mail to send in tests, obtained from WordPress admin email.
* Fix: Added charset on text/plain test mails and MIME version.

= 1.0.3 - 2025-01-04 =
* Improved: Show the mail test options in a details HTML tag and added CSS to the options screen to improve presentation.

= 1.0.2 - 2024-12-31 =
* Fix: readme.txt typo error.

= 1.0.1 - 2024-12-31 =
* Info: Updated readme.txt file.

= 1.0.0 - 2024-12-31 =
* Info: Initial release.
