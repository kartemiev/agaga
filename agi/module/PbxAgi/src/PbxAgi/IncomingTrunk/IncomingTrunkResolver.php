<?php
namespace PbxAgi\IncomingTrunk;

use PbxAgi\EntityResolver\AbstractEntityResolver;
use PbxAgi\EntityResolver\EntityResolverFactory;
use PbxAgi\EntityResolver\EntityResolverFactoryInterface;
 
class IncomingTrunkResolver extends AbstractEntityResolver
{
	protected $entityResolverFactory;
	public function __construct(EntityResolverFactoryInterface $entityResolverFactory)
	{
		$this->entityResolverFactory = $entityResolverFactory;
		parent::__construct();
		$elementChain = $entityResolverFactory->create(
    		array(
		    	'type'=>'onetomanyelement',
    			'options'=>array(
    						'table'=>'PbxAgi\TrunkAssoc\Model\TrunkAssocTable',
    						'primaryfield'=>'trunkref',
    						'resultfield'=>'contextref'
    					),
    			'children'=>array(
    					'context'=>array(
    			    				'type'=>'branchelement',
    								'options'=>array(
    											'table'=>'PbxAgi\Context\Model\ContextTable',
    											'primaryfield'=>'id',
    											'branchfield' => 'contexttype',
    											'resultfields'=> array(
    																	'EXTENSION' => 'internalref',
    																	'IVR' => 'ivrref',
    																	'FUNCTION' => 'funcref'
    																	)    										
    										),
    								'children'=>array(
		    									'extension'=>array(
		    											'type'=>'onetooneelement',
 		    											'options'=>array(
 		    													'branchname' => 'EXTENSION', 		    													
		    													'table'=>'ExtensionTable',
		    													'primaryfield'=>'id',
		    											),
		    													    												
    													),
    											'ivr'=>array(
    													'type'=>'onetooneelement',
     													'options'=>array(
     															'branchname' => 'IVR',     															
    															'table'=>'PbxAgi\Ivr\Model\IvrTable',
    															'primaryfield'=>'id',
    													),   														    														
    													),
    										'feature'=>array(
    												'type'=>'onetooneelement',
    												'options'=>array(
    														'branchname' => 'FUNCTION',
    														'table'=>'PbxAgi\Feature\Model\FeatureTable',
    														'primaryfield'=>'id',
    												),
    										),
											)
    									)
    				)				
			)
			);
 		$this->setElementChain($elementChain);    
	}    
}