<?php
/**
* Plugin Name: ZPLMOd - FAQ.Lite
* Description: Responsive FAQ - It easy for you to FAQs on your site add using shortcode, fully compatible with all responsive themes and reduce database calls.
* Version: 1.7.24
* Author: <Strong>ZPLMOd</Strong>
* Author URI: https://github.com/naksheth
* Plugin URI: https://github.com/Naksheth/ZPLMOd_FAQLite
* License: GPLv3
* License URI: http://www.gnu.org/licenses/gpl-3.0.html
**/

	$plugin = plugin_basename(__FILE__); 

// Get Plugin
	function plugin_get_version() { 
		$plugin_data = get_plugin_data( __FILE__ ); 
		$plugin_version = $plugin_data['Version']; 
		return $plugin_version; 
		/* <div class="build-sk"><span class="build-ski"><i class="bsk bski">build</i><i class="bsk bskp">'.plugin_get_version().'</i></span></div><br/> */
	}

	add_action( 'admin_menu', 'faqlite_options_setup' );
	add_filter( "plugin_action_links_$plugin", 'faqlite_settings_link' );

// Add Options Menu
	function faqlite_options_setup() {add_options_page( 'FAQ.Lite', '<span class="dashicons dashicons-editor-help" style="vertical-align:text-top;"></span> FAQ.Lite', 'manage_options', 'zplmod_faqlite', 'faqlite_options_page' ); }

// Add settings link on plugin page
	function faqlite_settings_link($links) { $settings_link = '<a href="admin.php?page=zplmod_faqlite" target="_blank" title="FAQ.Lite Shortcodes" style="background-color:#444; border-radius:4px; padding:2px 6px; font-style:normal; color:white;">Shortcodes</a> '; array_unshift($links, $settings_link); return $links; } 

// Script & Jquery
function zplmod_faqlite(){ 
	wp_enqueue_script('jquery'); 

	if( is_page() || is_single() ) { ?> 
<script type="text/javascript"> /* faqlite jquery */ jQuery(function($){ $(document).ready(function(){ $('.faqlite-title').click(function(){ var my_content_id = $(this).attr('data-content-id'); $('#' + my_content_id ).slideToggle(); $(this).toggleClass(function(){ if( $(this).is('.close-faq')){ return 'open-faq'; } else{ return 'close-faq'; }	}); }); }); }); </script> 
	<?php } }

	add_action('wp_footer', 'zplmod_faqlite',990);

