=== CL Simplest SMTP ===
Contributors: carloslongarela
Tags: system, debug, mail, smtp
Donate link: https://www.paypal.me/CarlosLongarela
Requires at least: 5.0
Tested up to: 6.7.1
Requires PHP: 7.4
Stable tag: 1.0.0
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
### Configure plugin with contstants.
Configure plugin with constants is the fastest option and also avoid database queries.

We must set these constants in our `wp-config.php` file:

define( 'CL_SIMPLEST_SMTP_HOST', 'your-smtp-host' );
define( 'CL_SIMPLEST_SMTP_AUTH', true );
define( 'CL_SIMPLEST_SMTP_PORT', 587 );
define( 'CL_SIMPLEST_SMTP_USER', 'your-smtp@user' );
define( 'CL_SIMPLEST_SMTP_PASS', 'your-smtp-password' );
define( 'CL_SIMPLEST_SMTP_SECURE', 'tls' );
define( 'CL_SIMPLEST_SMTP_FROM', 'your-smtp-sender@email' );
define( 'CL_SIMPLEST_SMTP_NAME', 'Your Sender Name' );

== Upgrade Notice ==
Upgrade plugin from WordPress public repository or uploading the plugin zip file from WordPress admin panel -> Plugins -> Add new plugin.

== Screenshots ==
1. SMTP save options
2. SMTP config file options

== Changelog ==
= 1.0.0 - 2024-12-31 =
* Info: Initial release.
