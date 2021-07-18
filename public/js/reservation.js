    //validating setting form.
    $("#settingForm").validate({
        rules: {
            n: {
                required: true,
        digits:true
            },
            tz: {
                required: true
            }
        },
        messages: {
            n: {
                required: 'Please enter n.'
            },
            tz: {
                required: 'Please enter tz.',
            },
        },
        errorPlacement: function(error, element)
        {   	
            error.insertAfter(element);
            $(element).addClass('is-invalid');
        },
        submitHandler: function(form) {
        }
    });

    //submitting setting form
    $('#settingForm').submit(function(e){
        e.preventDefault();
        var result = $("#settingForm").validate();
        if(!result.valid()){
            return false;
        }
        
        $.ajax({
            type: 'PATCH',
            url: '/reservation/setting',
            data: {
                '_token' : $('input[name="_token"]').val(),
                'n' : $('#n').val(),
                'd' : $('#d').val(),
                'g' : $('#g').val(),
                'tz' : $('#tz').val(),
            },
            success: function(data){    
                if(data.result == 'success'){
                    $('#step-1-form').hide();
                    $('#step-2-form').fadeIn(1000);
                    $('.select2-container').width('372');
                }
                else if(data.result == 'failure'){  
                    var prettyJson = JSON.stringify(data, null, 4);
                    $('#jsonDisplay').html(syntaxHighlight(prettyJson));
                    $('#jsonDisplay').removeClass('d-none').show();
                }else if(data.result == 'validation-error'){
                    let x = data.messages;
                    for (key in x) {
                        $('#'+key).addClass('is-invalid');
                        $('.error-'+key).html(x[key]);
                    }
                }
            },
            error: function(data){
                
            }
        });
    });

    //initializing select2.
    $('#name').select2({
        ajax: {
            url: '/get-users',
            data: function (params) {
                var query = {search: params.term,page: params.page || 1}
                return query;
            }
        }
    });
    
    //jquery datetimepicker.
    $('#date').datetimepicker({minDate:0});

    //validating reservation form.
    $("#reservationForm").validate({
        rules: {
            name: {
                required: true
            },
            date: {
                required: true
            },
        },
        messages: {
            name: {
                required: 'Please select users.'
            },
            date: {
                required: 'Please select date.',
            },
        },
        errorPlacement: function(error, element)
        {   	
            if (element.is("#name"))
                $(".error-name").html(error);          
            else
                error.insertAfter(element);
            $(element).addClass('is-invalid');
        },
        submitHandler: function(form) {
        }
    });

    //submitting reservation form.
    $('#reservationForm').submit(function(e){
        e.preventDefault();
        var result = $("#reservationForm").validate();
        
        if(!result.valid()){
            return false;
        }
        
        $.ajax({
            type: 'POST',
            url: '/reservation/create',
            data: {
                '_token' : $('input[name="_token"]').val(),
                'user_ids' : $('#name').val(),
                'date' : $('#date').val(),
            },
            success: function(data){
                if(data.result == 'success'){
                    $('#server-message').html(data.message).show();
                }
                else if(data.result == 'failure'){
                    var prettyJson = JSON.stringify(data, null, 4);
                    $('#server-message').html(data.message).show();
                    $('#jsonDisplay').html(syntaxHighlight(prettyJson));
                    $('#jsonDisplay').removeClass('d-none').show();
                }else if(data.result == 'validation-error'){
                    let x = data.messages;
                    for (key in x) {
                        $('#'+key).addClass('is-invalid');
                        $('.error-'+key).html(x[key]);
                    }
                }
            },
            error: function(data){
            }
        });
    });

    //function to format json
    function syntaxHighlight(json) {
        if (typeof json != 'string') {
            json = JSON.stringify(json, undefined, 2);
        }
        json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
            var cls = 'number';
            if (/^"/.test(match)) {
                if (/:$/.test(match)) {
                    cls = 'key';
                } else {
                    cls = 'string';
                }
            } else if (/true|false/.test(match)) {
                cls = 'boolean';
            } else if (/null/.test(match)) {
                cls = 'null';
            }
            return '<span class="' + cls + '">' + match + '</span>';
        });
    }
