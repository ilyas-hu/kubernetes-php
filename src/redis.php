<!DOCTYPE html>
<html>
<head>
    <title>Kubernetes Php Redis | Cloud Memory store</title>
</head>
<body>
<p>
	<?php
	//Create a redis server
	$redis = new Redis();
	//Connect to redis server, server config defined in environment variable
	$redis->connect(getenv('REDIS_HOST', '127.0.0.1'), getenv('REDIS_PORT', 6379));
	echo 'Connection to server successful <br>';
	//set the data in redis string
	$redis->set('tutorial-name', 'Kubernetes Php Redis | Cloud Memory store');
	// Get the stored data and print it
	echo 'Value Stored string in redis: ' . $redis->get('tutorial-name');
	?>
</p>
</body>
</html>