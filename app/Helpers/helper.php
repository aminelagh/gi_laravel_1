<?php

function getData(){
  return "Data is here";
}


function getMonthName($month){
  switch ($month) {
    case 1:   return "Janvier";
    case 2:   return "Février";
    case 3:   return "Mars";
    case 4:   return "Avril";
    case 5:   return "Mai";
    case 6:   return "Juin";
    case 7:   return "Juillet";
    case 8:   return "Août";
    case 9:   return "Septembre";
    case 10:  return "Octobre";
    case 11:  return "Novembre";
    case 12:  return "Decembre";
    default:  return $month;
  }
}

function getSommeDuree($h,$m,$s){
  while($s>59){
    $s = $s - 60;
    $m = $m + 1;
  }

  while($m>59){
    $m = $m - 60;
    $h = $h + 1;
  }
  return $h." : " .$m. " : ".$s;
}
