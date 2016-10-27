<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * RD Critical CSS
 * 
 * @package		ExpressionEngine
 * @category	Plugin
 * @author		Jarrod D Nix, Reusser Design
 * @license		https://opensource.org/licenses/MIT The MIT License (MIT)
 */

class Rd_critical_css
{

	public $return_data  = "";

	public function __construct()
	{
	
		if (version_compare(APP_VER, '3', '>='))
		{
			ob_start();
?>

<script>!function(w){"use strict";var loadCSS=function(href,before,media){function ready(cb){return doc.body?cb():void setTimeout(function(){ready(cb)})}function loadCB(){ss.addEventListener&&ss.removeEventListener("load",loadCB),ss.media=media||"all"}var ref,doc=w.document,ss=doc.createElement("link");if(before)ref=before;else{var refs=(doc.body||doc.getElementsByTagName("head")[0]).childNodes;ref=refs[refs.length-1]}var sheets=doc.styleSheets;ss.rel="stylesheet",ss.href=href,ss.media="only x",ready(function(){ref.parentNode.insertBefore(ss,before?ref:ref.nextSibling)});var onloadcssdefined=function(cb){for(var resolvedHref=ss.href,i=sheets.length;i--;)if(sheets[i].href===resolvedHref)return cb();setTimeout(function(){onloadcssdefined(cb)})};return ss.addEventListener&&ss.addEventListener("load",loadCB),ss.onloadcssdefined=onloadcssdefined,onloadcssdefined(loadCB),ss};"undefined"!=typeof exports?exports.loadCSS=loadCSS:w.loadCSS=loadCSS}("undefined"!=typeof global?global:this),function(w){if(w.loadCSS){var rp=loadCSS.relpreload={};if(rp.support=function(){try{return w.document.createElement("link").relList.supports("preload")}catch(e){return!1}},rp.poly=function(){for(var links=w.document.getElementsByTagName("link"),i=0;i<links.length;i++){var link=links[i];"preload"===link.rel&&"style"===link.getAttribute("as")&&(w.loadCSS(link.href,link),link.rel=null)}},!rp.support()){rp.poly();var run=w.setInterval(rp.poly,300);w.addEventListener&&w.addEventListener("load",function(){w.clearInterval(run)}),w.attachEvent&&w.attachEvent("onload",function(){w.clearInterval(run)})}}}(this);</script>

<?php
			$buffer = ob_get_contents();
			ob_end_clean();

			$file = ee()->TMPL->fetch_param('file') ? ee()->TMPL->fetch_param('file') : FALSE;
	
			if ($file && file_exists($_SERVER['DOCUMENT_ROOT'].$file))
			{	
				$return = file_get_contents($_SERVER['DOCUMENT_ROOT'].$file);
				
				// Remove any source map comments, i.e. /*# sourceMappingURL=critical.css.map */
				$return = preg_replace("(\n\/\*\#.*\*\/)", "", $return);
				
				$this->return_data = "<style>" . $return . "</style>" . $buffer;
			
			}
		}
	}

	/**
	* Plugin Usage
	*/
	
	// This function describes how the plugin is used.
	//  Make sure and use output buffering
	
	public static function usage()
	{
		ob_start(); 
?>

Invoke the {exp:rd_critical_css} tag with a file parameter that points to your critical css file, i.e.

{exp:rd_critical_css file='path/to/critical.css'}

Critical CSS will inject the contents of your critical css file into the head so that above-the-fold content will be styled without blocking the rendering of the page.

Recommended to use in conjunction with loadCSS to load stylesheets asynchronously: https://github.com/filamentgroup/loadCSS

<?php
		$buffer = ob_get_contents();
		ob_end_clean();

		return $buffer;
	}
	// END

}


/* End of file pi.rd_critical_css.php */
/* Location: ./system/user/addons/rd_critical_css/pi.rd_critical_css.php */
