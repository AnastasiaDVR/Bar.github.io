<?php
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "bar";

$dbLink = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName)
    or die("Error: ".mysqli_connect_error());
mysqli_query($dbLink, "SET CHARACTER SET 'utf8'");

if(!$dbLink) {
	echo "Не удалось подключится к серверу";
}

############### BODY OF CODE ##########################

$arrayAll = [];
$array = [];
$arrayPeople = [];
$min = 1; // min of guest
$max = 10; // max of guest

//
// Вносим жанры в массив
//
$countGenre = "SELECT `id_genre` as 'count' FROM `genre`"; 
$countGenre  = mysqli_query($dbLink, $countGenre);
while ($row = mysqli_fetch_assoc($countGenre)){
	$dataGenre[] = $row['count'];
}

// echo "<pre> genre: ";
// print_r($dataGenre);
// echo "</pre>";

//
// Генерация количества гостей
//
$randGuest = rand($min, $max); 

//
// Очищаем список гостей, т.к. счётчик id начинается с 1
//
$clean = "TRUNCATE TABLE `guest`"; 
$result = mysqli_query($dbLink, $clean);

//
// Цикл создания списка гостей от 1 до рандома
//
for ($i=1; $i < $randGuest+1; $i++) { 

	//
	// Считаем сколько жанров и выбираем сколько будет жанров
	//
	$randCountGenre = count($dataGenre);
	if ($randCountGenre > 0) {
		$randCountGenre = rand(1, $randCountGenre);
		// echo "-----------randCountGenre: ".$randCountGenre;

		//
		//  выбираем случайные жанры из списка (массив, количество)
		//
		$randGenre = array_rand($dataGenre, $randCountGenre);
		// echo "<pre> randGenre: ";
		// print_r($randGenre);
		// echo "</pre>";

		//
		// Для каждого жанра в списке создаём запись гостя, имя гостя - текущий счётчик. По умол. все в баре
		//
		if ($randCountGenre > 1) {
			// Если много жанров
			foreach ($randGenre as $key => $value) {
				$query  = "INSERT INTO `guest`(`name_guest`, `genre_guest`, `tag_guest`) VALUES ('Guest".$i."',".$dataGenre[$value].", 1)";
				$result = mysqli_query($dbLink, $query);
				// echo "<pre> dataGenre[value]: ";
				// print_r($dataGenre[$value]);
				// echo "</pre>";
			}
		}else{
			// Если один жанр
			$query  = "INSERT INTO `guest`(`name_guest`, `genre_guest`, `tag_guest`) VALUES ('Guest".$i."',".$dataGenre[$randGenre].", 1)";
			$result = mysqli_query($dbLink, $query);
		}
	}	
		
}

//
// Выбираем жанры
//
// $query  = "SELECT * FROM `genre`";
// $resultGenre  = mysqli_query($dbLink, $query);
//
// Вносим данные в массив жанров
// Array
// (
//     [rock] => Array
//         (
//             [0] => Guest1
//             [1] => Guest2
//         )
//
//     [k-pop] => Array
//         (
//             [0] => Guest2
//             [1] => Guest3
//         )
// )
//
// while ($rowGenre = mysqli_fetch_assoc($resultGenre)) {
//     $query  = "SELECT `name_guest` FROM `guest`  WHERE `genre_guest` = ".$rowGenre['id_genre'];
// 	$resultGuest  = mysqli_query($dbLink, $query );

// 	while ($rowGuest = mysqli_fetch_assoc($resultGuest)) {
// 		$arrayAll[$rowGenre["name_genre"]][] = $rowGuest["name_guest"];
// 	}
// }

// echo '<pre>';
// print_r($arrayAll);
// echo '</pre>';


//
// Вносим данные в массив песен
//
// Array
// (
//     [jhgd] => Array
//         (
//             [0] => k-pop
//         )
//
//     [rkg] => Array
//         (
//             [0] => k-pop
//         )
//
//     [qwe] => Array
//         (
//             [0] => rock
//             [1] => trance
//         )
//
// )

