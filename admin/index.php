<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>
<link rel="stylesheet" href="../css/style_adm.css">
<script src="https://code.jscharting.com/latest/jscharting.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://code.jscharting.com/latest/jscharting.js"></script>
</head>
<body>

<div class="user-info">
    <button onclick="location.href='../config/salir.php';" class="logout-button">Salir</button>
    <span>ADS</span>
</div>

<nav>
    <ul>
       <center> <li><strong>Dashboard</strong></li></center>
       <br>
        <li><ion-icon name="speedometer"></ion-icon>      <a href="index.php">Inicio</a></li>
        <li><ion-icon name="pie-chart"></ion-icon>        <a href="graficas.php">Graficas</a></li>
        <li><ion-icon name="file-tray-stacked"></ion-icon><a href="tablas.php">Tablas CRUDS</a></li>
        <li><ion-icon name="person-add"></ion-icon>       <a href="usuarios.php">Usuarios</a></li>
        <li><ion-icon name="aperture"></ion-icon>         <a href="../pages/index.php">Web site</a></li>
        <li><ion-icon name="terminal"></ion-icon>             <a href="consola.php">Consola</a></li>
    </ul>
</nav>
<div class="content-box">
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
<script src="https://code.highcharts.com/dashboards/datagrid.js"></script>
<script src="https://code.highcharts.com/dashboards/dashboards.js"></script>
<script src="https://code.highcharts.com/dashboards/modules/layout.js"></script>

<div class="cloud-monitoring-dashboard-container">
  <div class="cloud-monitoring-data-controls">
    <label for="enablePolling">
      <input type="checkbox" id="enablePolling" name="enablePolling" />
      <span>Enable data polling</span>
    </label>
  </div>
  <div id="container"></div>
</div>




</div>

<script>
    let board = void 0;
let instances = void 0;
let currentInstanceId = void 0;
const pollingCheckbox = document.getElementById('enablePolling');
const KPIOptions = {
    chart: {
        height: 165,
        margin: [0, 0, 0, 0],
        spacing: [0, 0, 0, 0],
        type: 'solidgauge'
    },
    yAxis: {
        min: 0,
        max: 100,
        stops: [
            [0.1, '#33A29D'], // green
            [0.5, '#DDDF0D'], // yellow
            [0.9, '#DF5353'] // red
        ]
    },
    pane: {
        background: {
            innerRadius: '80%',
            outerRadius: '100%'
        }
    },
    accessibility: {
        typeDescription: 'The gauge chart with 1 data point.'
    }
};

Highcharts.setOptions({
    credits: {
        enabled: false
    },
    title: {
        text: ''
    }
});

pollingCheckbox.onchange = async e => {
    if (e.target.checked) {
        // charts data
        (await board.dataPool.getConnector('charts')).startPolling();
        // KPI instances data
        (await board.dataPool.getConnector('instanceDetails')).startPolling();
    } else {
        // charts data
        (await board.dataPool.getConnector('charts')).stopPolling();
        // KPI instances data
        (await board.dataPool.getConnector('instanceDetails')).stopPolling();
    }
};

