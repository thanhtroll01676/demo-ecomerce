<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;

class OrderController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $data['orders'] = Order::orderBy('id', 'ASC')->paginate(20);
//        dd($data);
        return view('admin.orders.index', $data);
    }

    public function show($id){
        $order = Order::find($id);
        if($order !== null){
            $data['order'] = $order;

            return view('admin.orders.show', $data);
        }else {
            // ng dùng can thiệp, sửa id của link: trên URL hoặc trong button edit
            return redirect()->route('admin.order.index')->with('loi', "Không tồn tại đơn hàng có id: $id");
        }
    }

    public function delete($id){
        $order = Order::find($id);
        if ($order !== null) {
            $order->delete();
            return redirect()->route('admin.order.index')->with('thongbao', "Đã xoá đơn hàng $order->name");
        }else{
            // ng dùng can thiệp, sửa id của link trong action của form ẩn DELETE
            return redirect()->route('admin.order.index')->with('loi', "Không tồn tại đơn hàng có id: $id");
        }
    }
}
