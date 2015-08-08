<?php
/**
 * Plugin Name: TG Facebook Comments
 * Plugin URI : http://www.tekgazet.com/tg-facebook-comments-plugin
 * Description: Add, customize and moderate Facebook Comments on your website in simple and easy way. Decide where and how Facebook comments will appear.
 * Version: 1.0
 * Author: Ashok Dhamija
 * Author URI: http://tilakmarg.com/dr-ashok-dhamija/
 * License: GPLv2 or later
 */
 
 /*
  Copyright 2015 Ashok Dhamija web: http://tilakmarg.com/dr-ashok-dhamija/

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */
 
// Add a menu for our option page
add_action('admin_menu', 'tg_facebook_comments_add_page');
function tg_facebook_comments_add_page() {
	add_options_page( 'TG Facebook Comments Plugin', 'TG Facebook Comments', 'manage_options', 'tg_facebook_comments', 'tg_facebook_comments_option_page' );
}

// Draw the option page
function tg_facebook_comments_option_page() {
	
	//Check if it is first time after installation, if so, set default values
	$valid = array();
	$valid = get_option( 'tg_facebook_comments_options' );
	if( !$valid ) {	
		$valid['version'] = '2.4';
		$valid['appid'] = ''; 
		$valid['language'] = 'en_US';
		$valid['html5'] = 1;
		$valid['moderators'] = '';  
		$valid['posts'] = 1;
		$valid['pages'] = '';
		$valid['homepage'] = '';
		$valid['width'] = ''; //Blank means 100% only
		$valid['colorscheme'] = 'light';
		$valid['titlecomments'] = 'TG Facebook Comments';
		$valid['numcount'] = '5';
		$valid['orderby'] = 'social';
		$valid['linkplugin'] = '';
				
		update_option( 'tg_facebook_comments_options', $valid );
	}
	
	?>
	<div class="wrap">
		<?php screen_icon( 'plugins'); ?>
		<h2>TG Facebook Comments Page</h2>
		<form action="options.php" method="post">
			<?php settings_fields('tg_facebook_comments_options'); ?>
			<?php do_settings_sections('tg_facebook_comments'); ?>
			<input name="Submit" type="submit" value="Save Changes" />
			<input name="Submit2" type="submit" value="Reset to Default Values" />	
			<input name="Submit3" type="submit" value="Cancel changes" />
		</form>
	</div>
	<?php
}

// Register and define the settings
add_action('admin_init', 'tg_facebook_comments_admin_init');
function tg_facebook_comments_admin_init(){
	register_setting(
		'tg_facebook_comments_options',
		'tg_facebook_comments_options',
		'tg_facebook_comments_validate_options'
	);
	
	add_settings_section(
		'tg_facebook_comments_about',
		'About TG Facebook Comments Plugin',
		'tg_facebook_comments_section_about_text',
		'tg_facebook_comments'
	);
		
	add_settings_section(
		'tg_facebook_comments_main',
		'TG Facebook Comments Plugin Settings',
		'tg_facebook_comments_section_text',
		'tg_facebook_comments'
	);

	
	add_settings_field(
		'tg_facebook_comments_appid',
		'Enter AppID for your Facebook Comments App:',
		'tg_facebook_comments_setting_input_appid',
		'tg_facebook_comments',
		'tg_facebook_comments_main'
	);

		
	add_settings_field(
		'tg_facebook_comments_language',
		'Select language for comments:',
		'tg_facebook_comments_setting_input_language',
		'tg_facebook_comments',
		'tg_facebook_comments_main'
	);
	
	add_settings_field(
		'tg_facebook_comments_html5',
		'Enable HTML5 for rendering Facebook Comments?',
		'tg_facebook_comments_setting_input_html5',
		'tg_facebook_comments',
		'tg_facebook_comments_main'
	);
	
	add_settings_field(
		'tg_facebook_comments_moderators',
		'Enter Facebook IDs of Moderators for comments:',
		'tg_facebook_comments_setting_input_moderators',
		'tg_facebook_comments',
		'tg_facebook_comments_main'
	);
	
	add_settings_field(
		'tg_facebook_comments_posts',
		'Select if you want Facebook Comments in POSTS:',
		'tg_facebook_comments_setting_input_posts',
		'tg_facebook_comments',
		'tg_facebook_comments_main'
	);
	
	add_settings_field(
		'tg_facebook_comments_pages',
		'Select if you want Facebook Comments in PAGES:',
		'tg_facebook_comments_setting_input_pages',
		'tg_facebook_comments',
		'tg_facebook_comments_main'
	);
	
	add_settings_field(
		'tg_facebook_comments_homepage',
		'Select if you want Facebook Comments on HOME PAGE:',
		'tg_facebook_comments_setting_input_homepage',
		'tg_facebook_comments',
		'tg_facebook_comments_main'
	);
	
	add_settings_field(
		'tg_facebook_comments_width',
		'Select width of Facebook Comments block:',
		'tg_facebook_comments_setting_input_width',
		'tg_facebook_comments',
		'tg_facebook_comments_main'
	);
	
	add_settings_field(
		'tg_facebook_comments_colorscheme',
		'Select color-scheme for Facebook Comments:',
		'tg_facebook_comments_setting_input_colorscheme',
		'tg_facebook_comments',
		'tg_facebook_comments_main'
	);
	
	add_settings_field(
		'tg_facebook_comments_titlecomments',
		'Title for the Facebook Comments block:',
		'tg_facebook_comments_setting_input_titlecomments',
		'tg_facebook_comments',
		'tg_facebook_comments_main'
	);
	
	add_settings_field(
		'tg_facebook_comments_numcount',
		'Select number of comments to show initially:',
		'tg_facebook_comments_setting_input_numcount',
		'tg_facebook_comments',
		'tg_facebook_comments_main'
	);
	
	add_settings_field(
		'tg_facebook_comments_orderby',
		'How should the comments be ordered?',
		'tg_facebook_comments_setting_input_orderby',
		'tg_facebook_comments',
		'tg_facebook_comments_main'
	);
	
	add_settings_field(
		'tg_facebook_comments_linkplugin',
		'Credit link:',
		'tg_facebook_comments_setting_input_linkplugin',
		'tg_facebook_comments',
		'tg_facebook_comments_main'
	);
	
}