const setupDashboard = instanceId => {
    const instance = instances.find(
        instance => instance.InstanceId === instanceId
    ) || instances[0];

    // for polling option
    currentInstanceId = instance.InstanceId;

    board = Dashboards.board('container', {
        dataPool: {
            connectors: [{
                id: 'charts',
                type: 'JSON',
                options: {
                    firstRowAsNames: false,
                    columnNames: [
                        'timestamp', 'readOpt', 'writeOpt', 'networkIn',
                        'networkOut', 'cpuUtilization'
                    ],
                    dataUrl: 'https://demo-live-data.highcharts.com/instance-details.json',
                    beforeParse: function (data) {
                        const currentInstance = data.find(
                            inst => inst.InstanceId === currentInstanceId
                        ) || data;
                        return currentInstance.Details.map(
                            el => el
                        );
                    }
                }
            }, {
                id: 'instanceDetails',
                type: 'JSON',
                options: {
                    firstRowAsNames: false,
                    orientantion: 'columns',
                    columnNames: [
                        'index', 'CPUUtilization', 'MemoryUsage', 'DiskSizeGB',
                        'DiskUsedGB', 'DiskFreeGB', 'MediaGB', 'RootGB',
                        'Documents', 'Downloads'
                    ],
                    dataUrl: 'https://demo-live-data.highcharts.com/instances.json',
                    beforeParse: function (data) {
                        const currentInstance = data.find(
                            inst => inst.InstanceId === currentInstanceId
                        ) || data;
                        const diskSpace = currentInstance.DiskSpace.RootDisk;
                        return [
                            [
                                0, // display one record on chart KPI / disk
                                currentInstance.CPUUtilization,
                                currentInstance.MemoryUsage,
                                diskSpace.SizeGB,
                                diskSpace.UsedGB,
                                diskSpace.FreeGB,
                                diskSpace.MediaGB,
                                diskSpace.RootGB,
                                diskSpace.Documents,
                                diskSpace.Downloads
                            ]
                        ];
                    }
                }
            }, {
                id: 'instances',
                type: 'JSON',
                options: {
                    firstRowAsNames: false,
                    data: instances
                }
            }]
        },
        gui: {
            layouts: [{
                rows: [{
                    id: 'instance-details',
                    cells: [{
                        id: 'instance'
                    }, {
                        id: 'zone'
                    }, {
                        id: 'ami'
                    }, {
                        id: 'os'
                    }]
                }, {
                    cells: [{
                        id: 'instances-table'
                    }, {
                        id: 'kpi-wrapper',
                        layout: {
                            rows: [{
                                cells: [{
                                    id: 'cpu'
                                }, {
                                    id: 'memory'
                                }]
                            }, {
                                cells: [{
                                    id: 'health'
                                }, {
                                    id: 'disk'
                                }]
                            }]
                        }
                    }]
                }, {
                    cells: [{
                        id: 'disk-usage'
                    }, {
                        id: 'cpu-utilization'
                    }]
                }, {
                    cells: [{
                        id: 'network-opt'
                    }, {
                        id: 'disk-opt'
                    }]
                }]
            }]
        },
        components: [{
            cell: 'instance',
            type: 'HTML',
            title: 'Instance type:',
            elements: [{
                tagName: 'span'
            }, {
                tagName: 'p',
                textContent: instance.InstanceType
            }]
        }, {
            cell: 'zone',
            type: 'HTML',
            title: 'Zone:',
            elements: [{
                tagName: 'span'
            }, {
                tagName: 'p',
                textContent: instance.Zone
            }]
        }, {
            cell: 'ami',
            type: 'HTML',
            title: 'AMI:',
            elements: [{
                tagName: 'span'
            }, {
                tagName: 'p',
                textContent: instance.AMI
            }]
        }, {
            cell: 'os',
            type: 'HTML',
            title: 'OS:',
            elements: [{
                tagName: 'span'
            }, {
                tagName: 'p',
                textContent: instance.OS
            }]
        }, {
            cell: 'disk-usage',
            title: 'Disk usage',
            type: 'Highcharts',
            connector: {
                id: 'instanceDetails',
                columnAssignment: [{
                    seriesId: 'media-gb',
                    data: ['x', 'MediaGB']
                }, {
                    seriesId: 'root-gb',
                    data: ['x', 'RootGB']
                }, {
                    seriesId: 'documents',
                    data: ['x', 'Documents']
                }, {
                    seriesId: 'downloads',
                    data: ['x', 'Downloads']
                }]
            },
            chartOptions: {
                xAxis: {
                    min: -0.5,
                    max: 3.5,
                    showFirstLabel: false,
                    showLastLabel: false,
                    type: 'category',
                    categories: ['MediaGB', 'RootGB', 'Documents', 'Downloads'],
                    accessibility: {
                        description: 'Disk categories'
                    }
                },
                series: [{
                    name: 'MediaGB',
                    id: 'media-gb',
                    pointStart: 0,
                    pointPlacement: -0.3
                }, {
                    name: 'RootGB',
                    id: 'root-gb',
                    pointStart: 1,
                    pointPlacement: -0.1
                }, {
                    name: 'Documents',
                    id: 'documents',
                    pointStart: 2,
                    pointPlacement: 0.1
                }, {
                    name: 'Downloads',
                    id: 'downloads',
                    pointStart: 3,
                    pointPlacement: 0.4
                }],
                yAxis: {
                    title: {
                        text: 'GB'
                    },
                    accessibility: {
                        description: 'Gigabytes'
                    }
                },
                legend: {
                    enabled: false
                },
                chart: {
                    type: 'bar'
                },
                tooltip: {
                    headerFormat: '',
                    valueSuffix: ' Gb'
                },
                plotOptions: {
                    series: {
                        relativeXValue: true,
                        pointRange: 1,
                        pointPadding: 0,
                        groupPadding: 0,
                        pointWidth: 40,
                        dataLabels: {
                            enabled: true,
                            format: '{y} GB'
                        }
                    }
                },
                lang: {
                    accessibility: {
                        chartContainerLabel: 'Disk usage. Highcharts ' +
                            'interactive chart.'
                    }
                },
                accessibility: {
                    description: 'The chart is displaying space on disk'
                }
            }
        },
        {
            cell: 'cpu-utilization',
            title: 'CPU utilization',
            type: 'Highcharts',
            connector: {
                id: 'charts',
                columnAssignment: [{
                    seriesId: 'cpu-utilization',
                    data: ['timestamp', 'cpuUtilization']
                }]
            },
            sync: {
                highlight: true
            },
            chartOptions: {
                chart: {
                    type: 'spline'
                },
                series: [{
                    name: 'CPU utilization',
                    id: 'cpu-utilization'
                }],
                xAxis: {
                    type: 'datetime',
                    accessibility: {
                        description: 'Days'
                    }
                },
                yAxis: {
                    min: 0,
                    max: 100,
                    title: {
                        text: 'Percents'
                    },
                    accessibility: {
                        description: 'Percents'
                    }
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    valueSuffix: '%'
                },
                accessibility: {
                    description: 'The chart is displaying CPU usage',
                    point: {
                        valueDescriptionFormat: 'percents'
                    }
                }
            }
        },
        {
            cell: 'cpu',
            type: 'KPI',
            connector: {
                id: 'instanceDetails'
            },
            columnName: 'CPUUtilization',
            chartOptions: {
                ...KPIOptions,
                plotOptions: {
                    series: {
                        className: 'highcharts-live-kpi',
                        dataLabels: {
                            format: '<div style="text-align:center; ' +
                                'margin-top: -20px">' +
                            '<div style="font-size:1.2em;">{y}%</div>' +
                            '<div style="font-size:14px; opacity:0.4; ' +
                            'text-align: center;">CPU</div>' +
                            '</div>',
                            useHTML: true
                        }
                    }
                },
                series: [{
                    name: 'CPU utilization',
                    innerRadius: '80%',
                    data: [{
                        colorIndex: '100'
                    }],
                    radius: '100%'
                }],
                xAxis: {
                    accessibility: {
                        description: 'Days'
                    }
                },
                lang: {
                    accessibility: {
                        chartContainerLabel: 'CPU usage. Highcharts ' +
                            'interactive chart.'
                    }
                },
                tooltip: {
                    valueSuffix: '%'
                }
            }
        }, {
            cell: 'memory',
            type: 'KPI',
            connector: {
                id: 'instanceDetails'
            },
            columnName: 'MemoryUsage',
            chartOptions: {
                ...KPIOptions,
                yAxis: {
                    min: 0,
                    max: 2048,
                    stops: [
                        [0.1, '#33A29D'], // green
                        [0.5, '#DDDF0D'], // yellow
                        [0.9, '#DF5353'] // red
                    ]
                },
                plotOptions: {
                    series: {
                        className: 'highcharts-live-kpi',
                        dataLabels: {
                            format: '<div style="text-align:center; ' +
                                'margin-top: -20px">' +
                            '<div style="font-size:1.2em;">{y} MB</div>' +
                            '<div style="font-size:14px; opacity:0.4; ' +
                            'text-align: center;">Memory</div>' +
                            '</div>',
                            useHTML: true
                        }
                    }
                },
                series: [{
                    name: 'Memory usage',
                    innerRadius: '80%',
                    data: [{
                        colorIndex: '100'
                    }],
                    radius: '100%'
                }],
                lang: {
                    accessibility: {
                        chartContainerLabel: 'Memory usage. Highcharts ' +
                            'interactive chart.'
                    }
                },
                tooltip: {
                    valueSuffix: ' MB'
                }
            }
        },
        {
            cell: 'health',
            type: 'HTML',
            class: 'health-indicator',
            elements: [{
                tagName: 'div',
                class: 'health-wrapper highcharts-' + instance.HealthIndicator +
                    '-icon',
                attributes: {
                    'aria-label': 'Health: ' + instance.HealthIndicator,
                    role: 'img'
                }
            }, {
                tagName: 'div',
                class: 'health-title',
                textContent: 'Health'
            }]
        },
        {
            cell: 'disk',
            type: 'KPI',
            connector: {
                id: 'instanceDetails'
            },
            columnName: 'DiskUsedGB',
            chartOptions: {
                ...KPIOptions,
                plotOptions: {
                    series: {
                        dataLabels: {
                            format: '<div style="text-align:center; ' +
                                'margin-top: -20px">' +
                            '<div style="font-size:1.2em;">{y} GB</div>' +
                            '<div style="font-size:14px; opacity:0.4; ' +
                            'text-align: center;">Disk space</div>' +
                            '</div>',
                            useHTML: true
                        }
                    }
                },
                series: [{
                    name: 'Disk usage',
                    innerRadius: '80%',
                    data: [{
                        colorIndex: '100'
                    }],
                    radius: '100%'
                }],
                tooltip: {
                    valueSuffix: ' Gb'
                },
                lang: {
                    accessibility: {
                        chartContainerLabel: 'Disk usage. Highcharts ' +
                            'interactive chart.'
                    }
                }
            }
        },
        {
            cell: 'network-opt',
            type: 'Highcharts',
            title: 'Network (bytes)',
            connector: {
                id: 'charts',
                columnAssignment: [{
                    seriesId: 'in',
                    data: ['timestamp', 'networkIn']
                }, {
                    seriesId: 'out',
                    data: ['timestamp', 'networkOut']
                }]
            },
            sync: {
                highlight: true
            },
            chartOptions: {
                chart: {
                    type: 'spline'
                },
                xAxis: {
                    type: 'datetime',
                    accessibility: {
                        description: 'Days'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Bytes'
                    },
                    accessibility: {
                        description: 'Bytes'
                    }
                },
                legend: {
                    labelFormatter: function () {
                        const result =
                            this.name.replace(/([A-Z])/g, ' $1').toLowerCase();
                        return result.charAt(0).toUpperCase() + result.slice(1);
                    }
                },
                tooltip: {
                    valueDecimals: 0,
                    valueSuffix: ' bytes'
                },
                accessibility: {
                    description: `The chart is displaying amount of in and out
                                network operations`,
                    point: {
                        valueDescriptionFormat: 'bytes'
                    }
                },
                series: [{
                    name: 'network in',
                    id: 'in'
                }, {
                    name: 'network out',
                    id: 'out'
                }]
            }
        },
        {
            cell: 'disk-opt',
            type: 'Highcharts',
            title: 'Disk operations',
            connector: {
                id: 'charts',
                columnAssignment: [{
                    seriesId: 'read',
                    data: ['timestamp', 'readOpt']
                }, {
                    seriesId: 'write',
                    data: ['timestamp', 'writeOpt']
                }]
            },
            sync: {
                highlight: true
            },
            chartOptions: {
                chart: {
                    type: 'column'
                },
                xAxis: {
                    type: 'datetime',
                    accessibility: {
                        description: 'Days'
                    }
                },
                tooltip: {
                    valueDecimals: 0,
                    valueSuffix: ' operations'
                },
                yAxis: {
                    title: {
                        text: 'Operations'
                    },
                    accessibility: {
                        description: 'Operations'
                    }
                },
                legend: {
                    labelFormatter: function () {
                        const result =
                            this.name.replace(/([A-Z])/g, ' $1').toLowerCase();
                        return result.charAt(0).toUpperCase() + result.slice(1);
                    }
                },
                accessibility: {
                    description: `The chart is displaying amount of in and out
                                operations on disk`,
                    point: {
                        valueDescriptionFormat: 'operations'
                    }
                }
            }
        },
        {
            cell: 'instances-table',
            type: 'DataGrid',
            title: 'Instances',
            visibleColumns: [
                'InstanceId', 'InstanceType', 'PublicIpAddress', 'State',
                'HealthIndicator'
            ],
            dataGridOptions: {
                editable: false,
                columns: {
                    InstanceId: {
                        headerFormat: 'ID'
                    },
                    InstanceType: {
                        headerFormat: 'Type'
                    },
                    PublicIpAddress: {
                        headerFormat: 'Public IP'
                    },
                    HealthIndicator: {
                        headerFormat: 'Health'
                    }

                },
                events: {
                    row: {
                        click: async function (e) {
                            const enabledPolling = pollingCheckbox.checked;
                            if (enabledPolling) {
                                // stop polling when is enabled
                                await pollingCheckbox.click();
                            }
                            board.destroy();
                            setupDashboard(
                                e.target.parentNode.childNodes[0].innerText
                            );

                            // run polling when was enabled
                            if (enabledPolling) {
                                await pollingCheckbox.click();
                            }
                        }
                    }
                }
            },
            connector: {
                id: 'instances'
            },
            events: {
                mount: function () {
                    setTimeout(() => {
                        const currentRow =
                            document.querySelector(
                                `[data-original-data="${instance.InstanceId}"]`
                            ).parentNode;
                        currentRow.classList.add('current');
                    }, 1);
                }
            }
        }]
    });
};

