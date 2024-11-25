<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Users_model extends Model {
    public function read(){
        return $this->db->table('jmc_users')->get_all();
    }
    public function create($jmc_last_name, $jmc_first_name, $jmc_email, $jmc_gender, $jmc_address){
        $userdata = array(
            'jmc_last_name' => $jmc_last_name, 
            'jmc_first_name' => $jmc_first_name, 
            'jmc_email' => $jmc_email, 
            'jmc_gender' => $jmc_gender, 
            'jmc_address' => $jmc_address 
        );
        return $this->db->table('jmc_users')->insert($userdata);
    }
    public function get_one($id){
        $result = $this->db->table('jmc_users')->where('id', $id)->get();
        if ($result === false || empty($result)) {
            return false;
        }
        return $result;
    }
    public function update($jmc_last_name, $jmc_first_name, $jmc_email, $jmc_gender, $jmc_address, $id){
        $userdata = array(
            'jmc_last_name' => $jmc_last_name, 
            'jmc_first_name' => $jmc_first_name, 
            'jmc_email' => $jmc_email, 
            'jmc_gender' => $jmc_gender, 
            'jmc_address' => $jmc_address 
        );
        // First check if user exists
        $user = $this->db->table('jmc_users')->where('id', $id)->get();
        if (!$user) {
            return false;
        }
        return $this->db->table('jmc_users')->where('id', $id)->update($userdata);
    }
    public function delete($id){
        return $this->db->table('jmc_users')->where('id', $id)->delete();
    }
}
?>