// Draw the section header
function tg_facebook_comments_section_about_text() {
	echo '<p><b>TG Facebook Comments</b> is a plugin developed by <a href="http://tilakmarg.com/dr-ashok-dhamija/" target="_blank">Ashok Dhamija</a>. For any help or support issues, please leave your comments at <a href="http://www.tekgazet.com/tg-facebook-comments-plugin" target="_blank">TG Facebook Comments Plugin Page</a>, where you can also read more about the detailed functioning of this plugin. If you like this plugin, please vote favorably for it at its <a href="https://wordpress.org/plugins/tg-facebook-comments/" target="_blank">WordPress plugin page</a>.</p><hr />';
}


// Draw the section header
function tg_facebook_comments_section_text() {
	echo '<p>Enter your settings here for Facebook Comments on your website. You can change these settings any time later.</p><p><b>In most situations, simply entering the Facebook Comments AppID and accepting all other settings with their defaults may be sufficient and you may not be required to change other settings; therefore, please do not be overawed by so many settings. You may start with these default settings and change them later after testing them, only if needed. However, you must enter the Facebook Comments AppID, at least, as explained in AppID field below. Also, if you like this plugin, please select the Credit link checkbox below.</b></p>';
	//Display the Save Changes and Reset buttons at the top
	echo '<input name="Submit" type="submit" value="Save Changes" />  ';
	echo '<input name="Submit2" type="submit" value="Reset to Default Values" />  ';	
	echo '<input name="Submit3" type="submit" value="Cancel changes" />';
}

// Display and fill the form field
function tg_facebook_comments_setting_input_appid() {
	// get option 'appid' value from the database
	$options = get_option( 'tg_facebook_comments_options' );
	$appid = $options['appid'];
	// echo the field
	echo "<input id='appid' size='50' name='tg_facebook_comments_options[appid]' type='text' value='$appid' />";
	echo '<p>Your Facebook AppID needs to be entered here. If you do not have an AppID, you can easily create it free on Facebook Developers site by <a href="https://developers.facebook.com/apps" target="_blank">clicking here</a>. Detailed instructions for setting up an AppID can be seen <a href="http://www.tekgazet.com/how-to-easily-setup-and-install-facebook-comments-in-wordpress/soft/2848.html" target="_blank">here</a>. Please note that a valid AppID is necessary to properly show Facebook Comments on your website and to enable you to moderate comments as administrator of that App.<p>';
}

