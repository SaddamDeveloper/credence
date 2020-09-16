@extends('admin.template.master')

@section('content')

<div class="right_col" role="main">

    <div class="row">
      <div class="col-md-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>User Details</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <section class="content invoice">
              <div class="row invoice-info">
                @if (!empty($user_info))                    
                <div class="col-sm-12 invoice-col">
                  <table class="table table-striped">
                    <caption>User Deails</caption>
                    <tr>
                      <th style="width:150px;">Name : </th>
                      <td>{{ $user_info->name }}</td>
                    </tr> 
                    <tr>
                      <th style="width:150px;">Email : </th>
                      <td>{{ $user_info->email }}</td>
                    </tr> 
                    <tr>
                      <th style="width:150px;">Contact No : </th>
                      <td>{{ $user_info->contact_no }}</td>
                    </tr>
                    <tr>
                      <th style="width:150px;">Opening Date : </th>
                      <td>{{ \Carbon\Carbon::parse($user_info->created_at)->toDayDateTimeString() }}</td>
                    </tr>
                  </table>
                </div>
                @endif
              </div>
              <!-- /.row -->
              <hr>
           
              <div class="row">
                <button class="btn btn-warning" onclick="javascript:window.close()">Close</button>
              </div>
              <!-- /.row -->
            </section>
          </div>
        </div>
      </div>
    </div>

</div>


 @endsection

@section('script')
    
 @endsection