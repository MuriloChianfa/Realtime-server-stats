var cnt5 = 300;

const handleData5 = (data, newDateRange) => {
    Plotly.extendTraces('memfree', { y: [[data['mem']['free']]], x: [[newDateRange[1]]] }, [0]);

    Plotly.relayout('memfree', {
        xaxis: {
            rangeslider: {
                thickness: 0.08,
                autorange: true
            },
            range: newDateRange
        }
    });
}

var trace5 = {
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

var data5 = [trace5];

var layout5 = {
    title: '<b>Memory</b> free',
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
        exponentformat: 'SI',
    },
    margin:{l: 40, t: 35, b: 30, r: 5},
};

Plotly.plot('memfree', data5, layout5, {responsive: true, displayModeBar: false});
