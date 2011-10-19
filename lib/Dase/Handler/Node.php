<?php

class Dase_Handler_Node extends Dase_Handler
{
		public $resource_map = array(
				'select_list' => 'select_list',
				'{name}' => 'node',
				'thumb/{name}' => 'thumbnail',
				'{id}/edit' => 'node_form',
				'{id}/swap' => 'swap_file',
				'{id}/alias' => 'node_alias',
				'{id}/attvals' => 'node_attvals',
				'{id}/attachments' => 'attachments',
				'{id}/{att}' => 'node_field',
		);

		protected function setup($r)
		{
				//$this->user = $r->getUser();
		}

		private function _findNextUnique($base_dir,$basename,$ext,$iter=0)
		{
				if ($iter) {
						$checkname = $basename.'_'.$iter.'.'.$ext;
				} else {
						$checkname = $basename.'.'.$ext;
				}
				if (!file_exists($base_dir.'/'.$checkname)) {
						return $checkname;
				} else {
						$iter++;
						return $this->_findNextUnique($base_dir,$basename,$ext,$iter);
				}

		}

		private function _findNextUniqueAttachmentName($name,$node,$iter=0)
		{
				if (!$name) { return; }
				if ($iter) {
						$check = $name.'_'.$iter;
				} else {
						$check = $name;
				}
				$at = new Dase_DBO_Attachment($this->db);
				$at->node_id = $node->id;
				$at->name = $check;
				if (!$at->findOne()) {
						return $check;
				} else {
						$iter++;
						return $this->_findNextUniqueAttachmentName($check,$node,$iter);
				}
		}

		private function _findNextUniqueAlias($alias,$orig_node,$iter=0)
		{
				if (!$alias) { return; }
				if ($iter) {
						$checkalias = $alias.'_'.$iter;
				} else {
						$checkalias = $alias;
				}
				$node = new Dase_DBO_Node($this->db);
				$node->alias = $checkalias;
				if (!$node->findOne() || $node->id == $orig_node->id ) {
						return $checkalias;
				} else {
						$iter++;
						return $this->_findNextUniqueAlias($alias,$orig_node,$iter);
				}
		}

		public function getSelectList($r) 
		{
				$output = '';
				$nodes = new Dase_DBO_Node($this->db);
				foreach ($nodes->findAll(1) as $node) {
						$output .= "<option value='$node->id'>Node: $node->name</option>";
				}
				$r->renderResponse($output);
		}

		private function _findNextUniqueNodesetAscii($ascii,$node,$iter=0)
		{
				if (!$ascii) { return; }
				if ($iter) {
						$check = $ascii.'_'.$iter;
				} else {
						$check = $ascii;
				}
				$a = new Dase_DBO_Nodeset($this->db);
				$a->ascii_id = $ascii;
				$a->node_id = $node->id;
				if (!$a->findOne()) {
						return $check;
				} else {
						$iter++;
						return $this->_findNextUniqueNodesetAscii($ascii,$node,$iter);
				}
		}

		public function postToNodeAttvals($r)
		{
				//print_r($_POST); exit;
				$this->user = $r->getUser();
				$id = $r->get('id'); 
				$node = new Dase_DBO_Node($this->db);
				$node = $node->load($id);
				if (!$node) { 
						$r->renderError(404); 
				}
				if (($this->user->eid != $node->created_by) || !$this->user->is_admin) {
						$r->renderError(401);
				}
				$attval = new Dase_DBO_Attval($this->db);
				$attval->node_id = $node->id;
				$attval->att_ascii = $r->get('att_ascii');
				$attval->value = $r->get('value');
				if (!$attval->value && 0 !== $attval->value) {
						$attval->value = $r->get('defined_value');
				}
				if ($attval->value) {
						$attval->insert();
				}
				$r->renderRedirect("node/$node->id/attvals");
		}

		public function postToNodeAlias($r) 
		{
				$this->user = $r->getUser();
				$id = $r->get('id'); 
				$node = new Dase_DBO_Node($this->db);
				$node = $node->load($id);
				if (!$node) { 
						$r->renderError(404); 
				}
				if (($this->user->eid != $node->created_by) || !$this->user->is_admin) {
						$r->renderError(401);
				}
				$alias = $this->_findNextUniqueAlias($r->get('alias'),$node);
				$node->alias = $alias;
				$node->update();
				$r->renderOk('success');
		}

