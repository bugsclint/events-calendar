<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8' />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="Clinton L. Bugtong, Laravel, FullCalendar and Bootstrap contributors">
        <title>Events Calendar</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" >
        <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/core/main.min.css" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/list/main.min.css" rel="stylesheet" type="text/css" />
        <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

        <style>

            body {
                margin: 40px 10px;
                padding: 0;
                font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
                font-size: 14px;
            }

            .lh-condensed { line-height: 1.25; }

            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }

            #calendar {
                max-width: 900px;
                margin: 0 auto;
            }

        </style>
    </head>
    <body class="bg-light">
        <div class="container">
            <div class="py-3 text-center">
                <h2>Events Calendar</h2>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <h4 class="mb-3">Add</h4>
                    <form id="saveEventForm">

                        <div class="mb-3 input-div">
                            <label for="event">Event</label>
                            <input name="event" type="text" class="form-control" id="event" placeholder="">
                            <div class="invalid-feedback">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3 input-div">
                                <label for="from">From</label>
                                <input name="from" type="text" class="form-control" id="from" placeholder="" value="">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 input-div">
                                <label for="to">To</label>
                                <input name="to" type="text" class="form-control" id="to" placeholder="" value="">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>

                        <hr class="mb-4">
                        <h6 class="mb-3">Days</h6>

                        <div class="custom-control custom-checkbox">
                            <input name="mondays" type="checkbox" class="custom-control-input" id="mondays">
                            <label class="custom-control-label" for="mondays">Mondays</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input name="tuesdays" type="checkbox" class="custom-control-input" id="tuesdays">
                            <label class="custom-control-label" for="tuesdays">Tuesdays</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input name="wednesdays" type="checkbox" class="custom-control-input" id="wednesdays">
                            <label class="custom-control-label" for="wednesdays">Wednesdays</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input name="thursdays" value=0 type="checkbox" class="custom-control-input" id="thursdays">
                            <label class="custom-control-label" for="thursdays">Thursdays</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input name="fridays" type="checkbox" class="custom-control-input"id="fridays">
                            <label class="custom-control-label" for="fridays">Fridays</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input name="saturdays" type="checkbox" class="custom-control-input" id="saturdays">
                            <label class="custom-control-label" for="saturdays">Saturdays</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input name="sundays" type="checkbox" class="custom-control-input" id="sundays">
                            <label class="custom-control-label" for="sundays">Sundays</label>
                        </div>
                        <hr class="mb-4">
                        <button id="saveEventButton" class="btn btn-primary btn-lg btn-block" type="button">Save</button>
                    </form>
                </div>

                <div class="col-md-8 mb-4">
                    <div id='calendar'></div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js" type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" type="text/javascript"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/core/main.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/list/main.min.js" type="text/javascript"></script>
        <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>

        <script>

            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    plugins: ['list'],
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'listDay,listWeek,dayGridMonth'
                    },
                    // customize the button names,
                    // otherwise they'd all just say "list"
                    views: {
                        listDay: {buttonText: 'list day'},
                        listWeek: {buttonText: 'list week'}
                    },
                    defaultView: 'listWeek',
                    defaultDate: null,
                    navLinks: true, // can click day/week names to navigate views
                    editable: true,
                    eventLimit: true, // allow "more" link when too many events
                    events: {
                        url: '/api/events',
                        failure: function () {
                            alert('There was an error while fetching events!');
                        }
                    }
                });
                calendar.render();

                $('#from').datepicker({
                    uiLibrary: 'bootstrap4'
                });
                
                $('#to').datepicker({
                    uiLibrary: 'bootstrap4'
                });

                $(document).on('click', '#saveEventButton', function () {
                    var saveEventButton = $(this);
                    var saveEventForm = saveEventButton.closest('#saveEventForm');
                    $.ajax({
                        url: 'api/events',
                        type: 'POST',
                        dataType: 'json',
                        data: saveEventForm.serialize(),
                        beforeSend: function () {
                            // disable inputs and remove error if exist
                            saveEventButton.attr('disabled', true).text('Saving');
                            $.each(saveEventForm.find(':input'), function () {
                                $(this).attr('disabled', true).removeClass('is-invalid').closest('.input-div').find('.invalid-feedback').html('');
                            });
                        },
                        success: function (data) {
                            // disable search item input and remove error if exist
                            saveEventButton.attr('disabled', true).text('Save');
                            $.each(saveEventForm.find(':input'), function () {
                                $(this).attr('disabled', false);
                            });
                            var error = data.error;
                            if (error) {
                                var errorFields = error.fields;
                                $.each(errorFields, function (field, error) {
                                    var errorMessages = '';
                                    $.when($.each(error, function (i, message) {
                                        if (i == 0) {
                                            errorMessages = errorMessages + message;
                                        } else {
                                            errorMessages = errorMessages + '<br>' + message;
                                        }
                                    })).done(function () {
                                        $(':input[name="' + field + '"]').addClass('is-invalid').closest('.input-div').find('.invalid-feedback').html(errorMessages);
                                    });
                                });
                            } else {

                            }
                        }
                    });

                });
            });

        </script>
    </body>
</html>