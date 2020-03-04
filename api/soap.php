<?php 

$soapclient = new SoapClient("http://www.corwell.hu/services/vision.asmx?WSDL");

$response = $soapclient->GetCikkcsoportok();

var_dump($response);
