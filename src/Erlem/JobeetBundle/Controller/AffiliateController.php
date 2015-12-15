<?php
 
namespace Erlem\JobeetBundle\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Erlem\JobeetBundle\Entity\Affiliate;
use Erlem\JobeetBundle\Form\AffiliateType;
use Symfony\Component\HttpFoundation\Request;
use Erlem\JobeetBundle\Entity\Category;
 
class AffiliateController extends Controller
{
    public function newAction()
    {
        $entity = new Affiliate();
        $form = $this->createForm(new AffiliateType(), $entity);
 
        return $this->render('ErlemJobeetBundle:Affiliate:affiliate_new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    public function createAction(Request $request)
    {
        $affiliate = new Affiliate();
        $form = $this->createForm(new AffiliateType(), $affiliate);
        $form->bind($request);
        $em = $this->getDoctrine()->getManager();
 
        if ($form->isValid()) {
 
            $formData = $request->get('affiliate');
            $affiliate->setUrl($formData['url']);
            $affiliate->setEmail($formData['email']);
            $affiliate->setIsActive(false);
 
            $em->persist($affiliate);
            $em->flush();
 
            return $this->redirect($this->generateUrl('erlem_affiliate_wait'));
        }
 
        return $this->render('ErlemJobeetBundle:Affiliate:affiliate_new.html.twig', array(
            'entity' => $affiliate,
            'form'   => $form->createView(),
        ));
    }

    public function waitAction()
    {
        return $this->render('ErlemJobeetBundle:Affiliate:wait.html.twig');
    }    

}