<?php
	//------ this is index inside includes -------
	session_start();

	if (!ISSET($_SESSION['username'])) {
		header("Location: ../index");
		exit();
	}
	else {
		header("Location: ../home");
		exit();
	}
