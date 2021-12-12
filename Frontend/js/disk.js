const handleData2 = (data, newDateRange) => {
    Plotly.extendTraces('disk', { y: [[data['disk']]], x: [[newDateRange[1]]] }, [0]);

    Plotly.relayout('disk', {
        xaxis: {
            rangeslider: {
                thickness: 0.08,
                autorange: true
            },
            range: newDateRange
        }
    });
}

var trace2 = {
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

var data2 = [trace2];

var layout2 = {
    title: '<b>Disk</b> percent usage',
    showlegend: true, 
    legend: {"orientation": "v"}, 
    hovermode:'closest', 
    barmode: 'relative', 
    xaxis: {
        rangeslider: {
            thickness: 0.08,
            autorange: true
        },
        autorange: true
    },
    yaxis: {
        ticksuffix: '%',
        range: [0, 100]
    },
    margin:{l: 40, t: 35, b: 30, r: 5},
};

Plotly.plot('disk', data2, layout2, {responsive: true, displayModeBar: false});
