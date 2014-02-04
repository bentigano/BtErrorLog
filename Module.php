<?php
namespace BtErrorLog;

use Zend\Log\LoggerInterface;
use Zend\Mvc\MvcEvent;

class Module
{
	public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
	
    public function onBootstrap(MvcEvent $mvcEvent)
    {
        $eventManager = $mvcEvent->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onException'));
        $eventManager->attach(MvcEvent::EVENT_RENDER_ERROR, array($this, 'onException'));
    }

    public function onException(MvcEvent $mvcEvent)
    {
        $error = $mvcEvent->getError();

        if (!isset($error)) {
            return;
        }

		$serviceManager = $mvcEvent->getApplication()->getServiceManager();
        $config = $serviceManager->get('config');

        if (!isset($config['BtErrorLog']['logger'])) {
            return;
        }

		$loggerName = $config['BtErrorLog']['logger'];
		
		if (!$serviceManager->has($loggerName)) {
			continue;
		}

		$logger = $serviceManager->get($loggerName);

		if ($logger instanceof \Zend\Log\LoggerInterface) {
			
			$request = $mvcEvent->getRequest();
			$message = sprintf("Error triggered on %s (%s)",
                $request->getUriString(),
                $error
            );
			$logger->crit($message);
		} else {
			throw new \RuntimeException("Unknown logger - please verify the configuration");
		}
    }
}