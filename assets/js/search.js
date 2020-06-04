// Header: 'Access-Control-Allow-Origin: *';

jQuery(document).ready(function($) {
	var api_url = `https://news.google.com/search?q=`;
	var api_endpoint = `&amp;output=rss&hl=en-US&gl=US&ceid=US:en`;
	// var displayData = document.querySelector("");

	$('#api-search-form').submit(function(event){
		event.preventDefault()
		var form_data = {
			'query': $("#search-input").val(),
		};
		
		// $( '#display_info').(function( index, element ) {

			$.ajax({
				type: "POST",
				url: api_url + form_data.query + api_endpoint,
				contentType: 'text/plain',
				xhrFields: {
					withCredentials: false
				},
				headers: {
					"Access-Control-Allow-Origin":"*"
				},
				success: function(result){
					console.log(result);
				},
				error: function(xhr, status){
					console.log(xhr, status)
				}
			// })
		  });
		// // 	// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		// jQuery.post(ajaxurl, data, function(response) {
		//    alert('Got this from the server: ' + response);
		// });

		console.log(form_data.query);
	})



	// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
	// jQuery.post(ajaxurl, data, function(response) {
	// 	alert('Got this from the server: ' + response);
	// });
});
