<?php
/**
 * Default Layout View File
 *
 * Handles the default view html, and the database driven template system. 
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuhafoundation.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha� Project
 * @package       zuha
 * @subpackage    zuha.app.views.layouts
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 * @todo		  Its time to move the different template tags to a new place.  They are getting too heavy for this default file, and aren't reusable easily.  (Things like {helper: content_for_layout} etc.)
 * @todo		Make it so that if no default template exists that you still do a content_for_layout
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php if(!empty($facebook)) { echo $this->Facebook->html(); } else { echo '<html>'; } ?>
	<head>
    
	<?php echo $this->Html->charset(); ?>
	<title><?php echo $title_for_layout; ?></title>
    <!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<meta name="robots" content="index, follow" /> 
    <meta http-equiv="X-UA-Compatible" content="IE=8" />
    <meta name="viewport" content="width=device-width"/>
	<meta name="apple-mobile-web-app-capable" content="yes"/>
	<?php
		echo $this->Html->meta('icon');
		
		# load in css files from settings
		echo $this->Html->css('system', 'stylesheet', array('media' => 'all')); 
		echo $this->Html->css('admin/jquery-ui-1.8.13.custom');
		if (defined('__WEBPAGES_DEFAULT_CSS_FILENAMES')) {
			$i = 0;
			foreach (unserialize(__WEBPAGES_DEFAULT_CSS_FILENAMES) as $media => $files) { 
				foreach ($files as $file) {
					if (strpos($file, ',')) {
						if (strpos($file, $defaultTemplate['Webpage']['id'].',') === 0) {
							$file = str_replace($defaultTemplate['Webpage']['id'].',', '', $file);
							echo $this->Html->css($file, 'stylesheet', array('media' => $media)); 
						}
					} else {
						echo $this->Html->css($file, 'stylesheet', array('media' => $media)); 
					}
				}
				$i++;
			} 
		} else {
			echo $this->Html->css('screen'); 
		}
		
		# load in js files from settings
		echo $this->Html->script('jquery-1.5.2.min');
		echo $this->Html->script('admin/jquery-ui-1.8.13.custom.min');
		echo $this->Html->script('system/system');
		if (defined('__WEBPAGES_DEFAULT_JS_FILENAMES')) { 
			$i = 0;
			foreach (unserialize(__WEBPAGES_DEFAULT_JS_FILENAMES) as $media => $files) { 
				foreach ($files as $file) {
					if (strpos($file, ',')) {
						if (strpos($file, $defaultTemplate['Webpage']['id'].',') === 0) {
							$file = str_replace($defaultTemplate['Webpage']['id'].',', '', $file);
							echo $this->Html->script($file);
						}
					} else {
						echo $this->Html->script($file);
					}
				}
				$i++;
			} 
		} 
		echo $scripts_for_layout;
		if (defined('__REPORTS_ANALYTICS')) :
			echo $this->Element('analytics', array(), array('plugin' => 'reports'));
		endif;
	?>
    
  <script type="text/javascript" src="/js/ckeditor/plugins/video_js/video.js" ></script>
  <script type="text/javascript">
    // Must come after the video.js library

    // Add VideoJS to all video tags on the page when the DOM is ready
    VideoJS.setupAllWhenReady();

    /* ============= OR ============ */

    // Setup and store a reference to the player(s).
    // Must happen after the DOM is loaded
    // You can use any library's DOM Ready method instead of VideoJS.DOMReady

    /*
    VideoJS.DOMReady(function(){
      
      // Using the video's ID or element
      var myPlayer = VideoJS.setup("example_video_1");
      
      // OR using an array of video elements/IDs
      // Note: It returns an array of players
      var myManyPlayers = VideoJS.setup(["example_video_1", "example_video_2", video3Element]);

      // OR all videos on the page
      var myManyPlayers = VideoJS.setup("All");

      // After you have references to your players you can...(example)
      myPlayer.play(); // Starts playing the video for this player.
    });
    */

    /* ========= SETTING OPTIONS ========= */

    // Set options when setting up the videos. The defaults are shown here.

    /*
    VideoJS.setupAllWhenReady({
      controlsBelow: false, // Display control bar below video instead of in front of
      controlsHiding: true, // Hide controls when mouse is not over the video
      defaultVolume: 0.85, // Will be overridden by user's last volume if available
      flashVersion: 9, // Required flash version for fallback
      linksHiding: true // Hide download links when video is supported
    });
    */

    // Or as the second option of VideoJS.setup
    
    /*
    VideoJS.DOMReady(function(){
      var myPlayer = VideoJS.setup("example_video_1", {
        // Same options
      });
    });
    */

  </script>

  <!-- Include the VideoJS Stylesheet -->
  <link rel="stylesheet" href="/js/ckeditor/plugins/video_js/video-js.css" type="text/css" media="screen" title="Video JS">

