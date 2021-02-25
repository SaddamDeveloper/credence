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
          <div class="col-sm-2"></div>
          <div class="col-sm-9">
            <article class="col-main" style="width: 100%;">
              <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-9">
                        <div class="col-main" style="width: 100%;">
                            <div class="page-title">
                              <h2>Exchange</h2>
                            </div>
                            <div class="static-contain account-login">
                              <form action="http://localhost/credence/public/update-my-profile" autocomplete="off" method="POST">
                                <ul class="form-list">
                                  <li>
                                      <div class="row">
                                          <div class="col-sm-12">
                                              <label for="name">Order ID <span class="required">*</span></label>
                                              <br>
                                          <input type="text" name="name" value="CRDD459HY" class="input-text required-entry" required="">
                                          </div>
                                      </div>
                                  </li>
                                  <li>
                                      <div class="row">
                                          <div class="col-sm-12">
                                              <label for="email">Reason<span class="required">*</span></label>
                                              <br>
                                              <textarea class="required-entry input-text" value="" name="reason" required="" rows="3" style="width: 100%;"></textarea>
                                          </div>
                                      </div>
                                  </li>
                                </ul>
                                <p class="required">* Required Fields</p>
                                <div class="buttons-set">
                                    <a href="{{route('web.order.order')}}" class="button button1" style="padding: 4px 12px;border-width: 1px;">Back</a>
                                    <button id="send2" name="send" type="submit" class="button login"><span>save</span></button>
                                </div>
                              </form>
                            </div>
                        </div>
                      <a href="{{route('web.index')}}" class="button">GO TO HOME</a>
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
  @endsection