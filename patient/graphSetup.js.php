
var CoverSheetGraph = CoverSheetGraph || {};
var CoverSheetBMI = CoverSheetBMI ||{};

CoverSheetGraph.dataDateFormat = function (element) {
    return [Date.parseDate(element[0], 'Y-m-d'), element[1]];
};


CoverSheetBMI.dataDateFormat = function (element) {
    return [Date.parseDate(element[0], 'Y-m-d'), element[1]];
};


CoverSheetGraph.dataSort = function (left, right) {
    if (left[0] > right[0]) return 1;
    if (left[0] < right[0]) return -1;
    return 0;
};


CoverSheetBMI.dataSort = function (left, right) {
    if (left[0] > right[0]) return 1;
    if (left[0] < right[0]) return -1;
    return 0;
};

CoverSheetGraph.dataArrayFormat = function (data) {
    data = data.map(CoverSheetGraph.dataDateFormat);
    data.sort(CoverSheetGraph.dataSort);
    return data;
};


CoverSheetBMI.dataArrayFormat = function (data) {
    data = data.map(CoverSheetBMI.dataDateFormat);
    data.sort(CoverSheetBMI.dataSort);
    return data;
};


CoverSheetGraph.dataCrop = function (theArray) {
   var lastDate = theArray.slice(-1)[0][0];
    var maximum;
    if(lastDate!= null) maximum = lastDate.add(Date.MONTH, 1);
    var minimum;
    if(lastDate!= null) minimum = maximum.add(Date.YEAR, -2);
    var returnData = [];
    for (var i = 0; i < theArray.length; ++i) {
	thisDate = theArray[i][0];
	if (thisDate >= minimum && thisDate <= maximum) {
	    returnData.push(theArray[i]);
	}
    }
    return returnData;
};


CoverSheetBMI.dataCrop = function (theArray) {
    var lastDate = theArray.slice(-1)[0][0];
    var maximum;
    if(lastDate!= null) maximum = lastDate.add(Date.MONTH, 1);
    var minimum;
    if(lastDate!= null) minimum = maximum.add(Date.YEAR, -2);
    var returnData = [];
    for (var i = 0; i < theArray.length; ++i) {
	thisDate = theArray[i][0];
	if (thisDate >= minimum && thisDate <= maximum) {
	    returnData.push(theArray[i]);
	}
    }
    return returnData;
};



CoverSheetGraph.genSeries = function (namePrefix, dataArray, xTitle, yTitle) {
    var formatedData = CoverSheetGraph.dataCrop(dataArray).map(function (data) {
	    return {x: data[0].getTime(),
		    y: data[1],
		    dataDate: data[0]};
	});

    if (namePrefix == "cd4") {
	var seriesStyle = {
	    color: "#ff8888",
	    radius: 5,
	    yAxis: 1
	};
    
    } else {
    
    if (namePrefix == "bmi") {
	var seriesStyle = {
	    color: "#888aff",
	    radius: 3,
	    yAxis: 0
	};
    }
    else {
	var seriesStyle = {
	    color: "#555555",
	    radius: 3,
	    yAxis: 0
	};
    }
    }

    return {
	animation: false,
	connectNulls: false,
	data: formatedData,
	color: seriesStyle.color,
	lineWidth: 3,
	name: yTitle,
	shadow: false,
	yAxis: seriesStyle.yAxis,
	marker: {
	    radius: seriesStyle.radius,
	    symbol: "circle"
	},
	events: {
	    legendItemClick: function(event) {
		return false;
	    }
	}
    };
};






CoverSheetBMI.genSeries = function (namePrefix, dataArray, xTitle, yTitle) {
    var formatedData = CoverSheetBMI.dataCrop(dataArray).map(function (data) {
	    return {x: data[0].getTime(),
		    y: data[1],
		    dataDate: data[0]};
	});

    if (namePrefix == "cd4") {
	var seriesStyle = {
	    color: "#ff8888",
	    radius: 5,
	    yAxis: 1
	};
    
    } else {
    
    if (namePrefix == "bmi") {
	var seriesStyle = {
	    color: "#888aff",
	    radius: 3,
	    yAxis: 0
	};
    }
    else {
	var seriesStyle = {
	    color: "#555555",
	    radius: 3,
	    yAxis: 0
	};
    }
    }

    return {
	animation: false,
	connectNulls: false,
	data: formatedData,
	color: seriesStyle.color,
	lineWidth: 3,
	name: yTitle,
	shadow: false,
	yAxis: seriesStyle.yAxis,
	marker: {
	    radius: seriesStyle.radius,
	    symbol: "circle"
	},
	events: {
	    legendItemClick: function(event) {
		return false;
	    }
	}
    };
};









