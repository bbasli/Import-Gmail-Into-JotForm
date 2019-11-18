  

    $('#box_0').on('change', function () {
        $('select option:disabled').prop('disabled', false);
        var sel = $('option:selected', this).index();
        if ($.isNumeric($(this).val()) && $(this).val() !== "0")
            $('#box_2 option:eq("' + sel + '")').prop('disabled', true);
    });

    $('#box_2').on('change', function () {
        $('select option:disabled').prop('disabled', false);
        var sel = $('option:selected', this).index();
        if ($.isNumeric($(this).val()) && $(this).val() !== "0")
            $('#box_0 option:eq("' + sel + '")').prop('disabled', true);
    });

    function addOption(box_id, input_id){
        var select = document.getElementById(box_id.substring(1));
        var size = $(box_id+" > option").length;
        var field_name = $(input_id).val();
        if (field_name.length > 0) {
            select.remove(size-1);
            select.options[select.options.length] = new Option(field_name, field_name);
            select.options[select.options.length] = new Option('Add a new question', '0');
            $(box_id).val(field_name).change();
        }else
            $(box_id).val("-1").change();
        
        $(input_id).val("");
        $(input_id).css("display", "none");
    }

    $('#selects').on('change', function(event) {
        let id_box = "#" + event.target.id;
        let order = id_box.substring(id_box.indexOf("_")+1);
        let id_input = "#input" + order;
         if ($(id_box).val() === "0")
            $(id_input).css("display", "block");
        else
            $(id_input).css("display", "none");

        $(id_input).keypress(function(event)  {
            if (event.which === 13){
                addOption(id_box, id_input);
            }                
        });
    });

    $(document).on('keypress', 'form', function(e){
       var code = e.keyCode || e.which;
       if (code == 13 && ! $(e.target).is("textarea, input[type='submit'], input[type='button']")) {
          e.preventDefault();
          return false;
       }
    });
    
    $('#submit').on("click", function(event) {
        if($('#box_0').val() === "-1" || $('#box_1').val() === "-1" || $('#box_2').val() === "-1" 
            || $('#box_3').val() === "-1" || $('#box_4').val() === "-1")  {
                
                $('#error').text("You have to select all neccessary field!");
                event.preventDefault();
            }
    });
    
    
    
    
    