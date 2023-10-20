<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\TsFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\TsUser;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AuthController extends Authenticatable
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('user_code', 'user_password');

        $user = TsUser::where('user_code', $credentials['user_code'])->first();

        if ($user) {
            $password = $user->user_password;

            if (strcmp($credentials['user_password'], $password) == 0) {
                Auth::login($user);

                // Lấy factory_extcode và dept_name
                $data = DB::table('ts_user')
                    ->join('ts_employee', 'ts_user.employee_code', '=', 'ts_employee.employee_code')
                    ->join('ts_dept', 'ts_employee.dept_code', '=', 'ts_dept.dept_code')
                    ->join('ts_factory', 'ts_dept.company_code', '=', 'ts_factory.factory_code')
                    ->select('ts_factory.factory_extcode', 'ts_dept.dept_name')
                    ->where('ts_user.user_code', $credentials['user_code'])
                    ->get();

                if ($data->count() > 0) {
                    $message = 'Dang nhap thanh cong tai khoan: ' . $credentials['user_code'] . ', factory_extcode: ' . $data[0]->factory_extcode . ', dept_name: ' . $data[0]->dept_name;
                    return response()->json(['success' => true, 'data' => $data, 'message' => $message]);

                } else {
                    return response()->json(['success' => false, 'error' => 'Không tìm thấy dữ liệu']);
                }
            }
        }

        return response()->json(['success' => false, 'error' => 'Sai mật khẩu.']);
    }





}
