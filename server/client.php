<?php

//header("Content-Type: appication/json");
header('Access-Control-Allow-Origin: *');


  


	if ( isset($_POST['client_id'])  && isset($_POST['password']) ) 
	{//==== если была выслана переменная client_id по GET запросу-====

		//======= ПОЖКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ ==========================
		$host 	  = 'localhost';     // адрес хост (host) 
		$database = 'bank_tinkoff'; // имя базы данных
		$user 	  = 'root';          // имя пользователя
		$password = 'root'; 		 // пароль

		//require_once 'name.php'; // подключаем скрипт
		 
		// подключаемся к серверу
		$link = mysqli_connect($host, $user, $password, $database); 
		 //   or die("Ошибка " . mysqli_error($link));

		//проверяем успешно ли было соединение с БД
		if (mysqli_connect_errno()) {
	    	echo "Соединение не получилось: ". mysqli_connect_error();
	    	exit();
		}

	    // Установка кодировки UTF-8
		mysqli_query($link, "SET CHARACTER SET utf8"); 
		//============================================================


		$client_id     = $_POST['client_id'];
		$sent_password = $_POST['password'];

        //---сначала мы проверяем правильность пароля ддля ---------
        //----АУТЕНТИФИКАЦИИ ---------------------------------------
	    $query  ="SELECT `password` FROM accounts WHERE `client_id`=$client_id";
		$result = mysqli_query($link, $query);
		check($link);

        $row = mysqli_fetch_assoc($result);
		$real_password = $row['password'];

		if( $sent_password == $real_password ) 
		{//======== ПОЛЬЗОВАТЕЛЬ ПРОШЕЛ АУТЕНТИФИЦКАЦИЮ =================
           
            //читаем сумму на его счете и отдаем ее ему
            $query  ="SELECT `sum` FROM accounts WHERE `client_id`=$client_id";
			$result = mysqli_query($link, $query);
			check($link);
			$row = mysqli_fetch_assoc($result);
			echo  $row['sum']; 
		} //======== ПОЛЬЗОВАТЕЛЬ ПРОШЕЛ АУТЕНТИФИЦКАЦИЮ =================
		else 
		{
			echo "ВЫ ВВЕЛИ НЕПРАВИЛЬНЫЙ ПАРОЛЬ! ВАМ ЗАКРЫТ ДОСТУП!";
		}
    }//======== если была выслана переменная client_id по GET запросу-========
    else {
    	echo "Неправильный ввод! Где необходимые POST поля?";
    }




   //=== ФУНКЦИЯ ПРОВЕРКИ УСПЕЩНО ЛИ БЫЛ ВЫПОЛНЕН SQL-ЗАПРОС =========
	function check($link) {
		//проверяем успешно ли было соединение с таблицей БД
		if (mysqli_error($link)) {
	    	echo "Обращение к таблице БД не получилось: ". mysqli_error($link);
	    	exit();
		}
	}//==================================================================

?>
