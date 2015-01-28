<?php

require_once 'labels/findLabels.php';

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
	    function formatDatemed(value){
        return value ? value.dateFormat('m/y') : '';
    };
    
    var fm = Ext.form;

		var pid;
	function getPID(val){
	 pid = val;
	 return val;
	}
	
	function gotoPatient(val){
	
	//alert(data);
	return '<a href=\"patienttabs.php?pid='+ pid +'&lang=".$lang."&site=".$site."\">' + val + '</a>';
	
	}
	
	var  dob = new fm.DateField({format: 'd/m/Y',minValue: '01/01/1908',	minValueText: 'this is below the minimum allowed date for this field'   });
	
	function sexChange(val){
	if(val == 'Inconnu'){
		return '<span style=\"color:red;\">' + val + '</span>';
	}
	return val;
	}
	
    var cm = new Ext.grid.ColumnModel([
		{header: \"PatientID\",dataIndex: 'patientID', width: 97,hidden:true, renderer:getPID},
		{header: '".$preARVlabels[$lang][0]."',dataIndex: 'HIVdate', editable:false, width: 130,renderer: formatDate,editor: new fm.DateField({format: 'd/m/Y',minValue: '01/01/1908',	minValueText: 'this is below the minimum allowed date for this field'}) ,editable:false},
		{header: '".$preARVlabels[$lang][1]."', dataIndex: 'natID',width: 100,editor: new fm.TextField({allowBlank: false })},
		{header: '".$preARVlabels[$lang][44]."', dataIndex: 'stID',width: 100,editor: new fm.TextField({allowBlank: false }), renderer:gotoPatient, editable:false},
		{header: '".$preARVlabels[$lang][2]."',	dataIndex: 'lname',	width: 100,	editor: new fm.TextField({allowBlank: true })  },
		{header: '".$preARVlabels[$lang][3]."',dataIndex: 'fname',	width: 100,	editor: new fm.TextField({	allowBlank: false  })},
		{header: '".$preARVlabels[$lang][4]."',dataIndex: 'dob',	width: 110,renderer: formatDate,	editor: new fm.DateField({format: 'd/m/Y', maskRe: /[\XX\xx\d/]/ , validationEvent: false })},
		{header: '".$preARVlabels[$lang][5]."', dataIndex: 'ageYears',  width: 40, align: 'right',editor: new fm.TextField({	allowBlank: false}), editable: false},
        new Ext.grid.CheckColumn({ header: '".$preARVlabels[$lang][6]."', dataIndex: 'under1m', type: 'bool',  width: 60, editable: false}),
        new Ext.grid.CheckColumn({header: '".$preARVlabels[$lang][7]."', dataIndex: '1to2', type: 'bool',  width: 60, editable: false}),        
        new Ext.grid.CheckColumn({header: '".$preARVlabels[$lang][8]."', dataIndex: '2to4', type: 'bool',  width: 60, editable: false}), 
        new Ext.grid.CheckColumn({header: '".$preARVlabels[$lang][9]."', dataIndex: '5to14', type: 'bool',  width: 60, editable: false}), 
		new Ext.grid.CheckColumn({header: '".$preARVlabels[$lang][10]."', dataIndex: 'over15', type: 'bool',  width: 60, editable: false}), 
		{header: '".$preARVlabels[$lang][11]."', dataIndex: 'sex',width: 80,stateGroup : \"group1\", editor: new Ext.form.ComboBox({typeAhead: true,triggerAction: 'all',transform:'sex',lazyRender:true,listClass: 'x-combo-list-small'})},
		{header: '".$preARVlabels[$lang][12]."',	dataIndex: 'pregduedate',editable:false,	width: 130,	  renderer: formatDate,	  editor: new fm.DateField({ format: 'd/m/Y', minValue: '01/01/80' })},
		{header:'".$preARVlabels[$lang][13]."',dataIndex: 'Address',	stateGroup : \"group1\",width: 220,editor: new fm.TextField({allowBlank:true})},
		{header:'".$preARVlabels[$lang][45]."',dataIndex: 'Address2',	stateGroup : \"group1\",width: 220,editor: new fm.TextField({allowBlank:true})},
		{header:'".$preARVlabels[$lang][46]."',dataIndex: 'Address3',	stateGroup : \"group1\",width: 220,editor: new fm.TextField({allowBlank:true})},
		{header: '".$preARVlabels[$lang][14]."',	dataIndex: 'hivposdate',editable:false,	width: 130,	  renderer: formatDate,	  editor:new fm.DateField({	  format: 'd/m/Y',	  minValue: '01/01/1908', minValueText: 'this is below the minimum allowed date for this field'   })},	           
		{header: '".$preARVlabels[$lang][15]."',	dataIndex: 'CTXstart',editable:false,	width: 130,	  renderer: formatDatemed,	  editor: new fm.DateField({	  format: 'm/y',	  minValue: '01/80'  })},	
		{header: '".$preARVlabels[$lang][16]."',dataIndex: 'CTXstop',editable:false,width: 130, renderer: formatDatemed, editor: new fm.DateField({format: 'm/y', minValue: '01/80'  })},
		{header: '".$preARVlabels[$lang][17]."',	dataIndex: 'iodate',editable:false,	width: 130,	  renderer: formatDate,	  editor:new fm.DateField({	  format: 'd/m/Y',	  minValue: '01/01/1908', minValueText: 'this is below the minimum allowed date for this field'   })},	           
		{header: '".$preARVlabels[$lang][18]."',	dataIndex: 'iostart',editable:false,	width: 130,	  renderer: formatDatemed,	  editor: new fm.DateField({	 format: 'm/y',	  minValue: '01/80'})},
		{header: '".$preARVlabels[$lang][19]."',	dataIndex: 'baccdate',editable:false,	width: 130,	  renderer: formatDate,	  editor:new fm.DateField({	  format: 'd/m/Y',	  minValue: '01/01/1908', minValueText: 'this is below the minimum allowed date for this field'   })},	           
		new Ext.grid.CheckColumn({header: '".$preARVlabels[$lang][20]."', dataIndex: 'baccpos', type: 'bool',  width: 50, editable: false}), 
		new Ext.grid.CheckColumn({header: '".$preARVlabels[$lang][21]."', dataIndex: 'baccneg', type: 'bool',  width: 50, editable: false}),
		{header: '".$preARVlabels[$lang][22]."',	dataIndex: 'ppddate',editable:false,	width: 130,	  renderer: formatDate,	  editor:new fm.DateField({	  format: 'd/m/Y',	  minValue: '01/01/1908', minValueText: 'this is below the minimum allowed date for this field'   })},	            
		new Ext.grid.CheckColumn({header: '".$preARVlabels[$lang][23]."', dataIndex: 'ppdpos', type: 'bool',  width: 50, editable: false}), 
		new Ext.grid.CheckColumn({header: '".$preARVlabels[$lang][24]."', dataIndex: 'ppdneg', type: 'bool',  width: 50, editable: false}), 
		{header: '".$preARVlabels[$lang][25]."',	dataIndex: 'INHstart',editable:false,	width: 130,	  renderer: formatDatemed,	  editor: new fm.DateField({	 format: 'm/y',	  minValue: '01/80'})},
		{header: '".$preARVlabels[$lang][26]."',dataIndex: 'INHstop',editable:false,	width: 130,	  renderer: formatDatemed,	  editor: new fm.DateField({	  format: 'm/y',	  minValue: '01/80'   })},		
		{header: '".$preARVlabels[$lang][27]."',	dataIndex: 'TBstart',editable:false,width: 130,  renderer: formatDatemed, editor: new fm.DateField({format: 'm/y', minValue: '01/80' })},
		{header: '".$preARVlabels[$lang][28]."',dataIndex: 'TBstop',editable:false,	width: 130,	  renderer: formatDatemed, editor: new fm.DateField({ format: 'm/y', minValue: '01/80' })},
		{header: '".$preARVlabels[$lang][29]."',dataIndex: 'Flucstart',editable:false,width: 130,  renderer: formatDatemed,  editor: new fm.DateField({ format: 'm/y', minValue: '01/80'})},
		{header: '".$preARVlabels[$lang][30]."',dataIndex: 'Flucstop',editable:false,width: 130,  renderer: formatDatemed,  editor: new fm.DateField({ format: 'm/y', minValue: '01/80' })},
		{header: '".$preARVlabels[$lang][31]."',dataIndex: 'stage1',editable:false,width: 130, renderer: formatDate, editor: new fm.DateField({ format: 'd/m/Y', minValue: '01/01/80' })	},
		{header: '".$preARVlabels[$lang][32]."',dataIndex: 'stage2',editable:false,width: 130, renderer: formatDate,editor: new fm.DateField({ format: 'd/m/Y', minValue: '01/01/80' })},
		{header: '".$preARVlabels[$lang][33]."',dataIndex: 'stage3',editable:false,width: 130,renderer: formatDate, editor: new fm.DateField({format: 'd/m/Y',minValue: '01/01/80'})},
		{header: '".$preARVlabels[$lang][34]."',dataIndex: 'stage4',editable:false,width: 130,  renderer: formatDate,  editor:new fm.DateField({  format: 'd/m/Y',  minValue: '01/01/80'  })},
		{header: '".$preARVlabels[$lang][35]."',dataIndex: 'medEligDate',editable:false,	width: 130,renderer: formatDate, editor: new fm.DateField({format: 'd/m/Y', minValue: '01/01/80' })	},
		{header: '".$preARVlabels[$lang][36]."',dataIndex: 'whyElig',editable:false,width: 130, editor: new fm.TextField({allowBlank: false   })},
		{header: '".$preARVlabels[$lang][37]."',dataIndex: 'commDate',editable:false,width: 130, renderer: formatDate, editor: new fm.DateField({format: 'd/m/Y', minValue: '01/01/60' })},
		{header: '".$preARVlabels[$lang][38]."',dataIndex: 'lastCD4',editable:false,width: 130,editor: new fm.TextField({allowBlank: true })},
		{header: '".$preARVlabels[$lang][39]."',dataIndex: 'death',editable:false,width: 130,renderer: formatDate,editor:new fm.DateField({format: 'd/m/Y',minValue: '01/01/80'})},
		{header: '".$preARVlabels[$lang][40]."',dataIndex: 'lost',editable:false,width: 130, renderer: formatDate, editor: new fm.DateField({ format: 'd/m/Y', minValue: '01/01/80'})},
		{header: '".$preARVlabels[$lang][41]."',dataIndex: 'transfer',editable:false,width: 130,	  renderer: formatDate,editor: new fm.DateField({format: 'd/m/Y', minValue: '01/01/80'})},
		{header: '".$preARVlabels[$lang][42]."',dataIndex: 'ARTstart',editable:false,width: 130,renderer: formatDate,editor: new fm.DateField({ format: 'd/m/Y',minValue: '01/01/60' })},
		{header: '".$preARVlabels[$lang][43]."',dataIndex: 'stageStartART',editable:false,width: 130,editor: new fm.TextField({allowBlank: true })}
		
    ]);

    // by default columns are sortable
    cm.defaultSortable = true;

    // this could be inline
    var Register = Ext.data.Record.create([
    	{name: 'HIVdate', type: 'date', dateFormat: 'd/m/Y'},
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
		   {name: 'ppdpos', type: 'bool'},
		   {name: 'ppdneg', type: 'bool'},
		   {name: 'baccpos', type: 'bool'},
		   {name: 'baccneg', type: 'bool'},
           {name: 'sex'},
           {name: 'Address', type: 'string'},
		   {name: 'Address2', type: 'string'},
		   {name: 'Address3', type: 'string'},
           {name: 'hivposdate', type: 'date', dateFormat: 'd/m/Y'},
		   {name: 'baccdate', type: 'date', dateFormat: 'd/m/Y'},
		   {name: 'ppddate', type: 'date', dateFormat: 'd/m/Y'},
           {name: 'INHstart', type: 'date', dateFormat: 'm/y'},
           {name: 'INHstop', type: 'date', dateFormat: 'm/y'},
           {name: 'CTXstart', type: 'date', dateFormat: 'm/y'},
           {name: 'CTXstop', type: 'date', dateFormat: 'm/y'},
           {name: 'Flucstart', type: 'date', dateFormat: 'm/y'},
           {name: 'Flucstop', type: 'date', dateFormat: 'm/y'},
           {name: 'TBstart', type: 'date', dateFormat: 'm/y'},
           {name: 'TBstop', type: 'date', dateFormat: 'm/y'},
           {name: 'pregduedate', type: 'date', dateFormat: 'd/m/Y'},
           {name: 'death', type: 'date', dateFormat: 'd/m/Y'},
           {name: 'transfer', type: 'date', dateFormat: 'd/m/Y'},
           {name: 'lost', type: 'date', dateFormat: 'd/m/Y'},
           {name: 'stage1', type: 'date', dateFormat: 'd/m/Y'},
           {name: 'stage2', type: 'date', dateFormat: 'd/m/Y'},
           {name: 'stage3', type: 'date', dateFormat: 'd/m/Y'},
           {name: 'stage4', type: 'date', dateFormat: 'd/m/Y'},
           {name: 'medEligDate', type: 'date', dateFormat: 'd/m/Y'},
           {name: 'stageStartART', type: 'date', dateFormat: 'd/m/Y'},
           {name: 'whyElig', type: 'string'},
           {name: 'dateEligReady', type: 'date', dateFormat: 'd/m/Y'},
           {name: 'commDate', type: 'date', dateFormat: 'd/m/Y'},
           {name: 'ARTstart', type: 'date', dateFormat: 'd/m/Y'},
           {name: 'ARTid', type: 'string'},
		   {name: 'lastCD4', type: 'string'} 
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
               {name: 'HIVdate', mapping: 'HIVdate', type: 'date'},
			   {name: 'hivposdate', mapping: 'hivposdate', type: 'date'},
			   {name: 'dob', mapping: 'dob', type: 'date'},
			   {name: 'pregduedate', mapping: 'pregduedate', type: 'date'},
               {name: 'stID', mapping: 'stID', type: 'string'},
			   {name: 'natID', mapping: 'nationalID', type: 'string'},
               {name: 'patientID', mapping: 'patientID', type: 'string'},
               {name: 'lname', mapping: 'lname', type: 'string'},
               {name: 'fname', mapping: 'fname', type: 'string'},
			   {name: 'under1m', mapping: 'under1m', type: 'bool'},
				{name: '1to2', mapping: '1to2', type: 'bool'},
			{name: '2to4', mapping: '2to4', type: 'bool'},
			{name: '5to14', mapping: '5to14', type: 'bool'},
			{name: 'over15', mapping: 'over15', type: 'bool'},
			{name: 'ppddate', mapping: 'ppddate', type: 'date'},
			{name: 'baccdate', mapping: 'baccdate', type: 'date'},
			{name: 'ppdpos', mapping: 'ppdpos',type: 'bool'},
			{name: 'ppdneg', mapping: 'ppdneg',type: 'bool'},
			{name: 'baccpos', mapping: 'baccpos',type: 'bool'},
			{name: 'baccneg', mapping: 'baccneg',type: 'bool'},
               {name: 'sex', mapping: 'sex'},
               {name: 'ageYears', mapping: 'ageYears', type: 'string'}, 
               {name: 'Address', mapping: 'addrDistrict', type: 'string'},
			   {name: 'Address2', mapping: 'addrSection', type: 'string'},
			   {name: 'Address3', mapping: 'addrTown', type: 'string'},
			   {name: 'whyElig', mapping: 'whyElig', type: 'string'},
               {name: 'Flucstart', mapping: 'Flucstart', type: 'date'},
               {name: 'Flucstop', mapping: 'Flucstop', type: 'date'},
               {name: 'INHstart', mapping: 'INHstart', type: 'date'},
               {name: 'INHstop', mapping: 'INHstop', type: 'date'},
               {name: 'CTXstart', mapping: 'CTXstart', type: 'date'},
               {name: 'CTXstop', mapping: 'CTXstop', type: 'date'},
               {name: 'medEligDate', mapping: 'medEligDate', type: 'date'},
               {name: 'stageStartART', mapping: 'stageStartART', type: 'string'},
			{name: 'death',mapping: 'death', type: 'date' },
			{name: 'transfer',mapping: 'transfer', type: 'date'},
			{name: 'lost',mapping: 'lost', type: 'date'},
			   {name: 'stage1', mapping: 'stage1', type: 'date'},
			   {name: 'stage2', mapping: 'stage2', type: 'date'},
               {name: 'stage3', mapping: 'stage3', type: 'date'},
               {name: 'stage4', mapping: 'stage4', type: 'date'},
			{name: 'ARTstart', mapping:'ARTstart',type: 'date'},
			{name: 'commDate', mapping:'commDate',type: 'date'},
			{name: 'lastCD4', mapping: 'lastCD4', type: 'string'}
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
	    var grid = new Ext.grid.EditorGridPanel({ store: ds,cm: cm,layout: 'fit',renderTo:'editor-grid', 
	stripeRows:true,loadMask:true,
loadMask:{msg:'" . $waitMessageLabels[$lang][0] ."'}, 
height:320,title:'".$find_labels['regheader'][$lang]."', clicksToEdit:2,
		region:'center',
		tbar: [
            '".$regGridlabels['search'][$lang].": ', ' ',
           search
        	],
		bbar: [
		'-',
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
			},
		'-',{
            text: '".$regGridlabels['more'][$lang]."',
            handler: nextPat
			}
";
if (getAccessLevel (getSessionUser ()) != 0 && SERVER_ROLE == "production") {
	echo ",
		'-',{
            text: '".$regGridlabels['save'][$lang]."',
            handler: updateDB
        },
		'-',{
			text: '".$regGridlabels['add'][$lang]."',
            handler: openAddEntry
		}
	";
}
	echo "
		]
    });
	
 var addform = new Ext.FormPanel({
                    labelWidth:70,
                    frame:true,
                    url:'patientjson.php?ac=addData&arv=0&site=".$site."',
                    bodyStyle:'padding:5px 5px 0',
                    defaultType:'textfield',
                    defaults: {width: 180},
                    autoWidth:true,
					monitorValid: true,
                    autoHeight:true,
                    items: [
					new fm.DateField({fieldLabel:'".$preARVlabels[$lang][0]."',name: 'HIVdate',width: 130,	format: 'd/m/Y',minValue: '01/01/1908',	minValueText: 'this is below the minimum allowed date for this field', allowBlank:false }), 
					{fieldLabel: '".$preARVlabels[$lang][44]."', name: 'stID', width: 100, allowBlank:false},
					{fieldLabel: '".$preARVlabels[$lang][1]."', name: 'natID', width: 100, allowBlank:false},
					{fieldLabel: '".$preARVlabels[$lang][2]."',name: 'lname',	width: 100,	allowBlank: true},
					{fieldLabel: '".$preARVlabels[$lang][3]."',	name: 'fname',	width: 100,	allowBlank: false },
					new fm.DateField({fieldLabel:'".$preARVlabels[$lang][4]."',name: 'dob',width: 130,format: 'd/m/Y',minValue: '01/01/1908',minValueText: 'this is below the minimum allowed date for this field' , allowBlank:false  }),
					new fm.ComboBox({fieldLabel: '".$preARVlabels[$lang][11]."', forceSelection:true,typeAhead: true,triggerAction: 'all',transform:'sex2',lazyRender:true,listClass: 'x-combo-list-small' }),
					{fieldLabel: '".$preARVlabels[$lang][13]."',	name: 'Address',width: 220,	allowBlank: true },
					new fm.ComboBox({fieldLabel: '".$preARVlabels[$lang][45]."',forceSelection:true,typeAhead: true,triggerAction: 'all',transform:'addrSection',lazyRender:true,listClass: 'x-combo-list-small',name: 'Address2',width: 220 }),
					{fieldLabel: '".$preARVlabels[$lang][46]."',	name: 'Address3',width: 220,	allowBlank: true }
					],
					buttons: [{
	                    text:'Add',
						formBind: true,
						handler: function(){
                            addform.getForm().submit({
								waitMsg: 'Saving changes...',
								url: 'patientjson.php?ac=addData&arv=0&site=".$site."',
                                params: {
								task: \"update\" //pass task to do to the server script
								},
								success: function(rst, req) {
                                    Ext.Msg.alert('Data saved', 'Data is saved');
                                    win.hide();
									search.setRawValue(addform.getComponent(1).getRawValue());
									search.onTrigger2Click();
									addform.form.reset();
                                },
                                failure: function(rst, req) {
                                    Ext.Msg.alert('Failure!', 'Data is NOT saved, Please correct your errors');

                                }
                            });
                        }
	                },{
	                    text: 'Cancel',
	                    handler: function(){
	                       addform.getForm().reset();
						   win.hide();
	                    }
	                }]
					});
	
	
		function openAddEntry(){
	
	        if(!win){
	            win = new Ext.Window({
	                el:'hello-win',
	                layout:'form',
	                width:500,
					height: 'auto',
	                closeAction:'hide',
					defaultType: 'textfield',
	                plain: true,
					items: addform
	            });
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
                    url: 'patientjson.php?ac=saveData&arv=0&site=".$site."', //url to server side script
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
ds.load({params:{start:0, limit:15, pid: 'ST0', site:getSite(), lang:'".$lang."'}});


function getDataSource() {
     return ds;
    } 

});
";
?>
