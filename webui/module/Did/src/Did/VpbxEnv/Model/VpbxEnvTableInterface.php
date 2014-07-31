<?php
namespace Did\VpbxEnv\Model;

use Agaga\Entity\Did;

interface VpbxEnvTableInterface
{		
	public function getVpbxEnv($id); 
	public function saveVpbxEnv(VpbxEnv $vpbxenv); 		 
	public function getApiGateway();
	 
}
