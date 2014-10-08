<?php
class Form {
	/**
	 * ±à¼­Æ÷
	 * @param int $textareaid
	 * @param int $toolbar    ÓÐbasic full ºÍdescÈýÖÖ
	 * @param int $color ±à¼­Æ÷ÑÕÉ«
	 * @param string $alowuploadexts ÔÊÐíÉÏ´«ÀàÐÍ
	 * @param string $height ±à¼­Æ÷¸ß¶È
	 * @param string $disabled_page ÊÇ·ñ½ûÓÃ·ÖÒ³ºÍ×Ó±êÌâ
	 */
	public static function editor($textareaid = 'content', $toolbar = 'basic', $height = 200, $color = '', $up=true) {
		$str ='';
		if(!defined('EDITOR_INIT')) {
			$str = '<script type="text/javascript" src="'.B_PUBLIC.'/ckeditor/ckeditor.js"></script>';
			define('EDITOR_INIT', 1);
		}
	
		if($toolbar == 'basic') {
			$toolbar = "['Bold', 'Italic','Underline','Strike','NumberedList', 'BulletedList', 'TextColor','BGColor', 'Link', 'Unlink', '-', 'Image','Flash','Table','Smiley','SpecialChar'],['RemoveFormat'],
		   \r\n";
		} elseif($toolbar == 'full') {
		   $toolbar = "['Source','-','Templates'],
		    ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print'],
		    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],['ShowBlocks'],['Image','Capture','Flash'],['Maximize'],
		    '/',
		    ['Bold','Italic','Underline','Strike','-'],
		    ['Subscript','Superscript','-'],
		    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
		    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		    ['Link','Unlink','Anchor'],
		    ['Table','HorizontalRule','Smiley','SpecialChar'],
		    '/',
		    ['Styles','Format','Font','FontSize'],
		    ['TextColor','BGColor'],
		    ['attachment'],\r\n";
		  
		} elseif($toolbar == 'desc') {
			$toolbar = "['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'Image', '-','Source'],\r\n";
		
		} else {
			$toolbar = '';
		}
		$str .= "<script type=\"text/javascript\">\r\n";
		$str .= "CKEDITOR.replace( '$textareaid',{";

	


		$str .= "height:{$height},";
	
	
		if($color) {
			$str .= "extraPlugins : 'uicolor',uiColor: '$color',";
		}
		
		if($up) {	
			$str .="filebrowserImageUploadUrl:'".B_URL."/upimage',";
			$str .="filebrowserFlashUploadUrl:'".B_URL."/upflash',";
		}
		$str .= "toolbar :\r\n";
		$str .= "[\r\n";
		$str .= $toolbar;
		$str .= "]\r\n";
		//$str .= "fullPage : true";
		$str .= "});\r\n";
		$str .= '</script>';
		return $str;
	}
	/**
	 * ÈÕÆÚÊ±¼ä¿Ø¼þ
	 * 
	 * @param $name ¿Ø¼þname£¬id
	 * @param $value Ñ¡ÖÐÖµ
	 * @param $isdatetime ÊÇ·ñÏÔÊ¾Ê±¼ä
	 * @param $loadjs ÊÇ·ñÖØ¸´¼ÓÔØjs£¬·ÀÖ¹Ò³Ãæ³ÌÐò¼ÓÔØ²»¹æÔòµ¼ÖÂµÄ¿Ø¼þÎÞ·¨ÏÔÊ¾
	 * @param $showweek ÊÇ·ñÏÔÊ¾ÖÜ£¬Ê¹ÓÃ£¬true | false
	 */
	public static function date($name, $value = '', $isdatetime = 0, $loadjs = 0) {
		if($value == '0000-00-00 00:00:00') $value = '';
		$id = preg_match("/\[(.*)\]/", $name, $m) ? $m[1] : $name;
		if($isdatetime) {
			$size = 21;
			$format = '%Y-%m-%d %H:%M:%S';
			$showsTime = 12;
		} else {
			$size = 10;
			$format = '%Y-%m-%d';
			$showsTime = 'false';
		}
		$str = '';
		if($loadjs || !defined('CALENDAR_INIT')) {
			define('CALENDAR_INIT', 1);
			$str .= '<script src="'.B_PUBLIC.'/js/date/js/jscal2.js"></script>
   				 <script src="'.B_PUBLIC.'/js/date/js/lang/cn.js"></script>
   				 <link rel="stylesheet" type="text/css" href="'.B_PUBLIC.'/js/date/css/jscal2.css" />
    				<link rel="stylesheet" type="text/css" href="'.B_PUBLIC.'/js/date/css/border-radius.css" />
    				<link rel="stylesheet" type="text/css" href="'.B_PUBLIC.'/js/date/css/steel/steel.css" />';
		}
		$str .= '<input type="text" name="'.$name.'" id="'.$id.'" value="'.$value.'" size="'.$size.'" class="date" readonly>&nbsp;';
		$str .= '<script type="text/javascript">
			Calendar.setup({
			weekNumbers: true,
		    inputField : "'.$id.'",
		    trigger    : "'.$id.'",
		    dateFormat: "'.$format.'",
		    showTime: '.$showsTime.',
		    minuteStep: 1,
		    onSelect   : function() {this.hide();}
			});
        </script>';
		return $str;
	}

	/**
	 * ÑÕÉ«¿Ø¼þ
	 * 
	 * @param $name ¿Ø¼þname
	 * @param $value Ñ¡ÖÐÖµ
	 */
	public static function color($name, $value = '000000') {
	
		if(!defined('COLOR_INIT')) {
			define('COLOR_INIT', 1);
			$str= '<script src="'.B_PUBLIC.'/js/jscolor/jscolor.js"></script>';
   			
		}
		$str .= '<input class="color" style="width:48px;height:16px;overfrom:hidden" name="'.$name.'" value="'.$value.'" />';
	
		return $str;
	}

}
