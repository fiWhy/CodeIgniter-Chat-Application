<?php

class Communication_Model extends CI_Model {
    
    /**
     * Get dialogue list for user
     * 
     * @return array
     **/
    public function getDialogues($id = null, $sort = 'desc') {
        $db = $this->db;
        $user_id = $this->session->userdata('id');
        $q = "SELECT data.* FROM
                ( SELECT ud.id as ud_id, ud.creation_date as creation_date, um.data as data, um.stamp as stamp, um.status as um_status, u.* FROM `user_dialogues` as ud 
                    inner join `user_dialogues_members` as udm on ud.id = udm.dialogue_id
                    inner join `user_messages` as um on um.dialogue_id = ud.id
                    inner join `user` as u on u.id = um.user_id
                    inner join  `user_message_status` AS ums ON ums.message_id = um.id and ums.user_id = ".$user_id."
                    where udm.user_id = ".$user_id."
                    and udm.status = '1'
                    and (
                                (um.user_id != ums.user_id and um.status = '0' and ums.have_read = '1' and ums.status = '1') || (um.user_id = ums.user_id and um.status = '1') || (um.user_id != ums.user_id and um.status = '1' and ums.status = '1')
                                )                    
                    order by stamp
                                desc
                ) as data
                        group by data.ud_id
                        order by stamp
                        ".$sort;
        
        
        $dialogues = $db->query($q);
        
        
        $d_m = $dialogues->result_array();
        
        foreach($d_m as &$d){
            
            
        $q_m = "SELECT * FROM
                            user as u
                            inner join `user_dialogues_members` as udm on u.id = udm.user_id
                            where u.id != ".$user_id."
                                and udm.dialogue_id = ".$d['ud_id'];
        $um = $this->db->query($q_m);
            
            $d['members'] = $um->result_array();
            $d['msg_status'] = $d['um_status'] == '1'?'обычный':'удалено';
        }
        
        return $d_m;
    }

    /**
     * Get message list for user
     * 
     * @return array
     **/
    public function getDialogueMessages($dialogue_id) {
        $db = $this->db;
        $q = "select *, um.id as um_id, um.status as um_status
                from `user_dialogues` as ud
                inner join `user_messages` as um on um.dialogue_id = ud.id
                inner join `user` as u on u.id = um.user_id
                inner join `user_message_status` as ums on ums.message_id = um.id
                where ud.id = ".$dialogue_id."
                     and ums.user_id = ".$this->session->userdata('id')."
							and (
                                (um.user_id != ums.user_id and um.status = '0' and ums.have_read = '1'  and ums.status = '1') || (um.user_id = ums.user_id and um.status = '1') || (um.user_id != ums.user_id and um.status = '1' and ums.status = '1')
                                )
                order by stamp
                asc";
        $dialogues = $db->query($q);
        $d_m = $dialogues->result_array();
        foreach($d_m as &$d){
            $d['msg_status'] = $d['um_status'] == '1'?'обычный':'удалено';
        }
        
        return $d_m;
    }
    
    /**
     * Delete dialogue
     * 
     * @return boolean
     **/
    public function deleteDialogue($id)
    {
        $sender_id = $this->session->userdata('id');
         $q = "update `user_dialogues_members` set status = '0' 
                where user_id = ".$sender_id."
                and dialogue_id = ".intval($id); 
         if($this->db->query($q))
            return true;
         else
            return false;
    }
    
    /**
     * Delete message
     * 
     * @return boolean
     **/
    public function deleteMessage($id)
    {
        $sender_id = $this->session->userdata('id');
    
        $q = "update `user_message_status` set status = '0' 
                where user_id = ".$sender_id."
                and message_id = ".intval($id);
        $q1 = "update `user_messages` set status = '0'
                where user_id = ".$sender_id."
                    and id = ".intval($id);
        
        if($this->db->query($q) and $this->db->query($q1))
            return true;
        else
            return false;
        
    }
    
    /**
     * Send message
     * 
     * @return array
     **/
    public function sendMessage($data) {
        $sender_login = $this->session->userdata('login');
        $user_id = $this->db->query("select id, login from `user` where login = '" . $sender_login . "'")->row();

        $dialogue_members = $this->db->query("select * from `user_dialogues_members` as udm
                                        inner join `user` as u on u.id = udm.user_id
                                        where udm.dialogue_id = " . intval($data['dialogue_id']));
        $in = false;

        foreach ($dialogue_members->result_array() as $user) {
            if ($user['id'] == $user_id->id)
                $in = true;
        }


        if ($in) {
            $data['user_id'] = $user_id->id;
            $data['data'] = htmlspecialchars($data['data']);
            $data['stamp'] = date("Y-m-d H:i:s");
            $data['status'] = '1';

            /**
             * Add message
             */
            $this->db->insert('user_messages', $data);

            $msg_id = $this->db->insert_id();

            /**
             * Add message status
             */
            foreach ($dialogue_members->result() as $user) {
                
                if($user->status == '0'){
                    $this->db->update('user_dialogues_members', array('status'=>'1'), array('user_id' => $user->user_id, 'dialogue_id' => $user->dialogue_id));
                }
                
                $this->db->insert('user_message_status', [
                    'user_id' => $user->id,
                    'message_id' => $msg_id,
                    'have_read' => $user->login == $sender_login ? '1' : '0',
                ]);
            }

            $data['avatar'] = $this->session->userdata('avatar');

            return ['answer' => true, 'data' => $data];
        } else
            return ['answer' => false];
    }

}
