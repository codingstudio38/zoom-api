<?php
require_once 'config.php';
require_once 'api.php';
define('TIMEZONE','Asia/Kolkata');
date_default_timezone_set(TIMEZONE);
if(isset($_POST['addevent'])){
$start_date = $_POST['start_date'];
$start_time = $_POST['start_time'];
$arr['topic']=$_POST['topic'];
$arr['start_date']=$start_date."T".$start_time.":00";
//date('2022-08-25 17:00:00');
//gmdate("Y-m-d\TH:i:s", strtotime($data['start_date']));
//gmdate("Y-m-d\TH:i:s", strtotime($start_date.$start_time));
$arr['duration']=$_POST['duration'];
$arr['password']=$_POST['password'];
$arr['type']='2';
$arr['agenda']=$_POST['agenda'];
$arr['timezone']=TIMEZONE;
$result=createMeeting($arr);
if(isset($result->id)){
	echo "Join URL: <a href='".$result->join_url."'>".$result->join_url."</a><br/>";
	echo "Password: ".$result->password."<br/>";
	echo "Start Time: ".$result->start_time."<br/>";
	echo "Duration: ".$result->duration."<br/>";
	echo "agenda: ".$result->agenda."<br/>";
	echo "created_at: ".$result->created_at."<br/>";
	echo "topic: ".$result->topic."<br/>";
}else{
	echo '<pre>';
	print_r($result);
}
header("Location:index.php");
}
if(isset($_GET['delete_id'])){
	$delete = delete_meeting($_GET['delete_id']);
	echo '<pre>';
	print_r($delete);
	header("Location:index.php");
}
$data=meeting_list();
// https://artisansweb.net/how-to-create-a-meeting-on-zoom-using-zoom-api-and-php/

?>

<!DOCTYPE html>
<html>

<head>
    <title>Zoom Meet</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
        .register {
            background: -webkit-linear-gradient(left, #3931af, #00c6ff);
            margin-top: 3%;
            padding: 3%;
        }
        
        .register-left {
            text-align: center;
            color: #fff;
            margin-top: 4%;
        }
        
        .register-left input {
            border: none;
            border-radius: 1.5rem;
            padding: 2%;
            width: 60%;
            background: #f8f9fa;
            font-weight: bold;
            color: #383d41;
            margin-top: 30%;
            margin-bottom: 3%;
            cursor: pointer;
        }
        
        .register-right {
            background: #f8f9fa;
            border-top-left-radius: 10% 50%;
            border-bottom-left-radius: 10% 50%;
        }
        
        .register-left img {
            margin-top: 15%;
            margin-bottom: 5%;
            width: 60%;
            -webkit-animation: mover 2s infinite alternate;
            animation: mover 1s infinite alternate;
        }
        
        @-webkit-keyframes mover {
            0% {
                transform: translateY(0);
            }
            100% {
                transform: translateY(-20px);
            }
        }
        
        @keyframes mover {
            0% {
                transform: translateY(0);
            }
            100% {
                transform: translateY(-20px);
            }
        }
        
        .register-left p {
            font-weight: lighter;
            padding: 12%;
            margin-top: -9%;
        }
        
        .register .register-form {
            padding: 10%;
            margin-top: 10%;
        }
        
        .btnRegister {
            float: right;
            margin-top: 10%;
            border: none;
            border-radius: 1.5rem;
            padding: 2%;
            background: #0062cc;
            color: #fff;
            font-weight: 600;
            width: 50%;
            cursor: pointer;
        }
        
        .register .nav-tabs {
            margin-top: 3%;
            border: none;
            background: #0062cc;
            border-radius: 1.5rem;
            width: 28%;
            float: right;
        }
        
        .register .nav-tabs .nav-link {
            padding: 2%;
            height: 34px;
            font-weight: 600;
            color: #fff;
            border-top-right-radius: 1.5rem;
            border-bottom-right-radius: 1.5rem;
        }
        
        .register .nav-tabs .nav-link:hover {
            border: none;
        }
        
        .register .nav-tabs .nav-link.active {
            width: 100px;
            color: #0062cc;
            border: 2px solid #0062cc;
            border-top-left-radius: 1.5rem;
            border-bottom-left-radius: 1.5rem;
        }
        
        .register-heading {
            text-align: center;
            margin-top: 8%;
            margin-bottom: -15%;
            color: #495057;
        }
    </style>
</head>

<body>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
<div class="container register">
        <div class="row">
            <div class="col-md-3 register-left">
                <img src="Zoom_logo_PNG1.png" alt="" width="" height=""/>
            </div>
            <div class="col-md-9 register-right">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <h3 class="register-heading">Create Zoom Meet</h3>
                        <div class="row register-form">
                            <div class="col-md-12">
                                <form action="index.php" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input type="date" id="start_date" name="start_date" class="form-control" placeholder="Start Date *" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="time" id="start_time" name="start_time" class="form-control" placeholder="Start Time *" required />
                                    </div>
																		<div class="form-group">
                                        <input type="number" class="form-control" placeholder="Duration * in minute" name="duration" id="duration" required/>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Topic *" name="topic" id="topic" required/>
                                    </div>
                                    
                                    <div class="form-group">
                                        <textarea name="agenda" id="agenda" placeholder="Agenda *" class="form-control" required></textarea>
                                    </div>

																		<div class="form-group">
                                        <input type="password" class="form-control" placeholder="Password *" name="password" id="password" required/>
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary" id="addevent" name="addevent" value="Apply" />
                                    </div>
                                </form>
                            </div>


                        </div>

                    </div>

                </div>
            </div>
        </div>


    </div>
    
    <br>



    <div class="container" >
        <div class="col-md-12 table-responsive">

        
        <table>
  <tr>
    <th>uuid</th>
    <th>id</th>
    <th>host_id</th>
    <th>topic</th>
    <th>type</th>
    <th>start_time</th>
    <th>duration</th>
    <th>timezone</th>
    <th>agenda</th>
		<th>created_at</th>
		<th>join_url</th>
    <th>Action</th>

  </tr>
  <?php if (count($data->meetings) < 0) { ?>
    <tr>
    <td collspan="12">No upcoming events found.</td>
  </tr>
    <?php } else { ?>
		
    <?php $i=1; ?>
    <?php foreach ($data->meetings as $row) { ?>
    <tr>
        <td><?php echo @$row->uuid;?></td>
        <td><?php echo @$row->id;?></td>
        <td><?php echo @$row->host_id;?></td>
        <td><?php echo @$row->topic;?></td>
				<td><?php echo @$row->type;?></td>
        <td>
					<?php 
					if(@$row->start_time==""){

					} else {
						echo date("Y/m/d h:i:s A", strtotime(@$row->start_time)); 
					}
					?>
			</td>
        <td><?php echo @$row->duration." Min";?></td>
        <td><?php echo @$row->timezone;?></td>
				<td><?php echo @$row->agenda;?></td>
				<td>
				<?php 
					if(@$row->created_at==""){

					} else {
						echo date("Y/m/d h:i:s A", strtotime(@$row->created_at)); 
					}
					?>
				</td>
				<td><a href="<?php echo @$row->join_url;?>">join_url</a></td>
        <td><a href="index.php?delete_id=<?php echo @$row->id;?>">Delete</a></td>
    </tr>
    <?php } ?>

    <?php } ?>
        
  
  
</table>
</div>
          </div>




          </body>
          
</html>