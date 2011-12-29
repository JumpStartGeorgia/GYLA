<?php

defined('SYSPATH') OR exit('No direct script access.');

class Controller_Comment extends Controller_Application
{

    public function before()
    {
        parent::before();
        $this->check_access('wall', 'view');
    }

    public function action_new()
    {
        $this->check_access('wall', 'add_comment');
        $columns = array
            (
            'post_id',
            'body',
            'user_id',
            'published_at'
        );
        $values = array
            (
            $this->request->param('id'),
            $_POST['comment_body'],
            $_SESSION['userid'],
            date("Y-m-d H:i:s")
        );
        $query = DB::insert('comments', $columns)->values($values)->execute();
        if ($query)
            $this->request->redirect(URL::base());
    }

    public function action_ajax_read_comments()
    {
        $post_id = $this->request->param('id');

        $query = DB::select('comments.id', 'first_name', 'last_name', 'user_id', 'body', 'published_at')
                ->from('comments')
                ->join('people')
                ->on('comments.user_id', '=', 'people.id')
                ->where('post_id', '=', $post_id)
                ->order_by('published_at');

        $results = $this->db->query(Database::SELECT, $query)->as_array();
        empty($results) AND $results = array();

        echo View::factory('comments', array(
            'comments' => $results,
            'post_id' => $post_id,
            'allow_delete_comment' => $this->check_access('wall', 'delete_comment', FALSE)
        ));

        exit;
    }

    public function action_ajax_submit_comment()
    {
        $this->check_access('wall', 'add_comment');
        $post_id = $this->request->param('id');

        $columns = array
            (
            'post_id',
            'body',
            'user_id',
            'published_at'
        );
        $values = array
            (
            $post_id,
            $_POST['body'],
            $_SESSION['userid'],
            date("Y-m-d H:i:s")
        );
        $query = DB::insert('comments', $columns)->values($values)->execute();

        if ($query)
            $this->request->redirect(URL::site('comment/ajax_read_comments/' . $post_id));
        else
            echo "შეცდომა!";
    }

    public function action_ajax_delete_comment()
    {
        if (!$this->check_access('wall', 'delete_comment', FALSE))
            exit('access denied');
        $id = $this->request->param('id');
        empty($id) and die('choose a comment to delete');
        $query = DB::delete('comments')->where('id', '=', $id)->execute();
        exit('ok');
    }

}
