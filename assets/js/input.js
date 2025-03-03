/*  -- JQUERY NUMERIC --
 *  $(".numeric").numeric();
 *  $(".integer").numeric(false, function() { alert("Integers only"); this.value = ""; this.focus(); });
 *  $(".positive").numeric({ negative: false }, function() { alert("No negative values"); this.value = ""; this.focus(); });
 *  $(".positive-integer").numeric({ decimal: false, negative: false }, function() { alert("Positive integers only"); this.value = ""; this.focus(); });
 *  $(".decimal-2-places").numeric({ decimalPlaces: 2 });
 */


$(document).ready(function () {
    $(".numeric").numeric();
    $(".integer").numeric(false);
    $(".positive").numeric({negative: false});
    $(".decimal-2-places").numeric({decimalPlaces: 2, negative: false});
    $(".positive-integer").numeric({decimal: false, negative: false});
    $(".positive-decimal").numeric({decimal: true, negative: false, decimalPlaces: 2});

});