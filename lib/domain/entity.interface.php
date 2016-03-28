<?php 

namespace Lib\Domain;

use Lib\Core\Object;

interface Entity
{  
  public function save();
  
  public function delete();
  
  public function toArray();
  
}
