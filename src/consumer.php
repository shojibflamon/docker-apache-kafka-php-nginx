<?php

$conf = new \RdKafka\Conf();
$conf->set('log_level', (string)LOG_DEBUG);
//$conf->set('debug', 'all');
$conf->set('bootstrap.servers', 'kafka:9092');
//$conf->set('max.in.flight.requests.per.connection', (string) 1);

$consumer = new \RdKafka\Consumer($conf);
$consumer->setLogLevel(LOG_DEBUG);
$consumer->addBrokers("kafka:9092");

$topic = $consumer->newTopic("test");

$topic->consumeStart(0, RD_KAFKA_OFFSET_BEGINNING);

echo "consumer started";
while (true) {
	$msg = $topic->consume(0, 1000);
	if ($msg->payload) {
		echo $msg->payload, "\n";
	}
}
