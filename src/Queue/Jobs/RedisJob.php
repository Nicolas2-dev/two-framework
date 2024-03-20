<?php

namespace Two\Queue\Jobs;

use Two\Container\Container;
use Two\Queue\Queues\RedisQueue;
use Two\Queue\Job;


class RedisJob extends Job
{

    /**
     * The Redis queue instance.
     *
     * @var \Two\Queue\RedisQueue
     */
    protected $redis;

    /**
     * The Redis job payload.
     *
     * @var string
     */
    protected $job;

    /**
     * Create a new job instance.
     *
     * @param  \Two\Container\Container  $container
     * @param  \Two\Queue\RedisQueue  $redis
     * @param  string  $job
     * @param  string  $queue
     * @return void
     */
    public function __construct(Container $container, RedisQueue $redis, $job, $queue)
    {
        $this->job = $job;
        $this->redis = $redis;
        $this->queue = $queue;
        $this->container = $container;
    }

    /**
     * Fire the job.
     *
     * @return void
     */
    public function handle()
    {
        $payload = json_decode($this->getRawBody(), true);

        $this->resolveAndHandle($payload);
    }

    /**
     * Get the raw body string for the job.
     *
     * @return string
     */
    public function getRawBody()
    {
        return $this->job;
    }

    /**
     * Delete the job from the queue.
     *
     * @return void
     */
    public function delete()
    {
        parent::delete();

        $this->redis->deleteReserved($this->queue, $this->job);
    }

    /**
     * Release the job back into the queue.
     *
     * @param  int   $delay
     * @return void
     */
    public function release($delay = 0)
    {
        $this->delete();

        $this->redis->release($this->queue, $this->job, $delay, $this->attempts() + 1);
    }

    /**
     * Get the number of times the job has been attempted.
     *
     * @return int
     */
    public function attempts()
    {
        return array_get(json_decode($this->job, true), 'attempts');
    }

    /**
     * Get the job identifier.
     *
     * @return string
     */
    public function getJobId()
    {
        return array_get(json_decode($this->job, true), 'id');
    }

    /**
     * Get the IoC container instance.
     *
     * @return \Two\Container\Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Get the underlying queue driver instance.
     *
     * @return \Two\Redis\Database
     */
    public function getRedisQueue()
    {
        return $this->redis;
    }

    /**
     * Get the underlying Redis job.
     *
     * @return string
     */
    public function getRedisJob()
    {
        return $this->job;
    }

}
