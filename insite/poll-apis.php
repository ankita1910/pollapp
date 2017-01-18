<?php
	include 'db-connect.php';
	session_start();
	
	if(isset($_REQUEST["cmd"])) {

		switch($_REQUEST["cmd"]) {

			case "REGISTERUSER" :
				registerUser();
			break;

			case "USERLOGIN" : 
				checkLoginCredentials();
			break;

			case "INSERTQUESTION" :
				addPollQuestion();
			break;

			case "ADDRESPONSE" :
				addResponse();
			break;

			case "GETALLQUESTIONS" : 
				getAllQuestions();
			break;

			case "GETUSERQUESTIONS" : 
				getUserQuestions();
			break;

			case "GETRESPONSESTATISTICS" :
				getResponseStats();
			break;
		}
	}

	function registerUser() {
		global $conn;

		$isParamValid = paramValidation('firstname', 'lastname', 'email', 'password');

		if($isParamValid) {
			$firstName = strip_tags($_REQUEST["firstname"]);
			$lastName = strip_tags($_REQUEST["lastname"]);
			$email = strip_tags($_REQUEST["email"]);
			$password = strip_tags($_REQUEST["password"]);

			$json_response = array();
		
			$registerUserQuery = "INSERT INTO user (firstname, lastname, email, password)
					VALUES ('$firstName', '$lastName', '$email', '$password')";

			if($conn -> query($registerUserQuery)) {
				echo "User entered successfully";

				/* Setting session variables */

				$_SESSION['user_id'] = $conn->insert_id;
				$_SESSION['firstname'] = $firstName;
				$_SESSION['lastname'] = $lastName;
				$_SESSION['email'] = $email;
			} else {
				echo "Error: couldn't register user";
			}
		} else {
			echo "Please enter all the necessary parameters";
		}
	}

	function checkLoginCredentials() {
		global $conn;

		$isParamValid = paramValidation('email', 'password');

		if($isParamValid) {

			$json_response = array();
			$email = strip_tags($_REQUEST["email"]);
			$password = strip_tags($_REQUEST["password"]);

			$userLoginQuery = "SELECT user_id, firstname, lastname FROM user
								WHERE email = '$email' AND password = '$password'";

			$userLoginQueryResponse = $conn -> query($userLoginQuery);

			if(mysqli_num_rows($userLoginQueryResponse) != 0) {
				if(!$conn ->error) {
					while($row = $userLoginQueryResponse -> fetch_assoc()) {
						$row_array = array();
						$row_array['user_id'] = $row['user_id'];
						$row_array['firstname'] = $row['firstname'];
						$row_array['lastname'] = $row['lastname'];
						array_push($json_response, $row_array);

						/* Setting session variables */

						$_SESSION['user_id'] = $row['user_id'];
						$_SESSION['firstname'] = $row['firstname'];
						$_SESSION['lastname'] = $row['lastname'];
						$_SESSION['email'] = $email;
					}
					echo json_encode($json_response);
				} else {
					echo "Error in connecting with database";
				}
			} else {
				echo "No records found for this Email ID. Please Sign Up";
			}
		} else {
			echo "Please enter all the necessary parameters";
		}
	}

	function addPollQuestion() {
		global $conn;

		$user_id = $_SESSION["user_id"];

		$isParamValid = paramValidation('question_text', 'option1', 'option2', 'option3', 'option4');

		if($isParamValid) {
			$json_response = array();
			$question_text = strip_tags($_REQUEST["question_text"]);
			$option1 = strip_tags($_REQUEST["option1"]);
			$option2 = strip_tags($_REQUEST["option2"]);
			$option3 = strip_tags($_REQUEST["option3"]);
			$option4 = strip_tags($_REQUEST["option4"]);
			$category = strip_tags($_REQUEST["category"]);

			$addPollQuestionQuery = "INSERT INTO poll_questions (question_text, option1, option2, option3, option4, user_id, category)
									VALUES ('$question_text', '$option1', '$option2', '$option3', '$option4', '$user_id', '$category')";

			if($conn -> query($addPollQuestionQuery)) {
				echo "Question added successfully";
			} else {
				echo "Error adding question in the database";
			}
		} else {
			echo "Please enter all the necessary parameters";
		}
	}

	function addResponse() {
		global $conn;

		$isParamValid = paramValidation('question_id', 'option');
		$json_response = array();

		if($isParamValid) {
			
			$question_id = strip_tags($_REQUEST["question_id"]);
			$option = $_REQUEST["option"];

			/* Check if the question id already exists in database */

			$checkIfQuestionExists = "SELECT question_id from response_stats
										WHERE question_id = '$question_id'";

			$questionExistsResponse = $conn -> query($checkIfQuestionExists); 

			if(mysqli_num_rows($questionExistsResponse) > 0) {
				$updateResponseCount = "UPDATE response_stats
										SET $option = $option + 1
										WHERE question_id = '$question_id'";

				if($conn -> query($updateResponseCount)) {
					array_push($json_response, "Count updated successfully");
					echo json_encode($json_response);
				} else {
					array_push($json_response, "Error: updating count" . $conn->error);
					echo json_encode($json_response);
				}
			} else {
				$insertQsResponse = "INSERT INTO response_stats (question_id, $option)
										VALUES ('$question_id', $option + 1)";

				if($conn -> query($insertQsResponse)) {
					array_push($json_response, "Inserted successfully");
					echo json_encode($json_response);
				} else {
					array_push($json_response, "Error inserting new record" . $conn->error);
					echo json_encode($json_response);
				}
			}
		} else {
			array_push($json_response, "Please enter all the necessary parameters");
			echo json_encode($json_response);
		}
	}

	function getAllQuestions() {
		global $conn;

		$json_response = array();

		$getALLQuestionsQuery = "SELECT p.question_id, p.question_text, p.option1, p.option2, p.option3, p.option4,
									p.category, timestamp, u.firstname FROM poll_questions p
									INNER JOIN user u
									ON p.user_id = u.user_id
									ORDER BY  timestamp DESC";

		$allQsResponse = $conn -> query($getALLQuestionsQuery);

		if(mysqli_num_rows($allQsResponse) > 0 && !$conn ->error) {
			while($row = $allQsResponse -> fetch_assoc()) {
				$row_array = array();
				$row_array['question_id'] = $row['question_id'];
				$row_array['question_text'] = $row['question_text'];
				$row_array['option1'] = $row['option1'];
				$row_array['option2'] = $row['option2'];
				$row_array['option3'] = $row['option3'];
				$row_array['option4'] = $row['option4'];
				$row_array['category'] = $row['category'];
				$row_array['timestamp'] = $row['timestamp'];
				$row_array['firstname'] = $row['firstname'];
				array_push($json_response, $row_array);
			}
			echo json_encode($json_response);
		} else {
			echo "No records found for this Email ID. Please Sign Up";
		}
	}

	function paramValidation() {

	    foreach(func_get_args() as $arg) {
	    	$isParamValid = true;
	        if(empty($_REQUEST[$arg])) {
	            $isParamValid = false;
	        }
	   	 }
	    return $isParamValid;
	}

	function getUserQuestions() {
		global $conn;

		$json_response = array();

		$user_id = $_SESSION["user_id"];

		$getALLQuestionsQuery = "SELECT question_id, question_text, option1, option2, option3, option4,
									category, timestamp FROM poll_questions
									WHERE user_id = '$user_id' ORDER BY  timestamp DESC";

		$allQsResponse = $conn -> query($getALLQuestionsQuery);

		if(mysqli_num_rows($allQsResponse) > 0 && !$conn ->error) {
			while($row = $allQsResponse -> fetch_assoc()) {
				$row_array = array();
				$row_array['question_id'] = $row['question_id'];
				$row_array['question_text'] = $row['question_text'];
				$row_array['option1'] = $row['option1'];
				$row_array['option2'] = $row['option2'];
				$row_array['option3'] = $row['option3'];
				$row_array['option4'] = $row['option4'];
				$row_array['category'] = $row['category'];
				$row_array['timestamp'] = $row['timestamp'];
				array_push($json_response, $row_array);
			}
			echo json_encode($json_response);
		} else {
			echo "No records found for this Email ID. Please Sign Up";
		}
	}

	function getResponseStats() {

		global $conn;
		$json_response = array();
		$isParamValid = paramValidation('question_id');
		
		if($isParamValid) {

			$question_id = $_GET["question_id"];
			$getResponseStatsQuery = "SELECT * FROM response_stats
										WHERE question_id = '$question_id'";

			$getStatsResponse = $conn -> query($getResponseStatsQuery);

			if(mysqli_num_rows($getStatsResponse) > 0 && !$conn ->error) {
				while($row = $getStatsResponse -> fetch_assoc()) {
					$row_array = array();
					$row_array['question_id'] = $row['question_id'];
					$row_array['option1_count'] = $row['option1_count'];
					$row_array['option2_count'] = $row['option2_count'];
					$row_array['option3_count'] = $row['option3_count'];
					$row_array['option4_count'] = $row['option4_count'];
					
					array_push($json_response, $row_array);
				}
				echo json_encode($json_response);
			} else {
				array_push($json_response, "error");
				array_push($json_response, "No records found for this Email ID. Please Sign Up");
				echo json_encode($json_response);
			}
		}

	}
?>