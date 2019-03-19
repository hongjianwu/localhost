<?php
//define('APPLICATION_PATH', dirname(dirname(__FILE__)));
//
//if (!file_exists(APPLICATION_PATH.'/vendor/autoload.php')) {
//    echo 'framework error' . PHP_EOL;
//    die();
//}
//
//
//require_once APPLICATION_PATH . '/vendor/autoload.php';
//
//$app = new \Slim\App();
//
//$app->get('/', function ($request, $response, $args) {
//    $response->write("Welcome to Slim!");
//    return $response;
//});
//
//$app->get('/hello[/{name}]', function ($request, $response, $args) {
//    $response->write("Hello, " . $args['name']);
//    return $response;
//})->setArgument('name', 'World!');
//
//$app->run();

class Car{
    public function driveCar($type = '法拉利'){
        return "人开{$type}";
    }
}

class People
{
    private $car;

    public function __construct (Car $car)
    {
        $this->car = $car;
    }

    public function run ($type){
        return $this->car->driveCar($type);
    }
}

class Container
{
    public $building = [];

    public function bind($abstract = null, $concrete = null, $shared = false )
    {
        if(is_null($concrete)){
            $concrete = $abstract;
        }

        if(!$concrete instanceof  Closure){
            echo 1;exit;
            $concrete = $this->getCloure($abstract, $concrete);
        }
        $this->building[] = compact("concrete", "shared");
        var_dump($this->building);exit;
    }

    public function singleton($abstract, $concrete, $shared){
        $this->bind($abstract, $concrete, $shared);
    }

    public function getCloure($abstract, $concrete){
        return function ($c) use ($abstract , $concrete){
          $method = ($abstract == $concrete) ? "build" : "make";
          return $c->$method($concrete);
        };
    }

    public function make($abstract){
        var_dump($abstract);
        echo '---------------'.PHP_EOL;
        $concrete = $this->getConcrete($abstract);
        if($this->isBuildable($concrete, $abstract)){
            $object = $this->build($concrete);
        } else {
            $object = $this->make($concrete);
        }
        return $object;
    }

    public function getConcrete($abstract){

        if(!isset($this->building[$abstract])){
            return $abstract;
        }
        return $this->building[$abstract]['concrete'];
    }

    public function isBuildable($concrete, $abstract){
        return $concrete === $abstract|| $concrete instanceof Closure;
    }

    public function build($concrete){

        if($concrete instanceof  Closure){
            return $concrete($this);
        }

        $reflector = new ReflectionClass($concrete);
        if(!$reflector->isInstantiable()){
            throw new \Exception('无法实例化');
        }
        $constructor = $reflector->getConstructor();
        if(is_null($constructor)){
            return new $concrete;
        }

        $dependencies = $constructor->getParameters();
        $instance = $this->getDependencies($dependencies);
        var_dump($instance);
        return $reflector->newInstanceArgs($instance);
    }

    public function getDependencies(array $dependencies){

        $results = [];
        foreach ($dependencies as $dependency){
            $results[] = is_null($dependency->getClass())
                ? $this->resolvedNonClass($dependency)
                : $this->resolvedClass($dependency);
        }
        return $results;
    }

    public function resolvedNonClass(ReflectionParameter $parameter){

        if($parameter->isDefaultValueAvailable()){
            return $parameter->getDefaultValue();
        }
        throw new \Exception('出错');
    }

    public function resolvedClass( ReflectionParameter $parameter){
        return $this->make($parameter->getClass()->name);
    }
}

$app = new Container();
$app->bind('Car', 'App\Car');
$app->bind('People', 'App\People');
$people = $app->make('People');
echo $people->run('本田') . PHP_EOL;