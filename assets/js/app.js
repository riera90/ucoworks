global.$ = global.jQuery = require('jquery');

require('semantic-ui-css');
require('semantic-ui-calendar/dist/calendar');

$(document)
    .ready(function() {
        $('.ui.checkbox').checkbox();
        $('.ui.dropdown').dropdown();
    })
;