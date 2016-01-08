<?php
namespace AppBundle\EventListener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;


/**
 * Custom login listener.
 */
class LoginListener
{

	private $securityContext;
	protected $router;
	protected $dispatcher;

	public function __construct(SecurityContext $securityContext, Router $router, EventDispatcherInterface $dispatcher)
	{
		$this->securityContext = $securityContext;
		$this->router = $router;
		$this->dispatcher = $dispatcher;
	}

	/**
	 * Do the magic.
	 *
	 * @param InteractiveLoginEvent $event
	 */
	public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
	{
		if ($this->securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $event->getAuthenticationToken ()->getUser ();

           if ($user->getPasswordChangedAt () === null) {

               $this->dispatcher->addListener ( KernelEvents::RESPONSE, array (
                       $this,
                       'onKernelResponse'
               ) );

           }
		}

		if ($this->securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
			// user has logged in using remember_me cookie
		}

	}

    public function onKernelResponse(FilterResponseEvent $event) {
        $response = new RedirectResponse ( $this->router->generate ( 'admin_user_change_password' ) );
        $event->setResponse ( $response );
    }
}