// Init
(async () => {
    // load init list of intances
    instances = await fetch(
        'https://demo-live-data.highcharts.com/instances.json'
    ).then(response => response.json());

    setupDashboard();
    // run polling
    await pollingCheckbox.click();
})();

</script>
</body>





</html>
<style>
    @import url("https://code.highcharts.com/css/highcharts.css");
@import url("https://code.highcharts.com/dashboards/css/datagrid.css");
@import url("https://code.highcharts.com/dashboards/css/dashboards.css");

.highcharts-description {
    padding: 0 20px;
}

.cloud-monitoring-data-controls {
    background-color: var(--dashboard-bck-gray);
    border-bottom: 1px solid #a5abb1;
    padding: 20px 15px;
}

:root,
.highcharts-light {
    /* Colors for data series and points */
    --highcharts-color-0: #33a29d;
    --highcharts-color-2: #fe9d00;

    /* Extra colors */
    --bck-gray: #f1f5f9;
    --dashboard-bck-gray: #e4eaf1;
}

body {
    background-color: var(--bck-gray);
}

.highcharts-dashboards-wrapper {
    background-color: var(--dashboard-bck-gray);
    min-height: 1000px;
}

.highcharts-dashboards-cell > .highcharts-dashboards-component {
    border-radius: 15px;
    padding: 10px;
    text-align: left;
}