		public function postToNodeField($r) 
		{
				$this->user = $r->getUser();
				$id = $r->get('id'); 
				$node = new Dase_DBO_Node($this->db);
				$node = $node->load($id);
				if (!$node) { 
						$r->renderError(404); 
				}
				if (($this->user->eid != $node->created_by) || !$this->user->is_admin) {
						$r->renderError(401);
				}
				$att = $r->get('att');
				if ($node->hasMember($att)) {
						$node->$att = trim($r->get($att));
						if ($node->$att) {
								$node->update();
						}
				}
				$r->renderOk('success');
		}

		public function postToSwapFile($r)
		{
				$this->user = $r->getUser();
				$id = $r->get('id'); 
				$node = new Dase_DBO_Node($this->db);
				$node = $node->load($id);
				if (!$node) { 
						$r->renderError(404); 
				}

				if (($this->user->eid != $node->created_by) || !$this->user->is_admin) {
						$r->renderError(401);
				}

				$file = $r->_files['uploaded_file'];
				if ($file && is_file($file['tmp_name'])) {
						$name = $file['name'];
						$path = $file['tmp_name'];
						$type = $file['type'];
						if (!is_uploaded_file($path)) {
								$r->renderError(400,'no go upload');
						}
				} else {
						$r->renderError(400);
				}
				if (!isset(Dase_File::$types_map[$type])) {
						$r->renderError(415,'unsupported media type: '.$type);
				}

				$base_dir = $this->config->getAppSettings('media_dir');

				if (!file_exists($base_dir) || !is_writeable($base_dir)) {
						$r->renderError(403,'not allowed');
				}

				$ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
				$basename = Dase_Util::dirify(pathinfo($name,PATHINFO_FILENAME));

				if ('application/pdf' == $type) {
						$ext = 'pdf';
				}
				if ('application/msword' == $type) {
						$ext = 'doc';
				}
				if ('application/vnd.openxmlformats-officedocument.wordprocessingml.document' == $type) {
						$ext = 'docx';
				}

				@unlink($node->thumbnail_path);
				@unlink($node->filepath);

				$newname = $this->_findNextUnique($base_dir,$basename,$ext);
				$new_path = $base_dir.'/'.$newname;
				rename($path,$new_path);
				chmod($new_path,0775);

				$parts = explode('/',$type);
				if (isset($parts[0]) && 'image' == $parts[0]) {
						$thumb_path = $base_dir.'/thumb/'.$newname;
						$thumb_path = str_replace('.'.$ext,'.jpg',$thumb_path);
						$command = CONVERT." \"$new_path\" -format jpeg -resize '100x100 >' -colorspace RGB $thumb_path";
						$exec_output = array();
						$results = exec($command,$exec_output);
						if (!file_exists($thumbnail)) {
								//Dase_Log::info(LOG_FILE,"failed to write $thumbnail");
						}
						chmod($thumb_path,0775);
						$newname = str_replace('.'.$ext,'.jpg',$newname);
						$node->thumbnail_path = $thumb_path;
						$node->thumbnail_url = 'node/thumb/'.$newname;
				} else {
						$node->thumbnail_url = 	'www/images/mime_icons/'.Dase_File::$types_map[$type]['size'].'.png';
				}

				$size = @getimagesize($new_path);
				$node->name = $newname;
				$node->filepath = $new_path;
				$node->filesize = filesize($new_path);
				$node->mime = $type;
				if (isset($size[0]) && $size[0]) {
						$node->width = $size[0];
				}
				if (isset($size[1]) && $size[1]) {
						$node->height = $size[1];
				}
				$node->updated_by = $this->user->eid;
				$node->updated = date(DATE_ATOM);
				$node->update();

				$r->renderRedirect('node/'.$node->id.'/edit');

		}

		public function getNodeForm($r) { 
				$this->user = $r->getUser();
				$id = $r->get('id'); 
				$node = new Dase_DBO_Node($this->db);
				$node = $node->load($id);
				if (!$node) { 
						$r->renderError(404); 
				}
				if (($this->user->eid != $node->created_by) || !$this->user->is_admin) {
						$r->renderError(401);
				}
				$t = new Dase_Template($r);
				$t->assign('node', $node);
				$r->renderResponse($t->fetch('edit_node_form.tpl'));
		}

		public function getAttachments($r) { 
				$this->user = $r->getUser();
				$id = $r->get('id'); 
				$node = new Dase_DBO_Node($this->db);
				$node = $node->load($id);
				if (!$node) { 
						$r->renderError(404); 
				}
				if (($this->user->eid != $node->created_by) || !$this->user->is_admin) {
						$r->renderError(401);
				}
				$node->getAttachments();
				$t = new Dase_Template($r);
				$t->assign('node', $node);
				$r->renderResponse($t->fetch('edit_node_attachments.tpl'));
		}

