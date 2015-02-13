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


$kintoneValue =  array(
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

$message = "";
foreach ($kintoneValue as $key => $value){
    $message .= $key . "\n" . $value["value"];
}

print_r($message);


mb_language("ja");
mb_internal_encoding("UTF-8");

$subject = "kintoneからのメールです";
$message = "";
foreach ($kintoneValue as $key => $value){
    $message .= $key . "\n" . $value["value"];
}

mb_send_mail($_POST["adress"],$subject,$message);



?>
</body>
</html>
