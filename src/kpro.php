<?php
//BROKER_URL = kfk-bootstrap.bd-1.wpc.waltonelectronics.com:443
//OAUTH_TOKEN_PROVIDER_URL = https://keycloak-dev.bd-1.wpc.waltonelectronics.com/auth/realms/walton/protocol/openid-connect/token
//
//CLIENT_ID = dev-arafat
//CLIENT_SECRET = MuZkoY7MsXZ7XAuYnw4uBVJ2Hq9jS3KL
//
//GRANT_TYPE = client_credentials
$conf = new SimpleKafkaClient\Configuration();

//$conf = new \RdKafka\Conf();
$conf->set('log_level', (string)LOG_DEBUG);
//$conf->set('debug', 'all');
$conf->set('bootstrap.servers', 'kfk-bootstrap.bd-1.wpc.waltonelectronics.com:443');
$conf->set('security.protocol', 'sasl_ssl');
$conf->set('sasl.mechanisms', 'OAUTHBEARER');
$conf->set('api.version.request', 'true');
$conf->set('client.id', 'dev-arafat');
$conf->set('sasl.oauthbearer.config', 'principalClaimName=azp');
//$conf->set('sasl.oauthbearer.method', 'oidc');
//$conf->set('sasl.oauthbearer.client.id', 'dev-arafat');
//$conf->set('sasl.oauthbearer.client.secret', 'MuZkoY7MsXZ7XAuYnw4uBVJ2Hq9jS3KL');
//$conf->set('sasl.oauthbearer.token.endpoint.url', 'https://keycloak-dev.bd-1.wpc.waltonelectronics.com/auth/realms/walton/protocol/openid-connect/token');
//$conf->set('sasl.username', 'dev-arafat');
//$conf->set('sasl.password', 'MuZkoY7MsXZ7XAuYnw4uBVJ2Hq9jS3KL');
//$conf->set('ssl.ca.location', __DIR__ . '/ca-cert.pem');
$conf->set('message.send.max.retries', 5);
$conf->setOAuthBearerTokenRefreshCb(function($kafka, $oAuthBearerConfig) {
    // get the refresh token with some custom code, then act accordingly
    if ($tokenRefreshWasSucessful) {
        $kafka->setOAuthBearerToken($token, $lifetimeMs, $principalName, $extensions);
    } else {
        $kafka->setOAuthBearerTokenFailure($errorReason);
    }
});

$rk = new RdKafka\Producer($conf);


//$conf->set('security.protocol', 'SASL_SSL');
//$conf->set('ssl.check.hostname', 'True');
//$conf->set('sasl.mechanisms', 'OAUTHBEARER');
//$conf->set('client.id', 'dev-arafat');
//$conf->set('ssl.certificate.verify_cb', 'https://keycloak-dev.bd-1.wpc.waltonelectronics.com/auth/realms/walton/protocol/openid-connect/certs');
//$conf->set('sasl.oauthbearer.client.secret', 'MuZkoY7MsXZ7XAuYnw4uBVJ2Hq9jS3KL');
//$conf->set('sasl.oauthbearer.method', 'oidc');
//$conf->set('sasl.oauthbearer.token.endpoint.url', 'https://keycloak-dev.bd-1.wpc.waltonelectronics.com/auth/realms/walton/protocol/openid-connect/token');
//$conf->set('sasl_oauth_token_provider', 'MuZkoY7MsXZ7XAuYnw4uBVJ2Hq9jS3KL');
//var_dump($conf);die();
//		sasl_oauth_token_provider=TokenProvider(client_id, client_secret),
//var_dump($conf);die();

$producer = new \RdKafka\Producer($conf);
$producer->setLogLevel(LOG_DEBUG);


if ($producer->addBrokers("kfk-bootstrap.bd-1.wpc.waltonelectronics.com:443") < 1) {
    echo "Failed adding brokers\n";
    exit;
}

$topic = $producer->newTopic("dev_atiq_test");

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
die();


/*
 * Klover Cloud Cluster
 * */

$conf = new \RdKafka\Conf();
$conf->set('log_level', (string)LOG_DEBUG);
//$conf->set('debug', 'all');
//$conf->set('bootstrap.servers', 'kfk-bootstrap.bd-1.wpc.waltonelectronics.com:443');
//$conf->set('security_protocol', 'SASL_SSL');
//$conf->set('ssl_check_hostname', 'True');
//$conf->set('sasl_mechanism', 'OAUTHBEARER');
//$conf->set('sasl_plain_username', 'dev-arafat');
//$conf->set('sasl_plain_password', 'MuZkoY7MsXZ7XAuYnw4uBVJ2Hq9jS3KL');
//$conf->set('sasl_oauth_token_provider', 'MuZkoY7MsXZ7XAuYnw4uBVJ2Hq9jS3KL');

// https://github.com/edenhill/librdkafka/blob/master/CONFIGURATION.md
$conf->set('bootstrap.servers', 'kfk-bootstrap.bd-1.wpc.waltonelectronics.com:443');
$conf->set('security.protocol', 'SASL_SSL');
//$conf->set('security.protocol', 'SASL_PLAINTEXT');
$conf->set('sasl.mechanism', 'OAUTHBEARER');
//$conf->set('sasl.mechanism', 'PLAIN');

$conf->set('group.id', 'dev_default');
//$conf->set('sasl.username', 'dev_jarif');
//$conf->set('sasl.password', 'wbD9GwXxR7BTvZLI3DcSD7tlTjF5iy9z');
//$conf->set('grant_type', 'OAUTH_GRANT_TYPE');

//
//"kafka.sasl.jaas.config": 'org.apache.kafka.common.security.oauthbearer.OAuthBearerLoginModule required oauth.client.id = "dev_jarif" oauth.client.secret="wbD9GwXxR7BTvZLI3DcSD7tlTjF5iy9z" oauth.jwks.endpoint.uri="https://keycloak-dev.bd-1.wpc.waltonelectronics.com/auth/realms/walton/protocol/openid-connect/certs" oauth.token.endpoint.uri="https://keycloak-dev.bd-1.wpc.waltonelectronics.com/auth/realms/walton/protocol/openid-connect/token";',
//    "kafka.sasl.mechanism": "OAUTHBEARER",
//    "kafka.security.protocol" : "SASL_SSL",
//    "kafka.bootstrap.servers": 'kfk-bootstrap.bd-1.wpc.waltonelectronics.com:443',
//    "kafka.sasl.login.callback.handler.class" :"io.strimzi.kafka.oauth.client.JaasClientOauthLoginCallbackHandler",
//    "kafka.group.id": 'dev_default',
//    "subscribe": 'dev_test'


//		sasl_oauth_token_provider=TokenProvider(client_id, client_secret),
//var_dump($conf);die();

$producer = new \RdKafka\Producer($conf);
$producer->setLogLevel(LOG_DEBUG);

if ($producer->addBrokers("kfk-bootstrap.bd-1.wpc.waltonelectronics.com:443") < 1) {
    echo "Failed adding brokers\n";
    exit;
}


$topic = $producer->newTopic("dev_test");

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