// Display and fill the form field
function tg_facebook_comments_setting_input_language() {
	// get option 'language' value from the database
	$options = get_option( 'tg_facebook_comments_options' );
	$language = $options['language'];
	
	//display the option select field
	echo '<select name="tg_facebook_comments_options[language]">';
		echo '<option value="af_ZA"'. selected( $language, 'af_ZA', false ) .'>Afrikaans</option>';
		echo '<option value="sq_AL"'. selected( $language, 'sq_AL', false ) .'>Albanian</option>';
		echo '<option value="ar_AR"'. selected( $language, 'ar_AR', false ) .'>Arabic</option>';
		echo '<option value="hy_AM"'. selected( $language, 'hy_AM', false ) .'>Armenian</option>';
		echo '<option value="az_AZ"'. selected( $language, 'az_AZ', false ) .'>Azerbaijani</option>';
		echo '<option value="eu_ES"'. selected( $language, 'eu_ES', false ) .'>Basque</option>';
		echo '<option value="be_BY"'. selected( $language, 'be_BY', false ) .'>Belarusian</option>';
		echo '<option value="bn_IN"'. selected( $language, 'bn_IN', false ) .'>Bengali</option>';
		echo '<option value="bs_BA"'. selected( $language, 'bs_BA', false ) .'>Bosnian</option>';
		echo '<option value="bg_BG"'. selected( $language, 'bg_BG', false ) .'>Bulgarian</option>';
		echo '<option value="ca_ES"'. selected( $language, 'ca_ES', false ) .'>Catalan</option>';
		echo '<option value="cx_PH"'. selected( $language, 'cx_PH', false ) .'>Cebuano</option>';
		echo '<option value="zh_CN"'. selected( $language, 'zh_CN', false ) .'>Chinese Simplified (China)</option>';
		echo '<option value="zh_HK"'. selected( $language, 'zh_HK', false ) .'>Chinese Traditional(Hong Kong)</option>';
		echo '<option value="zh_TW"'. selected( $language, 'zh_TW', false ) .'>Chinese Traditional(Taiwan)</option>';
		echo '<option value="hr_HR"'. selected( $language, 'hr_HR', false ) .'>Croatian</option>';
		echo '<option value="cs_CZ"'. selected( $language, 'cs_CZ', false ) .'>Czech</option>';
		echo '<option value="da_DK"'. selected( $language, 'da_DK', false ) .'>Danish</option>';
		echo '<option value="nl_NL"'. selected( $language, 'nl_NL', false ) .'>Dutch</option>';
		echo '<option value="nl_BE"'. selected( $language, 'nl_BE', false ) .'>Dutch (België)</option>';
		echo '<option value="en_PI"'. selected( $language, 'en_PI', false ) .'>English (Pirate)</option>';
		echo '<option value="en_GB"'. selected( $language, 'en_GB', false ) .'>English (UK)</option>';
		echo '<option value="en_UD"'. selected( $language, 'en_UD', false ) .'>English (Upside Down)</option>';
		echo '<option value="en_US"'. selected( $language, 'en_US', false ) .'>English (US)</option>';
		echo '<option value="eo_EO"'. selected( $language, 'eo_EO', false ) .'>Esperanto</option>';
		echo '<option value="et_EE"'. selected( $language, 'et_EE', false ) .'>Estonian</option>';
		echo '<option value="fo_FO"'. selected( $language, 'fo_FO', false ) .'>Faroese</option>';
		echo '<option value="tl_PH"'. selected( $language, 'tl_PH', false ) .'>Filipino</option>';
		echo '<option value="fi_FI"'. selected( $language, 'fi_FI', false ) .'>Finnish</option>';		
		echo '<option value="fr_CA"'. selected( $language, 'fr_CA', false ) .'>French (Canada)</option>';
		echo '<option value="fr_FR"'. selected( $language, 'fr_FR', false ) .'>French (France)</option>';
		echo '<option value="fy_NL"'. selected( $language, 'fy_NL', false ) .'>Frisian</option>';
		echo '<option value="gl_ES"'. selected( $language, 'gl_ES', false ) .'>Galician</option>';
		echo '<option value="ka_GE"'. selected( $language, 'ka_GE', false ) .'>Georgian</option>';
		echo '<option value="de_DE"'. selected( $language, 'de_DE', false ) .'>German</option>';
		echo '<option value="el_GR"'. selected( $language, 'el_GR', false ) .'>Greek</option>';
		echo '<option value="he_IL"'. selected( $language, 'he_IL', false ) .'>Hebrew</option>';
		echo '<option value="hi_IN"'. selected( $language, 'hi_IN', false ) .'>Hindi</option>';
		echo '<option value="hu_HU"'. selected( $language, 'hu_HU', false ) .'>Hungarian</option>';
		echo '<option value="is_IS"'. selected( $language, 'is_IS', false ) .'>Icelandic</option>';
		echo '<option value="id_ID"'. selected( $language, 'id_ID', false ) .'>Indonesian</option>';
		echo '<option value="ga_IE"'. selected( $language, 'ga_IE', false ) .'>Irish</option>';
		echo '<option value="it_IT"'. selected( $language, 'it_IT', false ) .'>Italian</option>';
		echo '<option value="ja_JP"'. selected( $language, 'ja_JP', false ) .'>Japanese</option>';	
		echo '<option value="ja_KS"'. selected( $language, 'ja_KS', false ) .'>Japanese (Kansai)</option>';	
		echo '<option value="jv_ID"'. selected( $language, 'jv_ID', false ) .'>Javanese</option>';
		echo '<option value="kn_IN"'. selected( $language, 'kn_IN', false ) .'>Kannada</option>';
		echo '<option value="kk_KZ"'. selected( $language, 'kk_KZ', false ) .'>Kazakh</option>';
		echo '<option value="km_KH"'. selected( $language, 'km_KH', false ) .'>Khmer</option>';
		echo '<option value="ko_KR"'. selected( $language, 'ko_KR', false ) .'>Korean</option>';
		echo '<option value="ku_TR"'. selected( $language, 'ku_TR', false ) .'>Kurdish (Kurmanji)</option>';
		echo '<option value="la_VA"'. selected( $language, 'la_VA', false ) .'>Latin</option>';
		echo '<option value="lv_LV"'. selected( $language, 'lv_LV', false ) .'>Latvian</option>';
		echo '<option value="fb_LT"'. selected( $language, 'fb_LT', false ) .'>Leet Speak</option>';
		echo '<option value="lt_LT"'. selected( $language, 'lt_LT', false ) .'>Lithuanian</option>';		
		echo '<option value="mk_MK"'. selected( $language, 'mk_MK', false ) .'>Macedonian</option>';
		echo '<option value="ms_MY"'. selected( $language, 'ms_MY', false ) .'>Malay</option>';
		echo '<option value="ml_IN"'. selected( $language, 'ml_IN', false ) .'>Malayalam</option>';	
		echo '<option value="mr_IN"'. selected( $language, 'mr_IN', false ) .'>Marathi</option>';	
		echo '<option value="mn_MN"'. selected( $language, 'mn_MN', false ) .'>Mongolian</option>';	
		echo '<option value="ne_NP"'. selected( $language, 'ne_NP', false ) .'>Nepali</option>';
		echo '<option value="nb_NO"'. selected( $language, 'nb_NO', false ) .'>Norwegian (bokmal)</option>';
		echo '<option value="nn_NO"'. selected( $language, 'nn_NO', false ) .'>Norwegian (nynorsk)</option>';		
		echo '<option value="ps_AF"'. selected( $language, 'ps_AF', false ) .'>Pashto</option>';
		echo '<option value="fa_IR"'. selected( $language, 'fa_IR', false ) .'>Persian</option>';
		echo '<option value="pl_PL"'. selected( $language, 'pl_PL', false ) .'>Polish</option>';		
		echo '<option value="pt_BR"'. selected( $language, 'pt_BR', false ) .'>Portuguese (Brazil)</option>';
		echo '<option value="pt_PT"'. selected( $language, 'pt_PT', false ) .'>Portuguese (Portugal)</option>';
		echo '<option value="pa_IN"'. selected( $language, 'pa_IN', false ) .'>Punjabi</option>';
		echo '<option value="ro_RO"'. selected( $language, 'ro_RO', false ) .'>Romanian</option>';
		echo '<option value="ru_RU"'. selected( $language, 'ru_RU', false ) .'>Russian</option>';
		echo '<option value="sr_RS"'. selected( $language, 'sr_RS', false ) .'>Serbian</option>';
		echo '<option value="si_LK"'. selected( $language, 'si_LK', false ) .'>Sinhala</option>';
		echo '<option value="sk_SK"'. selected( $language, 'sk_SK', false ) .'>Slovak</option>';
		echo '<option value="sl_SI"'. selected( $language, 'sl_SI', false ) .'>Slovenian</option>';		
		echo '<option value="es_LA"'. selected( $language, 'es_LA', false ) .'>Spanish</option>';
		echo '<option value="es_CO"'. selected( $language, 'es_CO', false ) .'>Spanish (Colombia)</option>';
		echo '<option value="es_ES"'. selected( $language, 'es_ES', false ) .'>Spanish (Spain)</option>';
		echo '<option value="sw_KE"'. selected( $language, 'sw_KE', false ) .'>Swahili</option>';
		echo '<option value="sv_SE"'. selected( $language, 'sv_SE', false ) .'>Swedish</option>';	
		echo '<option value="tg_TJ"'. selected( $language, 'tg_TJ', false ) .'>Tajik</option>';	
		echo '<option value="ta_IN"'. selected( $language, 'ta_IN', false ) .'>Tamil</option>';
		echo '<option value="te_IN"'. selected( $language, 'te_IN', false ) .'>Telugu</option>';
		echo '<option value="th_TH"'. selected( $language, 'th_TH', false ) .'>Thai</option>';		
		echo '<option value="tr_TR"'. selected( $language, 'tr_TR', false ) .'>Turkish</option>';
		echo '<option value="uk_UA"'. selected( $language, 'uk_UA', false ) .'>Ukrainian</option>';
		echo '<option value="ur_PK"'. selected( $language, 'ur_PK', false ) .'>Urdu</option>';	
		echo '<option value="uz_UZ"'. selected( $language, 'uz_UZ', false ) .'>Uzbek</option>';	
		echo '<option value="vi_VN"'. selected( $language, 'vi_VN', false ) .'>Vietnamese</option>';	
		echo '<option value="cy_GB"'. selected( $language, 'cy_GB', false ) .'>Welsh</option>';	
	echo '</select>';
	echo '<p>Please select language in which comments will be made.<p>';	   
}


