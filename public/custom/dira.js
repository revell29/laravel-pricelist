"use strict"
    var swalInit = swal.mixin({
        buttonsStyling: false,
        confirmButtonClass: 'btn btn-primary',
        cancelButtonClass: 'btn btn-light'
    });

    function notification(title,text, type,bg) {
        new PNotify({
            title: title,
            text: text,
            type: type,
            addclass: bg
        });
        if (type == 'success') {
            var audio = $('#success-audio')[0];
            if (audio !== undefined) {
                audio.play();
            }
        } else if (type == 'error') {
            var audio = $('#error-audio')[0];
            if (audio !== undefined) {
                audio.play();
            }
        } else if (type == 'warning') {
            var audio = $('#warning-audio')[0];
            if (audio !== undefined) {
                audio.play();
            }
        }
    }

    function createWithoutImage(url,formData,btn,index) {
        $.ajax({
            url: url,
            method: "POST",
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                btn.html('Please wait').prop('disabled', true);
            },
            success: function(response) {
                swalInit.fire({
                title: "Success!",
                text: response.message,
                type: 'success',
                buttonStyling: false,
                confirmButtonClass: 'btn btn-primary btn-lg',
                }).then(function() {
                window.location.href = index;
                })
            },
            error: function(response) {
                if (response.status == 500) {
                console.log(response)
                swalInit.fire("Error", response.responseJSON.message, 'error');
                }
                if (response.status == 422) {
                var error = response.responseJSON.errors;

                }
                btn.html('Submit').prop('disabled', false);
            }
        });
    }

    function createWithImage(url,formData,btn,index) {
        $.ajax({
            url: url,
            method: "POST",
            data: formData,
            dataType: 'json',
            async: true,
            contentType: false,
            processData: false,
            beforeSend: function() {
                btn.html('Please wait').prop('disabled', true);
            },
            success: function(response) {
                swalInit.fire({
                title: "Success!",
                text: response.message,
                type: 'success',
                buttonStyling: false,
                confirmButtonClass: 'btn btn-primary btn-lg',
                }).then(function() {
                window.location.href = index;
                })
            },
            error: function(response) {
                if (response.status == 500) {
                console.log(response)
                swalInit.fire("Error", response.responseJSON.message, 'error');
                }
                if (response.status == 422) {
                var error = response.responseJSON.errors;

                }
                btn.html('Submit').prop('disabled', false);
            }
        });
    }

    function confirmUpdate(url, formData,btn,index) {
        swal.fire({
            title: 'Are you sure you want to update this data?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: "Yes, update!",
            cancelButtonText: 'No, please ',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    method: "POST",
                    data: formData,
                    dataType: 'json',
                    async: true,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        btn.html('Please wait').prop('disabled', true);
                    },
                    success: function(response) {
                        swalInit.fire({
                        title: "Success!",
                        text: response.message,
                        type: 'success',
                        buttonStyling: false,
                        confirmButtonClass: 'btn btn-primary btn-lg',
                        }).then(function() {
                        window.location.href = index;
                        })
                    },
                    error: function(response) {
                        if (response.status == 500) {
                        console.log(response)
                        swalInit.fire("Error", response.responseJSON.message, 'error');
                        }
                        if (response.status == 422) {
                        var error = response.responseJSON.errors;
        
                        }
                        btn.html('Submit').prop('disabled', false);
                    }
                });
            }
        })
    }
    
    $('.styled').uniform();

    $('.select').select2();
    
    $('.select-nosearch').select2({
        minimumResultsForSearch: Infinity
    })

    $('.number').number(true,0,',','.');


    function deleteImage(id,URL_DELETE) {
        $.ajax({
            url: URL_DELETE,
            method: 'GET',
            success: function(response) {}
        })
    }