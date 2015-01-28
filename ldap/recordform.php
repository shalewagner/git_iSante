/**
 * Ext.ux.grid.RecordForm Plugin Example Application
 *
 * @author    Ing. Jozef Sakáloš
 * @copyright (c) 2008, by Ing. Jozef Sakáloš
 * @date      31. March 2008
 * @version   $Id: recordform.js 113 2009-02-02 02:27:23Z jozo $

 * @license recordform.js is licensed under the terms of
 * the Open Source LGPL 3.0 license.  Commercial use is permitted to the extent
 * that the code/component(s) do NOT become part of another Open Source or Commercially
 * licensed development library or toolkit without explicit permission.
 * 
 * License details: http://www.gnu.org/licenses/lgpl.html
 */
var fm = Ext.form;
var gd = Ext.grid;
Ext.ns('Example');
Ext.state.Manager.setProvider(new Ext.state.CookieProvider);
Example.version = 'Beta 2'
function uiFormat(value) {
	if (value == '-') return 'Not yet defined';
	if (value == '0') return '<?=$access_labels['ui'][$lang][0];?>';
	if (value == '1') return '<?=$access_labels['ui'][$lang][1];?>';
	if (value == '2') return '<?=$access_labels['ui'][$lang][0];?>';
	if (value == '3') return '<?=$access_labels['ui'][$lang][1];?>';
};
function privLevel(value) {
	if (value == '-') return 'Not yet defined';  
	if (value == '0') return '<?=$access_labels['privLabels'][$lang][1];?>';
	if (value == '1') return '<?=$access_labels['privLabels'][$lang][2];?>';
	if (value == '2') return '<?=$access_labels['privLabels'][$lang][3];?>';
	if (value == '3') return '<?=$access_labels['privLabels'][$lang][4];?>';
};

