$(window).ready(function() {

  $('#hamburger').on('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      $('.hamburger').toggleClass('animate');
      $('.bar').toggleClass('animate');
      var mobileNav = $('.menu');
      mobileNav.toggleClass('hide_menu show_menu');
  })

  $('#hamburger_menu').on('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      $('.hamburger').toggleClass('animate');
      $('.bar').toggleClass('animate');
      var mobileNav = $('.menu');
      mobileNav.toggleClass('hide_menu show_menu');
  })

  $('.demande_devis_link a').on('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      $('.content_contact_produit').toggle('slow');
      $('.demande_devis_link').toggleClass('animate');
  })
  

  const next ='<img class="img-fluid" src="/assets/images/right-carousel.png">';
  const prev ='<img class="img-fluid" src="/assets/images/left-carousel.png">';

  $('#slider_evenement').owlCarousel({
      items:2,
      loop:false,
      dots:false,
      nav:true,
      margin:20,
      autoplay:false,
      responsiveClass:true,
      autoplayTimeout:8000,
      navText:[
        prev,
        next
      ],
      responsive:{
          0:{
              items:1,
              stagePadding: 30,
          },
          500:{
              items:1,
              stagePadding: 70,
          },
          768:{
              stagePadding: 50,
          },
          992:{
              items:2,
              stagePadding: 100,
          }
      }
  });


  $('#slider_media_produit').owlCarousel({
      items:1,
      loop:true,
      dots:true,
      nav:false,
      //animateOut: 'fadeOut',
      autoplay:false,
      responsiveClass:true,
      autoplayTimeout:10000,
      singleItem : true,
  });

  $('#slider_galerie_produit').owlCarousel({
      items:1,
      loop:false,
      dots:true,
      nav:false,
      //animateOut: 'fadeOut',
      autoplay:false,
      responsiveClass:true,
      autoplayTimeout:10000,
      singleItem : true,
  });

  $('.zoom_gallery').magnificPopup({
      delegate: 'a',
      type: 'image',
      closeOnContentClick: false,
      closeBtnInside: false,
      mainClass: 'mfp-with-zoom mfp-img-mobile',
      image: {
        verticalFit: true,
        titleSrc: function(item) {
          return item.el.attr('title');
        }
      },
      gallery: {
        enabled: true
      },
      zoom: {
        enabled: true,
        duration: 500, // don't foget to change the duration also in CSS
        opener: function(element) {
          return element.find('img');
        }
      }
  });

  $('.video_source').magnificPopup({
      type: 'iframe',
      iframe: {
        markup: '<div class="mfp-iframe-scaler">'+
                  '<div class="mfp-close"></div>'+
                  '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
                '</div>',
        patterns: {
          youtube: {
            index: 'youtube.com/',
            id: 'v=',
            src: '//www.youtube.com/embed/%id%?autoplay=1' // URL that will be set as a source for iframe.
          }, 
        },
        srcAction: 'iframe_src', // Templating object key. First part defines CSS selector, second attribute. "iframe_src" means: find "iframe" and set attribute "src".
      }
  });

});

new WOW().init();

/*  Display Grid  */

function resizeGridItem(item){
  grid = document.getElementsByClassName("list_medias_grid")[0];
  rowHeight = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-auto-rows'));
  rowGap = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-row-gap'));
  rowSpan = Math.ceil((item.querySelector('.item_medias').getBoundingClientRect().height+rowGap)/(rowHeight+rowGap));
    item.style.gridRowEnd = "span "+rowSpan;
}

function resizeAllGridItems(){
  allItems = document.getElementsByClassName("item_medias_grid");
  for(x=0;x<allItems.length;x++){
    resizeGridItem(allItems[x]);
  }
}

function resizeInstance(instance){
    item = instance.elements[0];
  resizeGridItem(item);
}

window.onload = resizeAllGridItems();
window.addEventListener("resize", resizeAllGridItems);

allItems = document.getElementsByClassName("item_medias_grid");
for(x=0;x<allItems.length;x++){
  imagesLoaded( allItems[x], resizeInstance);
}


