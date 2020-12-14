@extends('admin.template.master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
    	<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
                    <h2>Charges List</h2>
                    <div class="clearfix"></div>
    	        </div>
    	        <div>
    	            <div class="x_content">
                        <table id="category" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Sl</th>
                              <th>Description</th>                              
                              <th>Amount</th>
                           
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>  
                            @if (isset($charges) && !empty($charges))
                            @php
                              $count=1;
                            @endphp
                                @foreach ($charges as $item)
                                    <tr>
                                      <td>{{$count++}}</td>
                                      <td>{{$item->description}}</td>
                                      <td>
                                        {{$item->amount}}
                                      </td>
                                      
                                      <td>
                                        <a href="{{route('admin.charges_edit',['id'=>encrypt($item->id)])}}" class="btn btn-sm btn-warning">Edit</a>
                                        
                                        
                                      </td>
                                    </tr>
                                @endforeach
                            @else
                              <tr>
                                <td colspan="6" style="text-align: center">No Sub Category Found</td>
                              </tr>  
                            @endif                   
                          </tbody>
                        </table>
    	            </div>
    	        </div>
    	    </div>
    	</div>
    </div>
	</div>


 @endsection

@section('script')
     
     <script type="text/javascript">
         $(function () {
            var table = $('#category').DataTable();
        });
     </script>
    
 @endsection