<?php
class User_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function get_users($slug = FALSE)
        {
                if ($slug === FALSE)
                {
                        $query = $this->db->get('users');
                        return $query->result_array();
                }

                $query = $this->db->get_where('users', array('slug' => $slug));
                return $query->row_array();
        }

        public function set_users()
        {
                $this->load->helper('url');

                $slug = url_title($this->input->post('username'), 'dash', TRUE);

                $data = array(
                        'username' => $this->input->post('username'),
                        'email' => $this->input->post('email'),
                        'slug' => $slug                        
                );

                return $this->db->insert('users', $data);
        }
}