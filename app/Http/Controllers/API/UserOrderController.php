<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\Order;
use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserOrderController extends Controller
{
    public function __construct()
    {
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
    // public function orderSuccess(Request $request)
    // {
    //     $checkout = Checkout::find($request->id);
    //     $checkout->status = $checkout->status === "0" ? '1' : "0";
    //     $checkout->save();
    //     return response()->json([
    //         'status' => 200,
    //         'message' => 'Đơn hàng đã giao thành công.',
    //     ]);
    // }


    function getOrdersUser()
    {
        return response()->json([
            'status' => 200,
            'orders' => Checkout::where('user_id', auth()->user()->_id)->get()
        ]);
    }
    function userOrderDetail($id)
    {
        $checkout = Checkout::find($id);
        $order = Order::where('checkout_id', $checkout->_id)->get();
        return response()->json([
            'status' => 200,
            'checkout' => $checkout,
            'order' => $order,
        ]);
    }
}
