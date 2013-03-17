<?php
/*
Plugin Name: JQuery Html5 File Upload
Plugin URI: http://wordpress.org/extend/plugins/jquery-html5-file-upload/
Description: This plugin adds a file upload functionality to the front-end screen. It allows multiple file upload asynchronously along with upload status bar.
Version: 1.1
Author: Anwar Swabiri
Author URI: 
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


/**The URL of the plugin directory*/
define('JQHFUPLUGINDIRURL',plugin_dir_url(__FILE__));

/* Runs when plugin is activated */
register_activation_hook(__FILE__,'jquery_html5_file_upload_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'jquery_html5_file_upload_remove' );

function jquery_html5_file_upload_install() {
	add_option("jqhfu_accepted_file_types", 'gif|jpeg|jpg|png', '', 'yes');
	add_option("jqhfu_inline_file_types", 'gif|jpeg|jpg|png', '', 'yes');
	add_option("jqhfu_maximum_file_size", '5', '', 'yes');
	add_option("jqhfu_thumbnail_width", '80', '', 'yes');
	add_option("jqhfu_thumbnail_height", '80', '', 'yes');
	
	$upload_array = wp_upload_dir();
	$upload_dir=$upload_array['basedir'].'/files/';
	/* Create the directory where you upoad the file */
	if (!is_dir($upload_dir)) {
		$is_success=mkdir($upload_dir, '0755', true);
		if(!$is_success)
			die('Unable to create a directory within the upload folder');
	}
}

function jquery_html5_file_upload_remove() {
	/* Deletes the database field */
	delete_option('jqhfu_accepted_file_types');
	delete_option('jqhfu_inline_file_types');
	delete_option('jqhfu_maximum_file_size');
	delete_option('jqhfu_thumbnail_width');
	delete_option('jqhfu_thumbnail_height');
}

if(isset($_POST['savesetting']) && $_POST['savesetting']=="Save Setting")
{
	update_option("jqhfu_accepted_file_types", $_POST['accepted_file_types']);
	update_option("jqhfu_inline_file_types", $_POST['inline_file_types']);
	update_option("jqhfu_maximum_file_size", $_POST['maximum_file_size']);
	update_option("jqhfu_thumbnail_width", $_POST['thumbnail_width']);
	update_option("jqhfu_thumbnail_height", $_POST['thumbnail_height']);
}

if ( is_admin() ){

/* Call the html code */
add_action('admin_menu', 'jquery_html5_file_upload_admin_menu');


function jquery_html5_file_upload_admin_menu() {
add_options_page('JQuery HTML5 File Upload Setting', 'JQuery HTML5 File Upload Setting', 'administrator',
'jquery-html5-file-upload-setting', 'jquery_html5_file_upload_html_page');
}
}

function jquery_html5_file_upload_html_page() {
?>
<h2>JQuery HTML5 File Upload Setting</h2>

<form method="post" >
<?php wp_nonce_field('update-options'); ?>

<table >
<tr >
<td>Accepted File Types</td>
<td >
<input type="text" name="accepted_file_types" value="<?php print(get_option('jqhfu_accepted_file_types')); ?>" />&nbsp;filetype seperated by | (e.g. gif|jpeg|jpg|png)
</td>
</tr>
<tr >
<td>Inline File Types</td>
<td >
<input type="text" name="inline_file_types" value="<?php print(get_option('jqhfu_inline_file_types')); ?>" />&nbsp;filetype seperated by | (e.g. gif|jpeg|jpg|png)
</td>
</tr>
<tr >
<td>Maximum File Size</td>
<td >
<input type="text" name="maximum_file_size" value="<?php print(get_option('jqhfu_maximum_file_size')); ?>" />&nbsp;MB
</td>
</tr>
<tr >
<td>Thumbnail Width </td>
<td >
<input type="text" name="thumbnail_width" value="<?php print(get_option('jqhfu_thumbnail_width')); ?>" />&nbsp;px
</td>
</tr
<tr >
<td>Thumbnail Height </td>
<td >
<input type="text" name="thumbnail_height" value="<?php print(get_option('jqhfu_thumbnail_height')); ?>" />&nbsp;px
</td>
</tr>
<tr>
<td colspan="2">
<input type="submit" name="savesetting" value="Save Setting" />
</td>
</tr>
</table>

</form>
<?php
}


function jqhfu_enqueue_scripts() {
	$stylepath=JQHFUPLUGINDIRURL.'css/';
	$scriptpath=JQHFUPLUGINDIRURL.'js/';

	wp_enqueue_style ( 'jquery-ui-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/themes/base/jquery-ui.css' );
	wp_enqueue_style ( 'jquery-image-gallery-style', 'http://blueimp.github.com/jQuery-Image-Gallery/css/jquery.image-gallery.min.css');
	wp_enqueue_style ( 'jquery-fileupload-ui-style', $stylepath . 'jquery.fileupload-ui.css');
	wp_enqueue_script ( 'enable-html5-script', 'http://html5shim.googlecode.com/svn/trunk/html5.js');
	if(!wp_script_is('jquery')) {
		wp_enqueue_script ( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js',array(),'',false);
	}
	wp_enqueue_script ( 'jquery-ui-script', '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/jquery-ui.min.js',array('jquery'),'',true);
	wp_enqueue_script ( 'tmpl-script', 'http://blueimp.github.com/JavaScript-Templates/tmpl.min.js',array('jquery'),'',true);
	wp_enqueue_script ( 'load-image-script', 'http://blueimp.github.com/JavaScript-Load-Image/load-image.min.js',array('jquery'),'',true);
	wp_enqueue_script ( 'canvas-to-blob-script', 'http://blueimp.github.com/JavaScript-Canvas-to-Blob/canvas-to-blob.min.js',array('jquery'),'',true);
	wp_enqueue_script ( 'jquery-image-gallery-script', 'http://blueimp.github.com/jQuery-Image-Gallery/js/jquery.image-gallery.min.js',array('jquery'),'',true);
	wp_enqueue_script ( 'jquery-iframe-transport-script', $scriptpath . 'jquery.iframe-transport.js',array('jquery'),'',true);
	wp_enqueue_script ( 'jquery-fileupload-script', $scriptpath . 'jquery.fileupload.js',array('jquery'),'',true);
	wp_enqueue_script ( 'jquery-fileupload-fp-script', $scriptpath . 'jquery.fileupload-fp.js',array('jquery'),'',true);
	wp_enqueue_script ( 'jquery-fileupload-ui-script', $scriptpath . 'jquery.fileupload-ui.js',array('jquery'),'',true);
	wp_enqueue_script ( 'jquery-fileupload-jui-script', $scriptpath . 'jquery.fileupload-jui.js',array('jquery'),'',true);
	wp_enqueue_script ( 'transport-script', $scriptpath . 'cors/jquery.xdr-transport.js',array('jquery'),'',true);
}	

function jqhfu_load_ajax_function()
{
	/* Include the upload handler */
	require 'UploadHandler.php';
	global $current_user;
	get_currentuserinfo();
	$current_user_id=$current_user->ID;
	if(!isset($current_user_id) || $current_user_id=='')
		$current_user_id='guest';
	$upload_handler = new UploadHandler(null,$current_user_id,true);
	die(); 
}

function jqhfu_add_inline_script() {
?>
<script type="text/javascript">
/*
 * jQuery File Upload Plugin JS Example 7.0
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
jQuery(function () {
    'use strict';

    // Initialize the jQuery File Upload widget:
    jQuery('#fileupload').fileupload({
        url: '<?php print(admin_url('admin-ajax.php'));?>'
    });

    // Enable iframe cross-domain access via redirect option:
    jQuery('#fileupload').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
			<?php
			$absoluteurl=str_replace(home_url(),'',JQHFUPLUGINDIRURL);
			print("'".$absoluteurl."cors/result.html?%s'");
			?>
        )
    );

	if(jQuery('#fileupload')) {
		// Load existing files:
        jQuery.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: jQuery('#fileupload').fileupload('option', 'url'),
			data : {action: "load_ajax_function"},
			acceptFileTypes: /(\.|\/)(<?php print(get_option('jqhfu_accepted_file_types')); ?>)$/i,
			dataType: 'json',
			context: jQuery('#fileupload')[0]
			
            
        }).done(function (result) {
			jQuery(this).fileupload('option', 'done')
						.call(this, null, {result: result});
        });
    }

    // Initialize the Image Gallery widget:
    jQuery('#fileupload .files').imagegallery();

    // Initialize the theme switcher:
    jQuery('#theme-switcher').change(function () {
        var theme = jQuery('#theme');
        theme.prop(
            'href',
            theme.prop('href').replace(
                /[\w\-]+\/jquery-ui.css/,
                jQuery(this).val() + '/jquery-ui.css'
            )
        );
    });

});

</script>
<?php
}

/* Block of code that need to be printed to the form*/
function jquery_html5_file_upload_hook() {
$whitelist = array('localhost', '127.0.0.1');
if(!in_array($_SERVER['HTTP_HOST'], $whitelist)){
?>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-8264268943944137";
/* Add for JQFU Plugin */
google_ad_slot = "3528882927";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<?php
}
?>
<!-- The file upload form used as target for the file upload widget -->
    <form id="fileupload" action="<?php print(admin_url().'admin-ajax.php');?>" method="POST" enctype="multipart/form-data">
        <!-- Redirect browsers with JavaScript disabled to the origin page -->
       <input type="hidden" name="action" value="load_ajax_function" />
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="span7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="icon-plus icon-white"></i>
                    <span>Add Photos...</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="icon-upload icon-white"></i>
                    <span>Start upload</span>
                </button>
                <button type="button" class="btn btn-danger delete">
                    <i class="icon-trash icon-white"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" class="toggle">
            </div>
            <!-- The global progress information -->
            <div class="span5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="bar" style="width:0%;"></div>
                </div>
                <!-- The extended global progress information -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
		
        <!-- The loading indicator is shown during file processing -->
        <div class="fileupload-loading"></div>
        <br>
        <!-- The table listing the files available for upload/download -->
		
		
        <table role="presentation" class="table table-striped" style="width:590px;"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
		
    </form>
    <br>
    <div class="well">
       
    </div>

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
       
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">Error: </span> {%=file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td >
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start" colspan="3">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i>
                    <span>Start</span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="icon-ban-circle icon-white"></i>
                <span>Cancel</span>
            </button>
        {% } %}</td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
		<td class="error" colspan="5"><span class="label label-important">Error: </span> {%=file.error%} ({%=file.name.substring(4)%})</td>            
            
        {% } else { %}
            <td class="preview">{% if (file.thumbnail_url) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" data-gallery="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
            {% } %}</td>
            <td class="name" style="width:200px;">
<div style="width:190px;overflow-x:hidden;">
                <a href="{%=file.url%}" title="{%=file.name%}" data-gallery="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
           </div> </td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td colspan="2"></td>
        {% } %}
        <td class="delete">
            <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}&action=load_ajax_function"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                <i class="icon-trash icon-white"></i>
                <span>Delete</span>
            </button>
            <input type="checkbox" name="delete" value="1">
        </td>
    </tr>
{% } %}
</script>
<?php
}

function jquery_file_upload_shortcode() {
      jquery_html5_file_upload_hook();
}

/* Add the resources */
add_action( 'wp_enqueue_scripts', 'jqhfu_enqueue_scripts' );

/* Load the inline script */
add_action( 'wp_footer', 'jqhfu_add_inline_script' );

/* Hook on ajax call */
add_action('wp_ajax_load_ajax_function', 'jqhfu_load_ajax_function');
add_action('wp_ajax_nopriv_load_ajax_function', 'jqhfu_load_ajax_function');

add_shortcode ('jquery_file_upload', 'jquery_file_upload_shortcode');