<?php
/*
Plugin Name: Current Date Free 
Plugin URI: https://lightweightplugins.com/
Description: A lightweight plugin that provides shortcodes for the current, Year, Month, Day, Time and more.
Version: 2.0
Author: Team Lightweight Plugins
Author URI: https://lightweightplugins.com/
License: GPLv2 or later
Icons made by flaticon.com/authors/iconixar
*/


// Adds "Settings" to Plugin Page next to Activate/Deactivate 
function salcode_add_plugin_page_settings_link( $links ) {
	$links[] = '<a href="' .
		admin_url( 'options-general.php?page=lwcd-current-date-free' ) .
		'">' . __('Settings') . '</a>';
	return $links;
}
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'salcode_add_plugin_page_settings_link');

// The Shortcode 
	function build_lwcd_shortcode( $atts ){
		$args = shortcode_atts(array(
	'display' => 'Y',
	), $atts);
		$d = $args["display"];
  return date($d);
}
add_shortcode( 'lwcd', 'build_lwcd_shortcode');


// ====== Start ============ Legacy shortcode support

// Adds shortcode [lwcd-year] for current year ex 2020
function lwcdCurrentYear( $atts ){
    return date('Y');
}
add_shortcode( 'lwcd-year', 'lwcdCurrentYear' );

// Adds shortcode [lwcd-month-s] for current month string ex April
function lwcdCurrentMonths( $atts ){
    return date('F');
}
add_shortcode( 'lwcd-month-s', 'lwcdCurrentMonths' );

// Adds shortcode [lwcd-month-n] for current month number ex 4
function lwcdCurrentMonthn( $atts ){
  return date('n');
}
add_shortcode( 'lwcd-month-n', 'lwcdCurrentMonthn' );

// Adds shortcode [lwcd-day] for current day ex 20
function lwcdCurrentDay( $atts ){
  return date('j');
}
add_shortcode( 'lwcd-day', 'lwcdCurrentDay' );

// Adds shortcode [lwcd-day-sfx] for current day ex th
function lwcdCurrentDaySfx( $atts ){
  return date('S');
}
add_shortcode( 'lwcd-day-sfx', 'lwcdCurrentDaySfx' );

// ====== End ============== Will be removed in future version


