<?php
set_time_limit(100);
error_reporting(0);
ignore_user_abort(1);
session_start();
require_once('fungsi.php');
$TimeZone="+7";
$_time=gmdate("H", time() + ($TimeZone * 60 * 60));
$_SESSION['data'] = array('cookies' => 'ds_user=warung_insta3;shbid=7956;shbts=1560412976.5617907;csrftoken=LuVUy9Ia1X8FndjveOxBUXXF7gBoo1MX;rur=FTW;mid=XQIDLwABAAGatdUPMqXjZtlC_x4z;ds_user_id=2278272106;urlgen="{\"140.213.91.36\": 24203}:1hbKhE:hAsvm00JlkOcgJrwRB1p4xO7SoA";sessionid=2278272106%3AzEgHWmhWVLQGLS%3A21;', 'useragent' => 'Instagram 64.0.0.14.96 Android (11/3.5.3; 120; 320x480; samsung; GT-N7000; GT-N7000; smdkc210; en_US)', 'device_id' => 'android-cef1b938860dd6718de5eaae697b60e56', 'username' => 'warung_insta3', 'id' => '2278272106');
$xx = 0;
while($xx < 250){
	if($_time > 7 ){
      $jumlah= "5";
        $_POST['tipe'] = "followers";
        $target = "2552325391";
	$data_session = $_SESSION['data'];
	$getinfo = proccess(1, $data_session['useragent'], 'users/'.$target.'/info/',$data_session['cookies']);
	$getinfo = json_decode($getinfo[1]);
	if($_POST['tipe']=='followers'):
		if(!is_numeric($jumlah))
			$limit = 1;
		elseif($jumlah>($getinfo->user->follower_count-1))
			$limit = $getinfo->user->follower_count-1;
		else
			$limit = $jumlah-1;
		$tipe = 'followers';
	else:
		if(!is_numeric($jumlah))
			$limit = 1;
		elseif($jumlah>($getinfo->user->follower_count-1))
			$limit = $getinfo->user->follower_count-1;
		else
			$limit = $jumlah-1;
		$tipe = 'followers';
	endif;
	$c = 0;
	$listids = array();
	do{
		$parameters = ($c>0) ? '?max_id='.$c : '';
		$req = proccess(1, $data_session['useragent'], 'friendships/'.$target.'/'.$tipe.'/'.$parameters, $data_session['cookies']);
		$req = json_decode($req[1]);
		for($i=0;$i<count($req->users);$i++):
			if(count($listids)<=$limit)
				$listids[count($listids)] = $req->users[$i]->pk;
		endfor;
		$c = (isset($req->next_max_id)) ? $req->next_max_id : 0;
	}while(count($listids)<=$limit);
	for($i=0;$i<count($listids);$i++):
			$cross = proccess(1, $data_session['useragent'], 'friendships/create/'.$listids[$i].'/', $data_session['cookies'], hook('{"user_id":"'.$listids[$i].'"}'));
			$cross = json_decode($cross[1]);
			print $xx++.'. <b>@'.$data_session['username'].' Follow => '.$listids[$i]." ".$cross->status.PHP_EOL;
			flush();
			sleep(30);
     
	endfor;
	 sleep(60);
}
else
{
        $jumlah= "500";
        $_POST['tipe'] = "following";
	$target = $_SESSION['data']['id'];
	$data_session = $_SESSION['data'];
	$getinfo = proccess(1, $data_session['useragent'], 'users/'.$target.'/info/',$data_session['cookies']);
	$getinfo = json_decode($getinfo[1]);
	if($_POST['tipe']=='following'):
		if(!is_numeric($jumlah))
			$limit = 1;
		elseif($jumlah>($getinfo->user->following_count-1))
			$limit = $getinfo->user->following_count-1;
		else
			$limit = $jumlah-1;
		$tipe = 'following';
	else:
		if(!is_numeric($jumlah))
			$limit = 1;
		elseif($jumlah>($getinfo->user->follower_count-1))
			$limit = $getinfo->user->follower_count-1;
		else
			$limit = $jumlah-1;
		$tipe = 'followers';
	endif;
	$c = 0;
	$listids = array();
	do{
		$parameters = ($c>0) ? '?max_id='.$c : '';
		$req = proccess(1, $data_session['useragent'], 'friendships/'.$target.'/'.$tipe.'/'.$parameters, $data_session['cookies']);
		$req = json_decode($req[1]);
		for($i=0;$i<count($req->users);$i++):
			if(count($listids)<=$limit)
				$listids[count($listids)] = $req->users[$i]->pk;
		endfor;
		$c = (isset($req->next_max_id)) ? $req->next_max_id : 0;
	}while(count($listids)<=$limit);
	for($i=0;$i<count($listids);$i++):
			$cross = proccess(1, $data_session['useragent'], 'friendships/destroy/'.$listids[$i].'/', $data_session['cookies'], hook('{"user_id":"'.$listids[$i].'"}'));
			$cross = json_decode($cross[1]);
			print $xx++.'. <b>@'.$data_session['username'].' UnFollow => '.$listids[$i]." ".$cross->status.PHP_EOL;
			flush();
			sleep(30);
	endfor;
}
	
	
	
}
?>