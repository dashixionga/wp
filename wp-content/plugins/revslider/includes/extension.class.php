<?php
/**
 * @package RevSliderExtension
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.sliderrevolution.com/
 * @copyright 2024 ThemePunch
 */
 
if(!defined('ABSPATH')) exit();

class RevSliderExtension {
	
	public function __construct() {
		$this->init_essential_grid_extensions();
	}
	
	
	/***************************
	 * Setup part for Revslider inclusion into Essential Grid
	 ***************************/
	
	/**
	 * Do all initializations for RevSlider integration
	 */
	public function init_essential_grid_extensions(){
		
		if(!class_exists('Essential_Grid')) return false; //only add if Essential Grid is installed
		
		add_filter('essgrid_set_ajax_source_order', array($this, 'add_slider_to_eg_ajax'));
		add_filter('essgrid_handle_ajax_content', array($this, 'set_slider_values_to_eg_ajax'), 10, 4);
		add_action('essgrid_add_meta_options', array($this, 'add_eg_additional_meta_field'));
		add_action('essgrid_save_meta_options', array($this, 'save_eg_additional_meta_field'), 10, 2);
		
		//only do on frontend
		add_action('admin_head', array($this, 'add_eg_additional_inline_javascript'));
		add_action('wp_footer', array($this, 'add_eg_additional_inline_javascript'));
	}
	
	
	/**
	 * Add Slider to the List of choosable media
	 */
	public function add_slider_to_eg_ajax($media){
		
		$media['revslider'] = array('name' => __('Slider Revolution', 'revslider'), 'type' => 'ccw');
		
		return $media;
	}
	
	
	/**
	 * Add Slider to the List of choosable media
	 */
	public function set_slider_values_to_eg_ajax($handle, $media_sources, $post, $grid_id){
		
		if($handle !== 'revslider') return false;
		
		$slider_source	= '';
		$values			= get_post_custom($post['ID']);
		
		if(isset($values['eg_sources_revslider'])){
			if(isset($values['eg_sources_revslider'][0])){
				$slider_source = (isset($values['eg_sources_revslider'][0])) ? $values['eg_sources_revslider'][0] : '';
			}else{
				$slider_source = (isset($values['eg_sources_revslider'])) ? $values['eg_sources_revslider'] : '';
			}
		}
		
		return ($slider_source === '') ? false : ' data-ajaxtype="'.$handle.'" data-ajaxsource="'.$slider_source.'"';
	}
	
	
	/**
	 * Adds custom meta field into the essential grid meta box for post/pages
	 */
	public function add_eg_additional_meta_field($values){
		
		$sld = new RevSliderSlider();
		$sliders = $sld->get_sliders();
		$shortcodes = array();
		if(!empty($sliders)){
			$first = true;
			foreach($sliders as $slider){
				$name = $slider->get_param('shortcode','false');
				if($name != 'false'){
					$shortcodes[$slider->get_id()] = $name;
					$first = false;
				}
			}
		}
		
		$selected_slider = (isset($values['eg_sources_revslider'])) ? $values['eg_sources_revslider'] : '';
		if($selected_slider == ''){
			$selected_slider = array();
			$selected_slider[0] = '';
		}
		?>
		<p><strong style="font-size:14px"><?php _e('Choose Revolution Slider', 'revslider'); ?></strong></p>
		<p>
			<select name="eg_sources_revslider" id="eg_sources_revslider">
				<option value=""<?php selected($selected_slider[0], ''); ?>><?php _e('--- Choose Slider ---', 'revslider'); ?></option>
				<?php
				foreach($shortcodes ?? [] as $id => $name){
					?>
					<option value="<?php echo $id; ?>"<?php selected($selected_slider[0], $id); ?>><?php echo $name; ?></option>
					<?php
				}
				?>
			</select>
		</p>
		<?php
	}
	