CoverSheetGraph.gen3 = function (series, maxDate) {
if(maxDate!= null) maxDate=maxDate.add(Date.MONTH, 1).getTime();
    var chartRender = function(el) {
	new Highcharts.Chart({
		chart: {
		    renderTo: el.el.first().first().id,
		    type: 'line'
		    //spacingTop: 0,
		    //spacingBottom: 14,
		    //spacingLeft: 14,
		    //spacingRIght: 30
		},
		credits: {
		    enabled: false
		},
		title: {text: null},
		plotOptions: {
		    line: {
			states: {
			    hover: {
				lineWidth: 3
			    }
			}
		    }
		},
		legend: {
		    enabled: false,
		    verticalAlign: "top",
		    borderWidth: 0,
		    itemStyle: {cursor: 'default'},
		    itemHoverStyle: {cursor: 'default'}
		},
		tooltip: {
		    formatter: function () {
			var displayDate = this.point.dataDate.getDate() + '/'
			    + (this.point.dataDate.getMonth() + 1) + '/'
			    + this.point.dataDate.getFullYear();
			if (this.series.name == '<?= $coverHeaders[$lang][11] ?>') {
			    return this.y + ' kg (' + displayDate + ')';
			} else {
            
            if (this.series.name == '<?= $coverHeaders[$lang][14] ?>') {
			    return 'BMI ' + this.y + ' (' + displayDate + ')';
			}
            else {
			    return 'CD4 ' + this.y + ' (' + displayDate + ')';
			}
            }
		    },
		    backgroundColor: "rgba(218, 231, 246, .9)",
		    borderColor: "#99bbe8",
		    borderWidth: 1,
		    borderRadius: 0,
		    shadow: false,
		    style: {"font-family": "Tahoma",
			    "font-size": "10px",
			    "font-weight": "bold",
			    "color": "#15428B"}
		},
		xAxis: {
		    type: 'datetime',
		    lineColor: "#69aBc8",
		    gridLineColor: "#eeeeee",
		    gridLineWidth: 1,
		    tickPixelInterval: 35,
		    tickLength: 0,
		    startOnTick: true,
		    minPadding: 0,
		    max: maxDate,
		    labels: {
			align: "right",
			rotation: -45,
			style: {"font-family": "Tahoma",
				"font-size": "11px"},
			formatter: function () {
			    return Highcharts.dateFormat('%e/%m/%y', this.value);
			}
		    }
		},
		yAxis: [{
			min: 0,
			lineColor: "#69aBc8",
			lineWidth: 1,
			gridLineColor: "#dfe8f6",
			minorGridLineWidth: 0,
			tickColor: "#69aBc8",
			tickLength: 2,
			tickWidth: 1,
			title: {
			    text: '<?= $coverHeaders[$lang][11] ?>',
			    style: {
				color: "#555555"
			    }
			},
			labels: {
			    formatter : function() {
				return this.value;
			    },
			    style: {"font-family": "Tahoma",
				    "font-size": "11px"}
			}
		    },{
			opposite: true,
			min: 0,
			lineColor: "#69aBc8",
			lineWidth: 1,
			gridLineColor: "#dfe8f6",
			minorGridLineWidth: 0,
			tickColor: "#69aBc8",
			tickLength: 2,
			tickWidth: 1,
			title: {
			    text: '<?= $coverLabels[$lang][10] ?>',
			    style: {
				color: "#ff8888"
			    }
			},
			labels: {
			    formatter : function() {
				return this.value;
			    },
			    style: {"font-family": "Tahoma",
				    "font-size": "11px"}
			}
		    }],
		series: series
	    });
    };

    return {xtype: 'panel',
	    id: 'coverGraph',
	    layout: 'fit',
	    height: 350,
	    border: false,
	    listeners:{
	        afterrender: {
		    delay: 100,
		    fn: chartRender
		}
	    }
     };
};





CoverSheetBMI.gen4 = function (series, maxDate) {
if(maxDate!= null) maxDate=maxDate.add(Date.MONTH, 1).getTime();
    var chartRender = function(el) {
	new Highcharts.Chart({
		chart: {
		    renderTo: el.el.first().first().id,
		    type: 'line'
		    //spacingTop: 0,
		    //spacingBottom: 14,
		    //spacingLeft: 14,
		    //spacingRIght: 30
		},
		credits: {
		    enabled: false
		},
		title: {text: null},
		plotOptions: {
		    line: {
			states: {
			    hover: {
				lineWidth: 3
			    }
			}
		    }
		},
		legend: {
		    enabled: false,
		    verticalAlign: "top",
		    borderWidth: 0,
		    itemStyle: {cursor: 'default'},
		    itemHoverStyle: {cursor: 'default'}
		},
		tooltip: {
		    formatter: function () {
			var displayDate = this.point.dataDate.getDate() + '/'
			    + (this.point.dataDate.getMonth() + 1) + '/'
			    + this.point.dataDate.getFullYear();            
            if (this.series.name == '<?= $coverHeaders[$lang][14] ?>') {
			    return 'BMI ' + this.y + ' (' + displayDate + ')';
			}
		    },
		    backgroundColor: "rgba(218, 231, 246, .9)",
		    borderColor: "#99bbe8",
		    borderWidth: 1,
		    borderRadius: 0,
		    shadow: false,
		    style: {"font-family": "Tahoma",
			    "font-size": "10px",
			    "font-weight": "bold",
			    "color": "#15428B"}
		},
		xAxis: {
		    type: 'datetime',
		    lineColor: "#69aBc8",
		    gridLineColor: "#eeeeee",
		    gridLineWidth: 1,
		    tickPixelInterval: 35,
		    tickLength: 0,
		    startOnTick: true,
		    minPadding: 0,
		    max: maxDate,
		    labels: {
			align: "right",
			rotation: -45,
			style: {"font-family": "Tahoma",
				"font-size": "11px"},
			formatter: function () {
			    return Highcharts.dateFormat('%e/%m/%y', this.value);
			}
		    }
		},
		yAxis: [{
			min: 0,
			lineColor: "#69aBc8",
			lineWidth: 1,
			gridLineColor: "#dfe8f6",
			minorGridLineWidth: 0,
			tickColor: "#69aBc8",
			tickLength: 2,
			tickWidth: 1,
			title: {
			    text: '<?= $coverHeaders[$lang][14] ?>',
			    style: {
				color: "#555555"
			    }
			},
			labels: {
			    formatter : function() {
				return this.value;
			    },
			    style: {"font-family": "Tahoma",
				    "font-size": "11px"}
			}
		    },{
			opposite: true,
			min: 0,
			lineColor: "#69aBc8",
			lineWidth: 1,
			gridLineColor: "#dfe8f6",
			minorGridLineWidth: 0,
			tickColor: "#69aBc8",
			tickLength: 2,
			tickWidth: 1,
			title: {
			    text: '',
			    style: {
				color: "#ff8888"
			    }
			},
			labels: {
			    formatter : function() {
				return this.value;
			    },
			    style: {"font-family": "Tahoma",
				    "font-size": "11px"}
			}
		    }],
		series: series
	    });
    };

    return {xtype: 'panel',
	    id: 'coverBMI',
	    layout: 'fit',
	    height: 350,
	    border: false,
	    listeners:{
	        afterrender: {
		    delay: 100,
		    fn: chartRender
		}
	    }
     };
};







