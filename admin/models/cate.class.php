<?php 
Class cate {

	public function selectForm($name = 'cid', $cid = 0 ){

		$data = $this->field('id, cname')->order('id desc')->select() ;

		$html = '' ;

		$html .= '<select id="sel" name="'.$name.'">' ;

		$html .= '<option value="0"> 顶级分类 </option>' ;

		$selected = '' ;

		if ($data){
			foreach ($data as $row) {

				$selected = ($cid == $row['id']) ? 'selected' : '' ;

				$html .= '<option ' . $selected . ' value=' . $row['id'] . '>' .  $row['cname'] . '</option>' ;
			}
		}
		$html .="</select>" ;
		
		return $html ;
	}

}
 ?>