=== JQuery Html5 File Upload ===
Contributors: sinashshajahan
Donate link: 
Tags: jQuery Fileupload, Frontend Fileupload, Frontend, Media Upload, Picture Upload, Upload, Ajax Upload, HTML5, Progress Bar, Upload File, Uploadfile, Ajax Based File Uploader, File Uploader, Image Uploader, Progress bar, User Desgins Uploader, User Files, User Files Manager
Requires at least: 2.8.6
Tested up to: 4.0
Stable tag: 3.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin adds a file upload functionality to the front-end screen. It allows multiple file upload asynchronously along with upload status bar.

== Description ==

October 3rd 2014 - "Sorry for the delay in responding to your support queries. Going forward, the plugin will be actively maintained"

"Activate Plugin And Place [jquery_file_upload] In Your Post", so simple... right? :)

Note: Now You Can View the Uploaded Files At Your Admin Console

This plugin adds a file upload functionality to the front-end screen. It allows multiple file upload asynchronously along with upload status bar. It also lists the uploaded files as a gallery and allows us to delete the uploaded files. This is well suited for users who want to submit files to the admin, but can be altered in any required form. It make use of the HTML5 capability of the browser and fallback gracefully for browsers not supporting HTML5. 

The main advantage of this plugin is that it does not use flash and that it doesn't need any third party plugin. The uploaded files are stored under the 'upload' folder under the sub folder 'files' where the files are segregated based on the logged in user into different folders.

This plugin mainly make use of the JQuery File Upload plugin (http://blueimp.github.com/jQuery-File-Upload/). Please refer to the link for more features of the plugin. Also, feel free to modify the plugin as per your needs

Features 

1. View files at admin console:
   View the uploaded files at the wp-admin console
2. Multiple file upload:
   Allows to select multiple files at once and upload them simultaneously.
2. Drag & Drop support:
   Allows to upload files by dragging them from your desktop or filemanager and dropping them on your browser window.
4. Upload progress bar:
   Shows a progress bar indicating the upload progress for individual files and for all uploads combined.
5. Preview images:
   A preview of image files can be displayed before uploading with browsers supporting the required JS APIs.
6. No browser plugins (e.g. Adobe Flash) required:
   The implementation is based on open standards like HTML5 and JavaScript and requires no additional browser plugins.
7. Graceful fallback for legacy browsers:
   Uploads files via XMLHttpRequests if supported and uses iframes as fallback for legacy browsers.
8. HTML file upload form fallback:
   Allows progressive enhancement by using a standard HTML file upload form as widget element.
9. Cross-site file uploads:
   Supports uploading files to a different domain with cross-site XMLHttpRequests or iframe redirects.
10.Multiple plugin instances:
   Allows to use multiple plugin instances on the same webpage.
11.Customizable and extensible:
    You can change the settings from the admin panel.

== Installation ==

1. Upload the plugin 'jquery-html5-file-upload.zip' to the `/wp-content/plugins/` directory and extract it.
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place [jquery_file_upload] in your post where you want to display the file upload button. (You can also place `<?php jquery_html5_file_upload_hook(); ?>` in your template where you want to display the )
4. By defalut, it uploads jpg, jpeg, png and gif files with a file size limit of 5MB. You can change this setting to accept any file type by changing it in the settings file (Admin Panel->Settings->JQuery HTML5 File Upload Settings). You can also set the width and height of the thumbnail image here.

== Frequently asked questions ==

I uploaded and activated the plugin, whats next?

Once the plugin is activated, you can simply use '[jquery_file_upload]' in any of the post whaere you want to display the upload button or you can modify the theme template by adding `<?php jquery_html5_file_upload_hook(); ?>` in your theme template where you want to display the upload buttons.

Does this file upload functionality work in all the browsers?

It works in browsers like Google Chrome, Apple Safari 4.0+, Mozilla Firefox 3.0+, Opera 11.0+ and Microsoft Internet Explorer 6.0+. It should also work in any other browser.

== Screenshots ==

1. screenshot-1.jpg
2. screenshot-2.jpg
3. screenshot-3.jpg
4. screenshot-4.jpg
5. screenshot-5.jpg

== Changelog ==

Version 3.0

Fixes
Fixed the issue with the delete functionality
Fixed the layout issue in desktop screen
Fixed the layout issue in mobile screen
Fixed the progress bar layout issue
Fixed the add files button issue.

Enhancements
Modified to load all the JS and CSS files from the plugin directory
Eliminated inclusion of unwanted JS and CSS files

Version 2.2

Fixed the issue with the file upload and partial upload

Version 2.1

Fixed the plugin breakage. A major release coming soon.

Version 2.0

View the uploaded file at the wp-admin console.

Version 1.2

Provided the provision to change some of the settings through wp-admin
provided shortcut to add in the post

Version 1.1

Initial version


== Upgrade notice ==

Provided the provision to change some of the settings through wp-admin and also provided shortcut to add in the post and view the uploaded file at the wp-admin console.

== Arbitrary section 1 ==

