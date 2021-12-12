var cnt6 = 300;

const handleData6 = (data, newDateRange) => {
    Plotly.extendTraces('mempercent', { y: [[data['mem']['percent']]], x: [[newDateRange[1]]] }, [0]);

    Plotly.relayout('mempercent', {
        xaxis: {
            rangeslider: {
                thickness: 0.08,
                autorange: true
            },
            range: newDateRange
        }
    });
}

var trace6 = {
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

var data6 = [trace6];

var layout6 = {
    title: '<b>Memory</b> percent usage',
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

Plotly.plot('mempercent', data6, layout6, {responsive: true, displayModeBar: false});
