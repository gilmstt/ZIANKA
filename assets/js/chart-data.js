var randomScalingFactor = function () {
    return Math.round(Math.random() * 1000);
};

$.ajax({
    type: "POST",
    url: raiz_url + 'report/ajax_obtener_consultas_meses',
    //dataType: 'json',
    success: function (meses) {
        var datos = JSON.parse(meses);

        var lineChartData = {
            labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            datasets: [
                {
                    label: "Año pasado",
                    fillColor: "rgba(220,220,220,0.2)",
                    strokeColor: "rgba(220,220,220,1)",
                    pointColor: "rgba(220,220,220,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: [datos["pasado"][1], datos["pasado"][2], datos["pasado"][3], datos["pasado"][4], datos["pasado"][5], datos["pasado"][6], datos["pasado"][7], datos["pasado"][8], datos["pasado"][9], datos["pasado"][10], datos["pasado"][11], datos["pasado"][12]]
                },
                {
                    label: "Año actual",
                    fillColor: "rgba(48, 164, 255, 0.2)",
                    strokeColor: "rgba(48, 164, 255, 1)",
                    pointColor: "rgba(48, 164, 255, 1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(48, 164, 255, 1)",
                    data: [datos["presente"][1], datos["presente"][2], datos["presente"][3], datos["presente"][4], datos["presente"][5], datos["presente"][6], datos["presente"][7], datos["presente"][8], datos["presente"][9], datos["presente"][10], datos["presente"][11], datos["presente"][12]]
                }
            ]

        }
        var chart1 = document.getElementById("line-chart").getContext("2d");
        window.myLine = new Chart(chart1).Line(lineChartData, {
            responsive: true
        });
    },
    error: function (e) {
        alert('hay un error');
    }
});

$.ajax({
    type: "POST",
    url: raiz_url + 'report/ajax_obtener_consultas_tarifas',
    //dataType: 'json',
    success: function (data) {
        var datos = JSON.parse(data);
        var A = 0;
        var B = 0;
        var C = 0;
        var D = 0;
        jQuery.each(datos, function (i, val) {
            if (datos[i].ID_TARIFA == 1)
                A = datos[i].TOTAL;
            if (datos[i].ID_TARIFA == 2)
                B = datos[i].TOTAL;
            if (datos[i].ID_TARIFA == 3)
                C = datos[i].TOTAL;
            if (datos[i].ID_TARIFA == 4)
                D = datos[i].TOTAL;
        });

        var pieData = [
            {
                value: parseInt(A),
                color: "#30a5ff",
                highlight: "#62b9fb",
                label: "Tarifa A"
            },
            {
                value: parseInt(B),
                color: "#ffb53e",
                highlight: "#fac878",
                label: "Tarifa B"
            },
            {
                value: parseInt(C),
                color: "#1ebfae",
                highlight: "#3cdfce",
                label: "Tarifa C"
            },
            {
                value: parseInt(D),
                color: "#f9243f",
                highlight: "#f6495f",
                label: "Tarifa D"
            }
        ];
        var chart4 = document.getElementById("pie-chart").getContext("2d");
        window.myPie = new Chart(chart4).Pie(pieData, {responsive: true
        });
    },
    error: function (e) {
        alert('hay un error');
    }
});

