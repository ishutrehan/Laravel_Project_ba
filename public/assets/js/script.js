var abc = 0; //Declaring and defining global increement variable



$(document).ready(function() {



    //To add new input file field dynamically, on click of "Add More Files" button below function will be executed

    $('#add_more').click(function() {

        $(this).before($("<div/>", {

            id: 'filediv'

        }).fadeIn('slow').append(

            $("<input/>", {

                name: 'file[]',

                type: 'file',

                id: 'file'

            }),

            $("<br/><br/>")

        ));

    });



    //following function will executes on change event of file input to select different file   

    $('body').on('change', '#file', function() {

        if (this.files && this.files[0]) {

            abc += 1; //increementing global variable by 1



            var z = abc - 1;

            var x = $(this).parent().find('#previewimg' + z).remove();

            $(this).before("<div id='abcd" + abc + "' class='abcd'><img id='previewimg" + abc + "' src=''/></div>");



            var reader = new FileReader();

            reader.onload = imageIsLoaded;

            reader.readAsDataURL(this.files[0]);



            $(this).hide();

            $("#abcd" + abc).append($("<img/>", {

                id: 'img',

                src: '/assets/images/x.png',

                alt: 'delete'

            }).click(function() {

                $(this).parent().parent().remove();

            }));

        }

    });



    //To preview image     

    function imageIsLoaded(e) {

        $('#previewimg' + abc).attr('src', e.target.result);

    };



    $('#upload').click(function(e) {

        var name = $(":file").val();

        if (!name) {

            alert("First Image Must Be Selected");

            e.preventDefault();

        }

    });



    // morphology ---- >>

    var max_fields2 = 10; //maximum input boxes allowed

    var wrapper2 = $(".input_fields_wrap2"); //Fields wrapper

    var add_button2 = $(".add_field_button2"); //Add button ID



    var x = $(".input_fields_wrap2 .row2").length; //initlal text box count

    $(add_button2).click(function(e) { //on add input button click



        e.preventDefault();

        if (x < max_fields2) { //max input box allowed

            x++; //text box increment

            $(wrapper2).append('<div class="row2"><div class="form-group"><label for="question">Question ' + x + ':</label><textarea class="form-control textarea_' + x + '" name="question[' + x + '][0]"></textarea></div><div class="form-group"><label for="question">Answer:</label><textarea class="form-control textarea_' + x + '" name="question[' + x + '][1]"></textarea></div><a href="#" class="remove_field">Remove</a></div>');



            $('.textarea_' + x).jqte();

        }

    });



    $(wrapper2).on("click", ".remove_field", function(e) { //user click on remove text

        e.preventDefault();

        $(this).parent('div').remove();

        x--;

    })



    // << ----

    // Frontend



    $("#save_note").on('click', function(event) {

        if ($("#txt_notes").val() != "") {
            $.ajax({

                    url: Base_Url + '/save-note',

                    type: 'POST',

                    dataType: 'json',

                    data: {

                        text: $("#txt_notes").val(),

                        dt: $("#dt").val(),

                        qid: $("#qid").val()

                    },

                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                    }

                })

                .done(function(res) {
                    $("#notes").append('<li><a href="'+res.key+'">' + $("#txt_notes").val() + ' - ' + res.id + '</a></li>');
                    console.log("success", res);
                    $("#txt_notes").val('');

                })

                .fail(function() {

                    console.log("error");

                })

            

        }

    });



    $("#current").on('click', function(event) {

        var formData = $("#test_mcq_each").serializeArray();

        $.ajax({

                url: Base_Url + '/checkque',

                type: 'POST',

                dataType: 'json',

                data: formData,

            })

            .done(function(data) {

                var yes = 0;

                var no = 0;

                var yes2 = 0;

                var no2 = 0;

                console.log("data", data)

                for (var k in data) {

                    if (data[k].value == 'yes') {

                        $("span[data-id=" + data[k].key + "]").html("<b style='color:green'>CORRECT</b>");

                        yes2++;

                    }

                    if (data[k].value == 'no') {

                        $("span[data-id=" + data[k].key + "]").html("<b style='color:red'>INCORRECT</b>");

                        no2++;

                    }

                    if (data[k].key == data[k].uans &&  data[k].value == 'yes') {

                        yes = 1;

                    }

                    if (data[k].key == data[k].uans && data[k].value == 'no') {

                        no = 1;

                    }

                    $("#current").css('display', 'none');

                    $("#next").css('display', 'block');

                }

                console.log(">>>>>>>>",yes, no)

                $(".discussion").css('display', 'block');



                if ($("#qtype").val() == 'single') {

                    var corr = parseInt(yes2) * 100;

                    var ttc = corr / parseInt($("select").length);

                    var finl = parseInt(ttc) / 100;



                    var in_corr = parseInt(no2) * 100;

                    var tt_in = in_corr / parseInt($("select").length);

                    var finl_in = parseInt(tt_in) / 100;



                    if (yes2 > 0) {

                        var crr = (localStorage.getItem("correct") == null) ? 0 : localStorage.getItem("correct");

                        localStorage.setItem("correct", parseFloat(crr) + parseFloat(finl));

                        console.log('yes', yes2, parseFloat(crr) + parseFloat(finl))

                    }

                    if (no2 > 0) {

                        var incrr = (localStorage.getItem("incorrect") == null) ? 0 : localStorage.getItem("incorrect");

                        localStorage.setItem("incorrect", parseFloat(incrr) + parseFloat(finl_in));

                        console.log('no', no2, parseFloat(incrr) + parseFloat(finl_in))

                    }



                } else {

                    if (yes == 1) {

                        var crr = (localStorage.getItem("correct") == null) ? 0 : localStorage.getItem("correct");

                        localStorage.setItem("correct", parseFloat(crr) + 1);

                    }

                    if (no == 1 && yes == 0) {

                        var incrr = (localStorage.getItem("incorrect") == null) ? 0 : localStorage.getItem("incorrect");

                        localStorage.setItem("incorrect", parseFloat(incrr) + 1);

                    }

                }



                resetChart();

            })

            .fail(function() {

                console.log("error");

            })

            .always(function() {

                console.log("complete");

            });

    });



    $(document).on('click', '#check_all', function(event) {

        if ($(this).is(':checked')) {

            $(".subject").prop('checked', true);

        } else {

            $(".subject").prop('checked', false);

        }

    });



    function resetChart() {



        if (localStorage.getItem("correct") != null) {

            var corr = parseFloat(localStorage.getItem("correct")) * 100;

            var tt = corr / tot;

            localStorage.setItem("perc", parseFloat(tt));

            $("#pers").text(parseFloat(tt).toFixed(2));

        }



        config.data.datasets.forEach(function(dataset) {

            dataset.data[0] = parseFloat(localStorage.getItem("correct"));

            dataset.data[1] = parseFloat(localStorage.getItem("incorrect"));

        });

        window.myPie.update();

    }

});



function openCity(evt, cityName) {

    var i, tabcontent, tablinks;

    tabcontent = document.getElementsByClassName("tabcontent");

    for (i = 0; i < tabcontent.length; i++) {

        tabcontent[i].style.display = "none";

    }

    tablinks = document.getElementsByClassName("tablinks");

    for (i = 0; i < tablinks.length; i++) {

        tablinks[i].className = tablinks[i].className.replace(" active", "");

    }

    document.getElementById(cityName).style.display = "block";

    evt.currentTarget.className += " active";

}



// Get the element with id="defaultOpen" and click on it    

document.getElementById("defaultOpen").click();

    