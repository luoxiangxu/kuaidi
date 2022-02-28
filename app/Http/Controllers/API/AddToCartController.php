<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Order;
use App\Credit;

class AddToCartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth('api')->user()->id;
        return Order::where([
            ['user_id' , $user_id],
            ['make_order', null],
        ])->orderBy('created_at' , 'desc')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'qr_code' => 'required|base64image',
            'description_image' => 'required|base64image',
            'item_name' => 'required',
            'quantity' => 'required|integer',
            'remark' => 'sometimes',
        ]);

        $qr_code_image = $request->qr_code;
        $qr_code_name = rand().'.'.explode('/',explode(':', substr($qr_code_image,0,strpos($qr_code_image, ';')))[1])[1];
        \Image::make($qr_code_image)->save(public_path('images/qr_code_images/').$qr_code_name);

        $description_image = $request->description_image;
        $description_image_name = rand().'.'.explode('/',explode(':', substr($description_image,0,strpos($description_image, ';')))[1])[1];
        \Image::make($description_image)->save(public_path('images/description_images/').$description_image_name);

        $userid = auth('api')->user()->id;
        $user_city = auth('api')->user()->user_city;
        $user = User::findOrFail($userid);
        $user->orders()->create([
            'user_id' => $userid,
            'qr_code' => $qr_code_name,
            'description_image' => $description_image_name,
            'item_name' => $request->item_name,
            'quantity' => $request->quantity,
            'remark' => $request->remark,
            'user_city' => $user_city,
        ]);   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $this->validate($request,[
            'item_name' => 'required',
            'quantity' => 'required|integer',
            'remark' => 'sometimes',
        ]);

        $order->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $qrCode = $order->qr_code;
        $description_image = $order->description_image;

        $qrCode_path = public_path('images/qr_code_images/').$qrCode;
        $description_image_path = public_path('images/description_images/').$description_image;

        @unlink($qrCode_path);
        @unlink($description_image_path);

        $order->delete();
    }

    public function placeOrder()
    {
        $order_id = \Request::get('q');
        $user_id = auth('api')->user()->id;

        $credit = Credit::where('user_id', $user_id)->get();
        $amount = $credit[0]->amount;

        if($amount == 0 )
        {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Error',
            ], 400);
        }

        $orderCount = Order::where([
            ['user_id' , $user_id],
            ['make_order', true],
            ['ordered', null],
            ['rejected', null]
        ])->count();

        if($orderCount <=2 )
        {
            date_default_timezone_set("Asia/Yangon");
            $order = Order::findOrFail($order_id);
            $order->make_order = true;
            $order->make_order_date = date("Y-m-d h:i:sa");
            $order->status = "in progress";
            $order->save();
        }else{
            return response()->json([
                'status' => 'error',
                'msg'    => 'Error',
            ], 403);
        }
    }

    public function getOrders()
    {
        $user_id = auth('api')->user()->id;

        return Order::where([
            ['user_id' , $user_id],
            ['make_order', true],
        ])->orderBy('make_order_date' , 'desc')->paginate(10);
    }

    public function searchUserOrder()
    {
        $user_id = auth('api')->user()->id;
        if($search = \Request::get('q')){
            $orders = Order::where([
                ['item_name','LIKE',"%$search%"],
                ['user_id', $user_id],
                ['make_order', true]
            ])->orderBy('make_order_date', 'desc')->paginate(10);
        }else{
            $orders = Order::Where([
                ['user_id', $user_id],
                ['make_order', true]
            ])->orderBy('make_order_date', 'desc')->paginate(10);
        }
        return $orders;
    }

    public function searchAddToCart()
    {
        $user_id = auth('api')->user()->id;
        if($search = \Request::get('q')){
            $orders = Order::where([
                ['item_name','LIKE',"%$search%"],
                ['user_id', $user_id],
                ['make_order', null]
            ])->orderBy('created_at', 'desc')->paginate(10);
        }else{
            $orders = Order::Where([
                ['user_id', $user_id],
                ['make_order', null]
            ])->orderBy('created_at', 'desc')->paginate(10);
        }
        return $orders;
    }

    public function getUserOrders()
    {
        return Order::Where([
            ['make_order', true],
            ['ordered', null],
            ['rejected', null],
        ])->orderBy('make_order_date', 'asc')->paginate(10);
    }

    public function makeOrder(Request $request)
    {
        $this->validate($request,[
            'item_price' => 'required|integer',
            'shippment_amount' => 'required|integer',
        ]);
        date_default_timezone_set("Asia/Yangon");
        $order_id = $request->id;
        $order = Order::findOrFail($order_id);
        $order->item_price = $request->item_price;
        $order->shippment_amount = $request->shippment_amount;
        $order->total_amount = $request->total_amount;
        $order->ordered = true;
        $order->ordered_date = date("Y-m-d h:i:sa");
        $order->status = "ordered";
        $order->save();

        $user_id = $request->user_id;
        $user = User::findOrFail($user_id);
        $user->credit()->decrement('amount', $request->total_amount);  
    }

    public function rejectOrder(Request $request)
    {
        $this->validate($request,[
            'rejected_reason' => 'required',
        ]);
        date_default_timezone_set("Asia/Yangon");
        $order = Order::findOrFail($request->id);
        $order->rejected = true;
        $order->rejected_reason = $request->rejected_reason;
        $order->rejected_date = date("Y-m-d h:i:sa");
        $order->status = "rejected";
        $order->save();
    }

    public function arrivedOrder()
    {
        return Order::where([
            ['ordered', true],
            ['order_arrived', null]
        ])->orderBy('make_order_date' , 'asc')->paginate(10);
    }

    public function makeOrderArrived()
    {
        date_default_timezone_set("Asia/Yangon");
        $order_id = \Request::get('q');
        $order = Order::findOrFail($order_id);
        $order->order_arrived = true;
        $order->order_arrived_date = date("Y-m-d h:i:sa");
        $order->status = "Arrived Nam Kham";
        $order->save();
    }

    public function searchArrivedOrder()
    {
        if($search = \Request::get('q')){
            $arrivedOrders = Order::where([
                ['id', $search],
                ['ordered', true],
                ['order_arrived', null]
            ])->paginate(10);
        }else{
            $arrivedOrders = Order::where([
                ['ordered', true],
                ['order_arrived', null]
            ])->orderBy('ordered_date', 'asc')->paginate(10);;
        }
        return $arrivedOrders;
    }

    public function getQuery(Request $request)
    {
        $this->validate($request,[
            'from_date' => 'required',
            'to_date' => 'required',
        ]);

        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $orders[0] = Order::where([
            ['ordered_date','>=',$from_date],
            ['ordered_date','<=',$to_date]
        ])->orderBy('ordered_date', 'desc')->paginate(10);

        $orders[1] = Order::where([
            ['ordered_date','>=',$from_date],
             ['ordered_date','<=',$to_date]
        ])->sum('total_amount');

        $orders[2] = Order::where([
            ['ordered_date','>=',$from_date],
             ['ordered_date','<=',$to_date]
        ])->sum('shippment_amount');

        $orders[3] = Order::where([
            ['ordered_date','>=',$from_date],
             ['ordered_date','<=',$to_date]
        ])->count();

        return $orders;
    }

    public function orderRecord()
    {
        $orders[0] = Order::where('ordered', true)->orderBy('ordered_date', 'desc')->paginate(10);

        $orders[1] = Order::where('ordered', true)->sum('total_amount');

        $orders[2] = Order::where('ordered', true)->sum('shippment_amount');

        $orders[3] = Order::where('ordered', true)->count();

        return $orders;
    }
}
