// vim: sw=4:ts=4:nu:nospell:fdc=4
/**
 * @class WebPage
 *
 * WebPage Layout Generator
 *
 * @author    Ing. Jozef Sakáloš
 * @copyright (c) 2008, by Ing. Jozef Sakáloš
 * @date      6. April 2008
 * @version   1.0
 * @revision  $Id: WebPage.js 530 2009-02-01 23:14:37Z jozo $
 *
 * @license WebPage.js is licensed under the terms of the Open Source
 * LGPL 3.0 license. Commercial use is permitted to the extent that the 
 * code/component(s) do NOT become part of another Open Source or Commercially
 * licensed development library or toolkit without explicit permission.
 *
 *<p>License details: <a href="http://www.gnu.org/licenses/lgpl.html"
 * target="_blank">http://www.gnu.org/licenses/lgpl.html</a></p>
 */
 
/*global Ext, WebPage */
 
Ext.ns('WebPage');
 
WebPage = function(config) {
	Ext.apply(this, config, {
		 autoRender:true
		,autoTitle:true
		,langCombo:false
		,ctCreate:{tag:'div', id:'ct-wrap', cn:[{tag:'div', id:'ct'}]}
	});

	if(this.autoRender) {
		this.render();
	}
};

Ext.override(WebPage, {
	 navlinks:[{
		 text:'Home'
		,href:'http://extjs.eu'
		,target:'_self'
	},{
		 text:'Blog'
		,href:'http://blog.extjs.eu'
		,target:'_self'
	},{
		 text:'Examples'
		,href:'http://examples.extjs.eu'
		,target:'_blank'
	},{
		 text:'ExtJS'
		,href:'http://www.extjs.com'
		,target:'_blank'
	},{
		 text:'Forum'
		,href:'http://www.extjs.com/forum'
		,target:'_blank'
	},{
		 text:'Learn'
		,href:'http://www.extjs.com/learn'
		,target:'_blank'
	},{
		 text:'Docs'
		,href:'http://www.extjs.com/deploy/dev/docs'
		,target:'_blank'
	},{
		 text:'UX-Docs'
		,href:'http://www.extjs.eu/docs'
		,target:'_blank'
	},{
		 text:'Samples'
		,href:'http://www.extjs.com/deploy/dev/examples'
		,target:'_blank'
	},{
		 text:'Profile'
		,href:'http://www.extjs.com/forum/member.php?u=2178'
		,target:'_blank'
	}]
	,navlinksTpl: new Ext.XTemplate(
		 '<ul>'
		+'<tpl for="navlinks">'
		+'<li><a href="{href}" target="{target}">{text}</a></li>'
		+'</tpl>'
		+'</ul><div class="cleaner"></div>'
	)
	,render:function() {
		var body = Ext.getBody();
		var dh = Ext.DomHelper;

		// create wrap and container
		this.wrap = dh.insertFirst(body, this.ctCreate, true);
		this.ct = Ext.get('ct');

		if(this.width) {
			this.ct.setWidth(this.width);
		}


		this.west = dh.append(this.ct, {tag:'div', id:'west'}, true);
		if(this.westWidth) {
			this.west.setWidth(this.westWidth);
		}


		if(this.westContent) {
			this.west.appendChild(this.westContent);
			this.westContent = Ext.get(this.westContent).removeClass('x-hidden');
		}

	} // eo function render
});
 
// eof
