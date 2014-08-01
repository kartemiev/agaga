<?php
namespace Saas\Gizzle;


use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Http\Response;
use GuzzleHttp\Client;
use Zend\Db\ResultSet\ResultSet;
 
class ApiGateway implements ApiGatewayInterface
{
	protected $client;	
	protected $arrayObjectPrototype;
	protected $defaultHydrator;
	protected $url;
	protected $result;
	protected $idFieldName = 'id';
	protected $count = 0;
	protected $config;
	protected $auth;
 	const CONTENT_TYPE = 'application/json';
	public function __construct($options = array())
	{
  		$this->client = new Client($options);  		 
  		$this->auth = ($options['auth'])?($options['auth']):array();
	}

	public function get($id, $options = array())
	{
		$client = $this->client;
		$res = $client->get($this->getUrl().'/'.$id,array('auth'=>$this->auth,'query'=>$options));
		$this->result = $res;
		$this->checkContentType($res);
		$response = $res->json();
		$this->checkHttpResultCodes($res, array(Response::STATUS_CODE_200));		
		$data = $response['data'];		
		$object = clone $this->arrayObjectPrototype;
		$object->exchangeArray($data);
		return $object;
	}
	public function getList($options = array())
	{
 		$client = $this->client;
 		
 		$res = $client->get($this->getUrl(),array('auth'=>$this->auth,'query'=>$options));
 	 
 		 
		$this->result = $res;	
		$this->checkContentType($res);
		$response = $res->json();
		$this->checkHttpResultCodes($res, array(Response::STATUS_CODE_200));
		$total = $response['total'];		
		$data = $response['data'];
		$resultSet = new ResultSet(); 
		$resultSet->setArrayObjectPrototype($this->arrayObjectPrototype);
		$resultSet->initialize($data);
		return $resultSet;
	}
	
	public function create($data)
	{
		$client = $this->client;
		$res = $client->post($this->getUrl(), $data);
		$this->result = $res;
		$this->checkContentType($res);
		$this->checkHttpResultCodes($res, array(Response::STATUS_CODE_201, Response::STATUS_CODE_409));
		$object = null;
		if (Response::STATUS_CODE_201==$res->getStatusCode())
		{
			$response = $res->json();
			$data = $response['data'];
			$object = clone $this->arrayObjectPrototype;
			$this->defaultHydrator->hydrate($data, $object);
		}
		return $object;
	}
	public function update($data, $id, $patch = false)
	{
		$client = $this->client;					
		$methodname = ($patch)?'patch':'put';
		$json = \Zend\Json\Json::encode($data, true);
		$res = $client->$methodname($this->getUrl().'/'.$id, array('json'=>$json,'auth'=>$this->auth));				
		$this->result = $res;
		$this->checkContentType($res);
		$this->checkHttpResultCodes($res,array(Response::STATUS_CODE_200));
		$response = $res->json();
		$data = $response['data'];
		$object = clone $this->arrayObjectPrototype;
		$this->defaultHydrator->hydrate($data, $object);
		return $object;
	}
	public function delete($id)
	{
		$client = $this->client;
		$res = $client->delete($this->getUrl().'/'.$id);		
		$this->checkHttpResultCodes($res, array(Response::STATUS_CODE_204));
		return true;
	}
	public function deleteList()
	{
		$client = $this->client;	
		$res = $client->delete($this->getUrl());
		$this->checkHttpResultCodes($res, array(Response::STATUS_CODE_204));		
		return true;
	}
	
	protected function checkContentType($res)
	{
		return;
		var_dump($res->getHeader('content-type'));
		if (self::CONTENT_TYPE!==$res->getHeader('content-type'))
		{
			throw new ContentTypeMismatchException();
		}		
	}
	protected function checkHttpResultCodes($res,$codesAllowed = array())
	{
		if (!in_array($res->getStatusCode(), $codesAllowed))
		{
			throw new InvalidHttpStatusCodeReturnedException(var_dump($res));
		}		
	}
	
	public function getArrayObjectPrototype()
	{
		return $this->arrayObjectPrototype;
	}
	public function setArrayObjectPrototype($arrayObjectPrototype)
	{
		$this->arrayObjectPrototype = $arrayObjectPrototype;
	}
	public function setDefaultHydrator(HydratorInterface $defaultHydrator)
	{
		$this->defaultHydrator = $defaultHydrator;
		return $this;
	}	
	public function getDefaultHydrator()
	{
		return $this->defaultHydrator;
	}
	public function getUrl()
	{
		return $this->url;
	}
	public function setUrl($url)
	{
		$this->url = $url;
		return $this;
	}
	public function getResult()
	{
		return $this->result;
	}
	public function setIdFieldName($idFieldName)
	{
		$this->idFieldName;
		return $this;
	}
	public function getIdFieldName()
	{
		return $this->idFieldName;
	}
	public function setCount($count)
	{
		$this->count = $count;
		return $this;
	}
	public function getCount()
	{
		return $this->count;
	}
	public function getConfig()
	{
		return $this->config;
	}
	public function setConfig($config)
	{
		$this->config = $config;
	}
}