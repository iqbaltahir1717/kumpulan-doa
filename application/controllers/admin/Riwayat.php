<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Riwayat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_riwayat');
        if (!($this->session->userdata('user_id'))) {
            // ALERT
            $alertStatus  = 'failed';
            $alertMessage = 'Anda tidak memiliki Hak Akses atau Session anda sudah habis';
            getAlert($alertStatus, $alertMessage);
            redirect('auth');
        }
    }


    public function index()
    {
        $this->session->unset_userdata('sess_search_riwayat');

        // PAGINATION
        $baseUrl    = base_url() . "admin/riwayat/index/";
        $totalRows  = count((array) $this->m_riwayat->read('', '', ''));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 4;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;

        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows;



        //DATA
        $data['setting'] = getSetting();
        $data['title']   = 'Bidang';
        $data['riwayat']   = $this->m_riwayat->read($perPage, $page, '');


        // TEMPLATE
        $view         = "_backend/doa/riwayat";
        $viewCategory = "all";
        renderTemplate($data, $view, $viewCategory);
    }


    public function search()
    {
        if ($this->input->post('key')) {
            $data['search'] = $this->input->post('key');
            $this->session->set_userdata('sess_search_riwayat', $data['search']);
        } else {
            $data['search'] = $this->session->userdata('sess_search_riwayat');
        }

        // PAGINATION
        $baseUrl    = base_url() . "admin/riwayat/search/" . $data['search'] . "/";
        $totalRows  = count((array)$this->m_riwayat->read('', '', $data['search']));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 5;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;

        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows;

        //DATA
        $data['setting'] = getSetting();
        $data['title']   = 'Bidang';
        $data['riwayat']   = $this->m_riwayat->read($perPage, $page, $data['search']);

        // TEMPLATE
        $view         = "_backend/doa/riwayat";
        $viewCategory = "all";
        renderTemplate($data, $view, $viewCategory);
    }


    public function create()
    {
        csrfValidate();
        // POST
        $data['riwayat_id']   = '';
        $data['riwayat_name'] = $this->input->post('riwayat_name');
        $data['createtime']         = date('Y-m-d H:i:s');
        $this->m_riwayat->create($data);

        // LOG
        $message    = $this->session->userdata('user_name') . " menambah data kategori bidang berita " . $data['riwayat_name'];
        createLog($message);

        // ALERT
        $alertStatus  = "success";
        $alertMessage = "Berhasil menambah data kategori bidang berita " . $data['riwayat_name'];
        getAlert($alertStatus, $alertMessage);

        redirect('admin/riwayat');
    }


    public function update()
    {
        csrfValidate();
        // POST
        $data['riwayat_id']   = $this->input->post('riwayat_id');
        $data['riwayat_name'] = $this->input->post('riwayat_name');
        $this->m_riwayat->update($data);

        // LOG
        $message    = $this->session->userdata('user_name') . " mengubah data kategori bidang berita dengan ID = " . $data['riwayat_id'] . " - " . $data['riwayat_name'];
        createLog($message);

        // ALERT
        $alertStatus  = "success";
        $alertMessage = "Berhasil mengubah data kategori bidang berita : " . $data['riwayat_name'];
        getAlert($alertStatus, $alertMessage);

        redirect('admin/riwayat');
    }


    public function delete()
    {
        csrfValidate();
        // POST
        $this->m_riwayat->delete($this->input->post('riwayat_id'));

        // LOG
        $message    = $this->session->userdata('user_name') . " menghapus data kategori bidang berita dengan ID = " . $this->input->post('riwayat_id') . " - " . $this->input->post('riwayat_name');
        createLog($message);

        // ALERT
        $alertStatus  = "failed";
        $alertMessage = "Menghapus data kategori bidang berita : " . $this->input->post('riwayat_name');
        getAlert($alertStatus, $alertMessage);

        redirect('admin/riwayat');
    }
}
