<?php

namespace App\Http\Controllers\Frontend;

use App\Comment;
use App\Product;
use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
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

    /**
     * Trang chủ
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) // Để lấy đc cookie
    {
//        dd($request->cookie('recent_products'));
        $data['products'] = Product::orderBy('id', 'desc')->limit(12)->get();
        $data['featured_products'] = Product::where('featured_product' , '=', 1)->orderBy('id', 'desc')->limit(12)->get();
        $data['recent_products'] = [];
//        $data['categories'] = $this->makeCategories(Category::orderBy('name', 'ASC')->get());

        /* BEST SELLERS */
        $time = time();
        $_20daysBeforeToday = date('Y-m-d', $time - 20 * 86400);
        $now = date('Y-m-d', $time);
        /*
        $data['best_seller'] = DB::select(DB::raw(
            '  SELECT p.id, p.name, p.image, p.code, p.sale_price, sum_quan
                    FROM products AS p
                    INNER JOIN (
                                SELECT product_order.product_id, SUM(product_order.quantity) AS sum_quan 
                                FROM product_order 
                                WHERE DATE(product_order.updated_at) BETWEEN ? AND ?
                                GROUP BY product_order.product_id 
                                ORDER BY sum_quan DESC 
                                LIMIT 0, 7
                                ) AS po
                    ON p.id = po.product_id'
        ),[
            $_20daysBeforeToday,
            $now
        ]);
        */
        $data['best_sellers'] =
            Product::select('id', 'name', 'code', 'sale_price', 'image')
            ->join(DB::raw(
                            '(SELECT product_id, SUM(quantity) AS sum_quan 
                                    FROM product_order 
                                    WHERE DATE(updated_at) BETWEEN ? AND ?
                                    GROUP BY product_id 
                                    ORDER BY sum_quan DESC 
                                    LIMIT 0, 7) AS best_sellers'
                            ),
                        function($join){
                            $join->on('products.id', '=', 'best_sellers.product_id');
                        }
                    )
            ->addBinding([$_20daysBeforeToday, $now])
            ->get();

        $ids_arr = json_decode($request->cookie('recent_products'));
        if( ! empty($ids_arr)){
            $recent_products = $ids_arr;
        }else{
            $recent_products = null;
        }
        // Lấy những sp ngta đã xem (có id nằm trong mảng $recent_products)
        if(is_array($recent_products)){
            $data['recent_products'] = Product::whereIn('id', $ids_arr)->limit(10)->get();
        }
        return view('frontend.default.index', $data);
    }

    /**
     * Trang hiển thị sản phẩm
     */
    public function show(Request $request ,$slug, $id){
        $data['product'] = Product::find($id);

        // Có rồi thì gán lại, chưa có thì khởi tạo mảng []
        $ids_arr = json_decode($request->cookie('recent_products'));
        $recent_products = is_array($ids_arr) ? $ids_arr : [];

        // Kiểm tra xem đã chứa trong mảng chưa? Tránh trùng lặp
        if( ! in_array($data['product']->id, $recent_products)){
            array_unshift($recent_products, $data['product']->id);
        }
        // Giới hạn số lượng khi có quá nhiều
        if(count($recent_products) > 10){
            $recent_products = array_slice($recent_products, 0, 10);
        }
        $cookie = cookie('recent_products', json_encode($recent_products), 5);

        $data['recent_products'] = Product::whereIn('id', $recent_products)->limit(10)->get();

        // Đổ ra view và thêm cookie thông qua response
        return response()->view('frontend.default.single-product', $data)->cookie($cookie);
    }

    public function saveComment(Request $request, $slug, $id){
        $valid = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'content' => 'required',
            'score' => 'required|between:1,5',
        ], [
            'name.required' => 'Vui lòng nhập Tên.',
            'email.required' => 'Vui lòng nhập Email.',
            'email.email' => 'Vui lòng nhập đúng định dạng email.',
            'content.required' => 'Vui lòng nhập Lời Nhận Xét.',
            'score.required' => 'Vui lòng thực hiện Đánh Giá.',
            'score.between' => 'Vui lòng chỉ đánh giá từ :min sao đến :max sao.',
        ]);

        if($valid->fails()){
            return redirect()->back()->withErrors($valid)->withInput();
        }else{
            Comment::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'content' => $request->input('content'),
                'rating' => $request->input('score'),
                'product_id' => $id,
            ]);
            return redirect()->back()->with('message', 'Đánh giá của bạn đã được lưu lại!');
        }
    }

    public function indexProducts(Request $request){
//        Sắp xếp sản phẩm theo 4 tiêu chí
        $products = Product::orderBy('id', 'desc');
        if($orderBy = $request->input('orderBy')){
            switch ($orderBy){
                case 'latest':
                    $products = Product::orderBy('id', 'desc');
                    break;
                case 'oldest':
                    $products = Product::orderBy('id', 'asc');
                    break;
                case 'highest':
                    $products = Product::orderBy('sale_price', 'desc');
                    break;
                case 'lowest':
                    $products = Product::orderBy('sale_price', 'asc');
                    break;
            }
        }
//        Tìm kiếm sản phẩm theo TÊN hoặc tên MÃ SP (code):
//        SELECT * FROM products
//        WHERE ('name' like ? or 'code' like ?) AND 'category_id' = ?
//        ORDER BY 'id' DESC
        if($search = $request->input('search')){
            $products->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
                $query->orWhere('code', 'like', "%$search%");
            });
        }
//        Tìm kiếm theo chuyên mục
        if($category = $request->input('category')){
            $products->where('category_id', $category);
        }

        $data['products'] = $products->paginate(12);
        return view('frontend.default.products', $data);
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