$.ajax({
    type: "POST",
    url: raiz_url + 'report/ajax_obtener_consultas_membresias',
    //dataType: 'json',
    success: function (data) {
        var datos = JSON.parse(data);
        var PLATA = 0;
        var ORO = 0;
        var PLATINO = 0;
        jQuery.each(datos, function (i, val) {
            if (datos[i].ID_MEMBRESIA == 1)
                PLATA = datos[i].TOTAL;
            if (datos[i].ID_MEMBRESIA == 3)
                ORO = datos[i].TOTAL;
            if (datos[i].ID_MEMBRESIA == 5)
                PLATINO = datos[i].TOTAL;
        });

        var doughnutData = [
            {
                value: parseInt(PLATA),
                color: "#30a5ff",
                highlight: "#62b9fb",
                label: "Plata"
            },
            {
                value: parseInt(ORO),
                color: "#ffb53e",
                highlight: "#fac878",
                label: "Oro"
            },
            {
                value: parseInt(PLATINO),
                color: "#1ebfae",
                highlight: "#3cdfce",
                label: "Platino"
            }

        ];
        var chart3 = document.getElementById("doughnut-chart").getContext("2d");
        window.myDoughnut = new Chart(chart3).Doughnut(doughnutData, {responsive: true
        });
    },
    error: function (e) {
        alert('hay un error');
    }
});

//URGENCIAS
$.ajax({
    type: "POST",
    url: raiz_url + 'report/ajax_obtener_urgencias_meses',
    //dataType: 'json',
    success: function (meses) {
        var datos = JSON.parse(meses);

        var lineChartData = {
            labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            datasets: [
                {
                    label: "Año pasado",
                    fillColor: "rgba(220,220,220,0.2)",
                    strokeColor: "rgba(220,220,220,1)",
                    pointColor: "rgba(220,220,220,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: [datos["pasado"][1], datos["pasado"][2], datos["pasado"][3], datos["pasado"][4], datos["pasado"][5], datos["pasado"][6], datos["pasado"][7], datos["pasado"][8], datos["pasado"][9], datos["pasado"][10], datos["pasado"][11], datos["pasado"][12]]
                },
                {
                    label: "Año actual",
                    fillColor: "rgba(48, 164, 255, 0.2)",
                    strokeColor: "rgba(48, 164, 255, 1)",
                    pointColor: "rgba(48, 164, 255, 1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(48, 164, 255, 1)",
                    data: [datos["presente"][1], datos["presente"][2], datos["presente"][3], datos["presente"][4], datos["presente"][5], datos["presente"][6], datos["presente"][7], datos["presente"][8], datos["presente"][9], datos["presente"][10], datos["presente"][11], datos["presente"][12]]
                }
            ]

        }
        var chart1 = document.getElementById("line-chart2").getContext("2d");
        window.myLine = new Chart(chart1).Line(lineChartData, {
            responsive: true
        });
    },
    error: function (e) {
        alert('hay un error');
    }
});

$.ajax({
    type: "POST",
    url: raiz_url + 'report/ajax_obtener_urgencias_tarifas',
    //dataType: 'json',
    success: function (data) {
        var datos = JSON.parse(data);
        var A = 0;
        var B = 0;
        var C = 0;
        var D = 0;
        jQuery.each(datos, function (i, val) {
            if (datos[i].ID_TARIFA == 1)
                A = datos[i].TOTAL;
            if (datos[i].ID_TARIFA == 2)
                B = datos[i].TOTAL;
            if (datos[i].ID_TARIFA == 3)
                C = datos[i].TOTAL;
            if (datos[i].ID_TARIFA == 4)
                D = datos[i].TOTAL;
        });

        var pieData = [
            {
                value: parseInt(A),
                color: "#30a5ff",
                highlight: "#62b9fb",
                label: "Tarifa A"
            },
            {
                value: parseInt(B),
                color: "#ffb53e",
                highlight: "#fac878",
                label: "Tarifa B"
            },
            {
                value: parseInt(C),
                color: "#1ebfae",
                highlight: "#3cdfce",
                label: "Tarifa C"
            },
            {
                value: parseInt(D),
                color: "#f9243f",
                highlight: "#f6495f",
                label: "Tarifa D"
            }
        ];
        var chart4 = document.getElementById("pie-chart2").getContext("2d");
        window.myPie = new Chart(chart4).Pie(pieData, {responsive: true
        });
    },
    error: function (e) {
        alert('hay un error');
    }
});

