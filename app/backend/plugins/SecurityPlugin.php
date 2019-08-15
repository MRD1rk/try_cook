<?php

namespace Modules\Backend\Plugins;

use Models\Context;
use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Memory as AclList;
use Models\Resource as AclResource;
use Models\Employee;
use Models\Role as AclRole;

/**
 * SecurityPlugin
 *
 * This is the security plugin which controls that users only have access to the modules they're assigned to
 */
class SecurityPlugin extends Plugin
{
    /**
     * Returns an existing or new access control list
     *
     * @returns AclList
     */
    public function getAcl()
    {
//        if ($acl = $this->session->get('acl_backend')) {
//            $this->persistent->acl = $acl;
//            return $acl;
//        }

        $acl = new AclList();

        $acl->setDefaultAction(Acl::DENY);
//        $acl->setDefaultAction(Acl::ALLOW);

        $acl_roles = AclRole::find('module="backend"');
        $tmp = array();
        foreach ($acl_roles as $acl_role) {
            $tmp[$acl_role->id] = new Role($acl_role->name, $acl_role->description);
        }
        $roles = $tmp;
        unset($tmp);

        foreach ($roles as $role) {
            $acl->addRole($role);
        }

        $privateResources = AclResource::find(
            [
                "conditions" => "type = ?1 AND module = ?2",
                "bind" => [
                    1 => "private",
                    2 => "backend",
                ]
            ]
        );

        foreach ($privateResources as $resource) {
            $acl->addResource(new Resource($resource->controller), json_decode($resource->action_list));
        }
        $publicResources = AclResource::find(
            [
                "conditions" => "type = ?1 AND module = ?2",
                "bind" => [
                    1 => "public",
                    2 => "backend",
                ]
            ]
        );

        foreach ($publicResources as $resource) {
            $acl->addResource(new Resource($resource->controller), json_decode($resource->action_list));
        }

        foreach ($roles as $role) {
            foreach ($publicResources as $resource) {
                foreach (json_decode($resource->action_list) as $action) {
                    $acl->allow($role->getName(), $resource->controller, $action);
                }
            }
        }

        foreach ($privateResources as $resource) {
            foreach (json_decode($resource->action_list) as $action) {
                $acl->allow($roles[$resource->id_role]->getName(), $resource->controller, $action);
            }
        }

        $this->persistent->acl = $acl;
//        $this->session->set('acl_backend', $acl);


        return $this->persistent->acl;
    }

    /**
     * This action is executed before execute any action in the application
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     * @return bool
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        $role = Context::getInstance()->getEmployee()->role->name;

        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();

        $acl = $this->getAcl();



        if (!$acl->isResource($controller)) {
            $dispatcher->forward([
                'controller' => 'errors',
                'action' => 'show404'
            ]);

            return false;
        }

        $allowed = $acl->isAllowed($role, $controller, $action);

        if (!$allowed) {
            $dispatcher->forward(array(
                'controller' => 'errors',
                'action' => 'show401'
            ));

//            $this->session->destroy();
            return false;
        }
    }
}