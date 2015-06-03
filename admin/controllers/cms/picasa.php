<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Upload_picasa extends CI_Controller
    {
        
        function add_album()
        {
            if ($this->auth->isManager())
            {
                $data = json_decode(file_get_contents('./admin/cache/picasa'), true);
                $this->load->library('picasa');
                $this->picasa->login($data['username'], $data['password']);
                $data['album_id'] = $this->picasa->addAlbum(date('dmYHis'));
                file_put_contents('admin/cache/picasa', json_encode($data));
                die ($data['album_id']);
            }
            die('Bad_request');
        }
        
        function upload()
        {
            if ($this->auth->isManager())
            {
                $url = $this->input->post('image');
                if (preg_match('/^(.+?)(upload\/(.+))/', $url, $matches))
                {
                    $data = json_decode(file_get_contents('admin/cache/picasa'), true);
                    $this->load->library('picasa');
                    $this->picasa->login($data['username'], $data['password']);
                    $this->picasa->setAlbumId($data['album_id']);
                    $url = $this->picasa->upload(urldecode($matches['2']));
                    die(empty($url) ? 'HTTP_ERROR' : $url);
                }
            }
            die('Bad_request');
        }
    }
?>
