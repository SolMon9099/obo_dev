(function($) {
	'use strict';

	// Toggle
	hivetheme.getComponent('toggle').filter('[data-toggle]').each(function() {
		var toggle = $(this),
			id = toggle.data('toggle'),
			label = toggle.find('span'),
			caption = toggle.data('caption'),
			container = $('#' + id);

		if (container.length) {
			if (localStorage.getItem(id)) {
				toggle.attr('data-state', 'active');
				toggle.attr('data-caption', label.text());
				label.text(caption);
			} else {
				container.hide();
			}

			toggle.on('click', function() {
				container.toggle();

				if (toggle.attr('data-state') === 'active') {
					localStorage.removeItem(id);
				} else {
					localStorage.setItem(id, true);
				}
			});
		}
	});

	$('body').imagesLoaded(function() {

		// Slider
		hivetheme.getComponent('slider').each(function() {
			var container = $(this),
				slider = container.children('div:first'),
				slides = slider.children('div'),
				width = 420,
				settings = {
					prevArrow: '<i class="slick-prev fas fa-arrow-left"></i>',
					nextArrow: '<i class="slick-next fas fa-arrow-right"></i>',
					slidesToScroll: 1,
				};

			if (container.find('img').first().data('src')) {
				slider.on('init', function() {
					var images = container.find('img'),
						imageURLs = [];

					images.each(function() {
						imageURLs.push({
							src: $(this).data('src'),
						});
					});

					container.on('click', 'img', function() {
						var index = container.find('img').index($(this).get(0));

						if (index < imageURLs.length) {
							$.fancybox.open(imageURLs, {
								loop: true,
								buttons: ['close'],
							}, index);
						}
					});
				});
			}

			if (container.data('type') === 'carousel') {
				if (container.data('width')) {
					width = container.data('width');
				}

				$.extend(settings, {
					centerMode: true,
					slidesToShow: Math.ceil($(window).width() / width),
					responsive: [
						{
							breakpoint: 1025,
							settings: {
								slidesToShow: 3,
							},
						},
						{
							breakpoint: 769,
							settings: {
								slidesToShow: 2,
							},
						},
						{
							breakpoint: 481,
							settings: {
								slidesToShow: 1,
								centerMode: false,
							},
						},
					],
				});

				if (settings['slidesToShow'] > slides.length) {
					settings['slidesToShow'] = slides.length;
				}
			} else {
				width = $('#content').children('div:first').width();

				$.extend(settings, {
					slidesToShow: 1,
					variableWidth: true,
					centerMode: true,
					speed: 650,
				});

				slides.width(width);
			}

			if (container.data('pause')) {
				$.extend(settings, {
					autoplay: true,
					autoplaySpeed: parseInt(container.data('pause')),
				});
			}

			slider.slick(settings);
		});

		// Rating
		hivetheme.getComponent('circle-rating').each(function() {
			var container = $(this);

			container.circleProgress({
				size: 28,
				emptyFill: 'transparent',
				fill: container.css('color'),
				thickness: 3,
				animation: false,
				startAngle: -Math.PI / 2,
				reverse: true,
				value: parseFloat(container.data('value')) / 5,
			});
		});

		// Buttons
		$('.button, button, input[type="submit"], .wp-block-button__link, .hp-feature__icon').each(function() {
			var button = $(this),
				color = button.css('background-color');

			if (button.css('box-shadow') === 'none' && color.indexOf('rgb(') === 0) {
				color = color.replace('rgb(', 'rgba(').replace(')', ',.35)');

				button.css('box-shadow', '0 5px 21px ' + color);
			}
		});
	});
})(jQuery);
