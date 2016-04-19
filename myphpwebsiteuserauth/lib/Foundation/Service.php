<?php

namespace Lib\Foundation;

interface Service
{ 
  public function init(Request $request, Session $session);
  
  public function run($action) : Response;
  
}