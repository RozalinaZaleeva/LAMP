<?php
session_start();
$_SESSION['name'];//имя пользователя	
$_SESSION['role'];//его роль
$connect = mysql_connect("localhost","root","") or die(mysql_error());
mysql_select_db("sqlshop");
?>
<html>
<head>
	<title>ЦВЕТОЧКИ</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

</head>
<body style="padding-top:10px;">
	<?php
		$products = array(
			'0' => array('id'=>1,'name'=> 'Роза', 'price'=>300),
			'1'=>array('id'=>2,'name'=>'Тюльпан', 'price'=>200),
			'2'=>array('id'=>3,'name'=>'Фиалка', 'price' =>200),
			'3'=>array('id'=>4,'name'=>'Пион', 'price'=>100),
			'4'=>array('id'=>5,'name'=>'Гребер','price'=>400),
			'5'=>array('id'=>6,'name'=>'Гвоздика', 'price'=>100));
		
	?>
<div class="wrapper">
    <?php
    	if($_SESSION['role']=='admin')
    		echo '<a href = "show.php">Посмотреть заказы</a>';
    ?>
	<div class="form">
	<form method="post" action="index.php">
		<label for="fio">ФИО</label>
			<input type="text" name="fio" id="fio" required /><br/>
		<label for="products">Выберите продукт</label>
			<select name="prod" id="products">
		 		<?php    
		 			foreach ($products as $value) {
	                    echo '<option value="'.$value['id'].'">'.$value['name'].' '.$value['price'].' руб.</option>';
		 			}
		 		?>
			</select><br/>
		<label for="num">Кол-во</label>
				<input type="text" name="num" id="num" required><br/>
		<label for="com">Ваш комментарий</label>
			<input type="text" name="com" id="com" required><br/>
		<button type="submit">Отправить данные</button>
	</form>
	</div>
	<a class="right" href = "signin.php">SIGN IN</a>
<?php
	if(isset($_POST['fio']))
	{
		foreach ($products as $value) {
			if($_POST['prod']==$value['id'])
			{
				$price = $value['price'];
				$pro = $value['name'];
			}
		}
		$price = $price*$_POST['num'];
		$fio = $_POST['fio'];
		$com = $_POST['com'];
		echo <<<HERE
		<p>Привет, <b>$fio</b></p>
		<p>Сумма вашей покупки товара "$pro": <b>$price</b> рублей</p>
		<p>Мы обязательно примем к сведению ваш отзыв: <b>$com</b></p>
		<p>Спасибо за покупку! Приходите ещё!</p>
HERE;
		$num = $_POST['num'];
		$query = "INSERT INTO orders VALUES ('','$fio','$pro','$num','$com')";
		$result = mysql_query($query) or die(mysql_error());
	}
?>
</div>

</body>
</html>