.highcharts-dashboards-component-title {
    font-size: 1.2em;
    text-align: left;
}

#instance-details .highcharts-dashboards-component-content p {
    display: inline-block;
    font-size: 1em;
    font-weight: 600;
    margin-top: 20px;
}

#instance-details .highcharts-dashboards-component-content span {
    width: 40px;
    height: 40px;
    background-size: 32px 32px;
    border-radius: 5px;
    margin: 10px 15px 10px 10px;
    float: left;
}

@media (prefers-color-scheme: dark) {
    .highcharts-dashboards-wrapper,
    .cloud-monitoring-data-controls {
        background-color: var(--highcharts-neutral-color-10);
    }

    .cloud-monitoring-data-controls {
        color: #fff;
    }
}

@media (prefers-color-scheme: light) {
    #instances-table .highcharts-datagrid-column-header,
    #instances-table .highcharts-datagrid-row {
        background-color: var(--highcharts-neutral-color-0);
    }
}

/* https://awsicons.dev/ */

#instance-details #instance .highcharts-dashboards-component-content span {
    background: url("https://www.highcharts.com/samples/graphics/dashboards/cloud-monitoring/instance-ico.svg") 0 50% no-repeat;
}

#instance-details #zone .highcharts-dashboards-component-content span {
    background: url("https://www.highcharts.com/samples/graphics/dashboards/cloud-monitoring/zone-ico.svg") 0 50% no-repeat;
}

