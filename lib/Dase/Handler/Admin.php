<?php

class Dase_Handler_Admin extends Dase_Handler
{
		public $resource_map = array(
				'/' => 'admin',
				'users' => 'users',
				'add_user_form/{eid}' => 'add_user_form',
				'user/{id}/is_admin' => 'is_admin',
				'upload/files' => 'files',
				'upload' => 'upload_form',
				'create' => 'content_form',
				'files' => 'files',
				'attributes' => 'attributes',
		);

		protected function setup($r)
		{
				$this->user = $r->getUser();
				if ($this->user->is_admin) {
						//ok
				} else {
						$r->renderError(401);
				}
		}

		private function _findNextUniqueAttAscii($ascii_id,$orig_att,$iter=0)
		{
				if (!$ascii_id) { return; }
				if ($iter) {
						$checkatt = $ascii_id.'_'.$iter;
				} else {
						$checkatt = $ascii_id;
				}
				$att = new Dase_DBO_Attribute($this->db);
				$att->ascii_id = $checkatt;
				if (!$att->findOne() || $att->id == $orig_att->id ) {
						return $checkatt;
				} else {
						$iter++;
						return $this->_findNextUniqueAttAscii($ascii_id,$orig_att,$iter);
				}

		}

		public function getAdmin($r) 
		{
				$t = new Dase_Template($r);
				$r->renderResponse($t->fetch('admin.tpl'));
		}

		public function postToContentForm($r)
		{
				$node = new Dase_DBO_Node($this->db);
				$node->body = $r->get('body');
				$node->title = $r->get('title');
				if (!$node->title) {
						$params['msg'] = 'title is required';
						$r->renderRedirect('admin/create',$params);
				}
				$node->name = $this->_findUniqueName(Dase_Util::dirify($node->title));
				$node->thumbnail_url = 	'www/images/mime_icons/content.png';
				$node->created_by = $this->user->eid;
				$node->created = date(DATE_ATOM);
				$node->updated_by = $this->user->eid;
				$node->updated = date(DATE_ATOM);
				$node->insert();
				$r->renderRedirect('admin/create');
		}

		public function getAttributes($r)
		{
				$t = new Dase_Template($r);
				$atts = new Dase_DBO_Attribute($this->db);
				$atts->orderBy('name');
				$t->assign('atts',$atts->findAll(1));
				$r->renderResponse($t->fetch('admin_attributes.tpl'));
		}

		public function postToattributes($r)
		{
				$att = new Dase_DBO_Attribute($this->db);
				$name = $r->get('name');
				$def = $r->get('defined');
				if ($def) {
						$set = array();
						foreach (explode("\n",$def) as $d) {
								$d = trim($d);
								if ($d) { $set[] = $d; }
						}
						$att->defined_values = Dase_Json::get($set);
				}
				$att->name = $name;
				$att->ascii_id = $this->_findNextUniqueAttAscii(Dase_Util::dirify($name),$att);
				$att->insert();
				$r->renderRedirect('admin/attributes');
		}

		public function getContentForm($r) 
		{
				$t = new Dase_Template($r);
				$nodes = new Dase_DBO_Node($this->db);
				$nodes->orderBy('updated DESC');
				$t->assign('nodes',$nodes->findAll(1));
				$r->renderResponse($t->fetch('admin_create_content.tpl'));
		}

		public function getUploadForm($r) 
		{
				$t = new Dase_Template($r);
				$files = new Dase_DBO_Node($this->db);
				$files->orderBy('updated DESC');
				//$files->addWhere('filesize',0,'>');
				$t->assign('files',$files->findAll(1));
				$r->renderResponse($t->fetch('admin_upload.tpl'));
		}

		/*
		private function _getLinkTitle($url) 
		{
				$input = @file_get_contents(trim($url));
				$regexp = "<title>(.*)<\/title>";
				$matches = array();
				if(preg_match("/$regexp/siU", $input, $matches)) {
						return $matches[1];
				} else {
						return $url;
				}
		}
		 */

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

		private function _findUniqueName($name,$iter=0)
		{
				if ($iter) {
						$checkname = $name.'_'.$iter;
				} else {
						$checkname = $name;
				}
				$node = new Dase_DBO_Node($this->db);
				$node->name = $checkname;
				if (!$node->findOne()) {
						return $checkname;
				} else {
						$iter++;
						return $this->_findUniqueName($name,$iter);
				}
		}

		public function postToFiles($r)
		{
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

				$newname = $this->_findNextUnique($base_dir,$basename,$ext);
				$new_path = $base_dir.'/'.$newname;
				rename($path,$new_path);
				chmod($new_path,0775);
				$size = @getimagesize($new_path);
				$file = new Dase_DBO_Node($this->db);
				$file->name = $newname;
				$file->filepath = $new_path;
				$file->filesize = filesize($new_path);
				$file->mime = $type;

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
						$file->thumbnail_path = $thumb_path;
						$file->thumbnail_url = 'node/thumb/'.$newname;
				} else {
						$file->thumbnail_url = 	'www/images/mime_icons/'.Dase_File::$types_map[$type]['size'].'.png';
				}
				if (isset($size[0]) && $size[0]) {
						$file->width = $size[0];
				}
				if (isset($size[1]) && $size[1]) {
						$file->height = $size[1];
				}
				$file->created_by = $this->user->eid;
				$file->created = date(DATE_ATOM);
				$file->updated_by = $this->user->eid;
				$file->updated = date(DATE_ATOM);
				$file->insert();

				$r->renderRedirect('admin/upload');

		}

		public function getUsers($r) 
		{
				$t = new Dase_Template($r);
				$users = new Dase_DBO_User($this->db);
				$users->orderBy('name');
				$t->assign('users', $users->findAll(1));
				$r->renderResponse($t->fetch('admin_users.tpl'));
		}

		public function getAddUserForm($r) 
		{
				$t = new Dase_Template($r);
				$record = Utlookup::getRecord($r->get('eid'));
				$u = new Dase_DBO_User($this->db);
				$u->eid = $r->get('eid');
				if ($u->findOne()) {
						$t->assign('user',$u);
				}
				$t->assign('record',$record);
				$r->renderResponse($t->fetch('add_user_form.tpl'));
		}

		public function postToUsers($r)
		{
				$record = Utlookup::getRecord($r->get('eid'));
				$user = new Dase_DBO_User($this->db);
				$user->eid = $record['eid'];
				if (!$user->findOne()) {
						$user->name = $record['name'];
						$user->email = $record['email'];
						$user->insert();
				} else {
						//$user->update();
				}
				$r->renderRedirect('admin');

		}

		public function deleteIsAdmin($r) 
		{
				$user = new Dase_DBO_User($this->db);
				$user->load($r->get('id'));
				$user->is_admin = 0;
				$user->update();
				$r->renderResponse('deleted privileges');
		}

		public function putIsAdmin($r) 
		{
				$user = new Dase_DBO_User($this->db);
				$user->load($r->get('id'));
				$user->is_admin = 1;
				$user->update();
				$r->renderResponse('added privileges');
		}


}