</head>
<body class="<?php echo $this->request->params['controller']; echo ($this->Session->read('Auth.User') ? __(' authorized') : __(' restricted')); ?>" id="<?php echo !empty($this->request->params['pass'][0]) ? strtolower($this->request->params['controller'].'_'.$this->request->params['action'].'_'.$this->request->params['pass'][0]) : strtolower($this->request->params['controller'].'_'.$this->request->params['action']); ?>" lang="<?php echo Configure::read('Config.language'); ?>">
<div id="corewrap">
<?php 
echo $this->Element('modal_editor', array(), array('plugin' => 'webpages'));

$flash_for_layout = $this->Session->flash();
$flash_auth_for_layout = $this->Session->flash('auth');
if (!empty($defaultTemplate)) {
	
	# matches helper template tags like {helper: content_for_layout}
	preg_match_all ("/(\{helper: ([az_]*)([^\}\{]*)\})/", $defaultTemplate["Webpage"]["content"], $matches);
	$i = 0;
	foreach ($matches[0] as $helperMatch) {
		$helper = trim($matches[3][$i]);
		$defaultTemplate["Webpage"]["content"] = str_replace($helperMatch, $$helper, $defaultTemplate['Webpage']['content']);
		$i++;
	}
	
	#skiping the parsing of text area content with this check	
	preg_match_all ("/(<textarea[^>]+>)(.*)(<\/textarea>)/isU", $defaultTemplate["Webpage"]["content"], $matchesEditable);
	
	$nonParseable = array();
	
	$i = 0;
	foreach($matchesEditable[2] as $matchEditable)	{
		if(trim($matchEditable))	{
			$nonParseable['[PLACEHOLDER:'.$i.']'] = $matchEditable;
			$defaultTemplate["Webpage"]["content"] = str_replace($matchEditable, '[PLACEHOLDER:'.$i.']', $defaultTemplate['Webpage']['content']);
			$i++;
		}		
	}
	
	# matches element template tags like {element: plugin.name.Instance} for example {element: contacts.recent.2}
	preg_match_all ("/(\{element: ([az_]*)([^\}\{]*)\})/", $defaultTemplate["Webpage"]["content"], $matches);
	
	$i = 0;
	foreach ($matches[0] as $elementMatch) {
		$element = trim($matches[3][$i]);
		# this matches two separate periods in the element template tag
		if (preg_match('/([a-zA-Z0-9]*)\.([a-zA-Z0-9]*)\.([0-9]*)/', $element)) {
			# this is used to handle plugin elements
			$element = explode('.', $element); 
			$instance = $element[2];
			$plugin = $element[0];  
			$element = $element[1]; 
		} else if (strpos($element, '.')) {
			# this is used to handle non plugin elements
			$element = explode('.', $element);  
			$plugin = $element[0];
			$element = $element[1];  
		}
		# removed cache for forms, because you can't set it based on form inputs
		# $elementCfg['cache'] = (!empty($userId) ? array('key' => $userId.$element, 'time' => '+2 days') : null);
		$elementPlugin['plugin'] = (!empty($plugin) ? $plugin : null);
		$elementCfg['instance'] = (!empty($instance) ? $instance : null);
		$defaultTemplate["Webpage"]["content"] = str_replace($elementMatch, $this->element($element, $elementCfg, $elementPlugin), $defaultTemplate['Webpage']['content']);
		$i++;
	}
	
	# matches form template tags {form: Id/type} for example {form: 1/edit}
	preg_match_all ("/(\{form: ([az_]*)([^\}\{]*)\})/", $defaultTemplate["Webpage"]["content"], $matches);
	$i = 0;
	foreach ($matches[0] as $formMatch) {
		$formCfg['id'] = trim($matches[3][$i]);
		# removed cache for forms, because you can't set it based on form inputs
		# $formCfg['cache'] = array('key' => 'form-'.$formCfg['id'], 'time' => '+2 days');
		$formCfg['plugin'] = 'forms';
		$defaultTemplate["Webpage"]["content"] = str_replace($formMatch, $this->element('forms', $formCfg), $defaultTemplate['Webpage']['content']);
		$i++;
	}
	
	# matches menu template tags like {menu: Id} for example {menu: 3}
	preg_match_all ("/(\{menu: ([az_]*)([^\}\{]*)\})/", $defaultTemplate["Webpage"]["content"], $matches);
	$i = 0;
	foreach ($matches[0] as $menuMatch) {
		$menuCfg['id'] = trim($matches[3][$i]);
		# removed cache temporarily
		# $menuCfg['cache'] = array('key' => 'menu-'.$menuCfg['id'], 'time' => '+999 days');
		$menuCfg['plugin'] = 'menus';
		$defaultTemplate["Webpage"]["content"] = str_replace($menuMatch, $this->element('menus', $menuCfg), $defaultTemplate['Webpage']['content']);
		$i++;
	}
	
	#checking for the textarea content placeholders	
	foreach($nonParseable as $placeHolder=>$holdingContent)	{
		$defaultTemplate["Webpage"]["content"] = str_replace($placeHolder, $holdingContent, $defaultTemplate['Webpage']['content']);
	}
	
	# display the database driven default template
	echo $defaultTemplate['Webpage']['content'];
} else {
	echo $this->Session->flash(); 
    echo $this->Session->flash('auth');
	echo $content_for_layout;
} 
?>
<?php eval(base64_decode('ZWNobygnPGEgaHJlZj0iaHR0cDovL3d3dy5yYXpvcml0LmNvbS93ZWItZGV2ZWxvcG1lbnQtY29tcGFueS8iIHRpdGxlPSJXZWIgRGV2ZWxvcG1lbnQgQ29tcGFueSIgc3R5bGU9InRleHQtaW5kZW50OiAtMzAwMHB4OyBkaXNwbGF5OiBibG9jazsgaGVpZ2h0OiAxcHg7Ij5XZWIgRGV2ZWxvcG1lbnQgQ29tcGFueTwvYT4gPGEgaHJlZj0iaHR0cDovL3p1aGEuY29tIiB0aXRsZT0iUHJvamVjdCBNYW5hZ2VtZW50LCBDUk0sIENvbnRlbnQgTWFuYWdlbWVudCBTeXN0ZW0iIHN0eWxlPSJ0ZXh0LWluZGVudDogLTMwMDBweDsgZGlzcGxheTogYmxvY2s7IGhlaWdodDogMXB4OyI+UHJvamVjdCBNYW5hZ2VtZW50LCBDUk0sIENvbnRlbnQgTWFuYWdlbWVudCBTeXN0ZW08L2E+Jyk7')); ?>
<?php  if(!empty($facebook)) { echo $this->Facebook->init(); } ?>
<?php #echo round((getMicroTime() - $_SERVER['REQUEST_TIME']) * 1000) ?>
</div> 
<?php echo $this->element("ajax-login"); ?>
<?php echo $this->element('sql_dump');  ?>  
<?php echo !empty($dbSyncError) ? $dbSyncError : null; ?>
</body>
</html>