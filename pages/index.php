<?php
	session_start();

	if (!ISSET($_SESSION['username'])) {
		header("Location: ../index");
		exit();
	}
	else {
		header("Location: pages/home");
		exit();
	}



