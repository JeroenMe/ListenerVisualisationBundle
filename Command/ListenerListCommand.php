<?php

namespace JeroenMe\ListenerVisualisationBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * List all listeners registered in the event dispatcher by event.
 */
class ListenerListCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('listeners:list')
            ->setDescription('List listener for service(s) command')
            ->addArgument('event', InputArgument::OPTIONAL, 'event to list listeners for.', null)
            ->setHelp(<<<EOF
The <info>%command.name%</info> command lists the registered listeners for one event or for all events:

<info>php %command.full_name%</info>

The optional argument specifies which event to list the listeners for:

<info>php %command.full_name%</info> kernel.onresponse
EOF
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $event = $input->getArgument('event');
        if($event) {
            $this->listListenersForEvent($output, $event);
        } else {
            $this->listAllListeners($output);
        }
    }

    private function listAllListeners(OutputInterface $output)
    {
        $listenersByEvent = $this->getContainer()->get('event_dispatcher')->getListeners();

        foreach($listenersByEvent as $event => $listeners) {
            $this->listListenersForEvent($output, $event, $listeners);
        }
    }

    private function listListenersForEvent(OutputInterface $output, $eventName, $listeners = null)
    {
        if($listeners === null) {
            $listeners = $this->getContainer()->get('event_dispatcher')->getListeners($eventName);
        }

        $output->writeln($eventName);

        foreach($listeners as $listener) {
            foreach ($listener as $listenerObject) {
                try {
                    if(is_object($listenerObject)) {
                        $output->writeln('      '.get_class($listenerObject));
                    } else {
                        $output->writeln('      handled by: '.$listenerObject);
                    }
                } catch(\Exception $e) {}
            }
        }
    }
}
