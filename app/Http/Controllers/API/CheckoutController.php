<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\Order;
use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }
    function checkout(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'address' => 'required',
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->toJson()
            ], 400);
        }


        $checkout = new Checkout();
        $checkout->address = $request->address;
        $checkout->phone = $request->phone;
        $checkout->notes = $request->notes;
        $checkout->status = 0;
        $checkout->user_id = auth()->user()->_id;
        $checkout->save();

        $products = json_decode($request->products);

        foreach ($products as  $product) {
            $order = new Order();
            $order->checkout_id = $checkout->_id;
            $order->product_id = $product->_id;
            $order->qty = $product->qty;
            $order->save();
        }
        return response()->json([
            'status' => 200,
            'message' => 'Thanh toán thành công.',
            // 'products' => $products,
            // 'checkout' => $checkout,
            // 'order' => $order
        ]);
    }

    public function orders()
    {
        return response()->json([
            'status' => 200,
            'orders' => Checkout::all()
        ]);
    }
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    public function order($id)
    {
        $checkout = Checkout::find($id);
        $order = Order::where('checkout_id', $checkout->_id)->get();
        return response()->json([
            'status' => 200,
            'checkout' => $checkout,
            'order' => $order,
        ]);
    }
    public function orderSuccess(Request $request)
    {
        $checkout = Checkout::find($request->id);
        $checkout->status = $checkout->status == "0" ? 1 : 0;
        $checkout->save();
        return response()->json([
            'status' => 200,
            'message' => 'Đơn hàng đã giao thành công.',
        ]);
    }




    // function getOrdersUser()
    // {
    //     return response()->json([
    //         'status' => 200,
    //         'orders' => Checkout::where('user_id', auth()->user()->_id)->get()
    //     ]);
    // }
    // function findOrderUser($id)
    // {
    //     $checkout = Checkout::find($id);
    //     $order = Order::where('checkout_id', $checkout->_id)->get();
    //     return response()->json([
    //         'status' => 200,
    //         'checkout' => $checkout,
    //         'order' => $order,
    //     ]);
    // }
    // public function cancelOrder(Request $request)
    // {
    //     $checkout = Checkout::find($request->id);
    //     $checkout->status = $checkout->status === "0" ? '1' : "0";
    //     $checkout->save();
    //     return response()->json([
    //         'status' => 200,
    //         'message' => 'Đơn hàng đã hủy.',
    //     ]);
    // }
}
