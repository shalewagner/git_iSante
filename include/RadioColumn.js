Ext.grid.RadioColumn = function(config){
    Ext.apply(this, config);
    if(!this.id){
        this.id = Ext.id();
    }
    this.renderer = this.renderer.createDelegate(this);
};

Ext.grid.RadioColumn.prototype = {
    init : function(grid){
        this.grid = grid;
        this.grid.on('render', function(){
            var view = this.grid.getView();
            view.mainBody.on('mousedown', this.onMouseDown, this);
        }, this);
    },

    onMouseDown : function(e, t){
        if(t.className && t.className.indexOf('x-grid3-cc-'+this.id) != -1){
            e.stopEvent();
            var index = this.grid.getView().findRowIndex(t);
            var record = this.grid.store.getAt(index);
            record.set(this.dataIndex, this.inputValue);
        }
    },

    renderer : function(v, p, record){
        p.css += ' x-grid3-radio-col-td'; 
        return '<div class="x-grid3-radio-col'+(v == this.inputValue?'-on':'')+' x-grid3-cc-'+this.id+'"> </div>';
    }
};
