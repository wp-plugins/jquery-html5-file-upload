<?php
/*
Plugin Name: JQuery Html5 File Upload
Plugin URI: http://wordpress.org/extend/plugins/jquery-html5-file-upload/
Description: This plugin adds a file upload functionality to the front-end screen. It allows multiple file upload asynchronously along with upload status bar.
Version: 3.0
Author: sinashshajahan
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

// Add settings link on plugin page
function jquery_html5_file_upload_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=jquery-html5-file-upload-setting.php">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'jquery_html5_file_upload_settings_link' );

if ( is_admin() ){

/* Call the html code */
add_action('admin_menu', 'jquery_html5_file_upload_admin_menu');


function jquery_html5_file_upload_admin_menu() {
add_options_page('JQuery HTML5 File Upload Setting', 'JQuery HTML5 File Upload Setting', 'administrator',
'jquery-html5-file-upload-setting', 'jquery_html5_file_upload_html_page');
}
}

function jquery_html5_file_upload_html_page() {
$args = array(
    'orderby'                 => 'display_name',
    'order'                   => 'ASC',
    'selected'                => $_POST['user']
);
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
<br/>
<hr/>
<h2>View Uploaded Files</h2>
<table >
<tr >
<td>Select User</td>
<td >
<?php wp_dropdown_users($args); ?> 
</td>
<td>
<input type="submit" name="viewfiles" value="View Files" /> &nbsp; <input type="submit" name="viewguestfiles" value="View Guest Files" />
</td>
</tr>
<tr>
</table>
<table>
<tr>
<td>
<?php
if(isset($_POST['viewfiles']) && $_POST['viewfiles']=='View Files')
{
if ($_POST['user']) {
	$upload_array = wp_upload_dir();
	$imgpath=$upload_array['basedir'].'/files/'.$_POST ['user'].'/';
	$filearray=glob($imgpath.'*');
	if($filearray && is_array($filearray))
	{
		foreach($filearray as $filename){
			if(basename($filename)!='thumbnail'){
			print('<a href="'.$upload_array['baseurl'].'/files/'.$_POST ['user'].'/'.basename($filename).'" target="_blank"/>'.basename($filename).'</a>');
			print('<br/>');
			}
		}
	}
} 
}
else
if(isset($_POST['viewguestfiles']) && $_POST['viewguestfiles']=='View Guest Files')
{
	$upload_array = wp_upload_dir();
	$imgpath=$upload_array['basedir'].'/files/guest/';
	$filearray=glob($imgpath.'*');
	if($filearray && is_array($filearray))
	{
		foreach($filearray as $filename){
			if(basename($filename)!='thumbnail'){
			print('<a href="'.$upload_array['baseurl'].'/files/guest/'.basename($filename).'" target="_blank"/>'.basename($filename).'</a>');
			print('<br/>');
			}
		}
	}
}
?>
</td>
</tr>
</table>
</form>
<?php
}


function jqhfu_enqueue_scripts() {
	$stylepath=JQHFUPLUGINDIRURL.'css/';
	$scriptpath=JQHFUPLUGINDIRURL.'js/';
	
	wp_enqueue_style ( 'blueimp-gallery-style', $stylepath.'blueimp-gallery.min.css' );
	wp_enqueue_style ( 'jquery.fileupload-style', $stylepath.'jquery.fileupload.css' );

	if(!wp_script_is('jquery')) {
		wp_enqueue_script ( 'jquery', $scriptpath .'jquery.min.js',array(),'',false);
	}
	wp_enqueue_script ( 'jquery-ui-script', $scriptpath . 'jquery-ui.min.js',array('jquery'),'',true);
	wp_enqueue_script ( 'jtmpl-script', $scriptpath . 'tmpl.min.js',array('jquery'),'',true);
	wp_enqueue_script ( 'load-image-all-script', $scriptpath . 'load-image.all.min.js',array('jquery'),'',true);
	wp_enqueue_script ( 'canvas-to-blob-script', $scriptpath . 'canvas-to-blob.min.js',array('jquery'),'',true);
	wp_enqueue_script ( 'jquery-blueimp-gallery-script', $scriptpath . 'jquery.blueimp-gallery.min.js',array('jquery'),'',true);
	wp_enqueue_script ( 'jquery-iframe-transport-script', $scriptpath . 'jquery.iframe-transport.js',array('jquery'),'',true);
	wp_enqueue_script ( 'jquery-fileupload-script', $scriptpath . 'jquery.fileupload.js',array('jquery'),'',true);
	wp_enqueue_script ( 'jquery-fileupload-process-script', $scriptpath . 'jquery.fileupload-process.js',array('jquery'),'',true);
	wp_enqueue_script ( 'jquery-fileupload-image-script', $scriptpath . 'jquery.fileupload-image.js',array('jquery'),'',true);
	wp_enqueue_script ( 'jquery-fileupload-audio-script', $scriptpath . 'jquery.fileupload-audio.js',array('jquery'),'',true);
	wp_enqueue_script ( 'jquery-fileupload-video-script', $scriptpath . 'jquery.fileupload-video.js',array('jquery'),'',true);
	wp_enqueue_script ( 'jquery-fileupload-validate-script', $scriptpath . 'jquery.fileupload-validate.js',array('jquery'),'',true);
	wp_enqueue_script ( 'jquery-fileupload-ui-script', $scriptpath . 'jquery.fileupload-ui.js',array('jquery'),'',true);
	wp_enqueue_script ( 'jquery-fileupload-jquery-ui-script', $scriptpath . 'jquery.fileupload-jquery-ui.js',array('jquery'),'',true);
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
	$upload_handler = new UploadHandler(null,$current_user_id,true,null);
	die(); 
}

