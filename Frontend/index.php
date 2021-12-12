<?php declare(strict_types=1); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <title>Realtime stats</title>
</head>
<body>
    <div class="row">
        <div class="col-md-4">
            <div id="cpu"></div>
        </div>
        <div class="col-md-4">
            <div id="disk"></div>
        </div>
        <div class="col-md-4">
            <div id="mempercent"></div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <div id="memused"></div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <div id="memfree"></div>
        </div>
    </div>

    <script>
        const timeInterval = 180;
        const initialDate = getInitialDate();
        const initialData = getInitialData();

        function getInitialData() {
            var initialData = [];

            for (let i = 0; i < timeInterval; i++) {
                initialData[i] = 0;
            }

            return initialData;
        }

        function getInitialDate() {
            var initialDate2 = [];

            for (let i = 0; i < timeInterval; i++) {
                initialDate2[i] = new Date(new Date().getTime() - (i * 1000)).toISOString().replace(/\.\d+/, "");
            }

            return initialDate2;
        }

        function getNewDateRange() {
            return [
                new Date((new Date()).getTime() - (timeInterval * 1000)).toISOString().replace(/\.\d+/, ""),
                new Date().toISOString().replace(/\.\d+/, "")
            ];
        }
    </script>

    <script src="js/cpu.js"></script>
    <script src="js/disk.js"></script>
    <script src="js/mem-percent.js"></script>
    <script src="js/mem-used.js"></script>
    <script src="js/mem-free.js"></script>

    <script>
        const ws = new WebSocket('ws://127.0.0.1:9501');
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        const wsHandleErrors = function (error) {
            Toast.fire({
                icon: 'error',
                title: 'Ocorreu algum erro ao se comunicar com o servidor de WebSocket!'
            });
        };

        ws.onerror = wsHandleErrors;
        ws.onclose = wsHandleErrors;

        ws.addEventListener('open', () => {
            Toast.fire({
                icon: 'success',
                title: 'Conexão com o servidor de WebSocket efetuada com sucesso!'
            });
        });

        ws.addEventListener('message', data => {
            data = JSON.parse(data.data);

            console.log(data);

            let newDateRange = getNewDateRange();

            handleData(data, newDateRange);
            handleData2(data, newDateRange);
            handleData4(data, newDateRange);
            handleData5(data, newDateRange);
            handleData6(data, newDateRange);
        });
    </script>
</body>
</html>
