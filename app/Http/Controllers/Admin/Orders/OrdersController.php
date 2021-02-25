<?php

namespace App\Http\Controllers\Admin\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Address;
use App\Models\RefundInfo;
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

    public function returnRequestList()
    {
    	return view('admin.orders.return_request');
    }
    public function returnAcceptList()
    {
    	return view('admin.orders.return_accepted');
    }
    public function returnRejectedList()
    {
    	return view('admin.orders.return_rejected');
    }

    public function exchangeRequestList()
    {
    	return view('admin.orders.exchange_request');
    }
    public function exchangeAcceptList()
    {
    	return view('admin.orders.exchange_accepted');
    }
    public function exchangeRejectedList()
    {
    	return view('admin.orders.exchange_rejected');
    }

    public function newOrdersListAjax(Request $request){
        return datatables()->of(Order::where('order_status',1)->orderBy('id','desc')->get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn='';
               if($row->order_status == '1'){
                $btn .= '<a class="btn btn-danger btn-sm" href="'.route('admin.order_status_update',['order_id'=>encrypt($row->id),'status'=>encrypt(4)]).'">Cancel Order</a>';
                $btn .= '<a class="btn btn-primary btn-sm" id="out" data-id="'.$row->id.'">Shipped</a>';
               }
               $btn .=  '<a href="'.route('admin.order_detail', ['order_id' => encrypt($row->id)]).'" class="btn btn-success btn-sm">View Details</a>';
               return $btn;
            })->addColumn('username', function($row){
                if (isset($row->user->name)) {
                    return $row->user->name;
                } else {
                    return null;
                }
            })->addColumn('payment_status', function($row){
                if ($row->payment_status == '1') {
                    return '<a class="btn btn-danger btn-sm" >Failed</a>';
                } elseif($row->payment_status =='2') {
                    return '<a class="btn btn-success btn-sm" >Paid</a>';
                }else{
                    return '<a class="btn btn-info btn-sm" >Cod</a>';
                }
            })->addColumn('order_date', function($row){
               return $row->created_at->format('d-m-Y');
            })
            ->rawColumns(['action','username','payment_status','order_date'])
            ->make(true);
        
    }
   
    public function cancelOrdersListAjax(Request $request){
        return datatables()->of(Order::where('order_status',4)->orderBy('id','desc')->get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn='';
               if($row->order_status == '1'){
                $btn .= '<a class="btn btn-danger btn-sm" href="'.route('admin.order_status_update',['order_id'=>encrypt($row->id),'status'=>encrypt(4)]).'">Cancel Order</a>';
                $btn .= '<a class="btn btn-primary btn-sm" href="'.route('admin.order_status_update',['order_id'=>encrypt($row->id),'status'=>encrypt(2)]).'">Out For Delivery</a>';
               }
               $btn .=  '<a href="'.route('admin.order_detail', ['order_id' => encrypt($row->id)]).'" class="btn btn-success btn-sm">View Details</a>';
               return $btn;
            })->addColumn('username', function($row){
                if (isset($row->user->name)) {
                    return $row->user->name;
                } else {
                    return null;
                }
            })->addColumn('payment_status', function($row){
                if ($row->payment_status == '1') {
                    return '<a class="btn btn-danger btn-sm" >Failed</a>';
                } elseif($row->payment_status =='2') {
                    return '<a class="btn btn-success btn-sm" >Paid</a>';
                }else{
                    return '<a class="btn btn-info btn-sm" >Cod</a>';
                }
            })->addColumn('order_date', function($row){
               return $row->created_at->format('d-m-Y');
            })
            ->rawColumns(['action','username','payment_status','order_date'])
            ->make(true);
        
    }

    public function outForDeliveryOrdersListAjax(Request $request){
        return datatables()->of(Order::where('order_status',2)->orderBy('id','desc')->get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn='';
               if($row->order_status == '2'){
                
                $btn .= '<a class="btn btn-danger btn-sm" href="'.route('admin.order_status_update',['order_id'=>encrypt($row->id),'status'=>encrypt(4)]).'">Cancel Order</a>';
                $btn .= '<a class="btn btn-info btn-sm" href="'.route('admin.order_status_update',['order_id'=>encrypt($row->id),'status'=>encrypt(3)]).'">Delivered</a>';
               }
               $btn .=  '<a href="'.route('admin.order_detail', ['order_id' => encrypt($row->id)]).'" class="btn btn-success btn-sm">View Details</a>';
               return $btn;
            })->addColumn('username', function($row){
                if (isset($row->user->name)) {
                    return $row->user->name;
                } else {
                    return null;
                }
            })->addColumn('payment_status', function($row){
                if ($row->payment_status == '1') {
                    return '<a class="btn btn-danger btn-sm" >Failed</a>';
                } elseif($row->payment_status =='2') {
                    return '<a class="btn btn-success btn-sm" >Paid</a>';
                }else{
                    return '<a class="btn btn-info btn-sm" >Cod</a>';
                }
            })->addColumn('order_date', function($row){
               return $row->created_at->format('d-m-Y');
            })
            ->rawColumns(['action','username','payment_status','order_date'])
            ->make(true);
        
    }

    public function deliveredOrdersListAjax(Request $request){
        return datatables()->of(Order::where('order_status',3)->orderBy('id','desc')->get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn='';
               
               $btn .=  '<a href="'.route('admin.order_detail', ['order_id' => encrypt($row->id)]).'" class="btn btn-success btn-sm">View Details</a>';
               $btn .= '<a href="'.route('admin.invoice', ['order_id' => encrypt($row->id)]).'" class="btn btn-primary  btn-sm" target="_blank">Invoice</a>';
               return $btn;
            })->addColumn('username', function($row){
                if (isset($row->user->name)) {
                    return $row->user->name;
                } else {
                    return null;
                }
            })->addColumn('payment_status', function($row){
                if ($row->payment_status == '1') {
                    return '<a class="btn btn-danger btn-sm" >Failed</a>';
                } elseif($row->payment_status =='2') {
                    return '<a class="btn btn-success btn-sm" >Paid</a>';
                }else{
                    return '<a class="btn btn-info btn-sm" >Cod</a>';
                }
            })->addColumn('order_date', function($row){
               return $row->created_at->format('d-m-Y');
            })
            ->rawColumns(['action','username','payment_status','order_date'])
            ->make(true);
        
    }
    
    public function returnRequestListAjax(Request $request){
        return datatables()->of(Order::where('order_status',5)->orderBy('id','desc')->get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn='';
               $btn .=  '<a href="'.route('admin.add_return_request', ['order_id' => encrypt($row->id),'status'=>1]).'" class="btn btn-primary btn-sm">Accept Return Request</a>';
               $btn .=  '<a href="'.route('admin.add_return_request', ['order_id' => encrypt($row->id),'status'=>2]).'" class="btn btn-danger btn-sm">Reject Return Request</a>';
               $btn .=  '<a href="'.route('admin.order_detail', ['order_id' => encrypt($row->id)]).'" class="btn btn-success btn-sm">View Details</a>';
               return $btn;
            })->addColumn('username', function($row){
                if (isset($row->user->name)) {
                    return $row->user->name;
                } else {
                    return null;
                }
            })->addColumn('payment_status', function($row){
                if ($row->payment_status == '1') {
                    return '<a class="btn btn-danger btn-sm" >Failed</a>';
                } elseif($row->payment_status =='2') {
                    return '<a class="btn btn-success btn-sm" >Paid</a>';
                }else{
                    return '<a class="btn btn-info btn-sm" >Cod</a>';
                }
            })->addColumn('order_date', function($row){
               return $row->created_at->format('d-m-Y');
            })
            ->rawColumns(['action','username','payment_status','order_date'])
            ->make(true);
        
    }

    public function returnAcceptedListAjax(Request $request){
        return datatables()->of(Order::where('order_status',6)->orderBy('id','desc')->get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn='';
               
               $btn .=  '<a href="'.route('admin.order_detail', ['order_id' => encrypt($row->id)]).'" class="btn btn-success btn-sm">View Details</a>';
               return $btn;
            })->addColumn('username', function($row){
                if (isset($row->user->name)) {
                    return $row->user->name;
                } else {
                    return null;
                }
            })->addColumn('payment_status', function($row){
                if ($row->payment_status == '1') {
                    return '<a class="btn btn-danger btn-sm" >Failed</a>';
                } elseif($row->payment_status =='2') {
                    return '<a class="btn btn-success btn-sm" >Paid</a>';
                }else{
                    return '<a class="btn btn-info btn-sm" >Cod</a>';
                }
            })->addColumn('order_date', function($row){
               return $row->created_at->format('d-m-Y');
            })
            ->rawColumns(['action','username','payment_status','order_date'])
            ->make(true);
        
    }
    
    public function returnRejectedListAjax(Request $request){
        return datatables()->of(Order::where('order_status',7)->orderBy('id','desc')->get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn='';
               
               $btn .=  '<a href="'.route('admin.order_detail', ['order_id' => encrypt($row->id)]).'" class="btn btn-success btn-sm">View Details</a>';
               return $btn;
            })->addColumn('username', function($row){
                if (isset($row->user->name)) {
                    return $row->user->name;
                } else {
                    return null;
                }
            })->addColumn('payment_status', function($row){
                if ($row->payment_status == '1') {
                    return '<a class="btn btn-danger btn-sm" >Failed</a>';
                } elseif($row->payment_status =='2') {
                    return '<a class="btn btn-success btn-sm" >Paid</a>';
                }else{
                    return '<a class="btn btn-info btn-sm" >Cod</a>';
                }
            })->addColumn('order_date', function($row){
               return $row->created_at->format('d-m-Y');
            })
            ->rawColumns(['action','username','payment_status','order_date'])
            ->make(true);
        
    }
    
    public function addReturnRequest($id,$status){
        try {
            $order_id = decrypt($id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        $return = Order::findOrFail($order_id);
        return view('admin.orders.request_form',compact('return','status'));

    }
    
    public function processReturnRequest(Request $request){
        $this->validate($request,[
            'reasons'=>'required',
            'status'=>'required|numeric',
            'order_id'=>'required|numeric'
        ]);
        $status = $request->input('status');
        $order_id = $request->input('order_id');
        $reason = $request->input('reasons');
        $order = Order::findOrFail($order_id);
        if($status ==1){ 
            if($order->payment_type==2){
                if($order->payment_status==2){
                    $order->order_status = 6;
                    $order->return_accept_remark = $reason;
                    $refund = new RefundInfo();
                    $refund->order_id = $order_id;
                    $refund->user_id = $order->user_id;
                    $refund->amount = $order->amount;
                    $refund->status = 1;
                    $refund->save();
                }else{
                    return redirect()->back();
                }
            }else{
                $order->order_status = 6;
                $order->return_accept_remark = $reason;
            }

        }else{
            $order->order_status = 7;
            $order->return_cancel_remark = $reason;

        }
        if($order->save() && $status ==1){
            return redirect()->back()->with('message','Return Request accepted');
        }else{
            return redirect()->back()->with('message','Return Request Rejected');
        }

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
        $order = Order::findOrFail($order_id);
        if( $status==4){
            if($order->payment_type=2){
                if($order->payment_status == 2){
                    $refund = new RefundInfo();
                    $refund->order_id = $order_id;
                    $refund->user_id = $order->user_id;
                    $refund->amount = $order->amount;
                    $refund->save();
                }else{
                    return redirect()->back();
                }
            }else{
                 DB::table('order')
                ->where('id', $order_id)
                ->update([
                    'order_status' => $status,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                ]);
            }
            

        }else{
            
            DB::table('order')
            ->where('id', $order_id)
            ->update([
                'order_status' => $status,
                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            ]);
            
        }
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


    public function exchangeRequestListAjax(Request $request){
        return datatables()->of(Order::where('order_status',9)->orderBy('id','desc')->get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn='';
               $btn .=  '<a href="'.route('admin.add_exchange_request', ['order_id' => encrypt($row->id),'status'=>1]).'" class="btn btn-primary btn-sm">Accept Exchange Request</a>';
               $btn .=  '<a href="'.route('admin.add_exchange_request', ['order_id' => encrypt($row->id),'status'=>2]).'" class="btn btn-danger btn-sm">Reject Exchange Request</a>';
               $btn .=  '<a href="'.route('admin.order_detail', ['order_id' => encrypt($row->id)]).'" class="btn btn-success btn-sm">View Details</a>';
               return $btn;
            })->addColumn('username', function($row){
                if (isset($row->user->name)) {
                    return $row->user->name;
                } else {
                    return null;
                }
            })->addColumn('payment_status', function($row){
                if ($row->payment_status == '1') {
                    return '<a class="btn btn-danger btn-sm" >Failed</a>';
                } elseif($row->payment_status =='2') {
                    return '<a class="btn btn-success btn-sm" >Paid</a>';
                }else{
                    return '<a class="btn btn-info btn-sm" >Cod</a>';
                }
            })->addColumn('order_date', function($row){
               return $row->created_at->format('d-m-Y');
            })
            ->rawColumns(['action','username','payment_status','order_date'])
            ->make(true);
        
    }

    public function exchangeAcceptedListAjax(Request $request){
        return datatables()->of(Order::where('order_status',10)->orderBy('id','desc')->get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn='';
               
               $btn .=  '<a href="'.route('admin.order_detail', ['order_id' => encrypt($row->id)]).'" class="btn btn-success btn-sm">View Details</a>';
               return $btn;
            })->addColumn('username', function($row){
                if (isset($row->user->name)) {
                    return $row->user->name;
                } else {
                    return null;
                }
            })->addColumn('payment_status', function($row){
                if ($row->payment_status == '1') {
                    return '<a class="btn btn-danger btn-sm" >Failed</a>';
                } elseif($row->payment_status =='2') {
                    return '<a class="btn btn-success btn-sm" >Paid</a>';
                }else{
                    return '<a class="btn btn-info btn-sm" >Cod</a>';
                }
            })->addColumn('order_date', function($row){
               return $row->created_at->format('d-m-Y');
            })
            ->rawColumns(['action','username','payment_status','order_date'])
            ->make(true);
        
    }
    
    public function exchangeRejectedListAjax(Request $request){
        return datatables()->of(Order::where('order_status',11)->orderBy('id','desc')->get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn='';
               
               $btn .=  '<a href="'.route('admin.order_detail', ['order_id' => encrypt($row->id)]).'" class="btn btn-success btn-sm">View Details</a>';
               return $btn;
            })->addColumn('username', function($row){
                if (isset($row->user->name)) {
                    return $row->user->name;
                } else {
                    return null;
                }
            })->addColumn('payment_status', function($row){
                if ($row->payment_status == '1') {
                    return '<a class="btn btn-danger btn-sm" >Failed</a>';
                } elseif($row->payment_status =='2') {
                    return '<a class="btn btn-success btn-sm" >Paid</a>';
                }else{
                    return '<a class="btn btn-info btn-sm" >Cod</a>';
                }
            })->addColumn('order_date', function($row){
               return $row->created_at->format('d-m-Y');
            })
            ->rawColumns(['action','username','payment_status','order_date'])
            ->make(true);
        
    }

    public function addExchangeRequest($id,$status){
        try {
            $order_id = decrypt($id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        $exchange = Order::findOrFail($order_id);
        return view('admin.orders.exchange_form',compact('exchange','status'));

    }
    
    public function processExchangeRequest(Request $request){
        $this->validate($request,[
            'reasons'=>'required',
            'status'=>'required|numeric',
            'order_id'=>'required|numeric'
        ]);
        $status = $request->input('status');
        $order_id = $request->input('order_id');
        $reason = $request->input('reasons');
        $order = Order::findOrFail($order_id);
        if($status ==1){ 
            $order->order_status = 6;
            $order->exchange_accept_remark = $reason;
         
        }else{
            $order->order_status = 11;
            $order->exchange_cancel_remark = $reason;

        }
        if($order->save() && $status ==1){
            return redirect()->back()->with('message','Exchange Request accepted');
        }else{
            return redirect()->back()->with('message','Exchange Request Rejected');
        }

    }

   
}
