
var WPlabAlbedoSetupWizard = (function($){

		var t;

		// callbacks from form button clicks.
		var callbacks = {
			install_plugins: function(btn){
				var plugins = new PluginManager();
				plugins.init(btn);
			}
		};

		function window_loaded(){
			// init button clicks:
			$('.button-next').on( 'click', function(e) {

				var loading_button = wplab_loading_button(this);
				if(!loading_button){
						return false;
				}
				if($(this).data('callback') && typeof callbacks[$(this).data('callback')] != 'undefined'){
						// we have to process a callback before continue with form submission
						callbacks[$(this).data('callback')](this);
						return false;
				}else{
						loading_content();
						return true;
				}

			});

		}

		function loading_content(){
			$('.wplab-albedo-setup-content').block({
				message: null,
				overlayCSS: {
					background: '#fff',
					opacity: 0.6
				}
			});
		}

		function PluginManager(){

			var complete;
			var items_completed = 0;
			var current_item = '';
			var $current_node;
			var current_item_hash = '';

			function ajax_callback(response){
				if(typeof response == 'object' && typeof response.message != 'undefined'){
					$current_node.find('span').text(response.message);
					if(typeof response.url != 'undefined'){
							// we have an ajax url action to perform.

						if(response.hash == current_item_hash){
							$current_node.find('span').text("failed");
							find_next();
						} else {
							current_item_hash = response.hash;
							jQuery.post(response.url, response, function(response2) {
								process_current();
								$current_node.find('span').text(response.message + wplab_albedo_wizard_params.verify_text);
							}).fail(ajax_callback);
						}

					} else if(typeof response.done != 'undefined'){
						// finished processing this plugin, move onto next
						find_next();
					} else{
						// error processing this plugin
						find_next();
					}
				} else{
					// error - try again with next plugin
					$current_node.find('span').text("ajax error");
					find_next();
				}
			}
			function process_current(){
				if(current_item){
					// query our ajax handler to get the ajax to send to TGM
					// if we don't get a reply we can assume everything worked and continue onto the next one.
					jQuery.post(wplab_albedo_wizard_params.ajaxurl, {
						action: 'wplab_albedo_setup_plugins_wizard',
						wpnonce: wplab_albedo_wizard_params.wpnonce,
						slug: current_item
					}, ajax_callback).fail(ajax_callback);
				}
			}
			function find_next(){
				var do_next = false;
				if($current_node){
					if(!$current_node.data('done_item')){
						items_completed++;
						$current_node.data('done_item',1);
					}
					$current_node.find('.spinner').css('visibility','hidden');
				}
				var $li = $('.envato-wizard-plugins li');
				$li.each(function(){
					if(current_item == '' || do_next){
						current_item = $(this).data('slug');
						$current_node = $(this);
						process_current();
						do_next = false;
					}else if($(this).data('slug') == current_item){
						do_next = true;
					}
				});
				if(items_completed >= $li.length){
					// finished all plugins!
					complete();
				}
			}

			return {
				init: function(btn){
					$('.envato-wizard-plugins').addClass('installing');
					complete = function(){
						loading_content();
						window.location.href=btn.href;
					};
					find_next();
				}
			}
		}

	function wplab_loading_button(btn){

		var $button = jQuery(btn);

		if($button.data('done-loading') == 'yes') return false;

		var existing_text = $button.text();
		var existing_width = $button.outerWidth();
		var loading_text = '⡀⡀⡀⡀⡀⡀⡀⡀⡀⡀⠄⠂⠁⠁⠂⠄';
		var completed = false;

		$button.css('width',existing_width);
		$button.addClass('wplab_loading_button_current');
		var _modifier = $button.is('input') || $button.is('button') ? 'val' : 'text';
		$button[_modifier](loading_text);
		//$button.attr('disabled',true);
		$button.data('done-loading','yes');

		var anim_index = [0,1,2];

		// animate the text indent
		function moo() {
			if (completed)return;
			var current_text = '';
			// increase each index up to the loading length
			for(var i = 0; i < anim_index.length; i++){
				anim_index[i] = anim_index[i]+1;
				if(anim_index[i] >= loading_text.length)anim_index[i] = 0;
				current_text += loading_text.charAt(anim_index[i]);
			}
			$button[_modifier](current_text);
			setTimeout(function(){ moo();},60);
		}

		moo();

		return {
			done: function(){
				completed = true;
				$button[_modifier](existing_text);
				$button.removeClass('wplab_loading_button_current');
				$button.attr('disabled',false);
			}
		}

	}

	return {
		init: function(){
			t = this;
			$(window_loaded);
		},
		callback: function(func){
			console.log(func);
			console.log(this);
		}
	}

})(jQuery);


WPlabAlbedoSetupWizard.init();
