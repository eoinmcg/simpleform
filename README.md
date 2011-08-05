Simpleform - a Codeigniter helper
=================================


This helper aims to address the dull, repeatitive but vital nature of generating forms.
----------------------------------------------------------------------------------------

## Why use Simpleform?
- Very little code is needed to generate forms
- Forms are accessible, valid, nicely formatted and easily customised with CSS
- Simple to prepopulate form and automatically update with $\_POST values.
- Generate form directly from database table
- Easy to add dates
- If the form has been validated, error messages will be automatically be 
  prepended to the form and incorrect fields highlighted

## Installing
Merge the application folder with your Codeigniter application folder.
The `assets` folder contains sample images, css and javascript ,used in the demo
Files needed:

1.  *application/helpers/simpleform_helper.php* Required. Collection of helper 
    functions.

2.  *application/libraries/MY\_Form\_Validation.php* Optional. If included will
    highlight required fields as set with the form validation library.

3.  *application/controllers/simpleform.php* Demo controller.

4. *application/views/* Various views used in the demo.

This helper is loaded using the following code:
`$this->load->helper('simpleform');`

Assuming you install to localhost/codeigniter you can see a demo at
<http://localhost/codeigniter/index.php/simpleform>

## At a glance 

    <?php
      echo sf_form_open();  
      echo sf_fieldset_open('Your Details');
      echo sf_form_input('name');
      echo sf_form_input('email'); 
      echo sf_date('dob', 'Date of Birth', FALSE, FALSE, TRUE, FALSE); 
      echo sf_checkbox('terms', '&nbsp;', FALSE, 'I agree to the <a href="#">terms and conditions</a> of this service'); 
      echo sf_fieldset_close();
      echo sf_form_close('Sign me up!');
Will result in the following form

![Screenshot](https://github.com/eoinmcg/simpleform/blob/master/screenshot.png)

![Screenshot](http://localhost/simpleform/screenshot.png)

If you are using the form validation class required fields will be highlighted
and error messages shown.

## Function reference

#### sf\_form\_open($action = FALSE, $attributes = FALSE, $allow\_files = FALSE, $hide\_error\_msg = FALSE)
Wrapper for CIs form\_open, will also prepend and validation errors.

$action (string)
:   URL where form is submitted. Leave blank to send to current page.

$attributes (array)
:   array of attributes for the <form\> tag. e.g. `array('class' => 'form_class')`

$allow\_files (bool)
:   toggles the mulitpart attribute, necessary for uploading files 

$hide\_error\_msg (bool)
:   if TRUE will not prepend the form validation error message   

#### sf\_form\_close($val = 'Send', $accesskey = FALSE)
Generate submit button. Wrapped in div.submit

$val (string)
:   Text displayed on the submit button

$accesskey (string)
:   Accesskey for submitting the form

#### sf\_fieldset\_open($legend, $class='')
Open fieldset

$legend (string)
:   Text for the legend tag

$class (string)
:   CSS class

#### sf\_fieldset\_close()
Close fieldset

#### sf\_input($name, $label = FALSE, $val='', $note=FALSE, $small=FALSE)
Creates a text input field wrapped in div served with an optional note.
Error class will be added if fails validations.

$name (string)
:   name attribute of input tag

$label (string)
:   Text for label tag. If not given it will use the name attribute

$val (string)
:   Prepopulate with value. Will be overridden if a post key exists with the
    same name

$note (string)
:   Add additional expanatory text under the input

$small (string)
:   Sets a CSS class of `small`. Useful for inputting short numbers.

#### sf\_password($name, $label = FALSE, $val='', $note=FALSE)
Password Input Field. Wrapped in div, served with optional note and error if
fails validations

$name (string)
:   name attribute of input tag

$label (string)
:   Text for label tag. If not given it will use the name attribute

$val (string)
:   Prepopulate with value. Will be overridden if a post key exists with the
    same name

$note (string)
:   Add additional expanatory text under the input


#### sf\_hidden($name, $val='')
Hidden Input Field. Wrapped in div with hidden class.

$name (string)
:   name attribute of input tag

$val (string)
:   Prepopulate with value. Will be overridden if a post key exists with the
    same name

#### sf\_textarea($name, $label = FALSE, $val='', $note=FALSE, $class='')
With optional note and error class added in case of validation fail

$name (string)
:  Textarea name 

$label (string)
:   Text for label tag. If not given it will use the name attribute

$val (string)
:   Prepopulate with value. Will be overridden if a post key exists with the
    same name

$note (string)
:   Add additional expanatory text under the input

$class (string)
:   CSS class

#### sf\_checkbox($name, $label = FALSE, $val='', $note = FALSE)
Input type checkbox, wrapped in div, optional note and error class if validation fail

$name (string)
:  Input name attribute 

$label (string)
:   Text for label tag. If not given it will use the name attribute

$val (string)
:   Prepopulate with value. Will be overridden if a post key exists with the
    same name

$note (string)
:   Add additional expanatory text under the input

#### sf\_radio($name, $label = FALSE, $options = array(), $val = FALSE, $note = FALSE)
 Creates a group of radio buttons from array
 Wrapped in div, served with optional note and error

$name (string)
:  Input name attribute 

$label (string)
:   Text for label tag. If not given it will use the name attribute

$options (array)
:   Key value pairs for radio buttons   

$val (string)
:   Preset value attribute. pass a a comma delimited string. Will be
    overridden by $_POSTed values.

$note (string)
:   Add additional expanatory text under the input

#### sf\_select($name, $label = FALSE, $options = array(), $val = FALSE, $note = FALSE)
 Creates a select dropdown from array
 Wrapped in div, served with optional note and error

$name (string)
:  Input name attribute 

$label (string)
:   Text for label tag. If not given it will use the name attribute

$options (array)
:   Key value pairs for select option tags

$val (string)
:   Preset value attribute. Will be overridden by $\_POSTed values.

$note (string)
:   Add additional expanatory text under the input


#### sf\_multi\_select($name, $label = FALSE, $options = array(), $val='', $note=FALSE)
 Creates a list of checkboxes from array
 Wrapped in div, served with optional note and error

$name (string)
:  Input name attribute 

$label (string)
:   Text for label tag. If not given it will use the name attribute

$options (array)
:   Key value pairs for checkbox tags

$val (string)
:   Preset value attribute. pass a a comma delimited string. Will be
    overridden by $_POSTed values.

$note (string)
:   Add additional expanatory text under the input

#### sf\_date($name, $label = FALSE, $date = FALSE, $year\_range = FALSE, 					$set\_blank = FALSE, $show\_hours\_mins = FALSE)
 Generates a select fields for day month year. Hours and minutes can be
 optionally added

$name (string)
:  Input name attribute 

$label (string)
:   Text for label tag. If not given it will use the name attribute

$date (int)
:  Preset date with UNIX timestamp 

$year\_range (array)
:  Year to start and end. e.g. `array('2000', '2020')` year range is from 2000
  to 2020

$set\_blank (bool)
:  If TRUE starts with a blank date 

$show\_hours\_mins (bool)
:  If True adds 2 extra fields for hours and minutes

#### sf\_db\_table($table, $data = array(), $ignore = array(), $show\_primary\_key = FALSE)
Creates a form based on a table (MySQL only)
Will try to guess which type of form input to generate:

-   int, with a length of 1 = checkbox
-   int, with a length of 11 = date
-   text or varchar >= 512 = textarea
-   varchar with name _pass_ or _password_ = input password
-   varchar = input text (default)

$table (string)
:   Name of table

$data (array)
:   prepopulate the form

$ignore (array)
:   fields not too include in the form

$show\_primary\_key (bool)
:   Whether to display the primary key in the form.
    If FALSE will include as a hidden form field 





 
