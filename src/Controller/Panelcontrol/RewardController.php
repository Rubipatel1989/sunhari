<?php

namespace App\Controller\Panelcontrol;



use App\Controller\AppController;

use Cake\Core\Configure;

use Cake\Network\Exception\ForbiddenException;

use Cake\Network\Exception\NotFoundException;

use Cake\View\Exception\MissingTemplateException;

use Cake\ORM\TableRegistry;

use Cake\Network\Session\DatabaseSession;

use Cake\Controller\Component\FlashComponent;



/**

 * Static content controller

 *

 * This controller will render views from Template/Pages/

 *

 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html

 */

class RewardController extends AppController

{



    public function index(){



        if(!$this->request->getSession()->check('adminUserId')){

            return $this->redirect($this->backend_url.'/user/login');

        }



        $prefix_title = $this->backendTitle;

        

        $title = $prefix_title.' Reward';



        $this->set('title', $title);



        $rewardsTable = TableRegistry::get('Rewards');

        

        $conditions = array(

        					'Rewards.status !=' => 2

        				);

        $join = array();



        $order = array(

        				'Rewards.id' => 'DESC'

        			);



        $fields = array('Rewards.id', 'Rewards.user_id', 'Rewards.title', 'Rewards.direct_users', 'Rewards.matching_users', 'Rewards.reward', 'Rewards.amount', 'Rewards.start_date', 'Rewards.end_date', 'Rewards.remark', 'Rewards.status');



        $rewards = $rewardsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join, 'order' => $order))->toArray();

        $this->set('rewards', $rewards);



    }



    public function add(){



        if(!$this->request->getSession()->check('adminUserId')){

            return $this->redirect($this->backend_url.'/user/login');

        }



        $prefix_title = $this->backendTitle;

        

        $title = $prefix_title.' Reward | Add';



        $this->set('title', $title);



        $rewardsTable = TableRegistry::get('Rewards');



        if($this->request->is('post')){

            /*echo '<pre>';

            print_r($this->request->getData());

            echo $startDate = date('Y-m-d', strtotime($this->request->getData()['Reward']['start_date']));

            exit;*/



            $reward 					=  $rewardsTable->newEmptyEntity();

            $reward->user_id 			=  $this->adminUser->id;

            $reward->title              =  $this->request->getData()['Reward']['title'];

            $reward->direct_users       =  $this->request->getData()['Reward']['direct_users'];

            $reward->matching_users     =  $this->request->getData()['Reward']['matching_users'];

            $reward->reward   			=  $this->request->getData()['Reward']['reward'];

            $reward->amount    		    =  $this->request->getData()['Reward']['amount'];

            $reward->start_date       	=  date('Y-m-d', strtotime($this->request->getData()['Reward']['start_date']));

            $reward->end_date   		=  date('Y-m-d', strtotime($this->request->getData()['Reward']['end_date']));

            $reward->remark     		=  nl2br($this->request->getData()['Reward']['remark']);

            $reward->status   			=  $this->request->getData()['Reward']['status'];

            $reward->created   		    =  date("Y-m-d H:i:s");

            $reward->modified   		=  date("Y-m-d H:i:s");



            if($rewardsTable->save($reward)){

                $this->Flash->success(__('Congratulations! Reward has been added successfully.'));

                return $this->redirect($this->backend_url.'/reward/index');

            }

        }

    }



    public function edit($intId){



        if(!$this->request->getSession()->check('adminUserId')){

            return $this->redirect($this->backend_url.'/user/login');

        }



        if(!isset($intId)){

            return $this->redirect($this->backend_url.'/reward/index');

        }



        $prefix_title = $this->backendTitle;

        

        $title = $prefix_title.' Reward | Edit';



        $this->set('title', $title);



        $rewardsTable = TableRegistry::get('Rewards');



        $conditions = array(

        					'Rewards.id' => $intId

        				);



        $fields = array('Rewards.id', 'Rewards.user_id', 'Rewards.title', 'Rewards.direct_users', 'Rewards.matching_users', 'Rewards.reward', 'Rewards.amount', 'Rewards.start_date', 'Rewards.end_date', 'Rewards.remark', 'Rewards.status');



        $reward = $rewardsTable->find('all', array('fields' => $fields, 'conditions' => $conditions))->first();

        $this->set('reward', $reward);



        if($this->request->is('post')){

            /*echo '<pre>';

            print_r($this->request->getData());

            exit;*/



            $reward 					=  $rewardsTable->get($intId);

            $reward->title              =  $this->request->getData()['Reward']['title'];

            $reward->direct_users       =  $this->request->getData()['Reward']['direct_users'];

            $reward->matching_users     =  $this->request->getData()['Reward']['matching_users'];

            $reward->reward   			=  $this->request->getData()['Reward']['reward'];

            $reward->amount    		    =  $this->request->getData()['Reward']['amount'];

            $reward->start_date       	=  date('Y-m-d', strtotime($this->request->getData()['Reward']['start_date']));

            $reward->end_date   		=  date('Y-m-d', strtotime($this->request->getData()['Reward']['end_date']));

            $reward->remark     		=  nl2br($this->request->getData()['Reward']['remark']);

            $reward->status   			=  $this->request->getData()['Reward']['status'];

            $reward->modified   		=  date("Y-m-d H:i:s");



            if($rewardsTable->save($reward)){

                $this->Flash->success(__('Congratulations! Reward has been updated successfully.'));

                return $this->redirect($this->backend_url.'/reward/index');

            }

        }

    }



    public function updateStatus($intId, $intStatus){



        if(!$this->request->getSession()->check('adminUserId')){

            return $this->redirect($this->backend_url.'/user/login');

        }



        if(!isset($intId)){

            return $this->redirect(['controller' => 'packages', 'action' => 'index', 'prefix' => $this->backend]);

        }



        if(!isset($intStatus)){

            return $this->redirect(['controller' => 'packages', 'action' => 'index', 'prefix' => $this->backend]);

        }



        $prefix_title = $this->backendTitle;

        

        $title = $prefix_title.' Reward | Update Status';



        $this->set('title', $title);



        $rewardsTable = TableRegistry::get('Rewards');



        $conditions = array(

                            'Rewards.status !=' => 2,

                            'Rewards.id' => $intId

                        );

       



        $fields =  array('Rewards.id');

        $reward = $rewardsTable->find('all', array('fields' => $fields, 'conditions' => $conditions))->first();



        if(empty($reward)){

            return $this->redirect(['controller' => 'packages', 'action' => 'index', 'prefix' => $this->backend]);

        }



        $reward = $rewardsTable->get($intId);

        $reward->status = $intStatus;

        if($rewardsTable->save($reward)){

            $this->Flash->success(__('Congratulations! Status has been updated successfully.'));

            return $this->redirect($this->backend_url.'/reward/index');

        }



        $this->render(false);

    }



    public function delete($intId){



        if(!$this->request->getSession()->check('adminUserId')){

            return $this->redirect($this->backend_url.'/user/login');

        }



        if(!isset($intId)){

            return $this->redirect(['controller' => 'packages', 'action' => 'index', 'prefix' => $this->backend]);

        }



        $prefix_title = $this->backendTitle;

        

        $title = $prefix_title.' Reward | Delete';



        $this->set('title', $title);



        $rewardsTable = TableRegistry::get('Rewards');



        $conditions = array(

                            'Rewards.status !=' => 2,

                            'Rewards.id' => $intId

                        );

       



        $fields =  array('Rewards.id');

        $reward = $rewardsTable->find('all', array('fields' => $fields, 'conditions' => $conditions))->first();



        if(empty($reward)){

            return $this->redirect(['controller' => 'packages', 'action' => 'index', 'prefix' => $this->backend]);

        }



        $reward = $rewardsTable->get($intId);

        $reward->status = 2;

        if($rewardsTable->save($reward)){

            $this->Flash->success(__('Congratulations! Status has been updated successfully.'));

            return $this->redirect($this->backend_url.'/reward/index');

        }



        $this->render(false);

    }



    public function directReward() {

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;

        

        $title = $prefix_title.' Direct Reward';



        $this->set('title', $title);



        $achievedRewardsTable = TableRegistry::get('AchievedRewards');



        $conditions = array(

                            //'(Users.direct_active_left_one + Users.direct_active_right_one) >= 8',

                            'AchievedRewards.is_direct_home_furniture = 1

                             OR AchievedRewards.is_direct_bike = 1

                             OR AchievedRewards.is_direct_kwid = 1

                             OR AchievedRewards.is_direct_swift = 1

                             OR AchievedRewards.is_direct_artica = 1

                             OR AchievedRewards.is_direct_scorpio = 1

                             OR AchievedRewards.is_direct_bmw = 1

                             OR AchievedRewards.is_direct_audi = 1'

                        );



        $join = array(

                        array(

                            'table' => 'users',

                            'alias' => 'Users',

                            'type' => 'INNER',

                            'conditions' => array('Users.id = AchievedRewards.user_id')

                        ),

                        array(

                            'table' => 'details',

                            'alias' => 'Details',

                            'type' => 'INNER',

                            'conditions' => array('Details.user_id = Users.id')

                        )

                    );



        $fields = array('Users.id', 'Users.username', 'Details.id', 'Details.first_name', 'Details.last_name');

        $users = $achievedRewardsTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions))->enableAutoFields(true)->toArray();



        $this->set('users', $users); 





        $achievedRewardInfo = [];

        if(isset($_GET['user_id']) && !empty($_GET['user_id'])){



            $userId = $_GET['user_id'];



            $conditions = array(

                                'AchievedRewards.user_id' => $userId,

                            );

            

            $achievedRewardInfo =  $achievedRewardsTable->find('all', array('conditions' => $conditions))->enableAutoFields(true)->first();

        }



        $this->set('achievedRewardInfo', $achievedRewardInfo);



    }



    public function pairReward() {



        if(!$this->request->getSession()->check('adminUserId')){

            return $this->redirect($this->backend_url.'/user/login');

        }



        $prefix_title = $this->backendTitle;

        

        $title = $prefix_title.' Pair Reward';



        $this->set('title', $title);



        $achievedRewardsTable = TableRegistry::get('AchievedRewards');



        $conditions = array(

                            //'(Users.direct_active_left_one + Users.direct_active_right_one) >= 8',

                            'AchievedRewards.is_pair_home_furniture = 1

                             OR AchievedRewards.is_pair_kwid = 1

                             OR AchievedRewards.is_pair_swift = 1

                             OR AchievedRewards.is_pair_artica = 1

                             OR AchievedRewards.is_pair_scorpio = 1

                             OR AchievedRewards.is_pair_bmw = 1

                             OR AchievedRewards.is_pair_audi = 1'

                        );



        $join = array(

                        array(

                            'table' => 'users',

                            'alias' => 'Users',

                            'type' => 'INNER',

                            'conditions' => array('Users.id = AchievedRewards.user_id')

                        ),

                        array(

                            'table' => 'details',

                            'alias' => 'Details',

                            'type' => 'INNER',

                            'conditions' => array('Details.user_id = Users.id')

                        )

                    );



        $fields = array('Users.id', 'Users.username', 'Details.id', 'Details.first_name', 'Details.last_name');

        $users = $achievedRewardsTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions))->enableAutoFields(true)->toArray();



        $this->set('users', $users); 





        $achievedRewardInfo = [];

        if(isset($_GET['user_id']) && !empty($_GET['user_id'])){



            $userId = $_GET['user_id'];



            $conditions = array(

                                'AchievedRewards.user_id' => $userId,

                            );

            

            $achievedRewardInfo =  $achievedRewardsTable->find('all', array('conditions' => $conditions))->enableAutoFields(true)->first();

        }



        $this->set('achievedRewardInfo', $achievedRewardInfo);



    }



    public function changeRewardStatus($encUserId, $intStatus, $encField, $encBackUrl) {





        if(!$this->request->getSession()->check('adminUserId')){

            return $this->redirect($this->backend_url.'/user/login');

        }



        $prefix_title = $this->backendTitle;

        

        $title = $prefix_title.' Change Reward Status';



        $this->set('title', $title);



        $achievedRewardsTable = TableRegistry::get('AchievedRewards');



        $userId = base64_decode($encUserId);

        $field = base64_decode($encField);

        $backUrl = base64_decode($encBackUrl);



        $achievedRewardData = $achievedRewardsTable->get($userId);



        if($field == 'is_direct_home_furniture_status'){

             $achievedRewardData->is_direct_home_furniture_status = $intStatus;

        }

        elseif($field == 'is_direct_bike_status'){

             $achievedRewardData->is_direct_bike_status = $intStatus;

        }

        elseif($field == 'is_direct_kwid_status'){

             $achievedRewardData->is_direct_kwid_status = $intStatus;

        }

        elseif($field == 'is_direct_swift_status'){

             $achievedRewardData->is_direct_swift_status = $intStatus;

        }

        elseif($field == 'is_direct_artica_status'){

             $achievedRewardData->is_direct_artica_status = $intStatus;

        }

        elseif($field == 'is_direct_scorpio_status'){

             $achievedRewardData->is_direct_scorpio_status = $intStatus;

        }

        elseif($field == 'is_direct_bmw_status'){

             $achievedRewardData->is_direct_bmw_status = $intStatus;

        }

        elseif($field == 'is_direct_audi_status'){

             $achievedRewardData->is_direct_audi_status = $intStatus;

        }

        elseif($field == 'is_pair_home_furniture_status'){

             $achievedRewardData->is_pair_home_furniture_status = $intStatus;

        }

        elseif($field == 'is_pair_kwid_status'){

             $achievedRewardData->is_pair_kwid_status = $intStatus;

        }

        elseif($field == 'is_pair_swift_status'){

             $achievedRewardData->is_pair_swift_status = $intStatus;

        }

        elseif($field == 'is_pair_artica_status'){

             $achievedRewardData->is_pair_artica_status = $intStatus;

        }

        elseif($field == 'is_pair_scorpio_status'){

             $achievedRewardData->is_pair_scorpio_status = $intStatus;

        }

        elseif($field == 'is_pair_bmw_status'){

             $achievedRewardData->is_pair_bmw_status = $intStatus;

        }

        elseif($field == 'is_pair_audi_status'){

             $achievedRewardData->is_pair_audi_status = $intStatus;

        }



        if($achievedRewardsTable->save($achievedRewardData)){

            $this->Flash->success(__('Congratulations! Status has been updated successfully.'));

            return $this->redirect($backUrl.'?user_id='.$userId);

        }

        $this->render(false);



    }

}



