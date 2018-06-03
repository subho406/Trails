<?php

		function CaputreFlow($value='')
		{
			if($_POST["flow"])
			{
				$json_flow = $_POST["flow"];

				echo "<h1>Flow Captured!</h1> <br>"; // Success Message
				// var_dump(json_decode($json_flow,true));
				$flow = json_decode($json_flow,true);
				DataEntry($flow);
				// echo "<hr>".$flow[0]['title']."<br>".$flow[0]['url']."<br>".$flow[0]['id'];
						// echo "<hr>".$flow[1]['title']."<br>".$flow[1]['url']."<br>".$flow[1]['id'];
						// echo "<hr>".$flow[2]['title']."<br>".$flow[2]['url']."<br>".$flow[2]['id']."<hr>";		
			}
		}

		function DataEntry($flow)
		{
		// Store the data
			$servername = "localhost";
			$username = "root";
			$password = "test123";
			$dbName = "Trails";

			$conn = new mysqli($servername, $username, $password, $dbName);
			if ($conn->connect_error)
			{
				die("Connection failed: ".$conn->connect_error);
			}

			for ($i=0; $i < 10 ; $i++)
			{
				$id = mysqli_real_escape_string($conn, $flow[$i]['id']);
				$url = mysqli_real_escape_string($conn, $flow[$i]['url']);
				$title= mysqli_real_escape_string($conn, $flow[$i]['title']);
				$lastVisitTime = mysqli_real_escape_string($conn, $flow[$i]['lastVisitTime']);
				$typedCount = mysqli_real_escape_string($conn, $flow[$i]['typedCount']);
				$visitCount = mysqli_real_escape_string($conn, $flow[$i]['visitCount']);

				$sql = "INSERT INTO FlowDB (id, url, title, lastVisitTime, typedCount, visitCount)
				VALUES ('".$id."', '".$url."','".$title."','".$lastVisitTime."','".$typedCount."','".$visitCount."')";

				if ($conn ->query($sql) === TRUE)
				{
					echo "New record created";
				}
				else
				{
					//echo "Error: ".$sql."<br>".$conn->error;
				}
			}

			$conn->close();
		}

		function MapGen()
		{
			$servername = "localhost";
			$username = "root";
			$password = "test123";
			$dbName = "Trails";
			$conn = new mysqli($servername, $username, $password, $dbName);
			if ($conn->connect_error)
			{
				die("Connection failed: ".$conn->connect_error);
			}

			$flowGraph = "dinetwork {Start -> NeuralNetworks -> wikipedia -> neurosolution; NeuralNetorks -> tensorflow -> aiJunkie}";
    		$flowName = "java";

			MapEntry($flowName, $flowGraph);
		}

		function get_links($link)
		{
		    $ret = array();
		    $dom = new domDocument;
		 
		    @$dom->loadHTML(file_get_contents($link));
		    $dom->preserveWhiteSpace = false;
		     
		    $links = $dom->getElementsByTagName('a');
		     
		    foreach ($links as $tag)
		    {
		        $ret[$tag->getAttribute('href')] = $tag->childNodes->item(0)->nodeValue;
		    }
		     
		    return $ret;
		}

		function MapEntry($flowName, $flowGraph, $dbName = "Trails")
		{
			// Store the Map
			$servername = "localhost";
			$username = "root";
			$password = "test123";

			$conn = new mysqli($servername, $username, $password, $dbName);
			if ($conn->connect_error)
			{
				die("Connection failed: ".$conn->connect_error);
			}

			$sql = "INSERT INTO FlowMap
			VALUES('".$flowName."', '".$flowGraph."')";

			if ($conn ->query($sql) === TRUE)
			{
				echo "New record created";
			}
			else
			{
				echo "Error: ".$sql."<br>".$conn->error;
			}

			$conn->close();
		}

		CaputreFlow();
		//MapGen();
?>