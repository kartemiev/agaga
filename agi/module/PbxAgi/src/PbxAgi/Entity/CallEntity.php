<?php
namespace PbxAgi\Entity;
use PbxAgi\Entity\CallBearerInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CallEntity implements CallEntityInterface, ServiceLocatorAwareInterface
{

    protected $serviceLocator;

    protected $peerTable;

    protected $callOwner;

    protected $callOriginator;
   
    protected $callDestinator;

    protected $exten;
    
    protected $error;

    protected $uniqueid;
    
    protected $callrecording;
    
    protected $transfered;
     
    public function getServiceLocator() {
        return $this->serviceLocator;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    public function getCallOwner() {
        return $this->callOwner;
    }

    public function setCallOwner($callOwner) {
        $this->callOwner = $callOwner;
        return $this;
    }

    public function getCallOriginator() {
        return $this->callOriginator;
    }

    public function setCallOriginator($callOriginator) {
        $this->callOriginator = $callOriginator;
        return $this;
    }

    public function getCallDestinator() {
        return $this->callDestinator;
    }

    public function setCallDestinator($callDestinator) {
        $this->callDestinator = $callDestinator;
        return $this;
    }

    public function getExten() {
        return $this->exten;
    }

    public function setExten($exten) {
        $this->exten = $exten;
        return $this;
    }

    public function getError() {
        return $this->error;
    }

    public function setError($error) {
        $this->error = $error;
        return $this;
    }

    public function getUniqueid() {
        return $this->uniqueid;
    }

    public function setUniqueid($uniqueid) {
        $this->uniqueid = $uniqueid;
        return $this;
    }

        public function __construct(CallBearerInterface $callOwner  , CallBearerInterface $callOriginator, 
            CallBearerInterface $callDestinator) {
        $this->callOwner = $callOwner;
        $this->callOriginator = $callOriginator;
        $this->callDestinator = $callDestinator;
    }

        public function getPeerTable()
    {
        if (! $this->peerTable) {
            $sm = $this->getServiceLocator();
             $peerTable = $sm->get('PeerTable');
             $this->peerTable = $peerTable;
        }
        return $this->peerTable;
    }

	public function getTransfered() {
  		return $this->transfered;
 	}
 
 	public function setTransfered($transfered) {
  		$this->transfered = $transfered;
  		return $this;
 	}
}
