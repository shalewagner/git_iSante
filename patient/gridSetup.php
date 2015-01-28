<? require_once 'labels/grid.php'; ?>
var fm = Ext.form;
function formatDate(value){
    return value ? value.dateFormat('Y-m-d') : '';
};

function formatDateShort(value){
    return value ? value.dateFormat('Y-m') : '';
};

var labRec = new Ext.data.Record.create([
	{name: 'vDate', type: 'date'},
	{name: 'labid', type: 'string'},
	{name: 'labGroup', type: 'string'},	
	{name: 'testName<?=ucfirst($lang);?>', type: 'string'},
	{name: 'result', type: 'string'},
	{name: 'result2', type: 'string'},
	{name: 'result3', type: 'string'},
	{name: 'resultAbnormal', type: 'bool'},
	{name: 'resultRemarks', type: 'string'},
	{name: 'resultDate', type: 'date'},
	{name: 'assessionNumber', type: 'string'},
	{name: 'sendingSiteName', type: 'string'}
]);

var dxRec = new Ext.data.Record.create([
	{name: 'vDate', type: 'string'},
	{name: 'conditions_id', type: 'string'},
	{name: 'whoStage', type: 'string'},
	{name: 'conditionName<?=ucfirst($lang);?>', type: 'string'},
	{name: 'active', type: 'bool'},
	{name: 'resolved', type: 'bool'},
	{name: 'onsetDate', type: 'string'} 
]);

var rxRec = new Ext.data.Record.create([
	{name: 'vDate', type: 'string'},
	{name: 'drugID', type: 'string'},
	{name: 'drugGroup', type: 'string'},
	{name: 'drugName', type: 'string'},
	{name: 'isContinued', type: 'bool'},
	{name: 'startDate', type: 'string'},
	{name: 'stopDate', type: 'string'},
	{name: 'toxicity', type: 'bool'},
	{name: 'intolerance', type: 'bool'},
	{name: 'failureVir', type: 'bool'},
	{name: 'failureImm', type: 'bool'},
	{name: 'failureClin', type: 'bool'},
	{name: 'stockOut', type: 'bool'},
	{name: 'pregnancy', type: 'bool'},
	{name: 'patientHospitalized', type: 'bool'},
	{name: 'lackMoney', type: 'bool'},
	{name: 'alternativeTreatments', type: 'bool'},
	{name: 'missedVisit', type: 'bool'},
	{name: 'patientPreference', type: 'bool'} 
]);

var labReader = new Ext.data.JsonReader({root: 'results',totalProperty: 'total'}, labRec);
var dxReader = new Ext.data.JsonReader({ root: 'results', totalProperty: 'total' }, dxRec);
var rxReader = new Ext.data.JsonReader({ root: 'results', totalProperty: 'total' }, rxRec);

var labDs = new Ext.data.GroupingStore({
	id: 'labDs',
	proxy: new Ext.data.HttpProxy({
		url: 'patient/getHistory.php',
		method: 'POST'
	}),
	reader: labReader,
	remoteSort: true,
	sortInfo: [
		{field: 'labGroup', direction: 'ASC'},
		{field: 'testName<?=ucfirst($lang);?>', direction: 'ASC'},
		{field: 'vDate', direction: 'DESC'}
	],
	groupField: 'testName<?=ucfirst($lang);?>',
	baseParams: {pid:'<?=$pid;?>',lang:'<?=$lang;?>'}
}); 
var dxDs = new Ext.data.GroupingStore({
	id: 'dxDs',
	proxy: new Ext.data.HttpProxy({
		url: 'patient/getHistory.php?',
		method: 'POST' 
	}), 
	reader: dxReader,
	remoteSort: true,
	sortInfo: {field: 'vDate', direction: 'DESC'},
	groupField: 'vDate',
	baseParams: {pid:'<?=$pid;?>',lang:'<?=$lang;?>'}
});
var rxDs = new Ext.data.GroupingStore({
	id: 'rxDs',
	proxy: new Ext.data.HttpProxy({
		url: 'patient/getHistory.php',
		method: 'POST'
	}),
	reader: rxReader,
	remoteSort: true,
	sortInfo: {field: 'vDate', direction: 'DESC'},
	groupField: 'vDate',
	baseParams: {pid:'<?=$pid;?>',lang:'<?=$lang;?>'}
});

