<?php

Class Image{

	function __construct($b64, $filter, $userid)
	{
		$this->b64 = preg_replace('#^data:image/\w+;base64,#i', '', $b64);
		$this->filter = $filter;
		$this->userid = $userid;
		$toto = base64_decode($this->b64);
		file_put_contents('ressources/images/tmp.png', $toto);
		$this->merge();
	}

	function merge()
	{
		$im = imagecreatefrompng('ressources/images/tmp.png');
		if (!$this->filter)
		{
			$this->result = $this->b64;
			exit ;
		}
		$alpha = imagecreatefrompng('ressources/images/'.$this->filter.'.png');
		$this->imagecopymerge_alpha($im, $alpha, 0, 0, 0, 0, imagesx($alpha), imagesy($alpha), 100);
		imagepng($im,"ressources/images/result.png");
		$path = 'ressources/images/result.png';
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		$this->result = 'data:image/' . $type . ';base64,' . base64_encode($data);
		imagedestroy($im);
	}

	function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){
		$cut = imagecreatetruecolor($src_w, $src_h);
		imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
		imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
		imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
	}
}