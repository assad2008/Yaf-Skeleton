<?php

final class IndexAction extends ActionBase {

	public function _exe() {
		Posts::find(2);
		Posts::find(3);
		Posts::find(4);
		Posts::find(6);
		Posts::find(7);
		Posts::find(10);
		Posts::find(11);
		Posts::find(12);
		$posts = Posts::find(2)->toArray();
		echo '<pre>';
		print_r($posts);

		$starttime = Yaf_Registry::get("starttime");
		echo $starttime;
		echo '<br>';

		$mtime = explode(' ', microtime());
		$endtime = $mtime[1] + $mtime[0];
		echo $endtime;
		echo "<br>";

		echo bcsub($endtime, $starttime, 6);
		exit();
		$this->view->assign("user", $user);
		$this->view->assign("helo", "hello world");
		$this->view->display("index_index.html");
	}
}
