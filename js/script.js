$(document).ready(function(){ 
	$("#school-selector").each(function() { this.selectedIndex = 0 });
    $("#school-selector").change(function(){
      var inputValue = $(this).val();
      var dataString = "id="+inputValue;
      //AJAX call
      $.ajax({
        type: "POST",
        url: "includes/functions.php",
        data: dataString,
        success: function(result){
          //output result in page
          $(".students-details").html(result);
        }
      });

    });

    //populate school input onchnage selector
    $("#school-list").each(function() { this.selectedIndex = 0 });
    $('#school-name').val('');
    $('#school-list').on('change',function(){
         if($(this).val() != 0){
         	var selectedText = $('#school-list').find("option:selected").text();
         	selectedText = selectedText.trim();
            $('#school-name').val(selectedText);
        }else{
            $('#school-name').val('');
        }
    });
 });