// Display and fill the form field
function tg_facebook_comments_setting_input_html5() {
	// get option 'html5' value from the database
	$options = get_option( 'tg_facebook_comments_options' );
	$html5 = $options['html5'];
	
	// echo the field	
	$msg1 = '<input type="checkbox" id="html5" name="tg_facebook_comments_options[html5]" value="1"' . checked( 1, $html5, false ) . '/>';
    echo $msg1;
	echo '<p>Let HTML5 remain selected since generally it is supported nowadays. If there is a difficulty seen in displaying comments, or if the comments are not displayed properly, then try changing this setting.<p>';
}

// Display and fill the form field
function tg_facebook_comments_setting_input_moderators() {
	// get option 'moderators' value from the database
	$options = get_option( 'tg_facebook_comments_options' );
	$moderators = $options['moderators'];
	// echo the field
	echo "<input id='moderators' size='50' name='tg_facebook_comments_options[moderators]' type='text' value='$moderators' />";
	echo '<p>All admins to Facebook AppID can moderate Facebook comments, by default. To add more moderators, enter their Facebook IDs, separated by commas, but <b>without space</b>. Visit <a href="http://www.tekgazet.com/how-do-i-find-my-facebook-id-number/soft/2849.html" target="_blank">this link</a> to know how to find out Facebook ID of a user. <p>';
}

