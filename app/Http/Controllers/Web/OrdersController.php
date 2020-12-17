<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;
use DB;
use App\Models\Order;
use App\Models\OrderDetails;
class OrdersController extends Controller
{
    public function myOrderHistory(Request $request)
    {
        $orders = DB::table('order')
        	->where('user_id', Auth()->user()->id)
        	->orderBy('id', 'DESC')
        	->paginate(1);

        $order_history = [];
        foreach ($orders as $key => $item) {

        	if($item->payment_status == 1)
        		$payment_status = "Failed";
        	else
        		$payment_status = "Paid";

        	if($item->order_status == 1)
        		$order_status = "New Order";
        	else if($item->order_status == 2)
        		$order_status = "Out for Delivery";
        	else if($item->order_status == 3)
        		$order_status = "Delivered";
        	else
        		$order_status = "Canceled";

        	$order_detail = DB::table('order_detail')
        		->leftJoin('product_stock', 'order_detail.stock_id', '=', 'product_stock.id')
        		->leftJoin('product', 'product_stock.product_id', '=', 'product.id')
        		->leftJoin('size', 'product_stock.size_id', '=', 'size.id')
        		->leftJoin('color', 'product_stock.color_id', '=', 'color.id')
        		->where('order_detail.order_id', $item->id)
        		->select('product.id', 'product.product_name', 'product.banner', 'order_detail.price', 'order_detail.discount', 'order_detail.quantity', 'size.size', 'color.color')
        		->get();

        	$billing_address = DB::table('address')
        		->where('id', $item->address_id)
        		->first();

        	$order_history [] = [
        		'id' => $item->id,
        		'order_id' => $item->order_id,
        		'payment_status' => $payment_status,
        		'order_status' => $order_status,
        		'order_date' => \Carbon\Carbon::parse($item->created_at)->toDayDateTimeString(),
        		'order_detail' => $order_detail,
        		'billing_address' => $billing_address

        	];
        }

        if ($request->ajax()) {
            $view = view('web.order_history.order_history_data', compact('order_history'))->render();
            return response()->json(['html'=>$view]);
        }

        return view('web.order_history.order_history', ['order_history' => $order_history]);
	}
	public function orderDetail(){
		$orders = Order::latest()->paginate(10);
		return view('web.order.order', compact('orders'));
	}

	public function orderDetailss($id){
		$order_details = OrderDetails::where('id',$id)->get();
		
		return view('web.order.order_details',compact('order_details'));

	}
}
