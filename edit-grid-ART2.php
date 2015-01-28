<?php
echo "
Ext.app.SearchField = Ext.extend(Ext.form.TwinTriggerField, {
    initComponent : function(){
        Ext.app.SearchField.superclass.initComponent.call(this);
        this.on('specialkey', function(f, e){
            if(e.getKey() == e.ENTER){
                this.onTrigger2Click();
            }
        }, this);
    },

    validationEvent:false,
    validateOnBlur:false,
    trigger1Class:'x-form-clear-trigger',
    trigger2Class:'x-form-search-trigger',
    hideTrigger1:true,
    width:180,
    hasSearch : false,
    paramName : 'query',

    onTrigger1Click : function(){
        if(this.hasSearch){
            this.el.dom.value = '';
            var o = {start: 0};
            this.store.baseParams = this.store.baseParams || {};
            this.store.baseParams[this.paramName] = '';
            this.store.reload({params:o});
            this.triggers[0].hide();
            this.hasSearch = false;
        }
    },

    onTrigger2Click : function(){
        var v = this.getRawValue();
        if(v.length < 1){
            this.onTrigger1Click();
            return;
        }
        var o = {start: 0,site:getSite()};
        this.store.baseParams = this.store.baseParams || {};
        this.store.baseParams[this.paramName] = v;
        this.store.reload({params:o});
        this.hasSearch = true;
        this.triggers[0].show();
    }
});

Ext.QuickTips.init();
// turn on validation errors beside the field globally
Ext.form.Field.prototype.msgTarget = 'side';

