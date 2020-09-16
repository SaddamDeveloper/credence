  @extends('web.templet.master')

  {{-- @include('web.include.seo') --}}

  @section('seo')
    <meta name="description" content="Credence">
  @endsection

  @section('content')
    <!-- JTV Home Slider -->
    <div class="main-container col2-right-layout profile">
      <div class="main container">
        <div class="row">
          <section class="col-sm-9">
            <div class="col-main">
              <div class="page-title">
                <h2>My profile</h2>
              </div>
              <div class="static-contain">
                <h2>{{ $my_account->name }}</h2><hr>
                <div class="row">
                  <div class="col-xs-6">
                    <p><strong>Name : </strong>{{ $my_account->name }}</p> 
                    <p><strong>Email : </strong>{{ $my_account->email }}</p> 
                    <p><strong>Phone No : </strong>{{ $my_account->contact_no }}</p>
                  </div>
                  <div class="col-xs-12"><hr></div>
                  <div class="col-xs-6">
                    <label class="hidden-xs">You can edit your profile</label><br>
                    <a href="{{route('web.edit_my_profile')}}" class="button button--aylen btn">EDIT PROFILE</a>
                  </div>
                  <div class="col-xs-6">
                    <label class="hidden-xs">Check your saved shipping address</label><br>
                    <a href="{{route('web.address_list')}}" class="button button--aylen btn">SAVED ADDRESS</a>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <aside class="col-right sidebar col-sm-3 wow">
            <div class="block block-company">
              <div class="block-title" style="padding-left: 13px;">Account </div>
              <div class="block-content">
                <ol id="recently-viewed-items">
                  <li class="item odd"><a href="{{ route('web.wish_list') }}">Wishlist</a></li>
                  <li class="item  odd"><a href="{{route('web.order.order')}}">My Orders</a></li>
                  <li class="item odd"><a href="{{route('web.edit_my_profile')}}">Edit Profile</a></li>
                  <li class="item odd"><a href="{{route('web.address_list')}}">My Address</a></li>
                  <li class="item last"><a href="{{route('web.profile.change-password')}}">Change password</a></li>
                </ol>
              </div>
            </div>
          </aside>
        </div>
      </div>
    </div>
       
  @endsection

  @section('script')
  @endsection