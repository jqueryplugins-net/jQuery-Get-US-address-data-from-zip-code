<?php
/**
 * Plugin Name: Jquery Get US address data from zip code WordPress Plugin (City, County, State & Country)
 * Plugin URI: https://jqueryplugins.net/
 * Description: Uses Jquery and Google Maps For Javascript API - Custom Wordpress Shortcode that you can add to any post, page or text widget.  Example shortcode: [ZIP-TO-COUNTY]
 * Version: 1.0
 * Author: jqueryplugins.net
 * Author URI: https://jqueryplugins.net/
 * License: GPL2
 */
//main function - created inside custom wordpress shortcode
function jquery_get_us_Address_data_from_zip_code_shortcode() {
  // start output buffer
  ob_start();
//close php so that we can output our HTML
   ?>
<!--html output
First - Reference the API
Second - Add the logic to extract County from Zip Code
Third - Add form to page
This script will not work outside of the jqueryplugins.net demo unless you change the API Key URL Parameter in the URL Below.  You can obtain a free Google Maps Javascript API Here: https://developers.google.com/maps/documentation/javascript/
-->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD49zLuf-q1k6uZ-sPBeZinLNyiUALTu6Q"
  type="text/javascript"></script>
<script type="text/javascript">function getLocation(){
  getAddressInfoByZip(document.forms[0].zip.value); //grab zip value from input field
}
function response(obj){
  console.log(obj); //for debug purposes - you can view array object in debug console
}
function getAddressInfoByZip(zip){
  if(zip.length >= 5 && typeof google != 'undefined'){
    var addr = {};
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({ 'address': zip }, function(results, status){
      if (status == google.maps.GeocoderStatus.OK){
        if (results.length >= 1) {
      for (var ii = 0; ii < results[0].address_components.length; ii++){
        var street_number = route = street = city = state = zipcode = country = formatted_address = '';
        var types = results[0].address_components[ii].types.join(",");
        if (types == "street_number"){
          addr.street_number = results[0].address_components[ii].long_name;}
        if (types == "route" || types == "point_of_interest,establishment"){
          addr.route = results[0].address_components[ii].long_name;}
        if (types == "sublocality,political" || types == "locality,political" || types == "neighborhood,political" || types == "administrative_area_level_3,political"){
          addr.city = (city == '' || types == "locality,political") ? results[0].address_components[ii].long_name : city;}
        if (types == "administrative_area_level_1,political"){
          addr.state = results[0].address_components[ii].short_name;}
        if (types == "postal_code" || types == "postal_code_prefix,postal_code"){
          addr.zipcode = results[0].address_components[ii].long_name;}
        if (types == "country,political"){
          addr.country = results[0].address_components[ii].long_name;}
        if (types == "administrative_area_level_2,political"){ addr.county = results[0].address_components[ii].long_name; }
      }
      addr.success = true;
          jQuery('#county span').text( addr.county );
          jQuery('#city span').text( addr.city );
          jQuery('#state span').text( addr.state );
          jQuery('#country span').text( addr.country );
          response(addr); //for debug purposes
        } else {
           addr.success = false;
        }
      } else {
         addr.success = false;
      }
    });
  } else {
   addr.success = false;
  }
}</script>
<!--add the output HTML -->
<form><strong> Enter Zip:</strong> <input type="text" name="zip" value="55068"> <a href="#" class="btn" onclick="getLocation()">Get US Address Data From Zip Code -></a></form>
<div id="county">County: <span>________</span></div> 
<div id="city">City: <span>________</span></div>
<div id="state">State: <span>________</span></div>
<div id="country">Country: <span>________</span></div>
<!--end Output HTML and restart PHP -->
  <?php return ob_get_clean();}
add_shortcode( 'ZIP-TO-COUNTY', 'jquery_get_us_Address_data_from_zip_code_shortcode' );