<?php

namespace Two\Queue;

use Two\Queue\Job;
use Two\Bus\DispatcherInterface;


class CallQueuedHandler
{
    /**
     * The bus dispatcher implementation.
     *
     * @var \Two\Bus\DispatcherInterface
     */
    protected $dispatcher;


    /**
     * Create a new handler instance.
     *
     * @param  \Two\Bus\DispatcherInterface  $dispatcher
     * @return void
     */
    public function __construct(DispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Handle the queued job.
     *
     * @param  \Two\Queue\Job  $job
     * @param  array  $data
     * @return void
     */
    public function call(Job $job, array $data)
    {
        $command = $this->setJobInstanceIfNecessary(
            $job, unserialize($data['command'])
        );

        $this->dispatcher->dispatchNow(
            $command, $handler = $this->resolveHandler($job, $command)
        );

        if (! $job->isDeleted()) {
            $job->delete();
        }
    }

    /**
     * Resolve the handler for the given command.
     *
     * @param  \Two\Queue\Job  $job
     * @param  mixed  $command
     * @return mixed
     */
    protected function resolveHandler($job, $command)
    {
        $handler = $this->dispatcher->getCommandHandler($command) ?: null;

        if (! is_null($handler)) {
            $this->setJobInstanceIfNecessary($job, $handler);
        }

        return $handler;
    }

    /**
     * Set the job instance of the given class if necessary.
     *
     * @param  \Two\Queue\Job  $job
     * @param  mixed  $instance
     * @return mixed
     */
    protected function setJobInstanceIfNecessary(Job $job, $instance)
    {
        if (in_array('Two\Queue\InteractsWithQueueTrait', class_uses_recursive(get_class($instance)))) {
            $instance->setJob($job);
        }

        return $instance;
    }

    /**
     * Call the failed method on the job instance.
     *
     * @param  array  $data
     * @return void
     */
    public function failed(array $data)
    {
        $command = unserialize($data['command']);

        if (method_exists($command, 'failed')) {
            $command->failed($e);
        }
    }
}
