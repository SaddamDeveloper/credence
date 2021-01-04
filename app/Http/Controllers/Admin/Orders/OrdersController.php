<?php

namespace App\Http\Controllers\Admin\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Address;
use App\Models\User\User;
use Illuminate\Contracts\Encryption\DecryptException;

class OrdersController extends Controller
{
    public function newOrdersList()
    {
    	return view('admin.orders.new_orders');
    }

    public function outForDelivery(Request $request){
        $awb_no = $request->input('awb_no');
        $id = $request->input('order_id');
        $order = Order::find($id);
        $order->awb_no = $awb_no;
        $order->order_status = 2;
        if($order->save()){
            return 1;
        }else{
            return 2;
        }
    }

    public function outForDeliveryOrdersList()
    {
    	return view('admin.orders.out_for_delivery_orders');
    }

    public function deliveredOrdersList()
    {
    	return view('admin.orders.delivered_orders');
    }

    public function canceledOrdersList()
    {
    	return view('admin.orders.canceled_orders');
    }

    public function ordersListData(Request $request)
    {
        $columns = array( 
                            0 => 'id', 
                            2 => 'order_id',
                            2 => 'dispatch_id',
                            3 => 'user_name',
                            4 => 'payment_id',
                            5 => 'payment_status',
                            6 => 'order_date',
                            7 => 'action',
                        );

        $totalData = DB::table('order')
        	->where('order_status', $request->input('status'))
        	->count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))) {            
            
            $order_data = DB::table('order')
                            ->leftJoin('users', 'order.user_id', '=', 'users.id')
                            ->select('order.*', 'users.name')
                            ->where('order.order_status', $request->input('status'))
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
        }
        else {

            $search = $request->input('search.value'); 

            $order_data = DB::table('order')
                            ->leftJoin('users', 'order.user_id', '=', 'users.id')
                            ->select('order.*', 'users.name')
                            ->where('order.order_status', $request->input('status'))
                            ->orWhere('order.order_id','LIKE',"%{$search}%")
                            ->orWhere('users.name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = DB::table('order')
                            ->leftJoin('users', 'order.user_id', '=', 'users.id')
                            ->select('order.*', 'users.name')
                            ->where('order.order_status', $request->input('status'))
                            ->orWhere('order.order_id','LIKE',"%{$search}%")
                            ->orWhere('users.name', 'LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();

        if(!empty($order_data)) {

            $cnt = 1;

            foreach ($order_data as $single_data) {

                if($single_data->order_status == 1)
                    $val = "&emsp;<a class=\"btn btn-primary\" id=\"out\" data-id=\"$single_data->id\">Out for Delivery</a>&emsp;<a href=\"".route('admin.order_status_update', ['order_id' => encrypt($single_data->id), 'status' => encrypt(4)])."\" class=\"btn btn-danger\">Cancel Order</a>";
                else if($single_data->order_status == 2)
                    $val = "&emsp;<a href=\"".route('admin.order_status_update', ['order_id' => encrypt($single_data->id), 'status' => encrypt(3)])."\" class=\"btn btn-primary\">Delivered Order</a>&emsp;<a href=\"".route('admin.order_status_update', ['order_id' => encrypt($single_data->id), 'status' => encrypt(4)])."\" class=\"btn btn-danger\">Cancel Order</a>";
                else if($single_data->order_status == 4)
                    $val = "&emsp;<a href=\"".route('admin.order_status_update', ['order_id' => encrypt($single_data->id), 'status' => encrypt(2)])."\" class=\"btn btn-primary\" id=\"out\">Out for Delivery</a>";
                else
                    $val = "&emsp;";

                if (empty($single_data->payment_status)) 
                	$payment_status = "No Action";
                else 
                {
                	if($single_data->payment_status == 1)
	                	$payment_status = "Failed";
	                else if($single_data->payment_status == 3)
                        $payment_status = "COD";
                    else 
                        $payment_status = "PAID";
                }

                $nestedData['id']             = $cnt;
                $nestedData['order_id']       = $single_data->order_id;
                $nestedData['dispatch_id']       = $single_data->awb_no ?? '';
                $nestedData['user_name']      = "<a href=\"".route('admin.users_profile', ['user_id' => encrypt($single_data->user_id)])."\" title=\"View User Detail\" target=\"_blank\">$single_data->name</a>";
                $nestedData['payment_id']     = $single_data->payment_id;
                $nestedData['payment_status'] = $payment_status;
                $nestedData['order_date']     = \Carbon\Carbon::parse($single_data->created_at)->toDayDateTimeString();
                $nestedData['action']  = "$val&emsp;<a href=\"".route('admin.order_detail', ['order_id' => encrypt($single_data->id)])."\" class=\"btn btn-info\" target=\"_blank\">View Details</a>&emsp;<a href=\"".route('admin.invoice', ['order_id' => encrypt($single_data->id)])."\" class=\"btn btn-success\" target=\"_blank\">Invoice</a>";

                $data[] = $nestedData;

                $cnt++;
            }
        }

        $json_data = array(
                        "draw"            => intval($request->input('draw')),  
                        "recordsTotal"    => intval($totalData),  
                        "recordsFiltered" => intval($totalFiltered), 
                        "data"            => $data   
                    );
            
        print json_encode($json_data); 
    }

    public function orderStatusUpdate($order_id, $status)
    {
    	try {
            $order_id = decrypt($order_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        try {
            $status = decrypt($status);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        DB::table('order')
        	->where('id', $order_id)
        	->update([
        		'order_status' => $status,
        		'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
        	]);

        return redirect()->back();
    }

    public function orderDetail($order_id)
    {
        try {
            $order_id = decrypt($order_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $order = Order::find($order_id);
        $user = User::find($order->user_id);

        $address = Address::find($order->address_id);

        // $order_detail = DB::table('order_detail')
        //     ->leftJoin('product_stock', 'order_detail.stock_id', '=', 'product_stock.id')
        //     ->leftJoin('product', 'product_stock.product_id', '=', 'product.id')
        //     ->leftJoin('size', 'product_stock.size_id', '=', 'size.id')
        //     ->leftJoin('color', 'product_stock.color_id', '=', 'color.id')
        //     ->where('order_detail.order_id', $order_id)
        //     ->select('product_stock.product_id', 'product_stock.size_id', 'product_stock.color_id', 'product.product_name', 'size.size', 'color.color', 'order_detail.*')
        //     ->get();
        $order_detail = OrderDetails::where('order_id', $order_id)->get();
        return view('admin.orders.action.order_detail', ['order' => $order, 'user' => $user, 'address' => $address, 'order_detail' => $order_detail]);
    }

    public function invoice($order_id)
    {
        try {
            $order_id = decrypt($order_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $order = Order::find($order_id);

        $address = Address::find($order->address_id);

        // $order_detail = DB::table('order_detail')
        //     ->leftJoin('product_stock', 'order_detail.stock_id', '=', 'product_stock.id')
        //     ->leftJoin('product', 'product_stock.product_id', '=', 'product.id')
        //     ->leftJoin('size', 'product_stock.size_id', '=', 'size.id')
        //     ->leftJoin('color', 'product_stock.color_id', '=', 'color.id')
        //     ->where('order_detail.order_id', $order_id)
        //     ->select('product_stock.product_id', 'product_stock.size_id', 'product_stock.color_id', 'product.product_name', 'size.size', 'color.color', 'order_detail.*')
        //     ->get();
        $order_detail = OrderDetails::where('order_id', $order_id)->get();
        
        return view('admin.orders.action.invoice', ['order' => $order, 'address' => $address, 'order_detail' => $order_detail]);
    }

    public function usersOrdersHistoryList($user_id)
    {
        try {
            $user_id = decrypt($user_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $user_info = DB::table('users')
            ->where('id', $user_id)
            ->first();

        return  view('admin.orders.orders_history.orders_history', ['user_info' => $user_info]);
    }

    public function ordersHistoryListData(Request $request)
    {
        $columns = array( 
                            0 => 'id', 
                            2 => 'order_id',
                            3 => 'user_name',
                            4 => 'payment_id',
                            5 => 'payment_status',
                            6 => 'order_date',
                            7 => 'order_status',
                            8 => 'action',
                        );

        $totalData = DB::table('order')
            ->where('user_id', $request->input('user_id'))
            ->count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))) {            
            
            $order_data = DB::table('order')
                            ->leftJoin('users', 'order.user_id', '=', 'users.id')
                            ->select('order.*', 'users.name')
                            ->where('order.user_id', $request->input('user_id'))
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
        }
        else {

            $search = $request->input('search.value'); 

            $order_data = DB::table('order')
                            ->leftJoin('users', 'order.user_id', '=', 'users.id')
                            ->select('order.*', 'users.name')
                            ->where('order.user_id', $request->input('user_id'))
                            ->orWhere('order.order_id','LIKE',"%{$search}%")
                            ->orWhere('users.name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = DB::table('order')
                            ->leftJoin('users', 'order.user_id', '=', 'users.id')
                            ->select('order.*', 'users.name')
                            ->where('order.user_id', $request->input('user_id'))
                            ->orWhere('order.order_id','LIKE',"%{$search}%")
                            ->orWhere('users.name', 'LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();

        if(!empty($order_data)) {

            $cnt = 1;

            foreach ($order_data as $single_data) {

                if($single_data->order_status == 1)
                    $val = "New Order";
                else if($single_data->order_status == 2)
                    $val = "Out for Delivery";
                else if($single_data->order_status == 4)
                    $val = "Canceled Order";
                else
                    $val = "Delivered Order";

                if (empty($single_data->payment_status)) 
                    $payment_status = "No Action";
                else 
                {
                    if($single_data->payment_status == 1)
                        $payment_status = "Failed";
                    else
                        $payment_status = "Paid";
                }

                $nestedData['id']             = $cnt;
                $nestedData['order_id']       = $single_data->order_id;
                $nestedData['user_name']      = "<a href=\"".route('admin.users_profile', ['user_id' => encrypt($single_data->user_id)])."\" title=\"View User Detail\" target=\"_blank\">$single_data->name</a>";
                $nestedData['payment_id']     = $single_data->payment_id;
                $nestedData['payment_status'] = $payment_status;
                $nestedData['order_date']     = \Carbon\Carbon::parse($single_data->created_at)->toDayDateTimeString();
                $nestedData['order_status']     = $val;
                $nestedData['action']  = "&emsp;<a href=\"".route('admin.order_detail', ['order_id' => encrypt($single_data->id)])."\" class=\"btn btn-info\" target=\"_blank\">View Details</a>";

                $data[] = $nestedData;

                $cnt++;
            }
        }

        $json_data = array(
                        "draw"            => intval($request->input('draw')),  
                        "recordsTotal"    => intval($totalData),  
                        "recordsFiltered" => intval($totalFiltered), 
                        "data"            => $data   
                    );
            
        print json_encode($json_data); 
    }
}
