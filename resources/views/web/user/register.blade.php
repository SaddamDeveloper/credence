  @extends('web.templet.master')

  {{-- @include('web.include.seo') --}}

  @section('seo')
    <meta name="description" content="Credence">
  @endsection

  @section('content')
    <!-- JTV Home Slider -->
    <section class="main-container col1-layout product-login">
        <div class="main container">
          <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8" style="margin: auto;">
              <div class="account-login register-login">
                  <fieldset class="col2-set">
                      <div class="new-users"><strong>Register</strong>
                          <div class="content">

                            @if(session()->has('msg'))
                              <p style="font-weight: bolder; color: blue;">{{ session()->get('msg') }}</p>
                            @else
                                <p>If you don't have an account with us, please register in.</p>
                            @endif 
                            <form action="{{ route('web.registration') }}" autocomplete="off">
                              <ul class="form-list">
                                <li>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="name">Name <span class="required">*</span></label>
                                            <br>
                                            <input type="text" name="name" value="{{ old('name') }}" class="input-text required-entry">
                                            @error('name')
                                              <span style="color: red;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="email">Email Address <span class="required">*</span></label>
                                            <br>
                                            <input type="email" class="input-text required-entry" value="{{ old('email') }}" name="email">
                                            @error('email')
                                              <span style="color: red;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="contact_no">Phone Number <span class="required">*</span></label>
                                            <br>
                                            <input type="number" class="input-text required-entry" value="{{ old('contact_no') }}" name="contact_no">
                                            @error('contact_no')
                                              <span style="color: red;">{{ $message }}</span>
                                            @enderror 
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="pass">Password <span class="required">*</span></label>
                                            <br>
                                            <input type="password" class="input-text required-entry validate-password" name="password" required="">

                                        </div>
                                        <div class="col-sm-6">
                                            <label for="pass">Confirm Password <span class="required">*</span></label>
                                            <br>
                                            <input type="password" title="Confirm Password" name="confirm_password" class="input-text required-entry validate-password">
                                            @error('password')
                                              <span style="color: red;">{{ $message }}</span>
                                            @enderror 
                                        </div>
                                    </div>
                                </li>
                              </ul>
                              <p class="required">* Required Fields</p>
                              <div class="buttons-set">
                                  <button id="send2" name="send" type="submit" class="button login"><span>Register Account</span></button>
                              </div>
                            </form>
                            <hr>
                            <p>If you have an account with us, please log in.</p>
                            <a class="button login " href="{{ route('web.login') }}">LOGIN TO ACCOUNT</a>
                            </div>
                      </div>
                  </fieldset>
              </div>
            </div>          
          </div>
        </div>
    </section>
       
  @endsection

  @section('script')
  @endsection