<?php namespace Adnduweb\Ci4Admin\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class LoginFilter implements FilterInterface
{
	/**
	 * Do whatever processing this filter needs to do.
	 * By default it should not return anything during
	 * normal execution. However, when an abnormal state
	 * is found, it should return an instance of
	 * CodeIgniter\HTTP\Response. If it does, script
	 * execution will end and that Response will be
	 * sent back to the client, allowing for error pages,
	 * redirects, etc.
	 *
	 * @param \CodeIgniter\HTTP\RequestInterface $request
	 * @param array|null                         $params
	 *
	 * @return mixed
	 */
	public function before(RequestInterface $request, $params = null)
	{
		// echo 'dqsdfqsf'; exit;
		
		if (! function_exists('logged_in'))
		{
			helper('auth');
		}

		

		$current = (string)current_url(true)
			->setHost('')
			->setScheme('')
			->stripQuery('token');

		$config = config(App::class);
		if($config->forceGlobalSecureRequests)
		{
			# Remove "https:/"
			$current = substr($current, 7);
		}

		

		// if no user is logged in then send to the login form
		$authenticate = service('authentication');

		// Make sure this isn't already a login route
		if (in_array((string)$current, [route_to('login-area')]))
		{
			if ($authenticate->check())
			{
				// on regarde si on ne demande pas une connexion en tant que
				$entantque = session()->get('entantque');
				
				if( !$entantque ) {

					// On vérifie la double connexion
					if(user()->isTwoFactorActive()){

						if(user()->confirmTwoFactorAuth() == false){
					
							session()->set('wait_valid_two_factor', true);
							if (!in_array((string)$current, [route_to('two-factor-auth-2fa'), route_to('confirm-two-factor-auth-2fa'), route_to('two-factor-auth-2fa-code-recovery')]))
							{
								return redirect()->to(route_to('two-factor-auth-2fa'));
							}
						}else{
							if (in_array((string)$current, [route_to('two-factor-auth-2fa'), route_to('confirm-two-factor-auth-2fa')]))
							{
								return redirect()->to(route_to('dashboard'));
							}
						}
					}	
				}

				return redirect()->to(route_to('dashboard'));
			}
			return;
		}

		// Make sure this isn't already a login route
		if (in_array((string)$current, [route_to('forgot-password'), route_to('reset-password'), route_to('register'), route_to('activate-account')]))
		{
			return;
		}

		

		// Resend Account Activation
		if ('/' .$request->uri->getPath() == route_to('resend-activate-account'))
		{
			return;
		}

		
		if (!$authenticate->check())
		{
			$authenticate->logout();
			session()->set('redirect_url', current_url());
			session()->set('previous_page', $request->uri->getPath()); //ADN
			return redirect()->to(route_to('login-area'));
		}

		//echo 'qdfdsfqs'; exit;

		//Two_factor
		http://ci43.lan/admin8C5DfeRq6/two-factor-auth-2fa
		//confirmTwoFactorAuth()
		

		if(user()->isActivated() == false){

			$authenticate->logout();
			session()->set('info', lang('Core.deconnexion_compte_desactive'));
			session()->set('redirect_url', current_url());
            session()->set('previous_page', $request->uri->getPath());
			return redirect()->to(route_to('login-area'));

		}
		
		// On vérifie la double connexion
		if(user()->isTwoFactorActive()){

			if(user()->confirmTwoFactorAuth() == false){
				
				session()->set('wait_valid_two_factor', true);
				if (!in_array((string)$current, [route_to('two-factor-auth-2fa'), route_to('confirm-two-factor-auth-2fa'), route_to('two-factor-auth-2fa-code-recovery'), route_to('confirm-two-factor-auth-2fa-recovery')]))
				{
					return redirect()->to(route_to('two-factor-auth-2fa'));
				}
			}else{
				if (in_array((string)$current, [route_to('two-factor-auth-2fa'), route_to('confirm-two-factor-auth-2fa')]))
				{
					return redirect()->to(route_to('dashboard'));
				}
			}
		}	
	}

	//--------------------------------------------------------------------

	/**
	 * Allows After filters to inspect and modify the response
	 * object as needed. This method does not allow any way
	 * to stop execution of other after filters, short of
	 * throwing an Exception or Error.
	 *
	 * @param \CodeIgniter\HTTP\RequestInterface  $request
	 * @param \CodeIgniter\HTTP\ResponseInterface $response
	 * @param array|null                          $arguments
	 *
	 * @return void
	 */
	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{

	}

	//--------------------------------------------------------------------
}
