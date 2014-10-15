<!DOCTYPE html>
<html>
<head>
    <title>信息校验</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="stylesheet" type="text/css" href="/css/jquery-ui-1.10.2.custom.css" />
    <link rel="stylesheet" type="text/css" href="/css/ui.jqgrid.css" />
    <style type="text/css">
		body{
			margin:0 auto
		}
	</style>
</head>
<body>
	<nav>
	    <h1>信息校验</h1>
	</nav>
    <div>
    <label>输入相似度范围</label>
    	<input type="text" value="60" name="start" style="width:30px">
    	<input type="text" value="70" name="end" style="width:30px" />
    	<input type="button" value="查找" name="searchBtn"/>
    	
        <table id="list"></table>
        <a href="javascript:void(0)" id="ms1">批量置为正常</a>
    	<a href="javascript:void(0)" id="ms2">批量置为无效</a>
    </div>
    
<div id="gridpager"></div>
   	<script type="text/javascript" src="/js/jquery-1.8.2.min.js"></script>	
    <script type="text/javascript" src="/js/i18n/grid.locale-cn.js"></script>
    <script type="text/javascript" src="/js/jquery.jqGrid.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui-1.10.2.custom.min.js"></script>
    
    <script type="text/javascript">
    //<![CDATA[    
    var lastsel;
    var selectItem = new Array();
    var start = 60,end = 70;
    var url = 'product_list.php?start='+start+'&end='+end;
    jQuery('input[name="searchBtn"]').bind("click",function(){
    		var start = jQuery('input[name="start"]').val();
			var end = jQuery('input[name="end"]').val();
			var url = 'product_list.php?start='+start+'&end='+end;
			jQuery('#list').jqGrid('setGridParam',{url:url}).trigger("reloadGrid");
        });
    $('#list').jqGrid({
        url:url,
        datatype: 'json',
        colNames: ['条码','名称','规格','匹配商品名称','参考商品链接','匹配网店','匹配度','可用类别'],
        colModel: [
            { name: '条码', index:'条码',width:95,sortable:true,editable:false,endoptions:{readonly:true,size:10}},
            { name: '货品名称', index:'货品名称',width:200, sortable:true, editable:false,endoptions:{size:10}},
            { name: '规格', index:'规格',width:75, sortable:true, editable:false,endoptions:{size:10}},
            { name: 'simi_content', index:'simi_content', sortable:false,width:300},
            { name: 'src', index:'src',width:70, sortable:false, width:80,align:'center',formatter:DIYFmatter},
            { name: 'mallName', index:'mallName',width:70, sortable:true, editable:false,endoptions:{size:10}},
            { name: 'similarity', index:'similarity',width:50, sortable:true, editable:false,endoptions:{size:10}},
            { name: 'handle_state', index:'handle_state',width:55, sortable:true,hidden:true,edittype:"select",editoptions:{value:"1:正常;2:丢弃"},editable:true}
        ],
        height:"100%",
        rowNum:30,
        pager:'#gridpager',
        sortname:'similarity',
        cellEdit:false,
        multiselect:false,
        viewrecords:true,
        sortorder:'desc',
        multiselect:true,
        caption:" 信息校验",
        editurl:'product_edit.php?param='+selectItem,
    });

    jQuery("#ms1").click(function(){
	        var	selectItem  = jQuery("#list").jqGrid('getGridParam','selarrrow');
	        var status = 1;
	        if(selectItem.length==0||selectItem==""){
					alert("请选择");
		        }else{
					var r = confirm("确定置为正常数据吗？");
					if(r == true){
						$.ajax({
							  url: "product_edit.php",
							  data: {
								  param:selectItem,
								  status:status
							  },
							  success:function(data){
								  	var start = jQuery('input[name="start"]').val();
									var end = jQuery('input[name="end"]').val();
									var url = 'product_list.php?start='+start+'&end='+end;
									jQuery('#list').jqGrid('setGridParam',{url:url}).trigger("reloadGrid");
									}
							});
						}else{
							return;
						}
			    }
        });
    jQuery("#ms2").click(function(){
		var selectItem  = jQuery("#list").jqGrid('getGridParam','selarrrow');
		var status = 2;
		 if(selectItem.length==0||selectItem==""){
				alert("请选择");
	        }else{
				var r = confirm("确定置为无效数据吗？");
				if(r == true){
					$.ajax({
						  url: "product_edit.php",
						  data: {
							  param:selectItem,
							  status:status
						  },
						  success:function(data){
							  	var start = jQuery('input[name="start"]').val();
								var end = jQuery('input[name="end"]').val();
								var url = 'product_list.php?start='+start+'&end='+end;									
								jQuery('#list').jqGrid('setGridParam',{url:url}).trigger("reloadGrid");
								}
						});
					}else{
						return;
					}
		    }
    });
	jQuery.jgrid.useJSON=true;
    jQuery("#list").jqGrid('navGrid','#gridpager',{edit:false,add:false,del:false});
    function DIYFmatter(cellvalue,options,rowObject){
		return '<a target="_blank" href="'+cellvalue+'">参考商品链接</a>';
        }

	//]]>
	</script>
</body>
</html>
