    <footer>
      <div class="footer-inner">
        <div class="container">
          <div class="row">
            <div class="col-sm-4 col-xs-12 col-md-3">
              <div class="footer-links">
                <h4>Website links</h4>
                <ul class="links">
                  <li><a href="#" title="Product Recall">Company Policy</a></li>
                  <li><a href="#" title="Returns &amp; Exchange">Returns &amp; Policy</a></li>
                  <li><a href="#" title="Shipping Options">Shipping Policy</a></li>
                  <li><a href="#" title="Help &amp; FAQs">Help &amp; FAQs</a></li>
                  <li><a href="#" title="Order history">Order history</a></li>
                </ul>
              </div>
            </div>
            <div class="col-sm-4 col-xs-12 col-md-3">
              <div class="footer-links">
                <h4>Service</h4>
                <ul class="links">
                  <li><a href="{{route('web.my_profile')}}">Account</a></li>
                  <li><a href="{{ route('web.wish_list') }}">Wishlist</a></li>
                  <li><a href="#">Login</a></li>
                  <li><a href="#">Register</a></li>
                  <li><a href="#">Logout</a></li>
                </ul>
              </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
              <div class="footer-links">
                <div class="footer-newsletter">
                  <h1 style="font-size: 40px;">CREDENCE LLPP</h1>
                  <form id="newsletter-validate-detail" method="post" action="#">
                    <div class="newsletter-inner">
                      <p>Subscribe to be the first to know about Sales, Events, and Exclusive Offers!</p>
                    </div>
                  </form>
                </div>
                <div class="social">
                  <h4>Follow Us</h4>
                  <ul class="inline-mode">
                    <li class="social-network fb"><a title="Connect us on Facebook" target="_blank" href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a></li>
                    <li class="social-network googleplus"><a title="Connect us on Google+" target="_blank" href="https://plus.google.com/"><i class="fa fa-google-plus"></i></a></li>
                    <li class="social-network tw"><a title="Connect us on Twitter" target="_blank" href="https://twitter.com/"><i class="icon-social-twitter icons"></i></a></li>
                    <li class="social-network linkedin"><a title="Connect us on Linkedin" target="_blank" href="https://www.pinterest.com/"><i class="fa fa-linkedin"></i></a></li>
                    <li class="social-network rss"><a title="Connect us on rss" target="_blank" href="https://instagram.com/"><i class="fa fa-rss"></i></a></li>
                    <li class="social-network instagram"><a title="Connect us on Instagram" target="_blank" href="https://instagram.com/"><i class="fa fa-instagram"></i></a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <div class="container">
          <div class="row">
            <div class="col-sm-5 col-xs-12 coppyright">Copyright © 2020 <a href="#"> CREDENCE LLPP </a>| Developed by <a href="https://www.webinfotech.net.in/">Webinfotech </a> </div>
            <div class="col-sm-7 col-xs-12 payment-accept">
              <ul>
                <li> <a href="#"><img src="{{asset('web/images/payment-1.png')}}" alt="Payment Card"></a> </li>
                <li> <a href="#"><img src="{{asset('web/images/payment-2.png')}}" alt="Payment Card"></a> </li>
                <li> <a href="#"><img src="{{asset('web/images/payment-3.png')}}" alt="Payment Card"></a> </li>
                <li> <a href="#"><img src="{{asset('web/images/payment-4.png')}}" alt="Payment Card"></a> </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <!-- End Footer --> 
  </div>

    <!-- jquery js --> 
    <script type="text/javascript" src="{{asset('web/js/jquery.min.js')}}"></script> 

    <!-- bootstrap js --> 
    <script type="text/javascript" src="{{asset('web/js/bootstrap.min.js')}}"></script> 

    <!-- owl.carousel.min js --> 
    <script type="text/javascript" src="{{asset('web/js/owl.carousel.min.js')}}"></script> 

    <!-- jtv-jtv-mobile-menu js --> 
    <script type="text/javascript" src="{{asset('web/js/jtv-mobile-menu.js')}}"></script> 

    <!-- countdown js --> 
    <script type="text/javascript" src="{{asset('web/js/countdown.js')}}"></script> 

    <!-- main js --> 
    <script type="text/javascript" src="{{asset('web/js/main.js')}}"></script> 

    <script type="text/javascript">
      $(document).ready(function(){
          $('#search').keyup(function(){
              var keyword = $('#search').val();
  
              if (keyword.length == 0) {
                  $('#livesearch').hide();
              } else {
                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                  });
  
                  $.ajax({
                      method: "GET",
                      url   : "{{ url('/product-search/') }}/"+keyword,
                      success: function(response) {
  
                          if (response == ""){
  
                            
                                 $('#livesearch').html("<div style='background: #ffffff05; text-lign: center;'><img src='{{asset('web/images/not-found.jpg')}}' style='max-width: 100%'><strong>Sorry !!</strong> couldn\'t find what your are looking for...</div>");
                          }
                          else
                              $('#livesearch').html(response);
  
                          $('#livesearch').show();
                      }
                  });
              }
          });
      });
    </script>

    <script>
      $(document).ready(function(){
        $("#this-togg").click(function(){
          $(".search-box").toggleClass("disply-blk");    
          $(".mm-toggle1").toggleClass("closeit");
          $(".closeit").click(function(){
            $("#livesearch").css("display", "none");
          });
          
        });
      });
    </script>
</body>

</html>


    