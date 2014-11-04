//JS jQuery
// Data Arrays

var monthList = [
    "January", "February", "March", "April", "May", "June", "July", "August", "September", "November", "December"
];
var stateListLong = [
    "Alabama", "Alaska", "Arizona", "Arkansas", "California", "Colorado", "Connecticut", "Delaware", "Florida", "Georgia", "Hawaii", "Idaho", "Illinois", "Indiana", "Iowa", "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland", "Massachusetts", "Michigan", "Minnesota", "Mississippi", "Missouri", "Montana", "Nebraska", "Nevada", "New Hampshire", "New Jersey", "New Mexico", "New York", "North Carolina", "North Dakota", "Ohio", "Oklahoma", "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", "South Dakota", "Tennessee", "Texas", "Utah", "Vermont", "Virginia", "Washington", "West Virginia", "Wisconsin", "Wyoming", "District of Columbia", "Puerto Rico", "Guam", "American Samoa", "U.S. Virgin Islands", "Northern Mariana Islands"
];
// state vars
var saveState = "", prevVal = "";

// timer
var userRefreshTimer;
var userRefreshInterval = 1000;

// On Page Load
$(document).ready(function ( ) {
// Fill Month Selector
    for (var i = 0; i < monthList.length; i++) {
        if (monthList[ i].toLowerCase( ) === Selections.month) {
            $("#monthSelector").append("<option value=\"" + monthList[ i].toLowerCase( ) + "\" selected=\"selected\">" + monthList[ i] + "</option>");
        }
        else {
            $("#monthSelector").append("<option value=\"" + monthList[ i].toLowerCase( ) + "\">" + monthList[ i] + "</option>");
        }
    }
    // Fill State Selector
    for (var i = 0; i < stateListLong.length; i++) {
        if (stateListLong[ i].toLowerCase( ) === Selections.state) {
            $("#stateSelector").append("<option value=\"" + stateListLong[ i].toLowerCase( ) + "\" selected=\"selected\">" + stateListLong[ i] + "</option>");
        }
        else {
            $("#stateSelector").append("<option value=\"" + stateListLong[ i].toLowerCase( ) + "\">" + stateListLong[ i] + "</option>");
        }
    }
    // Fill Countries
    if (Selections.country === "US") {
        $("#countrySelector").append("<option value=\"US\" selected=\"selected\">United States</option>");
        $("#countrySelector").append("<option value=\"CA\">Canada</option>");
    }
    else {
        $("#countrySelector").append("<option value=\"US\">United States</option>");
        if (Selections.country === "CA") {
            $("#countrySelector").append("<option value=\"CA\" selected=\"selected\">Canada</option>");
        }
        else {
            $("#countrySelector").append("<option value=\"CA\">Canada</option>");
        }
    }
    // disable state selection if needed
    if (Selections.country !== "US") {
        $("#stateSelector").prop("disabled", true);
    }
    prevVal = Selections.country;

    // On country change
    $("#countrySelector").change(function ( ) {
        if ($("#countrySelector").val( ) !== "US") {
            $("#stateSelector").prop("disabled", true);
            if (prevVal === "US") {
                saveState = $("#stateSelector").val( );
                $("#stateSelector").val("");
            }
        }
        else {
            $("#stateSelector").prop("disabled", false);
            $("#stateSelector").val(saveState);
        }
        prevVal = $("#countrySelector").val( );
    });

    // On registration form change 
    // keyup
    $("#registration_form").find(" :text").keyup(function ( ) {
        onFormUpdate($(this).attr("name"), $(this).val);
    });
    // keydown
    $("#registration_form").find(" :text").keydown(function ( ) {
        clearTimeout(userRefreshTimer);
    });
    // change
    $("#registration_form").find(" :input").change(function ( ) {
        onFormUpdate($(this).attr("name"), $(this).val);
    });
    //Action function
    function onFormUpdate(str, val) {
        console.log(str);
        if (str === "username") {
            clearTimeout(userRefreshTimer);
            if (val) {
                userRefreshTimer = setTimeout(refreshUsername, userRefreshInterval);
            }
        }
    }
    //update user
    function refreshUsername( ) {
        console.log("update username");
    }
});
  