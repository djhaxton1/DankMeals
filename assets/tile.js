function drawTile(id, title, picture) {
	out = 	"<div class='col-md-4 portfolio-item'>" +
				"<div id='tile'>" +
					"<a href='recipePage.html?id=" + id + "'>" +
						"<img src='pics" + picture + "'>" +
					"</a>" +
				"</div>" +
				"<h3>" +
					"<a href='recipePage.html?id=" + id + "'>" +
						title +
					"</a>" +
				"</h3>" +
			"</div>";
			
	return out;
}