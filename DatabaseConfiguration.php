<?php
	
	Class DatabaseConfiguration
	{
		// data members //
		public $connection;
		private $servertype = "localhost", $username = "id12522521_root", $password = "1234567890", $database = "id12522521_blogpost";
		

		// member functions //
		
			// constructor function //
			public function __construct()
			{	

				$this->connection = mysqli_connect($this->servertype, $this->username, $this->password, $this->database);
					
				$this->connection->set_charset("utf8");
					
				if(!$this->connection)
				{
					echo "<h1>Connection Failed...</h1>";
				}
				
			}
			
			// data insert into database //
			public function query($query)
			{
				$data = mysqli_query($this->connection, $query);
				
				return mysqli_fetch_all($data, MYSQLI_ASSOC);
			}
			
			// data fetch for graphc
			public function query_for_graph($query)
			{
				$data = mysqli_query($this->connection, $query);
				
				return mysqli_fetch_all($data, MYSQLI_NUM);
			}
			
			// data fetch for graphc
			public function query_for_getInfo($query)
			{
				$data = mysqli_query($this->connection, $query);
				
				return mysqli_fetch_all($data, MYSQLI_ASSOC);
			}
			
			// data insert into database //
			public function insert($query)
			{
				
				mysqli_query($this->connection, $query);
				
				
			}
			
			// data insert into database //
			public function getLastRecord($query)
			{
				
				$insert = mysqli_query($this->connection, $query);
				
				 $id = mysqli_insert_id($this->connection);
				 
				 return $id;
				
				
			}

			// data delete into database //
			public function delete_query($query)
			{
				mysqli_query($this->connection, $query);
			}
			
			// data check into database //
			public function account_check($query)
			{
				$query_result = mysqli_query($this->connection, $query);
								
					if(mysqli_num_rows($query_result)>0)
					{
						return 1;
					}
					else
					{
						return 0;
					}

			}
			
			
			// data update into database //
			public function update($query)
			{
					mysqli_query($this->connection, $query);
			}
			

			// developer function //
			public function developer_query($query)
			{
					return mysqli_query($this->connection, $query);
			}
			
			// developer function //
			public function developer_fetch($data)
			{
					return mysqli_fetch_all($data, MYSQLI_ASSOC);
			}
		
			// developer function //
			public function developer_fetch_fields($data)
			{
					
					return mysqli_fetch_fields($data);
			}
			
			// data query_result into database //
			public function query_result($query)
			{
				 return  mysqli_query($this->connection, $query);
				 
				 
			}
			
			
			// data query_result into database //
			public function query_result_fetch($data)
			{
				 return mysqli_fetch_all($data, MYSQLI_ASSOC);
				 
				 
			}
		
			
			public function __destruct()
			{	
				mysqli_close($this->connection);			
			}
		
	}
	
?>	