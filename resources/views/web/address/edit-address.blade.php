  @extends('web.templet.master')

  {{-- @include('web.include.seo') --}}

  @section('seo')
    <meta name="description" content="Credence">
  @endsection

  @section('content')
    <!-- JTV Home Slider -->
    <section class="main-container col2-left-layout">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12">
            <article class="col-main" style="width: 100%;">
              <div class="container-fluid">
                  <div class="row">
                    <!-- <div class="col-md-1"></div> -->
                    <div class="col-md-12">
                        <div class="row">
                          <div class="box-account">
                            <div class="page-title">
                              <h2 class="text-center" style="padding: 0">Shipping Information</h2>
                            </div>   
                            <div class="checkout-page">

                              @if (session()->has('msg'))
                                <h5 class="text-center">{{ session()->get('msg') }}</h5> 
                              @else
                                <h5 class="text-center">Edit Shipping Address</h5> 
                              @endif

                              <div class="box-border">
                              <form method="POST" action="{{ route('web.update_address', ['address_id' => $address->id]) }}" autocomplete="off" method="POST">
                                @csrf
                                <ul>
                                  <li class="row">
                                    <div class="col-sm-6">
                                      <label for="first_name" class="required">Name</label>
                                    <input type="text" value="{{ $address->name }}" class="input form-control" name="name" id="name">
                                      <span id="name_msg" style="color: red;"></span>
                                    </div>
                                    <!--/ [col] -->
                                    <div class="col-sm-6">
                                      <label for="email_address" class="required">Email Address</label>
                                      <input type="email" class="input form-control" value="{{ $address->email }}" name="email" id="email_address">
                                      <span id="email_msg" style="color: red;"></span>
                                    </div>
                                    <!--/ [col] --> 
                                  </li>
                                  <!--/ .row -->
                                  <li class="row">
                                    <div class="col-xs-12">
                                      <label for="address" class="required">Address</label>
                                      <textarea class="input form-control form-area" name="address" id="address" rows="10">{{ $address->address }}</textarea>
                                      <span id="address_msg" style="color: red;"></span>
                                    </div>
                                    <!--/ [col] --> 
                                    
                                  </li>
                                  <!-- / .row -->
                                  <li class="row">
                                    <div class="col-sm-6">
                                      <label for="telephone">Phone Number</label>
                                      <input type="number" name="mobile_no" value="{{ $address->mobile_no }}" class="input form-control" id="telephone">
                                      <span id="telephone_msg" style="color: red;"></span>
                                    </div>
                                    <!--/ [col] -->
                                    <div class="col-sm-6">
                                      <label for="postal_code" class="required">Pincode</label>
                                      <input type="number" class="input form-control" value="{{ $address->pin_code }}" name="pin_code" id="postal_code">
                                      <span id="postal_code_msg" style="color: red;"></span>
                                    </div>
                                    <!--/ [col] --> 
                                  </li>
                                  <!--/ .row -->
                                  
                                  <li class="row">
                                    <div class="col-sm-6">
                                      <label for="city" class="required">City</label>
                                      <input class="input form-control" type="text" value="{{ $address->city }}" name="city" id="city">
                                      <span id="city_msg" style="color: red;"></span>
                                    </div>
                                    <!--/ [col] -->
                                    
                                    <div class="col-sm-6">
                                      <label class="required">State/Province</label>
                                      <input type="text" class="input form-control" value="{{ $address->state }}" name="state" id="state">
                                      <span id="state_msg" style="color: red;"></span>
                                    </div>
                                    <!--/ [col] --> 
                                  </li>
                                  <!--/ .row -->
                                  <li>
                                    <a href="{{route('web.address_list')}}" class="button button1" style="padding: 4px 12px;border-width: 1px;">Back</a>
                                    <button type="submit" class="button" id="address_btn">Save</button>
                                  </li>
                                </ul>
                                </form>
                              </div>
                            </div>                            
                          </div>
                        </div>
                    </div>
                  </div>
              </div>
            </article>
            <!--  ///*///======    End article  ========= //*/// --> 
          </div>
        </div>
      </div>
    </section>
       
  @endsection

  @section('script')
  <script>
    $(document).ready(function(){

$('#address_btn').click(function(){
      var name = $('#name').val();
      var email = $('#email_address').val();
      var address = $('#address').val();
      var telephone = $('#telephone').val();
      var postal_code = $('#postal_code').val();
      var city = $('#city').val();
      var state = $('#state').val();

      if (name == "") {
          $('#name_msg').text('Name can\'t be empty');
          return false;
      } else
          $('#name_msg').text('');

      if (email == "") {
          $('#email_msg').text('Email can\'t be empty');
          return false;
      } else{
          var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

          if (email.match(mailformat))
              $('#email_msg').text('');
          else {

              $('#email_msg').text('Invalid email');
              return false;
          }
      }

      if (address == "") {
          $('#address_msg').text('Address can\'t be empty');
          return false;
      } else
          $('#address_msg').text('');

      if (telephone == "") {
          $('#telephone_msg').text('Telephone can\'t be empty');
          return false;
      } else {
          if (telephone.length < 10){
              $('#telephone_msg').text('Contact no. should be of 10 digits');
              return false;
          }
          else if (telephone.length > 10){
              $('#telephone_msg').text('Contact no. should be of 10 digits');
              $('#telephone').val("");
              return false;
          } else
              $('#telephone_msg').text('');
      }

      if (postal_code == "") {
          $('#postal_code_msg').text('PIN Code can\'t be empty');
          return false;
      } else {
          if (postal_code.length < 6){
              $('#postal_code_msg').text('Pin code should be of 6 digits');
              return false;
          } 
          else if (postal_code.length > 6){
              $('#postal_code').val("");
              $('#postal_code_msg').text('Pin code should be of 6 digits');
              return false;
          } else
              $('#postal_code_msg').text('');
      }

      if (city == "") {
          $('#city_msg').text('City can\'t be empty');
          return false;
      } else
          $('#city_msg').text('');

      if (state == "") {
          $('#state_msg').text('State can\'t be empty');
          return false;
      } else
          $('#state_msg').text('');
  });

  $('#telephone').keyup(function(e){
      var telephone = $('#telephone').val();

      if (telephone.length < 10) 
          $('#telephone_msg').text('Contact no. should be of 10 digits');
      else{
          $('#telephone_msg').text('');
          event.preventDefault();
          return false;
      }
  });

  $('#postal_code').keyup(function(e){
      var postal_code = $('#postal_code').val();

      if (postal_code.length < 6) 
          $('#postal_code_msg').text('Pin code should be of 6 digits');
      else{
          $('#postal_code_msg').text('');
          event.preventDefault();
          return false;
      }
  });
});
  </script>
  @endsection