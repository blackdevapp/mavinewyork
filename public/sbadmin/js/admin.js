(function($) {
  "use strict"; // Start of use strict

  // Toggle the side navigation
  $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
    $("body").toggleClass("sidebar-toggled");
    $(".sidebar").toggleClass("toggled");
    if ($(".sidebar").hasClass("toggled")) {
      $('.sidebar .collapse').collapse('hide');
    };
  });

  // Close any open menu accordions when window is resized below 768px
  $(window).resize(function() {
    if ($(window).width() < 768) {
      $('.sidebar .collapse').collapse('hide');
    };
  });

  // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
  $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
    if ($(window).width() > 768) {
      var e0 = e.originalEvent,
        delta = e0.wheelDelta || -e0.detail;
      this.scrollTop += (delta < 0 ? 1 : -1) * 30;
      e.preventDefault();
    }
  });

  // Scroll to top button appear
  $(document).on('scroll', function() {
    var scrollDistance = $(this).scrollTop();
    if (scrollDistance > 100) {
      $('.scroll-to-top').fadeIn();
    } else {
      $('.scroll-to-top').fadeOut();
    }
  });

  // Smooth scrolling using jQuery easing
  $(document).on('click', 'a.scroll-to-top', function(e) {
    var $anchor = $(this);
    $('html, body').stop().animate({
      scrollTop: ($($anchor.attr('href')).offset().top)
    }, 1000, 'easeInOutExpo');
    e.preventDefault();
  });
  /** create toast close @by: @MAGIC 20191010 */
  $(document).on('click', 'button.close', function(e){
	  var dismiss = this.dataset.dismiss || false;
	  if(dismiss) {
		  $(document).find('.'+dismiss).remove();
	  }
  });
  
  $(document).on('click', 'button.delete-button', function(e){
	  var a = e.target.closest('a');
	  $('.modal#delete_modal .modal-header .modal-title').html('Delete ' + a.dataset.title);
	  $('.modal#delete_modal .modal-body').html('Are you sure to delete ' + a.dataset.title + '?');
	  $('.modal#delete_modal .modal-footer').html(''+
		'<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>'+
	  	'<a href="'+a.dataset.url+'" class="transparent-color"><button class="btn btn-danger">Delete</button></a>');
  });

})(jQuery); // End of use strict