CoverSheetGraph.ext2 = function () {
    var coverGraphItems = [];
    if (CoverSheetGraph.data.weight.length == 0 && CoverSheetGraph.data.cd4.length == 0) {
	coverGraphItems.push({
	        xtype: 'panel',
		title: '<?= $coverHeaders[$lang][3] ?>',
		html: '<div style="padding: 40px 20px"><?= $coverHeaders[$lang][10] ?></div>'
	    });
    } else {
	if (CoverSheetGraph.data.cd4.length == 0) {
	    var commonMaxDate = CoverSheetGraph.data.weight[CoverSheetGraph.data.weight.length-1][0];
	} else if (CoverSheetGraph.data.weight.length == 0) {
	    var commonMaxDate = CoverSheetGraph.data.cd4[CoverSheetGraph.data.cd4.length-1][0];
	} else if (CoverSheetGraph.data.weight[CoverSheetGraph.data.weight.length-1][0] > CoverSheetGraph.data.cd4[CoverSheetGraph.data.cd4.length-1][0]) {
	    var commonMaxDate = CoverSheetGraph.data.weight[CoverSheetGraph.data.weight.length-1][0];
	} else {
	    var commonMaxDate = CoverSheetGraph.data.cd4[CoverSheetGraph.data.cd4.length-1][0];
	}

	var series = [];
	if (CoverSheetGraph.data.weight.length != 0) {
	    series.push(CoverSheetGraph.genSeries('wt', CoverSheetGraph.data.weight,
						  '<?= $coverHeaders[$lang][9] ?>',
						  '<?= $coverHeaders[$lang][11] ?>'));
	}
	if (CoverSheetGraph.data.cd4.length != 0) {
	    series.push(CoverSheetGraph.genSeries('cd4', CoverSheetGraph.data.cd4,
						  '<?= $coverHeaders[$lang][8] ?>',
						  '<?= $coverLabels[$lang][10] ?>'));
	}     
        
	coverGraphItems.push(CoverSheetGraph.gen3(series, commonMaxDate));
    }
    return coverGraphItems;
};



CoverSheetBMI.ext3 = function () {
    var coverBMIItems = [];
    if (CoverSheetBMI.data.bmi.length == 0 && CoverSheetBMI.data.weight.length == 0) {
	coverBMIItems.push({
	        xtype: 'panel',
		title: '<?= $coverHeaders[$lang][3] ?>',
		html: '<div style="padding: 40px 20px"><?= $coverHeaders[$lang][10] ?></div>'
	    });
    } else {
	if (CoverSheetBMI.data.weight.length == 0) {
	    var commonMaxDate = CoverSheetBMI.data.bmi[CoverSheetBMI.data.bmi.length-1][0];
	} else if (CoverSheetBMI.data.bmi.length == 0) {
	    var commonMaxDate = CoverSheetBMI.data.weight[CoverSheetBMI.data.weight.length-1][0];
	} else if (CoverSheetBMI.data.weight[CoverSheetBMI.data.weight.length-1][0] > CoverSheetBMI.data.bmi[CoverSheetBMI.data.bmi.length-1][0]) {
	    var commonMaxDate = CoverSheetBMI.data.weight[CoverSheetBMI.data.weight.length-1][0];
	} else {
	    var commonMaxDate = CoverSheetBMI.data.bmi[CoverSheetBMI.data.bmi.length-1][0];
	}

	var series = [];    
    
    if (CoverSheetBMI.data.bmi.length != 0) {
	    series.push(CoverSheetBMI.genSeries('bmi', CoverSheetBMI.data.bmi,
						  '<?= $coverHeaders[$lang][13] ?>',
						  '<?= $coverHeaders[$lang][14] ?>'));
	} 
    
    
	coverBMIItems.push(CoverSheetBMI.gen4(series, commonMaxDate));
    }
    return coverBMIItems;
};


/** 201312 - GrowthChart functions no longer used. However, keeping parts for
    reference. Could be useful.**/

//Namespace for all data and functions used by the growth charts.
var GrowthChart = GrowthChart || {};

GrowthChart.zScoreToValue = function (l, m, s, zScore) {
    if (l === null) {
	return null;
    } else if (l == 0) {
	return m * Math.exp(s * zScore);
    } else {
	return m * Math.pow(1 + l*s*zScore, 1/l);
    }
};

GrowthChart.valueToZScore = function (l, m, s, value) {
    if (l == 0) {
	return Math.log(value/m) / s;
    } else {
	return (Math.pow(value/m, l) - 1) / (l*s);
    }
}