var labcm = new Ext.grid.ColumnModel([
	{header: 'Labid', dataIndex: 'labid', type: 'string', width: 120, sortable: false,  hidden: true}, 
	{header: 'Section', dataIndex: 'labGroup', type: 'string', width: 120, sortable: false},
	{header: '<?=$labLabels[$lang][1];?>', dataIndex: 'testName<?=ucfirst($lang);?>', type: 'string', width: 120, sortable: false,  hidden: true},
	{header: '<?=$labLabels[$lang][5];?>', dataIndex: 'resultDate', type: 'date', width: 60, sortable: true, renderer: formatDate, editor: new fm.DateField({format: 'd/m/y'})},
	{header: '<?=$labLabels[$lang][6];?>', type: 'bool', renderer: Ext.ux.grid.CheckColumn.prototype.renderer, dataIndex: 'resultAbnormal', width: 40, sortable: false,  hidden: true}, 
	{header: '<?=$labLabels[$lang][2];?>', dataIndex: 'result', type: 'string', width: 60, sortable: false},
	{header: '<?=$labLabels[$lang][3];?>', dataIndex: 'result2', type: 'string', width: 60, sortable: false,  hidden: true},
	{header: '<?=$labLabels[$lang][4];?>', dataIndex: 'result3', type: 'string', width: 60, sortable: false,  hidden: true},
	{header: 'Assession Number', dataIndex: 'assessionNumber', type: 'string', width: 80, sortable: true},
	{header: 'Order Date', dataIndex: 'vDate', type: 'date', width: 80, sortable: true, renderer: formatDate},
	{header: 'Source Lab', dataIndex: 'sendingSiteName', type: 'string', width: 80, sortable: true},
	{header: '<?=$labLabels[$lang][7];?>', dataIndex: 'resultRemarks', type: 'string', width: 120, sortable: false}
]); 
var dxcm = new Ext.grid.ColumnModel([
	{header: '<?=$dxLabels[$lang][0];?>', dataIndex: 'vDate', type: 'date', width: 80, sortable: true, hidden: true},
	{header: 'conditions_id', dataIndex: 'conditions_id', type: 'string', width: 120, sortable: false,  hidden: true},
	{header: '<?=$dxLabels[$lang][1];?>', dataIndex: 'whoStage', type: 'string', width: 80, sortable: false},
	{header: '<?=$dxLabels[$lang][2];?>', dataIndex: 'conditionName<?=ucfirst($lang);?>', type: 'string', width: 120, sortable: false},
	{header: '<?=$dxLabels[$lang][3];?>', dataIndex: 'onsetDate', type: 'date', width: 60, sortable: true},
	{header: '<?=$dxLabels[$lang][4];?>', dataIndex: 'active', type: 'bool', renderer: Ext.ux.grid.CheckColumn.prototype.renderer, width: 30, sortable: false},
	{header: '<?=$dxLabels[$lang][5];?>',dataIndex: 'resolved', type: 'bool', renderer: Ext.ux.grid.CheckColumn.prototype.renderer, width: 30,sortable: false}

]);
var rxcm = new Ext.grid.ColumnModel([
	{header: '<?=$medLabels[$lang][0];?>', dataIndex: 'vDate', type: 'date', width: 100, sortable: true, hidden: true},
	{header: 'DrugID', dataIndex: 'drugID', type: 'string', width: 120, sortable: false,  hidden: true},
	{header: '<?=$medLabels[$lang][1];?>', dataIndex: 'drugGroup', type: 'string', width: 80, sortable: false},
	{header: '<?=$medLabels[$lang][2];?>', dataIndex: 'drugName', type: 'string', width: 100, sortable: false},
	{header: '<?=$medLabels[$lang][3];?>', dataIndex: 'isContinued', type: 'bool', renderer: Ext.ux.grid.CheckColumn.prototype.renderer, width: 40, sortable: false},
	{header: '<?=$medLabels[$lang][4];?>', dataIndex: 'startDate', type: 'date', width: 60, sortable: true},
	{header: '<?=$medLabels[$lang][5];?>', dataIndex: 'stopDate', type: 'date', width: 60, sortable: true},
	{header: '<?=$medLabels[$lang][6];?>', dataIndex: 'toxicity', type: 'bool', renderer: Ext.ux.grid.CheckColumn.prototype.renderer, width: 40, sortable: false},
	{header: '<?=$medLabels[$lang][7];?>', dataIndex: 'intolerance', type: 'bool',renderer: Ext.ux.grid.CheckColumn.prototype.renderer, width: 40, sortable: false},
	{header: '<?=$medLabels[$lang][8];?>', dataIndex: 'failureVir', type: 'bool',renderer: Ext.ux.grid.CheckColumn.prototype.renderer, width: 40, sortable: false},
	{header: '<?=$medLabels[$lang][9];?>', dataIndex: 'failureImm', type: 'bool', renderer: Ext.ux.grid.CheckColumn.prototype.renderer, width: 40, sortable: false},
	{header: '<?=$medLabels[$lang][10];?>', dataIndex: 'failureClin', type: 'bool', renderer: Ext.ux.grid.CheckColumn.prototype.renderer, width: 40, sortable: false},
	{header: '<?=$medLabels[$lang][11];?>', dataIndex: 'stockOut', type: 'bool', renderer: Ext.ux.grid.CheckColumn.prototype.renderer, width: 40, sortable: false},
	{header: '<?=$medLabels[$lang][12];?>', dataIndex: 'pregnancy', type: 'bool', renderer: Ext.ux.grid.CheckColumn.prototype.renderer, width: 40, sortable: false},
	{header: '<?=$medLabels[$lang][13];?>', dataIndex: 'patientHospitalized', type: 'bool', renderer: Ext.ux.grid.CheckColumn.prototype.renderer, width: 40, sortable: false},
	{header: '<?=$medLabels[$lang][14];?>', dataIndex: 'lackMoney', type: 'bool', renderer: Ext.ux.grid.CheckColumn.prototype.renderer, width: 40, sortable: false},
	{header: '<?=$medLabels[$lang][15];?>', dataIndex: 'alternativeTreatments', type: 'bool', renderer: Ext.ux.grid.CheckColumn.prototype.renderer, width: 40, sortable: false},
	{header: '<?=$medLabels[$lang][16];?>', dataIndex: 'missedVisit', type: 'bool', renderer: Ext.ux.grid.CheckColumn.prototype.renderer, width: 40, sortable: false},
	{header: '<?=$medLabels[$lang][17];?>', dataIndex: 'patientPreference', type: 'bool', renderer: Ext.ux.grid.CheckColumn.prototype.renderer, width: 40, sortable: false}
]);

