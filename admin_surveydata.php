<?php
  global $wpdb;
  $cmd='';
  $id = '';
  $cmd = isset($_REQUEST['cmd'])?$_REQUEST['cmd']:'';
  $id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
  
  switch($cmd){
	case "save":
	         $created_at = "";
			 $updated_at = "";

			if($id<=0){
				 $created_at = date("Y-m-d H:i:s");
			 }
			else if($id>0){
				 $updated_at = date("Y-m-d H:i:s");
			 }

			$params = array(
			                'question' => $_REQUEST['question'],
							'answer'  => $_REQUEST['answer'],
							'created_at' =>$created_at,
							'updated_at' =>$updated_at,
							
							);
			
			 
			if($id>0){
			unset($params['created_at']);
			}if($id<=0){
			unset($params['updated_at']);
			} 
			if($id<=0){
			$res = $wpdb->insert($wpdb->prefix ."surveybot",$params);
			}
			if($id>0){
			
			 $res = $wpdb->update($wpdb->prefix ."surveybot",$params,array('id'=>$_REQUEST['id']));
			 
			}
			 ob_start();
             ob_end_flush();
			 echo "<script>";
			  echo "window.location.href = 'admin.php?page=surveydata';";
			 echo "</script>";
	      break;
	case "delete":  
	      $wpdb->delete($wpdb->prefix ."surveybot",array('id'=>$_REQUEST['id']));
		   ob_start();
           ob_end_flush();
		   echo "<script>";
			  echo "window.location.href = 'admin.php?page=surveydata';";
			 echo "</script>";
	      break;  
    case "edit":
	         if(!empty($_REQUEST['id'])){
		     	$surveydata  = $wpdb->get_results("select * from ".$wpdb->prefix ."surveybot where id='".$_REQUEST['id']."'"); 
			 }
			 include(dirname(__FILE__) . '/template/admin/surveydata/form.php');  
		  break;		  
	default:
	   $surveydata  = $wpdb->get_results("select * from ".$wpdb->prefix ."surveybot  ORDER BY id DESC"); 
	   include(dirname(__FILE__) . '/template/admin/surveydata/index.php');  
  }
?>