// Display and fill the form field
function tg_facebook_comments_setting_input_posts() {
	// get option 'posts' value from the database
	$options = get_option( 'tg_facebook_comments_options' );
	$posts = $options['posts'];
	// echo the field
	$msg1 = '<input type="checkbox" id="posts" name="tg_facebook_comments_options[posts]" value="1"' . checked( 1, $posts, false ) . '/>';
    echo $msg1;
	echo '<p>When you select this, Facebook comments will be shown on every post, including custom post types. However, you will still be able to disable comments on an individual post by using the TG Facebook Comments metabox at the time of publishing or updating that post.<p>';
}

// Display and fill the form field
function tg_facebook_comments_setting_input_pages() {
	// get option 'pages' value from the database
	$options = get_option( 'tg_facebook_comments_options' );
	$pages = $options['pages'];
	// echo the field
	$msg1 = '<input type="checkbox" id="pages" name="tg_facebook_comments_options[pages]" value="1"' . checked( 1, $pages, false ) . '/>';
    echo $msg1;
	echo '<p>When you select this, Facebook comments will be shown on every page. However, you will still be able to disable comments on an individual page by using the TG Facebook Comments metabox at the time of publishing or updating that page.<p>';
}

// Display and fill the form field
function tg_facebook_comments_setting_input_homepage() {
	// get option 'homepage' value from the database
	$options = get_option( 'tg_facebook_comments_options' );
	$homepage = $options['homepage'];
	// echo the field
	$msg1 = '<input type="checkbox" id="homepage" name="tg_facebook_comments_options[homepage]" value="1"' . checked( 1, $homepage, false ) . '/>';
    echo $msg1;
	echo '<p>Selecting this will enable Facebook comments on the homepage of your website. <b>Note:</b> If a static page is shown as your homepage and if you want to disable comments on your homepage, in addition to this setting, you may also have to disable comments on that static page by using the TG Facebook Comments metabox at the time of publishing or updating that page (this will apply if comments are enabled for <b>pages</b> by the previous setting).<p>';
}

// Display and fill the form field
function tg_facebook_comments_setting_input_width() {
	// get option 'width' value from the database
	$options = get_option( 'tg_facebook_comments_options' );
	$width = $options['width'];
	// echo the field
	echo "<input id='width' name='tg_facebook_comments_options[width]' type='text' value='$width' />";
	echo '<p>Keep it blank to keep the default width of 100% of the place / DIV where Facebook comments are shown. This is desirable since it will automatically make width responsive. However, if you want, you can enter any other number (in pixels) such as 350, 500, etc., as per your theme. Please enter only numbers (and <b>no other character</b>). The mobile version of Facebook Comments will ignore such number entered by you since it uses 100% width to be responsive and fluid.<p>';
}

// Display and fill the form field
function tg_facebook_comments_setting_input_colorscheme() {
	// get option 'colorscheme' value from the database
	$options = get_option( 'tg_facebook_comments_options' );
	$colorscheme = $options['colorscheme'];
	
	//display the option select field
	echo '<select name="tg_facebook_comments_options[colorscheme]">';
		echo '<option value="light" '. selected( $colorscheme, 'light', false ) .'>Light</option>';
		echo '<option value="dark" '. selected( $colorscheme, 'dark', false ) .'>Dark</option>';
	echo '</select>';
	echo '<p>This is the color-scheme for displaying Facebook comments - light or dark.<p>';	   
}

