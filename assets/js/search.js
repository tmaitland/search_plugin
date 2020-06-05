// Header: 'Access-Control-Allow-Origin: *';


jQuery(document).ready(function($) {
	
	let displayInfo = document.querySelector('#display_info');	
	let modal = document.querySelector('.modal');
	let modalBG = document.querySelector('.modal-bg');

	$('#api-search-form').submit(function(event){
		event.preventDefault()
		
		var form_data = {
			'query': $("#search-input").val(),
		};
		let x2js = new window.X2JS();
		displayInfo.innerHTML = '';
      axios({ method: 'get', url:`https://cors-anywhere.herokuapp.com/news.google.com/news?q=${form_data.query}&output=rss`,
      headers: { 'Access-Control-Allow-Origin': '*',  'Content-Type': 'application/json' } })
      .then(function (response) {
		let titles = [];
		let links = [];
		let pubDates = [];

        let xml = response.data;
        console.log(response.data);
        let newJSONData = x2js.xml_str2json(xml);
		console.log(newJSONData.rss.channel.item);

		
		for(let i = 0; i < 10; i++){
			titles.push(newJSONData.rss.channel.item[i].title);
			links.push(newJSONData.rss.channel.item[i].link);
			pubDates.push(newJSONData.rss.channel.item[i].pubDate);
			
			displayInfo.innerHTML += `
			<p class="rss-titles">
			  <a href=${links[i]} target="_blank" class="rss-links">${titles[i]}</a>
			  <small class="rss-dates">${pubDates[i]}</small>
			</p>
			`;

		}

		$(modal).show();
		$(modalBG).click( function() {
			$(modalBG).hide();
		});
		
		
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
