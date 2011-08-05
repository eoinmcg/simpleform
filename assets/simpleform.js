
$(document).ready(function () {

  // ------------------------- forms
  $("div.error").hide().fadeIn("slow");

  $('form :input:visible:enabled:first').focus().parents('div').addClass('active');
  $('form input, form textarea, form select, form checkbox, form radio').focus(function () {
    $(this).parents('div:first').addClass('active');
  });
  $('form input, form textarea, form select, form checkbox').blur(function () {
    $(this).parents('div:first').removeClass('active');
  });

  $('form div.required label').each(function() {
    console.log( $(this).html() );
    $(this).html = $(this).html + '<span class="required">*</span>';
  });

  $('form fieldset.closed').each(function() {
    $(this).children().not('legend').hide();
  });
  $('form fieldset.collapsible legend').click(function() {
    var parent = $(this).parents('fieldset');
    if ($(parent).hasClass('closed')) {
      $(parent).removeClass('closed');
      $(parent).children().not('legend').slideDown();
    }
    else {
      $(parent).addClass('closed');
      $(parent).children().not('legend').slideUp();
    }
  });
  // -------------------------

});
