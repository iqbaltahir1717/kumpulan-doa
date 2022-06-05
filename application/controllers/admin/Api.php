<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_doa');
        $this->load->model('m_kategori');
        $this->load->model('m_riwayat');
    }


    public function get_kumpulan_doa()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        http_response_code(200);

        $doa    = $this->m_api->getKumpulanDoa();
        $resultData = $doa;

        echo json_encode($resultData, JSON_PRETTY_PRINT);
    }


    public function search()
    {
        if ($this->input->post('key')) {
            $data['search'] = $this->input->post('key');
            $this->session->set_userdata('sess_search_doa', $data['search']);
        } else {
            $data['search'] = $this->session->userdata('sess_search_doa');
        }

        // PAGINATION
        $baseUrl    = base_url() . "admin/doa/search/" . $data['search'] . "/";
        $totalRows  = count((array)$this->m_doa->read('', '', $data['search'], '', ''));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 5;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;

        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows;

        //DATA
        $data['setting'] = getSetting();
        $data['title']   = 'Kumpulan Doa';
        $data['doa']    = $this->m_doa->read($perPage, $page, $data['search'], '', '');

        // TEMPLATE
        $view         = "_backend/doa/data";
        $viewCategory = "all";
        renderTemplate($data, $view, $viewCategory);
    }
}
