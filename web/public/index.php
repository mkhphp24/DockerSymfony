<?php

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;
use App\Controller\SearchController;
use App\Controller\ImportController;

include __DIR__ . "/bootstrap/atuoload.php";


class Kernel extends BaseKernel
{
    use MicroKernelTrait;
    private $conf;

    public function registerBundles()
    {
        return [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle()
        ];
    }

    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
        // PHP equivalent of config/packages/framework.yaml
        $c->loadFromExtension('framework', [
            'secret' => 'S0ME_SECRET'
        ]);
        $this->conf = require __DIR__ . '/app/config_site.php';
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        // kernel is a service that points to this class
        // optional 3rd argument is the route name
        $routes->add('/', 'kernel::viewHome')->setMethods('Get');
       // $routes->add('/getdata/', 'kernel::getData')->setMethods('Get');
        $routes->add('/import/', 'kernel::import')->setMethods('Get');
        $routes->add('/getdata/', 'kernel::searchData')->setMethods('POST');


    }


    public  function import(){
        $jsfile=file_get_contents('Code Challenge (DEV_Events_full).json');
        $json=json_decode( $jsfile, true);
        $import=new importController($json);
        $import->ImpoertData();
        return new JsonResponse([
            'result' =>$json,
        ]);
    }

    /**
     * @return Response
     */
public function  viewHome(){
        return new Response(
           str_replace("{baseurl}",$this->conf['conf']['baseurl'],file_get_contents('./view/index.html'))
        );
        }

     /**
     * @return JsonResponse
     * @Method({"POST", "HEAD"})
     */
        public function searchData(Request $request ){
        $search=new SearchController();
        $data = $request->request->all();
        $result=$search->returnData($data);
       // var_dump($data);
            return new JsonResponse($result);
        }
}

$kernel = new Kernel('dev', true);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
