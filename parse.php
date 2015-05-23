<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function trim_fgets($s) {
    return trim(fgets($s));
}

function mysqli_query_or_die($con, $s) {
    $res = mysqli_query($con, $s) or die(mysqli_error($con));
    return $res;
}

$file = "data.log";
$fh = fopen($file, "r");
if ( $fh ) {
    
  //File version
  $version = trim_fgets($fh);
  //echo $version."<br/><br/>";
  //Remote version
  $res=mysqli_query_or_die($con, "select version from mutex");
  $rversion = mysqli_fetch_array($res)[0];
  //echo $rversion."<br/><br/>";
  if ($version == $rversion) {
      //echo "Same version<br/><br/>";
  }
  else {      
    while (!feof($fh)) {
      $pc = trim_fgets($fh);
      //echo "Currently dumping ".$pc."..<br/>";
      mysqli_query_or_die($con, "insert into pc values('".$pc."', '".$version."', 0)");
      $line = trim_fgets($fh);
      while($line != "" && !feof($fh)) {
          //echo "[".$line."]"."<br/>";
          $data=preg_split('/\s+/', $line);
          
          //Add the w
          $res=mysqli_query_or_die($con, "select count(*) from w where"
                  . " user='".$data[0]."'"
                  . " and tty='".$data[1]."'"
                  . " and connected_from='".$data[2]."'"
                  . " and logina='".$data[3]."'"
                  . " and idle='".$data[4]."'"
                  . " and jcpu='".$data[5]."'"
                  . " and pcpu='".$data[6]."'"
                  . " and what='".$data[7]."'"
                  . " and pc_name='".$pc."'"
                  . " and version='".$version."'");
          $exists = mysqli_fetch_array($res)[0];
          //echo $exists."<br/><br/>";
          if ($exists == 0) {
            mysqli_query_or_die($con, "insert into w values("
                    . "'".$data[0]."',"
                    . "'".$data[1]."',"
                    . "'".$data[2]."',"
                    . "'".$data[3]."',"
                    . "'".$data[4]."',"
                    . "'".$data[5]."',"
                    . "'".$data[6]."',"
                    . "'".$data[7]."',"
                    . "'".$pc."',"
                    . "'".$version."')");
          }
          
          //add the status (locked or not)
          if($data[7] == 'pam:') {
            $res=mysqli_query_or_die($con, "select locked from pc where name='".$pc."' and version='".$version."'");
            $locked = mysqli_fetch_array($res)[0];
            if (!$locked) {
                mysqli_query_or_die($con, "update pc set locked=1 where name='".$pc."' and version='".$version."'");
            }
          }
          //next line
          $line = trim_fgets($fh);
      }
      //echo "<br/>";
    }
       
    //Delete old records
    mysqli_query_or_die($con, "delete from pc where version='".$rversion."'");
    mysqli_query_or_die($con, "delete from w where version='".$rversion."'");
    
    //Change the remote version
    mysqli_query_or_die($con, "update mutex set version='".$version."'");
  }
  fclose($fh);
}

?>