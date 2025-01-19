// CReate a funtion that close all details in the help page when we open a new one, with vanilla javascript
const cl_smtp_help_page    = document.getElementById( 'cl-smtp-help-page' );
const cl_smtp_help_details = cl_smtp_help_page.querySelectorAll( 'details' );

function cl_close_all_details() {
	cl_smtp_help_details.forEach( detail => {
		detail.removeAttribute( 'open' );
	} );
}

cl_smtp_help_details.forEach( detail => {
	detail.addEventListener( 'click', ( event ) => {
		cl_close_all_details();
	} );
} );
