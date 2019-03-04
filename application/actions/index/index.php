<?php

final class IndexAction extends ActionBase {

	public function _exe() {
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
