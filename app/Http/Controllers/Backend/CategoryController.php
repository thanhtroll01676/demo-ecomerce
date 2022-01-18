<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['categories'] = Category::orderBy('order', 'ASC')->paginate(20);
//        dd($data);
        return view('admin.categories.index', $data);
    }

    public function create()
    {
        // Trên tinh thần là chỉ có tối đa 2 cấp chuyên mục
        // Nên chuyên mục nào có parent = 0 thì mới có thể nhận
        // chuyên mục con
        $data['categories'] = Category::where([
            ['parent', '=', 0],
            ['id', '<>', 1]
        ])->get();
        return view('admin.categories.create', $data);
    }

    public function store(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name',
            'parent' => 'required',
        ], [
            'name.required' => 'Vui lòng nhập Tên chuyên mục',
            'name.unique' => 'Chuyên mục này đã tồn tại!!!',
            'parent.required' => 'Vui lòng nhập không xoá bỏ chuyên mục cha!!!',
            'parent.exists' => "Không tồn tại chuyên mục có id: ".$request->input('parent').", vui lòng không sửa value của chuyên mục cha!!"
        ]);
        // Ngoại lệ: cho phép trường parent từ form về có giá trị 0. mặc dù id của bảng categories >= 1
        $valid->sometimes('parent', 'exists:categories,id', function($input){
            if($input->parent !== "0"){
                // Không tồn tại trong bảng categories - cột id và có giá trị khác 0
                // Không cho phép (Chỉ cần có 1 cái true là: $valid->fails() == TRUE)
                return true;
            }else{
                // đc phép
                return false;
            }
        });
        if ($valid->fails()) {
            // Không hợp lệ, quay lại trang create, cùng với báo lỗi
            // và thông tin ng dùng đã nhập
            return redirect()->back()->withErrors($valid)->withInput();
        } else {
            // Hợp lệ, lưu vào csdl thông qua model Category
            $order = 0;
            if($request->input('order')){
                $order = $request->input('order');
            }
            $category = Category::create([
                'name' => $request->input('name'),
                'slug' => str_slug($request->input('name')),
                'parent' => $request->input('parent'),
                'order' => $order
            ]);
            return redirect()->route('admin.category.index')->with('thongbao', "Thêm chuyên mục $category->name thành công");
        }
    }

    // Khi ng dùng nhấn edit
    public function show($id)
    {
        $data['categories'] = Category::where([
            ['parent', '=', 0],
            ['id' ,'<>', 1]
        ])->get();

        $category = Category::find($id);
        if($category !== null){
            $data['category'] = $category;

            return view('admin.categories.show', $data);
        }else {
            // ng dùng can thiệp, sửa id của link: trên URL hoặc trong button edit
            return redirect()->route('admin.category.index')->with('loi', "Không tồn tại chuyên mục có id: $id");
        }
    }

    public function update(Request $request, $id)
    {
        $valid = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,'.$id,
            'parent' => 'required',
        ], [
            'name.required' => 'Vui lòng nhập Tên chuyên mục',
            'name.unique' => 'Chuyên mục này đã tồn tại!!!',
            'parent.required' => 'Vui lòng nhập không xoá bỏ chuyên mục cha!!!',
            'parent.exists' => "Không tồn tại chuyên mục có id: ".$request->input('parent').", vui lòng không sửa value của chuyên mục cha!!"
        ]);
        // Ngoại lệ: cho phép trường parent từ form về có giá trị 0. mặc dù id của bảng categories >= 1
        $valid->sometimes('parent', 'exists:categories,id', function($input){
            if($input->parent !== "0"){
                // Không tồn tại trong bảng categories - cột id và có giá trị khác 0
                // Không cho phép (Chỉ cần có 1 cái true là: $valid->fails() == TRUE)
                return true;
            }else{
                // đc phép
                return false;
            }
        });
        if ($valid->fails()) {
            // Không hợp lệ, quay lại trang show, cùng với báo lỗi
            // và thông tin ng dùng đã nhập
            return redirect()->back()->withErrors($valid)->withInput();
        } else {
            // Hợp lệ, lưu vào csdl thông qua model Category
            $category = Category::find($id);
            if($category !== null){
                $category->name = $request->input('name');
                $category->parent = $request->input('parent');
                if($request->input('order')){
                    $category->order = $request->input('order');
                }else{
                    $category->order = 0;
                }
                $category->save();
                return redirect()->route('admin.category.index')->with('thongbao', "Sửa chuyên mục $category->name thành công");
            }else{
                // khi ng dùng can thiệp, sửa id của link trong action của form PUT
                return redirect()->route('admin.category.index')->with('loi', "Không tồn tại chuyên mục có id: $id");
            }

        }
    }

    // khi ngta nhấn vào delete
    public function delete($id)
    {
        $category = Category::find($id);
        if ($category !== null) {
            $category->delete();
            return redirect()->route('admin.category.index')->with('thongbao', "Đã xoá chuyên mục $category->name");
        }else{
            // ng dùng can thiệp, sửa id của link trong action của form ẩn DELETE
            return redirect()->route('admin.category.index')->with('loi', "Không tồn tại chuyên mục có id: $id");
        }
    }
}
