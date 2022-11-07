<?php

class APIView
{

  public function showData($data, $code = 200)
  {
    header("HTTP/1.1 " . $code . " " . $this->_requestStatus($code));
    echo json_encode($data);
  }

  public function showMessage($message, $code = 200)
  {
    header("HTTP/1.1 " . $code . " " . $this->_requestStatus($code));
    echo $message;
  }

  protected function _requestStatus($code)
  {
    $status = array(
      200 => "OK",
      201 => "Created",
      400 => "Bad request",
      401 => "Unauthorized",
      403 => "Forbidden",
      404 => "Not found",
      409 => "Conflict",
      500 => "Internal Server Error"
    );
    return (isset($status[$code])) ? $status[$code] : $status[500];
  }
}
