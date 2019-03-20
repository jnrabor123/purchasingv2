<?php

class FDTP_Db
{
	public $database_array;
	public $current_database;
	public function __construct($database_array)
	{
		$this->database_array = $database_array;
		foreach($this->database_array as $key => $row)
		{
			$this->create_property($key);

			global ${$key};
			$this->{$key} = ${$key};
		}
	}

	public function change_database($database)
	{
		$this->current_database = $database;
	}

	public function create_property($name)
	{
		$this->{$name} = "";
	}

	public function set_database($db)
	{
		if($db ==  null)
		{
			$database_con = 'conn';
		}
		else
		{
			$database_con = $db;
		}
		return $database_con;
	}

	public function insert($table, $data, $db = null) 
	{

		$database = $this->set_database($db);
		
		try
		{
			$data_key = array_keys($data);
			$data_val = array_values($data);

			$key = implode(",", $data_key);

			$values = "";
			foreach ($data_val as $row => $value)
			{
			 	$values = $values . "?,";
			}
			$values = rtrim($values, ",");

			$query = "INSERT INTO $table ($key) VALUES ($values);";
			$stmt = $this->{$database}->prepare($query);
			$stmt->execute($data_val);

			return 'success';
		}
		catch (Exception $e)
		{
			return $e;
		}
	}

	public function insert_batch($table, $data, $db = null) 
	{

		try 
		{
			$database = $this->set_database($db);


			$x = 1;
			$key = "";
			$values = '';
			$data_val = [];

			foreach ($data as $row) 
			{
				$temp_values = "(";

				foreach ($row as $prop => $value) 
				{

					if ($x === 1) {
						$key .= $prop . ",";
					}
					array_push($data_val, $value);
					$temp_values .= '?,';

				}

				$x = 0;
				$temp_values = rtrim($temp_values, ",");
				$temp_values .= "),";
				$values .= $temp_values;
			}

			$values = rtrim($values, ",");
			$key 	= rtrim($key, ",");

			$query = "INSERT INTO $table ($key) VALUES $values;";
			$stmt = $this->{$database}->prepare($query);
			$stmt->execute($data_val);
			return 'success';
		} 
		catch (Exception $ex) 
		{
			echo $ex;
		}
	}

	public function update($table, $data, $where, $db = null) 
	{
		$database = $this->set_database($db);

		try
		{
			$data_key = array_keys($data);
			$where_key = array_keys($where);
			$where_val = "";
			$set_val = "";

			// query concatination
			for ($x = 0; $x < count($data_key); $x++)
			{
				$set_val = $set_val . $data_key[$x] . "= ?,";
			}
			$set_val = rtrim($set_val, ",");

			// where concatination
			for ($x = 0; $x < count($where_key); $x++)
			{
				$where_val = $where_val . $where_key[$x] . " ? AND";
			}
			$where_val = rtrim($where_val, "AND");

			// pushing values to array
			$values = [];
			foreach ($data as $row => $value)
			{
				array_push($values, $value);
			}
			// pushing where values to array
			foreach ($where as $key => $value)
			{
				array_push($values, $value);
			}

			$query = "UPDATE {$table} SET {$set_val} WHERE {$where_val}";
			$stmt = $this->{$database}->prepare($query);
			$stmt->execute($values);

			return TRUE;
		}
		catch (Exception $e)
		{
			echo $e;
		}
	}

	public function delete($table, $where, $db = null)
	{
		$database = $this->set_database($db);

		try 
		{
			$where_key = array_keys($where);
			$where_val = "";

			// where concatination
			for ($x = 0; $x < count($where_key); $x++)
			{
				$where_val .= $where_key[$x] . " ? AND";
			}
			$where_val = rtrim($where_val, "AND");

			// pushing values to array
			$values = [];
			foreach ($where as $row => $value)
			{
				array_push($values, $value);
			}

			$query = "DELETE FROM {$table} WHERE {$where_val} ";
			$stmt = $this->{$database}->prepare($query);
			$stmt->execute($values);

			return TRUE;
		} 
		catch (Exception $e) 
		{
			echo $e;
		}
	}
}