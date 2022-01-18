<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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
//        $data['users'] = User::all()->toArray();
//        $data['users'] = User::where('name','like','%he%')->get();
        $data['users'] = User::paginate(20);
//        dd($data);
        return view('admin.users.index', $data);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ], [
            'name.required' => 'Vui lòng nhập Họ Tên',
            'email.required' => 'Vui lòng nhập Email',
            'email.email' => 'Vui lòng nhập đúng định dạng Email',
            'email.unique' => 'Email này đã trùng, vui lòng chọn email khác',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.confirmed' => 'Xác nhận mật khẩu không đúng'

        ]);
        if ($valid->fails()) {
            // Không hợp lệ, quay lại trang create, cùng với báo lỗi
            // và thông tin ng dùng đã nhập
            return redirect()->back()->withErrors($valid)->withInput();
        } else {
            // Hợp lệ, lưu vào csdl thông qua model User
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password'))
            ]);
            return redirect()->route('admin.user.index')->with('thongbao', "Thêm người dùng $user->name thành công");
        }
    }

    // Khi ng dùng nhấn edit
    public function show($id)
    {
        $user = User::find($id);
        if($user !== null){
            $data['user'] = $user;
            return view('admin.users.show', $data);
        }else {
            // ng dùng can thiệp, sửa id của link: trên URL hoặc trong button edit
            return redirect()->route('admin.user.index')->with('loi', "Không tồn tại người dùng có id: $id");
        }
    }

    public function update(Request $request, $id)
    {
        $valid = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'confirmed',
        ], [
            'name.required' => 'Vui lòng nhập Họ Tên',
            'email.required' => 'Vui lòng nhập Email',
            'email.email' => 'Vui lòng nhập đúng định dạng Email',
            'email.unique' => 'Email bạn vừa nhập đã tồn tại, vui lòng chọn email khác',
            'password.confirmed' => 'Xác nhận mật khẩu không đúng'

        ]);
        if ($valid->fails()) {
            // Không hợp lệ, quay lại trang show, cùng với báo lỗi
            // và thông tin ng dùng đã nhập
            return redirect()->back()->withErrors($valid)->withInput();
        } else {
            // Hợp lệ, lưu vào csdl thông qua model User
            $user = User::find($id);
            if($user !== null){
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                if ($request->input('password')) {
                    $user->password = bcrypt($request->input('password'));
                }
                $user->save();
                return redirect()->route('admin.user.index')->with('thongbao', "Sửa người dùng $user->name thành công");
            }else{
                // khi ng dùng can thiệp, sửa id của link trong action của form PUT
                return redirect()->route('admin.user.index')->with('loi', "Không tồn tại người dùng có id: $id");
            }

        }
    }

    // khi ngta nhấn vào delete
    public function delete($id)
    {
        $user = User::find($id);
        if ($user !== null) {
            $user->delete();
            return redirect()->route('admin.user.index')->with('thongbao', "Đã xoá người dùng $user->name");
        }else{
            // ng dùng can thiệp, sửa id của link trong action của form ẩn DELETE
            return redirect()->route('admin.user.index')->with('loi', "Không tồn tại người dùng có id: $id");
        }
    }
}
