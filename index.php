<?php
/**
 * Реализовать возможность входа с паролем и логином с использованием
 * сессии для изменения отправленных данных в предыдущей задаче,
 * пароль и логин генерируются автоматически при первоначальной отправке формы.
 */

// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Массив для временного хранения сообщений пользователю.
  $messages = array();

  // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Выдаем сообщение об успешном сохранении.
  if (!empty($_COOKIE['save'])) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save', '', 100000);
    setcookie('login', '', 100000);
    setcookie('password', '', 100000);
    // Выводим сообщение пользователю.
    $messages[] = 'Спасибо, результаты сохранены.';
    // Если в куках есть пароль, то выводим сообщение.
    if (!empty($_COOKIE['password'])) {
      $messages[] = sprintf('Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>
        и паролем <strong>%s</strong> для изменения данных.',
        strip_tags($_COOKIE['login']),
        strip_tags($_COOKIE['password']));
    }
  }

  // Складываем признак ошибок в массив.
  $errors = array();
  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['name1'] = !empty($_COOKIE['name_error1']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['email1'] = !empty($_COOKIE['email_error1']);
  $errors['year'] = !empty($_COOKIE['year_error']);
  $errors['sex'] = !empty($_COOKIE['sex_error']);
  $errors['limbs'] = !empty($_COOKIE['limbs_error']);
  $errors['ability'] = !empty($_COOKIE['ability_error']);
  $errors['biography'] = !empty($_COOKIE['biography_error']);
  $errors['check'] = !empty($_COOKIE['check_error']);
  // TODO: аналогично все поля.

  // Выдаем сообщения об ошибках.
  if ($errors['name']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('name_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните имя.</div>';
  }
  if ($errors['name1']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('name_error1', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">В имени не могут присутствовать цифры.</div>';
  }
  if ($errors['email']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('email_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните корректно email.</div>';
  }
  if ($errors['year']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('year_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните год рождения.</div>';
  }
  if ($errors['sex']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('sex_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните пол.</div>';
  }
  if ($errors['limbs']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('limbs_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните кол-во конечностей.</div>';
  }
  if ($errors['ability']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('ability_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните поле с суперспособностями.</div>';
  }
  if ($errors['biography']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('biography_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните корректно биографию.</div>';
  }
  if ($errors['check']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('check_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Вы должны согласиться с условиями ипользования данных.</div>';
  }
  // TODO: тут выдать сообщения об ошибках в других полях.

  // Складываем предыдущие значения полей в массив, если есть.
  // При этом санитизуем все данные для безопасного отображения в браузере.
  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : strip_tags($_COOKIE['name_value']);
  $values['email'] = empty($_COOKIE['email_value']) ? '' : strip_tags($_COOKIE['email_value']);
  $values['year'] = empty($_COOKIE['year_value']) ? '' : strip_tags($_COOKIE['year_value']);
  $values['sex'] = empty($_COOKIE['sex_value']) ? '' : strip_tags($_COOKIE['sex_value']);
  $values['limbs'] = empty($_COOKIE['limbs_value']) ? '' : strip_tags($_COOKIE['limbs_value']);
  $values['1'] = empty($_COOKIE['1_value']) ? '' : strip_tags($_COOKIE['1_value']);
  $values['2'] = empty($_COOKIE['2_value']) ? '' : strip_tags($_COOKIE['2_value']);
  $values['3'] = empty($_COOKIE['3_value']) ? '' : strip_tags($_COOKIE['3_value']);
  $values['4'] = empty($_COOKIE['4_value']) ? '' : strip_tags($_COOKIE['4_value']);
  $values['5'] = empty($_COOKIE['5_value']) ? '' : strip_tags($_COOKIE['5_value']);
  $values['biography'] = empty($_COOKIE['biography_value']) ? '' : strip_tags($_COOKIE['biography_value']);
  $values['check'] = empty($_COOKIE['check_value']) ? '' : strip_tags($_COOKIE['check_value']);

  // TODO: аналогично все поля.

  // Если нет предыдущих ошибок ввода, есть кука сессии, начали сессию и
  // ранее в сессию записан факт успешного логина.
  if (empty($errors) && !empty($_COOKIE[session_name()]) &&
      session_start() && !empty($_SESSION['login'])) {
        $user = 'u47770';
        $pass = '445614';
        $db = new PDO('mysql:host=localhost;dbname=u47770', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

        try {
          $get=$db->prepare("SELECT * FROM application WHERE id=?");
          $get->bindParam(1,$_SESSION['uid']);
          $get->execute();
          $info=$get->fetchALL();
          $values['name']=$info[0]['name'];
          $values['email']=$info[0]['email'];
          $values['year']=$info[0]['year'];
          $values['sex']=$info[0]['sex'];
          $values['limbs']=$info[0]['limbs'];
          $values['biography']=$info[0]['biography'];
        
          $get2=$db->prepare("SELECT ability FROM application_ability WHERE application_id=?");
          $get2->bindParam(1,$_SESSION['uid']);
          $get2->execute();
          $inf2=$get2->fetchALL();
          for($i=0;$i<count($inf2);$i++){
            if($inf2[$i]['ability']=='1'){
              $values['1']=1;
            }
            if($inf2[$i]['ability']=='2'){
              $values['2']=1;
            }
            if($inf2[$i]['ability']=='3'){
              $values['3']=1;
            }
            if($inf2[$i]['ability']=='4'){
              $values['4']=1;
            }
            if($inf2[$i]['ability']=='5'){
              $values['5']=1;
            }
          }
        }
        catch(PDOException $e){
          print('Error: '.$e->getMessage());
          exit();
        }
    // TODO: загрузить данные пользователя из БД
    // и заполнить переменную $values,
    // предварительно санитизовав.
    printf('Выполнен вход с логином %s, uid %d', $_SESSION['login'], $_SESSION['uid']);
  }

  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
  // Проверяем ошибки.
  if(!empty($_POST['logout'])){
    session_destroy();
    header('Location: index.php');
  }
  if(empty($_SESSION['login'])){
    $check=$_POST['check'];
  }
  $errors = FALSE;
  if (empty($_POST['name'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('name_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  
  if(preg_match('~[0-9]+~', $_POST['name'])) {
    setcookie('name_error1', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['email'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('email_error1', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['year'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('year_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('year_value', $_POST['year'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['sex'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('sex_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('sex_value', $_POST['sex'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['limbs'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('limbs_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('limbs_value', $_POST['limbs'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['ability'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('ability_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    $abil = $_POST['ability'];
    foreach($abil as $ab) {
      if($ab =='1') {setcookie('1_value', 1, time() + 12 * 30 * 24 * 60 * 60);}
      if($ab =='2') {setcookie('2_value', 1, time() + 12 * 30 * 24 * 60 * 60);}
      if($ab =='3') {setcookie('3_value', 1, time() + 12 * 30 * 24 * 60 * 60);}
      if($ab =='4') {setcookie('4_value', 1, time() + 12 * 30 * 24 * 60 * 60);}
      if($ab =='5') {setcookie('5_value', 1, time() + 12 * 30 * 24 * 60 * 60);}
    }
  }

  if (empty($_POST['biography'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('biography_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('biography_value', $_POST['biography'], time() + 30 * 24 * 60 * 60);
  }
  if(empty($_SESSION['login'])) {
    if(!isset($check)) {
      setcookie('check_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else {
      setcookie('check_value', TRUE, time() + 30 * 24 * 60 * 60);
    }
  }

// *************
// TODO: тут необходимо проверить правильность заполнения всех остальных полей.
// Сохранить в Cookie признаки ошибок и значения полей.
// *************

  if ($errors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    setcookie('save','',100000);
    header('Location: index.php');
    exit();
  }
  else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('name_error', '', 100000);
    setcookie('name_error1', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('year_error', '', 100000);
    setcookie('sex_error', '', 100000);
    setcookie('limbs_error', '', 100000);
    setcookie('ability_error', '', 100000);
    setcookie('biography_error', '', 100000);
    setcookie('check_error', '', 100000);
    // TODO: тут необходимо удалить остальные Cookies.
  }

  $user = 'u47770';
  $pass = '445614';
  $db = new PDO('mysql:host=localhost;dbname=u47770', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
  

  // Проверяем меняются ли ранее сохраненные данные или отправляются новые.
  if (!empty($_COOKIE[session_name()]) &&
      session_start() && !empty($_SESSION['login'])) {
        $id=$_SESSION['uid'];
        $upd=$db->prepare("UPDATE application SET name =:name, email =:email, year =:year, sex =:sex, limbs =:limbs, biography =:biography WHERE id =:id ");
        $cols=array(
          ':name'=>$POST['name'],
          ':email'=>$POST['email'],
          ':year'=>$POST['year'],
          ':sex'=>$POST['sex'],
          ':limbs'=>$POST['limbs'],
          ':biography'=>$POST['biography'],
        );
        foreach($cols as $k=>&$v){
          $upd->bindParam($k,$v);
        }
        $upd->bindParam(':id',$id);
        $upd->execute();
        $del=$db->prepare("DELETE FROM application_ability WHERE application_id=?");
        $del->execute(array($id));
        $upd1=$db->prepare("INSERT INTO application_ability SET ability=:ability, application_id=:id");
        $upd1->bindParam(':id',$id);
        foreach($ability as $abl){
          $upd1->bindParam(':ability',$abl);
          $upd1->execute();
        }
    // TODO: перезаписать данные в БД новыми данными,
    // кроме логина и пароля.
  }
  else {
    // Генерируем уникальный логин и пароль.
    // TODO: сделать механизм генерации, например функциями rand(), uniquid(), md5(), substr().
    $login =substr(uniqid().uniqid(),-5);
    $passw = substr(md5(uniqid().uniqid()),rand(0, 5),10);
    $passw_hash = password_hash($passw,PASSWORD_DEFAULT);
    setcookie('login', $login);
    setcookie('password', $passw);
    try {
      $stmt = $db->prepare("INSERT INTO application SET name = ?, email = ?, year = ?, sex = ?, limbs = ?, biography = ?");
      $stmt -> execute([$_POST['name'], $_POST['email'], $_POST['year'], $_POST['sex'],$_POST['limbs'], $_POST['biography']]);
      $id=$db->lastInsertId();
      $usr = $db->prepare("INSERT INTO user SET id = ?, login = ?, password = ?");
      $usr->bindParam(1,$id);
      $usr->bindParam(2,$login);
      $usr->bindParam(3,$passw_hash);
      $usr->execute();

      $application_id = $db->lastInsertId();
      $application_ability = $db->prepare("INSERT INTO application_ability SET application_id = ?, ability = ?");
      foreach($_POST["ability"] as $ability){
        $application_ability -> execute([$application_id, $ability]);
        print($ability);
      }
    }
      catch(PDOException $e){
      print('Error : ' . $e->getMessage());
      exit();
    }

    // TODO: Сохранение данных формы, логина и хеш md5() пароля в базу данных.
    // ...
  }

  // Сохраняем куку с признаком успешного сохранения.
  if(!$errors) {
    setcookie('save', '1');
  }

  // Делаем перенаправление.
  header('Location: ./');
}
