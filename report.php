<html>
<head>
<meta charset = "UTF-8">
<title>WeeklyReport</title>
<link rel="stylesheet" type="text/css" href="report.css">

</head>
<body>
<?php


$path = "/home/acrovisionllc/pear/PEAR";
set_include_path(get_include_path() . PATH_SEPARATOR . $path);


require_once("/home/acrovisionllc/pear/PEAR/HTTP/Request2.php");




//require_once("/HTTP/Request2.php");

// 認証設定
$subDomain = "acrovision";
$loginName = "goto";
$password = "goto0126";

// アプリID
$appId = 121;
 
// リクエストヘッダ
 $header = array(
    "Host: " . $subDomain . ".cybozu.com:443",
    "Content-Type: application/json",
    "X-Cybozu-Authorization: " . base64_encode($loginName . ':' . $password)
);

$kintoneValue =  array(                 
                   /* "上長選択" => array(
                            "value" => $_POST["superior"]
                    ),*/
                    "対象期間始" => array(
                            "value" => $_POST["start"]
                    ),
                    "報告対象期間終" => array(
                            "value" => $_POST["end"]
                    ),
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
                    )
                );



try {
    // リクエスト作成
    $request = new HTTP_Request2();
    $request->setHeader($header);
    $request->setUrl("https://" . $subDomain . ".cybozu.com/k/v1/record.json");
    $request->setMethod(HTTP_Request2::METHOD_POST);
    $request->setBody(json_encode(array("app" => $appId,
    									"record" => $kintoneValue)
    									));
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


mb_language("ja");
mb_internal_encoding("UTF-8");

$subject = "週報に新しい登録がありました。";
$message = "";
foreach ($kintoneValue as $key => $value){
    $message .= "--" . $key . "--\n" . $value["value"] . "\n\n";
}

mb_send_mail($_POST["adress"],$subject,$message);



?>
</body>
</html>
