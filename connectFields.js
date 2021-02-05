var subject_line = $('#subject-line');
var name_line = $('#name-line');
var address_line = $('#address-line');
var content_line = $('#content-line');
var date_line = $('#date-line');


var frame, allInputFields, allTextareaFields, lastScrollTop = 0;

var allEmailFields = $('.field');
var map = {
    'subject': null,
    'name': null,
    'address': null,
    'date': null,
    'content': null
}

$(document).ready(function () {
    $(function () {
        $('#myFrame').on('load', function () {
            console.log("FRAME LOADED");

            $("input[type=checkbox]").click(function () {
                if ($(this).checked)
                    console.log("Checked to unchecked");
            });

            frame = $('#myFrame');

            frame.contents().scroll(function () {
                lastScrollTop = $(this).scrollTop();
            })

            allInputFields = frame.contents().find('.form-line input');
            allTextareaFields = frame.contents().find('.form-line textarea');

            // FORMU KÜÇÜLT
            minimizeFrame();

            // Email üzerinde secilen bir field
            $('.field').on('click', function () {
                var v = this;
                $(this).css({'border': '2px solid rgb(75, 188, 239)', 'border-radius': '4px'});
                $('.field').not(this).css({'animation': 'none', 'border': 'none'});

                var type = $(this).attr('class');

                if (type.indexOf('subject') >= 0) {

                    //Seçilebilecek fieldları belirginleştirmek için
                    frame.contents().find('input[data-type="input-textbox"]')
                        .css({'border': '2px solid #F8A61C', 'animation': 'pulse 2s infinite', 'border-radius': '4px'});

                    //formdan da uygun field seçildiğinde ikisini bağlamak için
                    frame.contents().find('input[data-type="input-textbox"]').on('click',
                        function () {
                            if (map.subject == null) {
                                frame.contents().find('input[data-type="input-textbox"]').not(this).css('border', '1px solid #c3cad8');
                                connect(this, v, subject_line);
                                const id = $(this).attr("id");
                                map.subject = id.substring(id.lastIndexOf("_") + 1);
                                $('#subject').attr('checked', 'checked');
                            }
                        })
                } else if (type.indexOf('name') >= 0) {

                    frame.contents().find('input[data-type=input-textbox]')
                        .css({'border': '2px solid #F8A61C', 'animation': 'pulse 2s infinite', 'border-radius': '4px'});

                    //formdan da uygun field seçildiğinde ikisini bağlamak için
                    frame.contents().find('input[data-type=input-textbox]').on('click',
                        function () {
                            if (map.name == null) {
                                frame.contents().find('input[data-type="input-textbox"]').not(this).css('border', '1px solid #c3cad8');
                                connect(this, v, name_line);
                                const id = $(this).attr("id");
                                map.name = id.substring(id.lastIndexOf("_") + 1);
                                $('#name').attr('checked', 'checked');
                            }
                        })
                } else if (type.indexOf('address') >= 0) {
                    frame.contents().find('input[data-component="email"]')
                        .css({'border': '2px solid #F8A61C', 'animation': 'pulse 2s infinite', 'border-radius': '4px'});

                    frame.contents().find('input[data-component="email"]').on('click',
                        function () {
                            connect(this, v, address_line);
                            const id = $(this).attr("id");
                            map.address = id.substring(id.lastIndexOf("_") + 1);
                            $('#address').attr('checked', 'checked');
                        })
                } else if (type.indexOf('date') >= 0) {
                    var date = frame.contents().find('li[data-type=control_datetime] input')[3];

                    $(date).css({
                        'border': '2px solid #F8A61C',
                        'animation': 'pulse 2s infinite',
                        'border-radius': '4px'
                    });

                    //formdan da uygun field seçildiğinde ikisini bağlamak için
                    $(date).on('click', function () {
                        connect(this, v, date_line);
                        const id = $(this).attr("id");
                        map.date = id.substring(id.lastIndexOf("_") + 1);
                        $('#date').attr('checked', 'checked');
                    })
                } else if (type.indexOf('content') >= 0) {
                    frame.contents().find('textarea[data-component="textarea"]')
                        .css({'border': '2px solid #F8A61C', 'animation': 'pulse 2s infinite', 'border-radius': '4px'});

                    frame.contents().find('textarea[data-component="textarea"]').on('click',
                        function () {
                            connect(this, v, content_line);
                            const id = $(this).attr("id");
                            map.content = id.substring(id.lastIndexOf("_") + 1);
                            $('#content').attr('checked', 'checked');
                        })
                } else {
                    alert('Undefined type detected. Open console for details');
                    console.err('Type: ' + type);
                }
            })
        })
    })

})


function minimizeFrame() {
    frame.contents().find('body').css({
        'display': 'flex',
        'justify-content': 'center',
        'font-size': '12px',
        'margin': '0',
        'height': '100%'
    });
    frame.contents().find('form').css({'width': '100%'});
    frame.contents().find('form .form-all').css({'margin': 'auto', 'height': '100%'});
    frame.contents().find('.form-header-group').css('border-bottom', 'none');
    frame.contents().find('.header-large .form-header').css('font-size', '1.5rem');
    frame.contents().find('[data-type=control_head]').css('border-bottom', '1px solid #d7d8e1');
    frame.contents().find('.form-line label').css('font-size', '14px');
    frame.contents().find('.form-line[data-type=control_button]').remove();
}

function connect(form_field, email_field, line) {

    var msx, msy, fsx, fsy;

    line.css("display", "block");

    $(email_field).addClass('u-border');
    $(form_field).css('border', '2px solid rgb(75, 188, 239)');
    $(form_field).css('box-shadow', '4px 6px 18px 8px rgba(75, 188, 239,1);');
    $(form_field).css('border-radius', '4px');

    msx = $(email_field).offset().left + 1;
    msy = $(email_field).offset().top + ($(email_field).height() / 2 + 5);

    if ($(form_field).attr("class").indexOf("Date") > -1)
        fsx = $(form_field).offset().left + frame.offset().left + $(form_field).width() + 50;
    else
        fsx = $(form_field).offset().left + frame.offset().left + $(form_field).width() + 20;

    if ($(form_field).attr("class").indexOf("Date") > -1)
        fsy = $(form_field).offset().top + frame.offset().top - $(form_field).height() * 2 - 10;
    else
        fsy = $(form_field).offset().top + frame.offset().top + ($(form_field).height() / 2) + 5 - lastScrollTop;

    line.attr('x1', msx).attr('y1', msy).attr('x2', fsx).attr('y2', fsy);
    setTimeout(function () {
        line.css("display", "none");
        $(form_field).css("border", "1px solid rgb(195, 202, 216)");
        $(email_field).removeClass("u-border");
        $(email_field).css("border", "none");
    }, 1000);
}

function setOthersDefault(formField, emailField) {
    allTextareaFields.css('border', '1px solid #c3cad8');

    for (var i = 0; i < allInputFields.length; i++)
        if (allInputFields[i] != formField[0])
            $(allInputFields[i]).css('border', '1px solid #c3cad8');

    for (var i = 0; i < allEmailFields.length; i++)
        if (allEmailFields[i] != emailField[0])
            $(allEmailFields[i]).removeClass('u-border');

}

function checkMapping() {
    for (let i in map)
        if (map[i] === null) {
            alert("Match Missing!!!");
            return false;
        }

    document.cookie = "subjectId=" + map.subject;
    document.cookie = "nameId=" + map.name;
    document.cookie = "contentId=" + map.content;
    document.cookie = "addressId=" + map.address;
    document.cookie = "dateId=" + map.date;

    top.location = "search.php";
}