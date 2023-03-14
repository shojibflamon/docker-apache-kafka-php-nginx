Terminal-0
Run All container
docker-compose up -d

Terminal-1
login php application for consumer
docker exec -it php-rdkafka bash
php con.php


Terminal-2
login php application for publisher
docker exec -it php-rdkafka bash
php pub.php


Terminal-3
login kafka for consumer
docker exec -it kafka bash
kafka-console-consumer.sh --bootstrap-server kafka:9092 --topic test --from-beginning


Terminal-4
login kafka for publisher
docker exec -it kafka bash
kafka-console-producer.sh --bootstrap-server localhost:9092 --topic test



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
 *
 *
 * Delete all data from topics
 * kafka-topics.sh --zookeeper zookeeper:2181 --delete --topic pos
 *
 * */