//Functions used to manipulate growth data sets.
GrowthChart.LmsData = {};

GrowthChart.LmsData.getter = function (name) {
    return function () {return growthChartLmsData[name];};
};

GrowthChart.LmsData.changeUnit = function (lmsData, factor) {
    var returnData = [];
    for (var gender in lmsData) {
	if (lmsData[gender] instanceof Array) {
	    returnData[gender] = lmsData[gender].map(function (element) {
		    return [element[0]*factor, element[1], element[2], element[3]];
		});
	}
    }
    return returnData;
};

GrowthChart.LmsData.clip = function (lmsData, xMin, xMax) {
    var returnData = [];
    for (var gender in lmsData) {
	if (lmsData[gender] instanceof Array) {
	    returnData[gender] = [];
	    lmsData[gender].map(function (element) {
		    if (element[0] >= xMin && element[0] <= xMax) {
			returnData[gender].push(element);
		    }
		});
	}
    }
    return returnData;
};

GrowthChart.LmsData.toPercentileCurve = function (lmsData, gender, percentile) {
    zScore = GrowthChart.ZTable.percentileToZScore(percentile);
    if (zScore === null) {
	return null;
    }

    return lmsData[gender].map(function(value) {
	    return [value[0], GrowthChart.zScoreToValue(value[1],value[2],value[3],zScore)];
	});
};

//This function could be used to add discontinuities but it currently isn't needed and it looks like null values are buggy in Highcharts anyway.
GrowthChart.LmsData.insertNull = function (data, index) {
    var outputData = {};
    for (var gender in data) {
	outputData[gender] = [];
	for (var i=0; i<data[gender].length; i++) {
	    outputData[gender].push(data[gender][i]);
	    if (i+1 == index) {
		outputData[gender].push([data[gender][i][0], null, null, null]);
		//i=i+1; //Doesn't work unless this is here. Might be a bug in Highcharts.
	    }
	}
    }
    return outputData;
};

//Constants used for date/time unit conversion.
GrowthChart.Constant = {};

//Days in a tropical (solar) year as of Jan 1, 2000. Source http://en.wikipedia.org/wiki/Tropical_year#Mean_tropical_year_current_value
//This one isn't much use here. It is approxamtily what you get when you enter 'days in a year' in to Google though. 
GrowthChart.Constant.daysInTropicalYear = 365.2421897;

//Days in a year based on the Gregorian calendar. This is probably the most accurate and useful value to use in the long term. 
GrowthChart.Constant.daysInGregorianYear = 365.2425;

//Days in a year based on the Julian calendar. The only reason this is here is because this is the value specified by the WHO guidelines. 
GrowthChart.Constant.daysInJulianYear = 365.25;

//Nobody disagrees on this. La la la la http://en.wikipedia.org/wiki/Leap_second I can't hear you.
GrowthChart.Constant.secondsInADay = 86400;

GrowthChart.Constant.millisecondsInAGregorianYear 
    = 1000 * GrowthChart.Constant.secondsInADay * GrowthChart.Constant.daysInGregorianYear;

GrowthChart.Constant.millisecondsInAGregorianMonth
    = GrowthChart.Constant.millisecondsInAGregorianYear / 12;

GrowthChart.Constant.millisecondsInAJulianMonth
    = 1000 * GrowthChart.Constant.secondsInADay * GrowthChart.Constant.daysInJulianYear / 12;

//Functions used to manipulate data points to be included on the growth charts.
GrowthChart.DataInput = {};

GrowthChart.DataInput.clipOrConvertAge = function (birthDate, ageUnitFactor, minAge, maxAge, date) {
    var age = (date - birthDate) * ageUnitFactor;
    if (minAge !== undefined && age < minAge) {
	return null;
    } else if (maxAge !== undefined && age > maxAge) {
	return null;
    } else {
	return age;
    }
};

//Generate an input filter witch converts x dates to ages and adjusts the x values based on xUnitFactor.
//The filter itself takes two parameters. The first is the data to filter and the second is the birth date of the patient. 
GrowthChart.DataInput.convertAge = function (ageUnitFactor, minAge, maxAge) {
    return function (data, birthDate) {
	var returnData = [];
	data.forEach(function (element) {
		var age = GrowthChart.DataInput.clipOrConvertAge(birthDate, ageUnitFactor, minAge, maxAge, element[0]); 
		if (age !== null) {
		    returnData.push({x: age,
				y: element[1],
				dataDate: element[0]});
		}
	    });
	return returnData;
    };
};

GrowthChart.DataInput.convertXY = function (ageUnitFactor, minAge, maxAge, minX, maxX) {
    return function (data, birthDate) {
	var returnData = [];
	data.forEach(function (element) {
		var age = GrowthChart.DataInput.clipOrConvertAge(birthDate, ageUnitFactor, minAge, maxAge, element[0]); 
		if (age !== null) {
		    var x = element[1];
		    if (minX === undefined || minX <= x) {
			if (maxX === undefined || maxX >= x) {
			    returnData.push({x: x,
					y: element[2],
					dataDate: element[0],
					dataAge: age});
			}
		    }
		}
	    });
	return returnData;
    };
};

