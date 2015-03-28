<?php
/**
 * @author Alexey Kulikov aka Clops <me@clops.at>
 */
namespace Clops\Controller;

use Clops\Domain\Grow;
use Clops\Domain\Plant;
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
        return $app['twig']->render('grow/add.html.twig', array());
    }


	/**
	 * @param Request     $request
	 * @param Application $app
	 */
	public function addAction(Request $request, Application $app)
	{
		$grow = new Grow( $app );
		$grow->setCreated('now');
		$grow->setName(   $request->get('name', 'n/a') );
		$grow->setMedium( $request->get('medium', 'hydro') );
		$grow->setStart(  $request->get('start', date('Y-m-d')) );
		$grow->addPlants( $request->get('plants', 1) );
		$grow->save();

		return $app->redirect('/grow/'.$grow->getID().'/plants/');
	}


	/**
	 * @param Request     $request
	 * @param Application $app
	 *
	 * @return mixed
	 */
	public function showAction(Request $request, Application $app, $id)
	{
		$grow = new Grow( $app, $id );
		return $app['twig']->render('grow/show.html.twig', array(
			'grow' => $grow
		));
	}


	/**
	 * @param Request     $request
	 * @param Application $app
	 *
	 * @return mixed
	 */
	public function showPlantsAction(Request $request, Application $app, $id)
	{
		$grow = new Grow( $app, $id );
		return $app['twig']->render('grow/updatePlants.html.twig', array(
			'grow' => $grow
		));
	}


	/**
	 * @param Request     $request
	 * @param Application $app
	 *
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function updatePlantsAction(Request $request, Application $app, $id)
	{
		$grow           = new Grow( $app, $id );
		$postedNames    = $request->get('name');
		$postedHeights  = $request->get('height');

		/**
		 * @var Plant $plant
		 */
		foreach($grow->getPlants() as $plant){
			if(isset($postedNames[$plant->getID()])){
				$plant->setName( $postedNames[$plant->getID()] );
			}

			if(isset($postedHeights[$plant->getID()])){
				$plant->setHeight( $postedHeights[$plant->getID()] );
			}

			$plant->update();
		}

		return $app->redirect('/grow/'.$grow->getID().'/');
	}
}
