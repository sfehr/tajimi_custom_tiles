/**
 * File media-image-slider.js
 *
 * IMAGE SLIDER: jQuery image slider used in home page. 
 *
 */

// IMAGE SLIDER
jQuery(document).ready(function ($) {

	var slideIndex = 1;
	var slider = [];
	var nSlides = 1; // get that value independent (read screen situation)

	// check if the window has the size of a mobile device. If yes show only one slide
	/*
	if( $(window).width() > 375 ) {
		nSlides = 2;
	}
	else{
		nSlides = 1;
	}
	*/

	// INITIALIZE
	$('.entry-media.itm-img').each(function (index) {

		var slides = $(this).find('img');
		slider[index] = new Slider(slides);

		//set first n slides active
		slides.each(function (index, element) {

			//sets all slides to invisible first (fallback in css)
			$(element).css('display', 'none');

			if (index < nSlides) {
				$(element).addClass('slide-active');
			} else {
				return false;
			}
		});

		// add next prev button (only when there is an image to slide)
		if( slides.length > 1 ){
			$(this).append(slider[index].nextButton);
			//	  $( this ).append( slider[ index ].prevButton );

			// add event listeners for the slider navigation
			$(this).on('click', '.slide-button.next', function () {
				var obj = $(this).parents('.entry-media.itm-img');
				changeSlide(obj, 'next');
			});

			$(this).on('click', '.slide-button.prev', function () {
				var obj = $(this).parents('.entry-media.itm-img');
				changeSlide(obj, 'prev');
			});
		}

	});


	// SLIDER OBJECT COSTRUCTOR
	function Slider(slides) {
		this.length = slides.length;
		this.nextButton = '<a class="slide-button next"></a>';
		this.prevButton = '<a class="slide-button prev"></a>';
	}


	// NAVIGATE THROUGH SLIDES
	function changeSlide(object, direction) {

		var currentSlide = object.find('.slide-active');
		//	  var currentSlideStart = object.find( '.slide-active' ).first(); //first of two only
		//	  var currentSlideEnd = object.find( '.slide-active' ).last(); //first of two only
		//	  var nextSlide = currentSlideEnd.next( 'img' ); //2nd next
		//	  var prevSlide = currentSlideStart.prev( 'img' ); //2nd prev
		var nextSlide = currentSlide.next('img'); //2nd next
		var prevSlide = currentSlide.prev('img'); //2nd prev		

		// NEXT
		if (direction == 'next') {

			if (nextSlide.length) {
				nextSlide.addClass('slide-active');
				currentSlide.removeClass('slide-active');
			} else {
				currentSlide.removeClass('slide-active');
				object.find('img').first().addClass('slide-active'); // do the rotation ?

			}
		}
		// PREV
		else {
			if (prevSlide.length) {
				prevSlide.addClass('slide-active');
			} else {
				object.find('img').last().addClass('slide-active'); // do the rotation ?
			}

		}


		// REMOVE CURRENT
		//  currentSlide.removeClass( 'slide-active' );
		if (direction == 'next') {
			//    currentSlideStart.removeClass( 'slide-active' );
		} else {
			//    currentSlideEnd.removeClass( 'slide-active' );
		}
	}

});