<?php
namespace xecommApp;
class Model_MemberAll extends \Model_Table{
	public $table="xecommApp_members";
	function init(){
		parent::init();

		$this->addField('first_name');
		$this->addField('last_name');
		$this->addField('emailID')->hint('Used as your Username');
		$this->addField('password')->type('password');
		$this->addField('address')->type('text');
		$this->addField('activation_code');
		$this->addField('last_notifiedID')->defaultValue(0);
		$this->addField('is_verify')->type('boolean')->defaultValue(false);
		$this->addField('is_active')->type('boolean')->defaultValue(true);
		$this->addField('join_on')->type('datetime')->defaultValue(date('Y-m-d H:i:s'));
		$this->addField('verified_on')->type('datetime')->defaultValue(null);
		$this->add('filestore/Field_Image','profile_pic_id');
		$this->hasMany('xecommApp/Order','member_id');

		$this->addExpression('name')->set('concat(first_name," ",last_name)');


		$this->add('dynamic_model/Controller_AutoCreator');
		

	}

	function getDistande(){
		
	}



	function is_registered($userName){
		$member=$this->add('xecommApp/Model_MemberAll');
		$member->addCondition('emailID',$userName);

		$member->tryloadAny();
		if($member->loaded()){
			return true;
		}else{
			return false;
		}
	}
	function has_referId($referanceId){
		$member=$this->add('xecommApp/Model_MemberAll');
		$member->tryLoad($referanceId);
		if($member->loaded()){
			return true;
		}else{
			return false;
		}
	}


	function register($visitorInfo){
		$this['first_name']=$visitorInfo['first_name'];
		$this['last_name']=$visitorInfo['last_name'];
		$this['password']=$visitorInfo['password'];
		$this['emailID']=$visitorInfo['emailId'];
		$this['referId']=$visitorInfo['referId'];
		if($this->save())
			return true;
		else
			return false;
			// throw new \Exception("Error Processing Request", 1);

																	
	}


/** RAKESH WORK */
	function sendVerificationMail(){

		if(!$this->loaded()) throw $this->exception('Model Must Be Loaded Before Email Send');

		$this['activation_code'] = rand(10000,99999);
		$this->save();
		
		$l=$this->api->locate('addons','xecommApp', 'location');
			$this->api->pathfinder->addLocation(
			$this->api->locate('addons','xecommApp'),
			array(
		  		'template'=>'templates',
		  		'css'=>'templates/css'
				)
			)->setParent($l);
			$tm=$this->add( 'TMail_Transport_PHPMailer' );
			$msg=$this->add( 'SMLite' );
			$msg->loadTemplate( 'mail/registrationVerifyMail' );

			//$msg->trySet('epan',$this->api->current_website['name']);		
			$enquiry_entries="some text related to register verification";
			$msg->trySetHTML('form_entries',$enquiry_entries);

			$email_body=$msg->render();	

			$subject ="Your Epan Got An Enquiry !!!";

			try{
				$tm->send( $this['email_id'], "info@epan.in", $subject, $email_body ,false,null);
			}catch( phpmailerException $e ) {
				// throw $e;
				$this->api->js(null,'$("#form-'.$_REQUEST['form_id'].'")[0].reset()')->univ()->errorMessage( $e->errorMessage() . " " . "rksinha.btech@gmail.com"  )->execute();
			}catch( Exception $e ) {
				throw $e;
			}
	}

	function is_current_user(){
		if($this->id == $this->api->xecommauth->model->id)
			return true;
		else
			return false;
	}

	function redeemPoint($redeemPoint,$remark=null){
		$redeemPoint=(-1)*$redeemPoint;
		if(!$this->loaded())
			throw new \Exception("Model Must Be loaded");
		
		$xsocial_member=$this->add('xsocialApp/Model_MemberAll');
		$xsocial_member->addCondition('emailID',$this['emailID']);
		$xsocial_member->tryloadAny();
		if($xsocial_member->loaded())
			$xsocial_member->redeemPoint($redeemPoint,$remark);
		return true;
			
	}

	function sendSubscribtionMail(){

		if(!$this->loaded()) throw $this->exception('Model Must Be Loaded Before Email Send');
		
		$l=$this->api->locate('addons','xecommApp', 'location');
			$this->api->pathfinder->addLocation(
			$this->api->locate('addons','xecommApp'),
			array(
		  		'template'=>'templates',
		  		'css'=>'templates/css'
				)
			)->setParent($l);
			$tm=$this->add( 'TMail_Transport_PHPMailer' );
			$msg=$this->add( 'SMLite' );
			$msg->loadTemplate( 'mail/subscribeMail' );

			//$msg->trySet('epan',$this->api->current_website['name']);		
			$enquiry_entries="some text related to register verification";
			$msg->trySetHTML('form_entries',$enquiry_entries);

			$email_body=$msg->render();	

			$subject ="Your Epan Got An Enquiry !!!";

			try{
				$tm->send( "", "info@epan.in", $subject, $email_body ,false,null);
			}catch( phpmailerException $e ) {
				// throw $e;
				$this->api->js(null,'$("#form-'.$_REQUEST['form_id'].'")[0].reset()')->univ()->errorMessage( $e->errorMessage() . " " . ""  )->execute();
			}catch( Exception $e ) {
				throw $e;
			}
	}

	function sendOrderDetail(){

		if(!$this->loaded()) throw $this->exception('Model Must Be Loaded Before Email Send');
		
		$l=$this->api->locate('addons','xecommApp', 'location');
			$this->api->pathfinder->addLocation(
			$this->api->locate('addons','xecommApp'),
			array(
		  		'template'=>'templates',
		  		'css'=>'templates/css'
				)
			)->setParent($l);
			$tm=$this->add( 'TMail_Transport_PHPMailer' );
			$msg=$this->add( 'SMLite' );
			$msg->loadTemplate( 'mail/subscribeMail' );

			//$msg->trySet('epan',$this->api->current_website['name']);		
			$enquiry_entries="some text related to register verification";
			$msg->trySetHTML('form_entries',$enquiry_entries);

			$email_body=$msg->render();	

			$subject ="Your Epan Got An Enquiry !!!";

			try{
				$tm->send( "", "info@epan.in", $subject, $email_body ,false,null);
			}catch( phpmailerException $e ) {
				// throw $e;
				$this->api->js(null,'$("#form-'.$_REQUEST['form_id'].'")[0].reset()')->univ()->errorMessage( $e->errorMessage() . " " . ""  )->execute();
			}catch( Exception $e ) {
				throw $e;
			}
	}

}