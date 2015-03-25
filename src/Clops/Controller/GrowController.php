<?php
/**
 * @author Alexey Kulikov aka Clops <me@clops.at>
 */
namespace Clops\Controller;

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

	public function addAction(Request $request, Application $app)
	{
		print_r($_POST);
		echo 111;exit;
	}

}
