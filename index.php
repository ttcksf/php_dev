<?php
  session_start();
  $error = [
    "select" => null,
    "name" => null,
    "email" => null,
    "contact" => null
  ];
  $select_list = [
    ""=>"選択して下さい",
    "AAA"=>"AAA",
    "BBB"=>"BBB",
    "CCC"=>"CCC",
  ];
  var_dump(($error["select"] == null) && ($error["name"] == null) && ($error["email"] == null) && ($error["contact"] == null));
  
  // ページ遷移ではなく、フォーム送信時のみに走らせるため
  if($_SERVER["REQUEST_METHOD"] === "POST"){
    if($_POST["select"] === ""){
      $error["select"] = "blank";
    }
    if($_POST["name"] === ""){
      $error["name"] = "blank";
    }
    if($_POST["email"] === ""){
      $error["email"] = "blank";
    }else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
      $error["email"] = "email";
    }
    if($_POST["contact"] === ""){
      $error["contact"] = "blank";
    }
    if(($error["select"] == null) && ($error["name"] == null) && ($error["email"] == null) && ($error["contact"] == null)){
      // エラーがないときは確認画面に移動する
      $_SESSION["form"] = $_POST;
      header("Location: confirm.php");
      exit();
    }else{
      var_dump(empty($error));
      var_dump($error);
    }
  }else{
    if(isset($_SESSION["form"])){
      $_POST = $_SESSION["form"];
    }
  }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="contact.css">
</head>
<body>
  <!-- お問合せフォーム画面 -->
  <div class="container">
        <!-- action=""とすると自分自身（index.php）に戻る -->
        <form action="" method="POST" novalidate>
            <p>お問い合わせ</p>
            <div class="row">
                <div class="col-2">
                    <label for="inputSelect">お問い合わせ内容</label>
                </div>
                <div class="col-2">
                    <p class="require_item">必須</p>
                </div>
                <div class="col-8">
                    <select name="select" id="inputSelect">
                      <?php
                          foreach($select_list as $key => $value){
                            if($key == $_POST["select"]){
                                echo "<option value='$key' selected>".$value."</option>";
                            }else{
                                echo "<option value='$key'>".$value."</option>";
                            }
                          }
                      ?>
                    </select>
                    <?php if($error["select"] === "blank"):?>
                      <p class="error_msg">※選択してください</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-2">
                        <label for="inputName">お名前</label>
                    </div>
                    <div class="col-2">
                        <p class="require_item">必須</p>
                    </div>
                    <div class="col-8">
                        <input type="text" name="name" id="inputName"
                        value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES) : "" ?>"
                        class="form-control" >
                        <?php if($error["name"] === "blank"):?>
                          <p class="error_msg">※お名前をご記入ください</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-2">
                        <label for="inputEmail">メールアドレス</label>
                    </div>
                    <div class="col-2">
                        <p class="require_item">必須</p>
                    </div>
                    <div class="col-8">
                        <input type="email" name="email" id="inputEmail" class="form-control"
                        value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES) : "" ?>">
                        <?php if($error["email"] === "blank"):?>
                          <p class="error_msg">※メールアドレスをご記入ください</p>
                        <?php endif; ?>
                        <?php if($error["email"] === "email"):?>
                          <p class="error_msg">※メールアドレスを正しくご記入ください</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-2">
                        <label for="inputContent">お問い合わせ内容</label>
                    </div>
                    <div class="col-2">
                        <p class="require_item">必須</p>
                    </div>
                    <div class="col-8">
                        <textarea name="contact" id="inputContent" rows="10" class="form-control"><?php echo isset($_POST['contact']) ? htmlspecialchars($_POST['contact'], ENT_QUOTES) : "" ?></textarea>
                        <?php if($error["contact"] === "blank"):?>
                          <p class="error_msg">※お問い合わせ内容をご記入ください</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8 offset-4">
                    <button type="submit">確認画面へ</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
