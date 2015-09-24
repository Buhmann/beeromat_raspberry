jQuery(document).ready(function($) {
    var ad = Administration();
});

function Administration() {
    /*
     * Mapping Buttons
     * power up = 1
     * read soil mositure = 2
     * bucket = 3
     * temperature = 4
     */
    var _btn_power_up = jQuery('#btnPowerUpPump');
    var _btn_power_up_number = 1;

    var _btn_read_soil_mositure = jQuery('#btnReadSoilMositure');
    var _btn_read_soil_mositure_number = 2;

    var _btn_bucket = jQuery('#btnBucket');
    var _btn_bucket_number = 3;

    var _btn_temperature = jQuery('#btnTemperature');
    var _btn_temperature_number = 4;

    var txt_result = jQuery('#txtResult');


    var initialize = function() {
        _btn_power_up.bind('click', function() {
            ajaxRequest(_btn_power_up_number, '/administration/exec', callback);
        });
        _btn_read_soil_mositure.bind('click', function() {
            ajaxRequest(_btn_read_soil_mositure_number, '/administration/exec', callback);
        });
        _btn_bucket.bind('click', function() {
            ajaxRequest(_btn_bucket_number, '/administration/exec', callback);
        });
        _btn_temperature.bind('click', function() {
            ajaxRequest(_btn_temperature_number, '/administration/exec', callback);
        });

    };

    var callback = function(data) {
//        console.log(data);
        txt_result.text(data);

    };

    initialize();


}
;


var ajaxRequest = function(data, url, callback) {
    $.ajax({
        type: "POST",
        url: url,
        async: true,
        data: {data: data},
        success: callback
    });
}

