<?php
	
	namespace App\Http\Controllers\Admin;

	use App\Http\Controllers\Controller;
	
	use Illuminate\Http\Request;

	use Illuminate\Http\Response;

	class DemoController extends Controller
	{
		//laravel中的request
		public function request(Request $request)
		{
			//域名之后的路径
			$uri = $request->path();
			// 完整的url地址
			$url=$request->url();
			echo '获取用户的参数中name字段：'.$request->input('name').'<br>';
			echo '获取url中num数组的第二个下标的内容:'.$request->input('num.1');
			//获取所有的字段
			$arr = $request->all();
			// 把name字段去除
			$arr = $request->except('name');
			//只要name字段
			$arr = $request->only('name');

			dd($arr);
		}

		//响应
		public function response(Request $request)
		{
			// return 'Hello World';
			// // 响应一张图片============================
			// $status = 200;
			// $value = 'image/jpeg';
			// $content = file_get_contents('./images/Koala.jpg');
			// // dd($content);
			// return (new Response($content, $status))
   //                ->header('Content-Type', $value);
			// =========================================
			// 重定向
			// return redirect('/request');

			// 请求转发
			return (new \App\Http\Controllers\admin\DemoController())->request($request);
		}
	}
