<?php
/**
* AccountController Doc Comment
*
* PHP version 5.5.9
*
* @author Sainte-Luce Marvin <marvin.sainteluce@gmail.com>
* @link   https://github.com/marvin-SL/planning
*
*/
namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use AppBundle\Form\ChangePasswordFormType;
use AppBundle\Entity\User;

/**
* AccountController
*
*/
class AccountController extends Controller
{

    /**
    * List user datas
    *
    * @param  Request $request [description]
    * @return [type]           [description]
    */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $connectedUser = $this->getUser();

        $user = $em->getRepository('AppBundle:User')->findOneBy(
            array(
            "id"=>$connectedUser->getId()
            )
        );

        return $this->render(
            'AppBundle:Admin/Account:index.html.twig', array('user'=>$user
            )
        );
    }

    /**
    * Changes user password
    *
    * @param  Request $request [description]
    * @return [type]           [description]
    */
    public function changePasswordAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $formFactory = $this->get('fos_user.change_password.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $userManager = $this->get('fos_user.user_manager');

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_profile_show');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('AppBundle:ChangePassword:changePassword.html.twig', array(
                'form' => $form->createView()
            )
        );
    }

}
