<?php

/**
 * Файл login.php для не авторизованного пользователя выводит форму логина.
 * При отправке формы проверяет логин/пароль и создает сессию,
 * записывает в нее логин и id пользователя.
 * После авторизации пользователь перенаправляется на главную страницу
 * для изменения ранее введенных данных.
 **/

// Отправляем браузеру правильную кодировку,
// файл login.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// Начинаем сессию.
session_start();

// В суперглобальном массиве $_SESSION хранятся переменные сессии.
// Будем сохранять туда логин после успешной авторизации.

  // Если есть логин в сессии, то пользователь уже авторизован.
  // TODO: Сделать выход (окончание сессии вызовом session_destroy()
  //при нажатии на кнопку Выход).
  // Делаем перенаправление на форму.
  

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (!empty($_SESSION['login'])) {
    header('Location: index.php');
  }
?>

<form action="login.php" method="post">
  <input name="login" /> Логин<br>
  <input name="password" type="password" />Пароль<br>
  <input type="submit" value="Войти" />
</form>

<?php
}
// Иначе, если запрос был методом POST, т.е. нужно сделать авторизацию с записью логина в сессию.
else {

  // TODO: Проверть есть ли такой логин и пароль в базе данных.
  // Выдать сообщение об ошибках.

  $login=$_POST['login'];
  $passw=$_POST['password'];
  $uid=0;
  $error=TRUE;
  $user = 'u47770';
  $pass = '445614';
  $db1 = new PDO('mysql:host=localhost;dbname=u47770', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
  if(!empty($login) and !empty($passw)){
    try{
      $c=$db1->prepare("SELECT * FROM user WHERE login=?");
      $c->bindParam(1,$login);
      $c->execute();
      $username=$c->fetchALL();
	    print($username[0]['password']);
      echo $username;
      if(password_verify($passw,$username[0]['password'])){
        $uid=$username[0]['id'];
        $error=FALSE;
      }
    }
    catch(PDOException $e){
      print('Error : ' . $e->getMessage());
      exit();
    }
  }
  if($error==TRUE){
    print('Неправильный логин или пароль <br> Создайте новую <a href="index.php"> учетную запись</a> или <a href="login.php">заново введите данные</a> ');
    session_destroy();
    exit();
  }
  // Если все ок, то авторизуем пользователя.
  $_SESSION['login'] = $login;
  // Записываем ID пользователя.
  $_SESSION['uid'] = $uid;

  // Делаем перенаправление.
  header('Location: index.php');
}