	/**
	 * Adds custom meta field into the essential grid meta box for post/pages
	 */
	public function save_eg_additional_meta_field($metas, $post_id){
		if(isset($metas['eg_sources_revslider'])) update_post_meta($post_id, 'eg_sources_revslider', $metas['eg_sources_revslider']);
	}
	
	
	/**
	 * Adds needed javascript to the DOM
	 */
	public function add_eg_additional_inline_javascript(){
		?><script>var ajaxRevslider;function rsCustomAjaxContentLoadingFunction(){ajaxRevslider=function(obj){var content='',data={action:'revslider_ajax_call_front',client_action:'get_slider_html',token:'<?php echo wp_create_nonce("RevSlider_Front");?>',type:obj.type,id:obj.id,aspectratio:obj.aspectratio};jQuery.ajax({type:'post',url:'<?php echo admin_url("admin-ajax.php");?>',dataType:'json',data:data,async:false,success:function(ret,textStatus,XMLHttpRequest){if(ret.success==true)content=ret.data;},error:function(e){console.log(e);}});return content;};var ajaxRemoveRevslider=function(obj){return jQuery(obj.selector+' .rev_slider').revkill();};if(jQuery.fn.tpessential!==undefined)if(typeof(jQuery.fn.tpessential.defaults)!=='undefined')jQuery.fn.tpessential.defaults.ajaxTypes.push({type:'revslider',func:ajaxRevslider,killfunc:ajaxRemoveRevslider,openAnimationSpeed:0.3});}var rsCustomAjaxContent_Once=false;if(document.readyState==="loading")document.addEventListener('readystatechange',function(){if((document.readyState==="interactive"||document.readyState==="complete")&&!rsCustomAjaxContent_Once){rsCustomAjaxContent_Once=true;rsCustomAjaxContentLoadingFunction();}});else{rsCustomAjaxContent_Once=true;rsCustomAjaxContentLoadingFunction();}</script><?php
		/*
		unminimized code:
		<script>
			var ajaxRevslider;
			function rsCustomAjaxContentLoadingFunction() {
				// CUSTOM AJAX CONTENT LOADING FUNCTION
				ajaxRevslider = function(obj) {
				
					// obj.type : Post Type
					// obj.id : ID of Content to Load
					// obj.aspectratio : The Aspect Ratio of the Container / Media
					// obj.selector : The Container Selector where the Content of Ajax will be injected. It is done via the Essential Grid on Return of Content
					
					var content	= '';
					var data	= {
						action:			'revslider_ajax_call_front',
						client_action:	'get_slider_html',
						token:			'<?php echo wp_create_nonce('RevSlider_Front'); ?>',
						type:			obj.type,
						id:				obj.id,
						aspectratio:	obj.aspectratio
					};
					
					// SYNC AJAX REQUEST
					jQuery.ajax({
						type:		'post',
						url:		'<?php echo admin_url('admin-ajax.php'); ?>',
						dataType:	'json',
						data:		data,
						async:		false,
						success:	function(ret, textStatus, XMLHttpRequest) {
							if(ret.success == true)
								content = ret.data;								
						},
						error:		function(e) {
							console.log(e);
						}
					});
					
					 // FIRST RETURN THE CONTENT WHEN IT IS LOADED !!
					 return content;						 
				};
				
				// CUSTOM AJAX FUNCTION TO REMOVE THE SLIDER
				var ajaxRemoveRevslider = function(obj) {
					return jQuery(obj.selector + ' .rev_slider').revkill();
				};


				// EXTEND THE AJAX CONTENT LOADING TYPES WITH TYPE AND FUNCTION				
				if (jQuery.fn.tpessential !== undefined) 					
					if(typeof(jQuery.fn.tpessential.defaults) !== 'undefined') 
						jQuery.fn.tpessential.defaults.ajaxTypes.push({type: 'revslider', func: ajaxRevslider, killfunc: ajaxRemoveRevslider, openAnimationSpeed: 0.3});   
						// type:  Name of the Post to load via Ajax into the Essential Grid Ajax Container
						// func: the Function Name which is Called once the Item with the Post Type has been clicked
						// killfunc: function to kill in case the Ajax Window going to be removed (before Remove function !
						// openAnimationSpeed: how quick the Ajax Content window should be animated (default is 0.3)					
			}
			
			var rsCustomAjaxContent_Once = false
			if (document.readyState === "loading") 
				document.addEventListener('readystatechange',function(){
					if ((document.readyState === "interactive" || document.readyState === "complete") && !rsCustomAjaxContent_Once) {
						rsCustomAjaxContent_Once = true;
						rsCustomAjaxContentLoadingFunction();
					}
				});
			else {
				rsCustomAjaxContent_Once = true;
				rsCustomAjaxContentLoadingFunction();
			}					
		</script>
		<?php
		*/
	}
	
}

global $revext;
$revext	= new RevSliderExtension();