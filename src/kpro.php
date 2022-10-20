<?php
/*
 * Klover Cloud Cluster
 * */

$conf = new \RdKafka\Conf();
$conf->set('log_level', (string)LOG_DEBUG);
//$conf->set('debug', 'all');
$conf->set('bootstrap.servers', 'kfk-bootstrap.bd-1.wpc.waltonelectronics.com:443');
$conf->set('security_protocol', 'SASL_SSL');
//$conf->set('ssl_check_hostname', 'True');
//$conf->set('sasl_mechanism', 'OAUTHBEARER');
//$conf->set('sasl_plain_username', 'dev-arafat');
//$conf->set('sasl_plain_password', 'MuZkoY7MsXZ7XAuYnw4uBVJ2Hq9jS3KL');
//$conf->set('sasl_oauth_token_provider', 'MuZkoY7MsXZ7XAuYnw4uBVJ2Hq9jS3KL');

//		sasl_oauth_token_provider=TokenProvider(client_id, client_secret),
var_dump($conf);die();

$producer = new \RdKafka\Producer($conf);
$producer->setLogLevel(LOG_DEBUG);


if ($producer->addBrokers("kafka:9092") < 1) {
	echo "Failed adding brokers\n";
	exit;
}

$topic = $producer->newTopic("test");

if (!$producer->getMetadata(false, $topic, 2000)) {
	echo "Failed to get metadata, is broker down?\n";
	exit;
}

$arr = [
	'Bangladesh', 'India', 'Pakistan', 'United States',
];
foreach ($arr as $value){
	echo $value . PHP_EOL;
	sleep(1);
//	$topic->produce(RD_KAFKA_PARTITION_UA, 0, $_SERVER['QUERY_STRING']);
	$topic->produce(RD_KAFKA_PARTITION_UA, 0, $value);
}

echo "Message published\n";