<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class AdminController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for admin
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Admin', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $admin = Admin::find($parameters);
        if (count($admin) == 0) {
            $this->flash->notice("The search did not find any admin");

            $this->dispatcher->forward([
                "controller" => "admin",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $admin,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a admin
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $admin = Admin::findFirstByid($id);
            if (!$admin) {
                $this->flash->error("admin was not found");

                $this->dispatcher->forward([
                    'controller' => "admin",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $admin->id;

            $this->tag->setDefault("id", $admin->id);
            $this->tag->setDefault("username", $admin->username);
            $this->tag->setDefault("password", $admin->password);
            $this->tag->setDefault("salt", $admin->salt);
            $this->tag->setDefault("realname", $admin->realname);
            $this->tag->setDefault("phone_number", $admin->phone_number);
            $this->tag->setDefault("intro", $admin->intro);
            $this->tag->setDefault("status", $admin->status);
            $this->tag->setDefault("creater", $admin->creater);
            $this->tag->setDefault("create_ip", $admin->create_ip);
            $this->tag->setDefault("create_time", $admin->create_time);
            $this->tag->setDefault("updater", $admin->updater);
            $this->tag->setDefault("update_time", $admin->update_time);
            $this->tag->setDefault("role_id", $admin->role_id);
            $this->tag->setDefault("grade", $admin->grade);
            $this->tag->setDefault("email", $admin->email);
            
        }
    }

    /**
     * Creates a new admin
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "admin",
                'action' => 'index'
            ]);

            return;
        }

        $admin = new Admin();
        $admin->username = $this->request->getPost("username");
        $admin->password = $this->request->getPost("password");
        $admin->salt = $this->request->getPost("salt");
        $admin->realname = $this->request->getPost("realname");
        $admin->phoneNumber = $this->request->getPost("phone_number");
        $admin->intro = $this->request->getPost("intro");
        $admin->status = $this->request->getPost("status");
        $admin->creater = $this->request->getPost("creater");
        $admin->createIp = $this->request->getPost("create_ip");
        $admin->createTime = $this->request->getPost("create_time");
        $admin->updater = $this->request->getPost("updater");
        $admin->updateTime = $this->request->getPost("update_time");
        $admin->roleId = $this->request->getPost("role_id");
        $admin->grade = $this->request->getPost("grade");
        $admin->email = $this->request->getPost("email", "email");
        

        if (!$admin->save()) {
            foreach ($admin->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "admin",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("admin was created successfully");

        $this->dispatcher->forward([
            'controller' => "admin",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a admin edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "admin",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $admin = Admin::findFirstByid($id);

        if (!$admin) {
            $this->flash->error("admin does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "admin",
                'action' => 'index'
            ]);

            return;
        }

        $admin->username = $this->request->getPost("username");
        $admin->password = $this->request->getPost("password");
        $admin->salt = $this->request->getPost("salt");
        $admin->realname = $this->request->getPost("realname");
        $admin->phoneNumber = $this->request->getPost("phone_number");
        $admin->intro = $this->request->getPost("intro");
        $admin->status = $this->request->getPost("status");
        $admin->creater = $this->request->getPost("creater");
        $admin->createIp = $this->request->getPost("create_ip");
        $admin->createTime = $this->request->getPost("create_time");
        $admin->updater = $this->request->getPost("updater");
        $admin->updateTime = $this->request->getPost("update_time");
        $admin->roleId = $this->request->getPost("role_id");
        $admin->grade = $this->request->getPost("grade");
        $admin->email = $this->request->getPost("email", "email");
        

        if (!$admin->save()) {

            foreach ($admin->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "admin",
                'action' => 'edit',
                'params' => [$admin->id]
            ]);

            return;
        }

        $this->flash->success("admin was updated successfully");

        $this->dispatcher->forward([
            'controller' => "admin",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a admin
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $admin = Admin::findFirstByid($id);
        if (!$admin) {
            $this->flash->error("admin was not found");

            $this->dispatcher->forward([
                'controller' => "admin",
                'action' => 'index'
            ]);

            return;
        }

        if (!$admin->delete()) {

            foreach ($admin->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "admin",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("admin was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "admin",
            'action' => "index"
        ]);
    }

}
