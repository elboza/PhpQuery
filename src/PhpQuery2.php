<?php
namespace PhpQuery;

class PhpQuery{
	private $doc,$xpath;
	function __construct(){

	}
	private function preprocess($str){
		$list=explode(' ',$str);
		return $list;
	}
	private function get_tag($str){
		if(preg_match('/^\w+/',$str,$matches)){
			return $matches[0];
		}else{
			return '*';
		}
	}
	private function get_id($str){
		if(preg_match('/#\w+/',$str,$matches)){
			return substr($matches[0],1);
		}
		return '';
	}
	private function get_classes($str){
		if(preg_match_all('/(?<=\.)\w+/',$str,$matches)){
			return $matches[0];
		}
		return array();
	}
	private function get_autotags($str){
		if(preg_match_all('/(?<=\[)\w+=?[\"\']?\w+[\"\']?(?=\])/',$str,$matches)){
			return $matches[0];
		}
		return array();
	}
	private function parse_item($str){
		$item=array();
		$item['tag']=$this->get_tag($str);
		$item['id']=$this->get_id($str);
		$item['classes']=$this->get_classes($str);
		$item['autotags']=$this->get_autotags($str);
		return $item;
	}
	private function autotags_to_xpath($autotags){
		$str='';
		foreach($autotags as $a){
			$str .= "[@{$a}]";
		}
		return $str;
	}
	private function class_to_xpath($class){
		$arr=array();
		if(empty($class)) return '';
		foreach($class as $a){
			array_push($arr,"contains(@class,\"{$a}\")");
		}
		return "[" . implode(" and ",$arr) . "]";
	}
	private function id_to_xpath($id){
		if($id==null) return '';
		if($id=='') return '';
		return "[@id=\"{$id}\"]";
	}
	public function to_xpath($item){
		$str="{$item['tag']}";
		$str .= $this->id_to_xpath($item['id']);
		$str .= $this->autotags_to_xpath($item['autotags']);
		$str .= $this->class_to_xpath($item['classes']);
		return $str;
	}
	public function load_str($str){
		$this->doc = new \DOMDocument();
		$internalErrors = libxml_use_internal_errors(true);
		$this->doc->loadHTML($str);
		libxml_use_internal_errors($internalErrors);
		$this->xpath = new \DOMXPath($this->doc);
		//libxml_use_internal_errors($internalErrors);
		//echo $doc->saveHTML(); 
	}
	private function free(){
		$xpath=null;
		$doc=null;
	}
	public function j_to_x($str,$b_rel=false){
		$arr=array();
		foreach($this->preprocess($str) as $a){
			array_push($arr,$this->to_xpath($this->parse_item($a)));
		}
		if($b_rel==false) $rel_str='//'; else $rel_str='';
		return $rel_str . implode("/",$arr);
	}
	public function query($str,$relative_node=null){
		if($relative_node!=null) $b_rel=true; else $b_rel=false;
		if($b_rel) return $this->xpath->query($this->j_to_x($str,$b_rel),$relative_node); 
		return $this->xpath->query($this->j_to_x($str));
	}
	public function xpath($str,$relative_node=null){
		return $this->xpath->query($str,$relative_node);
	}
}
?>
