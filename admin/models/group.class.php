<?php 
Class group {

	public function groupSelect($name="gid", $value="0") {

			$data=$this->field('id,gname')->select();

			$html = '' ;

			$html='<select id="sel" name="'.$name.'">';
			$html.='<option value="0">--用户组--</option>';
			foreach($data as $val){
				if($value==$val["id"])
					$html.='<option selected value="'.$val['id'].'">';
				else
					$html.='<option value="'.$val['id'].'">';

				$html.=$val['gname'];
				$html.='</option>';	
			}
			$html.='</select>';

			return $html;

	}

}
 ?>