		public function postToAttachments($r)
		{
				$this->user = $r->getUser();
				$id = $r->get('id'); 
				$node = new Dase_DBO_Node($this->db);
				$node = $node->load($id);
				if (!$node) { 
						$r->renderError(404); 
				}
				if (($this->user->eid != $node->created_by) || !$this->user->is_admin) {
						$r->renderError(401);
				}
				$at = new Dase_DBO_Attachment($this->db);
				$at->name = $r->get('name');
				$at->node_id = $node->id;
				$at->child_id = $r->get('child_id');
				$at->child_type = $r->get('child_type');
				$at->child_name = $r->get('child_name');
				if (!$at->name) {
						$params['msg'] = 'name your attachment please!';
						$r->renderRedirect('node/'.$node->id.'/attachments',$params);
				}
				$at->name = $this->_findNextUniqueAttachmentName($at->name,$node,$iter);
				if (!$at->child_id && 'url' == $at->child_type) {
						$at->insert();
				}
				if (!$at->child_name && $at->child_id && $at->child_type) {
						if ('node' == $at->child_type) {
								$child_node = new Dase_DBO_Node($this->db);
								$child_node->load($at->child_id);
								$at->child_name = $child_node->name;
						}
						if ('nodeset' == $at->child_type) {
								$nodeset = new Dase_DBO_Nodeset($this->db);
								$nodeset->load($at->child_id);
								$at->child_name = $nodeset->name;
						}
						$at->insert();
				}
				$r->renderRedirect('node/'.$node->id.'/attachments');
		}

		public function getNodeAttvals($r) { 
				$this->user = $r->getUser();
				$id = $r->get('id'); 
				$node = new Dase_DBO_Node($this->db);
				$node = $node->load($id);
				if (!$node) { 
						$r->renderError(404); 
				}
				if (($this->user->eid != $node->created_by) || !$this->user->is_admin) {
						$r->renderError(401);
				}
				$atts = new Dase_DBO_Attribute($this->db);
				$atts->orderBy('name');
				$node->getAttvals();
				$t = new Dase_Template($r);
				$t->assign('atts', $atts->findAll(1));
				$t->assign('node', $node);
				if ('image' == substr($node->mime,0,5)) {
						$t->assign('is_image',1);
				}
				$r->renderResponse($t->fetch('edit_node_attvals.tpl'));
		}

		public function getNode($r) { 
				//no file extension assume it is an id
				$name = $r->get('name'); 
				$node = new Dase_DBO_Node($this->db);
				if (is_numeric($name)) {
						$node = $node->load($name);
				} else {
						$node->name = $name;
						$node = $node->findOne();
				}
				if (!$node) { 
						$r->renderError(404); 
				}
				$node->getAttvals();
				$t = new Dase_Template($r);
				$t->assign('node', $node);
				if ('image' == substr($node->mime,0,5)) {
						$t->assign('is_image',1);
				}
				$r->renderResponse($t->fetch('node.tpl'));
		}

		public function getNodeJson($r) { 
				$name = $r->get('name'); 
				$node = new Dase_DBO_Node($this->db);
				if (is_numeric($name)) {
						$node = $node->load($name);
				} else {
						$node->name = $name;
						$node = $node->findOne();
				}
				if (!$node) { 
						$r->renderError(404); 
				}

				$node->getAttvals();
				$node->getAttachments();

				if (!$node) { 
						$r->renderError(404); 
				}
				$r->renderResponse($node->asJson($r));
		}

		public function getNodeJpg($r) { $this->_getNode($r); }
		public function getNodeGif($r) { $this->_getNode($r); }
		public function getNodePng($r) { $this->_getNode($r); }
		public function getNodePdf($r) { $this->_getNode($r); }
		public function getNodeTxt($r) { $this->_getNode($r); }
		public function getNodeMp3($r) { $this->_getNode($r); }

		public function _getNode($r) 
		{
				$path = $this->config->getAppSettings('media_dir').'/'.$r->get('name').'.'.$r->format;
				$r->serveFile($path,$r->response_mime_type);
		}

		public function getThumbnailJpg($r) 
		{
				$path = $this->config->getAppSettings('media_dir').'/thumb/'.$r->get('name').'.jpg';
				$r->serveFile($path,$r->response_mime_type);
		}
}

