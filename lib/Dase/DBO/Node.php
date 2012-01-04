<?php

require_once 'Dase/DBO/Autogen/Node.php';

class Dase_DBO_Node extends Dase_DBO_Autogen_Node 
{
		public $attvals = array();
		public $meta = array();
		public $attachments = array();
		public $request_vars = array();

		//NOTE: need to document diallowed metadata attribute names:
		// all fields on node AND 'meta','size'....

		public static function getByIds($db,$id_array)
		{
				$sample_node = new Dase_DBO_Node($db);
				$list = implode(',',$id_array);
				$sql = "SELECT * FROM node WHERE id in ($list)";
				$dbh = $db->getDbh();
				$sth = $dbh->prepare( $sql );
				$sth->setFetchMode(PDO::FETCH_INTO,$sample_node);
				$sth->execute();
				$set = array();
				foreach ($sth as $it) {
						$set[$it->id] = clone($it);
				}
				return $set;
		}

		public function __get($key)
		{
				if ('size' == $key) {
						if (!$this->filesize) {
								return;
						}
						if ($this->filesize < 1024) {
								$size = $this->filesize;
								return $size.'b';
						}
						if ($this->filesize/1024 < 1024) {
								$size = round($this->filesize/1024);
								return $size.'Kb';
						}
						$size = round($this->filesize/(1024*1024),2);
						return $size.'Mb';

				}
				//only works w/ actual nodes NOT stdClass (node->toPhp)
				if (isset($this->meta[$key]) && isset($this->meta[$key][0])) {
						return $this->meta[$key][0];
				}
				if ('is_image' == $key) {
						if ('image' == substr($this->mime,0,5)) {
								return true;
						} else {
								return false;
						}
				}
				return parent::__get($key);
		}

		public function runHook(&$request,&$template) 
		{
				if ($this->hook) {
						$class = Dase_Util::camelize($this->hook);
						if (class_exists($class)) {
								$class::run($request,$template,$this);
						}
				}
		}

		public static function nodeMultiSort($node_set,$field)
		{
				if (!is_array($field)) {    //if the field is given as a string, assume ascending
						$field = array($field=>true);
				}
				usort($node_set, function($a, $b) use($field) {
						$retval = 0;
						foreach ($field as $fieldname=>$desc) {
								if ($retval == 0) {
										$retval = strnatcmp($a->$fieldname, $b->$fieldname);
										if($desc) $retval *= -1;    //if
								}
						}
						return $retval;
				});
				return $node_set;
		}	

		public function setRequestVar($key,$val)
		{
				$this->request_vars[$key] = $val;
		}

		public function getRequestVar($key)
		{
				if (isset($this->request_vars[$key])) {
						return $this->request_vars[$key];
				} else {
						return false;
				}
		}

		public function expunge()
		{
				foreach ($this->getAttvals() as $av) {
						$av->delete();
				}
				foreach ($this->getAttachments() as $at) {
						$at->delete();
				}
				if ($this->delete()) {
						return true;
				}
		}

		public function getAttvals()
		{
				$attvals = new Dase_DBO_Attval($this->db);
				$attvals->node_id = $this->id;
				$this->attvals = $attvals->findAll(1);
				$meta = array();
				//for nodeset sorting
				foreach ($this->attvals as $attval) {
						if (!isset($meta[$attval->att_ascii])) {
								$meta[$attval->att_ascii] = array();
						}
						$meta[$attval->att_ascii][] = $attval->value;
				}
				$this->meta = $meta;
				return $this->attvals;
		}

		public function getAttachments()
		{
				$ats = new Dase_DBO_Attachment($this->db);
				$ats->node_id = $this->id;
				foreach ($ats->findAll(1) as $at) {
						//$at->retrieveNodes($this);
						$this->attachments[$at->name] = $at;
				}
				return $this->attachments;
		}

		public function asJson($r)
		{
				return Dase_Json::get($this->asPhp($r));
		}

		public function asPhp($r,$get_attachments = true)
		{
				$obj = new Dase_Node($this);
				$meta = array();
				foreach ($this->getAttvals() as $attval) {
						if (!isset($meta[$attval->att_ascii])) {
								$meta[$attval->att_ascii] = array();
						}
						$meta[$attval->att_ascii][] = $attval->value;
				}
				$obj->meta = $meta;

				if ($get_attachments) {
						$attachments = array();
						foreach ($this->getAttachments($r) as $at) {
								if ('url' == $at->child_type) {
										$attachments[$at->name] = array('url' => $at->name);
								}
								if ('node' == $at->child_type) {
										$node = new Dase_DBO_Node($this->db);
										$node->load($at->child_id);
										$attachments[$at->name] = $node->asPhp($r,false);
								}
								if ('nodeset' == $at->child_type) {
										$nodeset = new Dase_DBO_Nodeset($this->db);
										$nodeset->load($at->child_id);
										$attachments[$at->name]['name'] = $nodeset->ascii_id;
										$attachments[$at->name]['items'] = $nodeset->asPhp($r);
								}
						}
						$obj->attachments = $attachments;
						//also direct accessors
						foreach ($attachments as $k => $v) {
								if (!isset($obj->$k)) {
										$obj->$k = $v;
								}
						}
				}
				return $obj;
		}
}
