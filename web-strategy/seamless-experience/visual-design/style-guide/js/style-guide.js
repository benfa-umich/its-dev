	$( window ).bind( "create.xrayhtml", function( e ) {
		var prism = !!~e.target.getAttribute( "class" ).indexOf( "prism" );

		if( prism && "Prism" in window ) {
			$( ".prism" ).find( "code" ).addClass( "language-markup" );
			Prism.highlightAll();
		}
	});
