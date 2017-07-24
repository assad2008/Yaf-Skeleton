<?php

final class Action_Index extends ActionBase
{

    public function _exe()
    {
        $this->view->assign("helo", "hello world");
        $this->view->display("index_index.html");
    }
}