// Display and fill the form field
function tg_facebook_comments_setting_input_titlecomments() {
	// get option 'titlecomments' value from the database
	$options = get_option( 'tg_facebook_comments_options' );
	$titlecomments = $options['titlecomments'];
	// echo the field
	echo "<input id='titlecomments' name='tg_facebook_comments_options[titlecomments]' type='text' value='$titlecomments' />";
	echo '<p>This is the title of the Facebook Comments block. Default value is <b>Comments</b>.<p>';
}

// Display and fill the form field
function tg_facebook_comments_setting_input_numcount() {
	// get option 'numcount' value from the database
	$options = get_option( 'tg_facebook_comments_options' );
	$numcount = $options['numcount'];
	// echo the field
	echo "<input id='numcount' name='tg_facebook_comments_options[numcount]' type='text' value='$numcount' />";
	echo '<p>This is number of comments that will be shown initially in comments block. If more comments are available, the user will be able to load more comments by clicking on the show more comments link. Default value is 5 comments being shown initially. Please enter only a number, preferably between 1 and 20.<p>';
}

// Display and fill the form field
function tg_facebook_comments_setting_input_orderby() {
	// get option 'orderby' value from the database
	$options = get_option( 'tg_facebook_comments_options' );
	$orderby = $options['orderby'];
	
	//display the option select field
	echo '<select name="tg_facebook_comments_options[orderby]">';
		echo '<option value="social" '. selected( $orderby, 'social', false ) .'>Top</option>';
		echo '<option value="time" '. selected( $orderby, 'time', false ) .'>Oldest</option>';
		echo '<option value="reverse_time" '. selected( $orderby, 'reverse_time', false ) .'>Newest</option>';
	echo '</select>';
	echo '<p>This is the default order in which comments will be ordered. A user will still be able to change the order of comments at the time of reading the comments.<p>';	   
}

// Display and fill the form field
function tg_facebook_comments_setting_input_linkplugin() {
	// get option 'linkplugin' value from the database
	$options = get_option( 'tg_facebook_comments_options' );
	$linkplugin = $options['linkplugin'];
	// echo the field
	$msg1 = '<input type="checkbox" id="linkplugin" name="tg_facebook_comments_options[linkplugin]" value="1"' . checked( 1, $linkplugin, false ) . '/>';
    echo $msg1;
	echo '<p>Please select it to show link to the plugin, below the comments, so that other website owners may also know about the plugin and use it.<p>';
}

