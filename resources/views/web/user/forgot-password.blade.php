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
            <div class="col-md-4"></div>
            <div class="col-md-4" style="margin: auto;">
              <div class="account-login register-login" style="background: #fff">
                  <fieldset class="col2-set">
                      <div class="new-users"><strong>Forgot Password</strong>
                          <div class="content">
                              <p>If you have an account with us, please log in.</p>
                              <form action="http://assamproducts.webinfotechghy.xyz/login" autocomplete="off" method="POST">
                                  <input type="hidden" name="_token" value="SbcrwxGNI8nsUjuCOLRqrFVYCwSHDcTxbYEnbBCi">
                                  <ul class="form-list">
                                      <li>
                                          <label for="email">Email Id <span class="required">*</span></label>
                                          <br>
                                          <input type="text" title="Mobile No" class="input-text required-entry" id="email" value="" name="username">
                                      </li>
                                  </ul>
                                  <p class="required">* Required Fields</p>
                                  <div class="buttons-set">
                                      <button id="send2" name="send" type="submit" class="button login"><span>Submit</span></button>
                                  </div>
                              </form>
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