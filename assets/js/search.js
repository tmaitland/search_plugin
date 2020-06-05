// Header: 'Access-Control-Allow-Origin: *';


jQuery(document).ready(function($) {
	
	let displayInfo = document.querySelector('#display_info');	
	let modal = document.querySelector('.modal');
	let modalBG = document.querySelector('.modal-bg');

	$('#api-search-form').submit(function(event){
		event.preventDefault()
		let x2js = new window.X2JS();
		var form_data = {
			'query': $("#search-input").val(),
		};
		displayInfo.innerHTML = '';
		$("#loader").show();
		
      axios({ method: 'get', url:`https://cors-anywhere.herokuapp.com/news.google.com/news?q=${form_data.query}&output=rss`,
      headers: { 'Access-Control-Allow-Origin': '*',  'Content-Type': 'application/json' } })
      .then(function (response) {
		// empty arrays to push RSS Feed data into
		let titles = [];
		let links = [];
		let pubDates = [];


		// Data response, XML -> JSON conversion
        let xml = response.data;
        console.log(response.data);
        let newJSONData = x2js.xml_str2json(xml);
		console.log(newJSONData.rss.channel.item);

		// For each empty array, push corresponding data in
		for(let i = 0; i < 25; i++){
			titles.push(newJSONData.rss.channel.item[i].title);
			links.push(newJSONData.rss.channel.item[i].link);
			pubDates.push(newJSONData.rss.channel.item[i].pubDate);
			
			//Display each link
			displayInfo.innerHTML += `
			<p class="rss-titles">
			  <a href=${links[i]} target="_blank" class="rss-links">${titles[i]}</a>
			  <small class="rss-dates">${pubDates[i]}</small>
			</p>
			`;
		}

		  
		$(displayInfo).ready(function (){
			$(modal).addClass("visible");
			$(modalBG).addClass("visible");
			$("#loader").hide();
		})
		//Show the modal and modal background when data loads and populates container

		//Hide the modal only when the modal background is clicked
		$(modalBG).click(function(e){
			if($(e.target).closest('.modal').length === 0){
				$(modalBG).removeClass("visible");
			}
		})
		
      })
      .catch(function (error) {
        // handle error
        console.log(error);
      })
      .finally(function () {
        // always executed
      });

	})

});
