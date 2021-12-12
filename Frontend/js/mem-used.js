const handleData4 = (data, newDateRange) => {
    Plotly.extendTraces('memused', { y: [[data['mem']['used']]], x: [[newDateRange[1]]] }, [0]);

    Plotly.relayout('memused', {
        xaxis: {
            rangeslider: {
                thickness: 0.08,
                autorange: true
            },
            range: newDateRange
        }
    });
}

var trace4 = {
    x: initialDate,
    y: initialData,
    name: 'In',
    fill: 'tozeroy',
    line: {
        color: 'rgb(0, 0, 0)',
        width: 1
    },
    type: 'scatter'
};

var data4 = [trace4];

var layout4 = {
    title: '<b>Memory</b> usage',
    showlegend: true, 
    legend: {"orientation": "v"}, 
    hovermode:'closest', 
    barmode: 'relative',
    xaxis: {
        rangeslider: {
                thickness: 0.08,
                autorange: true
            },
        autorange: 'visible'
    },
    yaxis: {
        exponentformat: 'SI',
    },
    margin:{l: 40, t: 35, b: 30, r: 5},
};

Plotly.plot('memused', data4, layout4, {responsive: true, displayModeBar: false});
