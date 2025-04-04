var $j = jQuery.noConflict(); 
var jPMset = false;
$j(function () {
	 "use strict";
//================== Mobile Menu code ========================

	//console.log($j(document).width())
	if($j(document).width() < 1180){
		$j(".site-header").append('<span id="nav-trigger"></span>');
		var jPM = $j.jPanelMenu();
		jPM = $j.jPanelMenu({
			menu: '#menu-mobile-menu',
			trigger:'#nav-trigger',
			animated:false,
			direction: "right"
		});
		jPM.on();
		$j('#nav-trigger').click(function(){});
		jPMset = true;
	}
//================== Show/Hide ========================
	
	$j('.showhide_group').click(function(){showhide_group($j(this));return false;});

//================== Scroll to Top ========================

	$j('a.gototop').click(function() {
		$j('html, body').animate({scrollTop:0}, 'slow');
		return false;
	});

//================== Sub Menu ========================

	sub_menu();
	login_logo();

});

//================== Functions ========================

	// Show/Hide

		function showhide_group(obj){
			"use strict";
			var target = obj.attr('target');
			var group = obj.attr('group');
			$j('.group_active').removeClass('group_active');
			if($j('#'+target).length !== 0 && $j('#'+target).is(':hidden')){
				$j('.'+group).hide();
				$j('#'+target).show();
				obj.addClass('group_active');
			}else if($j('#'+target).length !== 0){
				$j('.'+group).hide();
				$j('#'+target).hide();
			}else if($j('.'+target).length !== 0 && $j('.'+target).is(':hidden')){
				$j('.'+group).hide();
				$j('.'+target).show();
				obj.addClass('group_active');
			}else if($j('.'+target).length !== 0){
				$j('.'+group).hide();
				$j('.'+target).hide();
			}
			return false;
		}

	// SubMenu

		function sub_menu(){
			$j('.menu-item-has-children').hover(function(){
				$j(this).children('.sub-menu').fadeIn('normal', 'linear');
			}, function(){
				$j(this).children('.sub-menu').fadeOut('normal', 'linear');
			});
		}

	// Login Logo

		function login_logo(){
			var image = $j('#login-logo');
			$j('#login h1').remove();
			$j('#login').prepend(image);
		}