$.ajax({
    type: "POST",
    url: raiz_url + 'report/ajax_obtener_urgencias_membresias',
    //dataType: 'json',
    success: function (data) {
        var datos = JSON.parse(data);
        var PLATA = 0;
        var ORO = 0;
        var PLATINO = 0;
        jQuery.each(datos, function (i, val) {
            if (datos[i].ID_MEMBRESIA == 1)
                PLATA = datos[i].TOTAL;
            if (datos[i].ID_MEMBRESIA == 3)
                ORO = datos[i].TOTAL;
            if (datos[i].ID_MEMBRESIA == 5)
                PLATINO = datos[i].TOTAL;
        });

        var doughnutData = [
            {
                value: parseInt(PLATA),
                color: "#30a5ff",
                highlight: "#62b9fb",
                label: "Plata"
            },
            {
                value: parseInt(ORO),
                color: "#ffb53e",
                highlight: "#fac878",
                label: "Oro"
            },
            {
                value: parseInt(PLATINO),
                color: "#1ebfae",
                highlight: "#3cdfce",
                label: "Platino"
            }

        ];
        var chart3 = document.getElementById("doughnut-chart2").getContext("2d");
        window.myDoughnut = new Chart(chart3).Doughnut(doughnutData, {responsive: true
        });
    },
    error: function (e) {
        alert('hay un error');
    }
});

$.ajax({
    type: "POST",
    url: raiz_url + 'report/ajax_obtener_consultas_casas',
    //dataType: 'json',
    data: {ID_MEMBRESIA : $('#ID_MEMBRESIA_S').val()},
    success: function (data) {
        var datos = JSON.parse(data);
        var casas = [];
        var totales = [];
        jQuery.each(datos, function (i, val) {
            casas[i] = val.NOMBRE_CASA;
            totales[i] = val.TOTAL;
        });
        var barChartData = {
            labels: casas,
            datasets: [
                {
                    fillColor: "rgba(48, 164, 255, 0.2)",
                    strokeColor: "rgba(48, 164, 255, 0.8)",
                    highlightFill: "rgba(48, 164, 255, 0.75)",
                    highlightStroke: "rgba(48, 164, 255, 1)",
                    data: totales
                }
            ]

        };

        var chart2 = document.getElementById("bar-chart").getContext("2d");
        window.myBar = new Chart(chart2).Bar(barChartData, {
            responsive: true,
            scaleLineColor: "rgba(0,0,0,.2)",
            scaleGridLineColor: "rgba(0,0,0,.05)",
            scaleFontColor: "#c5c7cc"
        });
    },
    error: function (e) {
        alert('hay un error');
    }
});

$.ajax({
    type: "POST",
    url: raiz_url + 'report/ajax_obtener_urgencias_casas',
    //dataType: 'json',
    data: {ID_MEMBRESIA : $('#ID_MEMBRESIA_U').val()},
    success: function (data) {
        var datos = JSON.parse(data);
        var casas = [];
        var totales = [];
        jQuery.each(datos, function (i, val) {
            casas[i] = val.NOMBRE_CASA;
            totales[i] = val.TOTAL;
        });
        var barChartData = {
            labels: casas,
            datasets: [
                {
                    fillColor: "rgba(48, 164, 255, 0.2)",
                    strokeColor: "rgba(48, 164, 255, 0.8)",
                    highlightFill: "rgba(48, 164, 255, 0.75)",
                    highlightStroke: "rgba(48, 164, 255, 1)",
                    data: totales
                }
            ]

        };

        var chart2 = document.getElementById("bar-chartu").getContext("2d");
        window.myBar = new Chart(chart2).Bar(barChartData, {
            responsive: true,
            scaleLineColor: "rgba(0,0,0,.2)",
            scaleGridLineColor: "rgba(0,0,0,.05)",
            scaleFontColor: "#c5c7cc"
        });
    },
    error: function (e) {
        alert('hay un error');
    }
});