// Validate user input 
function tg_facebook_comments_validate_options( $input ) {		
	$valid = array();	
	$options = get_option( 'tg_facebook_comments_options' );

	//Reset to default values, if needed
	if ( isset( $_POST['Submit2'] ) ) 
	{ 
		$valid['version'] = '2.4';
		$valid['appid'] = ''; 
		$valid['language'] = 'en_US';
		$valid['html5'] = 1;
		$valid['moderators'] = '';
		$valid['posts'] = 1;
		$valid['pages'] = '';
		$valid['homepage'] = '';
		$valid['width'] = ''; //Blank means 100% only
		$valid['colorscheme'] = 'light';
		$valid['titlecomments'] = 'TG Facebook Comments';
		$valid['numcount'] = '5';
		$valid['orderby'] = 'social';
		$valid['linkplugin'] = '';
		
		
		//Show message for defaults restored
		add_settings_error(
			'tg_facebook_comments_option_page',
			'tg_facebook_comments_texterror',
			'Default values have been restored.',
			'updated'
			);	
			
		return $valid;
	}

	//Cancel changes, if needed
	if ( isset( $_POST['Submit3'] ) ) 
	{ 		
		$valid['version'] = $options['version'] ;
		$valid['appid'] = $options['appid'] ;
		$valid['language'] = $options['language'] ;
		$valid['html5'] = $options['html5'] ;
		$valid['moderators'] = $options['moderators'] ;
		$valid['posts'] = $options['posts'] ;
		$valid['pages'] = $options['pages'] ;
		$valid['homepage'] = $options['homepage'] ;
		$valid['width'] = $options['width'] ;
		$valid['colorscheme'] = $options['colorscheme'] ;
		$valid['titlecomments'] = $options['titlecomments'] ;
		$valid['numcount'] = $options['numcount'] ;
		$valid['orderby'] = $options['orderby'] ;
		$valid['linkplugin'] = $options['linkplugin'] ;
				
		//Show message for defaults restored
		add_settings_error(
			'tg_facebook_comments_option_page',
			'tg_facebook_comments_texterror',
			'Cancelled the changes made.',
			'updated'
			);	
			
		return $valid;
	}
	
	//check whether AppID is correctly entered
	$valid['appid'] = preg_replace( '/[^0-9]/', '', $input['appid'] );	
	if( $valid['appid'] != $input['appid'] ) {
		//restore the old value
		$valid['appid'] = $options['appid'] ;
		//set error
		add_settings_error(
			'tg_customized_tags_appid',
			'tg_customized_tags_texterror',
			'Error: Please enter valid AppID number. Only numbers are allowed.',
			'error'
		);		
	}
	
	//check whether Moderators field is correctly entered
	$valid['moderators'] = preg_replace( '/[^0-9,]/', '', $input['moderators'] );	
	if( $valid['moderators'] != $input['moderators'] ) {
		//restore the old value
		$valid['moderators'] = $options['moderators'] ;
		//set error
		add_settings_error(
			'tg_customized_tags_moderators',
			'tg_customized_tags_texterror',
			'Error: Please enter valid characters in Moderators field. Only numbers and commas are allowed. Even space character not allowed.',
			'error'
		);		
	}
	
	//check whether width is correctly entered
	$valid['width'] = preg_replace( '/[^0-9]/', '', $input['width'] );	
	if( $valid['width'] != $input['width'] ) {
		//restore the old value
		$valid['width'] = $options['width'] ;
		//set error
		add_settings_error(
			'tg_customized_tags_width',
			'tg_customized_tags_texterror',
			'Error: Please enter valid width for Facebook comments block. Only numbers are allowed.',
			'error'
		);		
	}
		
	//check whether numcount is correctly entered
	$valid['numcount'] = preg_replace( '/[^0-9]/', '', $input['numcount'] );	
	if( $valid['numcount'] != $input['numcount'] ) {
		//restore the old value
		$valid['numcount'] = $options['numcount'] ;
		//set error
		add_settings_error(
			'tg_customized_tags_numcount',
			'tg_customized_tags_texterror',
			'Error: Please enter valid number of comments to be shown initially. Only numbers are allowed.',
			'error'
		);		
	}
	else {
		if( ( $valid['numcount'] < 1 ) or ( $valid['numcount'] > 20 )) {
			//restore the old value
			$valid['numcount'] = $options['numcount'] ;
			//set error
			add_settings_error(
			'tg_customized_tags_numcount',
			'tg_customized_tags_texterror',
			'Error: Please enter a number between 1 and 20 only for the number of comments to be shown initially.',
			'error'
		);	
		}
	}
	
	$valid['version'] = '2.4' ;
	//$valid['appid'] = $input['appid'] ;
	$valid['language'] = $input['language'] ;
	$valid['html5'] = $input['html5'] ;
	//$valid['moderators'] = $input['moderators'] ;
	$valid['posts'] = $input['posts'] ;
	$valid['pages'] = $input['pages'] ;
	$valid['homepage'] = $input['homepage'] ;
	//$valid['width'] = $input['width'] ;	
	$valid['colorscheme'] = $input['colorscheme'] ;
	$valid['titlecomments'] = $input['titlecomments'] ;
	//$valid['numcount'] = $input['numcount'] ;
	$valid['orderby'] = $input['orderby'] ;
	$valid['linkplugin'] = $input['linkplugin'] ;
			
	return $valid;		
}

function tg_facebook_comments_add_meta_box() {
    $post_types = get_post_types( '', 'names' );
    $options = get_option('tg_facebook_comments_options');
	
		
//	if ((!isset($options['appid'])) && (($options['appid'] != ''))){	
	
		foreach ( $post_types as $post_type ) {
			if ( "post" == $post_type ) {
				if ($options['posts']== 1) {
					add_meta_box('tg_facebook_comments_meta', 'TG Facebook Comments', 'tg_facebook_comments_meta_function', $post_type, 'advanced', 'high');
				}
			} elseif ( "page" == $post_type) {
				if ($options['pages']== 1) {
					add_meta_box('tg_facebook_comments_meta', 'TG Facebook Comments', 'tg_facebook_comments_meta_function', $post_type, 'advanced', 'high');
				}
			} else { 			//this takes care of custom-post types
				if ($options['posts']== 1) {
					add_meta_box('tg_facebook_comments_meta', 'TG Facebook Comments', 'tg_facebook_comments_meta_function', $post_type, 'advanced', 'high');
				}
			}
		}
//	}
}
add_action( 'add_meta_boxes', 'tg_facebook_comments_add_meta_box' );

function tg_facebook_comments_meta_function( $post ) {
	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'tg_facebook_comments_save_postdata', 'tg_facebook_comments_meta_box_nonce' );
    $_disable_tg_facebook_comments = get_post_meta( $post->ID, $key = '_disable_tg_facebook_comments', $single = true );
	
?>	
	<input id="_disable_tg_facebook_comments" name="_disable_tg_facebook_comments" type="checkbox" value="on" <?php checked('on', $_disable_tg_facebook_comments); ?> /> <label for="_disable_tg_facebook_comments">Disable Facebook Comments</label> 
<?php

}

