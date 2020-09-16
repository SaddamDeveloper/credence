@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
					        <h2>Top-Categories</h2>
                  <a class="btn btn-primary pull-right" href="{{ route('admin.new_top_category') }}">Add Top-Category</a>
                    {{-- <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul> --}}
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Name</th>
							<th>Slug</th>
							<th>Status</th>
							<th>Created Time</th>
							<th>Last Updated Time</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody class="form-text-element">
                        @if (count($top_categories) > 0)

                            @foreach ($top_categories as $key => $item)

                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->top_cate_name }}</td>
									<td>{{ $item->slug }}</td>
									<td>
                                        @if($item->status == 1)
                                            <a class="btn btn-success">Active</a>
                                        @else
                                            <a class="btn btn-danger">In-Active</a>
                                        @endif
                                    </td>
									<td>{{ $item->created_at }}</td>
									<td>{{ $item->updated_at }}</td>
                                    <td>
										@if($item->status == 1)
                                            <a href="{{ route('admin.update_top_category_status', ['top_category_id' => $item->id, 'status' => 2]) }}" class="btn btn-danger">In-Active</a>
                                        @else
                                            <a href="{{ route('admin.update_top_category_status', ['top_category_id' => $item->id, 'status' => 1]) }}" class="btn btn-success">Active</a>
										@endif
										
                                        <a href="{{ route('admin.edit_top_category', ['topCategoryId' => $item->id]) }}" class="btn btn-warning">Edit</a>
                                    </td>
                                </tr> 
                            @endforeach
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