Example.Grid1 = Ext.extend(Ext.grid.EditorGridPanel, {
	 layout:'fit'
	,border:false
	,stateful:false
	,url:'process-request.php'
	,objName:'company'
	,idName:'compID'
	,initComponent:function() {
		this.recordForm = new Ext.ux.grid.RecordForm({
			 title:'Make Changes Here'
			,iconCls:'original-icon-edit-record'
			,columnCount:1
			,ignoreFields:{compID:true,sitecode:true,lastLogin:true}
			,readonlyFields:{action1:true}
			,disabledFields:{qtip1:true}
			,formConfig:{
				 labelWidth:80
				,buttonAlign:'right'
				,bodyStyle:'padding-top:10px'
			}
		});
		// create row actions
		this.rowActions = new Ext.ux.grid.RowActions({
			 actions:[{
				 iconCls:'original-icon-minus'
				,qtip:'<?=$access_labels['ldap'][$lang];?>'
			},{
				 iconCls:'original-icon-edit-record'
				,qtip:'<?=addslashes($access_labels['privilege'][$lang]);?>'
			},{
				 iconCls:'original-icon-cross'
				,qtip:'<?=$access_labels['delete'][$lang];?>'
			}]
			,widthIntercept:Ext.isSafari ? 4 : 2
			,id:'actions'
		});
		this.rowActions.on('action', this.onRowAction, this);
		
		Ext.apply(this, {
			store:new Ext.data.Store({
				reader:new Ext.data.JsonReader({
					 id:'compID'
					,totalProperty:'totalCount'
					,root:'rows'
					,fields:[
						 {name:'compID', type:'int'}
						,{name: 'institution', type: 'string'}
						,{name: 'sitecode', type: 'string'}
						,{name: 'username', type: 'string'}
						,{name: 'fn', type: 'string'}
						,{name: 'ln', type: 'string'}
						,{name: 'phone', type: 'string'}
						,{name: 'privLevel', type: 'string'}
						,{name: 'debugFlag', type: 'bool'}
						,{name: 'uiConfiguration', type: 'string'}
//						,{name: 'lastLogin', type:'date', dateFormat:'Y-m-d'}
					]
				})
				,proxy:new Ext.data.HttpProxy({url:this.url})
				,baseParams:{cmd:'getDatax', objName:this.objName}
				,sortInfo:{field:'institution', direction:'ASC'}
				,remoteSort:true
				,listeners:{
					load:{scope:this, fn:function(store) {
						// keep modified records across paging
						var modified = store.getModifiedRecords();
						for(var i = 0; i < modified.length; i++) {
							var r = store.getById(modified[i].id);
							if(r) {
								var changes = modified[i].getChanges();
								for(p in changes) {
									if(changes.hasOwnProperty(p)) {
										r.set(p, changes[p]);
									}
								}
							}
						}
					}}
				}
			})
			,columns:[
				 {header: '<?=$access_labels['username'][$lang];?>', dataIndex: 'username', type: 'string',  width: 100, fixed: true, sortable: true, hideable: false}
				,{header: '<b><?=$access_labels['column1'][$lang] . $access_labels['column2'][$lang];?></b>', dataIndex: 'institution', type: 'string', width: 175, sortable: true, fixed: true, hideable: false}
				,{header: '<b><?=$access_labels['siteCode'][$lang];?></b>', dataIndex: 'sitecode', type: 'string',  width: 100, sortable: true, fixed: true, hideable: true, hidden: true}
				,{header: '<?=$access_labels['firstname'][$lang];?>', dataIndex: 'fn', type: 'string',  width: 100, fixed: true, sortable: true, hideable: false}
				,{header: '<?=$access_labels['lastname'][$lang];?>', dataIndex: 'ln', type: 'string',  width: 100, fixed: true, sortable: true, hideable: false}
				,{header: '<?=$access_labels['phone'][$lang];?>', dataIndex: 'phone', type: 'string',  width: 100, fixed: true, sortable: true, hideable: false}
				,{header: '<?=$access_labels['privLevel'][$lang];?>', dataIndex: 'privLevel', type: 'string',  width: 150, sortable: true, fixed: true, hideable: false
					,editor:new Ext.form.ComboBox({
						store:new Ext.data.SimpleStore({
							id:0
							,fields:['privIndex','privLevel']
							,data:[
								 ['0','<?=html_entity_decode($access_labels['privLabels'][$lang][1], ENT_QUOTES, CHARSET);?>']
								,['1','<?=html_entity_decode($access_labels['privLabels'][$lang][2], ENT_QUOTES, CHARSET);?>']
								,['2','<?=html_entity_decode($access_labels['privLabels'][$lang][3], ENT_QUOTES, CHARSET);?>']
								,['3','<?=html_entity_decode($access_labels['privLabels'][$lang][4], ENT_QUOTES, CHARSET);?>']
							]
						})
						,displayField:'privLevel'
						,valueField:'privIndex'
						,triggerAction:'all'
						,mode:'local'
						,editable:false
						,lazyRender:true
						,forceSelection:true
					})
					, renderer: privLevel}
				,{header: '<?=$access_labels['debug'][$lang];?>', type: 'boolean', renderer: Ext.ux.grid.CheckColumn.prototype.renderer, dataIndex: 'debugFlag', editable: false, width: 80, sortable: true, fixed: true} 
				,{header:'<?=addslashes($access_labels['uiConfig'][$lang]);?>',dataIndex:'uiConfiguration',type: 'string',width:75,sortable:true
					,editor:new Ext.form.ComboBox({
						store:new Ext.data.SimpleStore({
							id:0
							,fields:['uiIndex','uiConf']
							,data:[
								 ['0','<?=html_entity_decode($access_labels['ui'][$lang][0], ENT_QUOTES, CHARSET);?>']
								,['1','<?=html_entity_decode($access_labels['ui'][$lang][1], ENT_QUOTES, CHARSET);?>']
								,['2','<?=html_entity_decode($access_labels['ui'][$lang][0], ENT_QUOTES, CHARSET);?>']
								,['3','<?=html_entity_decode($access_labels['ui'][$lang][1], ENT_QUOTES, CHARSET);?>']
							]
						})
						,displayField:'uiConf'
						,valueField:'uiIndex'
						,triggerAction:'all'
						,mode:'local'
						,editable:false
						,lazyRender:true
						,forceSelection:true
					 })
					,renderer: uiFormat}
//				,{header:'<?=$access_labels['lastlogin'][$lang];?>',dataIndex:'lastLogin',width:60,sortable:true
//					,editor:new Ext.ux.form.DateTime({
//						timePosition:'below'
//					})
//					,renderer:Ext.util.Format.dateRenderer('Y-m-d')}
				,this.rowActions
			]
			,plugins:[
				new Ext.ux.grid.Search({
					iconCls:'original-icon-zoom'
					,searchText: '<?=html_entity_decode($access_labels['search'][$lang], ENT_QUOTES, CHARSET);?>'
					,selectAllText: '<?=html_entity_decode($access_labels['selectall'][$lang] , ENT_QUOTES, CHARSET);?>'
					,position: top
					,minChars: 2
					,mode: 'remote'
					,checkIndexes:['username','fn','ln']
					,disableIndexes:['phone','sitecode','privLevel','uiConfiguration','institution','debugFlag','lastLogin']
				})
				,this.rowActions
				,this.recordForm
			]
			,viewConfig:{forceFit:true}
			,tbar:[{
				 text:'<?=$access_labels['adduser'][$lang];?>'
				,tooltip:'Add user via form'
				,iconCls:'original-icon-form-add'
				,handler:function() {
					window.location.href = 'ldap/new.php?id=newUser&site=<?=$_GET['site'] . "&lang=$lang&lastPid=" . $_GET['lastPid'];?>';
				}
			}]
		}); // eo apply

		this.bbar = new Ext.PagingToolbar({
			 store:this.store
			,displayInfo:false
			,pageSize:500
			,hidden: true
		});
				
		// call parent
		Example.Grid1.superclass.initComponent.apply(this, arguments);
	} // eo function initComponent
	,onRender:function() {
		// call parent
		Example.Grid1.superclass.onRender.apply(this, arguments);
		// load store
		this.store.load({params:{start:0,limit:10}});
	} // eo function onRender
	,addRecord:function() {
		var store = this.store;
		if(store.recordType) {
			var rec = new store.recordType({newRecord:true});
			rec.fields.each(function(f) {
				rec.data[f.name] = f.defaultValue || null;
			});
			rec.commit();
			store.add(rec);
			return rec;
		}
		return false;
	} // eo function addRecord
	,onRowAction:function(grid, record, action, row, col) {
		switch(action) {
			case 'original-icon-edit-record':
				window.location.href = 'setPrivs.php?selUser=' + record.get('username') + '&site=<?=$_GET['site'] . "&lang=$lang&lastPid=" . $_GET['lastPid'];?>';
			break;
			case 'original-icon-minus':
				window.location.href = 'ldap/edit.php?id=' + record.get('username') + '&site=<?=$_GET['site'] . "&lang=$lang&lastPid=" . $_GET['lastPid'];?>';
			break;
			case 'original-icon-cross':
				this.deleteRecord(record);
			break;
		}
	} // eo onRowAction
	,commitChanges:function() {
		var records = this.store.getModifiedRecords();
		if(!records.length) {
			return;
		}
		var data = [];
		Ext.each(records, function(r, i) {
			var o = r.getChanges();
			if(r.data.newRecord) {
				o.newRecord = true;
			}
			o[this.idName] = r.get(this.idName);
			data.push(o);
		}, this);
		var o = {
			 url:this.url
			,method:'post'
			,callback:this.requestCallback
			,scope:this
			,params:{
				 cmd:'saveDatax'
				,objName:this.objName
				,data:Ext.encode(data)
			}
		};
		Ext.Ajax.request(o);
	} // eo function commitChanges
	,requestCallback:function(options, success, response) {
		if(true !== success) {
			this.showError(response.responseText);
			return;
		}
		try {
			var o = Ext.decode(response.responseText);
		}
		catch(e) {
			this.showError(response.responseText, 'Cannot decode JSON object');
			return;
		}
		if(true !== o.success) {
			this.showError(o.error || 'Unknown error');
			return;
		}
		switch(options.params.cmd) {
			case 'saveDatax':
				var records = this.store.getModifiedRecords();
				Ext.each(records, function(r, i) {
					if(o.insertIds && o.insertIds[i]) {
						r.set(this.idName, o.insertIds[i]);
						delete(r.data.newRecord);
					}
				});
				this.store.each(function(r) {
					r.commit();
				});
				this.store.modified = [];
//				this.store.commitChanges();
			break;

			case 'deleteData':
			break;
		}
	} // eo function requestCallback
	,showError:function(msg, title) {
		Ext.Msg.show({
			 title:title || 'Error'
			,msg:Ext.util.Format.ellipsis(msg, 2000)
			,icon:Ext.Msg.ERROR
			,buttons:Ext.Msg.OK
			,minWidth:1200 > String(msg).length ? 360 : 600
		});
	} // eo function showError
	,deleteRecord:function(record) {
		Ext.Msg.show({
			 title:'<?=$access_labels['deleteTitle'][$lang];?>'
			,msg:'<?=$access_labels['deleteWarn1'][$lang];?>' + record.get('username') + '<?=$access_labels['deleteWarn2'][$lang];?>'
			,icon:Ext.Msg.QUESTION
			,buttons:Ext.Msg.YESNO
			,scope:this
			,fn:function(response) {
				if('yes' !== response) {
					return;
				}
				window.location.href = 'ldap/delete.php?id=' + record.get('username') + '&site=<?=$_GET['site'] . "&lang=$lang&lastPid=" . $_GET['lastPid'];?>';
			}
		});
	} // eo function deleteRecord
}); // eo extend

// register xtype
Ext.reg('examplegrid1', Example.Grid1);

// app entry point
Ext.onReady(function() {
	Ext.QuickTips.init();

	var page = new WebPage({
		version:Example.version
		,westContent:'west-content'
	});

	Ext.override(Ext.form.Field, {msgTarget:'side'});
	
	var win = new Ext.Window({
		 id:'rfwin'
        ,title:Ext.get('page-title').dom.innerHTML
		,iconCls:'original-icon-grid'
		,width:1000
		,height:700
		,x:21
		,y:130
		,plain:true
		,layout:'fit'
		,closable:false
		,draggable:false
//		,autoheight:true
		,border:false
		,applyTo: 'west-content'
		,maximizable:true
		,items:{xtype:'examplegrid1', id:'examplegrid1'}
		,plugins:[new Ext.ux.menu.IconMenu()]
	});
	win.show();

	var rf = new Ext.ux.grid.RecordForm({
		 formCt:'east-form'
		,autoShow:true
		,autoHide:false
		,ignoreFields:{compID:true,lastLogin:true}
		,layout: 'fit'
		,formConfig:{autoHeight:false,border:true, frame:false, margins:'10 10 10 10'}
	});

}); // end onReady