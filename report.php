<html>
<head>
<meta charset = "UTF-8">
<title>週報</title>
<link rel="stylesheet" type="text/css" href="report.css">

</head>
<body>
<?php


/*$path = "/home/acrovisionllc/pear/PEAR";
set_include_path(get_include_path() . PATH_SEPARATOR . $path);


require_once("/home/acrovisionllc/pear/PEAR/HTTP/Request2.php");*/

require_once("/HTTP/Request2.php");

// 認証設定
$subDomain = "acrovision";
$id = "goto";
$passWord = "goto0126";
 
  

$uploaddir = 'C:/Users/m.goto/Desktop/WeeklyReport/upload';
$uploadfile = $uploaddir . basename($_FILES["userfile"]["name"]);

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "File is valid, and was successfully uploaded.\n";
} else {
    echo "Possible file upload attack!\n";
}

echo 'Here is some more debugging info:';
print_r($_FILES);



    $filePath = $uploadfile;
    $fileName = mb_convert_encoding(mb_substr($filePath, mb_strrpos($filePath, DIRECTORY_SEPARATOR) + 1), "UTF-8", "auto");
    $finfo = finfo_open(FILEINFO_MIME_TYPE);  
    $mimeType = finfo_file($finfo, $filePath);  
    $file_content_type = finfo_file($finfo, $filePath);

    finfo_close($finfo);  
    $fileArray = array ("file" => "@$filePath;filename=$fileName;type=$mimeType");
    $kintoneUrl = "https://".$subDomain.".cybozu.com/k/v1/file.json";
    $authToken = base64_encode($id.":".$passWord);
    $basicAuthToken = base64_encode($id.":".$passWord);
    $file_header = array("X-Cybozu-Authorization: $authToken",
                    "Host: " . $subDomain . ".cybozu.com:443",
                  );

try {

    $file_request = new HTTP_Request2();
    $file_request->setMethod(HTTP_Request2::METHOD_POST);

    $file_request->setHeader($file_header);
    $file_request->setUrl($kintoneUrl);

    $file_request->addUpLoad("file", $filePath,$fileName,$file_content_type);

    $file_request->setConfig(array(
      'ssl_verify_host' => false,
      'ssl_verify_peer' => false
    ));


    // レスポンス取得
    //$file_response = $file_request->send();


// HTTP_Request2のエラーを表示
} catch (HTTP_Request2_Exception $e) {
    die($e->getMessage());
// それ以外のエラーを表示
} catch (Exception $e) {
    die($e->getMessage());
}
 
// エラー時
if ($file_response->getStatus() != "200") {
  echo sprintf("status: %s\n", $file_response->getStatus());
  echo sprintf("cybozu error: %s\n", $response->getHeader('x-cybozu-error'));
  echo sprintf("body: \n%s\n", $file_response->getBody());
  die;
}


$filekey = json_decode($file_response -> getBody());






// アプリID
$appId = 121;
 
// リクエストヘッダ
 $header = array(
    "Host: " . $subDomain . ".cybozu.com:443",
    "Content-Type: application/json",
    "X-Cybozu-Authorization: " . base64_encode($loginName . ':' . $password)
);

try {
    // リクエスト作成
    $request = new HTTP_Request2();
    $request->setHeader($header);
    $request->setUrl("https://" . $subDomain . ".cybozu.com/k/v1/record.json");
    $request->setMethod(HTTP_Request2::METHOD_POST);
    $request->setBody(json_encode(array("app" => $appId,
    									"record" => array(
    										"遅刻当日以後" => array(
    												"value" => $_POST["late"]
    										),
    										"欠勤当日以後" => array(
    												"value" => $_POST["absence"]
    										),
    										"早退当日以後" => array(
    												"value" => $_POST["early"]
    										),
    										"遅刻前日まで" => array(
    												"value" => $_POST["beforelate"]
    										),
    										"欠勤前日まで" => array(
    												"value" => $_POST["beforeabsence"]
    										),
    										"早退前日まで" => array(
    												"value" => $_POST["beforeearly"]
    										),
    										"周りの人から受けた注意指摘クレーム" => array(
    												"value" => $_POST["claim"]
    										),
    										"誰からなにで" => array(
    												"value" => $_POST["claimtextform"]
    										),
    										"仕事上の悩み要望" => array(
    												"value" => $_POST["worktrouble"]
    										),
    										"仕事上の悩み" => array(
    												"value" => $_POST["worktroubleform"]
    										),
    										"仕事上の要望" => array(
    												"value" => $_POST["workdemandform"]
    										),
    										"プライベートな悩み要望" => array(
    												"value" => $_POST["privatetrouble"]
    										),
    										"プライベートな悩み" => array(
    												"value" => $_POST["privatetroubleform"]
    										),
    										"プライベートな要望" => array(
    												"value" => $_POST["privatedemandform"]
    										),
    										"営業売上ＵＰに繋がるかもしれないトピック" => array(
    												"value" => $_POST["salesUp"]
    										),
    										"営業・売上ＵＰに繋がるかもしれないトピックコメント" => array(
    												"value" => $_POST["salesUpform"]
    										),
    										"現場タスク先週" => array(
    												"value" => $_POST["beforetaskform"]
    										),
    										"現場以外タスク先週" => array(
    												"value" => $_POST["beforeexpecttaskform"]
    										),
    										"現場タスク今週" => array(
    												"value" => $_POST["tasktextform"]
    										),
    										"現場以外タスク今週" => array(
    												"value" => $_POST["expecttasktextform"]
    										),
    										"現在の課題" => array(
    												"value" => $_POST["problemform"]
    										),
    										"課題の対策" => array(
    												"value" => $_POST["problemmeasure"]
    										),
    										"報告者コメント" => array(
    												"value" => $_POST["reporterform"]
    										),
                                            "添付ファイル1" => array(
                                                    "value" => array(
                                                        $filekey
                                                    )
                                            ),


    									)
    									)));
    $request->setConfig(array(
      'ssl_verify_host' => false,
      'ssl_verify_peer' => false
    ));
 
    // レスポンス取得
    $response = $request->send();

    echo "アップロードできました";
 
// HTTP_Request2のエラーを表示
} catch (HTTP_Request2_Exception $e) {
    die($e->getMessage());
// それ以外のエラーを表示
} catch (Exception $e) {
    die($e->getMessage());
}
 
// エラー時
if ($response->getStatus() != "200") {
  echo sprintf("status: %s\n", $response->getStatus());
  echo sprintf("cybozu error: %s\n", $response->getHeader('x-cybozu-error'));
  echo sprintf("body: \n%s\n", $response->getBody());
  die;
}

?>
</body>
</html>
