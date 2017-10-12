<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Intervention\Image\ImageManagerStatic as Image;

// use App\Org\Image;

class UploadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.uploads.index');
    }

    public function doUploads(Request $request)
    {
        // //判断请求对象中是否有需要上传的文件
        if ($request->hasFile('mypic')) {
            //判断文件是否有效
            if ($request->file('mypic')->isValid()){
                //生成上传文件对象
                $file = $request->file('mypic');
                //获取后缀名
                $ext = $file->getClientOriginalExtension();
                // 随机生成新文件名
                $picname = time().rand(1000,9999).'.'.$ext;
                // 另存为
                $file->move('./upload', $picname);
                if($file->getError() > 0){
                    echo '上传失败';
                }else{
                    echo '上传吧成功';
                    echo "<img src='./upload/{$picname}'>";
                }
            }
        }

        // 1.使用自定义的类来进行图片的缩放
        // use App\Org\Image
        // $img = new Image();
        // $img->open('./upload/'.$picname);
        // $img->thumb('1000','500');
        // $img->save('./upload/s_'.$picname);

        // 2.使用第三方图片缩放类
        // $img = Image::make("./upload/".$picname)->resize(100,100);
        // $img->save("./upload/s_".$picname);
        
        //等比缩放
        $img = Image::make("./upload/".$picname);
        $img->resize(512, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $img->save("./upload/s_".$picname);
        
        //判断请求对象中是否有需要上传的文件
        // if ($request->hasFile('mypic')) {
        //     $data = $request->file('mypic');
        //     for ($i=0; $i < count($data); $i++) { 
        //         //获取后缀名
        //         $ext = $data[$i]->getClientOriginalExtension();
        //         // 随机生成新文件名
        //         $picname = time().rand(1000,9999).'.'.$ext;
        //         // 另存为
        //         $data[$i]->move('./upload', $picname);
        //         if($data[$i]->getError() > 0){
        //             echo '上传失败';
        //         }else{
        //             echo '上传成功';
        //             echo "<img src='./upload/{$picname}'>";
        //         }
        //     }
        // }
    }
}
