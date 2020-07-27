<?php

namespace Modules\Backend\Plugins;

use Models\Context;
use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Di\Injectable;
use Phalcon\Events\Event;
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
class SecurityPlugin extends Injectable
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


        $acl->setDefaultAction(Acl\Enum::DENY);
//        $acl->setDefaultAction(Acl::ALLOW);

        $acl_roles = AclRole::find('module="backend"');
        $tmp = array();
        foreach ($acl_roles as $acl_role) {
            $tmp[$acl_role->getId()] = new Role($acl_role->getName(), $acl_role->getDescription());
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
            $acl->addComponent(new Acl\Component($resource->getController()), json_decode($resource->getActionList()));
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
            $acl->addComponent(new Acl\Component($resource->getController()), json_decode($resource->getActionList()));
        }

        foreach ($roles as $role) {
            foreach ($publicResources as $resource) {
                foreach (json_decode($resource->getActionList()) as $action) {
                    $acl->allow($role->getName(), $resource->getController(), $action);
                }
            }
        }

        foreach ($privateResources as $resource) {
            foreach (json_decode($resource->getActionList()) as $action) {
                $acl->allow($roles[$resource->getIdRole()]->getName(), $resource->getController(), $action);
            }
        }

//        $this->persistent->acl = $acl;
//        $this->session->set('acl_backend', $acl);


        return $acl;
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



        if (!$acl->isComponent($controller)) {
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