<?php

require_once "db.php";
require_once 'teacher.php';
require_once "teacher.php";


   if(isset($_POST['submit'])) {
       $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
       $age = filter_input(INPUT_POST, 'age', FILTER_SANITIZE_NUMBER_INT);
       $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
       $tax = filter_input(INPUT_POST, 'tax', FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
       $salary = filter_input(INPUT_POST, 'salary', FILTER_SANITIZE_STRING);


       //inserting Data to database
       if (isset($_GET['action'])&&$_GET['action']=='edit'&&isset($_GET['id']))
       {
           $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
           $user=teacher::getByPK($id);
		   $user->name=$name;
		   $user->age=$age;
		   $user->address=$address;
		   $user->tax=$tax;
		   $user->salary=$salary;
		   
       }
       else
       {
       	   $user=new teacher($name,$age,$address,$tax,$salary);
		 
       }


       if ($user->save()==TRUE) {
           $msg = 'the teacher ' . $name . ' hass been inserted successfully';

       }
       else
       {
           echo 'Sorry';
//           $error=true;
//           $msg='the teacher not inserted';
       }
  }

if(isset($_GET['action'])&&$_GET['action']=='edit'&&isset($_GET['id']))
{
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
     if($id>0)
	 {
	 	$user=teacher::getByPK($id);
	 }
}

    //deleting
if(isset($_GET['action'])&&$_GET['action']=='delete'&&isset($_GET['id']))
{
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    if($id>0)
	{
		$user=teacher::getByPK($id);
        if ($user->delete()==true)
        {
        $msg='deleted successfully';
		}

    }
}


//selecting
  
   $result=teacher::getAll();
  ?>
<!DOCTYPE HTML>
<html>
<meta charset="utf8">
<head>
    <title>PDO</title>
<link rel="stylesheet" href="main.css"/>
</head>
<body>
<div class="wrraber">
    <div class="teach_form">
<form method="post" class="app_form">

    <fieldset>
        <legend>Teacher Information</legend>
        <?php if (isset($msg)){?>
          <p class="msg  <?= isset($error)? 'error' : ''?>"> <?= $msg?></p>
        <?php }?>


    <table>
        <tr>
            <td> <label> username teacher</label> </td>
            <td> <input required type="text" name="name"  placeholder="enter you name" maxlength="100" value="<?=isset($user)?$user->name : ''?>"></td>
        </tr>
        <tr>
            <td> <label> Age teacher</label> </td>
            <td> <input required type="number" name="age" placeholder="enter your Age"  maxlength="30" minlength="20" value="<?=isset($user)?$user->age : ''?>"></td>
        </tr>
        <tr>
            <td> <label> Address teacher</label> </td>
            <td> <input required type="text" name="address" placeholder="enter your address" value="<?=isset($user)?$user->address : ''?>" ></td>
        </tr>
        <tr>
            <td> <label> Tax teacher</label> </td>
            <td> <input required type="number" name="tax"  placeholder="enter your Tax" step="0.01" max="5" min="1" value="<?=isset($user)?$user->tax : ''?>"></td>
        </tr>
        <tr>
            <td> <label> Salary teacher</label> </td>
            <td> <input required type="number" name="salary" placeholder="enter your Salary" step="0.01" max="10000" min="3000" value="<?=isset($user)?$user->salary : ''?>"></td>
        </tr>
            <tr>
                <td><input type="submit" value="Save" name="submit"></td>
            </tr>
    </table>
    </fieldset>
</form>
    </div>
    <div class="teacher">
        <table>
            <thead>
            <tr>
            <th>Name</th>
            <th>Age</th>
            <th>Address</th>
            <th>Tax(%)</th>
            <th>salary</th>
                <th>Control</th>
            </tr>
            </thead>
            <tbody>

                <?php
                if(false !==$result){
                    foreach ($result as $teacher)
                    {?>
                        <tr>
                <td><?= $teacher->name?></td>
                <td><?= $teacher->age?></td>
                <td><?= $teacher->address?></td>
                <td><?= $teacher->tax?></td>
                <td><?= $teacher->calSalary()?></td>
                            <td>

                                <a href="http://localhost/PDO/? action=edit&&id=<?= $teacher->id;?>">Edit</a>
                                <a href="http://localhost/PDO/? action=delete&&id=<?= $teacher->id;?>">Delete</a>
                            </td>

                        </tr>
                <?php
                    }
                }else{
                    ?>
                <td colspan="5"><p>OPPS: Sorry no teacher</p></td>
<?php
                }
                ?>

            </tbody>
        </table>
    </div>
</div>

</body>
</html>

