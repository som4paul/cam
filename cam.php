<?php


 function select_data_from_db($table_name,$conn)
{

      $query="SELECT * FROM ".$table_name; 
     $final = array() ; 
      
     /* if($total_count>0)
      {
        while ($row = mysqli_fetch_array($query)) {
            $result[] = $row;
        }
      }*/
      $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
	$flag = FALSE;
while ($row = $result->fetch_assoc()) {
    $final[] = $row ; 
    $flag = TRUE;
}

      return $final;
 }


error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "18.157.183.172:7999";
$database = "xtream_iptvpro";
$username = "star";
$password = "starstars";



// Create connection

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection

if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

else //after successfull connection
{
//echo "Connected successfully";

  $myrows_tv_vod_category_list=select_data_from_db("tv_vod_category_list",$conn);
 
  $myrows_stream_category =  select_data_from_db("stream_categories",$conn);
  //echo "<pre>" ; print_r($myrows_tv_vod_category_list) ;




  if(count($myrows_tv_vod_category_list[0])>1){



  	for($i=0;$i<count($myrows_tv_vod_category_list[0]);$i++)
  	{

  		$sql = "INSERT INTO stream_categories (category_type, category_name, parent_id,cat_order)
    VALUES ('".$myrows_tv_vod_category_list[0][$i]['title']."','".$myrows_tv_vod_category_list[0][$i]['description']."','".'0'."','".'100'."')";

    $result = mysqli_query($conn,$sql);
    	}//end of for()//inserting one by one
  }//i.e. if tv_vod_category_list has data
  /*echo "<pre>" ; print_r($myrows_stream_category) ; 
    die;*/



$myrows_tv_vod_movie_list=select_data_from_db("tv_vod_movie_list",$conn);
 
  $myrows_streams =  select_data_from_db("streams",$conn);
 /* echo "<pre>" ; print_r($myrows_tv_vod_movie_list) ;*/
  //echo "<pre>" ; print_r($myrows_streams) ;


  if(count($myrows_tv_vod_movie_list)>1){



  	for($i=0;$i<count($myrows_tv_vod_movie_list);$i++)
  	{

  	$prepare = 	array
        (
           /* "id" => $myrows_tv_vod_movie_list[$i][''],*/
            "type" => '2',
            "category_id" => $myrows_tv_vod_movie_list[$i]['parent_id'],
            "stream_display_name" => $myrows_tv_vod_movie_list[$i]['title'],
            "stream_source" => $myrows_tv_vod_movie_list[$i]['stream_url'],
            "stream_icon" => $myrows_tv_vod_movie_list[$i]['poster_url'],
            "notes" => $myrows_tv_vod_movie_list[$i]['description'],
            "created_channel_location" => '0',
            "enable_transcode" => '0',
            "transcode_attributes" =>"[]",
            "custom_ffmpeg" => " ",
            "movie_propeties" => $myrows_tv_vod_movie_list[$i]['description'],
            "movie_subtitles" => " ",
            "read_native" => '0',
            "target_container" => "mp4",
            "stream_all" => '0',
            "remove_subtitles" =>'0',
           /* "custom_sid" => $myrows_tv_vod_movie_list[$i][''],
            "epg_id" => $myrows_tv_vod_movie_list[$i][''],
            "channel_id" => $myrows_tv_vod_movie_list[$i][''],
            "epg_lang" => $myrows_tv_vod_movie_list[$i][''],*/
            //"order" => '2',
            "auto_restart" => " ",
            "transcode_profile_id" => '0',
            "pids_create_channel" => '',
            "cchannel_rsources" => $myrows_tv_vod_movie_list[$i]['stream_url'],
            "gen_timestamps" => $myrows_tv_vod_movie_list[$i]['release_date'],
            "added" => $myrows_tv_vod_movie_list[$i]['release_date'],	
            "series_no" => $myrows_tv_vod_movie_list[$i]['star_rating'],
            "direct_source" => '0',
            "tv_archive_duration" => $myrows_tv_vod_movie_list[$i]['length'],
            "tv_archive_server_id" => '0',
            "tv_archive_pid" => '0',
            "movie_symlink" => '0',
            "redirect_stream" => '1',
            "rtmp_output" => '0',
            "number" => '0',
            "allow_record" => '0',
            "probesize_ondemand" => '128000',
            "custom_map" => $myrows_tv_vod_movie_list[$i]['genre2'],
            "external_push" => " ",
            "delay_minutes" => '0'
        ) ; 

$columnnames = array() ; 

        foreach ($prepare as $key => $value) {
        	# code...
        	$columnnames[] = $key ; 
        }
  
//print_r($prepare) ; die;  
        $columns = implode(", ",array_keys($prepare));
$escaped_values = array_map(array($conn, 'real_escape_string'), array_values($prepare));


$mystring ="id
type
category_id
created_channel_location
enable_transcode
read_native
stream_all
remove_subtitles
epg_id
order
transcode_profile_id
gen_timestamps
added
series_no
direct_source
tv_archive_duration
tv_archive_server_id
tv_archive_pid
movie_symlink
redirect_stream
rtmp_output
number
allow_record
probesize_ondemand
delay_minutes
" ; 

//print_r($columnnames) ; die;
for ($j=0; $j <count($escaped_values) ; $j++) { 
	# code...
if(strpos( $mystring,$columnnames[$j])!== false)
	{$escaped_values[$j] = $escaped_values[$j] ;  }//word found

	else
	{$escaped_values[$j] = "'".$escaped_values[$j]."'" ; }//word not found
}

//echo "<pre>" ; print_r($escaped_values) ; die;

$values  = implode(", ", $escaped_values);

/*echo "<pre>" ; print_r($columns) ; 
echo "<pre>" ; print_r($values) ; die;
*/
$sql = "INSERT INTO streams($columns) VALUES ($values)";

//echo $sql ; die; 
  		/*$sql = "INSERT INTO streams (type, category_id, stream_display_name,stream_source,stream_icon,notes,created_channel_location,enable_transcode,transcode_attributes,custom_ffmpeg,movie_propeties,movie_subtitles,read_native,target_container,stream_all,remove_subtitles,)
    VALUES ('".$$myrows_tv_vod_category_list[0][$i]['title']."','".$myrows_tv_vod_category_list[0][$i]['description']."','".'0'."','".'100'."')";*/
//echo $sql; die();
    mysqli_query($conn,$sql);//or die (mysqli_error($conn));

    
    	}//end of for()//inserting one by one
  }//i.e. if tv_vod_category_list has data
echo "Data cloning from tv_vod_category_list->stream_category and 
tv_vod_movie_list->streams is completed now !!! please check respective Database !
" ; 
}//end of  else
mysqli_close($conn);

?>
