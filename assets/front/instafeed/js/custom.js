// $(document).ready(function() {


  // var userFeed = new Instafeed({
  //   get: 'user',
  //   userId: '6321620007',
  //   limit: 8,
  //   resolution: 'standard_resolution',
  //   accessToken: '6321620007.1677ed0.3fdd143b850f4ddcba2d46fd7ff580b5',
  //   sortBy: 'most-recent',
  //   template: '<div class="item instaimg"><a href="{{link}}" title="{{caption}}" target="_blank"><img src="{{image}}" alt="{{caption}}" style="width:150px"></a></div>',
  // });


  // userFeed.run();

  var galleryFeed = new Instafeed({
    get: "user",
    userId: 6321620007,
    accessToken: "6321620007.1677ed0.3315542ddfd44c59bede9db5a1472193",
    resolution: "standard_resolution",
    // useHttp: "true",
    sortBy: 'most-recent',
    limit: 5,
    template: 
    '<div class="item instaimg">'+
      '<a href="{{link}}" title="{{caption}}" target="_blank">'+
        '<img src="{{image}}" alt="{{caption}}">'+
        '<div class="likes"><i class="fa fa-instagram"></i> {{model.user.username}} '+
        // '<i class="fa fa-heart"></i> {{likes}}'+
        '</div>'+
      '</a>'+
    '</div>',

    after: function() {
      var owl = $(".owl-carousel");

      // init owl    
      $(document).ready(function(){
        owl.owlCarousel({
          loop:true,
          items:1,
          margin:10,
          autoHeight:true,
          nav:false,
          dots:false,
          autoplay:true,
          autoplayTimeout:5000,
          autoplayHoverPause:true,
        });
      });
  }
});

  galleryFeed.run();


    // This will create a single gallery from all elements that have class "gallery-item"
    $('.gallery').magnificPopup({
      type: 'image',
      delegate: 'a',
      gallery: {
        enabled: true
      }
    });


  // });