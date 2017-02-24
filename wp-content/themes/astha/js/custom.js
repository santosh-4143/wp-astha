/*img hover effect start*/
 $(".hover").mouseleave(
    function () {
      $(this).removeClass("hover");
    }
  );
/*img hover effect end*/



//owl Carusel
    $(document).ready(function() {
     
      $("#owl-demo").owlCarousel({
     
          autoPlay: 5000, //Set AutoPlay to 3 seconds
     
          items : 3,
          itemsDesktop : [1199,3],
          itemsDesktopSmall : [979,3]
     
      });
     
    });

//end Carusel

//owl Carusel
    $(document).ready(function() {
     
      $("#owl-demo_1").owlCarousel({
     
          autoPlay: 5000, //Set AutoPlay to 3 seconds
     
          items : 3,
          itemsDesktop : [1199,3],
          itemsDesktopSmall : [979,3]
     
      });
     
    });

//end Carusel


//owl Carusel
    $(document).ready(function() {
     
      $("#owl-demo_2").owlCarousel({
     
          autoPlay: 5000, //Set AutoPlay to 3 seconds
     
          items : 5,
          itemsDesktop : [1199,3],
          itemsDesktopSmall : [979,3]
     
      });
     
    });

//end Carusel




$(document).ready(function(){
    $(".search_area > a").click(function(){
        $(".search_box").slideToggle();
    });
});

/*auto slider start*/
$(window).load(function() {
    $("#flexiselDemo1").flexisel();
    $("#flexiselDemo2").flexisel({
        enableResponsiveBreakpoints: true,
        responsiveBreakpoints: { 
            portrait: { 
                changePoint:480,
                visibleItems: 1
            }, 
            landscape: { 
                changePoint:640,
                visibleItems: 2
            },
            tablet: { 
                changePoint:768,
                visibleItems: 3
            }
        }
    });
	
	$("#flexiselDemo3").flexisel({
        visibleItems: 4,
        animationSpeed: 1000,
        autoPlay: true,
        autoPlaySpeed: 4000,            
        pauseOnHover: true,
        enableResponsiveBreakpoints: true,
        responsiveBreakpoints: { 
            portrait: { 
                changePoint:480,
                visibleItems: 1
            }, 
            landscape: { 
                changePoint:640,
                visibleItems: 2
            },
            tablet: { 
                changePoint:768,
                visibleItems: 3
            }
        }
    });
	
	    
});
/*auto slider end*/

/*for zoom in start*/
 jQuery(document).ready(function($){
    
                    $('#etalage').etalage({
                        thumb_image_width: 300,
                        thumb_image_height: 400,
                        source_image_width: 900,
                        source_image_height: 1200,
                        show_hint: true,
                        click_callback: function(image_anchor, instance_id){
                            alert('Callback example:\nYou clicked on an image with the anchor: "'+image_anchor+'"\n(in Etalage instance: "'+instance_id+'")');
                        }
                    });
    
                });
/*for zoom end*/

/*jquery accordian menu start*/
	  jQuery(document).ready(function(){
		  jQuery(".jquery-accordion-menu").jqueryAccordionMenu(); jQuery(".colors a").click(function(){
			  if($(this).attr("class") !="default"){
				  $("#jquery-accordion-menu").removeClass();
				  $("#jquery-accordion-menu").addClass("jquery-accordion-menu").addClass($(this).attr("class"));
			}
			else{
				$("#jquery-accordion-menu").removeClass(); 
				$("#jquery-accordion-menu").addClass("jquery-accordion-menu");
				}
			});
		}); 
/*jquery accordian menu end*/

/*jquery accordian menu start*/
	  jQuery(document).ready(function(){
		  jQuery("#jquery-accordion-menu_1").jqueryAccordionMenu(); jQuery(".colors a").click(function(){
			  if($(this).attr("class") !="default"){
				  $("#jquery-accordion-menu").removeClass();
				  $("#jquery-accordion-menu").addClass("jquery-accordion-menu").addClass($(this).attr("class"));
			}
			else{
				$("#jquery-accordion-menu").removeClass(); 
				$("#jquery-accordion-menu").addClass("jquery-accordion-menu");
				}
			});
		}); 
/*jquery accordian menu end*/

/*jquery accordian menu start*/
	  jQuery(document).ready(function(){
		  jQuery("#jquery-accordion-menu_2").jqueryAccordionMenu(); jQuery(".colors a").click(function(){
			  if($(this).attr("class") !="default"){
				  $("#jquery-accordion-menu").removeClass();
				  $("#jquery-accordion-menu").addClass("jquery-accordion-menu").addClass($(this).attr("class"));
			}
			else{
				$("#jquery-accordion-menu").removeClass(); 
				$("#jquery-accordion-menu").addClass("jquery-accordion-menu");
				}
			});
		}); 
/*jquery accordian menu end*/

/*multi lavel accordian menu*/
jQuery(document).ready(function(){
	var accordionsMenu = $('.cd-accordion-menu');

	if( accordionsMenu.length > 0 ) {
		
		accordionsMenu.each(function(){
			var accordion = $(this);
			//detect change in the input[type="checkbox"] value
			accordion.on('change', 'input[type="checkbox"]', function(){
				var checkbox = $(this);
				console.log(checkbox.prop('checked'));
				( checkbox.prop('checked') ) ? checkbox.siblings('ul').attr('style', 'display:none;').slideDown(300) : checkbox.siblings('ul').attr('style', 'display:block;').slideUp(300);
			});
		});
	}
});

