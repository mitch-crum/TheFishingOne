//JS 
// Data Arrays
  
var monthList = [
    "January", "February", "March", "April", "May", "June", "July", "August", "September", "November", "December"
];
var stateListLong = [
    "Alabama", "Alaska", "Arizona", "Arkansas", "California", "Colorado", "Connecticut", "Delaware", "Florida", "Georgia", "Hawaii", "Idaho", "Illinois", "Indiana", "Iowa", "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland", "Massachusetts", "Michigan", "Minnesota", "Mississippi", "Missouri", "Montana", "Nebraska", "Nevada", "New Hampshire", "New Jersey", "New Mexico", "New York", "North Carolina", "North Dakota", "Ohio", "Oklahoma", "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", "South Dakota", "Tennessee", "Texas", "Utah", "Vermont", "Virginia", "Washington", "West Virginia", "Wisconsin", "Wyoming", "District of Columbia", "Puerto Rico", "Guam", "American Samoa", "U.S. Virgin Islands", "Northern Mariana Islands"
];


// On Page Load
$( document).ready( function( ) {
	// Fill Month Selector
	for( var i = 0; i < monthList.length; i++) {
		$( "#monthSelector").append( "<option value=\"" + monthList[ i].toLowerCase() + "\">" + monthList[ i] + "</option>");
	}
	// Fill State Selector
	for( var i = 0; i < stateListLong.length; i++) {
		$( "#stateSelector").append( "<option value=\"" + stateListLong[ i].toLowerCase() + "\">" + stateListLong[ i] + "</option>");
	}
	// Fill Countries
	$( "#countrySelector").append( "<option value=\"US\">United States</option>");
	$( "#countrySelector").append( "<option value=\"CA\">Canada</option>");
	 // On country change
	 var saveState = "";
	$( "#countrySelector").change( function( ) {
		if ( $("#countrySelector").val( ) !== "US") {
			$( "#stateSelector").attr( "disabled", "disabled");
			saveState = $( "#stateSelector").val( );
			$( "#stateSelector").val( "");
		}
		else {
			$( "#stateSelector").removeAttr( "disabled");
			$( "#stateSelector").val( saveState);
		}
	});
 });
  