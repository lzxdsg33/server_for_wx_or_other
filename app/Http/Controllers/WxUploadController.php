<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Upload;
use ImageAddFont;

class WxUploadController extends Controller
{
  public function upload()
  {
      $Upload = new Upload();
      if ($Upload->is_error()) {
          echo $Upload->format_res_info();
      }

      $msg = $Upload->get_res_info();
      $ImageAddFont = new ImageAddFont($msg['file_name'], $_POST['content']);
      $ImageAddFont->save($msg['file_path']);
      echo $ImageAddFont->formate_res_info();
//      $ImageAddFont->output();
  }

    public function download(Request $request)
    {
        header('Content-type: image/jpg');
        echo file_get_contents($request->input('op'));
    }

}
