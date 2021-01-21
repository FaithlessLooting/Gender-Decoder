<?php
   /*
   Plugin Name: Gender Decoder
   Plugin URI: https://github.com/FaithlessLooting/Gender-Decoder
   description: Based on a tool created by @LovedayBrooke availble from http://gender-decoder.katmatfield.com/ This tool is intended to allow recruiters to check if a job description will appeal more to a male or female candidate
   Version: 1.1
   Author: Matthew Dove
   Author URI: TBC
   License: GPL2
   */
?>

<?php
// create custom plugin settings menu
add_action('admin_menu', 'gender_decoder_create_menu');

function gender_decoder_create_menu() {

	//create new top-level menu
	add_menu_page('Gender Decoder Settings', 'Gender Decoder Settings', 'administrator', __FILE__, 'gender_decoder_settings_page' , plugins_url('/images/icon.png', __FILE__) );

	//call register settings function
	add_action( 'admin_init', 'register_gender_decoder_settings' );
}


function register_gender_decoder_settings() {
	//register our settings
	register_setting( 'gender-decoder-settings-group', 'masculine_words' );
	register_setting( 'gender-decoder-settings-group', 'feminine_words' );
}
//function to render settings page in admin area
function gender_decoder_settings_page() {
?>
<div class="wrap">
<h1>Gender Decoder</h1>
<!-- post to options API -->
<form method="post" action="options.php">
    <?php
		//Wordpress requires these
		settings_fields( 'gender-decoder-settings-group' );
    do_settings_sections( 'gender-decoder-settings-group' );

		?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Masculine words</th>
				<!-- controls input for list of Masculine coded words -->
        <td><input type="text" name="masculine_words" value="<?php echo esc_attr( get_option('masculine_words') ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Feminine Words</th>
				<!-- controls input for list of Feminine coded words -->
        <td><input type="textarea" name="feminine_words" value="<?php echo esc_attr( get_option('feminine_words') ); ?>" /></td>
        </tr>
    </table>

    <?php
		//echo form submission button
		submit_button();

		?>

</form>
</div>
<?php } ?>

<?php
//function to render form and carry out actions on shortcode call
function gender_decoder_content_shortcode(){
	//start buffer and add form section
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
  </form>';
	//end of buffered section

		//declarations
    $malewordsfound=array();
    $femalewordsfound=array();
		$malewordsfound = [];
		$femalewordsfound = [];
		//fetch list of words from options page as string and sanitize incase of malicous inputs
    $malewords =sanitize_text_field(get_option('masculine_words'));
		//convert string to array
		$malewords = explode(" " , $malewords);
		//fetch list of words from options page as string and sanitize incase of malicous inputs
		$femalewords = sanitize_text_field(get_option('feminine_words'));
		//convert string to array
		$femalewords = explode(" " , $femalewords);

		//if user has submitted an input
		if(isset($_POST["textarea"])){
			//sanitize input
        $jobad = htmlspecialchars($_POST["textarea"]);
    }
		//convert advert to array of words to loop through
    $words = explode(' ', $jobad);

		//foreach word in advert
    foreach ($words as $word) {
			//if male words list contains the current word
      if(in_array($word, $malewords)) {
				//push current word to an array to report later
            array_push($malewordsfound,$word);
       }
    }
		//if there is an advert to display
    if(!empty($jobad)){
      echo '<div class="row">';
        echo '<div class="container">';
        echo '<h2> Your Advert</h2>';
				//echo out advert for user (escaping any tags to avoid malicous inputs)
      echo esc_html($jobad)."<br>";
    }
		//if any male coded words are found
    if(!empty($malewordsfound)){
    echo "Masculine-coded words in this ad:";
    echo "<ul>";
		//for each of those words found
    foreach ($malewordsfound as $output) {
      echo "<li>";
			//report word found in unordered list element (escaping any tags to avoid malicous inputs)
      echo esc_html($output);
      echo "</li>";
    }
    echo "</ul>";
}

		//foreach word in advert
    foreach ($words as $word) {
			//if female words list contains the current word
      if(in_array($word, $femalewords)) {
					//push current word to an array to report later
        	array_push($femalewordsfound,$word);
       }
    }
		//if any female coded words are found
if(!empty($femalewordsfound)){
    echo "Feminine-coded words in this ad:";
    echo "<ul>";
		//for each of those words found
    foreach ($femalewordsfound as $output) {
      echo "<li>";
			//report word found in unordered list element (escaping any tags to avoid malicous inputs)
      echo esc_html($output);
      echo "</li>";
    }
    echo "</ul>";
}
		//get buffer from top of function
    $output = ob_get_contents();
		//end buffer recording
    ob_end_clean();
		//return form to page where shortcode is called
    return  $output;
}
//register shortcode to wordpress core
add_shortcode('gender-decoder','gender_decoder_content_shortcode');
