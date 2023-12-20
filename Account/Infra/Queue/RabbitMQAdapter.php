<?php

namespace Account\Infra\Queue;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Throwable;

class RabbitMQAdapter implements Queue
{
    private AMQPStreamConnection $connection;
    public function __construct()
    {
        $this->connection = new AMQPStreamConnection('rabbitmq','5672', 'guest','guest');
    }

    /**
     * @throws \Exception
     */
    public function publish(string $queueName, array $input): void
    {
        $channel = $this->connection->channel();
        $channel->queue_declare($queueName, false, true, false, false);
        $msg = new AMQPMessage(json_encode($input), [
            "delivery_mode" => AMQPMessage::DELIVERY_MODE_PERSISTENT
        ]);
        $channel->basic_publish($msg, '',$queueName);
        $channel->close();
        $this->connection->close();
    }

    public function consume(string $queueName, callable $callback): void
    {
        $channel = $this->connection->channel();
        $channel->queue_declare($queueName, false, true, false, false);
        echo " [*] Waiting for messages. To exit press CTRL+C\n";
        $channel->basic_consume($queueName, '', false, false, false, false, $callback);
        try {
            $channel->consume();
        } catch (Throwable $exception) {
            echo $exception->getMessage();
        }

    }
}