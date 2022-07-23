<?php
//connection File 
require_once('include/config.php'); ?>

<?php
//include head file for language preference 
include("head.php");  ?>
<?php


    //if form has been submitted process it
    if (isset($_POST['submit'])) {



        //collect form data
        extract($_POST);

        //very basic validations
        if ($name == '') {
            $error[] = 'Error : Please enter your name.';
        }

        if ($email == '') {
            $error[] = 'Error : Please enter your email.';
        }

        if ($query == '') {
            $error[] = 'Error : Please provide description.';
        }
       
        
        if (!isset($error)) {

            try {

               

                //insert into database
                $stmt = $db->prepare('INSERT INTO contact (name,email,query) VALUES (:name,:email,:query)');




                $stmt->execute(array(
                    ':name' => $name,
                    ':email' => $email,
                    ':query' => $query,
                ));

             
                //redirect to index page
                header('Location: contact.php?action=success');
                exit;
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
?>

<title>Contact - Us - QNASTOP</title>
<meta name="description" content="Contact us - Qnastop is one stop for all your question">

<meta name="keywords" content="">
<meta property="og:url" content="https://qnastop.com<?php echo $_SERVER['REQUEST_URI']; ?>" />

<meta property="og:type" content="website" />

<meta property="og:title" content="Contact Us - Qnastop.com" />
<meta property="og:description" content="Contact us for any help/issue/ info etc. using form available on this page - Qnastop.com" />


<?php include("header.php");  ?>
<?php if (isset($error)) {
        foreach ($error as $error) {
            echo '<div class="message fail max-width1 font1">' . $error . '</div>';
        }
    }
?>
<?php if (isset($_GET['action'])) {
         
            echo '<div class="message success max-width1 font1">Your Message was sent succesfully.</div>';
        
    }
?>
<div class="fixed">
<div class="contact max-width1 m-auto">
    <h1 class="font1 m-auto max-width2">Contact Us</h1>
    <h3 class="max-width2 m-auto">Email Us at : contact@qnastop.com</h3>
    <h4 class="max-width2 m-auto">Or</h4>

    <form class="form m-auto max-width2" method="POST" action="">
        <div class="formbox">
            <input type="text" name = "name" placeholder="Enter your name">
        </div>
        <div class="formbox">
            <input type="email" name="email" placeholder="Enter your Email">
        </div>

        <div class="formbox">

            <textarea name="query" id="" cols="30" name="query" rows="8" placeholder="Describe your issue"></textarea>
        </div>
        <div class="formbox">
            <button class="btn-blue" name="submit">Submit</button>
        </div>

    </form>
</div>
</div>
<?php //footer content 
include("footer.php");  ?>