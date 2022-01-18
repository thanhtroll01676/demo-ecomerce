<?php

namespace App\Http\Controllers\Frontend;

use App\Category;
use App\Mail\OrderConfirmation;
use App\Product;
use App\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class CheckoutController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth'); // phần visitor xem mà

        View::share('categories', $this->makeCategories(Category::orderBy('name', 'ASC')->get()));
    }

    // CHẠY KHI NGTA BẤM VÀO NÚT CHECKOUT
    public function index(Request $request) // Để lấy đc cookie
    {
        // Lấy cookie (nếu có)
        $tmp = json_decode($request->cookie('cart'), true); // true để sau decode là 1 mảng chứ k phải 1 obj
        $cart = is_array($tmp) ? $tmp : [];// nếu k tồn tại cookie thì sau decode sẽ là null, mình chỉnh nó thành mảng rỗng

        $data['total'] = 0;
        $data['products'] = [];
        if(count($cart) > 0){
            $products = Product::whereIn('id', array_keys($cart))->get();
            // Những id có thật
            $id_exists = [];
            foreach($products as $product){
                array_unshift($id_exists, $product->id);
            }
            // Xóa những id ko có thật
            foreach($cart as $id => $v){
                if( ! in_array($id, $id_exists)){
                    unset($cart[$id]);
                }
            }
            // Chuẩn bị dữ liệu để xuất ra view
            $data['total'] = 0;
            foreach($products as $product){
                // Ghi đè số lượng hàng còn lại của sp đó thành số sp mà khách đặt
                $product->quantity = $cart[$product->id]['quantity'];
                $product->subtotal = $product->quantity * $product->sale_price;
                $data['total'] += $product->subtotal;
            }
            $data['products'] = $products;
            // Cập nhật lại cookie
            $cookie = cookie('cart', json_encode($cart), 5);
        }
        if (count($cart) === 0){
            return redirect()->route('frontend.home.index');
        }
        return response()->view('frontend.default.checkout', $data)->withCookie($cookie);
    }

    public function placeOrder(Request $request){

        // Lấy cookie (nếu có)
        $tmp = json_decode($request->cookie('cart'), true); // true để sau decode là 1 mảng chứ k phải 1 obj
        $cart = is_array($tmp) ? $tmp : [];// nếu k tồn tại cookie thì sau decode sẽ là null, mình chỉnh nó thành mảng rỗng

        if(count($cart) > 0){
            $valid = Validator::make($request->all(), [
                // CÁC LUẬT RÀNG BUỘC
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required|numeric',
                'address' => 'required',
            ], [
                // CÁC THÔNG BÁO KHI VI PHẠM RÀNG BUỘC TƯƠNG ỨNG
                'name.required' => 'Vui lòng nhập họ tên',

                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Vui lòng nhập đúng email',

                'phone.required' => 'Vui lòng nhập số điện thoại',
                'phone.numeric' => 'Vui lòng chỉ nhập số',

                'address.required' => 'Vui lòng nhập địa chỉ',
            ]);
            if($valid->fails()){
                // Có ít nhất 1 rule bị vi phạm
                return redirect()->back()->withErrors($valid)->withInput();
            }else{
                // Toàn bộ dữ liệu nhập hợp lệ rồi
                $products = Product::whereIn('id', array_keys($cart))->get();
                // Mảng $product_id_arr để đồng bộ bảng product_order với product_id và quantity
                $product_id_arr = [];
                foreach($products as $product){
                    $product_id_arr[$product->id] = [
                        'quantity' => $cart[$product->id]['quantity']
                    ];
                }
                $order = Order::create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'address' => $request->input('address'),
                    'user_id' => auth()->check() ? auth()->id() : null,
                ]);
                // Đồng bộ, cập nhật bảng product_order
                $order->products()->sync($product_id_arr);
                // Xóa cookie
                $cookie = cookie('cart', json_encode([]), 5);

                Mail::to($order->email)
//                    ->send(new OrderConfirmation($order));
                    ->queue(new OrderConfirmation($order));

                return redirect()->route('frontend.checkout.thankYou')
                    ->with('orderID', $order->id)
                    ->withCookie($cookie);
            }
        }
        if (count($cart) === 0){
            return redirect()->route('frontend.home.index');
        }
    }

    public function thankYou(){
        return view('frontend.default.thankyou');
    }

//    Method tạo ra 1 mảng chứa categories PHÂN CẤP theo parent của chúng
//    Category nào có chung parent, sẽ đc gom lại
    public function makeCategories($categories){
        $newCateArr = [];
        if(count($categories) > 0){
            foreach($categories as $category){
                $newCateArr[$category->parent][] = $category;
            }
        }
        return $newCateArr;
    }
}
