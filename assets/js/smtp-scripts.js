// Accordion for the help page: when a details element is opened, close the other ones.
const cl_smtp_help_page = document.getElementById( 'cl-smtp-help-page' );

if ( cl_smtp_help_page ) {
	const cl_smtp_help_details = cl_smtp_help_page.querySelectorAll( 'details' );

	cl_smtp_help_details.forEach( ( detail ) => {
		detail.addEventListener( 'toggle', () => {
			if ( ! detail.open ) {
				return;
			}

			cl_smtp_help_details.forEach( ( other ) => {
				if ( other !== detail ) {
					other.removeAttribute( 'open' );
				}
			} );
		} );
	} );
}
