<?php
//plik dto tworzenia polaczenia
$servername = 'localhost';//nazwa serwera
$username = 'root';//nazwa uzytkownika
$password = 'coderslab';//haslo
$baseName = 'warsztat_II';//nazwa bazy
//tworzenie nowego polaczenia
$conn= new mysqli ($servername, $username, $password, $baseName); //nowy obiekt mysqli oznacza nawizanie polaczenia

//sprawdzanie poprawnosci polaczenia
if ($conn->connect_error){//jezeli podczas ustanawiania polaczenia wystapil blad
    die("Blad przy polaczeniu do bazy danych: $conn->connect_error");//konczy dzialanie skryptu i wysiwietla napis
}
$conn->set_charset("utf8");//nastawia zestaw znakow na utf-8
echo "Polaczenie z baza danych $baseName udane <br>"; //jesli nie wystapily zadne bledy podczas ustanwianie polaczenia qyswietla napis

//operacje na bazie danych

//zamykanie polaczenia
//$conn->close();
//$conn = null;