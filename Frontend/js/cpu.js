const handleData = (data, newDateRange) => {
    Plotly.extendTraces('cpu', { y: [[data['cpu']]], x: [[newDateRange[1]]] }, [0]);
    
    Plotly.relayout('cpu', {
        xaxis: {
            rangeslider: {
                thickness: 0.08,
                autorange: true
            },
            range: newDateRange
        }
    });
}

var trace = {
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

var data = [trace];

var layout = {
    title: '<b>CPU</b> percent usage',
    showlegend: true, 
    legend: {"orientation": "v"}, 
    hovermode:'closest', 
    barmode: 'relative',
    xaxis: {
        rangeslider: {
            thickness: 0.08,
            autorange: true
        },
        autorange: 'once'
    },
    yaxis: {
        ticksuffix: '%',
        range: [0, 100]
    },
    margin:{l: 40, t: 35, b: 40, r: 5},
};

Plotly.plot('cpu', data, layout, {responsive: true, displayModeBar: false});
