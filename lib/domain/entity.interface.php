<?php 

namespace Lib\Domain;

use Lib\System\Object;

interface Entity
{  
  public function save();
  
  public function delete();
  
  public function toArray();
  
}
