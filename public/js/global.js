var global = (function() {
    this.baseUrl  = '';
    this.basePath = '';

    this.exampleFunction = function() {};

    return self;
}());

$(document).ready(function() {
    $("[data-toggle=tooltip]").tooltip({html:true});
    $('.datetimepicker').datetimepicker({
        sideBySide: true,
        allowInputToggle: true,
        format: 'YYYY-MM-DD HH:mm:ss'
    });
});