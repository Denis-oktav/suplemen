<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Kriteria extends CI_Controller {
    
        public function __construct()
        {
            parent::__construct();
            $this->load->library('pagination');
            $this->load->library('form_validation');
            $this->load->model('Kriteria_model');

            if ($this->session->userdata('id_user_level') != "1") {
            ?>
				<script type="text/javascript">
                    alert('Anda tidak berhak mengakses halaman ini!');
                    window.location='<?php echo base_url("Login/home"); ?>'
                </script>
            <?php
			}
        }

        public function index()
        {
            $data['page'] = "Kriteria";
			$data['list'] = $this->Kriteria_model->tampil();
            $this->load->view('kriteria/index', $data);
        }
        
        //menampilkan view create
        public function create()
        {
			$data['page'] = "Kriteria";
            $this->load->view('kriteria/create', $data);
        }

        //menambahkan data ke database
        public function store()
        {
                $data = [
                    'keterangan' => $this->input->post('keterangan'),
                    'kode_kriteria' => $this->input->post('kode_kriteria'),
                    'bobot' => $this->input->post('bobot'),
                    'jenis' => $this->input->post('jenis')
                ];
                
                $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
                $this->form_validation->set_rules('kode_kriteria', 'Kode Kriteria', 'required');
                $this->form_validation->set_rules('bobot', 'Bobot', 'required');
                $this->form_validation->set_rules('jenis', 'Jenis', 'required');
    
                if ($this->form_validation->run() != false) {
                    $a = $this->db->get_where('kriteria', array('kode_kriteria' => $this->input->post('kode_kriteria')))->num_rows();
                    $b = $this->db->get('kriteria')->result();
                    $hasil = 0;
                    foreach($b as $value){
                        $hasil = $hasil + $value->bobot;
                    }
                    if($a > 0){
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">kode kriteria sudah digunakan!</div>');
                        redirect('Kriteria/create');
                    }else if($hasil >= 1){
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Bobot tidak boleh lebih dari 1!,</div>');
                        redirect('Kriteria/create');
                    }else{
                        $result = $this->Kriteria_model->insert($data);

                        if ($result) {
                            $b = $this->db->get('kriteria')->result();
                                $hasil1 = 0;
                                foreach($b as $value){
                                    $hasil1 = $hasil1 + $value->bobot;
                            }
                            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil disimpan! Nilai = '.$hasil1.'</div>');
                            redirect('Kriteria');
                        }
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data gagal disimpan!</div>');
                    redirect('Kriteria/create');
                    
                }
            

        }

        public function edit($id_kriteria)
        {
            $data['page'] = "Kriteria";
			$data['kriteria'] = $this->Kriteria_model->show($id_kriteria);
            $this->load->view('kriteria/edit', $data);
        }
    
        public function update($id_kriteria)
        {
            // TODO: implementasi update data berdasarkan $id_kriteria
            $id_kriteria = $this->input->post('id_kriteria');
            $data = array(
                'keterangan' => $this->input->post('keterangan'),
                'kode_kriteria' => $this->input->post('kode_kriteria'),
                'bobot' => $this->input->post('bobot'),
                'jenis' => $this->input->post('jenis')
            );
            $a = $this->db->get_where('kriteria', array('kode_kriteria ' => $this->input->post('kode_kriteria'), 'id_kriteria !=' => $id_kriteria))->num_rows();
            $b = $this->db->get_where('kriteria', array( 'id_kriteria !=' => $id_kriteria))->result();
            
                    $hasil1 = 0;
                    foreach($b as $value){
                        $hasil1 = $hasil1 + $value->bobot;
                    }
                    $c =$this->input->post('bobot');
                    $hasil = $hasil1 + (float)$c;
                    if($a > 0){
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">kode kriteria sudah digunakan!</div>');
                        redirect('Kriteria/create');
                    }else if($hasil > 1){
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Bobot tidak boleh lebih dari 1! Nilai = '.$hasil.'</div>');
                        redirect('Kriteria/create');
                    }else{
            $this->Kriteria_model->update($id_kriteria, $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diupdate! Nilai = '.$hasil.'</div>');
            redirect('kriteria');
            }
        }
    
        public function destroy($id_kriteria)
        {
            $this->Kriteria_model->delete($id_kriteria);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil dihapus!</div>');
			redirect('kriteria');
        }
    
    }
    