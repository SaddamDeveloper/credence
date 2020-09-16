<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Credence | Admin Dashboard</title>

    <!-- Bootstrap -->
    <link href="{{ asset('admin/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('admin/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('admin/vendors/nprogress/nprogress.css') }}" rel="stylesheet">

    <!-- Datatables -->
    <link href="{{ asset('admin/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('admin/build/css/custom.min.css') }}" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="{{ route('admin.dashboard') }}" class="site_title"><span>Credence</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="{{ asset('admin/user/user.png') }}" class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{ Auth::user()->name }}</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Home</a>
                  </li>
                  <li><a><i class="fa fa-edit"></i> Manage Products <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('admin.new_product') }}">New Product</a></li>
                      <li><a href="{{ route('admin.active_product_list') }}">Active Products</a></li>
                      <li><a href="{{ route('admin.in_active_product_list') }}">In-Active Products</a></li>
                      <li><a href="{{ route('admin.product_list') }}">Products List</a></li>
                    </ul>
                    {{-- <ul class="nav child_menu">
                        <li><a>Apparel<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                             <li><a href="{{ route('admin.new_apparel_product') }}">New Product</a></li>
                              <li><a href="{{ route('admin.active_apparel_product_list') }}">Active Products</a></li>
                              <li><a href="{{ route('admin.in_active_apparel_product_list') }}">In-Active Products</a></li>
                              <li><a href="{{ route('admin.product_apparel_list') }}">Products List</a></li>
                          </ul>
                        </li>
                        <li><a>Cosmetics<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                             <li><a href="{{ route('admin.new_cosmetics_product') }}">New Product</a></li>
                              <li><a href="{{ route('admin.product_cosmetics_list') }}">Products List</a></li>
                          </ul>
                        </li>
                        <li><a>Perfumeries<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                             <li><a href="{{ route('admin.new_perfumeries_product') }}">New Product</a></li>
                              <li><a href="{{ route('admin.product_perfumeries_list') }}">Products List</a></li>
                          </ul>
                        </li>
                        <li><a>Krafts<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                             <li><a href="{{ route('admin.new_krafts_product') }}">New Product</a></li>
                              <li><a href="{{ route('admin.product_krafts_list') }}">Products List</a></li>
                          </ul>
                        </li>
                    </ul> --}}
                  </li>
                  <li><a><i class="fa fa-edit"></i> Manage Users <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('admin.users_list') }}">Users List</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-edit"></i> Manage Orders <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('admin.new_orders_list') }}">New Orders</a></li>
                      <li><a href="{{ route('admin.out_for_delivery_orders_list') }}">Out for Delivery</a></li>
                      <li><a href="{{ route('admin.delivered_orders_list') }}">Delivered Orders</a></li>
                      <li><a href="{{ route('admin.canceled_orders_list') }}">Cancel Orders</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-edit"></i> Manage Brands <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('admin.new_brand') }}">New Brand</a></li>
                      <li><a href="{{ route('admin.all_brand') }}">Brands List</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-edit"></i> Manage Category <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('admin.all_third_level_sub_category') }}">3rd Sub-Category</a></li>
                      <li><a href="{{ route('admin.all_sub_category') }}">Sub-Category</a></li>
                      <li><a href="{{ route('admin.all_top_category') }}">Top-Category</a></li>
                    </ul>
                  </li>
                </ul>
                
              </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('admin.logout') }}">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('admin/user/user.png') }}" alt="">{{ Auth::user()->name }}
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="{{ route('admin.profile') }}"> Profile</a></li>
                    <li><a href="{{ route('admin.change_password') }}">Change Password</a></li>
                    <li><a href="{{ route('admin.logout') }}"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>

                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">
                        {{-- @if($header_data['new_order_cnt'] > 0)
                            {{ $header_data['new_order_cnt'] }}
                        @else
                            {{ 0 }}
                        @endif --}}
                    </span>
                  </a>
                  {{-- @if($header_data['new_order_cnt'] > 0)
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                      <a>
                        <span><b>({{ $header_data['new_order_cnt'] }}) New Orders</b></span>
                      </a>
                    </li>
                    <li>
                      <div class="text-center">
                        <a href="{{ route('admin.new_orders_list') }}">
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                  @endif --}}
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->