GrowthChart.DataInput.convertAgeBMI = function (ageUnitFactor, minAge, maxAge) {
    return function (data, birthDate) {
	var returnData = [];
	data.forEach(function (element) {
		var age = GrowthChart.DataInput.clipOrConvertAge(birthDate, ageUnitFactor, minAge, maxAge, element[0]);
		if (age !== null) {
		    var heightMeters = element[1]/100;
		    returnData.push({x: age,
				y: element[2] / (heightMeters * heightMeters),
				dataDate: element[0]});
		}
	    });
	return returnData;
    };
};

//Take two regular input data sets and combine them where their dates match.
//data1 and data2 must be sorted.
GrowthChart.DataInput.matchDate = function (data1, data2) {
    var index1 = 0;
    var index2 = 0;
    var matchedData = [];
    while (index1 < data1.length && index2 < data2.length) {
	if (data1[index1][0].getTime() == data2[index2][0].getTime()) {
	    matchedData.push([data1[index1][0], data1[index1][1], data2[index2][1]]);
	    index1 = index1 + 1;
	    index2 = index2 + 1;
	} else if (data1[index1][0].getTime() < data2[index2][0].getTime()) {
	    index1 = index1 + 1;
	} else {
	    index2 = index2 + 1;
	}
    }
    return matchedData;
};

GrowthChart.DataInput.toPercentile = function (lmsDate, gender, x, y) {
    if (x < lmsDate[gender][0][0]
	|| x > lmsDate[gender][lmsDate[gender].length-1][0]) {
	return null;
    }

    var nearestLsm = GrowthChart.linearIndexSearch(0, lmsDate[gender].length-1,
						   function (i) {
						       return lmsDate[gender][i][0];
						   },
						   x);
    var lowLms = lmsDate[gender][nearestLsm[0]];
    var highLms = lmsDate[gender][nearestLsm[1]];
    var weight = nearestLsm[2];
    var lowZScore = GrowthChart.valueToZScore(lowLms[1], lowLms[2], lowLms[3], y);
    var highZScore = GrowthChart.valueToZScore(highLms[1], highLms[2], highLms[3], y);
    var interpolatedZScore = weight*highZScore + (1-weight)*lowZScore;
    return GrowthChart.ZTable.zScoreToPercentile(interpolatedZScore);
}