function tg_facebook_comments_save_postdata( $post_id ) {
    
	// We need to verify this came from our screen and with proper authorization, because the save_post action can be triggered at other times.
	 
	// Check if our nonce is set.
	if ( ! isset( $_POST['tg_facebook_comments_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['tg_facebook_comments_meta_box_nonce'], 'tg_facebook_comments_save_postdata' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	
	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}
    	
	// OK, it's safe for us to save the data now. 
	
	// Sanitize user input.
	$_disable_tg_facebook_comments_data = sanitize_text_field( $_POST['_disable_tg_facebook_comments'] );
    // Update the meta field in the database.
	update_post_meta($post_id, '_disable_tg_facebook_comments', $_disable_tg_facebook_comments_data);

}
add_action( 'save_post', 'tg_facebook_comments_save_postdata' );

//Add info about admins and moderators in head section
function tg_facebook_comments_head_section() {
	$options = get_option( 'tg_facebook_comments_options' );
	if (!empty($options['appid'])) {
		echo '<meta property="fb:app_id" content="'.$options['appid'].'"/>';
	}
	if (!empty($options['moderators'])) {
		//echo '<meta property="fb:admins" content="'.$options['moderators'].'"/>';
		$moderators = trim($options['moderators']);
		if(strpos($moderators,',') >= 0)
		{
			$moderators_array = explode(",", $moderators);
			foreach($moderators_array as $moderator){
				echo '<meta property="fb:admins" content="'.$moderator.'"/>';
			}
		} else {
			echo '<meta property="fb:admins" content="'.$moderators.'"/>';
		}		
	}
}
add_action('wp_head', 'tg_facebook_comments_head_section');

//add info in footer section
function tg_facebook_comments_footer_section() {
	$options = get_option( 'tg_facebook_comments_options' );
	if ($options['appid'] != '') {
		?>
		<!-- TG Facebook Comments Plugin : http://www.tekgazet.com/tg-facebook-comments-plugin -->
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/<?php echo $options['language']; ?>/sdk.js#xfbml=1&version=v<?php echo $options['version']; ?>&appId=<?php echo $options['appid']; ?>";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		<?php 
	}
}
add_action('wp_footer', 'tg_facebook_comments_footer_section', 100);


//add info for comments block
function tg_facebook_comments_comment_section($content) {
	$options = get_option( 'tg_facebook_comments_options' );
		
	$color = $numposts = $orderby = $width = '';
	
	if ( $options['html5'] == 1 ) {
		$colorscheme = 'data-colorscheme';
		$numposts = 'data-numposts';
		$orderby = 'data-order-by';
		$width = 'data-width';
		}
	else {
		$colorscheme = 'colorscheme';
		$numposts = 'numposts';
		$orderby = 'order-by';
		$width = 'data-width';
	}
	
	//set width-value including if it is not default of "nothing"
	$width_value = '';
	if ( $options['width'] == '' ) {
		$width_value = $width . '="100%"' ; 
	}
	else {
		$width_value = $width . '="' . $options['width'] .'"' ; 
	}
	
	//set numposts value
	$numpost_value = $numposts . '="' . $options['numcount'] .'"' ;
	
	//set colorscheme value
	$colorscheme_value = $colorscheme . '="' . $options['colorscheme'] .'"' ;
	
	//set orderby value
	$orderby_value = $orderby . '="' . $options['orderby'] .'"' ;
		
	//prepare additions to be made to contents
	$contents_addl = '';
	//see if tiltle of comments is to be displayed
	if ( $options['titlecomments'] != '' ) {
		$contents_addl = "<h3> " . $options['titlecomments'] . "</h3>";
	}
		
	$comment_str = '<div class="fb-comments" data-href="'. get_permalink() . '" ' . $width_value . ' ' . $numpost_value . ' ' . $colorscheme_value . ' ' . $orderby_value . ' ></div>';
	$contents_addl .= "<!-- TG Facebook Comments Plugin : http://www.tekgazet.com/tg-facebook-comments-plugin -->". $comment_str ;
	
	//see if link plugin is selected
	if ( $options['linkplugin'] == 1 ) {
		$contents_addl .= '<p>Powered by <a href="http://www.tekgazet.com/tg-facebook-comments-plugin">TG Facebook Comments</a></p>';
	}

	//Check whether and where to display the comment box
	if ( (is_single() && $options['posts'] == 1) || (is_page() && $options['pages'] == 1) ) {
			$_disable_tg_facebook_comments = get_post_meta( get_the_ID(), '_disable_tg_facebook_comments', true );
			if ( $_disable_tg_facebook_comments != 'on') {			
				$content .= $contents_addl ;
			}
	   }
	
	if ((is_home() || is_front_page()) && ($options['homepage'] == 1)) {
			$content .= $contents_addl ;
	   }
	
	return $content;
}
add_filter ('the_content', 'tg_facebook_comments_comment_section', 100);

?>
