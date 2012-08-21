var i;

$(function(){

  if ($('#status').length > 0)
  {
      $('input[type="submit"]').css('display', 'none')
      i = 0;
      var t = setTimeout(update_content, 100);

      function update_content()
      {
          $.get('import.php?i=' + i, function (response)
          {
              $('#status').append(response);
              i ++;
              if (i < total_files)
              {
                  update_content();
              }
              else if (i == total_files)
              {
                  $('input[type="submit"]').fadeIn('fast');
              }
          });
      }

  }

});
