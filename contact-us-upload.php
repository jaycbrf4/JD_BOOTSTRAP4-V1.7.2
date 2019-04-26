<?php
/* Template Name: Contact-Page-with-upload
*
* A Custom PHP Contact us page. Add or change form fields on line 56 and in the form itself.
* Jquery is used to add/remove Bootstrap is-invalid class to invalid fields.
*/

/**
* Get Error Class
*
* @return string;
*/

$response = '';

function getErrorClass($failedKeys, $key)
{ 
if(isset($failedKeys) && is_array($failedKeys) && in_array($key, $failedKeys))
{
  return 'is-invalid';
}

return '';
}

if(isset($_POST) && !empty($_POST))
{
// New Line Tag
$nL = "<br />";
 
// Response generation function
 
// Fuction to generate response
  function my_contact_form_generate_response($type, $message)
  {
    global $response;

    if($type == "success") 
    {
      $response = "<div class='success alert alert-success wow fadeIn' role='alert' id='success-message'> <i class='fal fa-thumbs-up'></i> &nbsp; {$message}</div>";
    }
    else 
    {
      $response = "<div class='error alert alert-danger wow fadeIn' role='alert' id='error-message'><i class='fal fa-thumbs-down'></i> &nbsp; {$message} </div>";
    }
  }
// Response messages
$missing_content  = "Please supply all information.";
$email_invalid    = "Email Address Invalid.";
$message_unsent   = "Message was not sent. Try Again.";
$message_sent     = "Thanks! Your message has been sent.";
 
// Define the fields we use, title => field name
// This can be used to add fields into auto-validation below. 
$userVariables = [
  'First Name'  => 'first_name',
  'Last Name'   => 'last_name',
  'Phone'       => 'phone',
  'Email'       => 'email',
  'Comment'     => 'comment'
];

// Instantiate variables for failed, successful validated fields
$failedFields   = [];
$validFields    = [];
$failedKeys     = [];
 
// Loop through each variable defined above, and check it's validity as a non-blank string. 
// If successful, add it to the message array and strip all tags for security, and trim whitespace
if(!empty($_POST))
{
  foreach($userVariables as $title => $userField)
  {
    // If our field did not pass validation, we push to failedFields array
    if(!isset($_POST[$userField]) || !is_string($_POST[$userField]) || $_POST[$userField] == '')
    {
      $failedFields[]   = $title;
      $failedKeys[]     = $userField;
    }
    // If successful, add this to validFields array and trim/clean the content
    else
    {
      $validFields[$title] = trim(strip_tags(($_POST[$userField])));
    }
  } 
}

// If we have > 0 failed fields, we will send a error response to the form
if(!empty($failedFields))
{
  // Concatenate message with failed fields in the message
  $failureMessage = "The following fields are required: " . implode(', ', $failedFields);
  my_contact_form_generate_response("error", $failureMessage);
}
// Create HTML message
$message  = '<html><head>';
// define the Google Font used in the message
$message .='<style>@import url("https://fonts.googleapis.com/css?family=Open+Sans:400,600");</style>';
$message .='</head>';
$message .='<body style="font-family:Open Sans, sans-serif; font-weight:400;">';
$message .= "<h3>Message from contact form on" .get_bloginfo('name') ."</h3>";
$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';

// If we have valid fields listed above, we will concatenate a message for the email body then close the table, body, and html tags
if(!empty($validFields))
{
  foreach($validFields as $title => $value)
  {
    $message .= "<tr style='background: #eee;'><td style='width:200px; font-family: Open Sans, sans-serif; margin: 0px; padding:8px; font-weight: 600;'>" . $title . ":</td><td style='font-family: Open Sans, sans-serif; margin: 0px; padding:8px; font-weight: 400;'>" . $value . "</td></tr>";
  }
}

$message .= '</table></body></html>';
// end message

/**
*
* Handle file attachment
*
*/
if ( ! function_exists( 'wp_handle_upload' ) ) 
{
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
}

$uploadedFile     = false;
$movefile         = false;
$failedAttachment = false;

if(isset($_FILES['attachmentFile']) && file_exists($_FILES['attachmentFile']['tmp_name']))
{
  $uploadedFile = $_FILES['attachmentFile'];

  //Get the uploaded file information
  $name_of_uploaded_file = basename($uploadedFile['name']);

  //get the file extension of the file
  $type_of_uploaded_file = substr($name_of_uploaded_file, strrpos($name_of_uploaded_file, '.') + 1);

  $size_of_uploaded_file = $uploadedFile["size"] / 1024; //size in KBs

  //Settings
  $max_allowed_file_size  = 2000; // size in KB
  $allowed_extensions     = array("jpg", "jpeg", "png", "pdf");
  $upload_overrides       = array( 'test_form' => false );

  //Validations
  if($size_of_uploaded_file > $max_allowed_file_size)
  {
    $failedKeys[]     = 'attachmentFile';
    $failedFields[]   = 'Uploaded File';
    $failedAttachment = true;
    my_contact_form_generate_response("error", "Size of uploaded file should be less than ". round($max_allowed_file_size / 1024). "mb ");
  }

  //------ Validate the file extension 
  $allowed_ext = false;

  for($i = 0; $i <sizeof($allowed_extensions); $i++)
  {
    if(strcasecmp($allowed_extensions[$i], $type_of_uploaded_file) == 0)
    {
      $allowed_ext = true;
    }
  }

  if(!$allowed_ext)
  {
    $failedKeys[]     = 'attachmentFile';
    $failedFields[]   = 'Uploaded File';
    $failedAttachment = true;
    my_contact_form_generate_response("error", "The uploaded file is not supported file type. Only the following file types are supported: ".implode(', ',$allowed_extensions));
  }

  if(!$failedAttachment)
  {
    $movefile = wp_handle_upload($uploadedFile, $upload_overrides);

    if($movefile && ! isset( $movefile['error'] ) ) {

        $movefile['url'];
    }
  }
}

if(empty($failedFields) && !$failedAttachment && isset($_POST['gotcha']) && $_POST['gotcha'] == '')
{
  // Mailer variables
  $to           = get_option('admin_email');
  $email        = $_POST['email'];
  $subject      = "Message from contact form on ".get_bloginfo('name');
  $headers      = 'From: '. $email . "\r\n" . 'Reply-To: ' . $email . "\r\n";
  $attachment   = $movefile && isset($movefile['file']) ? $movefile['file'] : false;

  // Add HTML response type support to the email
  add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
  
  // Create the message and send, returning success variable
  $sent = wp_mail($to, $subject, $message, $headers, $attachment);

  // If successful, kick back success on form
  if($sent) 
  {
    my_contact_form_generate_response("success", $message_sent); 
  }
  // On failure, send error response back to the form
  else 
  {
    my_contact_form_generate_response("error", $message_unsent); 
    unlink( $movefile['file'] );
  }
}
else if(($_POST['submitted'] || !empty($failedFields)) && !$failedAttachment) 
{
  my_contact_form_generate_response("error", $failureMessage);
}
}
?>
<!-- End Form Logic -->


