<?php
session_start();

// Connect to the database (replace with your database credentials)
include 'dbconnect.php';

// Initialize variables
$questionIndex = isset($_SESSION['questionIndex']) ? $_SESSION['questionIndex'] : 0;
$num = 0;
$score = isset($_SESSION['score']) ? $_SESSION['score'] : 0;
$selectedAnswer = ''; // Initialize selected answer
$correctAnswer = ''; // Initialize correct answer

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the selected answer and the correct answer from the form
    $selectedAnswer = strtolower($_POST['answer']); // Convert to lowercase for case-insensitive comparison
    $correctAnswer = strtolower($_POST['correct_answer']); // Convert to lowercase for case-insensitive comparison

    // Check if the selected answer is correct
    if ($selectedAnswer === $correctAnswer) {
        // Increment the user's score
        $score++;
        $_SESSION['score'] = $score;
    } else {
        echo '<div class="error-message">Incorrect answer!<br>
        Submitted Answer:'. $selectedAnswer. '<br>
        Correct Answer:' .$correctAnswer. '</div>';
    }

    // Increment the question index for the next question
    $questionIndex++;
    $_SESSION['questionIndex'] = $questionIndex;
}

// Retrieve a question from the database
$query = "SELECT * FROM question LIMIT $questionIndex, 1";
$result = mysqli_query($conn, $query);
$num = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        /* Style for the error message */
        .error-message {
            position: absolute;
            top: 80%;
            left: 40%;
            right: 40%;
            background-color: #f00;
            color: #fff;
            padding: 5px;
            text-align: center;
            animation: showErrorMessage 2s linear;
            opacity: 0;
            border-radius: 35%;
        }

        @keyframes showErrorMessage {
            0% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }

        /* Reset some default styles for consistency */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Set a background color for the body */
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }

        /* Style the header */
        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }

        /* Style the main container */
        main {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Style the quiz container */
        .quiz-container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        /* Style the question container */
        #question-container {
            margin-bottom: 20px;
        }

        /* Style the question text */
        #question-container h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        /* Style the answer options */
        #question-container ul {
            list-style-type: none;
            padding: 0;
        }

        #question-container li {
            margin-bottom: 10px;
        }

        /* Style the radio buttons */
        #question-container input[type="radio"] {
            margin-right: 10px;
        }

        /* Style the score container */
        #score-container {
            text-align: right;
            font-size: 18px;
            margin-bottom: 20px;
        }

        /* Style the "Next" button */
        form button[type="submit"] {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Style the "Play Again" button */
        form[name="play_again"] button[type="submit"] {
            margin: 1rem;
            background-color: #f00;
        }

        /* Style the question container */
        #question-container {
            position: relative;
            /* Add this line to enable positioning */
            margin-bottom: 20px;
        }

        /* Style the score container within the question container */
        #score-container {
            position: absolute;
            top: 0;
            right: 0;
            background-color: #333;
            color: #fff;
            padding: 5px 10px;
            border-radius: 0 0 5px 0;
            font-size: 16px;
        }

        /* Style the "Next" button */
        form button[type="submit"] {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <header>
        <h1>Quiz App</h1>
    </header>
    <main>
        <div class="quiz-container">
            <div id="question-container">
                <?php
                if ($num > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<h2>' . $row['questiontext'] . '</h2>';
                        echo '<form method="POST" action="quiz.php">';
                        echo '<ul>';
                        for ($i = 'a'; $i <= 'd'; $i++) {
                            $optionKey = 'option' . $i;
                            $value = $i;
                            $isChecked = ($selectedAnswer === $value) ? 'checked' : ''; // Check if this option was previously selected
                            echo '<li><input type="radio" name="answer" value="' . $value . '" ' . $isChecked . '>' . $row[$optionKey] . '</li>';
                        }
                        echo '</ul>';
                        echo '<input type="hidden" name="correct_answer" value="' . $row['correctoption'] . '">';
                        echo '<button type="submit">Submit Answer</button>';
                        echo '</form>';
                    }
                } else {
                    echo '<h2>Thank you for playing!</h2>';
                    echo '<p>Your final score is: ' . $score . '</p>';
                    echo '<form method="POST" action="resetquiz.php">';
                    echo '<br>' . '<button type="submit" name="play_again">Play Again</button>';
                    echo '</form>';
                }
                ?>
            </div>
            <div id="score-container">
                Score:
                <?php echo $score; ?>
            </div>
        </div>
    </main>
</body>

</html>