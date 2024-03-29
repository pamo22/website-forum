<?php 
session_start();

$conn = mysqli_connect("localhost", "low", "", "maindb");

if ($conn === false) {
	die("Cant connect to sql database. " . mysqli_connect_error());
}

if (!isset($_SESSION['userid'])) {
	header('Location: viewpost.php?code=2&postid='.$_GET['postid']);
	exit();
}

$content = htmlspecialchars($_REQUEST['content']);

if ($content == NULL) {
	header('Location: viewpost.php?code=1&postid='.$_GET['postid']);
	exit();
}
if (strlen($content) > 1024) {
	header('Location: viewpost.php?code=3&postid='.$_GET['postid']);
	exit();
}



$sqlr = $conn->prepare("INSERT INTO maindb.comments (postid, userid, content) VALUES (?, ?, ?)");
$sqlr->bind_param('sss', $_GET['postid'], $_SESSION['userid'], $_REQUEST['content']);
$sqlr->execute();

header('Location: viewpost.php?postid='.$_GET['postid']);

mysqli_close($conn);


