<?php
namespace Sandstorm\Zapier\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Sandstorm.Zapier".      *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Log\SystemLoggerInterface;

class ApiController extends \TYPO3\Flow\Mvc\Controller\ActionController
{

    /**
     * @var string
     * @Flow\InjectConfiguration(path="apiKey")
     */
    protected $apiKey;

    /**
     * @Flow\Inject
     * @var SystemLoggerInterface
     */
    protected $systemLogger;

    protected $supportedMediaTypes = array('*/*');

    /**
     * @return void
     */
    public function pingAction()
    {

        $this->systemLogger->log("FOO" . $this->apiKey);
        $apiKey = $this->request->getHttpRequest()->getHeader('X-Api-Key');
        $this->systemLogger->log($apiKey);
        if ($apiKey === $this->apiKey) {
            $this->response->setStatus(204);
            $this->response->send();
        } else {
            $this->response->setStatus(403, 'Invalid Authentication');
            $this->response->send();
        }

        return false;
    }

    /**
     * @return void
     */
    public function lastPublishedNodesAction()
    {
        return json_encode([
            [
                "nodePath" => "foo"
            ]
        ]);
    }

    protected function throwStatus($statusCode, $statusMessage = null, $content = null)
    {
        if ($statusCode !== 406) {
            parent::throwStatus($statusCode, $statusMessage, $content);
        }
    }

}