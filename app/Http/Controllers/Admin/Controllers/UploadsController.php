<?php

namespace App\Http\Controllers\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadsController extends Controller
{

    const STATUS_FAIL = 0;
    const STATUS_SUCCESS = 1;

    protected $disk;

    public function __construct()
    {

        $this->disk = Storage::disk('public');
    }

    public function index(Request $request)
    {

        $config =config('filesystems.disks.public');

        $pathDir =  date('Ymd');
        $path = $config['root'] . $pathDir;
        if(!$request->file('editormd-image-file')){
            return $this->returnJson('Not File');
        }

        $pic = $request->file('editormd-image-file');
        if(!$pic->isValid()){
            return $this->returnJson('文件无效');
        }


        $newName=md5(time() . rand(0, 10000)).".".$pic->getClientOriginalExtension();
        if($this->disk->exists($path.'/'.$newName)){
            return $this->returnJson('文件名已存在或文件已存在');
        }

        if(!$pic->move($path,$newName)){
            return $this->returnJson('系统异常，文件保存失败');
        }

        $url = asset($config['url']. $pathDir. '/'  .$newName);

        return $this->returnJson('success', self::STATUS_SUCCESS, $url);

    }

    protected function returnJson( $message='', $success = self::STATUS_FAIL, $url = '')
    {
        return response()->json([
            'success' => $success,  //1：上传成功  0：上传失败
            'message' => $message,
            'url' => $url
        ]);
    }
}