// $query  = "SELECT * FROM `music`";
// $resultMusic  = mysqli_query($dbLink, $query);

// while ($rowMusic = mysqli_fetch_assoc($resultMusic)) {
//     $query  = "SELECT `name_genre` FROM `genre`  WHERE `id_genre` = ".$rowMusic['genre_music'];
// 	$resultGenre  = mysqli_query($dbLink, $query );

// 	while ($rowGenre = mysqli_fetch_assoc($resultGenre)) {
// 		$array[$rowMusic["name_music"]][] = $rowGenre["name_genre"];
// 	}
// }

// echo '<pre>';
// print_r($array);
// echo '</pre>';

######### MAIN LOGIC #######

//
// Вносим список песен в массив
//
$query  = "SELECT DISTINCT `name_music` FROM `music`";
$resultMusic  = mysqli_query($dbLink, $query);

while ($rowMusic = mysqli_fetch_assoc($resultMusic)) {
	$arrayMusic[] = $rowMusic['name_music'];
}

// echo '<pre>';
// print_r($arrayMusic);
// echo '</pre>';	

//
// Получаем рандомную песню
//
$randMusic = array_rand($arrayMusic, 1);
// echo $arrayMusic[$randMusic];

//
// Ищем жанры рандомной песни
//
$query  = "SELECT `name_genre` FROM `genre` INNER JOIN `music` ON `genre_music` = `id_genre` WHERE `name_music` = '".$arrayMusic[$randMusic]."'";
$resultGenre  = mysqli_query($dbLink, $query);

while ($rowGenre = mysqli_fetch_assoc($resultGenre)) {
	$arrayGenre[] = $rowGenre['name_genre'];
}
// echo '<pre>';
// print_r($arrayGenre);
// echo '</pre>';	

//
// Ищем гостей по жанрам песни. Если есть, то идут танцевать (по умол. в баре) - устанавливаем тег 2-dance
//
foreach ($arrayGenre as $id => $genre) {
	$query  = "SELECT * FROM `guest` INNER JOIN `genre` ON `id_genre` = `genre_guest` WHERE `name_genre` = '".$genre."'";
	$resultGuest  = mysqli_query($dbLink, $query);
	// echo '<pre>';
	// echo $query;
	// echo '</pre>';	

	while ($row = mysqli_fetch_assoc($resultGuest)) {
		$arrayGuest[] = $row['name_guest'];
		if ($row['name_guest'] !== null) {
			$query  = "UPDATE `guest` SET `tag_guest`= 2 WHERE `name_guest` = '".$row['name_guest']."'";
			$result  = mysqli_query($dbLink, $query);
			// echo '<pre>';
			// echo $query;
			// echo '</pre>';	
		}
	}
}

//
// Выволим гостей, их жанры и тег
//
$query = "SELECT `name_guest`, `name_genre`, `id_tag`, `name_tag` FROM `guest` 
	INNER JOIN `genre` ON `id_genre` = `genre_guest` 
	INNER JOIN `tag` ON `id_tag` = `tag_guest`";
$result = mysqli_query($dbLink, $query);

//
// Делим их в массив по тегам
//
while ($row = mysqli_fetch_assoc($result)) {
	if ($row['id_tag'] == 2) {
		$arrayPeople['dance'][] = $row['name_guest'];
	}else{
		$arrayPeople['bar'][] = $row['name_guest'];
	}
}

// echo '<pre>';
// print_r($arrayPeople);
// echo '</pre>';

//
// Выводим всех по тегам. array_unique() - Убрать повторяющиеся значения из массива
//
echo '<pre> In bar: </br>';
if (isset($arrayPeople['bar'])) {
	foreach (array_unique($arrayPeople['bar']) as $key => $value) {
		echo $value."</br>";
	}
}else{
	echo "Nothing in bar";
}
echo '</pre>';

echo '<pre> Dancing: </br>';
if (isset($arrayPeople['dance'])) {
	foreach (array_unique($arrayPeople['dance']) as $key => $value) {
		echo $value."</br>";
	}
}else{
	echo "Nothing dancing";
}
echo '</pre>';
