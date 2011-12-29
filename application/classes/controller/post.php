<?php

defined('SYSPATH') OR exit('No direct script access.');

class Controller_Post extends Controller_Application
{

    public function before()
    {
        parent::before();
        $this->check_access('wall', 'view');
    }

    /* public function action_post()
      {
      $id = $this->request->param('id');
      empty($id) AND $this->request->redirect(URL::base());

      $sql = "
      SELECT
      posts.*,
      `users`.`first_name`,
      `users`.`last_name`,
      `users`.`username`,
      `users`.`id` AS `user_id`,
      (SELECT
      COUNT(id)
      FROM
      comments
      WHERE
      post_id = posts.id)
      AS
      total_comments
      FROM
      `posts`
      JOIN
      `users`
      ON
      (`posts`.`user_id` = `users`.`id`)
      WHERE
      posts.id = ".$id."
      ";
      $post = $this->db->query(Database::SELECT, $sql)->as_array();
      empty($post) AND $this->request->redirect(URL::base());

      $this->template->content = View::factory('post');
      $this->template->content->post = $post[0];
      } */

    public function action_delete()
    {
        $this->check_access('wall', 'delete');
        $id = $this->request->param('id');
        $query = DB::delete('posts')->where('id', '=', $id)->execute();
        $this->request->redirect(URL::base());
    }

    public function action_new()
    {
        $this->check_access('wall', 'add');
        //$query = DB::insert('posts', array('title', 'body', 'type', 'user_id', 'attachment_url', 'published_at'))
        //->values(array('fred', 'p@5sW0Rd'));
        switch ($this->request->param('id'))
        {
            case 'text':
                $columns = array
                    (
                    'title',
                    'body',
                    'type',
                    'user_id',
                    'attachment_url',
                    'published_at'
                );
                $values = array
                    (
                    $_POST['text_title'],
                    $_POST['text_body'],
                    'text',
                    $_SESSION['userid'],
                    NULL,
                    date("Y-m-d H:i:s")
                );
                $query = DB::insert('posts', $columns)->values($values)->execute();
                if ($query)
                    $this->request->redirect(URL::base());
                break;
            case 'photo':
                $up = $this->image_upload($_FILES['photo_attachment']);
                if (substr($up, 0, 8) != "uploads/" && $up != NULL)  //return if any errors
                    exit($up);
                $columns = array
                    (
                    'title',
                    'body',
                    'type',
                    'user_id',
                    'attachment_url',
                    'published_at'
                );
                $values = array
                    (
                    $_POST['photo_title'],
                    $_POST['photo_body'],
                    'photo',
                    $_SESSION['userid'],
                    $up,
                    date("Y-m-d H:i:s")
                );
                $query = DB::insert('posts', $columns)->values($values)->execute();
                if ($query)
                    $this->request->redirect(URL::base());
                break;
            case 'video':
                $columns = array
                    (
                    'title',
                    'body',
                    'type',
                    'user_id',
                    'attachment_url',
                    'embed_code',
                    'published_at'
                );
                $values = array
                    (
                    $_POST['video_title'],
                    $_POST['video_body'],
                    'video',
                    $_SESSION['userid'],
                    /* $_POST['photo_attachment'] */ NULL,
                    $this->process_embed_code($_POST['video_embed_code']),
                    date("Y-m-d H:i:s")
                );
                $query = DB::insert('posts', $columns)->values($values)->execute();
                if ($query)
                    $this->request->redirect(URL::base());
                break;
            case 'document':
                $up = $this->document_upload($_FILES['document_attachment']);
                if (substr($up, 0, 8) != "uploads/" && $up != NULL)  //return if any errors
                    exit($up);
                $columns = array
                    (
                    'title',
                    'body',
                    'type',
                    'user_id',
                    'attachment_url',
                    'published_at'
                );
                $values = array
                    (
                    $_POST['document_title'],
                    $_POST['document_body'],
                    'document',
                    $_SESSION['userid'],
                    $up,
                    date("Y-m-d H:i:s")
                );
                $query = DB::insert('posts', $columns)->values($values)->execute();
                if ($query)
                    $this->request->redirect(URL::base());
                break;
        }
    }

    private function image_upload($file)
    {
        if (empty($file['size']))
            return FALSE;
        $mimes = array('image/jpeg', 'image/pjpeg', 'image/gif', 'image/png');
        if (!(in_array($file['type'], $mimes) AND ($file['size'] / 1024) < 4092))
            return 'ატვირთული ფაილი არაა სურათი ან მისი ზომა მეტია 2 მბ-ზე.';
        $path = 'uploads/images/';
        $name = substr(sha1(mt_rand() . uniqid('gyla_', TRUE) . time()), 0, 5) . '_' . $file['name'];
        file_exists($path . $name) AND $name = mt_rand() . $name;
        if (!move_uploaded_file($file['tmp_name'], $path . $name))
            return 'Upload failed...';
        return $path . $name;
    }

    private function document_upload($filedata)
    {
        if ($filedata['size'] > 0)
            if (/* ($filedata['type'] == "image/jpeg" || $filedata['type'] == "image/pjpeg" ||
              $filedata['type'] == "image/gif"  || $filedata['type'] == "image/png")  && */
                    $filedata['size'] / 1024 < 4097)
            {
                $path = "uploads/documents/";
                $name = mt_rand(0, 1000) . $filedata['name'];
                if (file_exists($path . $name))
                    $name = mt_rand(0, 1000) . time() . $name;
                $upload = move_uploaded_file($filedata["tmp_name"], $path . $name);
                if (!$upload)
                    return "file is valid but upload failed";
                return $path . $name;
            }
            else
                return "ატვირთული ფაილის ზომა მეტია 4 მბ-ზე";
        else
            return NULL;
    }

    private function process_embed_code($code)
    {
        $hpos1 = strpos($code, "height=");
        $part = substr($code, $hpos1, 12);
        $code = str_replace($part, 'height="160"', $code);

        $wpos1 = strpos($code, "width=");
        $part = substr($code, $wpos1, 11);
        $code = str_replace($part, 'width="250"', $code);

        $hpos2 = strrpos($code, "height=");
        $part = substr($code, $hpos2, 12);
        $code = str_replace($part, 'height="160"', $code);

        $wpos2 = strrpos($code, "width=");
        $part = substr($code, $wpos2, 11);
        $code = str_replace($part, 'width="250"', $code);

        return $code;
    }

}
