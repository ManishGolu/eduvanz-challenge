<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiFunctionalLogic extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->model('ApiDataLogic');
    error_reporting(0);
  }

	public function index(){
    header('Content-Type: application/json');
    $api_method = $_SERVER['REQUEST_METHOD'];
    if($api_method == 'POST'){
      $this->registration();
    }else if($api_method == 'GET'){
      $this->list_participant();
    }else if($api_method == 'PUT'){
      $this->update_details();
    }else{
      echo json_encode(array('data' => 'Undefiend method.'));;
    }
	}

  public function registration(){
    $params = json_decode(file_get_contents('php://input'), TRUE);
    $addLen = strlen($params['address']);
    if($addLen > 50){
      echo json_encode(array('data' => 'Please check, the address the exceeding the maximum limit of 50 characters.'));
    }else if(($params['number_of_guests'] < 3) && (($params['profession'] == 'Student') || ($params['profession'] == 'Employed'))){
    $paramArray = array(
      'name' => $params['name'],
      'age' => $params['age'],
      'date_of_birth' => $params['date_of_birth'],
      'profession' => $params['profession'],
      'locality' => $params['locality'],
      'number_of_guests' => $params['number_of_guests'],
      'address' => $params['address'],
    );
    $this->ApiDataLogic->saveRegistration($paramArray);
    echo json_encode(array('data' => 'Registration successful.'));
  }else{
    echo json_encode(array('data' => 'Please check the values of Profession(Student or Employed) and Number of Guests(0, 1 or 3), before registration.'));
    }
  }

  public function list_participant(){
    $listParams = json_decode(file_get_contents('php://input'), TRUE);
    $minVal = $listParams['min'];
    $maxVal = $listParams['max'];
    $list = $this->ApiDataLogic->getList($minVal, $maxVal);
    echo json_encode(array('data' => $list));
  }

  public function update_details(){
    $updateParams = json_decode(file_get_contents('php://input'), TRUE);
    $addLen = strlen($updateParams['address']);
    if($addLen > 50){
      echo json_encode(array('data' => 'Please check, the address the exceeding the maximum limit of 50 characters.'));
    }else if(($updateParams['number_of_guests'] < 3) && (($updateParams['profession'] == 'Student') || ($updateParams['profession'] == 'Employed'))){
      $updateParamArray = array(
        'name' => $updateParams['name'],
        'age' => $updateParams['age'],
        'date_of_birth' => $updateParams['date_of_birth'],
        'profession' => $updateParams['profession'],
        'locality' => $updateParams['locality'],
        'number_of_guests' => $updateParams['number_of_guests'],
        'address' => $updateParams['address'],
      );
      $id = $updateParams['id'];
      $this->ApiDataLogic->updateParticipant($id, $updateParamArray);
      echo json_encode(array('data' => 'Participant has been updated successfully.'));
    }else{
      echo json_encode(array('data' => 'Please check the values of Profession(Student or Employed) and Number of Guests(0, 1 or 3), before update.'));
    }
  }

  public function listingParticipants(){
    if($this->input->post('searched')){
      $searchValue = $this->input->post('search');
      $data['list'] = $this->ApiDataLogic->searchInput($searchValue);
    }else{
      $tRows = $this->getTotalRows();
      $pageNo = $tRows / 10;
      $pg = explode('.', $pageNo);
      if($pg[0] < $pageNo){
        $totPages = $pg[0] + 1;
      }else if($pg[0] == $pageNo){
        $totPages = $pg[0];
      }
      $data['totalPages'] = $totPages;
      $showPageNo = $this->input->post('page');
      if($showPageNo > 0){
      $minVal = (($showPageNo - 1) * 10) + 1;
      }else{
      $minVal = 1;
      }
      $maxVal = $minVal + 9;
      $data['list'] = $this->ApiDataLogic->getList($minVal, $maxVal);
    }

    $this->load->view('participant-list', $data);
  }

  public function getTotalRows(){
    return $this->ApiDataLogic->totalRows();
  }

}
