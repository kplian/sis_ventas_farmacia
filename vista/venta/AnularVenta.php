<?php
/**
*@package pXP
*@file gen-AnularVenta.php
*@author  (admin)
*@date 18-01-2019 14:57:46
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.AnularVenta=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.AnularVenta.superclass.constructor.call(this,config);
		
	    this.grid.getTopToolbar().disable();
		this.grid.getBottomToolbar().disable();
		this.init();
		this.addButton('anular_factura', {
            text: 'Anular Factura',
            iconCls: 'bupload',
            disabled: true,
            handler: this.BAnularFactura,
            tooltip: '<b>Anular Factura</b><br/>Anular una factura finalizada.'
        });
		//this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_venta'
			},
			type:'Field',
			form:true 
		},
		
		{
            //configuracion del componente
            config:{
                    labelSeparator:'',
                    inputType:'hidden',
                    name: 'id_proceso_wf'
            },
            type:'Field',
            form:true 
        },
        
        {
            //configuracion del componente
            config:{
                    labelSeparator:'',
                    inputType:'hidden',
                    name: 'id_estado_wf'
            },
            type:'Field',
            form:true 
        },
        {
            config:{
                name: 'correlativo_venta',
                fieldLabel: 'Nro',              
                gwidth: 110,
                renderer: function(value,c,r){  
                	
                	if (r.data.codigo_sin != '') {
                		return String.format('{0}', '<p><font color="blue">' + value + '</font></p>');
                	} else {
                		return value;
                	}  
                    
                }
            },
                type:'TextField',
                filters:{pfiltro:'ven.correlativo_venta',type:'string'},              
                grid:true,
                form:false,
                bottom_filter: true
        },        
        {
            config:{
                name: 'total_venta',
                fieldLabel: 'Total Venta',
                allowBlank: false,
                anchor: '80%',
                gwidth: 120,
                maxLength:5,
                disabled:true
            },
                type:'NumberField',
                filters:{pfiltro:'ven.total_venta',type:'numeric'},
                id_grupo:1,
                grid:true,
                form:false
        },
         {
            config:{
                name: 'comision',
                fieldLabel: 'Comision',              
                gwidth: 110
            },
                type:'TextField',
                grid:true,
                form:false
        },
		
		
        
        {
			config:{
				name: 'observaciones',
				fieldLabel: 'Observaciones',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100
			},
				type:'TextArea',
				filters:{pfiltro:'ven.observaciones',type:'string'},
				id_grupo:0,
				grid:true,
				form:false
		}
		,
        {
            config:{
                name: 'codigo_sin',
                fieldLabel: 'Codigo SIN',              
                gwidth: 110
               
            },
                type:'TextField',
                filters:{pfiltro:'ven.codigo_sin',type:'string'},              
                grid:true,
                form:true,
                bottom_filter: true
        }
        , {
			config : {
				name : 'id_motivo_anulacion',
				fieldLabel : 'Motivo Anulacion',
				allowBlank : false,
				emptyText : 'Motivo Anulacion...',
				store : new Ext.data.JsonStore({
					url : '../../sis_siat/control/MotivoAnulacion/listarMotivoAnulacion',
					id : 'id_motivo_anulacion',
					root : 'datos',
					sortInfo : {
						field : 'codigo',
						direction : 'ASC'
					},
					totalProperty : 'total',
					fields : ['id_motivo_anulacion', 'codigo', 'descripcion'],
					// turn on remote sorting
					remoteSort : true,
					baseParams : {
						par_filtro : 'codigo#descripcion'
					}
				}),
				valueField : 'id_motivo_anulacion',
				displayField : 'descripcion',
				gdisplayField : 'descripcion', //mapea al store del grid
				tpl : '<tpl for="."><div class="x-combo-list-item"><p>({codigo}) {descripcion}</p> </div></tpl>',
				hiddenName : 'id_motivo_anulacion',
				forceSelection : true,
				typeAhead : true,
				triggerAction : 'all',
				lazyRender : true,
				mode : 'remote',
				pageSize : 10,
				queryDelay : 1000,
				width : 250,
				gwidth : 150,
				minChars : 2,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['descripcion']);
				}
			},
			type : 'ComboBox',
			id_grupo : 0,
			filters : {
				pfiltro : 'descripcion',
				type : 'string'
			},

			grid : true,
			form : true
		}
		
        /*,
	     {
			config:{
				name: 'motivo_anulacion',
				fieldLabel: 'Motivo de Anulacion',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100
			},
				type:'TextArea',
				filters:{pfiltro:'ven.motivo_anulacion',type:'string'},
				id_grupo:0,
				grid:true,
				form:true
		}  */ 
	],
	tam_pag:50,	
	title:'AnularVenta ',
	ActSave:'../../sis_ventas_facturacion/control/Venta/insertarVentaAnular',
	ActDel:'../../sis_siat/control/AnularVenta/eliminarAnularVenta',
	ActList:'../../sis_ventas_facturacion/control/Venta/listarAnularVenta',
	id_store:'id_venta',
	fields: [
	   {name:'id_venta', type: 'numeric'},
	   {name:'id_cliente', type: 'numeric'},
       {name:'id_sucursal', type: 'numeric'},
       {name:'id_proceso_wf', type: 'numeric'},
       {name:'id_estado_wf', type: 'numeric'},
       {name:'estado_reg', type: 'string'},
       {name:'correlativo_venta', type: 'string'},
       {name:'a_cuenta', type: 'string'},
       {name:'total_venta', type: 'numeric'},
       {name:'fecha_estimada', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
       {name:'usuario_ai', type: 'string'},
       {name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
       {name:'id_usuario_reg', type: 'numeric'},
       {name:'id_usuario_ai', type: 'numeric'},
       {name:'id_usuario_mod', type: 'numeric'},
       {name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
       {name:'porcentaje_descuento', type: 'numeric'},
       {name:'id_vendedor_medico', type: 'numeric'},
       {name:'comision', type: 'numeric'},
       {name:'observaciones', type: 'string'},
       {name:'codigo_sin', type: 'string'},
       {name:'motivo_anulacion', type: 'string'}
	
	],
	sortInfo:{
		field: 'id_venta',
		direction: 'ASC'
	},
	bdel:false,
	bsave:false, 
	bnew:false,
	bedit:false,
	onReloadPage:function(param){
		//Se obtiene la gestión en función de la fecha del comprobante para filtrar partidas, cuentas, etc.
		var me = this;
		this.initFiltro(param);
	},
	initFiltro: function(param){
		this.store.baseParams=param;
		this.load( { params: { start:0, limit: this.tam_pag } });
	},
	onButtonNew: function () {
            
             this.ocultarComponente(this.Cmp.estado_reg);
             Phx.vista.AnularVenta.superclass.onButtonNew.call(this);
            },
    /*onButtonEdit: function () {
            
             //this.mostrarComponente(this.Cmp.estado_reg);
             Phx.vista.AnularVenta.superclass.onButtonEdit.call(this);
            }
	,*/
    BAnularFactura:function () {
			var rec = this.sm.getSelected();
			Phx.vista.AnularVenta.superclass.onButtonEdit.call(this);
			/*Phx.CP.loadingShow();
			Ext.Ajax.request({
				url: '../../sis_siat/control/AnularVenta/insertarAnularFactura',
				params: {
					estado: 'recibido'
				},
				success: this.successDerivar,
				failure: this.conexionFailure,
				timeout: this.timeout,
				scope: this
			});*/
	
		},
		
    /*
    preparaMenu:function(n){
      	
      	Phx.vista.AnularVenta.superclass.preparaMenu.call(this,n);      	
		  var data = this.getSelectedData();

		  var tb =this.tbar;
		  //si el archivo esta escaneado se permite visualizar

			this.getBoton('anular_factura').disable();

		if (data['codigo_sin'] != '') {

			this.getBoton('anular_factura').enable();
			
		}

       return tb
		
	},
	liberaMenu:function(){
        var tb = Phx.vista.AnularVenta.superclass.liberaMenu.call(this);
        if(tb){
           
           this.getBoton('anular_factura').disable();
			        
        }
       return tb
 },*/
		successDerivar : function(resp) {

			Phx.CP.loadingHide();
			var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
			if (!reg.ROOT.error) {
				alert(reg.ROOT.detalle.mensaje)

			}
			this.reload();

		}
	
		
})
</script>
		