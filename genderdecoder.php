<?php

$currentpath = get_stylesheet_directory();
$malewordsfound=array();
$femalewordsfound=array();
$malewords = [
    'active', 'adventurous', 'aggress', 'ambition', 'analyse', 'assert', 'athlete', 'autonomous', 'battle', 'boast',
    'challenge', 'champion', 'competition', 'confident', 'courage', 'decide', 'decision', 'decisive', 'defend',
    'determine', 'dominate', 'dominant', 'driven', 'fearless', 'fight', 'force', 'greedy', 'head-strong', 'headstrong',
    'hierarch', 'hostile', 'impulsive', 'independent', 'individual', 'intellect', 'lead', 'logic', 'objective',
    'opinion', 'outspoken', 'persist', 'principle', 'reckless', 'self-confident', 'self-reliant', 'self-sufficient',
    'selfconfident', 'selfreliant', 'selfsufficient', 'stubborn', 'superior', 'unreasonable',
];
$femalewords = [
	'agree','affectionate','child','cheer','collab','commit','communal','compassion','connect','considerate',
	'cooperative','co-operate','depend','emotional','empath','feel','flatterable','gentle','honest','interpersonal',
	'interdependent','interpersonal','inter-personal','inter-dependent','inter-persona','kind','kinship','loyal',
	'modesty','nag','nurture','pleasant','polite','quiet','responsive','sensitive','submissive','support','sympathy',
	'tender','together','trust','understand','warm','whine','enthusiastic','inclusive','share','sharing'];
$jobad = $_POST["textarea"];
$words = explode(' ', $jobad);
$malewordsfound = [];
$femalewordsfound = [];

foreach ($words as $word) {
  if(in_array($word, $malewords)) {
        array_push($malewordsfound,$word);
   }
}

print_r($malewordsfound);

foreach ($words as $word) {
  if(in_array($word, $femalewords)) {
        array_push($femalewordsfound,$word);
   }
}

print_r($femalewordsfound);


?>
