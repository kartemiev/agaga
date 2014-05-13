<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Vpbxui\MediaRepos\Model\MediaReposTableInterface;
use Zend\View\Model\ViewModel;
use Vpbxui\MediaRepos\Form\MediaReposForm;
use Vpbxui\MediaRepos\Model\MediaRepos;
use FFMpeg\FFProbe;
class MediaReposController extends AbstractActionController
{
    protected $mediaReposTable;
    const VPBX_VPBXID = 1;
    const VPBX_MEDIAREPOSDIR = '/var/lib/asterisk/mediarepos'; /* TDB: unleash hardcoded */
    public function __construct(MediaReposTableInterface $mediaReposTable)
    {
        $this->mediaReposTable = $mediaReposTable;
    }
    public function indexAction()
    {
        $mediaRepos = $this->mediaReposTable->fetchAll();
        return  new ViewModel(array(
            'mediarepos' => $mediaRepos,
            'flashMessages' => $this->flashMessenger()->getMessages()            
        ));
    }
    public function addAction()
    {
        $sm = $this->getServiceLocator();
        $form = new MediaReposForm();
                
        $request = $this->getRequest();
        if ($request->isPost()) {
    
//            $post =  array_merge_recursive($request->getPost()->toArray(),
  //              $this->getRequest()->getFiles()->toArray()
  //              );
        $post = $request->getPost()->toArray();
         $files=$this->getRequest()->getFiles()->toArray();
         
            $mediarepos = new MediaRepos();
            $form->setInputFilter($mediarepos->getInputFilter());
            $form->setData($post);
           
            if ($form->isValid()) {
                $file = $files['custname']; 
                      
                if ((0==$file['error']))
                    {
                        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);                        
                        $mediarepos->exchangeArray($form->getData());                        
                        $mediarepos->vpbxid = self::VPBX_VPBXID;                
                        $mediarepos->contenttype = $file['type'];
                        $mediarepos->custname = $file['name'];
                        $mediarepos->filesize = $file['size'];
                        $mediarepos->extension = $extension;
                        $lastId = $this->mediaReposTable->saveMediaRepos($mediarepos);
                        $dstDir = self::VPBX_MEDIAREPOSDIR.'/'.$lastId;
                        mkdir($dstDir);
                        move_uploaded_file($file['tmp_name'], $dstDir.'/'.$lastId.'.'.$extension);
                      
                        $this->flashMessenger()->addMessage('файл '.$mediarepos->custname.' успешно добавлен');                    
                        return $this->redirect()->toRoute('vpbxui/settings/media');                    
                    }            
                 }
            }       
            $this
            ->getServiceLocator()
            ->get('viewhelpermanager')
            ->get('HeadScript')
            ->appendFile('/js/bootstrap-fileupload.min.js')
            ;
            $headLink = $this->getServiceLocator()->get('viewhelpermanager')->get('headLink');
            $headLink->appendStylesheet('/css/bootstrap-fileupload.min.css');
        return array('form' => $form,
            'flashMessages' => $this->flashMessenger()->getMessages(),
        );
    }
    
     
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('vpbxui/settings/media');
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Нет');
        
            if ($del == 'Да') {
                $id = (int) $request->getPost('id');
                $mediarepos = $this->mediaReposTable->getMediaReposById($id, self::VPBX_VPBXID);
                $this->mediaReposTable->deleteMediaRepos($id);
                unlink( self::VPBX_MEDIAREPOSDIR.'/'.$id.'/'.$id.'.'.$mediarepos->extension);
                $this->flashMessenger()->addMessage('файл '.$mediarepos->custname.' успешно удален');                
            }
        
            // Redirect to list of albums
            return $this->redirect()->toRoute('vpbxui/settings/media');
        }
        else 
        {
            $mediarepos = $this->mediaReposTable->getMediaReposById($id, self::VPBX_VPBXID);
        }
        
        return array(
            'id'    => $id,
            'mediarepos' => $mediarepos
        );
    }
}