<?php
/*
	分类组建
*/
Class sort{

	//组合select 输出
	public function selectForm($name = 'cid', $cid = 0 ){

		$data = $this->field('id, sname, concat(path, "-", id) as abspath')->order('abspath, id')->select() ;

		$html = '' ;
		
		$html .= '<select name="' . $name . '">' ;

		$html .= '<option value="0"> 顶级分类 </option>' ;

		if ($data){
			
			foreach($data as $row){
				$num = count(explode('-', $row['abspath'])) - 2 ;
				$space = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $num) ;

				$selected = ($cid == $row['id']) ? 'selected' : '' ;

				$html .= '<option ' . $selected . ' value=' . $row['id'] . '>' . $space . $row['sname'] . '</option>' ;
			}
		
		}

		$html .= '</select>' ;

		return $html ;
	}

}
?>