// Shortcode
function zplmod_faqlite_shortcode( $atts, $content, $tag ){

	if($tag == 'faqlite')	{
		extract( shortcode_atts( array (
			'header' => 'FAQ ?', 
			'headercolor' => '#444', 
			'tabspancolor' => '#444',
			'tabbgcolor' => '#555', 
			'tabtitlecolor' => '#fff', 
			'tabtitlefontsize' => '16',
			'tabtextbgcolor' => '#efcb28', 
			'tabtextcolor' => '#444'
		), $atts ) );

	return '<div class="faqlite-list"><h2 class="faqlite-header">'.$header.'</h3>' .do_shortcode($content). '
<style type="text/css">
.faqlite-list{margin:10px 3px;} h2.faqlite-header{font-size:18px; color:'.$headercolor.'; margin:6px auto;}
.faqlite-entry{border:none!important; margin-bottom:2px!important; padding-bottom:0px !important;}
.faqlite-title.close-faq, .faqlite-title.open-faq{cursor:pointer;} 
.faqlite-title.close-faq span{background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAC9JREFUeNpi/P//PwMeAJNkxKWAiYFCMGoAFQxgQYoqYqKTNi5gHE1IQ90AgAADAGadByAvvYTgAAAAAElFTkSuQmCC) no-repeat center center;}
.faqlite-title.open-faq span{background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAACdJREFUeNpi/P//PwMlgImBQjBqABUMYAHi/wPuAsbRaBzqBgAEGACwVgQhD7DWpwAAAABJRU5ErkJggg==) no-repeat center center;}
.faqlite-title.close-faq span, .faqlite-title.open-faq span{width:30px; height:30px; display:inline-block; position:relative; left:0; top:8px; margin-right:12px; margin-left:-42px; background-color:'.$tabspancolor.';}
h3.faqlite-title{font-size:'.$tabtitlefontsize.'px; color:'.$tabtitlecolor.'; background-color:'.$tabbgcolor.'; padding:0px 10px 10px; padding-left:50px; margin:0;-webkit-touch-callout: none;-webkit-user-select: none;-khtml-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;outline-style:none;}
.faqlite-content{display:none; color:'.$tabtextcolor.'; background:'.$tabtextbgcolor.'; font-size:14px; padding:10px; padding-left:50px; word-break:normal;}
.faqlite-entry p, .faqlite-entry ul, .faqlite-entry ul li{}
</style>
</div>';

	} else if($tag == 'faqlite_tab') {
		$no = rand(); //random no.
		extract( shortcode_atts( array (
			'tabspancolor' => '',
			'title' => 'FAQ Title or Header',
			'tabbgcolor' => '', 'titlecolor' => '',
			'textbgcolor' => '', 'textcolor' => ''
		), $atts ) );
return '
<article class="faqlite-entry" id="faqlite-entry-'.$no.'">
	<h3 class="faqlite-title close-faq" data-content-id="faqlite-content-'.$no.'" style="background:'.$tabbgcolor.'; color:'.$titlecolor.';"><span style="background-color:'.$tabspancolor.';"></span>'.$title.'</h3>
	<div class="faqlite-content" id="faqlite-content-'.$no.'" style="display: none;background:'.$textbgcolor.'; color:'.$textcolor.';">' .do_shortcode($content). '</div>
</article>';

// ShortCode Error
} else { return '!!3RR0R_F1X_S00N...'; }
}

	add_shortcode( 'faqlite', 'zplmod_faqlite_shortcode' );
	add_shortcode( 'faqlite_tab', 'zplmod_faqlite_shortcode' );


// FAQ.Lite Option Page
	function faqlite_options_page() { ?>

<h3 style="color:#555;"> <span class="dashicons dashicons-editor-help" style="font-size:x-large; vertical-align:bottom;"></span> FAQ.Lite </h3>

<style type="text/css">
/* Tab Post */
#tab-main {margin:0; max-width:800px;} #tab-main input[type=radio] {display:none;}
#tab-main label {display: inline-block; padding:6px 20px; font-weight:600; text-align:center;} #tab-main label:hover {color:#fff; cursor:pointer;}
#tab-main input:checked + label {background:#dd2727; color:#fff;} #tab-main input + label {background:#888; color:#fff; margin-right:-2px;}
#tab-content {background:#e9e9e9; border-top:3px solid #dd2727; border-radius:0px;} #tab-content > div {display:none; padding:15px;} #tab1:checked ~ #tab-content #tabcontent1, #tab2:checked ~ #tab-content #tabcontent2, #tab3:checked ~ #tab-content #tabcontent3{display:block;}
.ip_textarea{width:100%;*min-width:550px; *max-width:550px;} .ta_small{height:150px;} .ta_med{height:300px;} .ta_large{height:550px;}
.zpl_ip_ul, .zpl_ip_ul li .span-ip-a, .zpl_ip_ul li .span-ip-b{display:block;} .zpl_ip_ul li .span-ip-b .dashicons{vertical-align:-6px;}
.zpl_ip_ul li .span-ip-a{vertical-align:top; *min-width:125px; *max-width:125px; margin:5px 0px 10px; text-align:left; font-weight:700;}
/* build */ .build-sk{display:inline-block; cursor:default;}.build-ski{display:flex; padding:2px 5px; color:#fff;}.build-ski .bsk{padding:2px 6px; font-style:normal;}.build-ski .bski{background-color:#444; border-radius:4px 0px 0px 4px;}.build-ski .bskp{background-color:#33ab0c; border-radius:0px 4px 4px 0px;}
</style>

<div id="tab-main">
<input id="tab1" type="radio" name="tabs" checked ><label for="tab1"><span class="dashicons dashicons-media-code" style="vertical-align:top;"></span> Shortcode</label>
<input id="tab2" type="radio" name="tabs" ><label for="tab2"><span class="dashicons dashicons-format-status" style="vertical-align:top;"></span> Help</label>
<input id="tab3" type="radio" name="tabs" ><label for="tab3"><span class="dashicons dashicons-nametag" style="vertical-align:top;"></span> About</label>
<div id="tab-content"> 

<!-- Tab 1 : #General -->
<div id="tabcontent1"> <ul class="zpl_ip_ul" style="width:100%;">

<li><span class="span-ip-a"><span class="dashicons dashicons-arrow-right"></span> Shortcode </span> 
<span class="span-ip-b"><textarea class="ip_textarea ta_med">

[faqlite header="FAQLite Testing Shortcode" headercolor="#444" tabspancolor="#999" tabbgcolor="#555" tabtitlecolor="#fff" tabtitlefontsize="18" tabtextbgcolor="#ecd008" tabtextcolor="#444"]

[faqlite_tab title="Title 1"]
Content Text Here 1
[/faqlite_tab]

[faqlite_tab title="Title 2"]
Content Text Here 2
[/faqlite_tab]

[/faqlite]

</textarea>
<p style="background-color:#ccc;padding:5px;">Shortcode above FAQLite style change as one style to all tabs. If want to change style specific tab or tabs use shortcode below. **Color #444 are HTML Color Code (Find on Photoshop or Google...). For Click Tab Help for more..</p>
</span><hr><br>

<span class="span-ip-a"><span class="dashicons dashicons-arrow-right"></span> Tab Shortcode Style Change one by one </span>
<span class="span-ip-b"><textarea class="ip_textarea ta_small">

[faqlite_tab title="Title Here" tabspancolor="#333" tabbgcolor="#e21725" titlecolor="#fff" textbgcolor="#efcb28" textcolor="#555"]
Content Text Here
[/faqlite_tab]

</textarea><br><br><hr><br>
</li>
	
</ul></div><!-- Tab 1 : #End -->

<!-- Tab 2 : #Help -->
<div id="tabcontent2"> <ul class="zpl_ip_ul" style="width:100%;">

<p style="font-weight:700;"><span class="dashicons dashicons-arrow-right"></span> Shortcode Help : <br><br>
<img src="<?php echo plugins_url( 'screenshot-1.png', __FILE__ );?>" style="max-width:665px;width:100%;" ><br>
<img src="<?php echo plugins_url( 'screenshot-2.png', __FILE__ );?>" style="max-width:665px;width:100%;" >
</p>
	
</ul></div><!-- Tab 2 : #End -->

<!-- Tab 3 : #About -->
<div id="tabcontent3"> <ul class="zpl_ip_ul" style="width:100%;">

<li><span class="span-ip-a">
▒█▀▀▀█ ▒█▀▀█ ▒█░░░ ▒█▀▄▀█ ▒█▀▀▀█ █▀▀▄  <br/>
░▄▄▄▀▀ ▒█▄▄█ ▒█░░░ ▒█▒█▒█ ▒█░░▒█ █░░█  <br/>
▒█▄▄▄█ ▒█░░░ ▒█▄▄█ ▒█░░▒█ ▒█▄▄▄█ ▀▀▀░  <br/><br/>
<span class="dashicons dashicons-arrow-right"></span> FAQ Lite v<?php echo plugin_get_version();?> | <span class="dashicons dashicons-admin-site"></span> <a href="https://github.com/Naksheth/ZPLMOd_FAQLite" target="_blank">Website</a>
</span> 

<span class="span-ip-b"><p>
FAQ.Lite, it easy for you to FAQs on your site add using shortcode. Fully compatible with all responsive themes and reduce database calls.<br/>
</p></span><hr><br>
</li>

</ul></div><!-- Tab 3 : #End -->

</div></div>
<?php }
