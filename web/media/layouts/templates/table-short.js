var TableShort = function() {

	var initConfirmation = function(){
		
		$('.confirmation-delete').confirmation(
        {
            container: 'body', 
            btnOkClass: 'btn btn-sm btn-success', 
            btnOkLabel: 'Delete ',
            btnCancelClass: 'btn btn-sm btn-danger', 

            onConfirm: function()
            {
            	var id = $(this)[0].id;
                var url = $(this)[0].url;
                var message = $(this)[0].message;
                var error_message = $(this)[0].errormessage;
          
                $.post(url, {}, 
                    function(data){
                        

                        if(data.result == 'success'){
                            $('#row' + id).fadeOut();
                            $('#row' + id).remove();
                            toastr.success(message);

                        } else {
                            toastr.error(data.message + ' ' + data.data.error_description);
                        }
                     
                    }, 'json'
                );  
            }
        });
		
	}
	
	var initDataTable = function (){
		
		var table = $('#dataTableUsers').DataTable({
            responsive: true,
            lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],

        }); 

        $(".export").on('click', function (event) {
	        // CSV
	        $(this)
	            .attr({
	                'download': 'Records.csv',
	                'href': ex(),
	                'target': '_blank'
	        });
	    });	
	}

	var ex = function(){
		var csv=$('#dataTableUsers').table2CSV({delivery:'value'});
        // Data URI
        csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);
        
        return csvData;
	}
	
	
	 
	 return {

        init: function () {
            //table short handlers
			initConfirmation();
			initDataTable();
        }, 
		save: function(id, index_url, callback){
			
			$form = $(id);
			$url = $form.attr('action');

			$.post($url, $form.serialize(), 
				function(data){
					

					if(data.result == 'success'){
						
						if(callback){
							callback();
						} else {
							toastr.success('Details successfully saved.');
							setTimeout( function(){document.location = index_url;}, 3000 );
						}
					   
					   

					} else {
						toastr.error(data.message + '<br>' + data.data.error_description );
					}

					return false;
				 
				}, 'json'
			);
		}
    };
	

}