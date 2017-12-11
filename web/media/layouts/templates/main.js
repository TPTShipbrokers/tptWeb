var Main = function() {




	var ex = function(){
		var csv=$('#dataTableUsers').table2CSV({delivery:'value'});
        // Data URI
        csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);
        
        return csvData;
	}
	
};



 Main.initTooltip = function(){
		$('[data-toggle="tooltip"]').tooltip();
	};

Main.initDatatable = function (id){
		
	var table = $(id).DataTable({
        responsive: true,
        lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
        errMode: "none",
 

    }); 

    $(id).on( 'draw.dt', function () {
        Main.initConfirmation('.confirmation-delete');
    });

};

Main.initExport = function(id, name, tableId){
	$(id).on('click', function (event) {
        // CSV
        $(this)
            .attr({
                'download': name + '.csv',
                'href': ex(),
                'target': '_blank'
        });
    });	

    function ex(){
        var csv=$(tableId).table2CSV({delivery:'value'});
        // Data URI
        csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);
        
        return csvData;
    }
};

Main.initConfirmation = function(id, callback, data){

		
	$(id).confirmation({
        container: 'body', 
        btnOkClass: 'btn btn-sm btn-success', 
        btnOkLabel: 'Delete ',
        btnCancelClass: 'btn btn-sm btn-danger', 

        onConfirm: function()
        {

        	var id = $(this)[0].id;
        	var prefix = $(this)[0].idprefix;
            var url = $(this)[0].url;
            var message = $(this)[0].message;
            var error_message = $(this)[0].errormessage;
            var obj = data?data:{};
            var row_id = prefix?prefix + id:"#row" + id;
      
            $.post(url, obj, 
                function(data){
                    

                    if(data.result == 'success'){
                        
                        if(callback)
                        	callback(data);
                        else
                        {
                        	$(row_id).fadeOut();
	                        $(row_id).remove();
	                        toastr.success(message);
                        }


                    } else {
                        toastr.error(data.message + ' ' + data.data.error_description);
                    }

                     
                 
                }, 'json'
            );  
        }
    });
	
};

Main.save = function(id, index_url, callback, data){
			
	$form = $(id);
	$url = $form.attr('action');

    if(data){
        $data = data;
    } else {
        $data = $form.serialize();
    }

	$.post($url, $data, 
		function(data){
			

			if(data.result == 'success'){
               
				if(callback){
					callback(data);
				} else {
					toastr.success('Details successfully saved.');
					setTimeout( function(){document.location = index_url;}, 3000 );
					return false;
				}
			   
			} else {
				toastr.error(data.data.error_description );
			}

			return false;
		 
		}, 'json'
	);
};

Main.initTypeahead = function(id, values, target_id){

	var adapter = new Bloodhound({
      	datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.num); },
	    queryTokenizer: Bloodhound.tokenizers.whitespace,
	    local: values
    });

    adapter.initialize();

    $(id).typeahead(null, {
      	displayKey: 'num',
      	hint: (App.isRTL() ? false : true),
      	source: adapter.ttAdapter()
    });

    if(target_id){
    	 $(id).bind('typeahead:select', function(ev, suggestion) {
	      	$(target_id).val(suggestion.id);
	    });
    }
   


};

Main.initDatetimePicker = function(id){

    $( id ).each(function( index ) {
      $( this ).datetimepicker({
          sideBySide: true,
          showTodayButton: true,
            format: 'YYYY-MM-DD HH:mm'
        });
    });
}

Main.init =  function () {
    
	Main.initTooltip();
};