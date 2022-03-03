<?php namespace Adnduweb\Ci4Core\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use CodeIgniter\I18n\TimeDifference; 
use Adnduweb\Ci4Core\Models\OperationActivityModel;
use Adnduweb\Ci4Core\Entities\OperationActivity;

class StopConcurrentOperations implements FilterInterface
{
    public $method = ['edit', 'update'];
    /**
     * Nothing to do prior to a controller running.
     *
     * @param array|null $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
         //var_dump(setting('Consent.requireConsent')); exit;
         if(!in_array(CI_AREA_ADMIN, service('request')->getUri()->getSegments())){
            return;
        }
        if (! function_exists('logged_in')){
			helper('auth');
        }

        if(logged_in()){
            

            $class = service('router')->controllerName();
            $controller =  new $class;

            if(!method_exists($controller,'stopConcurrentOperations')){
                if(!$controller->stopConcurrentOperations ==true){
                    return;
                }
                return;
            }

            if(null !== $request->getUri()->getSegment(3)){

                if(in_array($request->getUri()->getSegment(3), $this->method)){

                    $operation_id = $request->getUri()->getSegment(4);
                    $user_id = user()->id;

                    if(user() && !empty($operation_id)){
                        $activityModel = model(OperationActivityModel::class)->where(["operation_id" => $operation_id, 'class' => $class])->first();

                        if(!empty($activityModel)){

                           $time = Time::parse($activityModel->updated_at);

                            if($activityModel->is_editing && $time->difference(Time::now())->getMinutes()<5 && $activityModel->editing_by != $user_id){
                                throw new \RuntimeException('Cette page est déjà en cours de modification', 409);
                            }else {
                                $activity = new OperationActivity();
                                $data = [
                                    'id'           => $activityModel->id,
                                    'operation_id' => $operation_id,
                                    'is_editing'   => true,
                                    'editing_by'   => $user_id,
                                    'class'        => $class,
                                    'updated_at'   => Time::now(),
                                ];
                                $activity->fill($data);
        
                                model(OperationActivityModel::class)->save($activity);
                            }
                        }else{
                            $activity = new OperationActivity();
                            $data = [
                                'operation_id' => $operation_id,
                                'is_editing'   => true,
                                'editing_by'   => $user_id,
                                'class'        => $class,
                                'updated_at'   => Time::now(),
                            ];
                            $activity->fill($data);
    
                            model(OperationActivityModel::class)->save($activity);
                        }
                    }

                }

            }
           
        }
        
       
    }

    /**
     * If enabled, insert the view and the styles/scripts
     * into the view file.
     *
     * @param array|null $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

       
    }
}
