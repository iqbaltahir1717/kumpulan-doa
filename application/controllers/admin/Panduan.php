<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Panduan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_panduan');
        // if (!$this->session->userdata('user_id') or $this->session->userdata('user_group') != 1) {
        //     // ALERT
        //     $alertStatus  = 'failed';
        //     $alertMessage = 'Anda tidak memiliki Hak Akses atau Session anda sudah habis';
        //     getAlert($alertStatus, $alertMessage);
        //     redirect('admin/dashboard');
        // }
    }


    public function index()
    {
        $this->session->unset_userdata('sess_search_panduan');

        // PAGINATION
        $baseUrl    = base_url() . "admin/panduan/index/";
        $totalRows  = count((array) $this->m_panduan->read('', '', ''));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 4;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;

        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows;



        //DATA
        $data['setting'] = getSetting();
        $data['title']   = 'Panduan';
        $data['panduan']     = $this->m_panduan->read($perPage, $page, '');


        // TEMPLATE
        $view         = "_backend/panduan";
        $viewCategory = "all";
        renderTemplate($data, $view, $viewCategory);
    }


    public function search()
    {
        if ($this->input->post('key')) {
            $data['search'] = $this->input->post('key');
            $this->session->set_userdata('sess_search_panduan', $data['search']);
        } else {
            $data['search'] = $this->session->userdata('sess_search_panduan');
        }

        // PAGINATION
        $baseUrl    = base_url() . "admin/panduan/search/" . $data['search'] . "/";
        $totalRows  = count((array)$this->m_panduan->read('', '', $data['search']));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 5;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;

        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows;

        //DATA
        $data['setting'] = getSetting();
        $data['title']   = 'Panduan';
        $data['panduan']     = $this->m_panduan->read($perPage, $page, $data['search']);

        // TEMPLATE
        $view         = "_backend/panduan";
        $viewCategory = "all";
        renderTemplate($data, $view, $viewCategory);
    }

    public function create_page()
    {
        //DATA
        $data['setting']       = getSetting();
        $data['title']         = 'Tambah Panduan';

        // TEMPLATE
        $view         = "_backend//_create_panduan";
        $viewCategory = "all";
        renderTemplate($data, $view, $viewCategory);
    }

    public function update_page()
    {
        //DATA
        $data['setting']       = getSetting();
        $data['title']         = 'Update Panduan';
        $data['panduan']          = $this->m_panduan->get($this->uri->segment(4));

        // TEMPLATE
        $view         = "_backend/_update_panduan";
        $viewCategory = "all";
        renderTemplate($data, $view, $viewCategory);
    }

    public function detail_page()
    {
        //DATA
        $data['setting']       = getSetting();
        $data['title']         = 'Update Panduan';
        $data['panduan']          = $this->m_panduan->get($this->uri->segment(4));

        // TEMPLATE
        $view         = "_backend/_detail_panduan";
        $viewCategory = "all";
        renderTemplate($data, $view, $viewCategory);
    }

    public function create()
    {
        csrfValidate();
        // POST
        $data['panduan_id']       = '';
        $data['panduan_title'] = $this->input->post('panduan_title');
        $data['panduan_deskripsi']   = $this->input->post('panduan_deskripsi');
        $data['createtime']   = date('Y-m-d H:i:s');
        $this->m_panduan->create($data);

        // LOG
        $message    = $this->session->userdata('user_name') . " menambah data panduan ";
        createLog($message);

        // ALERT
        $alertStatus  = "success";
        $alertMessage = "Berhasil menambah data panduan ";
        getAlert($alertStatus, $alertMessage);

        redirect('admin/panduan');
    }


    public function update()
    {
        csrfValidate();
        // POST
        $data['panduan_id']       = $this->input->post('panduan_id');
        $data['panduan_title'] = $this->input->post('panduan_title');
        $data['panduan_deskripsi']   = $this->input->post('panduan_deskripsi');
        $this->m_panduan->update($data);

        // LOG
        $message    = $this->session->userdata('user_name') . " mengubah data panduan dengan ID = " . $data['panduan_id'];
        createLog($message);

        // ALERT
        $alertStatus  = "success";
        $alertMessage = "Berhasil mengubah data panduan : ";
        getAlert($alertStatus, $alertMessage);

        redirect('admin/panduan');
    }


    public function delete()
    {
        csrfValidate();
        // POST
        $this->m_panduan->delete($this->input->post('panduan_id'));

        // LOG
        $message    = $this->session->userdata('user_name') . " menghapus data panduan dengan ID = " . $this->input->post('panduan_id') . $this->input->post('panduan_name');
        createLog($message);

        // ALERT
        $alertStatus  = "failed";
        $alertMessage = "Menghapus data panduan : " . $this->input->post('panduan_name');
        getAlert($alertStatus, $alertMessage);

        redirect('admin/panduan');
    }
}
