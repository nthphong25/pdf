<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Đăng nhập</title>
</head>

<body>
    {{-- <h2>Đăng nhập</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="user_code">User Code</label>
            <input type="text" name="user_code" id="user_code" class="form-control" required autofocus>
        </div>

        <div class="form-group">
            <label for="user_password">Password</label>
            <input type="password" name="user_password" id="user_password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Đăng nhập</button>
    </form>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}

    <?php
    // // Import model
    // use App\Models\User;

    // // Truy vấn dữ liệu
    // $tsUsers = User::all();
    //  // Lấy tất cả dữ liệu từ bảng dbo.ts_user
    // foreach ($tsUsers as $user) {
    //     echo $user->user_code;
    // }

    // // dd($p);
    ?>
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" />


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body>

        <section class="">
            <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="border-black border bg-white rounded-lg shadow-2xl dark:border md:mt-0  xl:p-0">
                    <div class="w-[415px] h-[572px] md:space-y-6 sm:p-8 rounded-[5px border-black]">
                        <div class=" flex items-end mb-8 text-2xl font-semibold text-gray-900 ml-7"
                            style="margin-top: -20px">
                            <img class="mr-2" src="{{ Vite::asset('resources/images/logo.png') }}" alt="logo">
                            <h1 style="font-size: 43px;">
                                <span class="text-teal-600" style="margin-right: -10px;">I</span>
                                <span class="text-black" style="margin-right: -10px;">-H</span>
                                <span class="text-rose-600" style="margin-right: -10px;">R</span>
                                <span class="text-lime-500">M</span>
                            </h1>
                        </div>
                        <div class="text-gray-500 font-bold text-xl" style="margin-top: -20px">
                            <p class="flex justify-center"><span>Salary Management System</span></p>
                            <p class="flex justify-center"><span>人事薪資管理系統</span></p>
                        </div>

                        <form class="space-y-3 " style="margin-top: 0px" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div>
                                <label for="account" class="text-sm font-medium text-gray-500 ml-6" id="#user-code">帳號
                                    </label>
                                <div class="flex justify-center items-center">
                                    <input id="userCode" type="text" name="user_code"
                                        class="w-[300px] h-[40px] rounded-[5px] border border-gray-500 bg-white focus:bg-white hover:bg-white focus:border-gray-500 hover:border-gray-500"
                                        required="">
                                </div>
                            </div>

                            <div>
                                <label for="password"
                                    class="block text-sm font-medium text-gray-500 dark:text-white ml-6">密碼 </label>
                                <div class="flex justify-center items-center">
                                    <input id="userPassword" type="password" name="user_password"
                                        class="w-[300px] h-[40px] rounded-[5px] border border-gray-500 bg-white focus:bg-white hover:bg-white focus:border-gray-500 hover:border-gray-500"
                                        required="">
                                </div>
                            </div>


                            <div>
                                <label for="select"
                                    class="block text-sm font-medium text-gray-600 dark:text-white ml-6">廠別</label>
                                <div class="flex justify-center items-center">
                                    <select id="selectCompany" name="selectElement"
                                        class="w-[300px] h-[40px] bg-gray-50 border border-gray-900 text-gray-900 sm:text-sm focus:ring-primary-600 focus:border-primary-600 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <!-- Tùy chọn của select -->
                                        {{-- <option value="">1</option> --}}
                                    </select>
                                </div>
                            </div>




                            <div>
                                <label for="select2"
                                    class="block text-sm font-medium text-gray-600 dark:text-white ml-6">部門</label>
                                <div class="flex justify-center items-center">
                                    <select id="selectDept"
                                        class="w-[300px] h-[40px] bg-gray-50 border border-gray-900 text-gray-900 sm:text-sm focus:ring-primary-600 focus:border-primary-600 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    </select>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-start ml-6">
                                    <div class="flex items-center h-5">
                                        <input id="remember" aria-describedby="remember" type="checkbox"
                                            class="  w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800">
                                    </div>
                                    <div class="ml-3 text-xs left-16">
                                        <label for="remember" class="text-gray-500 dark:text-gray-300">Remember
                                            me</label>
                                    </div>
                                </div>
                                <a href="#"
                                    class="text-sky-500 text-xs font-medium text-primary-600 hover:underline dark:text-primary-500 mr-6">Forgot
                                    Login Detail?</a>
                            </div>
                            <div class="flex justify-center">
                                <button type="submit" style="margin-top: -5px;"
                                    class=" w-[140px] h-[40px]  text-white bg-sky-600 bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-3 py-2 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Login
                                </button>
                            </div>

                            <p style="margin-top: 0px;"
                                class="text-center text-sm font-light text-gray-500 dark:text-gray-400">
                                Don’t have an account yet? <a href="#"
                                    class="text-sky-500 font-medium text-primary-600 hover:underline dark:text-primary-500">Sign
                                    up</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </section>


    </body>

    </html>

</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Sử dụng jQuery cho AJAX request
    $(document).ready(function() {
    $('#userPassword').on('input', function() {
        var userCode = $('#userCode').val();
        var userPassword = $('#userPassword').val();

        // Lấy CSRF token từ trang hiện tại
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'POST',
            url: '/login', // Địa chỉ URL của hàm login
            data: {
                user_code: userCode,
                user_password: userPassword,
                // Gửi CSRF token cùng với yêu cầu
                _token: csrfToken
            },
            success: function(response) {
                if (response.success) {
                    // Xóa tất cả các tùy chọn hiện có trong các ô select
                    $('#selectCompany').empty();
                    $('#selectDept').empty();

                    // Loop qua tất cả các bản ghi và thêm tùy chọn mới vào các ô select
                    for (var i = 0; i < response.data.length; i++) {
                        var companyCode = response.data[i].factory_extcode;
                        var deptName = response.data[i].dept_name;

                        // Tạo một option mới cho company_code và thêm vào select company
                        var newCompanyOption = $('<option>', {
                            value: companyCode,
                            text: companyCode
                        });

                        $('#selectCompany').append(newCompanyOption);

                        // Tạo một option mới cho dept_name và thêm vào select dept
                        var newDeptOption = $('<option>', {
                            value: deptName,
                            text: deptName
                        });

                        $('#selectDept').append(newDeptOption);
                    }

                    console.log(response.data);
                } else {
                    // Xử lý lỗi nếu cần
                    console.log(response.error);
                }
            },
            error: function(error) {
                // Xử lý lỗi nếu gặp vấn đề với yêu cầu AJAX
                console.log(error);
            }
        });
    });
});

</script>
