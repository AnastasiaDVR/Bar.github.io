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

$arrayPeople = [];
$min = 1; // min of guest
$max = 10; // max of guest

$countGenre = "SELECT `id_genre` FROM `genre`"; 
$countGenre  = mysqli_query($dbLink, $countGenre);
while ($row = mysqli_fetch_assoc($countGenre)){
	$dataGenre[] = $row['id_genre'];
}

$randGuest = rand($min, $max); 

$clean = "TRUNCATE TABLE `guest`"; 
$result = mysqli_query($dbLink, $clean);

for ($i=1; $i < $randGuest+1; $i++) { 
	$randCountGenre = count($dataGenre);
	if ($randCountGenre > 0) {
		$randCountGenre = rand(1, $randCountGenre);
		$randGenre = array_rand($dataGenre, $randCountGenre);
		
		if ($randCountGenre > 1) {
			foreach ($randGenre as $key => $value) {
				$query  = "INSERT INTO `guest`(`name_guest`, `genre_guest`, `tag_guest`) VALUES ('Guest".$i."',".$dataGenre[$value].", 1)";
				$result = mysqli_query($dbLink, $query);
			}
		}else{
			$query  = "INSERT INTO `guest`(`name_guest`, `genre_guest`, `tag_guest`) VALUES ('Guest".$i."',".$dataGenre[$randGenre].", 1)";
			$result = mysqli_query($dbLink, $query);
		}
	}	
		
}

######### MAIN LOGIC #######

$query  = "SELECT DISTINCT `name_music` FROM `music`";
$resultMusic  = mysqli_query($dbLink, $query);

while ($rowMusic = mysqli_fetch_assoc($resultMusic)) {
	$arrayMusic[] = $rowMusic['name_music'];
}

$randMusic = array_rand($arrayMusic, 1);
echo "Name music: ".$arrayMusic[$randMusic];

$query  = "SELECT `name_genre` FROM `genre` INNER JOIN `music` ON `genre_music` = `id_genre` WHERE `name_music` = '".$arrayMusic[$randMusic]."'";
$resultGenre  = mysqli_query($dbLink, $query);

while ($rowGenre = mysqli_fetch_assoc($resultGenre)) {
	$arrayGenre[] = $rowGenre['name_genre'];
}

foreach ($arrayGenre as $id => $genre) {
	$query  = "SELECT * FROM `guest` INNER JOIN `genre` ON `id_genre` = `genre_guest` WHERE `name_genre` = '".$genre."'";
	$resultGuest  = mysqli_query($dbLink, $query);
	while ($row = mysqli_fetch_assoc($resultGuest)) {
		$arrayGuest[] = $row['name_guest'];
		if ($row['name_guest'] !== null) {
			$query  = "UPDATE `guest` SET `tag_guest`= 2 WHERE `name_guest` = '".$row['name_guest']."'";
			$result  = mysqli_query($dbLink, $query);
		}
	}
}

$query = "SELECT `name_guest`, `name_genre`, `id_tag`, `name_tag` FROM `guest` 
	INNER JOIN `genre` ON `id_genre` = `genre_guest` 
	INNER JOIN `tag` ON `id_tag` = `tag_guest`";
$result = mysqli_query($dbLink, $query);

while ($row = mysqli_fetch_assoc($result)) {
	if ($row['id_tag'] == 2) {
		$arrayPeople['dance'][] = $row['name_guest'];
	}else{
		$arrayPeople['bar'][] = $row['name_guest'];
	}
}

echo '<pre> In bar: </br>';
if (isset($arrayPeople['bar'])) {
	foreach (array_unique($arrayPeople['bar']) as $key => $value) {
		echo $value."</br>";
	}
}else{
	echo "Nobody in bar";
}
echo '</pre>';

echo '<pre> Dancing: </br>';
if (isset($arrayPeople['dance'])) {
	foreach (array_unique($arrayPeople['dance']) as $key => $value) {
		echo $value."</br>";
	}
}else{
	echo "Nobody dancing";
}
echo '</pre>';
