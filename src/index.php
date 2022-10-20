<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo phpversion().'<br>';
/*
$conf = new \RdKafka\Conf();
$conf->set('bootstrap.servers', 'kafka:9092');
$conf->set('socket.timeout.ms', (string) 50);
$conf->set('queue.buffering.max.messages', (string) 1000);
$conf->set('max.in.flight.requests.per.connection', (string) 1);
$conf->setDrMsgCb(
	function (\RdKafka\Producer $producer, \RdKafka\Message $message): void {
		if ($message->err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
			// Perform your error handling here using $message->errstr()
		}
	}
);
$conf->set('log_level', (string) LOG_DEBUG);
$conf->set('debug', 'all');
$conf->setLogCb(
	function (\RdKafka\Producer $producer, int $level, string $facility, string $message): void {
		// Perform your logging mechanism here
	}
);
$conf->set('statistics.interval.ms', (string) 1000);
$conf->setStatsCb(
	function (\RdKafka\Producer $producer, string $json, int $json_len): void {
		// Perform your stats mechanism here ...
	}
);

$topicConf = new \RdKafka\TopicConf();
$topicConf->set('message.timeout.ms', (string) 30000);
$topicConf->set('request.required.acks', (string) -1);
$topicConf->set('request.timeout.ms', (string) 5000);

$producer = new \RdKafka\Producer($conf);
$topic = $producer->newTopic('test1', $topicConf);

for ($i = 0; $i < 100; $i++) {
	$key = $i % 10;
	$payload = sprintf('payload-%d-%s', $i, $key);
	$topic->produce(RD_KAFKA_PARTITION_UA, 0, $payload, (string) $key);

	// trigger callback queues
	$producer->poll(1);
}

$producer->flush(5000);*/



$conf = new RdKafka\Conf();
$conf->set('log_level', (string)LOG_DEBUG);
$conf->set('debug', 'all');
$rk = new RdKafka\Producer($conf);

//$rk->addBrokers("10.0.0.1:9092,10.0.0.2:9092");
$rk->addBrokers("172.27.0.2:9092");
//$rk->addBrokers("172.27.0.3:9092");
$topic = $rk->newTopic("test2");
echo '<pre>'.print_r($topic,true).'</pre>';
echo '<pre>'.print_r($rk,true).'</pre>';die();

/*
 * Create Topics
 * kafka-topics.sh --create --topic myKafkaTopic --zookeeper zookeeper:2181 --replication-factor 1 --partitions 1
 * kafka-topics.sh --bootstrap-server localhost:9092 --create --topic testTopic --replication-factor 1 --partitions 3
 *
 * Listing topics
 * From Zookeeper container
 * kafka-topics.sh --list --zookeeper zookeeper:2181
 *
 * Describe Topics
 * kafka-topics.sh --bootstrap-server localhost:9092 --describe --topic myKafkaTopic (1 Partition)
 * Same as (localhost == kafka = container name)
 * kafka-topics.sh --bootstrap-server kafka:9092 --describe --topic myKafkaTopic
 * kafka-topics.sh --bootstrap-server localhost:9092 --describe --topic testTopic (3 Partition)
 *
 * From Kafka container
 * kafka-topics.sh --bootstrap-server localhost:9092 --list
 * same as
 * kafka-topics.sh --zookeeper zookeeper:2181 --list
 *
 * Producer initiate
 * kafka-console-producer.sh --bootstrap-server localhost:9092 --topic myKafkaTopic
 *
 * Consumer initiate
 * kafka-console-consumer.sh --bootstrap-server localhost:9092 --topic myKafkaTopic --from-beginning
 * kafka-console-consumer.sh --bootstrap-server localhost:9092 --topic testTopic --from-beginning
 * Same as (localhost == kafka = container name)
 * kafka-console-consumer.sh --bootstrap-server kafka:9092 --topic testTopic --from-beginning


	* kafka-console-producer.sh --bootstrap-server localhost:9092 --topic test
	* kafka-console-consumer.sh --bootstrap-server kafka:9092 --topic test --from-beginning
 * */
