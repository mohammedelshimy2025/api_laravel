<?php

namespace App\Traits;


trait genralTrait
{
  public function returnError($errNum , $msg){
    return response()->json([
      'status' => false,
      'errNum' => $errNum,
      'msg'    => $msg
    ]);
  }

  public function returnSuccess($msg = "" , $errNum = "5000 "){
    return[
      'status' => false,
      'errNum' => $errNum,
      'Msg'    => $msg
    ];
  }

  public function returnData($key, $value , $msg = ""){
    return response()->json([
      'status' => true,
      'errNum' => "5000",
      'msg'    => $msg,
      $key => $value
    ]);

  }

  


}