Ext.onReady(function(){


    var win;

		function copyText(text) {
		if (window.clipboardData) { // Internet Explorer
				window.clipboardData.setData(\"Text\", \"\"+ text);
		} else if (window.netscape) { // Mozilla
				try {
						netscape.security.PrivilegeManager.enablePrivilege('UniversalXPConnect');
						var gClipboardHelper = Components.classes[\"@mozilla.org/widget/clipboardhelper;1\"].getService(Components.interfaces.nsIClipboardHelper);
						gClipboardHelper.copyString(text);
				} catch(e) {
						return alert(e + 'Please type: \"about:config\" in your address bar. Then filter by \"signed\". Change the value of \"signed.applets.codebase_principal_support\" to true. You should then be able to use this feature.');
				}
		} else {
				return alert('Your browser does not support this feature');
		}
	};
	
    function formatBoolean(value){
        return value ? 'Yes' : 'No';  
    };
    
    function formatDate(value){
        return value ? value.dateFormat('d/m/Y') : '';
    }; 
    
    var fm = Ext.form;

	function sexChange(val){
	if(val == 'Inconnu'){
		return '<span style=\"color:red;\">' + val + '</span>';
	}
	return val;
	}
	
	var pid;
	function getPID(val){
	 pid = val;
	 return val;
	}
	
	function gotoPatient(val){
	
	//alert(data);
	return '<a href=\"patienttabs.php?pid='+ pid +'&lang=".$lang."&site=".$site."\">' + val + '</a>';
	
	}
	
	
	
    var cm = new Ext.grid.ColumnModel([
	{ header: \"PatientID\",id:'pid', dataIndex: 'patientID', width: 97, hidden:true, renderer:getPID},
	{ header: '".$ARVlabels[$lang][0]."',dataIndex: 'ARTstart',width: 130, editable: false, renderer: formatDate, editor: new fm.DateField({ format: 'd/m/Y', minValue: '01/01/60'})},
	{header: '".$ARVlabels[$lang][1]."', dataIndex: 'natID',width: 100,editor: new fm.TextField({allowBlank: false })},
	{ header: '".$ARVlabels[$lang][37]."',dataIndex: 'stID',	width: 100,	editor: new fm.TextField({	allowBlank: false}), renderer:gotoPatient, editable:false},
	{ header: '".$ARVlabels[$lang][2]."',dataIndex: 'whyElig',	width: 130, editable: false,  editor: new fm.TextField({	allowBlank: false })},
	{ header: '".$ARVlabels[$lang][3]."',dataIndex: 'lname',	width: 100,	editor: new fm.TextField({	allowBlank: true }) },
	{ header: '".$ARVlabels[$lang][4]."',dataIndex: 'fname',	width: 100,	editor: new fm.TextField({	allowBlank: false }) },
	{ header: '".$ARVlabels[$lang][5]."',dataIndex: 'dob',	width: 130,	renderer: formatDate, stateGroup : \"group1\", editor: new fm.DateField({	format: 'd/m/Y',minValue: '01/01/1908',	minValueText: 'this is below the minimum allowed date for this field'}) },
	{ header: '".$ARVlabels[$lang][6]."', dataIndex: 'ageYears', width: 90, align: 'right',editor: new fm.TextField({allowBlank: false }), editable:false },
	new Ext.grid.CheckColumn({ header: '".$ARVlabels[$lang][7]."', dataIndex: 'under1m', type: 'bool',  width: 60, editable: false}),
    new Ext.grid.CheckColumn({header: '".$ARVlabels[$lang][8]."', dataIndex: '1to2', type: 'bool',  width: 60, editable: false}),        
    new Ext.grid.CheckColumn({header: '".$ARVlabels[$lang][9]."', dataIndex: '2to4', type: 'bool',  width: 60, editable: false}), 
    new Ext.grid.CheckColumn({header: '".$ARVlabels[$lang][10]."', dataIndex: '5to14', type: 'bool',  width: 60, editable: false}), 
	new Ext.grid.CheckColumn({header: '".$ARVlabels[$lang][11]."', dataIndex: 'over15', type: 'bool',  width: 60, editable: false}), 
	{ header: '".$ARVlabels[$lang][12]."',dataIndex: 'sex',width: 80,	stateGroup : \"group1\",  editor: new Ext.form.ComboBox({typeAhead: true,triggerAction: 'all',transform:'sex',lazyRender:true,listClass: 'x-combo-list-small'}),renderer:sexChange},
	{ header: '".$ARVlabels[$lang][13]."',dataIndex: 'pregduedate', editable: false,width: 130, renderer: formatDate, editor:new fm.DateField({ format: 'd/m/Y', minValue: '01/01/1908',  minValueText: 'this is below the minimum allowed date for this field'})	},
	{ header: '".$ARVlabels[$lang][14]."',dataIndex: 'Address',stateGroup : \"group1\",width: 220,editor: new fm.TextField({allowBlank: false})	},
	{ header: '".$ARVlabels[$lang][69]."',dataIndex: 'Address2',width: 220, editor: new Ext.form.ComboBox({typeAhead: true,triggerAction: 'all',transform:'addrSection',lazyRender:true,listClass: 'x-combo-list-small'})	},
	{ header: '".$ARVlabels[$lang][70]."',dataIndex: 'Address3',stateGroup : \"group1\",width: 220,editor: new fm.TextField({allowBlank: false})	},
	{ header: '".$ARVlabels[$lang][15]."',	dataIndex: 'statAtstart',editable: false,	width: 100,	editor: new fm.TextField({	allowBlank: true }) },
	{ header: '".$ARVlabels[$lang][16]."',	dataIndex: 'weightAtstart',editable: false,	width: 100,	editor: new fm.TextField({	allowBlank: true }) },
	{ header: '".$ARVlabels[$lang][17]."',	dataIndex: 'heightAtstart',editable: false,	width: 100,	editor: new fm.TextField({	allowBlank: true }) },
	{ header: '".$ARVlabels[$lang][18]."',	dataIndex: 'stageStartART',editable: false,	width: 100,	editor: new fm.TextField({	allowBlank: true }) },
	{ header: '".$ARVlabels[$lang][19]."',	dataIndex: 'lastCD4',editable: false,	width: 100,	editor: new fm.TextField({	allowBlank: true }) },
	{ header: '".$ARVlabels[$lang][20]."',dataIndex: 'INHstart',editable: false,width: 130,  renderer: formatDate,  editor: new fm.DateField({ format: 'd/m/Y',  minValue: '01/1908'  })},
	{ header: '".$ARVlabels[$lang][21]."',dataIndex: 'INHstop',editable: false,width: 130,  renderer: formatDate,  editor: new fm.DateField({  format: 'd/m/Y',  minValue: '01/01/1908' })},
	{ header: '".$ARVlabels[$lang][22]."',dataIndex: 'CTXstart',editable: false,	width: 130,  renderer: formatDate,  editor: new fm.DateField({  format: 'd/m/Y',  minValue: '01/01/1908' })	},
	{ header: '".$ARVlabels[$lang][23]."',dataIndex: 'CTXstop',editable: false,	width: 130,	  renderer: formatDate,	  editor: new fm.DateField({format: 'd/m/Y',  minValue: '01/01/1908'   })	},
	{ header: '".$ARVlabels[$lang][24]."',	dataIndex: 'TBstart',editable: false,	width: 130,	  renderer: formatDate,	  editor: new fm.DateField({format: 'd/m/Y', minValue: '01/01/80' })	},
	{ header: '".$ARVlabels[$lang][25]."',	dataIndex: 'TBstop',editable: false,	width: 130,	  renderer: formatDate,	  editor: new fm.DateField({format: 'd/m/Y', minValue: '01/01/80' })},
	{header: '".$ARVlabels[$lang][26]."',	dataIndex: 'iodate',editable: false,	width: 130,	  renderer: formatDate,	  editor:new fm.DateField({	  format: 'd/m/Y',	  minValue: '01/01/1908', minValueText: 'this is below the minimum allowed date for this field'   })},	              
	{ header: '".$ARVlabels[$lang][27]."', id:'1reg1',	dataIndex: '1reg1',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][28]."',	dataIndex: '1reg2',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{header: '".$ARVlabels[$lang][29]."',	dataIndex: '1reg2date',	width: 130,	  renderer: formatDate,	  editor:new fm.DateField({	  format: 'd/m/Y',	  minValue: '01/01/1908', minValueText: 'this is below the minimum allowed date for this field'   }), editable:false},	             
	{ header: '".$ARVlabels[$lang][30]."',	dataIndex: '1reg3',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{header: '".$ARVlabels[$lang][31]."',	dataIndex: '1reg3date',	width: 130,	  renderer: formatDate,	  editor:new fm.DateField({	  format: 'd/m/Y',	  minValue: '01/01/1908', minValueText: 'this is below the minimum allowed date for this field'   }), editable:false},	             
	{ header: '".$ARVlabels[$lang][32]."',	dataIndex: '2reg1',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][33]."',	dataIndex: '2reg2',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{header: '".$ARVlabels[$lang][34]."',	dataIndex: '2reg2date',	width: 130,	  renderer: formatDate,	  editor:new fm.DateField({	  format: 'd/m/Y',	  minValue: '01/01/1908', minValueText: 'this is below the minimum allowed date for this field'   }), editable:false},	             
	{ header: '".$ARVlabels[$lang][35]."',	dataIndex: '2reg3',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{header: '".$ARVlabels[$lang][36]."',	dataIndex: '2reg3date',	width: 130,	  renderer: formatDate,	  editor:new fm.DateField({	  format: 'd/m/Y',	  minValue: '01/01/1908', minValueText: 'this is below the minimum allowed date for this field'   }), editable:false},	             
	{ header: '".$ARVlabels[$lang][38]."',	dataIndex: 'reg0',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][39]."',	dataIndex: 'reg1',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][40]."',	dataIndex: 'reg2',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][41]."',	dataIndex: 'reg3',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][42]."',	dataIndex: 'reg4',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][43]."',	dataIndex: 'reg5',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][44]."',	dataIndex: 'func6',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][45]."',	dataIndex: 'reg6',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][46]."',	dataIndex: 'cd46',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][47]."',	dataIndex: 'reg7',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][48]."',	dataIndex: 'reg8',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][49]."',	dataIndex: 'reg9',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][50]."',	dataIndex: 'reg10',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][51]."',	dataIndex: 'reg11',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][52]."',	dataIndex: 'func12',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false},	
	{ header: '".$ARVlabels[$lang][53]."',	dataIndex: 'reg12',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][54]."',	dataIndex: 'cd412',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][55]."',	dataIndex: 'reg13',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][56]."',	dataIndex: 'reg14',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },	
	{ header: '".$ARVlabels[$lang][57]."',	dataIndex: 'reg15',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][58]."',	dataIndex: 'reg16',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][59]."',	dataIndex: 'reg17',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][60]."',	dataIndex: 'reg18',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][61]."',	dataIndex: 'reg19',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][62]."',	dataIndex: 'reg20',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][63]."',	dataIndex: 'reg21',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][64]."',	dataIndex: 'reg22',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][65]."',	dataIndex: 'reg23',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][66]."',	dataIndex: 'func24',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][67]."',	dataIndex: 'reg24',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false },
	{ header: '".$ARVlabels[$lang][68]."',	dataIndex: 'cd424',	width: 100,	editor: new fm.TextField({	allowBlank: true }), editable:false }

	]);

    // by default columns are sortable
    cm.defaultSortable = true;

    // this could be inline
    var Register = Ext.data.Record.create([

    	{name: 'ARTstart', type: 'date', dateFormat: 'd/m/Y'},
           {name: 'stID', type: 'string'},
		   {name: 'natID', type: 'string'},
           {name: 'patientID', type: 'string'},
           {name: 'lname', type: 'string'},
           {name: 'fname', type: 'string'},
           {name: 'ageYears', type:'string'},
		   {name: 'under1m', type: 'bool'},
		   {name: '1to2', type: 'bool'},
		   {name: '2to4', type: 'bool'},
		   {name: '5to14', type: 'bool'},
		   {name: 'over15', type: 'bool'},
           {name: 'sex'},
		   {name: 'dob', type: 'date', dateFormat: 'd/m/Y'},
		   {name: 'pregduedate', type: 'date', dateFormat: 'd/m/Y'},
           {name: 'Address', type: 'string'},
		   {name: 'Address2'},
		   {name: 'Address3', type: 'string'},
		   {name: 'statAtstart', type: 'string'},
		   {name: 'weightAtstart', type: 'string'},
		   {name: 'heightAtstart', type: 'string'},
		   {name: 'lastCD4', type: 'string'},
           {name: 'INHstart', type: 'date', dateFormat: 'd/m/Y'},
           {name: 'INHstop', type: 'date', dateFormat: 'd/m/Y'},
           {name: 'CTXstart', type: 'date', dateFormat: 'd/m/Y'},
           {name: 'CTXstop', type: 'date', dateFormat: 'd/m/Y'},
           {name: 'Flucstart', type: 'date', dateFormat: 'd/m/Y'},
           {name: 'Flucstop', type: 'date', dateFormat: 'd/m/Y'},
           {name: 'TBstart', type: 'date', dateFormat: 'd/m/Y'},
           {name: 'TBstop', type: 'date', dateFormat: 'd/m/Y'},
           {name: 'medEligDate', type: 'date', dateFormat: 'd/m/Y'},
           {name: 'stageStartART', type: 'date', dateFormat: 'd/m/Y'},
           {name: 'whyElig', type: 'string'},
		   {name: 'cd46', type: 'string'},
		   {name: 'cd412', type: 'string'},
		   {name: 'cd424', type: 'string'},
		   {name: 'func6', type: 'string'},
		   {name: 'func12', type: 'string'},
		   {name: 'func24', type: 'string'},
		   {name: 'reg0', type: 'string'},
		   {name: 'reg1', type: 'string'},
		   {name: 'reg2', type: 'string'},
		   {name: 'reg3', type: 'string'},
		   {name: 'reg4', type: 'string'},
		   {name: 'reg5', type: 'string'},
		   {name: 'reg6', type: 'string'},
		   {name: 'reg7', type: 'string'},
		   {name: 'reg8', type: 'string'},
		   {name: 'reg9', type: 'string'},
		   {name: 'reg10', type: 'string'},
		   {name: 'reg11', type: 'string'},
		   {name: 'reg12', type: 'string'},
		   {name: 'reg13', type: 'string'},
		   {name: 'reg14', type: 'string'},
		   {name: 'reg15', type: 'string'},
		   {name: 'reg16', type: 'string'},
		   {name: 'reg17', type: 'string'},
		   {name: 'reg18', type: 'string'},
		   {name: 'reg19', type: 'string'},
		   {name: 'reg20', type: 'string'},
		   {name: 'reg21', type: 'string'},
		   {name: 'reg22', type: 'string'},
		   {name: 'reg23', type: 'string'},
		   {name: 'reg24', type: 'string'},
		   {name: '1reg1',type: 'string'},
			{name: '2reg1', type: 'string'},
			{name: '2reg2', type: 'string'},
			{name: '2reg2date', type: 'date'},
			{name: '2reg3', type: 'string'},
			{name: '2reg3date', type: 'date'},
			{name: '1reg2', type: 'string'},
			{name: '1reg2date', type: 'date'},
			{name: '1reg3', type: 'string'},
			{name: '1reg3date', type: 'date'}
           
      ]);

    // create the Data Store
   var ds = new Ext.data.Store({
    
           proxy: new Ext.data.ScriptTagProxy({
               url: 'patientjson.php'
           }),
    
           reader: new Ext.data.JsonReader({
               root: 'results',
               totalProperty: 'total',
               id: 'id'
           }, [
               {name: 'ARTstart', mapping: 'ARTstart', type: 'date'},
               {name: 'stID', mapping: 'stID', type: 'string'},
			   {name: 'natID', mapping: 'nationalID', type: 'string'},
               {name: 'patientID', mapping: 'patientID', type: 'string'},
               {name: 'lname', mapping: 'lname', type: 'string'},
               {name: 'fname', mapping: 'fname', type: 'string'},
               {name: 'ageYears', mapping: 'ageYears', type: 'string'}, 
			   {name: 'under1m', mapping: 'under1m', type: 'bool'},
			{name: '1to2', mapping: '1to2', type: 'bool'},
			{name: '2to4', mapping: '2to4', type: 'bool'},
			{name: '5to14', mapping: '5to14', type: 'bool'},
			{name: 'over15', mapping: 'over15', type: 'bool'},
			{name: 'sex', mapping: 'sex'},
			{name: 'dob', mapping: 'dob', type: 'date'},
			{name: 'pregduedate', mapping:'pregduedate', type: 'date'},
			{name: 'Address', mapping: 'addrDistrict', type: 'string'},
			{name: 'Address2', mapping: 'addrSection'},
			{name: 'Address3', mapping: 'addrTown', type: 'string'},
			{name: 'statAtstart',mapping: 'statAtstart', type: 'string'},
			{name: 'weightAtstart',mapping: 'weightAtstart', type: 'string'},
		    {name: 'heightAtstart',mapping: 'heightAtstart', type: 'string'},
            {name: 'INHstart', mapping: 'INHstart', type: 'date'},
            {name: 'INHstop', mapping: 'INHstop', type: 'date'},
            {name: 'CTXstart', mapping: 'CTXstart', type: 'date'},
             {name: 'CTXstop', mapping: 'CTXstop', type: 'date'},
             {name: 'medEligDate', mapping: 'medEligDate', type: 'date'},
			   {name: 'whyElig', mapping: 'whyElig', type: 'string'},
               {name: 'stageStartART', mapping: 'stageStartART', type: 'string'},
			{name: 'lastCD4', mapping: 'lastCD4', type: 'string'},
			{name: 'cd46', mapping: 'cd46', type: 'string'},
			{name: 'cd412',mapping: 'cd412', type: 'string'},
			{name: 'cd424',mapping: 'cd424', type: 'string'},
			{name: 'func6',mapping: 'func6', type: 'string'},
			{name: 'func12',mapping: 'func12', type: 'string'},
			{name: 'func24',mapping: 'func24', type: 'string'},
			{name: 'reg0', mapping: 'reg0',type: 'string'},
			{name: 'reg1',mapping: 'reg1', type: 'string'},
			{name: 'reg2', mapping: 'reg2',type: 'string'},
			{name: 'reg3', mapping: 'reg3',type: 'string'},
			{name: 'reg4',mapping: 'reg4', type: 'string'},
			{name: 'reg5', mapping: 'reg5',type: 'string'},
			{name: 'reg6', mapping: 'reg6',type: 'string'},
			{name: 'reg7',mapping: 'reg7', type: 'string'},
			{name: 'reg8', mapping: 'reg8',type: 'string'},
			{name: 'reg9', mapping: 'reg9',type: 'string'},
			{name: 'reg10',mapping: 'reg10', type: 'string'},
			{name: 'reg11', mapping: 'reg11',type: 'string'},
			{name: 'reg12', mapping: 'reg12',type: 'string'},
			{name: 'reg13',mapping: 'reg13', type: 'string'},
			{name: 'reg14', mapping: 'reg14',type: 'string'},
			{name: 'reg15', mapping: 'reg15',type: 'string'},
			{name: 'reg16',mapping: 'reg16', type: 'string'},
			{name: 'reg17', mapping: 'reg17',type: 'string'},
			{name: 'reg18', mapping: 'reg18',type: 'string'},
			{name: 'reg19',mapping: 'reg19', type: 'string'},
			{name: 'reg20', mapping: 'reg20',type: 'string'},
			{name: 'reg21', mapping: 'reg21',type: 'string'},
			{name: 'reg22', mapping: 'reg22',type: 'string'},
			{name: 'reg23',mapping: 'reg23', type: 'string'},
			{name: 'reg24', mapping: 'reg24',type: 'string'},
			{name: '1reg1', mapping: '1reg1',type: 'string'},
			{name: '2reg1',mapping: '2reg1', type: 'string'},
			{name: '2reg2',mapping: '2reg2', type: 'string'},
			{name: '2reg2date',mapping: '2reg2date', type: 'date'},
			{name: '2reg3',mapping: '2reg3', type: 'string'},
			{name: '2reg3date',mapping: '2reg3date', type: 'date'},
			{name: '1reg2',mapping: '1reg2', type: 'string'},
			{name: '1reg2date',mapping: '1reg2date', type: 'date'},
			{name: '1reg3',mapping: '1reg3', type: 'string'},
			{name: '1reg3date',mapping: '1reg3date', type: 'date'}
           ])
    
    });

	var search =  new Ext.app.SearchField({
				store: ds,
                width:320
            });
    
		function nextPat(){
		var id = ds.getAt(9).get('stID');
		search.setRawValue(id);
		search.onTrigger2Click();
	}
	
    // create the editor grid
    var grid = new Ext.grid.EditorGridPanel({layout:'fit',store: ds, cm: cm,renderTo: 
'editor-grid',stripeRows:true,loadMask:true,loadMask:{msg:'" . $waitMessageLabels[$lang][0] ."'},header: 
false,height:320,autoWidth:true,title:'".$find_labels['regheader2'][$lang]."',frame:true,clicksToEdit:2,
		tbar: ['".$regGridlabels['search'][$lang].": ', ' ',search],
		bbar: ['-',
			{text: '<font size=1px>" . $splashLabels_r[$lang]["toClip"] . "</font>', handler: function (){
					var gridData = '';
					for (j = 0; j < cm.getColumnCount(); j++) {
						if (gridData != '') gridData += ', ';
						gridData += cm.getColumnHeader(j)
					}
					gridData += '\\n';
					for (i=0; i < ds.getCount(); i++) {
						record = ds.getAt(i);
						flag = false;
						for (j = 0; j < cm.getColumnCount(); j++) {
							if (flag) gridData += ', ';
							flag = true;
							gridData += record.get(cm.getDataIndex(j));
						}
						gridData += '\\n';
				     }
					 mainForm.regcsv.value = gridData;
					 mainForm.submit();
					 copyText(gridData);
				}
			},'-',
			{ text: '".$regGridlabels['more'][$lang]."',handler: nextPat}
			";
if (getAccessLevel (getSessionUser ()) != 0 && SERVER_ROLE == "production") {
			echo ",'-',
			{ text: '".$regGridlabels['save'][$lang]."', handler: updateDB}
			"; 
}
			echo "
			]
    });

	
 var addform = new Ext.FormPanel({
					labelWidth:70,
                    frame:true,
                    url:'patientjson.php?ac=addData&arv=1',
                    bodyStyle:'padding:5px 5px 0',
                    defaultType:'textfield',
                    defaults: {width: 180},
                    autoWidth:true,
					monitorValid: true,
                    autoHeight:true,
                    items: [{fieldLabel: '".$ARVlabels[$lang][1]."',name: 'stID',width: 100,allowBlank:false}],

					buttons: [{ text:'Add', formBind: true,
							handler: function(){
		                            addform.getForm().submit({
										waitMsg: 'Saving changes...',
										url: 'patientjson.php?ac=addData&arv=1',
		                                params: {
										task: \"update\" //pass task to do to the server script
										},
										success: function(rst, req) {
		                                    Ext.Msg.alert('Data saved', 'Data is saved');
		                                    win.hide();
											search.setRawValue(addform.getComponent(0).getRawValue());
											search.onTrigger2Click();
											addform.form.reset();
		                                },
		                                failure: function(rst, req) {
		                                    Ext.Msg.alert('Failure!', 'Data is NOT saved, Please correct your errors');

		                                }
		                            });
		                        }
			                },{ text: 'Cancel',
			                    handler: function(){
			                       addform.getForm().reset();
								   win.hide();
			                    }
					}]
					});
	
	
		function openAddEntry(){
	        if(!win){
	            win = new Ext.Window({ el:'hello-win',  layout:'form', width:500,height: 'auto',closeAction:'hide',defaultType: 'textfield',plain: true, items: addform });
				}
	        win.show(this);
			};

		function updateDB(oGrid_Event) {
		jsonData = \"[\";
                for (i=0; i<ds.getCount(); i++) {
		              record = ds.getAt(i);
		              if (record.data.newRecord || record.dirty) {
		                if (jsonData != \"[\")
		                  jsonData += \",\";
		                jsonData += Ext.util.JSON.encode(record.data);
		              }
            }   
                        jsonData = jsonData.substring(0,jsonData.length-1) + \" }]\";		 	
            //submit to server
            Ext.Ajax.request( 
                {   
                    waitMsg: 'Saving changes...',
                    url: 'patientjson.php?ac=saveData&arv=1&site=".$site."', //url to server side script
                    //method: 'POST', //if specify params default is 'POST' instead of 'GET'
                    params: {
                        task: \"update\", //pass task to do to the server script
						data:jsonData						
                    },
                    failure:function(response,options){
                        Ext.MessageBox.alert('Warning','Oops...');
                        //ds.rejectChanges();//undo any changes
                    },                                  
                    success:function(response,options){
                        //Ext.MessageBox.alert('Success','Yeah...');
                           var responseData = Ext.util.JSON.decode(response.responseText);//passed back from server
                           ds.commitChanges();//commit changes (removes the red triangle which indicates a 'dirty' field)
                           ds.load({params: {site: ".$site."}});
						   Ext.MessageBox.alert(\"Done\", \"Data saved\");
                        } 
                    }                                 
            );
        }; 
   	
// trigger the data store load
ds.load({params:{start:0, limit:2, pid: 'ST00001', site:getSite(),arv:1}});

function getDataSource() {
     return ds;
    } 

});
";
?>
