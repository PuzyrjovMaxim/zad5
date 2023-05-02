<html>
  <head>
    <style>
/* Сообщения об ошибках и поля с ошибками выводим с красным бордюром. */
.error {
  border: 2px solid red;
}
    </style>
  </head>
  <body>

<?php
if (!empty($messages)) {
  print('<div id="messages">');
  // Выводим все сообщения.
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}

// Далее выводим форму отмечая элементы с ошибками классом error
// и задавая начальные значения элементов ранее сохраненными.
?> 
<form action="" method="POST">
  <div>
  <label>fio:</label>
  <input name="name" <?php if ($errors['name']) {print 'class="error"';} ?> value="<?php print $values['name']; ?>" />
  </div>
  <div>
  <label>email:</label>
  <input name="email" type="email" <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>"/>
  </div>
  <div>
  <label>birthyear:</label>
  <select name="year" <?php if ($errors['year']) {print 'class="error"';} ?> value="<?php print $values['year']; ?>">
    <?php 
    for ($i = 1922; $i <= 2022; $i++) {
      printf('<option value="%d">%d год</option>', $i, $i);
    }
    ?>
  </select>
  </div>
  <div <?php if ($errors['sex']) {print 'class="error"';} ?>>
  <label>Пол: </label>
  <span><input type="radio" name="sex" value="1" <?php if($values['sex'] == '1') {print 'checked';} ?>/> М </span>
  <span><input type="radio" name="sex" value="2" <?php if($values['sex'] == '2') {print 'checked';} ?>/> Ж </span>
  </div>
  <p></p>
  <div <?php if ($errors['limbs']) {print 'class="error"';} ?>>
  <label>Number of limbs: </label>
  <span><input type="radio" name="limbs" value="1" <?php if($values['limbs'] == '1') {print 'checked'; } ?>/> 1 </span>
  <span><input type="radio" name="limbs" value="2" <?php if($values['limbs'] == '2') {print 'checked'; } ?>/> 2 </span>
  <span><input type="radio" name="limbs" value="3" <?php if($values['limbs'] == '3') {print 'checked';} ?>/> 3 </span>
  <span><input type="radio" name="limbs" value="4" <?php if($values['limbs'] == '4') {print 'checked'; } ?>/> 4 </span>
  <span><input type="radio" name="limbs" value="5" <?php if($values['limbs'] == '5') {print 'checked'; } ?>/> 5 </span>
  </div>
  <p></p>
  <div>
  <select name="ability[]" multiple="multiply" <?php if ($errors['ability']) {print 'class="error"';} ?>>
    <option value="1" <?php if($values['1'] == 1) {print 'selected';} ?>> нет </option>
    <option value="2" <?php if($values['2'] == 1) {print 'selected';} ?>> Телепотрация </option>
    <option value="3" <?php if($values['3'] == 1) {print 'selected';} ?>> Невидимость </option>
    <option value="4" <?php if($values['4'] == 1) {print 'selected';} ?>> Мгновенный перевод </option>
    <option value="5" <?php if($values['5'] == 1) {print 'selected';} ?>> полет </option>
  </select>
  </div>
  <p></p>
  <div>
  <label>Ваша Биография: </label>
  <textarea name="biography" <?php if ($errors['biography']) {print 'class="error"';} ?> value="<?php print $values['biography']; ?>"></textarea>
  </div>
  <input type="submit" value="ok" />
</form>
<?php
    if(empty($_SESSION['login'])){
      echo'
      <div class="login">
        <p> <a href="login.php">Если имеется аккаунт, то нажмите здесь</a></p>
      </div>';
    }
    else{
      echo '
        <div class="logout">
          <form action="index.php" method="post">
            <input name="logout" type="submit" value="Выйти">
          </form>
        </div>';
    } 
  ?>
</html>

