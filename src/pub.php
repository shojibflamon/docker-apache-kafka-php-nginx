<?php

$conf = new \RdKafka\Conf();
$conf->set('log_level', (string)LOG_DEBUG);
//$conf->set('debug', 'all');
$conf->set('bootstrap.servers', 'kafka:9092');
//$conf->set('max.in.flight.requests.per.connection', (string) 1);


$producer = new \RdKafka\Producer($conf);
$producer->setLogLevel(LOG_DEBUG);


if ($producer->addBrokers("kafka:9092") < 1) {
	echo "Failed adding brokers\n";
	exit;
}

$topic = $producer->newTopic("pos");

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