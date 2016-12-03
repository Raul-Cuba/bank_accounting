<?php

//header("Content-Type: appication/json");
header('Access-Control-Allow-Origin: *');


  


	if ( isset($_POST['client_id']) ) 
	{//---- если была выслана переменная client_id по GET запросу---

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


		$client_id = $_POST['client_id'];

	    $query  ="SELECT `sum` FROM accounts WHERE `client_id`=$client_id";
		$result = mysqli_query($link, $query);

		check($link);

		$row = mysqli_fetch_assoc($result);
		echo  $row['sum']; 
        

    }//---- если была выслана переменная client_id по GET запросу---
    else {
    	echo "Неправильный ввод!";
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