function jqhfu_add_inline_script() {
?>
<script type="text/javascript">

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
        jQuery('#fileupload').addClass('fileupload-processing');
		// Load existing files:
        jQuery.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: jQuery('#fileupload').fileupload('option', 'url'),
			data : {action: "load_ajax_function"},
			acceptFileTypes: /(\.|\/)(<?php print(get_option('jqhfu_accepted_file_types')); ?>)$/i,
			dataType: 'json',
			context: jQuery('#fileupload')[0]
		}).always(function () {
            jQuery(this).removeClass('fileupload-processing');	    
        }).done(function (result) {
			jQuery(this).fileupload('option', 'done')
						.call(this, jQuery.Event('done'), {result: result});
        });
    }

});
</script>
<?php
}

/* Block of code that need to be printed to the form*/
function jquery_html5_file_upload_hook() {
?>
<!-- The file upload form used as target for the file upload widget -->
    <form id="fileupload" action="<?php print(admin_url().'admin-ajax.php');?>" method="POST" enctype="multipart/form-data" style="max-width:500px;">
        <!-- Redirect browsers with JavaScript disabled to the origin page -->
       <input type="hidden" name="action" value="load_ajax_function" />
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
       <div class="fileupload-buttonbar">
       <div class="fileupload-buttons">
            <!-- The fileinput-button span is used to style the file input field as button -->
            <label class="jqhfu-file-container">
              Add files...
                <input type="file" name="files[]" multiple class="jqhfu-inputfile">
            </label>
			<button type="submit" class="start jqhfu-button">Start upload</button>
            <button type="reset" class="cancel jqhfu-button">Cancel upload</button>
            <button type="button" class="delete jqhfu-button">Delete</button>
            <input type="checkbox" class="toggle">
            <!-- The global file processing state -->
            <span class="fileupload-process"></span>
        </div>
        <!-- The global progress state -->
        <div class="fileupload-progress jqhfu-fade" style="display:none;max-width:500px;margin-top:2px;">
            <!-- The global progress bar -->
            <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
            <!-- The extended global progress state -->
            <div class="progress-extended">&nbsp;</div>
        </div>
    </div>
    <!-- The table listing the files available for upload/download -->
	<div class="jqhfu-upload-download-table">
    <table role="presentation"><tbody class="files"></tbody></table>
	</div>	
    </form>
   
<!-- The blueimp Gallery widget -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload jqhfu-fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name" style="max-width:190px;overflow-x:hidden;">{%=file.name%}</p>
            <strong class="error"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress"></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="start jqhfu-button" disabled>Start</button>
            {% } %}
            {% if (!i) { %}
                <button class="cancel jqhfu-button">Cancel</button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download jqhfu-fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name" style="max-width:190px;overflow-x:hidden;">
                <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
            </p>
            {% if (file.error) { %}
                <div><span class="error">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            <button class="delete jqhfu-button" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}&action=load_ajax_function"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>Delete</button>
            <input type="checkbox" name="delete" value="1" class="toggle">
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