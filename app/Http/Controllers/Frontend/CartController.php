<?php

namespace App\Http\Controllers\Frontend;

use App\Category;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class CartController extends Controller
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

    // CHẠY KHI NGTA BẤM VÀO NÚT GIỎ HÀNG
    public function index(Request $request) // Để lấy đc cookie
    {
        // Lấy cookie (nếu có)
        $tmp = json_decode($request->cookie('cart'), true); // true để sau decode là 1 mảng chứ k phải 1 obj
        $cart = is_array($tmp) ? $tmp : [];// nếu k tồn tại cookie thì sau decode sẽ là null, mình chỉnh nó thành mảng rỗng
        if(count($cart) > 0){
            // Tính tổng số tiền dựa vào số lượng và giá của từng món
            $sumPrice = 0;
            foreach($cart as $id => $value){
                $sumPrice += $value['price'] * $value['quantity'];
            }
            $data = [
                'total' => count($cart), // Số loại sản phẩm khác nhau trong giỏ
                'sumPrice' => number_format($sumPrice, 0, ',', '.'),
                'cart' => $cart
            ];
            return view('frontend.default.cart', $data);
        }
        return redirect()->route('frontend.home.index');
    }

    // Action xử lý AJAX gửi lên từ trang index.blade.php (TRANG CHỦ) khi ngta nhấn 'Thêm giỏ hàng'
    public function addToCart(Request $request){
        $id = $request->input('id');
        if($request->ajax() && is_numeric($id)){
            $product = Product::find($id);
            if($product !== null){
                // Lấy cookie (nếu có)
                $tmp = json_decode($request->cookie('cart'), true); // true để sau decode là 1 mảng chứ k phải 1 obj
                $cart = is_array($tmp) ? $tmp : [];// nếu k tồn tại cookie thì sau decode sẽ là null, mình chỉnh nó thành mảng rỗng

                if( ! array_key_exists($id, $cart)){ // Chưa có sản phẩm loại này trong giỏ
                    $cart[$id] = [
                        'name' => $product->name,
                        'code' => $product->code,
                        'price' => $product->sale_price,
                        'image' => $product->image ? asset("uploaded/$product->image") : asset("images/no_image_73x73.jpg"),
                        'quantity' => is_numeric($request->input('quantity')) && $request->input('quantity') > 0 ? $request->input('quantity') : 1,
                    ];
                }else{ // Đã có sản phẩm loại này trong giỏ rồi, ngta thêm tiếp thì tăng số lượng thôi
                    $cart[$id]['quantity'] += is_numeric($request->input('quantity')) && $request->input('quantity') > 0 ? $request->input('quantity') : 1;
                }
                // Tạo cookie (PHẢI CHẠY TRƯỚC VÒNG FOREACH PHÍA DƯỚI)
                $cookie = cookie('cart', json_encode($cart), 5);
                // Tính tổng số tiền dựa vào số lượng và giá của từng món
                $sumPrice = 0;
                foreach($cart as $id => $value){
                    $sumPrice += $value['price'] * $value['quantity'];
                    $cart[$id]['price'] = number_format($value['price'], 0, ',', '.');
                }
                // Trả kết quả về sau khi xử lý AJAX, có gửi kèm cookie nữa
                return response()->json([
                    'message' => 'Đã thêm vào giỏ hàng thành công',
                    'total' => count($cart), // Số loại sản phẩm khác nhau trong giỏ
                    'sumPrice' => number_format($sumPrice, 0, ',', '.'),
                    'cart' => $cart
                ])->withCookie($cookie);
            }
        }
    }

    /* TỰ CHẠY KHI LOAD (LẠI) TRANG FRONTEND.DEFAULT.MASTER */
    public function getCart(Request $request){
        // Lấy cookie (nếu có)
        $tmp = json_decode($request->cookie('cart'), true); // true để sau decode là 1 mảng chứ k phải 1 obj
        $cart = is_array($tmp) ? $tmp : [];// nếu k tồn tại cookie thì sau decode sẽ là null, mình chỉnh nó thành mảng rỗng
        // Tính tổng số tiền dựa vào số lượng và giá của từng món
        $sumPrice = 0;
        foreach($cart as $id => $value){
            $sumPrice += $value['price'] * $value['quantity'];
            $cart[$id]['price'] = number_format($value['price'], 0, ',', '.');
        }
        // Trả kết quả về sau khi xử lý AJAX
        return response()->json([
            'message' => 'Đã thêm vào giỏ hàng thành công',
            'total' => count($cart), // Số loại sản phẩm khác nhau trong giỏ
            'sumPrice' => number_format($sumPrice, 0, ',', '.'),
            'cart' => $cart
        ]);
    }

    // CHẠY KHI BẤM NÚT 'Cập nhật giỏ hàng'
    public function updateCart(Request $request){
        // Lấy cookie (nếu có)
        $tmp = json_decode($request->cookie('cart'), true); // true để sau decode là 1 mảng chứ k phải 1 obj
        $cart = is_array($tmp) ? $tmp : [];// nếu k tồn tại cookie thì sau decode sẽ là null, mình chỉnh nó thành mảng rỗng
        foreach($request->input('cart') as $id => $quantity){
            if(isset($cart[$id])){
                if(is_numeric($quantity) && $quantity > 0){
                    $cart[$id]['quantity'] = $quantity;
                }else{
                    unset($cart[$id]);
                }
            }
        }
        $cookie = cookie('cart', json_encode($cart), 5);
        return redirect()->route('frontend.cart.index')->withCookie($cookie);
    }

    public function deleteCart(Request $request, $id){
        // Lấy cookie (nếu có)
        $tmp = json_decode($request->cookie('cart'), true); // true để sau decode là 1 mảng chứ k phải 1 obj
        $cart = is_array($tmp) ? $tmp : [];// nếu k tồn tại cookie thì sau decode sẽ là null, mình chỉnh nó thành mảng rỗng
        if(isset($cart[$id])){
            unset($cart[$id]);
        }
        $cookie = cookie('cart', json_encode($cart), 5);
        return redirect()->route('frontend.cart.index')->withCookie($cookie);
    }

    public function deleteAll(Request $request){
        $cookie = cookie('cart', json_encode([]), 5);
        return redirect()->route('frontend.cart.index')->withCookie($cookie);
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
