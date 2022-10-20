<?php
//echo phpinfo();
//die();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$conf = new RdKafka\Conf();

// Set the group id. This is required when storing offsets on the broker
$conf->set('group.id', 'myConsumerGroup');

$rk = new RdKafka\Consumer($conf);
$rk->addBrokers("localhost:9292");

$topicConf = new RdKafka\TopicConf();
$topicConf->set('auto.commit.interval.ms', 100);

// Set where to start consuming messages when there is no initial offset in
// offset store or the desired offset is out of range.
// 'smallest': start from the beginning
$topicConf->set('auto.offset.reset', 'smallest');

$topic = $rk->newTopic("myKafkaTopic", $topicConf);

// Start consuming partition 0
$topic->consumeStart(0, RD_KAFKA_OFFSET_STORED);

while (true) {
	$message = $topic->consume(0, 120*10000);
	switch ($message->err) {
		case RD_KAFKA_RESP_ERR_NO_ERROR:
			var_dump($message);
			break;
		case RD_KAFKA_RESP_ERR__PARTITION_EOF:
			echo "No more messages; will wait for more\n";
			break;
		case RD_KAFKA_RESP_ERR__TIMED_OUT:
			echo "Timed out\n";
			break;
		default:
			throw new \Exception($message->errstr(), $message->err);
			break;
	}
}
?>