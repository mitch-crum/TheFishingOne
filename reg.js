//JS jQuery
// Data Arrays

var monthList = [
    "January", "February", "March", "April", "May", "June", "July", "August", "September", "November", "December"
];
var stateListLong = [
    "Alabama", "Alaska", "Arizona", "Arkansas", "California", "Colorado", "Connecticut", "Delaware", "Florida", "Georgia", "Hawaii", "Idaho", "Illinois", "Indiana", "Iowa", "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland", "Massachusetts", "Michigan", "Minnesota", "Mississippi", "Missouri", "Montana", "Nebraska", "Nevada", "New Hampshire", "New Jersey", "New Mexico", "New York", "North Carolina", "North Dakota", "Ohio", "Oklahoma", "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", "South Dakota", "Tennessee", "Texas", "Utah", "Vermont", "Virginia", "Washington", "West Virginia", "Wisconsin", "Wyoming", "District of Columbia", "Puerto Rico", "Guam", "American Samoa", "U.S. Virgin Islands", "Northern Mariana Islands"
];
var saveState = "", prevVal = "";
// On Page Load
$( document).ready( function( ) {
// Fill Month Selector
	for( var i = 0; i < monthList.length; i++) {
		if ( monthList[ i].toLowerCase( ) === Selections.month) {
			$( "#monthSelector").append( "<option value=\"" + monthList[ i].toLowerCase( ) + "\" selected=\"selected\">" + monthList[ i] + "</option>");
		}
		else {
			$( "#monthSelector").append( "<option value=\"" + monthList[ i].toLowerCase( ) + "\">" + monthList[ i] + "</option>");
		}
	}
	// Fill State Selector
	for( var i = 0; i < stateListLong.length; i++) {
		if ( stateListLong[ i].toLowerCase( ) === Selections.state) {
			$( "#stateSelector").append( "<option value=\"" + stateListLong[ i].toLowerCase( ) + "\" selected=\"selected\">" + stateListLong[ i] + "</option>");
		}
		else {
			$( "#stateSelector").append( "<option value=\"" + stateListLong[ i].toLowerCase( ) + "\">" + stateListLong[ i] + "</option>");
		}
	}
	// Fill Countries
	if ( Selections.country === "US") {
		$( "#countrySelector").append( "<option value=\"US\" selected=\"selected\">United States</option>");
		$( "#countrySelector").append( "<option value=\"CA\">Canada</option>");
	}
	else {
		$( "#countrySelector").append( "<option value=\"US\">United States</option>");
		$( "#countrySelector").append( "<option value=\"CA\" selected=\"selected\">Canada</option>");
	}
	// disable state selection
	if ( Selections.country !== "US") {
		$( "#stateSelector").attr( "disabled", "disabled");
	}
	prevVal = Selections.country;
	 // On country change
	$( "#countrySelector").change( function( ) {
		if ( $("#countrySelector").val( ) !== "US") {
			$( "#stateSelector").attr( "disabled", "disabled");
			if ( prevVal === "US") {
				saveState = $( "#stateSelector").val( );
				$( "#stateSelector").val( "");
			}
		}
		else {
			$( "#stateSelector").removeAttr( "disabled");
			$( "#stateSelector").val( saveState);
		}
		prevVal = $("#countrySelector").val( );
	});
 });
  