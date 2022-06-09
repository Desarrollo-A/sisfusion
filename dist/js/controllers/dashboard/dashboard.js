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
      enabled: false
    }
  },
  grid:{
    show:true,
    
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
      name: 'Ventas apartados',
      data: [0]
    }, {
      name: 'Cancelados apartados',
      data: [0]
    }, {
      name: 'Ventas contratadas',
      data: [0]
    }, {
      name: 'Canceladas contratadas',
      data: [0]
    }],
    chart: {
      type: 'bar',
      height: '80%',
      stacked: true,
      stackType: '100%',
      toolbar:{
        show:false
      }
    },
    noData: {
      text: undefined,
      align: 'center',
      verticalAlign: 'middle',
      offsetX: 0,
      offsetY: 0,
      show:false,
      style: {
        color: undefined,
        fontSize: '14px',
        fontFamily: undefined
      }
    },
    plotOptions: {
      bar: {
        horizontal: true
      },
    },
    stroke: {
      width: 0.5,
      colors: ['#fff']
    },
    yaxis: {
      labels: {
        show: false,
      }
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return ''
        }
      }
    },
    fill: {
      opacity: 1
    },
    xaxis: {
      categories: [''],
    },
    legend: {
      position: 'left',
      horizontalAlign: 'center',
      offsetY: 10,
      show:false,
    },

  };

  var options3 = {
    series: [{
      name: 'series1',
      data: [256, 104, 318, 465, 233, 363, 150]
    }],
    chart: {
      width: '100%',
      height:'100%',
      type: 'area',
      toolbar: {
        show: false
      },
      sparkline: {
        enabled: false
      }
    },
    grid:{
      show:true,

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

  var options4 = {
  chart: {
    height: 360,
    type: "bar",
    toolbar: {
      show: !1
    },
    events: {
      click: function(o, a, t) {
        console.log(o, a, t)
      }
    }
  },
  colors : ["#4caf50", "#003d82", "#999999", "#f44336", "#ffa500", "#003d82", "#4caf50", "#f44336"],
  plotOptions: {
    bar: {
      columnWidth: "45%",
      distributed: !0,
      horizontal: true,
    }
  },

  dataLabels: {
    enabled: !1
  },
  series: [{
    data: [100560, 156, 25, 52, 2508, 6532, 198360, 1632]
  }],
  xaxis: {
    categories: ["Prospectos Totales", "Nuevos prospectos", "Ventas apartados", "Cancelados apartados", "Cierres totales", "Prospectos con cita", "Ventas contratadas", "Contratos cancelados"],
    labels: {
      style: {
        colors : ["#4caf50", "#003d82", "#999999", "#f44336", "#ffa500", "#003d82", "#4caf50", "#f44336"],
        fontSize: "14px"
      }
    }
  },
  legend: {
    offsetY: 7
  },
  grid: {
    row: {
      colors: ["transparent", "transparent"],
      opacity: .2
    },
    borderColor: "#f1f3fa"
  }
};


  var chart = new ApexCharts(document.querySelector("#chart"), options);
  var chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
  var chart3 = new ApexCharts(document.querySelector("#chart3"), options3);
  var chart4 = new ApexCharts(document.querySelector("#chart4"), options4);

  chart.render();
  chart2.render();
  chart3.render();
  chart4.render();
