(function($){
    
    $(document).ready(function(){


        $('.back-to-top').click(function(){
            $('html, body').animate({ scrollTop: 0 }, 400);
        });

        //Main Nav Hover Settings
        $('ul.nav li.dropdown').hover(function() {
          $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
        }, function() {
          $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
        });
        
        $('.messages-concerns').mouseover(function(){
            $('.menu-notif').css('background','crimson','color','white'); 
        });
        $('.messages-concerns').mouseout(function(){
            $('.menu-notif').css('background','#777','color','white'); 
        });
        
        
        $('li.dropdown').mouseover(function(){
            $(this).addClass('border-bottom');
            $(this).addClass('padding-bottom');
        });
        
        $('li.dropdown').mouseout(function(){
            $(this).removeClass('border-bottom');
            $(this).removeClass('padding-bottom');
        });
        
        //click menu
        $('#navbar-who-am-i').click(function(){
            $('#navbar-services').removeClass('add-border-bottom');
            $('#navbar-services').removeClass('add-padding-bottom');
            $('#navbar-portfolio').removeClass('add-border-bottom');
            $('#navbar-portfolio').removeClass('add-padding-bottom');
            $('#navbar-contact').removeClass('add-border-bottom');
            $('#navbar-contact').removeClass('add-padding-bottom');
            
            $(this).addClass('add-border-bottom');
            $(this).addClass('add-padding-bottom');
        });  
        
        $('#navbar-services').click(function(){
            $('#navbar-who-am-i').removeClass('add-border-bottom');
            $('#navbar-who-am-i').removeClass('add-padding-bottom');
            $('#navbar-portfolio').removeClass('add-border-bottom');
            $('#navbar-portfolio').removeClass('add-padding-bottom');
            $('#navbar-contact').removeClass('add-border-bottom');
            $('#navbar-contact').removeClass('add-padding-bottom');
            
            $(this).addClass('add-border-bottom');
            $(this).addClass('add-padding-bottom');
        }); 
        
        $('#navbar-portfolio').click(function(){
            $('#navbar-who-am-i').removeClass('add-border-bottom');
            $('#navbar-who-am-i').removeClass('add-padding-bottom');
            $('#navbar-services').removeClass('add-border-bottom');
            $('#navbar-services').removeClass('add-padding-bottom');
            $('#navbar-contact').removeClass('add-border-bottom');
            $('#navbar-contact').removeClass('add-padding-bottom');
            
            $(this).addClass('add-border-bottom');
            $(this).addClass('add-padding-bottom');
        }); 
        
        $('#navbar-contact').click(function(){
            $('#navbar-who-am-i').removeClass('add-border-bottom');
            $('#navbar-who-am-i').removeClass('add-padding-bottom');
            $('#navbar-services').removeClass('add-border-bottom');
            $('#navbar-services').removeClass('add-padding-bottom');
            $('#navbar-portfolio').removeClass('add-border-bottom');
            $('#navbar-portfolio').removeClass('add-padding-bottom');
            
            $(this).addClass('add-border-bottom');
            $(this).addClass('add-padding-bottom');
        }); 
        
        
        //sticky header
        window.onscroll = function() {stickyMenu()};

        var navbar = document.getElementById("navigation-pane");
        var sticky = navbar.offsetTop;

        function stickyMenu() {
          if (window.pageYOffset >= sticky) {
            navbar.classList.add("sticky");
            $('.navbar-brand img').addClass('sticky-logo');
          } else {
            navbar.classList.remove("sticky");
            $('.navbar-brand img').removeClass('sticky-logo');
          }
        }
        
        
        //Thumbnail Scroller
        $(".item").mThumbnailScroller({
            axis:"y",
            type:"hover-precise"
        });
    
        
        //animate skillset skillbars when reached the skillset section
        $(window).scroll(function() {
            var offset = $(".skillset-wrapper").offset().top;

            if ($(window).scrollTop() >= offset) {
                $('.skillbar').each(function () {
                    $(this).find('.skillbar-bar').animate({
                        width: $(this).attr('data-percent')
                    }, 7000);
                });
            }
        });
        
        
        $('.send-btn').click(function(){
            // $('#navbar-services').removeClass('add-border-bottom');
            // $('#navbar-services').removeClass('add-padding-bottom');
            // $('#navbar-portfolio').removeClass('add-border-bottom');
            // $('#navbar-portfolio').removeClass('add-padding-bottom');
            // $('#navbar-contact').removeClass('add-border-bottom');
            // $('#navbar-contact').removeClass('add-padding-bottom');
            
            // $(this).addClass('add-border-bottom');
            // $(this).addClass('add-padding-bottom');
            
            var name = $('#name').val();
            var email = $('#email').val();
            var message = $('#message').val();
            
            if( name.length != 0 && email.length != 0 && message.length != 0 ) {
                $.ajax({
                    url: 'mailer.php', 
                    method: 'POST', 
                    data: {
                        'name' : name,
                        'email' : email,
                        'message' : message,
                    },
                    beforeSend: function (data) {
                        $('.loader').show();
                    },
                    success: function (data) {
                        console.log(data);
                        setTimeout(function () {
                            $('.loader').hide();
                            $('#name').val('');
                            $('#email').val('');
                            $('#message').val('');
                            
//                            $('html, body').animate({ scrollTop: 0 }, 400);

                            $('#success-message').show();

                            setTimeout(function () {
                                $('#success-message').hide();
                            }, 5000);

                        }, 3000);
                    },
                    error : function( data ) {
                        console.log(data);
                        setTimeout(function(){
                            $('.loader').hide();

                            $('#error-message').show();
                            
//                            $('html, body').animate({ scrollTop: 0 }, 400);
                            
                            setTimeOut(function(){
                                $('#error-message').hide();
                            }, 5000);

                        }, 3000);

                    }
                }); // End of Ajax
            } else {
                alert('All fields are required. Please try again!');
            }
            
            
            

        });
    });
})(jQuery);
