<?php
   /*
   Plugin Name: Gender Decoder
   Plugin URI: https://github.com/FaithlessLooting/Gender-Decoder
   description: Based on a tool created by @LovedayBrooke availble from http://gender-decoder.katmatfield.com/ This tool is intended to allow recruiters to check if a job description will appeal more to a male or female candidate
   Version: 1.0
   Author: Matthew Dove
   Author URI: TBC
   License: GPL2
   */
?>
<?


function gender_decoder_content_shortcode(){
  ob_start();
  echo '<form class="form-horizontal" method="post" action="">
  <fieldset>

  <!-- Form Name -->
  <legend>Gender Decoder</legend>

  <!-- Textarea -->
  <div class="form-group">
    <label class="col-md-4 control-label" for="textarea">Your Job Description</label>
    <div class="col-md-4">
      <textarea class="form-control" id="textarea" name="textarea">Paste job description here...</textarea>
    </div>
  </div>

  <!-- Button -->
  <div class="form-group">
    <label class="col-md-4 control-label" for="gendersubmit"></label>
    <div class="col-md-4">
      <button id="gendersubmit" name="gendersubmit" class="btn btn-default">Submit</button>
    </div>
  </div>

  </fieldset>
  </form>


  <div class="row">
    <div class="container">
      <h2> Your Advert</h2>';
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
      if(isset($_POST["textarea"])){
        $jobad = htmlspecialchars($_POST["textarea"]);
      }
    $words = explode(' ', $jobad);
    $malewordsfound = [];
    $femalewordsfound = [];

    foreach ($words as $word) {
      if(in_array($word, $malewords)) {
            array_push($malewordsfound,$word);
       }
    }
    echo $jobad."<br>";
    echo "Masculine-coded words in this ad:";
    echo "<ul>";
    foreach ($malewordsfound as $output) {
      echo "<li>";
      echo $output;
      echo "</li>";
    }
    echo "</ul>";

    foreach ($words as $word) {
      if(in_array($word, $femalewords)) {
            array_push($femalewordsfound,$word);
       }
    }

    echo "Feminine-coded words in this ad:";
    echo "<ul>";
    foreach ($femalewordsfound as $output) {
      echo "<li>";
      echo $output;
      echo "</li>";
    }
    echo "</ul>";    $output = ob_get_contents();
    ob_end_clean();
    return  $output;
}
add_shortcode('gender-decoder','gender_decoder_content_shortcode');