//Meta data for all types of growth charts we can make.
GrowthChart.allGraphInfo = {
    'cdc_weight_month_0-36': {
	source: "CDC",
	title: "<?=_('en:Weight for Age')?> (0-36 <?=_('en:Months')?>)",
	xTitle: "<?=_('en:Age')?> (<?=_('en:Months')?>)",
	yTitle: "<?=_('en:Weight')?> (kg)",
	dataSetGetter: GrowthChart.LmsData.getter("cdc_weight_month_0-36"),
	inputFilter: GrowthChart.DataInput.convertAge(1 / GrowthChart.Constant.millisecondsInAGregorianMonth, 0, 36),
	xTickInterval: 3,
	xMinorTickInterval: 1,
	yTickInterval: 1,
	yMinorTickInterval: 0.2
    },
    'cdc_length_month_0-36': {
	source: "CDC",
	title: "<?=_('en:Length for Age')?> (0-36 <?=_('en:Months')?>)",
	xTitle: "<?=_('en:Age')?> (<?=_('en:Months')?>)",
	yTitle: "<?=_('en:Length')?> (cm)",
	dataSetGetter: GrowthChart.LmsData.getter("cdc_length_month_0-36"),
	inputFilter: GrowthChart.DataInput.convertAge(1 / GrowthChart.Constant.millisecondsInAGregorianMonth, 0, 36),
	xTickInterval: 3,
	xMinorTickInterval: 1,
	yTickInterval: 5,
	yMinorTickInterval: 1
    },
    'cdc_weight_length_month_0-36': {
	source: "CDC",
	title: "<?=_('en:Weight for Length')?> (0-36 <?=_('en:Months')?>)",
	xTitle: "<?=_('en:Length')?> (cm)",
	yTitle: "<?=_('en:Weight')?> (kg)",
	ageTitle: "<?=_('en:Age')?> (<?=_('en:Months')?>)",
	dataSetGetter: GrowthChart.LmsData.getter("cdc_weight_length_45-103.5"),
	inputFilter: GrowthChart.DataInput.convertXY(1 / GrowthChart.Constant.millisecondsInAGregorianMonth, 0, 36),
	xTickInterval: 10,
	xMinorTickInterval: 2,
	yTickInterval: 1,
	yMinorTickInterval: 0.2
    },
    'cdc_circumference_month_0-36': {
	source: "CDC",
	title: "<?=_('en:Head Circumference for Age')?> (0-36 <?=_('en:Months')?>)",
	xTitle: "<?=_('en:Age')?> (<?=_('en:Months')?>)",
	yTitle: "<?=_('en:Head Circumference')?> (cm)",
	dataSetGetter: GrowthChart.LmsData.getter("cdc_circumference_month_0-36"),
	inputFilter: GrowthChart.DataInput.convertAge(1 / GrowthChart.Constant.millisecondsInAGregorianMonth, 0, 36),
	xTickInterval: 3,
	xMinorTickInterval: 1,
	yTickInterval: 1,
	yMinorTickInterval: 0.2
    },
    'cdc_height_year_2-20': {
	source: "CDC",
	title: "<?=_('en:Height for Age')?> (2-20 <?=_('en:Years')?>)",
	xTitle: "<?=_('en:Age')?> (<?=_('en:Years')?>)",
	yTitle: "<?=_('en:Length')?> (cm)",
	dataSetGetter: function () {
	    return GrowthChart.LmsData.changeUnit(growthChartLmsData["cdc_height_month_24-240"], 1/12);
	},
	inputFilter: GrowthChart.DataInput.convertAge(1 / GrowthChart.Constant.millisecondsInAGregorianYear, 2, 20),
	xTickInterval: 1,
	xMinorTickInterval: 0.5,
	yTickInterval: 5,
	yMinorTickInterval: 1
    },
    'cdc_weight_year_2-20': {
	source: "CDC",
	title: "<?=_('en:Weight for Age')?> (2-20 <?=_('en:Years')?>)",
	xTitle: "<?=_('en:Age')?> (<?=_('en:Years')?>)",
	yTitle: "<?=_('en:Weight')?> (kg)",
	dataSetGetter: function () {
	    return GrowthChart.LmsData.changeUnit(growthChartLmsData["cdc_weight_month_24-240"], 1/12);
	},
	inputFilter: GrowthChart.DataInput.convertAge(1 / GrowthChart.Constant.millisecondsInAGregorianYear, 2, 20),
	xTickInterval: 1,
	xMinorTickInterval: 0.5,
	yTickInterval: 5,
	yMinorTickInterval: 1
    },
    'cdc_bmi_year_2-20': {
	source: "CDC",
	title: "<?=_('en:BMI for Age')?> (2-20 <?=_('en:Years')?>)",
	xTitle: "<?=_('en:Age')?> (<?=_('en:Years')?>)",
	yTitle: "<?=_('en:BMI')?> (kg/m²)",
	dataSetGetter: function () {
	    return GrowthChart.LmsData.changeUnit(growthChartLmsData["cdc_bmi_month_24-240"], 1/12);
	},
	inputFilter: GrowthChart.DataInput.convertAgeBMI(1 / GrowthChart.Constant.millisecondsInAGregorianYear, 2, 20),
	xTickInterval: 1,
	xMinorTickInterval: 0.5,
	yTickInterval: 1,
	yMinorTickInterval: 0.2
    },
    'cdc_weight_stature_2-5': {
	source: "CDC",
	title: "<?=_('en:Weight for Stature')?> (2-5 <?=_('en:Years')?>)",
	xTitle: "<?=_('en:Stature')?> (cm)",
	yTitle: "<?=_('en:Weight')?> (kg)",
	ageTitle: "<?=_('en:Age')?> (<?=_('en:Years')?>)",
	dataSetGetter: GrowthChart.LmsData.getter("cdc_weight_height_77-121.5"),
	inputFilter: GrowthChart.DataInput.convertXY(1 / GrowthChart.Constant.millisecondsInAGregorianYear, 2, 5),
	xTickInterval: 5,
	xMinorTickInterval: 1,
	yTickInterval: 1,
	yMinorTickInterval: 0.2
    },
    'who_bmi_month_0-24': {
	source: "WHO",
	title: "<?=_('en:BMI for Age')?> (0-24 <?=_('en:Months')?>)",
	xTitle: "<?=_('en:Age')?> (<?=_('en:Months')?>)",
	yTitle: "<?=_('en:BMI')?> (kg/m²)",
	dataSetGetter: function () {
	    return GrowthChart.LmsData.clip(GrowthChart.LmsData.changeUnit(growthChartLmsData["who_bmi_day_0-1856"],
								      12/GrowthChart.Constant.daysInJulianYear),
					    0, 24);
	},
	inputFilter: GrowthChart.DataInput.convertAgeBMI(1 / GrowthChart.Constant.millisecondsInAJulianMonth, 0, 24),
	xTickInterval: 2,
	xMinorTickInterval: 1,
	yTickInterval: 1,
	yMinorTickInterval: 0.25
    },
    'who_circumference_month_0-24': {
	source: "WHO",
	title: "<?=_('en:Head Circumference for Age')?> (0-24 <?=_('en:Months')?>)",
	xTitle: "<?=_('en:Age')?> (<?=_('en:Months')?>)",
	yTitle: "<?=_('en:Head Circumference')?> (cm)",
	dataSetGetter: function () {
	    return GrowthChart.LmsData.clip(GrowthChart.LmsData.changeUnit(growthChartLmsData["who_circumference_day_0-1856"],
								      12/GrowthChart.Constant.daysInJulianYear),
					    0, 24);
	},
	inputFilter: GrowthChart.DataInput.convertAge(1 / GrowthChart.Constant.millisecondsInAJulianMonth, 0, 24),
	xTickInterval: 2,
	xMinorTickInterval: 1,
	yTickInterval: 2,
	yMinorTickInterval: 0.5
    },
    'who_length_month_0-24': {
	source: "WHO",
	title: "<?=_('en:Length for Age')?> (0-24 <?=_('en:Months')?>)",
	xTitle: "<?=_('en:Age')?> (<?=_('en:Months')?>)",
	yTitle: "<?=_('en:Length')?> (cm)",
	dataSetGetter: function () {
	    return GrowthChart.LmsData.clip(GrowthChart.LmsData.changeUnit(growthChartLmsData["who_lengthHeight_day_0-1856"],
								      12/GrowthChart.Constant.daysInJulianYear),
					    0, 24);
	},
	inputFilter: GrowthChart.DataInput.convertAge(1 / GrowthChart.Constant.millisecondsInAJulianMonth, 0, 24),
	xTickInterval: 2,
	xMinorTickInterval: 1,
	yTickInterval: 5,
	yMinorTickInterval: 1
    },
    'who_weight_month_0-24': {
	source: "WHO",
	title: "<?=_('en:Weight for Age')?> (0-24 <?=_('en:Months')?>)",
	xTitle: "<?=_('en:Age')?> (<?=_('en:Months')?>)",
	yTitle: "<?=_('en:Weight')?> (kg)",
	dataSetGetter: function () {
	    return GrowthChart.LmsData.clip(GrowthChart.LmsData.changeUnit(growthChartLmsData["who_weight_day_0-1856"],
								      12/GrowthChart.Constant.daysInJulianYear),
					    0, 24);
	},
	inputFilter: GrowthChart.DataInput.convertAge(1 / GrowthChart.Constant.millisecondsInAJulianMonth, 0, 24),
	xTickInterval: 2,
	xMinorTickInterval: 1,
	yTickInterval: 1,
	yMinorTickInterval: 0.5
    },
    'who_weight_length_month_0-24': {
	source: "WHO",
	title: "<?=_('en:Weight for Length')?> (0-24 <?=_('en:Months')?>)",
	xTitle: "<?=_('en:Length')?> (cm)",
	yTitle: "<?=_('en:Weight')?> (kg)",
	ageTitle: "<?=_('en:Age')?> (<?=_('en:Months')?>)",
	dataSetGetter: GrowthChart.LmsData.getter("who_weight_length_45-110"),
	inputFilter: GrowthChart.DataInput.convertXY(1 / GrowthChart.Constant.millisecondsInAJulianMonth, 0, 24),
	xTickInterval: 10,
	xMinorTickInterval: 2,
	yTickInterval: 2,
	yMinorTickInterval: 1
    }
};
//Definitions for different sets of percentile curves. Each curve is described as a percentile value and a boolean value which indicates if the curve should be displayed with emphasis. All curves with percentile > 0.5 are mirrored using the formulate (1 - percentile).
GrowthChart.allPercentileInfo = {
    cdc95: [[0.5, true], [0.75, false], [0.9, false], [0.95, true]],
    cdc97: [[0.5, true], [0.75, false], [0.9, false], [0.97, true]],
    who: [[0.5, true], [0.85, false], [0.97, false]],
    crazy: [[0.5, true], [0.75, false], [0.85, false], [0.9, false],
	    [0.95, false], [0.97, false], [0.99, false], [0.999, false]]
};

