<?php
namespace PbxAgi\Service\PermissionResolver;

use PbxAgi\Service\PermissionResolver\PermissionNodeFactory as NodeFactory;

class PermissionResolver extends AbstractPermissionResolver
{
	protected $nodeFactory;
    public function __construct(NodeFactory $nodeFactory)
    {
    	$this->nodeFactory = $nodeFactory;
        $this->add($nodeFactory->create(
    			array(
    					'table'=>'ExtensionTable',
    					'method'=>'getExtensionById',
    					'parentIdFieldName'=>'extensiongroup',
    					'idFieldName'=>'id',
        		)
        	)
		);        
        $this->add($nodeFactory->create(
        		array(
        				'table'=>'PbxAgi\ExtensionGroup\Model\ExtensionGroupTable',
        				'method'=>'getExtensionGroup',
        				'parentIdFieldName'=>'vpbxid',        				
        				'idFieldName'=>'id',
        		)
        )
        );
        $this->add($nodeFactory->create(
        		array(
        				'table'=>'PbxAgi\ExtensionDefaults\Model\ExtensionDefaultsTable',
        				'method'=>'getExtensionDefaults',
        				'idFieldName'=>'vpbxid',
        				'idFieldValue'=> 1
        		)
        )
        );
    }
}