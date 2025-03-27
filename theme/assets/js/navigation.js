/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens.
 */
( function() {
    console.log('navigation.js');
	const siteNavigation = document.getElementById( 'site-navigation' );

	// Return early if the navigation doesn't exist.
	if ( ! siteNavigation ) {
		return;
	}

	const button = siteNavigation.querySelector( '.menu-toggle' );

	// Return early if the button doesn't exist.
	if ( ! button ) {
		return;
	}

	const menu = siteNavigation.getElementsByTagName( 'ul' )[ 0 ];

	// Hide menu toggle button if menu is empty and return early.
	if ( ! menu ) {
		button.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );

	button.addEventListener( 'click', function() {
		siteNavigation.classList.toggle( 'toggled' );

		if ( siteNavigation.classList.contains( 'toggled' ) ) {
			button.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );
		} else {
			button.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );
		}
	} );
} )();