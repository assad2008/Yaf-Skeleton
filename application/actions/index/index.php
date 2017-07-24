<?php

final class IndexAction extends ActionBase
{

    public function _exe()
    {
        $user = User::find(1)->toArray();
        $this->view->assign("user", $user);
        $this->view->assign("helo", "hello world");
        $this->view->display("index_index.html");
    }
}
