function drawTile(id, title, picture) {
	out = 	"<div class='col-md-4 portfolio-item'>" +
				"<div id='tile'>" +
					"<a href='recipePage.html?id=" + id + "'>" +
						"<img src='pics" + picture + "'>" +
						"<div id='tile-title'><p>" + title + "</p></div>" +
					"</a>" +
				"</div>" +
			"</div>";
			
	return out;
}