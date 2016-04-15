<?php 

namespace Library\Model;

use Library\System\Object;

interface Entity
{  
  public function save();
  
  public function delete();
  
  public function toArray();
  
}