var labGrid = new Ext.grid.GridPanel({
	id: 'labGrid',
	store: labDs,
	cm: labcm,
	containerScroll: true,
	view: new Ext.grid.GroupingView({
		forceFit:true,
//		startCollapsed: true,
		groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "<?=$items[$lang];?>s" : "<?=$items[$lang];?>"]})'
	}),
	autoScroll: true,
	stripeRows: true,
	title: 'Lab',
	height: 350,
	width: 800,
	frame: true
});
var dxGrid = new Ext.grid.GridPanel({
	id: 'dxGrid',
	store: dxDs,
	cm: dxcm,
	view: new Ext.grid.GroupingView({
		forceFit:true,
		startCollapsed: false,
		groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "<?=$items[$lang];?>s" : "<?=$items[$lang];?>"]})'
	}),
	autoScroll: true,
	stripeRows: true,
	selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
	title: 'Diagnoses',
	height: 350,
	width: 800,
	stripeRows: true,
	frame: true
});
var rxGrid = new Ext.grid.GridPanel({
	id: 'rxGrid',
	store: rxDs,
	cm: rxcm,
	view: new Ext.grid.GroupingView({
		forceFit:true, 
		startCollapsed: false,
		groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "<?=$items[$lang];?>s" : "<?=$items[$lang];?>"]})'
	}),
	autoScroll: true,
	stripeRows: true,
	selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
	title: 'Medication',
	height: 350,
	width: 800,
	autoScroll: true,
	frame: true
});

//labDs.load({params: {task: 'lab'}});
dxDs.load({params: {task: 'dx'}});
rxDs.load({params: {task: 'rx'}}); 
