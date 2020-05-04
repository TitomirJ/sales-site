(function($, undefined){
    $(function(){	

		// чек чекбокс

        $('body').on('click', '#btn-registration', function() {
            if(!$("#agree").is(':checked')) {
                $('.agree-text').removeClass('d-none');
                $('.agree-text').addClass('d-block');
            }else{
                $('#formRegist').submit();
            }
        });


		/*--------------------------------------------------------------*/
    	// animate
    	wow = new WOW(
                      {
                      boxClass:     'wow',      // default
                      animateClass: 'animated', // default
                      offset:       0,          // default
                      mobile:       false,       // default
                      live:         true        // default
                    }
                    )
                    wow.init();

    	
		/*--------------------------------------------------------------*/
        // sctoll to anchor
        $('a[href^="#"]').on('click', function(event) {
            var target = $(this.getAttribute('href'));
            if( target.length ) {
                event.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top
                }, 1700);
            }
        });

		/*--------------------------------------------------------------*/
		// fixed nav
		$(window).scroll(function(){
			if ($(window).scrollTop() > 300) {
				$('.nav').addClass('header-fixed');
			}
			else {
				$('.nav').removeClass('header-fixed');
			}
		});

		//close modal when click on links in modal
        $('.modal-land').find('a').on('click', function() {
            $('.modal-land').fadeOut(".6s");
			$("html,body").css("overflow","auto");
			$('.menu-icon').toggleClass('menu-icon-active');
        })
		/*--------------------------------------------------------------*/

		/*--------------------------------------------------------------*/
		
		/*--------------------------------------------------------------*/

		// input masks
		    // phone input
		    $(".mask-tel").mask("+38(999) 999-99-99");

		// modal custom 
		$("#btnModal").on('click', function () {
			$('.menu-icon').toggleClass('menu-icon-active');
			if($('.menu-icon').hasClass("menu-icon-active")){
				$("html,body").css("overflow","hidden");
				$(".modal-land").fadeIn('.6s');
			} else {
				$("html,body").css("overflow","auto");
				$(".modal-land").fadeOut(".6s");
			}
		});

		/*--------------------------------------------------------------*/

		/*--------------------------------------------------------------*/
		$(".authModalBtn").on('click', function () {
			$('#authModal').addClass("modal-auth_open");
			$("#authModal").fadeIn('.6s');
			$("html,body").css("overflow","hidden");
		});

		$(".close-authModal").on('click', function () {
			$("html,body").css("overflow","auto");
			$("#authModal").fadeOut(".6s");
		});
		/*--------------------------------------------------------------*/

		$(document).ready(function() {
			var btn = $('#button-up');
			$(window).scroll(function() {
				if ($(window).scrollTop() > 400) {
					btn.removeClass('d-none');
				} else {
					btn.addClass('d-none');
				}
			});
			btn.on('click', function(e) {
				e.preventDefault();
				$('html, body').animate({scrollTop:0}, '400');
			});
		});

	});
})(jQuery);