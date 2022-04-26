var options = {
    series: [{
    name: 'series1',
    data: [31, 40, 28, 51, 42, 109, 100]
  }],
    chart: {
    width: '100%',
    height:'100%',
    type: 'area',
    toolbar: {
      show: false
    },
    sparkline: {
      enabled: true
    }
  },
  grid:{
    show:false,
    
    xaxis: {
      lines: {
          show: false
      },
      axisBorder: {
        show: false,
      },
    },
    yaxis: {
      lines: {
          show: false
      },
      axisBorder: {
        show: false,
      },
    }
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    curve: 'smooth'
  },
  yaxis:{
    labels: {
      show: false
    }
  },
  xaxis: {
    labels: {
      show: false
    },
  },
  tooltip: {
    x: {
      format: 'dd/MM/yy HH:mm'
    },
  },
  };

  var options2 = {
    series: [{
      name: 'Marine Sprite',
      data: [44]
    }, {
      name: 'Striking Calf',
      data: [53]
    }, {
      name: 'Tank Picture',
      data: [12]
    }, {
      name: 'Bucket Slope',
      data: [9]
    }, {
      name: 'Reborn Kid',
      data: [25]
    }],
    chart: {
      type: 'bar',
      height: '100%',
      stacked: true,
      stackType: '100%'
    },
    plotOptions: {
      bar: {
        horizontal: true,
      },
    },
    stroke: {
      width: 0.5,
      colors: ['#fff']
    },
    title: {
      text: '100% Stacked Bar'
    },
    yaxis: {
      labels: {
        show: false,
      }
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return val + "K"
        }
      }
    },
    fill: {
      opacity: 1
    },
    legend: {
      position: 'top',
      horizontalAlign: 'left',
      offsetX: 40
    }
  };
  var chart = new ApexCharts(document.querySelector("#chart"), options);
  var chart2 = new ApexCharts(document.querySelector("#chart2"), options2);

  chart.render();
  chart2.render();