#instance-details #ami .highcharts-dashboards-component-content span {
    background: url("https://www.highcharts.com/samples/graphics/dashboards/cloud-monitoring/ami-ico.svg") 0 50% no-repeat;
}

#instance-details #os .highcharts-dashboards-component-content span {
    background: url("https://www.highcharts.com/samples/graphics/dashboards/cloud-monitoring/os-ico.svg") 0 50% no-repeat;
}

#instances-table .highcharts-datagrid-container {
    border: none;
    font-weight: 100;
}

#instances-table .highcharts-datagrid-row {
    cursor: pointer;
}

#instances-table .highcharts-datagrid-row .highcharts-datagrid-cell:first-child {
    white-space: nowrap;
}

#instances-table .highcharts-datagrid-row.current {
    background-color: var(--highcharts-neutral-color-10);
    pointer-events: none;
}

#instances-table .highcharts-datagrid-row:hover {
    background-color: var(--highcharts-neutral-color-10);
}

.health-title {
    width: 100%;
    text-align: center;
    font-size: 1.2em;
    padding-top: 15px;
}

.health-wrapper {
    margin: auto;
    width: 100px;
    height: 100px;
    margin-top: 15px;
}

.highcharts-Warning-icon,
.highcharts-datagrid-cell[data-original-data="Warning"] {
    background: url("https://www.highcharts.com/samples/graphics/dashboards/cloud-monitoring/warning-ico.svg") 50% 50% no-repeat;
    background-size: 64px 64px;
}

