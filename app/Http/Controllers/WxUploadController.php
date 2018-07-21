<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Upload;

class WxUploadController extends Controller
{
  public function upload()
  {
      echo storage_path();
//      $Upload = new Upload(new Request);
//      echo $Upload->format_res_info();
  }
}
