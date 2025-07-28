$(function () {
	"use strict";
	/* perfect scrol bar */
	// new PerfectScrollbar(".scroll-menu");
	// new PerfectScrollbar(".app-container");
	// new PerfectScrollbar('.header-message-list');
	// new PerfectScrollbar('.header-notifications-list');
	// search bar
	$(".mobile-search-icon").on("click", function () {
		$(".search-bar").addClass("full-search-bar");
	});
	$(".search-close").on("click", function () {
		$(".search-bar").removeClass("full-search-bar");
	});

	$(function() {
		for (var e = window.location, o = $(".navbar-nav .dropdown-item").filter(function() {
				return this.href == e
			}).addClass("active").parent().addClass("active"); o.is("li");) o = o.parent("").addClass("").parent("").addClass("")
	}),
	
	$(".dark-mode").on("click", function() {

		if($(".dark-mode-icon i").attr("class") == 'bx bx-sun') {
			$(".dark-mode-icon i").attr("class", "bx bx-moon");
			$("html").attr("class", "light-theme")
		} else {
			$(".dark-mode-icon i").attr("class", "bx bx-sun");
			$("html").attr("class", "dark-theme")
		}

	}), 

	// toggle menu button
	$(".toggle-icon").click(function () {
		if ($(".wrapper").hasClass("toggled")) {
			// unpin sidebar when hovered
			$(".wrapper").removeClass("toggled");
			$(".sidebar-wrapper").unbind("hover");
		} else {
			$(".wrapper").addClass("toggled");
			$(".sidebar-wrapper").hover(function () {
				$(".wrapper").addClass("sidebar-hovered");
			}, function () {
				$(".wrapper").removeClass("sidebar-hovered");
			})
		}
	});
	/* Back To Top */
	$(document).ready(function () {
		$(window).on("scroll", function () {
			if ($(this).scrollTop() > 300) {
				$('.back-to-top').fadeIn();
			} else {
				$('.back-to-top').fadeOut();
			}
		});
		$('.back-to-top').on("click", function () {
			$("html, body").animate({
				scrollTop: 0
			}, 600);
			return false;
		});
	});
	$(function () {
		for (var i = window.location, o = $(".metismenu li a").filter(function () {
			return this.href == i;
		}).addClass("").parent().addClass("");;) {
			if (!o.is("li")) break;
			o = o.parent("").addClass("").parent("").addClass("");
		}
	}),	
	$('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
		if (!$(this).next().hasClass('show')) {
		  $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
		}
		var $subMenu = $(this).next(".dropdown-menu");
		$subMenu.toggleClass('show');
	  
	  
		$(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
		  $('.submenu .show').removeClass("show");
		});  
		return false;
	  });
});