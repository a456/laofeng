<?php
	/**
	*	数据库操作类
	*	author:黄永杰
	*	date:2017.02.27	
	*/
	class Model
	{
		// 属性
		public $link;	//数据库连接
		public $tabName;//表名
		public $pk;		//主键
		public $Field;	//数据库的字段
		public $where = array();	//保存where条件
		public $order;	//保存排序条件
		public $limit;	//保存分页条件

		// 方法
		/**
		*	构造方法
		*		@param string $tabName 表名
		*/
		public function __construct($tabName)
		{
			$this->link = mysqli_connect(HOST,USER,PASSWORD,DBNAME) or die('数据库连接失败');
			mysqli_set_charset($this->link,'utf8');
			$this->tabName = $tabName;
			// 初始化主键
			$this->getFiled();
		}

		public function getFiled()
		{
			$sql = "DESC {$this->tabName}";
			$res = mysqli_query($this->link,$sql);
			while($rows = mysqli_fetch_assoc($res)){
				if($rows['Key'] == 'PRI'){
					$this->pk = $rows['Field'];
				}
				$arr[] = $rows['Field'];
			}
			$this->Field = $arr;
		}

		/**
		*	单条查询
		*/
		public function find($id)
		{
			$sql = "SELECT * FROM {$this->tabName} WHERE {$this->pk}={$id}";
			$res = mysqli_query($this->link,$sql);
			$data = mysqli_fetch_assoc($res);
			return $data;
		}

		/**
		*	查询方法
		*/ 
		public function select()
		{
			$sql = "SELECT * FROM {$this->tabName}";
			//判断是否有where条件查询
			if(count($this->where)>0){
				// SELECT * FROM user where id=10 and name="zhang3";
				$sql .= " WHERE ".implode(' and ',$this->where);
			}
			// 判断是否有排序条件查询
			if(!empty($this->order)){
				$sql .= " ORDER BY ".$this->order;
			}
			if(!empty($this->limit)){
				$sql .= " limit ".$this->limit;
			}

			// var_dump($sql);die;
			$res = mysqli_query($this->link,$sql);
			$data = array();
			while($rows = mysqli_fetch_assoc($res)){
				$data[] = $rows;
			}
			// 释放结果集
			mysqli_free_result($res);
			return $data;
		}

		/**
		*	添加方法
		*	
		*/
		public function insert($data)
		{
			// 定义空数组来保存要添加的字段
			$fields = array();
			$values = array();
			foreach ($data as $k => $v) {
				if(in_array($k,$this->Field) && $k != $this->pk){
					$fields[] = $k;
					$values[] = $v;
				}
			}
			// var_dump($fields);
			// var_dump($values);
			// die;
			// zhang3,18,1
			$sql = "INSERT INTO {$this->tabName}(".implode(',',$fields).") VALUES('".implode("','",$values)."')";
			$res = mysqli_query($this->link,$sql);
			//获取最后添加的那条数据的id
			return mysqli_insert_id($this->link);
		}

		/**
		*	修改方法
		*		
		*/
		public function update($data)
		{
			$str = '';
			// 遍历所有你要修改的数据
			foreach ($data as $k => $v) {
				if(in_array($k,$this->Field) && $k != $this->pk){
					$str .= "{$k} = '{$v}',";
				}
			}
			// 干掉最右边多余的,
			$str = rtrim($str,',');
			$sql = "UPDATE {$this->tabName} SET ".$str." WHERE {$this->pk}=".$data["{$this->pk}"];
			// echo $sql;
			$res = mysqli_query($this->link,$sql);
			return mysqli_affected_rows($this->link);
			
		}

		/**
		*	删除方法
		*		@param int $id 主键的值
		*/
		public function del($id)
		{
			$sql = "DELETE FROM {$this->tabName} WHERE {$this->pk}={$id}";
			mysqli_query($this->link,$sql);
			// 返回影响行数
			return mysqli_affected_rows($this->link);
		}

		/**
		*	where方法
		*/
		public function where($where)
		{
			$this->where[] = $where;
			return $this;
		}

		/**
		*	limit方法
		*/
		public function limit($m,$n=0)
		{
			if($n == 0){
				$this->limit = $m;
			}else{
				$this->limit = "{$m},{$n}";
			}
			return $this;
		}

		/**
		*	order方法
		*/
		public function order($order)
		{
			$this->order = $order;
			return $this;
		}


		/**
		*	析构方法
		*/ 
		public function __destruct()
		{
			mysqli_close($this->link);
		}
	}


