<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
        $aConstruct = [
            'container' =>'main/home'
        ];

        $this->load->view('/layout/layout', $aConstruct);
		//$this->load->view('welcome_message');
	}

    /*
    TODO:: 웁스 에러기 처리기 추가해보기
    TODO:: 모노로그 추가
    TODO:: 스위프트메일러 추가
    */

    //
    //
}
