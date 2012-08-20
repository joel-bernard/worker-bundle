<?php

namespace Riverline\WorkerBundle\DependencyInjection;

use \Symfony\Component\DependencyInjection\ContainerBuilder;

class RiverlineWorkerExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testLoad()
    {
        $containerBuilder = new ContainerBuilder();
        $config = array(
            'riverline_worker' => array(
                'providers' => array(
                    'semaphore' => array(
                        'class'   => 'Riverline\WorkerBundle\Provider\Semaphore',
                    )
                ),
                'queues' => array(
                    'test' => array(
                        'provider' => 'semaphore',
                        'name'     => 'test'
                    )
                )
            )
        );

        $extension = new RiverlineWorkerExtension();

        $extension->load($config, $containerBuilder);

        $provider = $containerBuilder->get('riverline_worker.provider.semaphore');

        $this->assertInstanceOf('Riverline\WorkerBundle\Provider\Semaphore', $provider);

        $queue = $containerBuilder->get('riverline_worker.queue.test');

        $this->assertInstanceOf('Riverline\WorkerBundle\Queue\Queue', $queue);
    }
}