GrowthChart.dataTable = function (gender, graphInfo, scatterData, birthDate) {
    var lmsDate = graphInfo.dataSetGetter();
    var scatterSeriesData = graphInfo.inputFilter(scatterData, birthDate);
    scatterSeriesData.forEach(function (element) {
	    element.percentile = GrowthChart.DataInput.toPercentile(lmsDate, gender,
								    element.x, element.y);
	});
    return scatterSeriesData;
};

GrowthChart.render = function (div, gender, graphInfo, percentileInfo, scatterData, birthDate) {
    var percentileData = [];
    for (var i=percentileInfo.length-1; i>0; i--) {
	percentileData.push([1-percentileInfo[i][0], percentileInfo[i][1]]);
    }
    percentileData = percentileData.concat(percentileInfo);

    var lmsDate = graphInfo.dataSetGetter();
    var seriesData = percentileData.map(function(data) {
	var curveData = GrowthChart.LmsData.toPercentileCurve(lmsDate, gender, data[0]);
	lineWidth = 0.5;
	if (data[1]) {
	    lineWidth = 1.5;
	}

	return {
	    animation: false,
	    name: Math.round((data[0]*100) * 100) / 100,
	    connectNulls: false,
	    data: curveData,
	    dataLabels: {
		enabled: true,
		align: "right",
		    style: {"font-size": "110%"},
		formatter: function() {
		    if (this.x == curveData[curveData.length-1][0]) {
			return Math.round((data[0]*100) * 100) / 100;
		    }
		}
	    },
	    enableMouseTracking: false,
	    color: "#000000",
	    lineWidth: lineWidth,
	    marker: {enabled: false},
	    shadow: false
	};
    });

    var scatterSeriesData = graphInfo.inputFilter(scatterData, birthDate);
    seriesData.push({
	    animation: false,
	    name: "scatterData",
	    data: scatterSeriesData,
	    color: "#000000",
	    lineWidth: 0,
	    marker: {
		enabled: true,
		radius: 6,
		symbol: "diamond"
		    },
	    shadow: false
		});

    if (gender == "male") {
	var displayGender = "<?=_('en:Boys')?>";
    } else {
	var displayGender = "<?=_('en:Girls')?>";
    }

    var title = graphInfo.source + ', ' + graphInfo.title + ', ' + displayGender;

    new Highcharts.Chart({
         chart: {
	    renderTo: div,
            type: 'line'
         },
	 credits: {
	    enabled: false
	 },
         title: {
	    text: title,
	    style: {"color": "#000000"}
         },
	 legend: {enabled: false},
	 tooltip: {
		formatter: function () {
		    var percentile = GrowthChart.DataInput.toPercentile(lmsDate, gender, this.x, this.y);

		    var displayDate = this.point.dataDate.getDate() + '/'
			+ (this.point.dataDate.getMonth() + 1) + '/'
			+ this.point.dataDate.getFullYear();
		    var displayX = Math.round(this.x * 100) / 100;
		    var displayY = Math.round(this.y * 100) / 100;
		    var displayAge = ''; //optional, only weight for length/height charts use this
		    if (this.point.dataAge !== undefined && graphInfo.ageTitle !== undefined) {
			if (this.point.dataAge == 0) {
			    displayAge = "<?=_('en:day of birth')?>";
			} else {
			    displayAge = graphInfo.ageTitle + ": " + Math.round(this.point.dataAge*100)/100 + "<br>";
			}
		    } else {
			if (this.x == 0) {
			    displayX = "<?=_('en:day of birth')?>";
			}
		    }
		    if (percentile === null) {
			var displayPercentile = '';
		    } else {
			var displayPercentile = "<br><?=_('en:Percentile')?>" + ": " 
			    + Math.round(percentile * 100 * 100) / 100;
		    }

		    return "<?=_('en:Date')?>" + ": " + displayDate + "<br>"
			+ displayAge
			+ graphInfo.xTitle + ": " + displayX + "<br>" 
			+ graphInfo.yTitle + ": " + displayY
			+ displayPercentile;
		}
	 },
         xAxis: {
            title: {
	       text: graphInfo.xTitle,
	       style: {"color": "#000000"}
            },
	    gridLineWidth: 1,
	    tickInterval: graphInfo.xTickInterval,
	    minorTickInterval: graphInfo.xMinorTickInterval,
	    labels: {
	       style: {"font-size": "110%"}
	    }
         },
         yAxis: {
            title: {
	       text: graphInfo.yTitle,
	       style: {"color": "#000000"}
            },
	    max: graphInfo.yMax,
	    tickInterval: graphInfo.yTickInterval,
	    minorTickInterval: graphInfo.yMinorTickInterval,
	    labels: {
	       style: {"font-size": "110%"}
	    }
         },
         series: seriesData
      });
};

