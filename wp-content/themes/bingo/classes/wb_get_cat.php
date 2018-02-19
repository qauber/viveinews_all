<?php

class wb_get_cat
{
    private $not_cat = array( "archive" ); // name or id category
  
        public function wb_get_arr_cat($parant=0, $category=array()) {
            $args = array(
                  'orderby'                  => 'name',
                  'order'                    => 'DESC',
                  'hide_empty'               => 0,
                  'hierarchical'             => true,
                  'exclude'                  => '',
                  'taxonomy'                 => 'product_cat',
                  'parent'                   => $parant
            );
            $categories = get_categories($args);
                    foreach ($categories as $value) {
                        $category[] = array("id" =>$value->term_id, "title" => $value->name, "" => $value->parent,
                        "sub" => $this->wb_get_arr_cat($value->term_id)
                        );
                    }
            usort($category, function($l, $r) {  return strcmp(strtolower($l["title"]), strtolower($r["title"]));  });

            return $category;
        }
 
 	public function wb_get_tree( $data, $level = 0, $active = null, $category_remove=array() ) {
  		foreach ($data as $value) {
                    if($value["id"] == $active) {
                            $selected = "selected='selected'";
                      }else{
                            $selected = "";
                      }
  			if($level > 1) continue;
            $not_cat2 = array_merge($this->not_cat, $category_remove);
  			if( in_array( $value["id"], $not_cat2 ) ) continue;
  			if( in_array( strtolower( $value["title"] ), $not_cat2 ) ) continue;
  			if($value["parent"] != 0) continue;
   			echo "<option value='".$value["id"]."' class='wb-opt-lvl-".$level."' $selected>".$value["title"]."</option>";
   			if($value["sub"]){
   				$level++;
   				$this->wb_get_tree( $value["sub"], $level );
   				$level--;
   			}
  		}
 	}
        
        public function wb_get_tree_sub($data, $id, $active) {
            foreach ($data as $value) {
                if ($value["id"] != $id)
                    continue;
                foreach ($value["sub"] as $valsub) {
                    if (in_array(strtolower($valsub["title"]), $this->not_cat))
                        continue;
                    if ($valsub["id"] == $active) {
                        $selected = "selected='selected'";
                    } else {
                        $selected = "";
                    }
                    echo "<option value='" . $valsub["id"] . "' " . $selected . ">" . $valsub["title"] . "</option>";
                }
            }
        }
                                                

        public function get_tree_sub($data, $sub_arr = array()){
           foreach($data as $value){
               if( in_array( strtolower( $value["title"] ), $this->not_cat ) ) continue;
               foreach($value["sub"] as $sub_val){
                   $sub_arr[$value["id"]][] = array("id" => $sub_val["id"], "title" => $sub_val["title"]);
               }
           }
           return $sub_arr;
        }

}
