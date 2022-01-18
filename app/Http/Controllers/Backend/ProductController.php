<?php

namespace App\Http\Controllers\Backend;

use App\Attachment;
use App\Http\Controllers\Controller;
use App\Category;
use App\MyLibrary\Facades\Tool;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use App\Tag;

class ProductController extends Controller
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
//        dd(Tool::getThumbnail('abc.jpg'));
        $data['products'] = Product::with('user')
            ->orderBy('featured_product', 'DESC')
            ->orderBy('id', 'DESC')
            ->paginate(20);
//        dd($data);
        return view('admin.products.index', $data);
    }

    public function create()
    {
        // Trên tinh thần là chỉ có tối đa 2 cấp sản phẩm
        // Nên sản phẩm nào có parent = 0 thì mới có thể nhận
        // sản phẩm con
        $data['categories'] = $this->makeCategories(Category::orderBy('name', 'ASC')->get());
//        dd($data);
        return view('admin.products.create', $data);
    }

    public function store(Request $request)
    {
//        dd($request->input('tags'));
//        dd($request->all());
        $valid = Validator::make($request->all(), [
            'name' => 'required',
            'code' => 'required|unique:products,code',
            'content' => 'required',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'original_price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            'image' => 'image|max:2048',
            'images.*' => 'image|max:2048',
            // exists:(tồn tại trong bảng nào),(tìm trong cột nào)
            'category_id' => 'required|exists:categories,id'
        ], [
            'name.required' => 'Vui lòng nhập Tên sản phẩm.',
            
            'code.required' => 'Vui lòng nhập Mã sản phẩm.',
            'code.unique' => 'Mã sản phẩm này đã tồn tại!!!',
            
            'content.required' => 'Vui lòng nhập mô tả cho sản phẩm.',
            
            'regular_price.required' => 'Vui lòng nhập giá thị trường',
            'regular_price.numeric' => 'Giá thị trường phải là chữ số.',
            'regular_price.min' => 'Giá trị nhỏ nhất là :min',

            'sale_price.required' => 'Vui lòng nhập giá bán',
            'sale_price.numeric' => 'Giá bán phải là chữ số.',
            'sale_price.min' => 'Giá trị nhỏ nhất là :min',

            'original_price.required' => 'Vui lòng nhập giá gốc',
            'original_price.numeric' => 'Giá gốc phải là chữ số.',
            'original_price.min' => 'Giá trị nhỏ nhất là :min',

            'quantity.required' => 'Vui lòng nhập số lượng',
            'quantity.numeric' => 'Số lượng phải là chữ số.',
            'quantity.min' => 'Giá trị nhỏ nhất là :min',

            'image.image' => 'Chỉ được chọn file ảnh.',
            'image.max' => 'Kích thước file chọn vượt quá :max KBytes',

            'images.*.image' => 'Chỉ được chọn file ảnh.',
            'images.*.max' => 'Kích thước file chọn vượt quá :max KBytes',

            'category_id.required' => 'Vui lòng cho biết sản phẩm thuộc chuyên mục nào.',
            'category_id.exists' => "Không tồn tại chuyên mục có id: ".$request->input('category_id').", vui lòng không sửa value của chuyên mục!!"
        ]);

        if ($valid->fails()) {
            // Không hợp lệ, quay lại trang create, cùng với báo lỗi
            // và thông tin ng dùng đã nhập
            return redirect()->back()->withErrors($valid)->withInput();
        } else {
            // Hợp lệ, lưu vào csdl thông qua model Product

            // Kiểm tra xem ngta có gửi hình k?
            $savePath = null;
            if($request->hasFile('image')){
                $image = $request->file('image');
                $savePath = $this->saveImage($image);
            }

            // Kiểm tra attributes trước khi thêm vào csdl, cái nào null thì xoá đi (unset)
            $attributes = null;
            if($request->has('attributes') && is_array($request->input('attributes')) && count($request->input('attributes'))>0){
                $attributes = $request->input('attributes');
                foreach($attributes as $key => $attribute){
                    if(empty($attribute['name'])){
                        unset($attributes[$key]);
                        continue;
                    }
                    if(empty($attribute['value'])){
                        unset($attributes[$key]);
                        continue;
                    }
                }
//                dd($attributes);
                // chuyển mảng thành chuỗi json lưu vào csdl
                $attributes = json_encode($attributes);
            }

            // Thêm 1 record vào csdl
            $product = Product::create([
                'name' => $request->input('name'),
                'code' => mb_strtoupper($request->input('code'), 'UTF-8'),
                'content' => $request->input('content'),
                'regular_price' => $request->input('regular_price'),
                'sale_price' => $request->input('sale_price'),
                'original_price' => $request->input('original_price'),
                'quantity' => $request->input('quantity'),
                'image' => $savePath,
                'attributes' => $attributes,
                'user_id' => auth()->id(),
                'category_id' => $request->input('category_id')
            ]);

            // Thêm thư viện ảnh
            if($request->hasFile('images')){
                foreach($request->file('images') as $imageFile){
                    Attachment::create([
                        'type' => 'image',
                        'mime' => $imageFile->getMimeType(),
                        'path' => $this->saveImage($imageFile),
                        'product_id' => $product->id,
                    ]);
                }
            }

            // Thêm Tags
            if($request->has('tags') && is_array($request->input('tags')) && count($request->input('tags'))){
                $tags = $request->input('tags');
                $tagsId = [];
                foreach($tags as $tag){
                    // Tìm trong bảng tags, nếu chưa có thì thêm record mới, có r thì thôi
                    // Rồi lấy id của tag đó cho vào mảng $tagsId
                    $tag = Tag::firstOrCreate([
                        'name' => str_slug($tag)
                    ], [
                        'name' => str_slug($tag),
                        'slug' => str_slug($tag)
                    ]);
//                    dd($tag);
                    $tagsId[] = $tag->id;
                }
                // Thêm vào bảng product_tag, id của product và tag tương ứng
                $product->tags()->sync($tagsId);
            }

            return redirect()->route('admin.product.index')->with('thongbao', "Thêm sản phẩm $product->name thành công");
        }
    }



    // Khi ng dùng nhấn edit
    public function show($id)
    {
        $product = Product::find($id);
//        dd($product->tags);
        if($product !== null){
            $data['product'] = $product;
            $data['categories'] = $this->makeCategories(Category::orderBy('name', 'ASC')->get());
            return view('admin.products.show', $data);
        }else {
            // ng dùng can thiệp, sửa id của link: trên URL hoặc trong button edit
            return redirect()->route('admin.product.index')->with('loi', "Không tồn tại sản phẩm có id: $id");
        }
    }

    public function update(Request $request, $id)
    {
        // Kiểm tra tính hợp lệ
        $valid = Validator::make($request->all(), [
            'name' => 'required',
            'code' => 'required|unique:products,code,'.$id,
            'content' => 'required',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'original_price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            'image' => 'image|max:2048',
            'image.*' => 'image|max:2048',
            // exists:(tồn tại trong bảng nào),(tìm trong cột nào)
            'category_id' => 'required|exists:categories,id'
        ], [
            'name.required' => 'Vui lòng nhập Tên sản phẩm.',

            'code.required' => 'Vui lòng nhập Mã sản phẩm.',
            'code.unique' => 'Mã sản phẩm này đã tồn tại!!!',

            'content.required' => 'Vui lòng nhập mô tả cho sản phẩm.',

            'regular_price.required' => 'Vui lòng nhập giá thị trường',
            'regular_price.numeric' => 'Giá thị trường phải là chữ số.',
            'regular_price.min' => 'Giá trị nhỏ nhất là :min',

            'sale_price.required' => 'Vui lòng nhập giá bán',
            'sale_price.numeric' => 'Giá bán phải là chữ số.',
            'sale_price.min' => 'Giá trị nhỏ nhất là :min',

            'original_price.required' => 'Vui lòng nhập giá gốc',
            'original_price.numeric' => 'Giá gốc phải là chữ số.',
            'original_price.min' => 'Giá trị nhỏ nhất là :min',

            'quantity.required' => 'Vui lòng nhập số lượng',
            'quantity.numeric' => 'Số lượng phải là chữ số.',
            'quantity.min' => 'Giá trị nhỏ nhất là :min',

            'image.image' => 'Chỉ được chọn file ảnh.',
            'image.max' => 'Kích thước file chọn vượt quá :max KBytes',

            'image.*.image' => 'Chỉ được chọn file ảnh.',
            'image.*.max' => 'Kích thước file chọn vượt quá :max KBytes',

            'category_id.required' => 'Vui lòng cho biết sản phẩm thuộc chuyên mục nào.',
            'category_id.exists' => "Không tồn tại chuyên mục có id: ".$request->input('category_id').", vui lòng không sửa value của chuyên mục!!"
        ]);

        if ($valid->fails()) {
            // Không hợp lệ, quay lại trang show, cùng với báo lỗi
            // và thông tin ng dùng đã nhập
            return redirect()->back()->withErrors($valid)->withInput();
        } else {
            // Hợp lệ, lưu vào csdl thông qua model Product
            $product = Product::find($id);
            if($product !== null){
                // Kiểm tra xem ngta có gửi hình k?
                $savePath = $product->image; // Cứ lấy cái cũ (có thể có hoặc '') gán cho nó đã
                if($request->hasFile('image')){
                    $image = $request->file('image');
                    $savePath = $this->saveImage($image);
                    $this->deleteImage($product->image);
                } // end if

                // Cập nhật mới thư viện ảnh
                if($request->hasFile('images')){
                    // Xoá hết ảnh cũ rồi mới thêm vô sau
                    foreach($product->attachments as $imageFile){
                        $this->deleteImage($imageFile->path);
                        $imageFile->delete();
                    }
                    // Thêm lại cái mới
                    foreach($request->file('images') as $imageFile){
                        Attachment::create([
                            'type' => 'image',
                            'mime' => $imageFile->getMimeType(),
                            'path' => $this->saveImage($imageFile),
                            'product_id' => $product->id,
                        ]);
                    }
                }

                // Kiểm tra attributes trước khi thêm vào csdl, cái nào null thì xoá đi (unset)
                $attributes = '';
                if($request->has('attributes') && is_array($request->input('attributes')) && count($request->input('attributes'))>0){
                    $attributes = $request->input('attributes');
                    foreach($attributes as $key => $attribute){
                        if(empty($attribute['name'])){
                            unset($attributes[$key]);
                            continue;
                        }
                        if(empty($attribute['value'])){
                            unset($attributes[$key]);
                            continue;
                        }
                    }
//                dd($attributes);
                    // chuyển mảng thành chuỗi json lưu vào csdl
                    $attributes = json_encode($attributes);
                }

                $product->name = $request->input('name');
                $product->code = mb_strtoupper($request->input('code'), 'UTF-8');
                $product->content = $request->input('content');
                $product->regular_price = $request->input('regular_price');
                $product->sale_price = $request->input('sale_price');
                $product->original_price = $request->input('original_price');
                $product->quantity = $request->input('quantity');
                $product->image = $savePath;
                $product->attributes = $attributes;
                $product->user_id = auth()->id();
                $product->category_id = $request->input('category_id');
                
                $product->save();

                // Thêm Tags
                if($request->has('tags') && is_array($request->input('tags')) && count($request->input('tags'))){
                    $tags = $request->input('tags');
                    $tagsId = [];
                    foreach($tags as $tag){
                        // Tìm trong bảng tags, nếu chưa có thì thêm record mới, có r thì thôi
                        // Rồi lấy id của tag đó cho vào mảng $tagsId
                        $tag = Tag::firstOrCreate([
                            'name' => str_slug($tag)
                        ], [
                            'name' => str_slug($tag),
                            'slug' => str_slug($tag)
                        ]);
//                    dd($tag);
                        $tagsId[] = $tag->id;
                    }
                    // Thêm vào bảng product_tag, id của product và tag tương ứng
                    $product->tags()->sync($tagsId);
                }

                return redirect()->route('admin.product.index')->with('thongbao', "Sửa sản phẩm <a href='".route('admin.product.show', ['id' => $product->id])."'>$product->name</a> thành công");
            }else{
                // khi ng dùng can thiệp, sửa id của link trong action của form PUT
                return redirect()->route('admin.product.index')->with('loi', "Không tồn tại sản phẩm có id: $id");
            }

        }
    }
    
    // khi ngta nhấn vào delete
    public function delete($id)
    {
        $product = Product::find($id);
        if ($product !== null) {
            // Xóa hình gốc và các cỡ hình khác của ảnh đại diện sản phẩm
            $this->deleteImage($product->image);
            // Xóa các hình thư viện ảnh
            if(count($product->attachments) > 0){
//                dd($product->attachments);
                foreach($product->attachments as $imageFile){
                    $this->deleteImage($imageFile->path);
                    $imageFile->delete();
                }
            }
            // Xóa sản phẩm
            $product->delete();
            return redirect()->route('admin.product.index')->with('thongbao', "Đã xoá sản phẩm $product->name");
        }else{
            // ng dùng can thiệp, sửa id của link trong action của form ẩn DELETE
            return redirect()->route('admin.product.index')->with('loi', "Không tồn tại sản phẩm có id: $id");
        }
    }

    // Phương thức lưu ảnh
    public function saveImage($image){
        if( ! empty($image) && file_exists(public_path('uploaded'))){
            $subfolder_name = date('Y-m');
            $subfolder_path = public_path('uploaded/'.$subfolder_name);
            // tên file chưa có đuôi mở rộng:
            $fileNameWithoutExt = md5($image->getClientOriginalName().time());// để tên khó trùng thôi
            // Đuôi mở rộng của file:
            $ext = $image->getClientOriginalExtension();
            // tên file có đuôi mở rộng:
            $fileName = $fileNameWithoutExt . '.' . $ext;

            if( ! file_exists($subfolder_path)){
                // Chưa có subfolder
                mkdir($subfolder_path, 0755);
            }
            // Cbị cái cần lưu vào trường image của bảng product
            $savePath = "$subfolder_name/$fileName";
            // lưu hình vô subfolder
            $image->move($subfolder_path, $fileName);

            /* Tạo các cỡ hình khác nhau */
            $createImage = function($suffix = '_thumb', $width = 250, $height = 170) use($fileNameWithoutExt, $ext, $subfolder_path, $fileName){
                $fileName_suffix = $fileNameWithoutExt . $suffix . '.' . $ext;
                Image::make("$subfolder_path/$fileName")
                    ->resize($width, $height)
                    ->save("$subfolder_path/$fileName_suffix")
                    ->destroy();

            };
            $createImage();
//            $createImage('_900x530', 900, 530);
//            $createImage('_900x300', 900, 300);
            $createImage('_450x337', 450, 337);
//            $createImage('_600x170', 600, 170);
            $createImage('_80x80', 80, 80);

            return $savePath;

//            $fileName_thumb = $fileNameWithoutExt . '_thumb.' . $ext;
//            Image::make("$subfolder_path/$fileName")
//                ->resize(150, null, function($constraint){
//                    $constraint->aspectRatio();
//                })
//                ->save("$subfolder_path/$fileName_thumb");
//            return $savePath;
        } // end if
        return null;
    }

    public function deleteImage($imagePath){
        if( ! empty($imagePath)){
            if(file_exists(public_path("uploaded/$imagePath"))){
                unlink(public_path("uploaded/$imagePath"));
            }
            $deleteOtherImages = function ($suffixArr) use($imagePath) {
                foreach($suffixArr as $suffix){
                    if(file_exists(public_path(get_thumbnail("uploaded/$imagePath", $suffix)))){
                        unlink(public_path(get_thumbnail("uploaded/$imagePath", $suffix)));
                    }
                }
            };
//            $deleteOtherImages(['_thumb', '_900x530', '_900x300', '_450x337', '_600x170', '_80x80']);
            $deleteOtherImages(['_thumb', '_450x337', '_80x80']);
        }
    }

    public function setFeaturedProduct($id){
        $product = Product::find($id);
        if ($product !== null) {
            $product->featured_product = ! $product->featured_product;
            if($product->featured_product == true){
                $thongbao = "Đã set sản phẩm $product->name là sản phẩm nổi bật";
            }else{
                $thongbao = "Đã hủy set sản phẩm $product->name là sản phẩm nổi bật";
            }
            $product->save();

            return redirect()->route('admin.product.index')->with('thongbao', $thongbao);
        }else{
            // ng dùng can thiệp, sửa id của link trong action của form ẩn PATCH
            return redirect()->route('admin.product.index')->with('loi', "Không tồn tại sản phẩm có id: $id");
        }
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
