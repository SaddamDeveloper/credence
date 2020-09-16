@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>3rd Sub-Categories</h2>
                    <a class="btn btn-primary pull-right" href="{{ route('admin.new_third_level_sub_category') }}">Add 3rd Sub-Category</a>
                   {{--  <ul class="nav navbar-right panel_toolbox">
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
                            <th>Top-Category</th>
                            <th>Sub-Category</th>
                            <th>Third Level Sub-Category</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Created Time</th>
                            <th>Last Updated Time</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody class="form-text-element">
                        @if (count($third_sub_categories) > 0)

                            @foreach ($third_sub_categories as $key => $value)

                                <tr>
                                    <td>{{ $value->id }}</td>
                                    <td>{{ $value->top_cate_name }}</td>
                                    <td>{{ $value->sub_cate_name }}</td>
                                    <td>{{ $value->third_level_sub_category_name }}</td>
                                    <td>{{ $value->slug }}</td>
                                    <td>
                                        @if($value->status == 1)
                                            <a class="btn btn-success">Active</a>
                                        @else
                                            <a class="btn btn-danger">In-Active</a>
                                        @endif
                                    </td>
                                    <td>{{ $value->created_at }}</td>
                                    <td>{{ $value->updated_at }}</td>
                                    <td>
                                        @if($value->status == 1)
                                            <a href="{{ route('admin.update_third_sub_category_status', ['third_sub_category_id' => $value->id, 'status' => 2]) }}" class="btn btn-danger">In-Active</a>
                                        @else
                                            <a href="{{ route('admin.update_third_sub_category_status', ['third_sub_category_id' => $value->id, 'status' => 1]) }}" class="btn btn-success">Active</a>
                                        @endif

                                        <a href="{{ route('admin.edit_third_level_sub_category', ['third_sub_category_id' => $value->id]) }}" class="btn btn-warning">Edit</a>
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