<?php
namespace PbxAgi\Service\ShortDialMenu\CreateShortDialMenu;

use PAGI\Node\NodeController;
use PbxAgi\Service\ShortDialMenu\ShortDialDataContainerInterface;
use PAGI\Node\Node;
class ShortDialNumChosen
{
    protected $nodeController;
    protected $shortDialDataContainer;
    public function __construct(
        NodeController $nodeController, 
        ShortDialDataContainerInterface $shortDialDataContainer
        )
    {
        $this->nodeController = $nodeController;
        $this->shortDialDataContainer = $shortDialDataContainer;
    }
    public function __invoke(Node $node)
    {
        $shortDialNum = $node->getInput();
        $this->shortDialDataContainer
            ->setShort($shortDialNum);
        $this->nodeController->jumpTo('shortDialPromtMenu');
    }
}