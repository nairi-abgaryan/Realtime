<?php
class UsersController extends AppController {
  public $uses = array(
        "warehouse", "warehofuse", "written_item", "Comment", "Station", "Server","Cron",
        "User", "Realtime", "Team", "Client", "Person", "Transaction_log","new_sms",
        "Estate_user", "Estate_user", "Gps", "Adress", "Service", "Payment","url",
        "Technical_data", "Telefon", "Legal_person", "online", "histori", "role","credit",
        "Problem", "Permission", "Service_name", 'Problem', 'Product_name', 'legal_data',
        "User_permission", "Village", "Street", "Transaction", "sxal_username", 
        "black_list", "sms", "new_messages","call_history","problem_log","page","permission","user_role"
    );
  
    public $helpers = array('Html', 'Form', 'Session');
    public $paginate = array(
        'limit' => 1,
        'conditions' => array('status' => '1'),
        'order' => array('User.username' => 'asc' ) 
    );
   
   public $components = array(
    
    'Auth' => array(
        'loginRedirect' => array('controller' => 'realtimes', 'action' => 'search'),
        'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
        'authError' => 'You must be logged in to view this page.',
        'loginError' => 'Invalid Username or Password entered, please try again.'
 
    ));
    
    
   public function perm($controller,$action,$role){
        $page = $this->perm = $this->page->query("SELECT perm FROM realtimes.pages as page "
                . "left join permissions as perm "
                . "on perm.page=page.id "
                . "where page.page_controller='$controller' and page_name='$action' and role='$role'");
        if(count($page)!=0 ){
        
            if(!$page["0"]["perm"]["perm"]){ 
                $page = $this->perm = $this->page->query("SELECT * FROM realtimes.pages as page "
                . "left join permissions as perm "
                . "on perm.page=page.id "
                . "where page.page_controller='$controller' and perm='1' and role='$role' limit 1");
                if(count($page)!=0 && $page["0"]["perm"]["perm"]){
                   return $this->redirect(array('action'=>$page["0"]["page"]["page_name"],'controller'=>$page["0"]["page"]["page_controller"]));
                 }else{
                     $page = $this->perm = $this->page->query("SELECT * FROM realtimes.pages as page "
                    . "left join permissions as perm "
                    . "on perm.page=page.id "
                    . "where perm='1' and role='$role' limit 1");
            
                      if(count($page)!=0 && $page["0"]["perm"]["perm"]){
                          return $this->redirect(array('action'=>$page["0"]["page"]["page_name"],'controller'=>$page["0"]["page"]["page_controller"]));
                      }else{
                          return $this->redirect(array('action'=>'logout','controller'=>'users'));
                      }
                 }
            }else{
                
            }
        }else if(count($page)==0){
            
        }
   }
 

   // only allow the login controllers only
    public function beforeFilter() {
         
        $this->Auth->allow('login');
        $this->set('logged_in', $this->Auth->loggedIn());
        $this->set('current_user', $this->Auth->user());
        $this->Auth->user();
        $role = $this->Auth->user()["role"];
        $controller = $this->request->params['controller'];
        $action = $this->request->params['action'];
        $this->perm($controller, $action,$role);
         $a = $this->user_role->find("all");
         $this->set('role',$a);
    }
   

    public function isAuthorized($user) {
        // Here is where we should verify the role and give access based on role

        return true;
    }
 
    public function login(){
          
              
            
                     
                if ($this->request->is('post')) {
                    
                    if ($this->Auth->login()) {
                      
                        $this->redirect($this->Auth->redirectUrl());
                    } else {
                        $this->Session->setFlash(__('Invalid username or passwords'));
                    }
                }
            
             
             
    }

        // if we get the post information, try to authenticate
    

    public function logout() {
         $username = $this->Auth->user()["username"];
          if($online){
               $this->Online->Delete($online["Online"]["id"]);
          }
            session_destroy();
        $this->Session->destroy();
        $this->redirect($this->Auth->logout());
    }
 
    public function index($id = null) {
         if($this->Auth->user()["role"] == "1"){
        $this->paginate = array(
            'limit' => 10,
            'order' => array('User.username' => 'asc' )
        );
        $users = $this->paginate('User');
        $this->set(compact('users'));
        }else{
            $this->redirect(array('controller'=>'realtimes','action' => 'search')); 
        }
    }
   
 
    public function add() {
     
        if ($this->request->is('post')) {
               
            $this->User->create();
            if (isset($this->request->data)) {
                var_dump($this->request->data);
                if( $this->User->save($this->request->data)){
                    $data = $this->request->data["User"];
                    $insertper = array();
                    $this->Session->setFlash(__('The user has been created'));
                    $insertper["users_id"] = $this->User->id;
                   
                   
                    $this->Session->write($authdata,$insertper);
                    $this->redirect(array('controller'=>'users','action' => 'add')); 
                    }else {
                        $this->Session->setFlash(__('The user could not be created. Please, try again.'));
                    }   
            }
        }
    }
 
    public function edit($id = null) {
 
            if (!$id) {
                $this->Session->setFlash('Please provide a user id');
                $this->redirect(array('action'=>'index'));
            }
 
            $user = $this->User->findById($id);
            if (!$user) {
                $this->Session->setFlash('Invalid User ID Provided');
                $this->redirect(array('action'=>'index'));
            }
 
            if ($this->request->is('post') || $this->request->is('put')) {
                $this->User->id = $id;
                $this->request->data["User"]["id"] = (int)$id;
                $this->request->data["User"]["role"] = (int)$this->request->data["User"]["role"];
                
                var_dump($this->request->data);
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash(__('The user has been updated'));
                    $this->redirect(array('action' => 'edit', $id));
                }else{
                    $this->Session->setFlash(__('Unable to update your user.'));
                }
            }
            
            if (!$this->request->data) {
                $this->request->data = $user;
            }
    }
    public function delete($id = null) {
         
        if (!$id) {
            $this->Session->setFlash('Please provide a user id');
            $this->redirect(array('action'=>'index'));
        }
         
        $this->User->id = $id;
        if (!$this->User->exists()) {
            $this->Session->setFlash('Invalid user id provided');
            $this->redirect(array('action'=>'index'));
        }
        if ($this->User->saveField('status', 0)) {
            $this->Session->setFlash(__('User deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->redirect(array('action' => 'index'));
    }
    public function message(){
        
    }
}
?>