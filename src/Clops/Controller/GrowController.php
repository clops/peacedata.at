<?php
/**
 * @author Alexey Kulikov aka Clops <me@clops.at>
 */
namespace Clops\Controller;

use Clops\Domain\Grow;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PageController
 *
 * @package Clops\Controller
 */
class GrowController
{

    /**
     * Splash Page
     *
     * @param Request     $request
     * @param Application $app
     *
     * @return mixed
     */
    public function prepareAddAction(Request $request, Application $app)
    {
        return $app['twig']->render('grow_add.html.twig', array());
    }


	/**
	 * @param Request     $request
	 * @param Application $app
	 */
	public function addAction(Request $request, Application $app)
	{
		$grow = new Grow( $app );
		$grow->setCreated('now');
		$grow->setName( $request->get('name', 'n/a') );
		$grow->setMedium( $request->get('medium', 'hydro') );
		$grow->setStart( $request->get('start', date('Y-m-d')) );
		$grow->save();

		echo 'Created Grow with ID '.$grow->getID();
		exit;
	}

}