<?php get_header(); ?>
<div id="main" class="clearfix" role="main">
<div id="content">
  <div class="container wow fadeIn" data-wow-delay="0.5s">
    <div class="row">
      <div class="col">
        <h1 class="page-title">Contact Us</h1>
          <div id="respond">
            
          <?php echo $response; ?>
            <form class="form-horizontal jumbotron" action="<?php the_permalink(); ?>" method="post" id="contact_form" enctype="multipart/form-data">
              <fieldset>
                <legend>Do you have questions, interested in a product or would like to inquire about delivery options?</legend>
                <p>Please fill out the contact form and we will get back to you ASAP!</p>
                  <div class="form-row">
                  <div class="col">
                    <div class="form-group">
                      <label for="first_name">First Name</label>
                        <div class="input-group">
                          <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user-circle"></i></span></div>
                          <input name="first_name" placeholder="First Name" class="form-control  <?php echo getErrorClass($failedKeys, 'first_name'); ?>" type="text" value="<?php echo esc_attr($_POST['first_name']); ?>" required>
                          <div class="invalid-feedback">Please provide your first name.</div>
                        </div>
                      </div>
                    </div><!--/.col-->
                    <div class="col"> 
                     <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <div class="input-group">
                          <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user-circle"></i></span></div>
                          <input name="last_name" placeholder="Last Name" class="form-control <?php echo getErrorClass($failedKeys, 'last_name'); ?>" type="text" value="<?php echo esc_attr($_POST['last_name']); ?>" required>
                          <div class="invalid-feedback">Please provide your last name.</div>
                        </div>
                      </div>
                    </div><!--/.col-->
                  </div><!--/.form-row-->
                  <div class="form-row">
                    <div class="col"> 
                      <div class="form-group">
                        <label for="email">E-Mail</label>
                        <div class="input-group">
                          <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-at"></i></span></div>
                          <input name="email" placeholder="E-Mail Address" class="form-control <?php echo getErrorClass($failedKeys, 'email'); ?>" type="email" value="<?php echo esc_attr($_POST['email']); ?>" required>
                          <div class="invalid-feedback">Please provide your email address.</div>
                        </div>
                      </div>
                      </div><!--/.col-->
                      
                      <div class="col"> 
                      <div class="form-group">
                        <label for="phone">Phone #</label>
                        <div class="input-group">
                          <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-mobile"></i></span></div>
                          <input name="phone" placeholder="(855)555-1212" class="form-control <?php echo getErrorClass($failedKeys, 'phone'); ?>" type="text" value="<?php echo esc_attr($_POST['phone']); ?>" required>
                          <div class="invalid-feedback">Please provide your phone number.</div>
                        </div>
                      </div>
                    </div><!--/.col-->
                  </div><!-- /.form-row -->
                  <div class="form-row">
                    <div class="col">
                    
                      <div class="form-group">
                        <label for="comment">Your Message</label>
                        <div class="input-group">
                          <div class="input-group-prepend"><span class="input-group-text"><i class="fal fa-pencil"></i></span></div>
                          <textarea class="form-control <?php echo getErrorClass($failedKeys, 'comment'); ?>" name="comment" required><?php echo esc_textarea($_POST['comment']); ?></textarea>
                          <div class="invalid-feedback">Please provide your message.</div>
                        </div>
                      </div>
                      <div class="form-group">
                         <label for="attachmentFile">Attach file</label>
                                <input type="file" name="attachmentFile" class="<?php echo getErrorClass($failedKeys, 'attachmentFile'); ?>">
                      </div><!-- /.form-group -->

                      <!--Anti-Spam Field-->
                      <div class="form-group" hidden id="gotcha">
                        <label for="gotcha">Leave this field empty</label>
                        <div class="input-group">
                          <input name="gotcha" class="form-control" type="text">
                        </div>
                      </div>
                      <div class="form-group" hidden>
                        <input type="hidden" name="submitted" value="1">
                      </div>
                      <!-- Button -->
                      <div class="form-group">
                        <button type="submit" class="btn btn-info">Send
                          <span class="fal fa-fighter-jet"></span>
                        </button>
                      </div>
                    </div><!--/.col-md-8-->
                  </fieldset>
                </form>                   
                 <script>
                // Add/Remove Bootstrap "has-error" class from invalid fields on key-up and blur
                jQuery('#new_post :input[required]').keyup(function ()
                {
                  var formElement = jQuery(this);
                     
                  
                  if(formElement.hasClass('is-invalid') && jQuery.trim(formElement.val()).length)
                  {
                    formElement.removeClass('is-invalid');
                  }
                });

                jQuery('#new_post :input[required]').blur(function ()
                {
                  var formElement = jQuery(this);
                    
                  
                  if(jQuery.trim(formElement.val()).length==0)
                  {
                    formElement.addClass('is-invalid');
                  }
                });
              </script>

            </div><!--/.respond-->
          </div><!--/.col-->
        </div><!-- /.row-->
      </div><!--/.container-->

      <!-- insert page content -->
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix'); ?> role="article">
          <section class="post_content">
            <?php the_content(); ?>
          </section>
      </article><!-- end article -->

    <?php endwhile; ?>
    <?php else : ?>
    <article id="post-not-found">
      <div class="container">
        <div class="row">
          <div class="col">
            <header>
              <h1><?php _e("Not Found", "JD_BOOTSTRAP"); ?></h1>
            </header>
            <section class="post_content">
              <p><?php _e("Sorry, but the requested resource was not found on this site.", "JD_BOOTSTRAP"); ?></p>
            </section>
          </div><!-- /.col-sm-12 -->
        </div><!-- /.row -->
      </div><!-- /.container -->          
    </article>

    <?php endif; ?>

  </div><!-- /content -->
</div><!-- /main -->
  <?php get_footer(); ?>