.highcharts-Critical-icon,
.highcharts-datagrid-cell[data-original-data="Critical"] {
    background: url("https://www.highcharts.com/samples/graphics/dashboards/cloud-monitoring/critical-ico.png") 50% 50% no-repeat;
    background-size: 64px 64px;
}

.highcharts-OK-icon,
.highcharts-datagrid-cell[data-original-data="OK"] {
    background: url("https://www.highcharts.com/samples/graphics/dashboards/cloud-monitoring/ok-ico.svg") 50% 50% no-repeat;
    background-size: 64px 64px;
}

.highcharts-datagrid-cell[data-original-data="Critical"],
.highcharts-datagrid-cell[data-original-data="Warning"],
.highcharts-datagrid-cell[data-original-data="OK"] {
    background-size: 24px 24px;
    text-indent: -9999px;
}

.highcharts-dashboards-component-kpi-value {
    display: none;
}

#instances-table {
    height: 400px;
}

#cpu,
#memory {
    height: 200px;
}

#health,
#disk {
    height: 195px;
}

#disk-opt,
#network-opt {
    height: 300px;
}

#cpu-utilization,
#disk-usage {
    height: 400px;
}

/* MEDIUM */
@media (max-width: 992px) {
    #instance,
    #zone,
    #ami,
    #os,
    #cpu,
    #memory,
    #health,
    #disk {
        flex: 1 1 50%;
    }

    #instances-table,
    #disk-usage,
    #cpu-utilization,
    #kpi-wrapper {
        flex: 1 1 100%;
    }

    #instances-table,
    #cpu-utilization {
        height: 300px;
    }
}

/* SMALL */
@media (max-width: 576px) {
    #instance,
    #zone,
    #ami,
    #os,
    #disk-opt,
    #network-opt,
    #cpu,
    #memory,
    #health,
    #disk {
        flex: 1 1 100%;
    }
}

</style>