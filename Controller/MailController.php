<?php

namespace Mrapps\MailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/mrapps/mail")
 */
class MailController extends Controller
{
    private function getBaseData() {
        
        //Manager Type
        $managerType = strtolower(trim($this->container->getParameter("mrapps_mail.general.manager_type")));
        if(!in_array($managerType, array('orm','mongodb'))) $managerType = 'orm';
        
        $em = null;
        switch($managerType) {
            case 'mongodb':
                $em = $this->get('doctrine_mongodb')->getManager();
                break;
            default:
                $em = $this->getDoctrine()->getManager();
                break;
        }
        
        return array(
            'manager_type' => $managerType,
            'em' => $em,
        );
    }
    
    /**
     * @Route("/verify_mail")
     * @Template()
     */
    public function verifymailAction(Request $request)
    {
        $baseData = $this->getBaseData();
        $em = $baseData['em'];
        $now = new \DateTime();
        
        $body = $request->getContent();
        $sns = json_decode($body, true);
        
        $type = strtolower(trim($sns['Type']));
        
        //Parametro GET
        $typeRequest = trim($request->get('type'));
        if(strlen($typeRequest) > 0) $type = strtolower($typeRequest);
        
        //Conferma sottoscrizione
        if($type == 'subscriptionconfirmation') {
            
                $response = null;
                $ch = curl_init();
                if ($ch) {
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_URL, $sns['SubscribeURL']);
                    curl_setopt($ch, CURLOPT_HEADER, 0);

                    $response = curl_exec($ch);
                    curl_close($ch);
                }
                return new Response($response);
            
        }
        
        //Notifica
        if($type == 'notification') {
            
            $message = json_decode($sns['Message'], true);
            
            $notificationType = trim($request->get('notification_type'));
            if(strlen($notificationType) == 0) {
                $notificationType = (isset($message['notificationType'])) ? strtolower(trim($message['notificationType'])) : '';
            }
            
            if(strlen($notificationType) > 0) {
                
                //Indirizzo e-mail
                $email = trim($request->get('mail_destination'));
                if(isset($message['mail']['destination']) && is_array($message['mail']['destination'])) {
                    foreach ($message['mail']['destination'] as $addr) {
                        $email = strtolower(trim($addr));
                        break;
                    }
                }
                
                if(strlen($email) > 0) {
                    
                    switch($notificationType) {
                        case 'bounce':
                            
                            $users = $em->getRepository('ApplicationSonataUserBundle:User')->findBy(array('emailCanonical' => $email));
                            
                            foreach ($users as $user) {
                                
                                if(is_null($user->getFacebookUid())) {
                                    
                                    //Utente disabilitato e ConfirmationToken valorizzato e PasswordRequestedAt non valorizzato -> utente appena registrato
                                    if((!$user->isEnabled()) && (strlen(trim($user->getConfirmationToken())) > 0) && is_null($user->getPasswordRequestedAt())) {

                                        //Eliminazione utente
                                        $em->remove($user);

                                    }else {

                                        //Disabilito l'utente
                                        $user->setEnabled(false);
                                        $em->persist($user);
                                    }
                                    
                                }else {
                                    //Utente Facebook -> rimuovo i campi email
                                    $user->setEmail('');
                                    $user->setEmailCanonical('');
                                    $em->persist($user);
                                }
                                
                            }
                            
                            $em->flush();

                            break;
                    }
                    
                    //Log verifica
                    switch($baseData['manager_type']) {
                        case 'mongodb':
                            $log = new \Mrapps\MailBundle\Document\LogVerifica();
                            break;
                        default:
                            $log = new \Mrapps\MailBundle\Entity\LogVerifica();
                            break;
                    }
                    
                    $log->setCreatedAt($now);
                    $log->setEmail($email);
                    $log->setTipo($notificationType);
                    
                    $em->persist($log);
                    $em->flush();
                    //============================================================
                }
            }
        }
        
        return new Response(null, 204, array('Content-Length' => 0, 'Content-Type' => 'text/html'));
    }
}