// Create page in dashboard settings
function lwcd_admin_menu() {
  add_submenu_page(
    'options-general.php',
    'Current Date Free by Lightweight Plugins',
    'Current Date',
    'manage_options',
    'lwcd-current-date-free',
    'lwcd_admin_page_contents'
    );
    }
  add_action( 'admin_menu', 'lwcd_admin_menu' );
  
   
  function lwcd_admin_page_contents() {
  ?>
  <h1>Current Date Free by Lightweight Plugins</h1>
  <br>
  <h2>Basic Structure</h2>
  <p>Insert <code>[lwcd display="format(s)"]</code>, replacing format(s) with the desired output from the available formats below.</p>
  <br>
  <h2>Multiple Formats in One Shortcode</h2>
  <p>Inserting <code>[lwcd display="F jS"]</code> would output <code>F</code> full text of the month, then a space, then <code>j</code> day of the month - no zero, then <code>S</code> day of the month suffix.</p>
  <p>Example: Today is <?php print date('F jS');?></p>
  <br>
  <h2>Multiple Formats in One Shortcode with Text</h2>
  <p>Inserting <code>[lwcd display="h:i:s A"]</code> would output hour:minuite:second space capital AM/PM. The colons output as the character they are.</p>
  <p>Example: The time is <?php print date('h:i:s A');?></p>
  <br>
  <h2>Multiple Formats in One Shortcode with Conflicting Text</h2>
  <p>Inserting <code>[lwcd display="Today is the z day of o."]</code> would output jibberish since some of the letters are also recognised formats. You must tell the shortcode not to convert the letter to a date, time, etc but print them as text. To flag the letter as text, insert a <code>\</code> before each letter. For simplicity, you can do them all except the ones needed. Another options would be to use two shortcodes.
  <p>Example: <code>[lwcd display="Today is the z day of o."]</code> would output <?php print date('Today is the z day of o.');?></p>
  <p>Example: <code>[lwcd display="\T\o\d\a\y \i\s \t\h\e z \d\a\y \o\f o."]</code> would output <?php print date('\T\o\d\a\y \i\s \t\h\e z \d\a\y \o\f o.');?></p>
  <p>Example: <code>Today is the [lwcd display="z"] day of [lwcd display="o"].</code> would output <?php echo "Today is the "; print date('z'); echo " day of "; print date('o.');?></p>
  <br>
  <h2>Available Formats</h2>
  <h4>Day Formats</h4>
  <p>
  <code>d</code> - Day of the month, 2 digits with leading zeros, example	01 to 31<br>
  <code>D</code> - A text representation of a day, three letters, exmaple	Mon through Sun<br>
  <code>j</code> - Day of the month without leading zeros, example 1 to 31<br>
  <code>l</code> - (lowercase ‘L’) A full text representation of the day of the week, example Sunday through Saturday<br>
  <code>S</code> - English suffix for the day of the month, 2 characters, example st, nd, rd or th.<br>
  <code>w</code> - Numeric representation of the day of the week, example 0 (for Sunday) through 6 (for Saturday)<br>
  <code>z</code> - The day of the year (starting from 0), example 0 through 365
</p>
<h4>Week Formats</h4>
  <p>
  <code>W</code> - Week number of year, weeks starting on Monday, example 42 (the 42nd week in the year)
</p>
<h4>Year Formats</h4>
  <p>
  <code>L</code> - Whether it’s a leap year, example 1 if it is a leap year, 0 otherwise.<br>
  <code>Y</code> - A four digit representation of a year, example 2004<br>
  <code>y</code> - A two digit representation of a year, example 04

</p>
<h4>Time Formats</h4>
  <p>
  <code>a</code> - Lowercase Ante meridiem and Post meridiem, example am or pm<br>
  <code>A</code> - Uppercase Ante meridiem and Post meridiem, example AM or PM<br>
  <code>g</code> - 12-hour format of an hour without leading zeros, example 1 through 12<br>
  <code>G</code> - 24-hour format of an hour without leading zeros, example 0 through 23<br>
  <code>h</code> - 12-hour format of an hour with leading zeros, example	01 through 12<br>
  <code>H</code> - 24-hour format of an hour with leading zeros, example	00 through 23<br>
  <code>i</code> - Minutes with leading zeros, example	00 to 59<br>
  <code>s</code> - Seconds, with leading zeros, example 00 through 59
</p>
<h4>Timezone</h4>
  <p>
  <code>e</code> - Timezone identifier, example UTC, GMT, Atlantic/Azores<br>
  <code>I</code> - (capital i)Whether or not the date is in daylight saving time, example	1 if Daylight Saving Time, 0 otherwise.<br>
  <code>O</code> - Difference to Greenwich time (GMT) in hours, example +0200<br>
  <code>P</code> - Difference to Greenwich time (GMT) with colon, example +02:00<br>
  <code>T</code> - Timezone abbreviation, example EST, MDT
</p>
<h4>Full Date/Time</h4>
  <p>
  <code>c</code> - ISO 8601 formatted date, example 2004-02-12T15:19:21+00:00<br>
  <code>r</code> - RFC 2822 formatted date, examlpe Thu, 21 Dec 2000 16:01:07 +0200<br>
  <code>U</code> - Seconds since the Unix Epoch (January 1 1970 00:00:00 GMT), example <?php print date('U');?>

</p>
<br>
  <h2>Contact Us</h2>
  <p><a href="https://lightweightplugins.com/" target="_blank"><button class="button-primary">Visit Lightweight Plugins Home</button></a></p>
 
  <br><br><br>
  <h1><br>== Legacy Shortcodes Support is Ending Soon ==</h1>
  <br>
  <h2>Legacy shortcode support will be removed with the next update</h2>
  <p>Insert <code>[lwcd-year]</code> for the current year ex. <strong>2020</strong></p>
  <p>Insert <code>[lwcd-month-s]</code> for the current month as a string ex. <strong>February</strong></p>
  <p>Insert <code>[lwcd-month-n]</code> for the current month as a number ex. <strong>2</strong></p>
  <p>Insert <code>[lwcd-day]</code> for the current day ex. <strong>9</strong></p>
  <p>Insert <code>[lwcd-day-sfx]</code> for the current day suffix ex. <strong>th</strong></p>
  <h2><br>Examples</h2>
  <p>Insert <code>&amp;copy;[lwcd-year]</code> to get <strong>© 2020</strong></p>
  <p>Insert <code>[lwcd-day]/[lwcd-month-n]/[lwcd-year]</code> to get <strong>9/2/2020</strong></p>
  <p>Insert <code>[lwcd-month-s] [lwcd-day][lwcd-day-sfx]</code> to get <strong>February 9th</strong></p>
  
  
  <?php }