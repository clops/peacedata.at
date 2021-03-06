<?php
    /**
     * @author Alexey Kulikov aka Clops <me@clops.at>
     *
     * Supported Routes, their controllers and all error handlers
     */

    use Silex\Application\TwigTrait;
    use Silex\Application;
    use Symfony\Component\HttpFoundation\Response;

    /** @var Silex\Application $app * */
    $app->get('/', 'Clops\Controller\PageController::indexAction');
    $app->get('/index.html', 'Clops\Controller\PageController::indexAction');
    $app->get('/grow/add/', 'Clops\Controller\GrowController::prepareAddAction');
	$app->post('/grow/add/', 'Clops\Controller\GrowController::addAction');
	$app->get('/grow/{id}/', 'Clops\Controller\GrowController::showAction')->assert('id', '\d+');
	$app->get('/grow/{id}/plants/', 'Clops\Controller\GrowController::showPlantsAction')->assert('id', '\d+');
	$app->post('/grow/{id}/plants/', 'Clops\Controller\GrowController::updatePlantsAction')->assert('id', '\d+');

    ## Error Handlers ##############################################################
    #
    $app->error(function (\Exception $e, $code) use ($app) {
        switch ($code) {
            case 404:
                $message = $app['twig']->render('error404.html.twig');
                break;
            default:
                $message = 'We are sorry, but something went terribly wrong.';
        }

        if ($app['debug']) {
            $message .= ' Error Message: ' . $e->getMessage();
        }

        return new Response($message, $code);
    });

    return $app;