GrowthChart.linearIndexSearch = function (firstIndex, lastIndex, lookup, targetValue) {
    //Find closest value
    var closestIndex = GrowthChart.indexSearch(firstIndex, lastIndex, lookup, targetValue);
    var closestValue = lookup(closestIndex);

    if (closestValue == targetValue) {
	return [closestIndex, closestIndex, 0];
    } else if (closestValue < targetValue) {
	var lowerIndex = closestIndex;
	var lowerValue = closestValue;
	var upperIndex = closestIndex + 1;
	var upperValue = lookup(upperIndex);
    } else {
	var upperIndex = closestIndex;
	var upperValue = closestValue;
	var lowerIndex = closestIndex - 1;
	var lowerValue = lookup(lowerIndex);
    }

    var upperWeight = (targetValue - lowerValue) / (upperValue - lowerValue);
    return [lowerIndex, upperIndex, upperWeight];
}

GrowthChart.indexSearch = function (firstIndex, lastIndex, lookup, targetValue) {
    //Does the targetValue exactly match the value located at firstIndex?
    firstValue = lookup(firstIndex);
    if (targetValue == firstValue) {
	return firstIndex;
    }

    //Does the targetValue exactly match the value located at lastIndex?
    lastValue = lookup(lastIndex);
    if (targetValue == lastValue) {
	return lastIndex;
    }

    //If firstIndex and lastIndex are right next to each other then pick the value which is closest to targetValue.
    if (firstIndex + 1 == lastIndex) {
	if ( (targetValue - firstValue) < (lastValue - targetValue) ) {
	    return firstIndex;
	} else {
	    return lastIndex;
	}
    }

    //Cut the range between firstIndex and lastIndex in half and try the search again.
    middleIndex = Math.floor((firstIndex + lastIndex) / 2);
    if (lookup(middleIndex) > targetValue) {
	return GrowthChart.indexSearch(firstIndex, middleIndex, lookup, targetValue);
    } else {
	return GrowthChart.indexSearch(middleIndex, lastIndex, lookup, targetValue);
    }
};


//Functions and data for converting z-scores to percentiles and back.
GrowthChart.ZTable = {};

GrowthChart.ZTable.percentileToZScore = function percentileToZScore(percentile) {
    var zTable = GrowthChart.ZTable.data;

    //Highest percentile value in our zTable
    zTableUpperBound = zTable[zTable.length-1][0];

    //Make sure the percentile we are being asked to convert is not outside the bounds of our zTable
    if (percentile < (1 - zTableUpperBound) || percentile > zTableUpperBound) {
	return null;
    }

    //If the percentile is < 0.5 then make the z-score will be negative
    if (percentile < 0.5) {
	var negativeZ = true;
	percentile = 1 - percentile;
    } else {
	var negativeZ = false;
    }

    tableIndex = GrowthChart.indexSearch(0, zTable.length-1,
					 function (i) {return zTable[i][0];}, percentile);

    if (negativeZ) {
	return -zTable[tableIndex][1];
    } else {
	return zTable[tableIndex][1];
    }
};

GrowthChart.ZTable.zScoreToPercentile = function (zScore) {
    var zTable = GrowthChart.ZTable.data;

    //Highest z-score value in our zTable
    zTableUpperBound = zTable[zTable.length-1][1];

    //Make sure the z-score we are being asked to convert is not outside the bounds of our zTable
    if (zScore < -zTableUpperBound || zScore > zTableUpperBound) {
	return null;
    }

    //If the z-score is negative then lookup the positive one instead
    if (zScore < 0) {
	var negativeZ = true;
	zScore = -zScore;
    } else {
	var negativeZ = false;
    }

    tableIndex = GrowthChart.indexSearch(0, zTable.length-1,
					 function (i) {return zTable[i][1];}, zScore);

    if (negativeZ) {
	return 1 - zTable[tableIndex][0];
    } else {
	return zTable[tableIndex][0];
    }
};

GrowthChart.ZTable.data = <?php readfile('growthChartData/z-scores.json'); ?>;



/**End - Commenting out all GrowthChart functions 
**/ 
