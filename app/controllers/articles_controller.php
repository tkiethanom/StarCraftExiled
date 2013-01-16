<?php
class ArticlesController extends AppController{
	var $name = "Articles";
		
	function manage(){
		$this->set("title_for_layout", "Manage Articles");
	}
	
	function add(){
		if($this->_hasPermission("article_admin")){
			$this->set("title_for_layout", "Add Article");
			
			if (!empty($this->data)) {
				if ($this->Article->save($this->data)) {
					$this->Session->setFlash('Article has been saved.', "default", array('class'=>'flash-success'));
					$this->redirect("/home");
					exit;
				}
			}
		}
		else{
			exit;
		}
	}
	
	function edit($article_id = null){
		if($this->_hasPermission("article_admin")){
			$this->set("title_for_layout", "Edit Article");
			$this->Article->id = $article_id;
			if (empty($this->data)) {
				$this->data = $this->Article->read();
			} else {
				if ($this->Article->save($this->data)) {
					$this->Session->setFlash('Article has been updated.', "default", array('class'=>'flash-success'));
					$this->redirect("/home");
					exit;
				}
			}
			$this->set("article_id",$article_id);
		}
		else{
			exit;
		}
	}
}
?>